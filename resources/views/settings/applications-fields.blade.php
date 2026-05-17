@extends('layouts.academic')
@section('title', 'Application Field Settings')
@section('heading', 'Application Field Settings')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Field</a>
@endsection
@section('content')
@php
$fields = [
    ['id'=>1,'label'=>'Applicant Name',  'type'=>'Text',    'required'=>true, 'visible'=>true],
    ['id'=>2,'label'=>'Email',           'type'=>'Email',   'required'=>true, 'visible'=>true],
    ['id'=>3,'label'=>'Phone',           'type'=>'Phone',   'required'=>true, 'visible'=>true],
    ['id'=>4,'label'=>'Course Applied',  'type'=>'Select',  'required'=>true, 'visible'=>true],
    ['id'=>5,'label'=>'Previous Grades', 'type'=>'Text',    'required'=>true, 'visible'=>true],
    ['id'=>6,'label'=>'Statement',       'type'=>'Textarea','required'=>false,'visible'=>true],
    ['id'=>7,'label'=>'Documents',       'type'=>'File',    'required'=>false,'visible'=>true],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Label</th><th>Type</th><th>Required</th><th>Visible</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($fields as $f)
        <tr>
            <td style="color:#64748b;">{{$f['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$f['label']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$f['type']}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$f['required']?'#fee2e2':'#f1f5f9'}};color:{{$f['required']?'#991b1b':'#64748b'}};">{{$f['required']?'Yes':'No'}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$f['visible']?'#d1fae5':'#f1f5f9'}};color:{{$f['visible']?'#065f46':'#64748b'}};">{{$f['visible']?'Yes':'No'}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
