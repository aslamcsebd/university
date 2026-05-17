@extends('layouts.academic')
@section('title', 'Room Types')
@section('heading', 'Room Types')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Type</a>
@endsection
@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Room Type</th><th>Capacity</th><th>Monthly Fee</th><th>Amenities</th><th>Rooms</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['1','Single Room',1,'$150',['Bed','Desk','Wardrobe'],12],['2','Double Room',2,'$100',['2 Beds','Desk','Wardrobe','AC'],28],['3','Triple Room',3,'$80', ['3 Beds','Desk','Fan'],15],['4','Dormitory',6,'$50', ['6 Beds','Fan'],5]] as $t)
        <tr>
            <td style="color:#94a3b8;">{{$t[0]}}</td>
            <td style="font-weight:600;">{{$t[1]}}</td>
            <td style="text-align:center;font-weight:700;">{{$t[2]}}</td>
            <td style="font-weight:700;color:#10b981;">{{$t[3]}}</td>
            <td><div style="display:flex;gap:4px;flex-wrap:wrap;">@foreach($t[4] as $a)<span style="padding:2px 6px;background:#f1f5f9;border-radius:4px;font-size:10px;color:#475569;">{{$a}}</span>@endforeach</div></td>
            <td style="text-align:center;font-weight:700;">{{$t[5]}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Room Type</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Type Name</label><input class="form-input" placeholder="e.g. Single Room"></div>
        <div><label class="form-label">Capacity (persons)</label><input type="number" class="form-input" placeholder="1"></div>
        <div><label class="form-label">Monthly Fee ($)</label><input type="number" class="form-input" placeholder="150"></div>
        <div><label class="form-label">Description</label><textarea class="form-input" rows="3" placeholder="Amenities..."></textarea></div>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
</div>
@endsection
