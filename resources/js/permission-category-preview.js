export default function permissionCategoryPreview() {
    const actions = ['View', 'Create', 'Edit', 'Delete', 'Manage'];
    const pages = [
        ['faculties', 'Faculties'],
        ['departments', 'Departments'],
        ['programs', 'Programs'],
        ['batches', 'Batches & Sections'],
        ['courses', 'Courses'],
        ['sessions', 'Academic Sessions'],
        ['buildings', 'Buildings'],
        ['rooms', 'Rooms'],
        ['campuses', 'Campuses'],
    ].map(([key, label]) => ({
        key, label,
        permissions: actions.map(action => ({
            key: `${action.toLowerCase()}.${key}`,
            action,
            label: `${action} ${label}`,
        })),
    }));
    const allKeys = pages.flatMap(page => page.permissions.map(permission => permission.key));
    const unselected = new Set(['delete.departments', 'delete.courses', 'delete.rooms', 'manage.sessions']);

    return {
        pages,
        editing: false,
        search: '',
        selectedKeys: allKeys.filter(key => !unselected.has(key)),
        get totalCount() { return allKeys.length; },
        get activeCount() { return this.selectedKeys.length; },
        get allSelected() { return this.activeCount === this.totalCount; },
        get visiblePages() {
            const query = this.search.trim().toLocaleLowerCase();
            return this.pages.map(page => ({
                ...page,
                permissions: page.permissions.filter(permission => !query
                    || `${page.label} ${page.key}`.toLocaleLowerCase().includes(query)
                    || `${permission.label} ${permission.key}`.toLocaleLowerCase().includes(query)),
            })).filter(page => page.permissions.length);
        },
        isSelected(key) { return this.selectedKeys.includes(key); },
        pagePermissions(page) { return this.pages.find(item => item.key === page.key).permissions; },
        pageCount(page) { return this.pagePermissions(page).filter(permission => this.isSelected(permission.key)).length; },
        pageAllSelected(page) { return this.pageCount(page) === this.pagePermissions(page).length; },
        toggleAll(checked) {
            if (this.editing) this.selectedKeys = checked ? [...allKeys] : [];
        },
        togglePage(page, checked) {
            if (!this.editing) return;
            const selected = new Set(this.selectedKeys);
            this.pagePermissions(page).forEach(permission => checked ? selected.add(permission.key) : selected.delete(permission.key));
            this.selectedKeys = [...selected];
        },
        togglePermission(key, checked) {
            if (!this.editing || !allKeys.includes(key)) return;
            const selected = new Set(this.selectedKeys);
            checked ? selected.add(key) : selected.delete(key);
            this.selectedKeys = [...selected];
        },
    };
}
