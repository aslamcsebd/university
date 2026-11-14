<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsController extends Controller
{
    public function index()
    {
        $university = University::current();
        $settings   = Setting::getGroup('general');
        return view('settings.general', compact('university', 'settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'short_name'      => 'nullable|string|max:50',
            'tagline'         => 'nullable|string|max:255',
            'email'           => 'nullable|email',
            'phone'           => 'nullable|string|max:30',
            'address'         => 'nullable|string',
            'website'         => 'nullable|url',
            'established_at'  => 'nullable|date',
            'timezone'        => 'required|string',
            'currency'        => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'logo'            => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        $university = University::current() ?? new University();

        if ($request->hasFile('logo')) {
            if ($university->logo) {
                Storage::disk('public')->delete($university->logo);
            }
            $validated['logo'] = $request->file('logo')->store('university', 'public');
        }

        $university->fill($validated)->save();

        Setting::setMany([
            'general.university_name' => $validated['name'],
            'general.tagline'         => $validated['tagline'] ?? '',
            'general.timezone'        => $validated['timezone'],
            'general.currency'        => $validated['currency'],
            'general.currency_symbol' => $validated['currency_symbol'],
        ], 'general');

        return back()->with('success', 'Settings updated successfully.');
    }
}
