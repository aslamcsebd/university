const uniqueKeys = (keys) => [...new Set((Array.isArray(keys) ? keys : []).map(String))];
const normalizedName = (name) => String(name ?? '').trim().replace(/\s+/g, ' ');
const comparisonName = (name) => normalizedName(name).normalize('NFKC').toLocaleLowerCase();
const compactPermissionLabel = (module, permission, page = module) => {
    const label = normalizedName(permission.label || permission.action || permission.key);
    const action = normalizedName(permission.action);
    const category = normalizedName(module.label);
    return action && [category, normalizedName(page.label)].some(name => name
        && comparisonName(label) === comparisonName(`${action} ${name}`))
        ? action : label;
};

export default function rolesWorkspace(roles = [], modules = [], allowedKeys = [], canCreate = false, initialRoleId = null, endpoints = {}) {
    const roleList = roles.map((role) => ({
        ...role,
        id: String(role.id),
        permissions: uniqueKeys(role.permissions),
    }));
    const moduleList = modules.map((module) => {
        const pages = (module.pages ?? [{ id: `general-${module.id}`, key: 'general', label: 'General permissions', permissions: module.permissions ?? [] }])
            .map(page => ({
                ...page,
                permissions: page.permissions.map(permission => ({ ...permission, displayLabel: compactPermissionLabel(module, permission, page) })),
            }));
        return { ...module, pages, permissions: pages.flatMap(page => page.permissions) };
    });
    const allKeys = uniqueKeys(moduleList.flatMap((module) => module.permissions.map((permission) => permission.key)));
    const ownId = 'my-permissions';
    const originalSelections = Object.fromEntries(roleList.map((role) => [
        role.id,
        role.is_super ? [...allKeys] : [...role.permissions],
    ]));
    originalSelections[ownId] = [...allKeys];
    const firstRole = roleList.find((role) => role.id === String(initialRoleId)) ?? roleList[0] ?? null;

    return {
        roles: roleList,
        modules: moduleList,
        allowedKeys: uniqueKeys(allowedKeys),
        canCreate: Boolean(canCreate),
        roleSearch: '',
        permissionSearch: '',
        isEditing: false,
        createModalOpen: false,
        newRoleName: '',
        createError: '',
        selectedId: firstRole?.id ?? ownId,
        selectedPermissions: firstRole ? [...originalSelections[firstRole.id]] : [...allKeys],
        endpoints,
        isCreating: false,
        isSaving: false,
        feedback: '',
        feedbackType: 'success',
        _allKeys: allKeys,
        _ownId: ownId,
        _originalSelections: originalSelections,
        _draftSelections: Object.fromEntries(Object.entries(originalSelections).map(([id, keys]) => [id, [...keys]])),

        get selectedRole() {
            if (this.selectedId === this._ownId) {
                return { id: this._ownId, label: 'My permissions', permissions: [...this._allKeys], editable: false, is_self: true };
            }
            return this.roles.find((role) => role.id === String(this.selectedId)) ?? null;
        },

        get displayedPermissionKeys() {
            return this.selectedRole?.is_self ? this._allKeys : this._allKeys.filter(key => this.allowedKeys.includes(key));
        },

        get filteredRoles() {
            const query = comparisonName(this.roleSearch);
            return this.roles.filter((role) => !query || comparisonName(`${role.label} ${role.key}`).includes(query));
        },

        get visibleModules() {
            const query = comparisonName(this.permissionSearch);
            const displayed = new Set(this.displayedPermissionKeys);
            return this.modules.map((module) => {
                const moduleMatches = comparisonName(`${module.label} ${module.key}`).includes(query);
                const pages = module.pages.map(page => {
                    const pageMatches = comparisonName(`${page.label} ${page.key}`).includes(query);
                    return { ...page, permissions: page.permissions.filter(permission => displayed.has(permission.key)
                        && (!query || moduleMatches || pageMatches
                            || comparisonName(`${permission.label} ${permission.key} ${permission.action}`).includes(query))) };
                }).filter(page => page.permissions.length > 0);
                return { ...module, pages, permissions: pages.flatMap(page => page.permissions) };
            }).filter((module) => module.permissions.length > 0);
        },

        get totalPermissions() {
            return this.displayedPermissionKeys.length;
        },

        get selectedCount() {
            const selected = new Set(this.selectedPermissions);
            return this.displayedPermissionKeys.filter((key) => selected.has(key)).length;
        },

        get activePermissionCount() {
            const selected = new Set(this.isEditing ? this.selectedPermissions : this._originalSelections[this.selectedId] ?? []);
            return this.displayedPermissionKeys.filter((key) => selected.has(key)).length;
        },

        get allPermissionsSelected() {
            return this.totalPermissions > 0 && this.activePermissionCount === this.totalPermissions;
        },

        get visiblePermissionCount() {
            return uniqueKeys(this.visibleModules.flatMap((module) => module.permissions.map((permission) => permission.key))).length;
        },

        get isReadOnly() {
            const role = this.selectedRole;
            return !role || role.is_super || !role.editable;
        },

        get isBusy() {
            return this.isCreating || this.isSaving;
        },

        get hasChanges() {
            if (!this.selectedRole) return false;
            const original = new Set(this._originalSelections[this.selectedId] ?? []);
            const current = new Set(this.selectedPermissions);
            return original.size !== current.size || [...original].some((key) => !current.has(key));
        },

        _storeSelection() {
            if (this.selectedId === null) return;
            this._draftSelections[this.selectedId] = [...this.selectedPermissions];
        },

        _setSelection(keys) {
            this.selectedPermissions = uniqueKeys(keys);
            this._storeSelection();
        },

        selectRole(id) {
            if (this.isBusy) return;
            const roleId = String(id);
            const role = this.roles.find((item) => item.id === roleId);
            if (!role) return;
            this._storeSelection();
            this.selectedId = roleId;
            this.selectedPermissions = role.is_super ? [...this._allKeys] : [...(this._draftSelections[roleId] ?? role.permissions)];
            this.permissionSearch = '';
            this.isEditing = false;
            this.createError = '';
            this.feedback = '';
        },

        showOwnPermissions() {
            if (this.isBusy) return;
            this._storeSelection();
            this.selectedId = this._ownId;
            this.selectedPermissions = [...this._allKeys];
            this.permissionSearch = '';
            this.isEditing = false;
            this.feedback = '';
        },

        openCreateModal() {
            if (!this.canCreate || this.isBusy) return;
            this.newRoleName = '';
            this.createError = '';
            this.createModalOpen = true;
            this.$nextTick?.(() => this.$refs?.newRoleInput?.focus());
        },

        closeCreateModal() {
            if (this.isCreating) return;
            this.createModalOpen = false;
            this.$nextTick?.(() => this.$refs?.createRoleButton?.focus());
        },

        beginEditing() {
            if (this.isBusy || this.isReadOnly) return;
            this.isEditing = true;
            this.feedback = '';
        },

        cancelEditing() {
            if (this.isBusy) return;
            this.resetSelection();
            this.isEditing = false;
            this.feedback = '';
        },

        isEnabled(key) {
            return (this._originalSelections[this.selectedId] ?? []).includes(key);
        },

        async startNewRole() {
            if (this.isBusy) return false;
            this.createError = '';
            if (!this.canCreate) {
                this.createError = 'You do not have permission to create roles.';
                return false;
            }
            const label = normalizedName(this.newRoleName);
            if (!label) {
                this.createError = 'Enter a role name to get started.';
                return false;
            }
            const availableRoles = this.roles;
            let key = label.normalize('NFKD').replace(/\p{M}/gu, '').toLowerCase()
                .replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
            if (key && !/^[a-z]/.test(key)) key = `role_${key}`;
            if (!key) {
                key = 'custom_role';
                let suffix = 2;
                while (availableRoles.some((role) => comparisonName(role.key) === key)) key = `custom_role_${suffix++}`;
            }
            key = key.slice(0, 100).replace(/_+$/g, '');
            const duplicate = availableRoles.some((role) => comparisonName(role.label) === comparisonName(label)
                || comparisonName(role.key) === comparisonName(label) || comparisonName(role.key) === key);
            if (duplicate) {
                this.createError = 'A role with this name already exists. Choose a different name.';
                return false;
            }
            this.isCreating = true;
            this.feedback = '';
            try {
                const response = await window.axios.post(this.endpoints.storeUrl, {
                    name: key, label, permissions: [],
                }, { headers: this._requestHeaders() });
                this._applyServerResult(response.data);
                this.roleSearch = '';
                this.permissionSearch = '';
                    this.isEditing = false;
                this.createModalOpen = false;
                this.newRoleName = '';
                this.feedback = '';
                return true;
            } catch (error) {
                this.createError = this._errorMessage(error, 'Unable to create the role. Please try again.');
                return false;
            } finally {
                this.isCreating = false;
            }
        },

        async savePermissions() {
            if (!this.isEditing || this.isBusy || this.isReadOnly) return false;
            if (!this.hasChanges) {
                this.isEditing = false;
                this.feedback = '';
                return true;
            }
            const role = this.selectedRole;
            const permissions = [...this.selectedPermissions];
            this.isSaving = true;
            this.feedback = '';
            try {
                const response = await window.axios.put(role.update_url, {
                    name: role.key, label: role.label, description: role.description,
                    permissions,
                }, { headers: this._requestHeaders() });
                this._applyServerResult(response.data);
                this.isEditing = false;
                this.feedback = '';
                return true;
            } catch (error) {
                this.feedback = this._errorMessage(error, 'Unable to save permissions. Your changes are still here.');
                this.feedbackType = 'error';
                return false;
            } finally {
                this.isSaving = false;
            }
        },

        _applyServerResult(result) {
            const role = { ...result.role, id: String(result.role.id), permissions: uniqueKeys(result.role.permissions) };
            this._storeSelection();
            const existing = this.roles.findIndex((item) => item.id === role.id);
            if (existing === -1) this.roles.push(role);
            else this.roles.splice(existing, 1, role);
            const priority = (item) => item.is_super ? 0 : item.key === 'admin' ? 1 : 2;
            this.roles.sort((a, b) => priority(a) - priority(b) || a.label.localeCompare(b.label));
            const savedKeys = role.is_super ? [...this._allKeys] : [...role.permissions];
            this._originalSelections[role.id] = [...savedKeys];
            this._draftSelections[role.id] = [...savedKeys];
            this.selectedId = role.id;
            this.selectedPermissions = [...savedKeys];
            if (Array.isArray(result.allowed_keys)) this.allowedKeys = uniqueKeys(result.allowed_keys);
            if (typeof result.can_create === 'boolean') this.canCreate = result.can_create;
        },

        _requestHeaders() {
            const headers = { Accept: 'application/json' };
            const csrf = globalThis.document?.querySelector('meta[name="csrf-token"]')?.content;
            if (csrf) headers['X-CSRF-TOKEN'] = csrf;
            return headers;
        },

        _errorMessage(error, fallback) {
            const status = error.response?.status;
            if (status === 401 || status === 419) return 'Your session has expired. Refresh the page and try again.';
            if (status >= 500) return fallback;
            const errors = error.response?.data?.errors;
            if (errors) return Object.values(errors).flat()[0] ?? fallback;
            return error.response?.data?.message ?? fallback;
        },

        roleInitials(role) {
            return normalizedName(role.label).split(' ').slice(0, 2)
                .map((word) => Array.from(word)[0]).join('').toUpperCase();
        },

        rolePermissionCount(role) {
            const keys = this._allKeys.filter(key => this.allowedKeys.includes(key));
            return role.is_super ? keys.length : role.permissions.filter(key => keys.includes(key)).length;
        },

        isSelected(key) {
            return this.selectedPermissions.includes(key);
        },

        canToggle(key) {
            return this.isEditing && !this.isBusy && !this.isReadOnly && this.allowedKeys.includes(key) && this._allKeys.includes(key);
        },

        togglePermission(key) {
            if (!this.canToggle(key)) return;
            this._setSelection(this.isSelected(key)
                ? this.selectedPermissions.filter((item) => item !== key)
                : [...this.selectedPermissions, key]);
        },

        modulePermissionKeys(module) {
            const category = this.modules.find((item) => String(item.id) === String(module.id)) ?? module;
            const displayed = new Set(this.displayedPermissionKeys);
            return uniqueKeys(category.permissions.map((permission) => permission.key)).filter(key => displayed.has(key));
        },

        modulePermissionCount(module) {
            return this.modulePermissionKeys(module).length;
        },

        moduleSelectedCount(module) {
            return this.modulePermissionKeys(module).filter((key) => this.isEditing ? this.isSelected(key) : this.isEnabled(key)).length;
        },

        moduleAllSelected(module) {
            const keys = this.modulePermissionKeys(module);
            return keys.length > 0 && this.moduleSelectedCount(module) === keys.length;
        },

        toggleModule(module) {
            const keys = this.modulePermissionKeys(module).filter((key) => this.canToggle(key));
            if (!keys.length) return;
            const shouldSelect = !this.moduleAllSelected(module);
            this._setSelection(shouldSelect
                ? [...this.selectedPermissions, ...keys]
                : this.selectedPermissions.filter((key) => !keys.includes(key)));
        },

        pagePermissionKeys(module, page) {
            const category = this.modules.find(item => String(item.id) === String(module.id));
            const fullPage = category?.pages.find(item => String(item.id) === String(page.id)) ?? page;
            const displayed = new Set(this.displayedPermissionKeys);
            return uniqueKeys(fullPage.permissions.map(permission => permission.key)).filter(key => displayed.has(key));
        },

        pageSelectedCount(module, page) {
            return this.pagePermissionKeys(module, page).filter(key => this.isEditing ? this.isSelected(key) : this.isEnabled(key)).length;
        },

        pageAllSelected(module, page) {
            const keys = this.pagePermissionKeys(module, page);
            return keys.length > 0 && this.pageSelectedCount(module, page) === keys.length;
        },

        togglePage(module, page, checked) {
            const keys = this.pagePermissionKeys(module, page).filter(key => this.canToggle(key));
            if (!keys.length) return;
            this._setSelection(checked ? [...this.selectedPermissions, ...keys]
                : this.selectedPermissions.filter(key => !keys.includes(key)));
        },

        selectAll() {
            this._setSelection([...this.selectedPermissions, ...this._allKeys.filter((key) => this.canToggle(key))]);
        },

        toggleAllPermissions(checked) {
            if (checked) this.selectAll();
            else this.clearSelection();
        },

        clearSelection() {
            this._setSelection(this.selectedPermissions.filter((key) => !this.canToggle(key)));
        },

        resetSelection() {
            if (this.isBusy || this.isReadOnly) return;
            this._setSelection(this._originalSelections[this.selectedId] ?? []);
            this.feedback = '';
        },
    };
}
