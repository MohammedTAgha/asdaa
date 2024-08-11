<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:100240', // Example validation
        ]);

        $filePath = $request->file('file')->store('uploads', 'public');
        
        $file = new File();
        $file->name = $request->file('file')->getClientOriginalName();
        $file->path = $filePath;
        $file->uploaded_by = auth()->id();
        $file->hidden = $request->input('hidden', false);
        $file->save();
        
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function index()
    {
        $files = File::query()
            ->when(auth()->user()->role !== 'Super Admin', function ($query) {
                $query->where('hidden', false);
            })
            ->get();

        return view('files.index', compact('files'));
    }

    public function show(File $file)
    {
        if ($file->hidden && auth()->user()->role !== 'Super Admin') {
            abort(403);
        }

        return response()->download(storage_path('app/public/' . $file->path));
    }
}
