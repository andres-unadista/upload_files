@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.files.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="files">Archivos</label>
                          <input type="file" class="form-control-file" name="files[]"  id="files" placeholder="archivo" aria-describedby="filesId" multiple>
                          <small id="filesId" class="form-text text-muted">Selecciona los archivos</small>
                        </div>
                        <button class="btn btn-primary float-right mt-2">Subir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
