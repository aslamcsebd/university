@extends('layouts.academic')
@section('title', 'Content Types')
@section('heading', 'Content Types')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Type</a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Type Name</th><th>Extension</th><th>Icon</th><th>Max Size</th><th>Files</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['1','PDF Document','pdf','📄','20 MB',48,'#ef4444'],['2','Video','mp4, avi','🎬','500 MB',12,'#6366f1'],['3','PowerPoint','ppt, pptx','📊','50 MB',24,'#f59e0b'],['4','Word Document','doc, docx','📝','10 MB',36,'#0ea5e9'],['5','Image','jpg, png','🖼️','5 MB',20,'#10b981'],['6','Audio','mp3, wav','🎵','50 MB',8,'#8b5cf6']] as $t)
        <tr>
            <td style="color:#94a3b8;">{{$t[0]}}</td>
            <td style="font-weight:600;">{{$t[1]}}</td>
            <td><span style="padding:2px 8px;background:#f1f5f9;border-radius:4px;font-size:11px;font-family:monospace;color:#475569;">{{$t[2]}}</span></td>
            <td style="font-size:20px;">{{$t[3]}}</td>
            <td style="color:#64748b;">{{$t[4]}}</td>
            <td style="text-align:center;font-weight:700;color:{{$t[6]}};">{{$t[5]}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Content Type</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Type Name</label><input class="form-input" placeholder="e.g. PDF Document"></div>
        <div><label class="form-label">Allowed Extensions</label><input class="form-input" placeholder="e.g. pdf, PDF"></div>
        <div><label class="form-label">Max File Size (MB)</label><input type="number" class="form-input" placeholder="20"></div>
        <div><label class="form-label">Icon (emoji)</label><input class="form-input" placeholder="📄"></div>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
</div>
@endsection
