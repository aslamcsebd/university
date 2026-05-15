@extends('layouts.academic')
@section('title','Rooms')
@section('heading','Rooms')
@section('header-actions')
<button class="btn btn-primary" onclick="openModal('modal-add')">+ New Room</button>
@endsection
@section('content')
@php
$rooms = [
    ['id'=>1,'building'=>'Block A','building_code'=>'BLK-A','name'=>'Lecture Hall A','label'=>'Ground Floor','floor'=>'G','capacity'=>120,'type'=>'Lecture Hall','status'=>'Available'],
    ['id'=>2,'building'=>'Block A','building_code'=>'BLK-A','name'=>'Lecture Hall B','label'=>'Level 1','floor'=>'1','capacity'=>80,'type'=>'Lecture Hall','status'=>'Available'],
    ['id'=>3,'building'=>'Block A','building_code'=>'BLK-A','name'=>'Tutorial Room 1','label'=>'Level 2','floor'=>'2','capacity'=>30,'type'=>'Tutorial Room','status'=>'Available'],
    ['id'=>4,'building'=>'Block B','building_code'=>'BLK-B','name'=>'Computer Lab 1','label'=>'Level 2','floor'=>'2','capacity'=>40,'type'=>'Lab','status'=>'Available'],
    ['id'=>5,'building'=>'Block B','building_code'=>'BLK-B','name'=>'Computer Lab 2','label'=>'Level 2','floor'=>'2','capacity'=>40,'type'=>'Lab','status'=>'Maintenance'],
    ['id'=>6,'building'=>'Science Block','building_code'=>'SCI','name'=>'Physics Lab','label'=>'Level 1','floor'=>'1','capacity'=>30,'type'=>'Lab','status'=>'Available'],
    ['id'=>7,'building'=>'Admin Block','building_code'=>'ADM','name'=>'Seminar Room 1','label'=>'Level 3','floor'=>'3','capacity'=>25,'type'=>'Seminar Room','status'=>'Available'],
    ['id'=>8,'building'=>'Block C','building_code'=>'BLK-C','name'=>'Workshop Room','label'=>'Ground Floor','floor'=>'G','capacity'=>35,'type'=>'Workshop','status'=>'Available'],
];
$typeStyle=['Lecture Hall'=>['#eef2ff','#4338ca'],'Lab'=>['#fef9c3','#854d0e'],'Tutorial Room'=>['#d1fae5','#065f46'],'Seminar Room'=>['#f3e8ff','#6b21a8'],'Workshop'=>['#fee2e2','#991b1b']];
$statusStyle=['Available'=>['#d1fae5','#065f46','#10b981'],'Maintenance'=>['#fef9c3','#854d0e','#f59e0b'],'Unavailable'=>['#fee2e2','#991b1b','#ef4444']];
@endphp
<div style="display:flex;gap:20px;align-items:flex-start;">
    {{-- Tips --}}
    <div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
        <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 Rooms</div>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">A <strong style="color:#fff;">Room</strong> belongs to a <strong style="color:#fff;">Building</strong>. It has a name, label/floor, capacity and type.</p>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Rooms are assigned to <strong style="color:#fff;">Timetable Slots</strong>. Room name and label are copied into each slot for historical accuracy.</p>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
            @php
                $total=count($rooms);
                $avail=count(array_filter($rooms,fn($r)=>$r['status']==='Available'));
                $maint=count(array_filter($rooms,fn($r)=>$r['status']==='Maintenance'));
                $totalCap=array_sum(array_column($rooms,'capacity'));
            @endphp
            @foreach([['Total Rooms',$total,'#4f46e5'],['Available',$avail,'#10b981'],['Maintenance',$maint,'#f59e0b'],['Total Capacity',$totalCap,'#0ea5e9']] as [$l,$v,$c])
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
                <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
            </div>
            @endforeach
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ Tip</div>
            <p style="font-size:11px;color:#166534;line-height:1.6;margin:0;">Create <strong>Buildings</strong> first, then add rooms under each building with floor labels.</p>
        </div>
    </div>
    {{-- Table --}}
    <div style="flex:1;">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <span style="font-size:16px;font-weight:700;color:#1e1b4b;">{{ count($rooms) }} Rooms</span>
                <div style="display:flex;gap:10px;">
                    <select class="form-select" style="width:160px;"><option>All Buildings</option><option>Block A</option><option>Block B</option><option>Science Block</option><option>Admin Block</option></select>
                    <select class="form-select" style="width:140px;"><option>All Types</option><option>Lecture Hall</option><option>Lab</option><option>Tutorial Room</option><option>Seminar Room</option></select>
                    <select class="form-select" style="width:130px;"><option>All Statuses</option><option>Available</option><option>Maintenance</option></select>
                    <input class="form-input" style="width:160px;" placeholder="Search rooms…" type="text">
                </div>
            </div>
            <table>
                <thead><tr><th>Building</th><th>Room Name</th><th>Label / Floor</th><th>Type</th><th>Capacity</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($rooms as $r)
                @php [$bg,$tc]=$typeStyle[$r['type']]??['#f1f5f9','#374151']; [$sb,$st,$sd]=$statusStyle[$r['status']]??['#f1f5f9','#374151','#9ca3af']; @endphp
                <tr>
                    <td>
                        <div style="font-weight:700;color:#4f46e5;font-size:12px;font-family:monospace;">{{ $r['building_code'] }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $r['building'] }}</div>
                    </td>
                    <td style="font-weight:700;color:#1e293b;">{{ $r['name'] }}</td>
                    <td>
                        <span style="background:#f1f5f9;color:#475569;font-size:11px;font-weight:700;padding:3px 8px;border-radius:6px;">Floor {{ $r['floor'] }}</span>
                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">{{ $r['label'] }}</div>
                    </td>
                    <td><span style="background:{{ $bg }};color:{{ $tc }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:9999px;">{{ $r['type'] }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <div style="flex:1;max-width:60px;height:5px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{ min(100,round($r['capacity']/120*100)) }}%;background:#4f46e5;border-radius:9999px;"></div></div>
                            <span style="font-size:13px;font-weight:700;color:#1e293b;">{{ $r['capacity'] }}</span>
                        </div>
                    </td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:{{ $sb }};color:{{ $st }};"><span style="width:6px;height:6px;border-radius:50%;background:{{ $sd }};display:inline-block;"></span>{{ $r['status'] }}</span></td>
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
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">🏫</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">New Room</h2></div>
    <div style="display:grid;gap:14px;">
        <div><label class="form-label">Building <span style="color:#ef4444;">*</span></label><select class="form-select"><option>— Select Building —</option><option>Block A (BLK-A)</option><option>Block B (BLK-B)</option><option>Block C (BLK-C)</option><option>Science Block (SCI)</option><option>Admin Block (ADM)</option></select></div>
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:12px;">
            <div><label class="form-label">Room Name <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. Lecture Hall A"></div>
            <div><label class="form-label">Floor</label><input class="form-input" placeholder="e.g. G, 1, 2"></div>
        </div>
        <div><label class="form-label">Label / Description</label><input class="form-input" placeholder="e.g. Ground Floor, Near Main Entrance"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div><label class="form-label">Type</label><select class="form-select"><option>Lecture Hall</option><option>Lab</option><option>Tutorial Room</option><option>Seminar Room</option><option>Workshop</option></select></div>
            <div><label class="form-label">Capacity <span style="color:#ef4444;">*</span></label><input class="form-input" type="number" placeholder="e.g. 80"></div>
            <div><label class="form-label">Status</label><select class="form-select"><option>Available</option><option>Maintenance</option><option>Unavailable</option></select></div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Create Room</button></div>
</div></div>
{{-- Edit --}}
<div id="modal-edit" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">✏️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">Edit Room</h2></div>
    <div style="display:grid;gap:14px;">
        <div><label class="form-label">Building</label><select class="form-select"><option selected>Block A (BLK-A)</option><option>Block B (BLK-B)</option></select></div>
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:12px;">
            <div><label class="form-label">Room Name</label><input class="form-input" value="Lecture Hall A"></div>
            <div><label class="form-label">Floor</label><input class="form-input" value="G"></div>
        </div>
        <div><label class="form-label">Label</label><input class="form-input" value="Ground Floor"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div><label class="form-label">Type</label><select class="form-select"><option selected>Lecture Hall</option><option>Lab</option></select></div>
            <div><label class="form-label">Capacity</label><input class="form-input" type="number" value="120"></div>
            <div><label class="form-label">Status</label><select class="form-select"><option selected>Available</option><option>Maintenance</option></select></div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
</div></div>
@endsection
