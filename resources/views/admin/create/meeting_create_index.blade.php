@extends('layouts.template')

@section('content')

<style>
    .clock-timepicker {
        width: 100%;
    }

</style>

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">Tambah Rapat</h4>
                            <form action="{{ route('admin_create_meeting_store') }}" method="post">
                                @csrf
                                <div class="form-group w-25">
                                    <label for="exampleInputEmail1">Nama Rapat</label>
                                    @error('name')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <input type="text" class="form-control" name="name" value="{{  old('name') }}"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan nama rapat">
                                </div>
                                <div class="form-group date w-25 mt-3">
                                    <label for="datepicker">Tanggal Rapat</label>
                                    @error('tanggal')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <input type="date" class="form-control data full datedropper picker-input" name="tanggal"
                                     id="date-input" placeholder="Tanggal Rapat" value="{{ old('tanggal') }}">
                                     
                                </div>
                                <div class="jam row">
                                    <div class="form-group w-25 date mt-3 col-sm">
                                        <label for="timepicker">Dari Jam</label>
                                        @error('dari_jam')
                                        <div class="text-danger mt-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <input type="text" class="form-control time" value="{{  old('dari_jam') }}"
                                            name="dari_jam" id="timepicker1" placeholder="Tanggal Rapat">
                                    </div>
                                    <div class="form-group w-25 date mt-3 col-sm">
                                        <label for="timepicker">Hingga Jam</label>
                                        @error('sampai_jam')
                                        <div class="text-danger mt-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <input type="date" class="form-control time" value="{{  old('sampai_jam') }}"
                                            name="sampai_jam" id="timepicker2" placeholder="Tanggal Rapat">
                                    </div>
                                </div>
                                <div class="submit mt-3">
                                    <button class="btn btn-primary btn-submit">Simpan</button>
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


        $("#timepicker1").clockTimePicker({
            autosize: false,

        });
        $("#timepicker2").clockTimePicker({
            autosize: false,
        });
        });
    

    // new AirDatePicker('#datepicker');

</script>
@endsection
