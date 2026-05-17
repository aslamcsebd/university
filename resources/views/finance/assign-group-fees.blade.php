@extends('layouts.academic')
@section('title', 'Assign Group Fees')
@section('heading', 'Assign Group Fees')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Course</label>
                <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                    <option>Select Course</option>
                    <option>B.Sc Computer Science</option>
                    <option>B.Com</option>
                    <option>MBA</option>
                </select>
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Semester</label>
                <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                    <option>Select Semester</option>
                    <option>Semester 1</option>
                    <option>Semester 2</option>
                    <option>Semester 3</option>
                </select>
            </div>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Fees Type</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>Select Fees Type</option>
                <option>Tuition Fee</option>
                <option>Exam Fee</option>
                <option>Library Fee</option>
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Amount ($)</label>
                <input type="number" placeholder="0.00" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Due Date</label>
                <input type="date" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Assign to Group</button>
    </form>
</div>
@endsection
