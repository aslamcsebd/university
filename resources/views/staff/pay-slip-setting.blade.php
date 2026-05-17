@extends('layouts.academic')
@section('title', 'Pay Slip Setting')
@section('heading', 'Pay Slip Setting')
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ Pay Slip Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div><label class="form-label">Institution Name</label><input class="form-input" value="Academy University"></div>
        <div><label class="form-label">Institution Address</label><textarea class="form-input" rows="2">123 University Road, City</textarea></div>
        <div><label class="form-label">Logo URL</label><input class="form-input" placeholder="https://..."></div>
        <div><label class="form-label">Footer Note</label><textarea class="form-input" rows="2">This is a computer generated pay slip.</textarea></div>
        <div>
            <label class="form-label">Show Fields</label>
            <div style="display:flex;flex-direction:column;gap:6px;margin-top:6px;">
                @foreach(['Basic Salary','Allowances','Deductions','Tax','Net Pay','Bank Details','Signature'] as $item)
                <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> {{$item}}</label>
                @endforeach
            </div>
        </div>
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">Pay Slip Preview</div>
    <div style="border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;">
        <div style="background:#1e1b4b;padding:14px 18px;"><div style="font-size:13px;font-weight:800;color:#fff;">🎓 Academy University</div><div style="font-size:10px;color:#a5b4fc;margin-top:2px;">Pay Slip — July 2025</div></div>
        <div style="padding:14px 18px;font-size:12px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
                @foreach([['Employee','Dr. Mitchell'],['ID','STF-001'],['Designation','Professor'],['Department','CS'],['Month','July 2025'],['Bank A/C','****4521']] as $f)
                <div><div style="color:#94a3b8;font-size:10px;">{{$f[0]}}</div><div style="font-weight:600;color:#1e293b;">{{$f[1]}}</div></div>
                @endforeach
            </div>
            <div style="border-top:1px dashed #e2e8f0;padding-top:10px;">
                @foreach([['Basic Salary','$5,000'],['Allowance','+$800'],['Tax','-$300'],['Net Pay','$5,500']] as $r)
                <div style="display:flex;justify-content:space-between;padding:4px 0;{{$r[0]==='Net Pay'?'font-weight:800;border-top:1px solid #e2e8f0;margin-top:4px;padding-top:8px;':''}}"><span style="color:#64748b;">{{$r[0]}}</span><span style="font-weight:600;color:#1e293b;">{{$r[1]}}</span></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
@endsection
