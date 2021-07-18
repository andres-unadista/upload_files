<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $files = File::whereUserId(Auth::id())->latest()->get();

        return view('files.show-files', compact('files'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayImages(File $file = null)
    {
        if (isset($file) && ($file->user_id === Auth::id())) {
            return redirect('storage/' . Auth::id() . '/' . $file->name_file);
        } else {
            abort(403);
        }
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
        if ($request->hasFile('files')) {
            $this->saveFile($files, $user_id);
        } else {
            Alert::error('Error', 'Debe subir uno o más archivos');
        }
        return back();
    }

    public function saveFile(array $files, string $user_id): void
    {
        foreach ($files as $file) {
            $nameOriginalFile = (explode('.', $file->getClientOriginalName()))[0];
            $fileName = time() . Str::slug($nameOriginalFile) . '.' . $file->getClientOriginalExtension();
            $saveFile = Storage::putFileAs('/public/' . $user_id . '/', $file, $fileName);
            if ($saveFile) {
                File::create([
                    'name_file' => $fileName,
                    'user_id' => $user_id,
                ]);
                Alert::success('Completado', 'Archivos cargados con éxito');
            } else {
                Alert::error('Error', 'Archivos no cargados');
            }
        }
    }
}
