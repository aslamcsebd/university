<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Models\ContentType;
use Illuminate\Http\Request;

class ContentTypeController extends Controller
{
    public function index()
    {
        $types = ContentType::withCount('contents')->orderBy('name')->get();
        return view('study.content-types', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:content_types,name',
            'icon'        => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
        ]);
        ContentType::create($data);
        return back()->with('success', 'Content type added.');
    }

    public function update(Request $request, ContentType $contentType)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:content_types,name,' . $contentType->id,
            'icon'        => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
        ]);
        $contentType->update($data);
        return back()->with('success', 'Content type updated.');
    }

    public function destroy(ContentType $contentType)
    {
        if ($contentType->contents()->exists()) {
            return back()->with('error', 'Cannot delete type with content.');
        }
        $contentType->delete();
        return back()->with('success', 'Content type deleted.');
    }
}
