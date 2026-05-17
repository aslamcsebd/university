@extends('layouts.academic')
@section('title', 'Book List')
@section('heading', 'Book List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Book</a>
@endsection
@section('content')
@php
$books = [
    ['id'=>'BK-001','title'=>'Introduction to Algorithms','author'=>'Cormen et al.','category'=>'CS',      'copies'=>5,'available'=>3,'status'=>'Available'],
    ['id'=>'BK-002','title'=>'Data Structures',           'author'=>'Weiss',        'category'=>'CS',      'copies'=>4,'available'=>4,'status'=>'Available'],
    ['id'=>'BK-003','title'=>'Database Systems',          'author'=>'Ramakrishnan', 'category'=>'CS',      'copies'=>3,'available'=>1,'status'=>'Available'],
    ['id'=>'BK-004','title'=>'Principles of Economics',   'author'=>'Mankiw',       'category'=>'Commerce','copies'=>6,'available'=>6,'status'=>'Available'],
    ['id'=>'BK-005','title'=>'Operating Systems',         'author'=>'Tanenbaum',    'category'=>'CS',      'copies'=>2,'available'=>0,'status'=>'Unavailable'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Copies</th><th>Available</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($books as $b)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$b['id']}}</td>
            <td style="font-weight:600;">{{$b['title']}}</td>
            <td style="color:#64748b;">{{$b['author']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$b['category']}}</span></td>
            <td style="text-align:center;font-weight:700;">{{$b['copies']}}</td>
            <td style="text-align:center;font-weight:700;color:{{$b['available']>0?'#10b981':'#ef4444'}};">{{$b['available']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$b['status']==='Available'?'#d1fae5':'#fee2e2'}};color:{{$b['status']==='Available'?'#065f46':'#991b1b'}};">{{$b['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
