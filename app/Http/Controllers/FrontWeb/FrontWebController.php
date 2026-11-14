<?php

namespace App\Http\Controllers\FrontWeb;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\FrontNews;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontWebController extends Controller
{
    public function slidersIndex()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('frontweb.sliders', compact('sliders'));
    }

    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|string|max:500',
            'order'    => 'nullable|integer|min:0',
            'image'    => 'nullable|image|max:5120',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('frontweb/sliders', 'public');
        }
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order']     = $validated['order'] ?? Slider::max('order') + 1;
        Slider::create($validated);
        return back()->with('success', 'Slider added.');
    }

    public function destroySlider(Slider $slider)
    {
        $slider->delete();
        return back()->with('success', 'Slider deleted.');
    }

    public function newsIndex()
    {
        $news = FrontNews::with('author')->latest()->paginate(20);
        return view('frontweb.news', compact('news'));
    }

    public function storeNews(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:500',
            'body'         => 'required|string',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);
        $validated['slug']        = Str::slug($validated['title']) . '-' . time();
        $validated['author_id']   = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', false);
        $validated['published_at'] = $validated['published_at'] ?? ($validated['is_published'] ? now() : null);
        FrontNews::create($validated);
        return back()->with('success', 'News article created.');
    }

    public function destroyNews(FrontNews $news)
    {
        $news->delete();
        return back()->with('success', 'News deleted.');
    }

    public function pagesIndex()
    {
        return view('frontweb.pages');
    }

    // Public front website
    public function publicHome()
    {
        $sliders   = Slider::where('is_active', true)->orderBy('order')->take(10)->get();
        $news      = FrontNews::where('is_published', true)->latest('published_at')->take(6)->get();
        $events    = \App\Models\Event::where('is_published', true)->where('start_at', '>=', now())->orderBy('start_at')->take(4)->get();
        $programs  = \App\Models\Program::where('is_active', true)->with('department')->take(8)->get();
        $university = \App\Models\University::current();
        return view('public.home', compact('sliders', 'news', 'events', 'programs', 'university'));
    }
}
