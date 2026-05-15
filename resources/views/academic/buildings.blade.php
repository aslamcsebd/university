@extends('layouts.academic')
@section('title','Buildings')
@section('heading','Buildings')
@section('header-actions')
<button class="btn btn-primary" onclick="openModal('modal-add')">+ New Building</button>
@endsection
@section('content')
@php
$buildings = [
    ['id'=>1,'code'=>'BLK-A','name'=>'Block A','campus'=>'Main Campus','floors'=>4,'rooms'=>8,'status'=>'Active'],
    ['id'=>2,'code'=>'BLK-B','name'=>'Block B','campus'=>'Main Campus','floors'=>3,'rooms'=>6,'status'=>'Active'],
    ['id'=>3,'code'=>'BLK-C','name'=>'Block C','campus'=>'Main Campus','floors'=>2,'rooms'=>4,'status'=>'Active'],
    ['id'=>4,'code'=>'SCI',  'name'=>'Science Block','campus'=>'Main Campus','floors'=>3,'rooms'=>5,'status'=>'Active'],
    ['id'=>5,'code'=>'ADM',  'name'=>'Admin Block','campus'=>'Main Campus','floors'=>5,'rooms'=>3,'status'=>'Active'],
    ['id'=>6,'code'=>'ANN',  'name'=>'Annex Building','campus'=>'North Campus','floors'=>2,'rooms'=>4,'status'=>'Inactive'],
];
@endphp
<div style="display:flex;gap:20px;align-items:flex-start;">
    {{-- Tips --}}
    <div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
        <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 Buildings</div>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">A <strong style="color:#fff;">Building</strong> is a physical structure on campus — e.g. <em>Block A</em> or <em>Science Block</em>.</p>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Buildings contain <strong style="color:#fff;">Rooms</strong> which are assigned to timetable slots.</p>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
            @php $total=count($buildings);$active=count(array_filter($buildings,fn($b)=>$b['status']==='Active'));$totalRooms=array_sum(array_column($buildings,'rooms')); @endphp
            @foreach([['Buildings',$total,'#4f46e5'],['Active',$active,'#10b981'],['Total Rooms',$totalRooms,'#f59e0b']] as [$l,$v,$c])
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
                <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
            </div>
            @endforeach
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ Flow</div>
            <p style="font-size:11px;color:#166534;line-height:1.6;margin:0;"><strong>Building</strong> → <strong>Rooms</strong> → <strong>Timetable Slots</strong></p>
        </div>
    </div>
    {{-- Cards + Table --}}
    <div style="flex:1;display:flex;flex-direction:column;gap:16px;">
        {{-- Building cards --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;">
            @foreach($buildings as $b)
            <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                <div style="font-size:11px;font-weight:800;font-family:monospace;color:#4f46e5;margin-bottom:6px;">{{ $b['code'] }}</div>
                <div style="font-size:14px;font-weight:700;color:#1e293b;margin-bottom:4px;">{{ $b['name'] }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-bottom:10px;">{{ $b['campus'] }}</div>
                <div style="display:flex;justify-content:space-between;font-size:12px;">
                    <span style="color:#64748b;">🏢 {{ $b['floors'] }} floors</span>
                    <span style="color:#4f46e5;font-weight:700;">{{ $b['rooms'] }} rooms</span>
                </div>
                <div style="margin-top:10px;">
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:9999px;font-size:10px;font-weight:700;background:{{ $b['status']==='Active'?'#d1fae5':'#fee2e2' }};color:{{ $b['status']==='Active'?'#065f46':'#991b1b' }};"><span style="width:5px;height:5px;border-radius:50%;background:{{ $b['status']==='Active'?'#10b981':'#ef4444' }};display:inline-block;"></span>{{ $b['status'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
        {{-- Table --}}
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:16px;font-weight:700;color:#1e1b4b;">{{ count($buildings) }} Buildings</span>
                <input class="form-input" style="width:220px;" placeholder="Search buildings…" type="text">
            </div>
            <table>
                <thead><tr><th>Code</th><th>Building Name</th><th>Campus</th><th>Floors</th><th>Rooms</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($buildings as $b)
                <tr>
                    <td style="font-weight:800;font-family:monospace;color:#4f46e5;">{{ $b['code'] }}</td>
                    <td style="font-weight:700;color:#1e293b;">{{ $b['name'] }}</td>
                    <td style="font-size:12px;color:#64748b;">{{ $b['campus'] }}</td>
                    <td style="font-size:13px;">{{ $b['floors'] }}</td>
                    <td><a href="/academic/rooms" style="font-weight:700;color:#4f46e5;text-decoration:none;">{{ $b['rooms'] }} <span style="font-size:11px;color:#94a3b8;font-weight:400;">rooms</span></a></td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:{{ $b['status']==='Active'?'#d1fae5':'#fee2e2' }};color:{{ $b['status']==='Active'?'#065f46':'#991b1b' }};"><span style="width:6px;height:6px;border-radius:50%;background:{{ $b['status']==='Active'?'#10b981':'#ef4444' }};display:inline-block;"></span>{{ $b['status'] }}</span></td>
                    <td><div style="display:flex;gap:6px;"><button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button><button class="btn btn-danger btn-sm">Delete</button></div></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Add --}}
<div id="modal-add" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">🏢</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">New Building</h2></div>
    <div style="display:grid;gap:14px;">
        <div><label class="form-label">Campus / Organisation <span style="color:#ef4444;">*</span></label><select class="form-select"><option>Main Campus</option><option>North Campus</option><option>South Campus</option></select></div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Building Code <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. BLK-A" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Building Name <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. Block A"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Number of Floors</label><input class="form-input" type="number" min="1" placeholder="e.g. 4"></div>
            <div><label class="form-label">Status</label><select class="form-select"><option>Active</option><option>Inactive</option></select></div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Create Building</button></div>
</div></div>
{{-- Edit --}}
<div id="modal-edit" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">✏️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">Edit Building</h2></div>
    <div style="display:grid;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Building Code</label><input class="form-input" value="BLK-A" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Building Name</label><input class="form-input" value="Block A"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Floors</label><input class="form-input" type="number" value="4"></div>
            <div><label class="form-label">Status</label><select class="form-select"><option selected>Active</option><option>Inactive</option></select></div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
</div></div>
@endsection
