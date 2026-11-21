@push('styles')
    <style>
        .rw-preview-note { margin: 0; flex-shrink: 0; padding: 8px 14px; border-bottom: 1px solid var(--rw-border); color: #64748b; font-size: 11px; }
        .dark .rw-preview-note { color: #94a3b8; }
    </style>
@endpush

<div class="rw-card" x-data="permissionCategoryPreview()">
    <div class="rw-card-header">
        <div class="rw-title-with-role">
            <h2>Permissions</h2>
            <span class="rw-role-badge">Design preview</span>
        </div>
        <div class="rw-search-wrap rw-header-search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
            <input class="rw-input" type="search" placeholder="Search pages or permissions" aria-label="Search preview pages or permissions" x-model="search">
        </div>
        <label class="rw-select-all" for="rw-preview-select-all" x-show="editing" x-cloak>
            <input id="rw-preview-select-all" class="rw-checkbox" type="checkbox" :checked="allSelected" @change="toggleAll($event.target.checked)" aria-controls="rw-preview-academic-pages">
            <span>Select all</span>
        </label>
        <div class="rw-header-actions">
            <span class="rw-active-count" x-text="activeCount + '/' + totalCount" aria-label="Selected sample permissions out of all sample permissions"></span>
            <button type="button" class="rw-edit-button" @click="editing = !editing" :aria-label="editing ? 'Finish preview editing' : 'Edit sample permissions'">
                <svg x-show="!editing" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m16 3 5 5-12 12-6 1 1-6L16 3Z"/></svg>
                <svg x-show="editing" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                <span x-text="editing ? 'Done' : 'Edit'">Edit</span>
            </button>
        </div>
    </div>
    <p class="rw-preview-note">9 pages · 45 sample permissions · Preview changes are not saved.</p>
    <div class="rw-modules">
        <fieldset class="rw-module">
            <legend class="sr-only">Academic</legend>
            <div class="rw-module-heading">
                <span class="rw-module-title">
                    <template x-if="editing"><input id="rw-preview-category-academic" class="rw-checkbox" type="checkbox" :checked="allSelected" @change="toggleAll($event.target.checked)" data-parent-id="rw-preview-select-all" aria-controls="rw-preview-academic-pages" aria-label="Select all Academic sample permissions"></template>
                    <label class="rw-category-name" for="rw-preview-category-academic">Academic</label>
                </span>
                <span class="rw-module-count" x-text="activeCount + '/' + totalCount"></span>
            </div>
            <div id="rw-preview-academic-pages" class="rw-child-pages rw-preview-pages">
                <template x-for="page in visiblePages" :key="page.key">
                    <fieldset class="rw-child-page rw-preview-page" :data-page-key="page.key">
                        <legend class="sr-only" x-text="page.label"></legend>
                        <div class="rw-child-page-heading">
                            <template x-if="editing"><input class="rw-checkbox" type="checkbox" :id="'rw-preview-page-' + page.key" :checked="pageAllSelected(page)" @change="togglePage(page, $event.target.checked)" data-parent-id="rw-preview-category-academic" :aria-controls="'rw-preview-actions-' + page.key" :aria-label="'Select all sample permissions for ' + page.label"></template>
                            <label class="rw-child-page-name rw-preview-page-name" :for="'rw-preview-page-' + page.key" x-text="page.label"></label>
                            <span class="rw-module-count" x-text="pageCount(page) + '/' + pagePermissions(page).length"></span>
                        </div>
                        <div class="rw-permission-grid" :id="'rw-preview-actions-' + page.key">
                            <template x-for="permission in page.permissions" :key="permission.key">
                                <label class="rw-permission" :for="'rw-preview-permission-' + permission.key" :title="permission.label" :class="{ 'is-editable': editing, 'is-disabled': !editing && !isSelected(permission.key), 'is-checked': editing && isSelected(permission.key) }">
                                    <template x-if="editing"><input class="rw-checkbox" type="checkbox" :id="'rw-preview-permission-' + permission.key" :data-parent-id="'rw-preview-page-' + page.key" :checked="isSelected(permission.key)" @change="togglePermission(permission.key, $event.target.checked)" :aria-label="permission.label"></template>
                                    <span class="rw-permission-bullet" x-show="!editing" :class="{ 'is-disabled': !isSelected(permission.key) }" aria-hidden="true"></span>
                                    <span class="rw-permission-name"><span x-text="permission.action"></span></span>
                                </label>
                            </template>
                        </div>
                    </fieldset>
                </template>
            </div>
            <p class="rw-preview-note" x-show="visiblePages.length === 0" x-cloak>No matching pages or permissions.</p>
        </fieldset>
    </div>
</div>
