@extends('layouts.academic')
@section('title', 'Tax Settings')
@section('heading', 'Tax Settings')
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ Tax Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div><label class="form-label">Tax Name</label><input class="form-input" value="Income Tax"></div>
        <div><label class="form-label">Tax Rate (%)</label><input type="number" class="form-input" value="10"></div>
        <div><label class="form-label">Tax Type</label><select class="form-select"><option>Percentage</option><option>Fixed Amount</option></select></div>
        <div><label class="form-label">Apply To</label><select class="form-select"><option>All Staff</option><option>Professors Only</option><option>Lecturers Only</option></select></div>
        <div><label class="form-label">Minimum Taxable Salary</label><input type="number" class="form-input" value="2000"></div>
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;font-size:14px;font-weight:700;color:#1e1b4b;">Tax Slabs</div>
    <table>
        <thead><tr><th>Salary Range</th><th>Tax Rate</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['$0 – $2,000','0%'],['$2,001 – $4,000','5%'],['$4,001 – $6,000','10%'],['$6,001+','15%']] as $t)
        <tr>
            <td style="font-weight:600;">{{$t[0]}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$t[1]}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
