<x-app-layout>
    <x-slot name="title">Roles & Permissions</x-slot>

    @push('styles')
        <style>
            .rw-page { --rw-blue: #2563eb; --rw-border: #e5e7eb; --rw-muted: #64748b; color: #0f172a; }
            .rw-page [x-cloak] { display: none !important; }
            .rw-heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 24px; }
            .rw-eyebrow { display: flex; align-items: center; gap: 7px; margin-bottom: 7px; color: var(--rw-muted); font-size: 11px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; }
            .rw-heading h1 { margin: 0; font-size: 27px; font-weight: 700; letter-spacing: -.035em; }
            .rw-heading p { margin: 7px 0 0; font-size: 13px; color: var(--rw-muted); }
            .rw-heading-badges { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; }
            .rw-badge { display: inline-flex; align-items: center; gap: 5px; border: 1px solid var(--rw-border); border-radius: 4px; background: #fff; padding: 6px 9px; color: #475569; font-size: 11px; font-weight: 600; white-space: nowrap; }
            .rw-badge-preview { border-color: #bfdbfe; color: #2563eb; background: #eff6ff; }
            .rw-grid { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; align-items: start; }
            .rw-left { grid-column: span 4; min-width: 0; }
            .rw-right { grid-column: span 8; min-width: 0; }
            .rw-card { display: flex; flex-direction: column; height: min(800px, calc(100vh - 230px)); min-height: 570px; border: 1px solid var(--rw-border); border-radius: 10px; background: #fff; box-shadow: 0 2px 7px #0f172a04; overflow: hidden; }
            .rw-card-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 19px 20px; border-bottom: 1px solid var(--rw-border); }
            .rw-card-header h2 { margin: 0; font-size: 16px; font-weight: 700; }
            .rw-count { display: inline-flex; align-items: center; justify-content: center; min-width: 25px; height: 23px; border-radius: 4px; background: #f1f5f9; padding: 0 7px; color: #64748b; font-size: 11px; font-weight: 700; }
            .rw-title-with-icon { display: flex; align-items: center; gap: 9px; }
            .rw-create { padding: 17px 18px; border-bottom: 1px solid var(--rw-border); background: #fafbfe; }
            .rw-create label { display: block; margin-bottom: 8px; color: #475569; font-size: 11px; font-weight: 600; }
            .rw-create-row { display: flex; align-items: stretch; gap: 7px; }
            .rw-input { min-width: 0; width: 100%; border: 1px solid #dbe1e9; border-radius: 5px; background: #fff; padding: 10px 11px; color: #0f172a; font: inherit; font-size: 12px; box-shadow: none; }
            .rw-input::placeholder { color: #94a3b8; }
            .rw-input:focus { outline: none; border-color: #93b4ff; box-shadow: 0 0 0 3px #2563eb12; }
            .rw-create-button { display: flex; align-items: center; justify-content: center; gap: 5px; flex-shrink: 0; border: 0; border-radius: 5px; background: var(--rw-blue); padding: 0 11px; color: white; font-size: 12px; font-weight: 600; }
            .rw-create-button:hover { background: #1d4ed8; }
            .rw-error { margin: 8px 0 0; font-size: 11px; color: #dc2626; }
            .rw-search-wrap { position: relative; }
            .rw-search-wrap > svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
            .rw-search-wrap .rw-input { padding-left: 33px; }
            .rw-role-search { padding: 13px 18px 9px; }
            .rw-role-list { flex: 1; min-height: 0; overflow-y: auto; padding: 4px 9px 12px; scrollbar-width: thin; scrollbar-color: #dbe1e9 transparent; }
            .rw-role { position: relative; display: flex; align-items: center; gap: 11px; width: 100%; margin: 3px 0; border: 1px solid transparent; border-radius: 6px; background: transparent; padding: 12px 10px; text-align: left; transition: background .15s, border-color .15s; }
            .rw-role:hover { background: #f8fafc; }
            .rw-role.is-active { border-color: #dbeafe; background: #eff6ff; }
            .rw-role.is-active::before { content: ''; position: absolute; top: 14px; bottom: 14px; left: -1px; width: 3px; border-radius: 3px; background: var(--rw-blue); }
            .rw-role-avatar { display: grid; flex-shrink: 0; width: 36px; height: 36px; place-items: center; border: 1px solid #e8edf3; border-radius: 6px; background: #f8fafc; color: #64748b; font-size: 11px; font-weight: 700; }
            .rw-role.is-active .rw-role-avatar { border-color: #bfdbfe; background: #dbeafe; color: var(--rw-blue); }
            .rw-role-text { flex: 1; min-width: 0; }
            .rw-role-name { display: block; overflow: hidden; color: #334155; font-size: 12px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
            .rw-role.is-active .rw-role-name { color: #1d4ed8; }
            .rw-role-meta { display: block; margin-top: 4px; color: #94a3b8; font-size: 10px; }
            .rw-role-tail { display: flex; flex-shrink: 0; align-items: center; color: #94a3b8; }
            .rw-pill { border-radius: 3px; background: #f1f5f9; padding: 3px 6px; color: #64748b; font-size: 9px; font-weight: 700; }
            .rw-pill-draft { background: #dbeafe; color: #2563eb; }
            .rw-left-footer { display: flex; align-items: center; gap: 7px; border-top: 1px solid var(--rw-border); padding: 12px 18px; color: #94a3b8; font-size: 10px; }
            .rw-panel-heading { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 19px 22px; border-bottom: 1px solid var(--rw-border); }
            .rw-panel-heading h2 { margin: 0; font-size: 16px; font-weight: 700; }
            .rw-panel-subtitle { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; margin-top: 7px; color: #94a3b8; font-size: 11px; }
            .rw-selected-name { color: #2563eb; font-weight: 600; }
            .rw-readonly { display: inline-flex; align-items: center; gap: 5px; flex-shrink: 0; border: 1px solid #e2e8f0; border-radius: 4px; padding: 6px 8px; color: #64748b; font-size: 10px; }
            .rw-toolbar { padding: 15px 21px 12px; border-bottom: 1px solid #edf0f4; }
            .rw-toolbar-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 12px; }
            .rw-filters { display: flex; align-items: center; gap: 3px; border-radius: 4px; background: #f1f5f9; padding: 3px; }
            .rw-filter { border: 0; border-radius: 3px; background: transparent; padding: 6px 9px; color: #64748b; font-size: 10px; font-weight: 600; white-space: nowrap; }
            .rw-filter span { margin-left: 4px; opacity: .65; font-weight: 500; }
            .rw-filter.is-active { background: #fff; color: #2563eb; box-shadow: 0 1px 3px #0f172a0a; }
            .rw-bulk-actions { display: flex; align-items: center; gap: 12px; }
            .rw-text-button { border: 0; background: none; padding: 0; color: #2563eb; font-size: 11px; font-weight: 600; white-space: nowrap; }
            .rw-text-button:disabled { color: #cbd5e1; cursor: not-allowed; }
            .rw-modules { flex: 1; min-height: 0; overflow-y: auto; overscroll-behavior: contain; background: #fafbfc; padding: 17px 20px; scrollbar-width: thin; scrollbar-color: #dbe1e9 transparent; }
            .rw-module { margin-bottom: 12px; border: 1px solid var(--rw-border); border-radius: 7px; background: #fff; }
            .rw-module:last-child { margin-bottom: 0; }
            .rw-module-heading { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 13px 14px 11px; }
            .rw-module-title { display: flex; align-items: center; gap: 8px; min-width: 0; }
            .rw-module-icon { display: grid; width: 26px; height: 26px; flex-shrink: 0; place-items: center; border: 1px solid #e2eaf7; border-radius: 4px; background: #f4f7fe; color: #5a7cb6; }
            .rw-module-title h3 { margin: 0; color: #334155; font-size: 12px; font-weight: 600; }
            .rw-module-controls { display: flex; align-items: center; gap: 9px; flex-shrink: 0; }
            .rw-module-count { flex-shrink: 0; margin-left: auto; color: #64748b; font-size: 11px; line-height: 18px; font-variant-numeric: tabular-nums; white-space: nowrap; }
            .rw-checkbox { width: 14px; height: 14px; flex-shrink: 0; margin: 0; border: 1px solid #cbd5e1; border-radius: 3px; color: #2563eb; accent-color: #2563eb; }
            .rw-checkbox:disabled { cursor: not-allowed; opacity: .55; }
            .rw-permission { display: flex; align-items: center; gap: 7px; min-width: 0; border: 1px solid #edf0f4; border-radius: 4px; background: #fafbfc; padding: 9px; cursor: pointer; }
            .rw-permission.is-checked { border-color: #dbeafe; background: #f4f8ff; }
            .rw-permission.is-locked { cursor: default; }
            .rw-permission span { overflow-wrap: anywhere; color: #64748b; font-size: 11px; line-height: 1.45; }
            .rw-permission.is-checked span { color: #335886; }
            .rw-panel-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; border-top: 1px solid var(--rw-border); padding: 15px 21px; }
            .rw-selection-count { color: #475569; font-size: 11px; }
            .rw-selection-count strong { color: #2563eb; }
            .rw-preview-note { margin-top: 4px; color: #94a3b8; font-size: 10px; }
            .rw-footer-actions { display: flex; align-items: center; gap: 14px; }
            .rw-save-button { display: flex; align-items: center; gap: 6px; border: 0; border-radius: 4px; background: var(--rw-blue); padding: 10px 13px; color: #fff; font-size: 11px; font-weight: 600; cursor: pointer; white-space: nowrap; }
            .rw-save-button:disabled { background: #dbeafe; color: #7a9dc9; cursor: not-allowed; }
            .rw-create-button:disabled { opacity: .6; cursor: wait; }
            .rw-feedback { margin-bottom: 16px; border: 1px solid #bbf7d0; border-radius: 6px; background: #f0fdf4; padding: 11px 14px; color: #166534; font-size: 12px; }
            .rw-feedback.is-error { border-color: #fecaca; background: #fef2f2; color: #b91c1c; }
            .rw-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; min-height: 190px; padding: 24px; text-align: center; color: #94a3b8; font-size: 12px; }
            .rw-empty strong { color: #475569; font-size: 13px; }
            .rw-page button:focus-visible, .rw-page input:focus-visible { outline: 2px solid #60a5fa; outline-offset: 3px; }
            .dark .rw-page { --rw-border: #334155; color: #e2e8f0; }
            .dark .rw-card, .dark .rw-module, .dark .rw-badge { background: #1e293b; }
            .dark .rw-create, .dark .rw-modules, .dark .rw-role-avatar, .dark .rw-permission { background: #182337; }
            .dark .rw-role-name, .dark .rw-module-title h3, .dark .rw-selection-count, .dark .rw-empty strong { color: #cbd5e1; }
            .dark .rw-role:hover, .dark .rw-filters, .dark .rw-count, .dark .rw-pill { background: #26354b; }
            .dark .rw-role.is-active, .dark .rw-permission.is-checked, .dark .rw-badge-preview { background: #1d3557; border-color: #345a86; }
            .dark .rw-role.is-active .rw-role-name, .dark .rw-selected-name, .dark .rw-selection-count strong { color: #93c5fd; }
            .dark .rw-filter.is-active { background: #334155; color: #93c5fd; }
            .dark .rw-role-avatar, .dark .rw-permission, .dark .rw-readonly, .dark .rw-toolbar { border-color: #334155; }
            .dark .rw-module-icon, .dark .rw-role.is-active .rw-role-avatar, .dark .rw-pill-draft { background: #263d5e; border-color: #345a86; color: #93c5fd; }
            .dark .rw-permission.is-checked span { color: #a8c9f1; }
            .dark .rw-save-button:disabled { background: #263d5e; color: #7191bc; }
            .dark .rw-feedback { background: #123529; border-color: #166534; color: #86efac; }
            .dark .rw-feedback.is-error { background: #3f2028; border-color: #7f1d1d; color: #fca5a5; }
            @media (max-width: 1199px) { .rw-grid { gap: 17px; } .rw-bulk-actions { gap: 8px; } .rw-filter { padding: 6px; } }
            @media (max-width: 1023px) { .rw-left, .rw-right { grid-column: span 12; } .rw-card { height: auto; min-height: 0; } .rw-role-list { max-height: 300px; } .rw-modules { flex: none; max-height: 540px; } }
            @media (max-width: 600px) { .rw-heading { align-items: flex-start; gap: 12px; } .rw-heading h1 { font-size: 22px; } .rw-heading p { font-size: 12px; line-height: 1.6; } .rw-heading-badges .rw-badge:not(.rw-badge-preview) { display: none; } .rw-toolbar, .rw-modules { padding-left: 13px; padding-right: 13px; } .rw-card-header, .rw-panel-heading { padding: 16px; } .rw-toolbar-row { flex-wrap: wrap; gap: 11px; } .rw-panel-footer { align-items: flex-start; flex-wrap: wrap; padding: 14px; } .rw-footer-actions { margin-left: auto; } .rw-create { padding: 15px; } }
            .rw-card-header { height: 64px; min-height: 64px; flex-shrink: 0; padding: 14px 20px; }
            .rw-panel-subtitle { margin-top: 4px; }
            .rw-card-header > div:first-child { min-width: 0; }
            .rw-panel-subtitle { display: block; max-width: 260px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            .rw-role-search, .rw-toolbar { padding: 14px 18px; border-bottom: 1px solid var(--rw-border); }
            .rw-header-actions { display: flex; align-items: center; gap: 10px; }
            .rw-view-select { min-width: 86px; border: 1px solid var(--rw-border); border-radius: 4px; padding: 6px 25px 6px 9px; color: #475569; font-size: 11px; background-color: #fff; }
            .rw-edit-button { display: inline-flex; align-items: center; gap: 5px; border: 1px solid #bfdbfe; border-radius: 4px; background: #eff6ff; padding: 7px 10px; color: #2563eb; font-size: 11px; font-weight: 600; }
            .rw-create-trigger { min-height: 35px; padding: 9px 12px; }
            .rw-bulk-actions { margin-top: 10px; justify-content: flex-end; }
            .rw-permission { border: 0; border-bottom: 1px solid #edf0f4; border-radius: 0; background: transparent; padding: 10px 2px; cursor: default; }
            .rw-permission:last-child { border-bottom: 0; }
            .rw-permission.is-editable { cursor: pointer; }
            .rw-permission.is-checked { background: transparent; border-color: #edf0f4; }
            .rw-permission-name { flex: 1; min-width: 0; }
            .rw-permission-name > span { display: block; color: #334155; font-size: 12px; }
            .rw-permission-name small { display: block; margin-top: 3px; color: #94a3b8; font-size: 10px; }
            .rw-permission-status { flex-shrink: 0; border-radius: 3px; background: #f1f5f9; padding: 4px 7px; color: #94a3b8 !important; font-size: 10px !important; }
            .rw-permission-status.is-enabled { background: #f0fdf4; color: #15803d !important; }
            .rw-preview-note { color: #dc2626; }
            .rw-modal { position: fixed; inset: 0; z-index: 80; display: flex; align-items: center; justify-content: center; padding: 20px; background: #0f172a66; }
            .rw-modal-card { width: 100%; max-width: 360px; border: 1px solid var(--rw-border); border-radius: 9px; background: #fff; padding: 20px; box-shadow: 0 20px 60px #0f172a26; }
            .rw-modal-heading { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
            .rw-modal-heading h2 { margin: 0; font-size: 16px; font-weight: 700; }
            .rw-modal-close { background: transparent; border: 0; color: #94a3b8; font-size: 23px; line-height: 1; }
            .rw-modal-card > label { display: block; margin-bottom: 7px; color: #64748b; font-size: 12px; }
            .rw-modal-actions { display: flex; align-items: center; justify-content: flex-end; gap: 16px; margin-top: 20px; }
            .rw-modal-actions .rw-create-button { min-height: 35px; padding: 9px 12px; }
            .dark .rw-modal-card { background: #1e293b; }
            .dark .rw-permission-name > span { color: #cbd5e1; }
            .dark .rw-permission { border-color: #334155; }
            .dark .rw-permission-status { background: #26354b; }
            .dark .rw-permission-status.is-enabled { background: #123529; color: #86efac !important; }
            .dark .rw-edit-button { background: #263d5e; border-color: #345a86; color: #93c5fd; }
            .rw-heading { margin-bottom: 16px; }
            .rw-heading-actions { display: flex; align-items: center; gap: 8px; }
            .rw-card { height: auto; min-height: 0; overflow: visible; }
            .rw-card-header { gap: 10px; padding: 12px 14px; background: #fff; border-radius: 10px 10px 0 0; }
            .rw-title-with-icon { flex-shrink: 0; gap: 6px; }
            .rw-card-header h2 { white-space: nowrap; font-size: 16px; }
            .rw-header-search { flex: 1 1 160px; min-width: 85px; max-width: 260px; margin: 0 auto; }
            .rw-header-search .rw-input { padding-top: 8px; padding-bottom: 8px; font-size: 12px; }
            .rw-header-actions { flex-shrink: 0; gap: 7px; }
            .rw-active-count { color: #64748b; font-size: 11px; font-weight: 600; font-variant-numeric: tabular-nums; white-space: nowrap; }
            .rw-role-list { flex: none; overflow: visible; max-height: none; padding: 6px; }
            .rw-role { padding: 8px; margin: 2px 0; gap: 8px; }
            .rw-role-avatar { width: 29px; height: 29px; border-radius: 4px; }
            .rw-modules { flex: none; overflow: visible; max-height: none; padding: 0 13px; background: #fff; }
            .rw-module { display: grid; grid-template-columns: 142px minmax(0, 1fr); gap: 12px; margin: 0; padding: 10px 0; border: 0; border-bottom: 1px solid var(--rw-border); border-radius: 0; }
            .rw-module:last-child { border-bottom: 0; }
            .rw-module-heading { flex-direction: column; align-items: flex-start; justify-content: center; gap: 5px; padding: 0; }
            .rw-module-icon { display: none; }
            .rw-module-title h3 { font-size: 11px; line-height: 1.4; }
            .rw-module-controls { gap: 6px; }
            .rw-permission { flex: 0 1 auto; max-width: 100%; gap: 5px; margin: 0; padding: 5px 7px; border: 1px solid #e8edf3; border-radius: 3px; background: #fafbfc; }
            .rw-permission:last-child { border-bottom: 1px solid #e8edf3; }
            .rw-permission.is-checked { background: #eff6ff; border-color: #dbeafe; }
            .rw-permission-name { flex: none; }
            .rw-permission-name > span { font-size: 11px; line-height: 1.3; }
            .rw-permission-status { padding: 2px 4px; font-size: 9px !important; }
            .rw-compact-actions { display: flex; justify-content: flex-end; gap: 12px; padding: 8px 14px; border-bottom: 1px solid var(--rw-border); }
            .dark .rw-card-header, .dark .rw-modules { background: #1e293b; }
            .dark .rw-permission, .dark .rw-permission:last-child { border-color: #334155; background: #182337; }
            .dark .rw-permission.is-checked { background: #1d3557; border-color: #345a86; }
            .rw-modules { padding: 12px; }
            .rw-module { display: block; margin-bottom: 10px; padding: 0; border: 1px solid var(--rw-border); border-radius: 6px; background: #fff; }
            .rw-module:last-child { border-bottom: 1px solid var(--rw-border); }
            .rw-module-heading { flex-direction: row; align-items: center; justify-content: space-between; padding: 12px; }
            .rw-module-icon { display: grid; }
            .rw-module-title h3 { font-size: 12px; }
            .rw-permission { width: 100%; margin: 0; padding: 8px; border-radius: 4px; background: #f8fafc; }
            .rw-permission.is-checked { background: #eff6ff; border-color: #dbeafe; }
            .rw-permission-name { flex: 1; }
            .rw-permission-name > span { font-size: 11px; line-height: 1.5; }
            .rw-checkbox:disabled { opacity: .8; }
            .dark .rw-module { background: #1e293b; }
            .dark .rw-permission.is-checked { background: #1d3557; border-color: #345a86; }
            .rw-header-bulk { display: flex; align-items: center; gap: 9px; flex-shrink: 0; }
            .rw-cancel-button { border-color: var(--rw-border); background: #fff; color: #64748b; }
            .dark .rw-cancel-button { background: #1e293b; border-color: #475569; color: #cbd5e1; }
            .rw-select-all { display: inline-flex; align-items: center; gap: 6px; color: #2563eb; font-size: 11px; font-weight: 600; white-space: nowrap; cursor: pointer; }
            .rw-select-all.is-disabled { cursor: not-allowed; color: #94a3b8; }
            .rw-module-title label { cursor: default; }
            .rw-checkbox:not(:disabled), .rw-permission.is-editable { cursor: pointer; }
            .rw-modules { padding: 8px 12px 12px; }
            fieldset.rw-module { min-width: 0; margin: 0 0 10px; padding: 0; border: 1px solid var(--rw-border); border-radius: 6px; overflow: hidden; }
            .rw-module-heading { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 7px 18px; border-bottom: 1px solid var(--rw-border); background: #f8fafc; }
            .rw-category-name { font-size: 12px; line-height: 18px; font-weight: 600; color: #334155; white-space: nowrap; }
            .rw-module-title { gap: 6px; }
            .rw-permission-grid { display: flex; flex-wrap: wrap; align-items: center; gap: 2px 14px; padding: 3px 0 0; }
            .rw-permission { flex: 0 1 auto; width: auto; max-width: 100%; gap: 6px; padding: 3px 0; border: 0; border-radius: 3px; background: transparent; }
            .rw-permission:last-child, .rw-permission.is-checked, .rw-permission.is-disabled { border: 0; background: transparent; }
            .rw-permission-name { flex: 0 1 auto; }
            .rw-permission-name > span { font-size: 12px; line-height: 18px; white-space: nowrap; }
            .rw-permission.is-editable:hover { background: #eff6ff; }
            .rw-permission-bullet { width: 6px; height: 6px; flex-shrink: 0; border-radius: 50%; background: #2563eb; }
            .rw-permission-bullet.is-disabled { background: #cbd5e1; }
            .rw-permission.is-disabled .rw-permission-name > span { color: #94a3b8; }
            .rw-disabled-label { color: #94a3b8 !important; font-size: 9px !important; }
            .rw-inline-error { margin: 0; padding: 7px 14px; color: #dc2626; font-size: 11px; }
            .dark .rw-module-heading { background: #26354b; border-color: #334155; }
            .dark .rw-category-name { color: #cbd5e1; }
            .dark .rw-permission, .dark .rw-permission:last-child, .dark .rw-permission.is-checked, .dark .rw-permission.is-disabled { background: transparent; }
            .dark .rw-permission.is-editable:hover { background: #263d5e; }
            .dark .rw-permission-bullet.is-disabled { background: #475569; }
            .rw-card-header { height: 48px; min-height: 48px; padding: 7px 14px; }
            .rw-title-with-role { display: flex; align-items: center; gap: 8px; min-width: 0; }
            .rw-role-badge { max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; border-radius: 3px; padding: 3px 7px; background: #eff6ff; color: #2563eb; font-size: 11px; line-height: 16px; font-weight: 600; }
            .dark .rw-role-badge { background: #263d5e; color: #93c5fd; }
            .rw-left, .rw-right { min-height: 0; }
            .rw-card { height: clamp(320px, calc(100dvh - 172px), 850px); min-height: 0; overflow: hidden; }
            .rw-card-header { flex: 0 0 48px; position: relative; z-index: 1; }
            .rw-role-list, .rw-modules { flex: 1 1 auto; min-height: 0; max-height: none; overflow-y: auto; overflow-x: hidden; overscroll-behavior: contain; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
            .rw-inline-error { flex-shrink: 0; }
            .rw-child-pages { display: flex; flex-direction: column; gap: 6px; padding: 8px; }
            .rw-child-page { min-width: 0; margin: 0; border: 1px solid #e8edf3; border-radius: 4px; padding: 0; background: #fff; overflow: hidden; }
            .rw-child-page-heading { display: flex; align-items: center; gap: 6px; min-width: 0; padding: 5px 9px; border-bottom: 1px solid #edf2f7; }
            .rw-child-page-name { color: #475569; font-size: 12px; line-height: 18px; font-weight: 600; white-space: nowrap; cursor: default; }
            .rw-child-page .rw-permission-grid { gap: 2px 18px; padding: 3px 9px 5px; }
            .dark .rw-child-page { border-color: #334155; background: #1e293b; }
            .dark .rw-child-page-heading { border-color: #334155; }
            .dark .rw-child-page-name { color: #94a3b8; }
        </style>
    @endpush

    <div class="rw-page" x-data="rolesWorkspace(@js($workspaceRoles), @js($workspaceModules), @js($grantablePermissionKeys), @js($canCreateRole), @js($initialRoleId), @js($workspaceEndpoints))">
        <div class="rw-heading">
            <div>
                <h1>Roles & Permissions</h1>
            </div>
            @if(request()->query('preview') === 'academic')
                <a href="{{ route('roles.index') }}" class="rw-edit-button">Back to roles</a>
            @else
                <div class="rw-heading-actions">
                    <button type="button" class="rw-edit-button" @click="showOwnPermissions()" :disabled="isBusy" :aria-pressed="selectedRole?.is_self ?? false">My permissions</button>
            @if($canCreateRole)
                <button type="button" class="rw-create-button rw-create-trigger" x-ref="createRoleButton" @click="openCreateModal()" :disabled="isBusy" x-show="canCreate">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                    Create role
                </button>
            @endif
                </div>
            @endif
        </div>



        <div class="rw-grid">
            <aside class="rw-left" aria-label="Role selection">
                <div class="rw-card">
                    <div class="rw-card-header">
                        <div class="rw-title-with-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.7" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <h2>All roles</h2>
                        </div>
                        <div class="rw-search-wrap rw-header-search">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
                            <input data-role-search class="rw-input" type="search" placeholder="Search roles" aria-label="Search roles" x-model="roleSearch">
                        </div>

                        <span class="rw-count" x-text="roles.length">{{ count($workspaceRoles) }}</span>
                    </div>


                    <nav class="rw-role-list" aria-label="Available roles">
                        <template x-for="role in filteredRoles" :key="role.id">
                            <button :data-role-id="role.id" type="button" class="rw-role" :class="{ 'is-active': selectedId === role.id }" @click="selectRole(role.id)" :disabled="isBusy" :aria-pressed="selectedId === role.id" aria-controls="rw-permission-panel">
                                <span class="rw-role-avatar" x-text="roleInitials(role)"></span>
                                <span class="rw-role-text">
                                    <span class="rw-role-name" x-text="role.label"></span>
                                    <span class="rw-role-meta" x-text="role.users_count + (role.users_count === 1 ? ' member' : ' members') + ' · ' + (role.is_super ? 'All permissions' : rolePermissionCount(role) + ' permissions')"></span>
                                </span>
                                <span class="rw-role-tail">
                                    <svg x-show="role.is_super" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-label="Protected system role"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                                    <svg x-show="!role.is_super" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m9 5 7 7-7 7"/></svg>
                                </span>
                            </button>
                        </template>
                        <div class="rw-empty" x-show="filteredRoles.length === 0" x-cloak><strong>No roles found</strong><span>Try another role name.</span></div>
                    </nav>

                </div>
            </aside>

            <section id="rw-permission-panel" class="rw-right" aria-label="Selected role permissions">
                @if(request()->query('preview') === 'academic')
                    @include('roles.category-preview')
                @else
                <div class="rw-card">
                    <div class="rw-card-header">
                        <div class="rw-title-with-role">
                            <h2>Permissions</h2>
                            <span class="rw-role-badge" x-text="selectedRole?.label ?? 'Choose a role'" :title="selectedRole?.label ?? 'Choose a role'" aria-live="polite"></span>
                        </div>
                        <div class="rw-search-wrap rw-header-search">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
                            <input data-permission-search class="rw-input" type="search" placeholder="Search permissions" aria-label="Search modules or permissions" x-model="permissionSearch">
                        </div>
                        <div class="rw-header-bulk" x-show="isEditing" x-cloak>
                            <label for="rw-select-all-permissions" class="rw-select-all" :class="{ 'is-disabled': isBusy || isReadOnly }">
                                <input id="rw-select-all-permissions" class="rw-checkbox" type="checkbox" :checked="allPermissionsSelected" @change="toggleAllPermissions($event.target.checked)" :disabled="isBusy || isReadOnly" aria-controls="rw-permission-categories">
                                <span>Select all</span>
                            </label>
                        </div>
                        <div class="rw-header-actions" x-show="selectedRole">
                            <span class="rw-active-count" x-text="activePermissionCount + '/' + totalPermissions" :title="selectedRole?.is_self ? 'Your permissions' : 'Assigned permissions / permissions you can assign'" :aria-label="selectedRole?.is_self ? 'Your own permission count' : 'Assigned permissions out of permissions you can assign'"></span>
                            <button data-save-permissions type="button" class="rw-edit-button" x-show="!isReadOnly" @click="isEditing ? savePermissions() : beginEditing()" :disabled="isBusy" :aria-label="isEditing ? 'Save permissions' : 'Edit permissions'">
                                <svg x-show="!isEditing" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m16 3 5 5-12 12-6 1 1-6L16 3Z"/></svg>
                                <svg x-show="isEditing" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                                <span x-text="isSaving ? 'Saving…' : isEditing ? 'Save' : 'Edit'">Edit</span>
                            </button>
                            <span class="rw-readonly" x-show="isReadOnly" x-cloak x-text="selectedRole?.is_super ? 'System role' : 'View only'"></span>

                        </div>
                    </div>


                    <p class="rw-inline-error" x-show="feedback && feedbackType === 'error'" x-text="feedback" role="alert" x-cloak></p>

                    <div id="rw-permission-categories" class="rw-modules">
                        <template x-for="module in visibleModules" :key="module.id">
                            <fieldset class="rw-module" :data-module-key="module.key" x-show="selectedRole">
                                <legend class="sr-only" x-text="module.label"></legend>
                                <div class="rw-module-heading">
                                    <span class="rw-module-title">
                                        <template x-if="isEditing"><input class="rw-checkbox" type="checkbox" :id="'rw-category-' + module.id" data-parent-id="rw-select-all-permissions" :data-category-id="module.id" :aria-controls="'rw-category-permissions-' + module.id" :checked="moduleAllSelected(module)" @change="toggleModule(module)" :disabled="isReadOnly || !modulePermissionKeys(module).some(key => canToggle(key))" :aria-label="'Select all permissions in ' + module.label"></template>
                                        <label class="rw-category-name" :for="'rw-category-' + module.id" x-text="module.label"></label>
                                    </span>
                                    <span class="rw-module-count" x-text="moduleSelectedCount(module) + '/' + modulePermissionCount(module)"></span>
                                </div>
                                <div class="rw-child-pages" :id="'rw-category-permissions-' + module.id">
                                    <template x-for="page in module.pages" :key="page.id">
                                        <fieldset class="rw-child-page" :data-page-key="page.key">
                                            <legend class="sr-only" x-text="page.label"></legend>
                                            <div class="rw-child-page-heading">
                                                <template x-if="isEditing"><input class="rw-checkbox" type="checkbox" :id="'rw-page-' + page.id" :data-parent-id="'rw-category-' + module.id" :aria-controls="'rw-page-permissions-' + page.id" :checked="pageAllSelected(module, page)" @change="togglePage(module, page, $event.target.checked)" :disabled="!pagePermissionKeys(module, page).some(key => canToggle(key))" :aria-label="'Select all permissions for ' + page.label"></template>
                                                <label class="rw-child-page-name" :for="'rw-page-' + page.id" x-text="page.label"></label>
                                                <span class="rw-module-count" x-text="pageSelectedCount(module, page) + '/' + pagePermissionKeys(module, page).length"></span>
                                            </div>
                                            <div class="rw-permission-grid" :id="'rw-page-permissions-' + page.id">
                                                <template x-for="permission in page.permissions" :key="permission.key">
                                                    <label class="rw-permission" :for="'rw-permission-' + module.id + '-' + permission.key" :title="permission.label + ' (' + permission.key + ')'" :class="{ 'is-checked': isEditing && isSelected(permission.key), 'is-editable': isEditing && canToggle(permission.key), 'is-disabled': !isEditing && !isEnabled(permission.key) }">
                                                        <template x-if="isEditing"><input class="rw-checkbox" type="checkbox" :id="'rw-permission-' + module.id + '-' + permission.key" :data-parent-id="'rw-page-' + page.id" :data-category-id="module.id" :data-page-id="page.id" :data-permission-key="permission.key" :checked="isSelected(permission.key)" @change="togglePermission(permission.key)" :disabled="!canToggle(permission.key)" :aria-label="module.label + ': ' + page.label + ': ' + permission.label"></template>
                                                        <span class="rw-permission-bullet" x-show="!isEditing" :class="{ 'is-disabled': !isEnabled(permission.key) }" aria-hidden="true"></span>
                                                        <span class="rw-permission-name"><span x-text="permission.displayLabel"></span></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </fieldset>
                                    </template>
                                </div>
                            </fieldset>
                        </template>
                        <div class="rw-empty" x-show="!selectedRole" x-cloak>
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.3" aria-hidden="true"><path d="M12 3 20 6v6c0 5-8 9-8 9S4 17 4 12V6l8-3Z"/></svg>
                            <strong>Choose a role to get started</strong><span>Its module permissions will appear here.</span>
                        </div>
                        <div class="rw-empty" x-show="selectedRole && visibleModules.length === 0" x-cloak>
                            <strong>No matching permissions</strong><span>Try another module or permission name.</span>
                            <button type="button" class="rw-text-button" @click="permissionSearch = ''">Show all permissions</button>
                        </div>
                    </div>


                </div>
                @endif
            </section>
        </div>
        @if($canCreateRole)
            <div class="rw-modal" x-show="createModalOpen" x-cloak @click.self="closeCreateModal()" @keydown.escape.window="closeCreateModal()">
                <section class="rw-modal-card" role="dialog" aria-modal="true" aria-labelledby="rw-create-title">
                    <div class="rw-modal-heading"><h2 id="rw-create-title">Create role</h2><button type="button" class="rw-modal-close" @click="closeCreateModal()" :disabled="isCreating" aria-label="Close create role dialog">×</button></div>
                    <label for="rw-new-role">Role name</label>
                    <input id="rw-new-role" x-ref="newRoleInput" data-new-role-input class="rw-input" type="text" maxlength="100" placeholder="Enter role name" x-model="newRoleName" :disabled="isCreating" @keydown.enter.prevent="startNewRole()" :aria-invalid="Boolean(createError)" aria-describedby="rw-create-error">
                    <p id="rw-create-error" class="rw-error" x-show="createError" x-text="createError" role="alert" x-cloak></p>
                    <div class="rw-modal-actions"><button data-new-role-button type="button" class="rw-create-button" @click="startNewRole()" :disabled="isCreating"><span x-text="isCreating ? 'Creating…' : 'Create role'">Create role</span></button></div>
                </section>
            </div>
        @endif

    </div>
</x-app-layout>
