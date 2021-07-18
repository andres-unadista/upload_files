@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Listado de archivos') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre archivo</th>
                                <th>Ver</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td scope="row">{{ $file->name_file }}</td>
                                    <td><a target="_blank" href="{{ route('files.displayImage', $file->id) }}" class="btn btn-outline-secondary">Ver</a> </td>
                                    <td><a href="storage/{{ $file->user_id }}/{{ $file->name_file }}" class="btn btn-outline-danger">Eliminar</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
