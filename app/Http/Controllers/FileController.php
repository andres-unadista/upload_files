<?php

namespace App\Http\Controllers;

use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
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
        $files = File::whereUserId(Auth::id())->latest()->get();

        return view('files.show-files', compact('files'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayImage(string $filename)
    {
        try {
            $file = Storage::get('public/' . Auth::id(). '/'. $filename);
            $response = Response::make($file, 200);
            $response->header("Content-Type", 'image/jpeg');
            $response->header("Content-Type", 'image/png');
            return $response;
        } catch (Exception $e) {
            abort(404);
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
            $saveFile = Storage::putFileAs('/public/' . $user_id . '/', $file, $file->getClientOriginalName());
            if ($saveFile) {
                File::create([
                    'name_file' => $file->getClientOriginalName(),
                    'user_id' => $user_id,
                ]);
                Alert::success('Completado', 'Archivos cargados con éxito');
            } else {
                Alert::error('Error', 'Archivos no cargados');
            }
        }
    }
}
