@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('IMPORT CSV FILE') }}</div>

                    <div class="card-body">
                        <span>{{ session('status') }}</span>
                        <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Import csv file') }}</label>
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required autocomplete="name" autofocus>
                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Import') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
