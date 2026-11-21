# Project workflow

- After completing each task that changes project code, run `npm run build` from the project root as the final verification step.
- Include the frontend build result in the final response. Fix failures caused by your changes and report any remaining blocker.

# New pages and permission registration

- Every new application page must be added to `config/permission-pages.php` with a stable unique key, category, readable label, and named route prefix. Put it in the intended page order; the registry synchronizes that serial order into `permission_pages.sort_order`.
- Keep protected routes under `auth` and `AuthorizeModule`. Standard named CRUD routes (`index`, `show`, `create`, `store`, `edit`, `update`, `destroy`) automatically generate the necessary page/action permissions during `php artisan permissions:sync`; do not create actions the page does not support. A GET route whose name exactly matches the declared page prefix also registers View, even without an `.index` suffix.
- Explicitly map custom actions in `authorization.routes` or the page's `actions` map, with required data/management permissions. Unknown custom actions stay denied. Use `@access` for links/buttons so frontend and backend use the same route rules.
- When adding/changing a page, run `php artisan config:clear`, then `php artisan permissions:sync` after migrations. Verify its page fieldset and route access. Registration is a development/deployment step, not a database write on every web request.
- New permissions are not assigned to ordinary roles or users by sync. Super Admin automatically has every registered permission. New user-created roles start empty; an authorized administrator explicitly selects grants in Roles & Permissions. Do not copy new grants to Admin, Manager, Teacher, Student, or all users by default.
- Dashboard cards belong in `authorization.dashboard_cards`, with a meaningful label and required data permissions. Sync creates each card permission; check both card permission and data permissions before loading its data and displaying the card. Never rely only on hiding HTML.
- Preserve stable permission keys, IDs, custom labels, role grants and direct user grants. The page-permission migration performs the existing-data conversion once; do not add legacy grant expansion to normal synchronization or runtime authorization.
- For authorization changes, verify denied access, permitted access, page isolation, grant revocation and privilege-escalation protection. Do not run mobile/responsive browser checks unless the user requests them.

# Creator ownership and delegation

- Users and roles record immutable `created_by` from the authenticated creator on the server. Do not accept creator IDs from request input or change the original record's ownership on edit/duplicate; new copies belong to the copier. System/unauthenticated records may have no creator.
- Non-super administrators may list, view, edit, delete, assign and duplicate only the users/roles they directly created, with the required action permissions. Super Admin can access all creators and unowned records. Use explicit `visibleTo` scopes and policies; do not add global scopes that would break permission inheritance from assigned roles.
- Apply creator filtering to related role dropdowns, user detail role names, role member counts and Dashboard user/role records/counts. Existing foreign/system role assignments may be preserved on user edit without exposing or newly assigning them.
- Delegate only keys in the actor's current effective permissions, whether through role creation/editing/duplication, role assignment or direct user grants. A user holding 100 permissions cannot delegate any of the other permissions. Existing privileged grants remain controlled by Super Admin.
- In the role editor, show/count only permissions the actor can delegate; hide unrelated categories/pages. My permissions is a read-only view of the actor's own active/custom permissions, including held management permissions that cannot be delegated. Super Admin can see the complete catalog. Never use the global catalog total as an ordinary actor's assignment limit.
- Student/Teacher/Staff account creation must stamp the creator and validate default role permissions against the creator's grants before creating the account. Never let an automatic default role bypass the delegation ceiling.
- Backfill legacy creators only from explicit creation audit events. Do not infer ownership from later editors, arbitrary administrators or permission updates. Unknown creators remain visible to Super Admin only.
