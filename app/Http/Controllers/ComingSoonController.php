<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComingSoonController extends Controller
{
    public function __invoke(Request $request)
    {
        $module = str($request->path())->title()->replace('/', ' → ')->toString();
        return view('coming-soon', compact('module'));
    }
}
