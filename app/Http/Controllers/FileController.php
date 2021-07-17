<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $max_size = (int) ini_get('upload_max_filesize') * 1024;
        $user_id = Auth::id();
        $files = $request->file('files');
        foreach ($files as $file) {
            if (Storage::putFileAs('/public/'.$user_id.'/', $file, $file->getClientOriginalName())) {
                File::create([
                    'name_file' => $file->getClientOriginalName(),
                    'user_id' => $user_id,
                ]);
                Alert::success('Completado', 'Archivos cargados con éxito');
            }
        }
        return back();
    }
}
