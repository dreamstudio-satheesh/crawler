<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenderController extends Controller
{
    /**
     * Display a listing of the tender.
     */
    public function index()
    {
        $tenders = Tender::all();
        return view('tenders.index', compact('tenders'));
    }

    /**
     * Show the form for creating a new tender.
     */
    public function create()
    {
        return view('tenders.create');
    }

    /**
     * Store a newly created tender in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $data=$request->validate([
            'document' => 'required|mimes:pdf,xlxs,xlx,docx,doc,csv,txt|max:16384',
            'name' => 'required|string',
            'estimate_amount' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',

        ]);

        if ($request->hasFile('document')) {
            $fileName =  $request->document->getClientOriginalName();
            $filePath = 'uploads/' . $fileName;
            $path = Storage::disk('public')->put($filePath, file_get_contents($request->file('document')));
            $path = Storage::disk('public')->url($path);

            $data['file_name'] = $fileName;
            $data['file_path'] = $filePath;


            Tender::create($data);
        }

        return redirect()
            ->route('tenders.index')
            ->with('success', 'Tender created successfully!');
    }

    /**
     * Remove the specified tender from storage.
     *
     * @param  \App\Models\Tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tender = Tender::findOrFail($id);
        $tender->delete();

        return redirect()
            ->route('tenders.index')
            ->with('success', 'Tender deleted successfully!');
    }
}
