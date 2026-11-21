import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import rolesWorkspace from './roles-workspace';
import permissionCategoryPreview from './permission-category-preview';

Alpine.plugin(collapse);
Alpine.data('rolesWorkspace', rolesWorkspace);
Alpine.data('permissionCategoryPreview', permissionCategoryPreview);

window.Alpine = Alpine;
Alpine.start();
