@extends('layouts.template')

@section('content')

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none !important;
        }
    </style>

    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                    <h4 class="card-title">Tulis Pengumuman</h4>
                                    <form action="{{ route('admin_create_pengumuman_store') }}" method="post">
                                        @csrf
                                        <label for="judul" class="form-label mb-3">Judul</label>
                                        <input type="text" name="judul" id="judul" class="form-control">
                                        <div class="trix mt-3">
                                            <label for="pengumuman" class="form-label">Pengumuman</label>
                                            <input id="pengumuman" class="mt-3" type="hidden" name="pesan">
                                            <trix-editor input="pengumuman"></trix-editor>
                                        </div>
                                        <div class="button mt-3">
                                            <button class="btn btn-success" type="submit">Submit</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#pengumuman_form',
                menubar: false,
            });
        });
    </script>

@endsection