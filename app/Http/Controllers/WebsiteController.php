<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::all();
        return view('websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'url' => 'required|string|max:255',
            'product_url' => 'required|string|max:255',
            'title' => 'nullable',
            'description' => 'nullable',
            'price' => 'nullable',
            'image' => 'nullable',

        ]);

        $division = Website::create($data);

        return redirect()->route('websites.index', $division->name)->with('success', 'Website created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $website = Website::findOrFail($id);
        $website->delete();

        return redirect()
            ->route('websites.index')
            ->with('success', 'website deleted successfully!');
    }
}
