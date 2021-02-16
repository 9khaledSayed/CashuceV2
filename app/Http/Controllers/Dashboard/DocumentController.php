<?php

namespace App\Http\Controllers\Dashboard;

use App\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            $documents = auth()->user()->documents;
            return response()->json($documents);
        }
        return view('dashboard.documents.index');
    }


    public function create()
    {
        return view('dashboard.documents.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('public/documents/', $fileName);

        auth()->user()->documents()->create([
            'file_name' => $fileName,
        ]);

        return response()->json([
            'status' => 1
        ]);
    }

    public function download(Document $document)
    {
        return Storage::download('/public/documents/' . $document->file_name);
    }
}
