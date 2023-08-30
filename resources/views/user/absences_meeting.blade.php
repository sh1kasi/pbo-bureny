@extends('layouts.template')

@section('title')
Absen Rapat | {{ $meeting->name }}
@endsection

@section('content')

@include('user.modal.absences_user_modal');

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Absen Rapat</h4>
                        <p id="judul_rapat">Judul Rapat: {{ $meeting->name }}</p>
                        <p id="waktu">Tanggal/jam:
                            {{ Carbon\Carbon::parse($meeting->tanggal)->translatedFormat("j F Y") }}
                            ({{ $meeting->dari_jam }} - {{ $meeting->sampai_jam }})</p>
                        <p id="pembuat">Pembuat: {{ $meeting->pembuat }}</p>
                        <hr>
                        <div class="absen">

                            @php
                                $now = Carbon\Carbon::now();
                                $check = $now->between(Carbon\Carbon::parse($meeting->dari_jam), Carbon\Carbon::parse($meeting->sampai_jam)->addHour(2));
                                
                            @endphp

                            <form action="{{ route('user_meeting_store', $id)  }}" id="presence_form" method="post">
                                @csrf
                                <input type="hidden" name="status" id="status">
                                <input type="hidden" name="alasan" id="alasan">
                                <input type="hidden" name="token" id="token">
                            </form>
                                <div class="form d-flex justify-content-evenly">
                                    <div class="form-group form-check">
                                        @if ($meeting->tanggal == $now->format("Y-m-d") && $check)
                                            <button class="btn btn-success btn-lg" value="1" id="absen-btn">Absen</button>
                                        @else
                                            <button class="btn btn-secondary btn-lg" disabled value="1" id="absen-btn">Absen</button>
                                        @endif
                                    </div>
                                    <div class="form-group form-check">
                                        <button class="btn btn-warning btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#absenceMeeting" id="izin-btn">Izin</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <form method="post" action="{{ route('user_meeting_store', $id)  }}" id="absenForm"> --}}
    {{-- @csrf --}}
    <div class="modal fade" id="absenceMeetingToken" tabindex="-1" role="dialog" aria-labelledby="absenceMeetingTokenLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="absenceMeetingTokenLabel">Masukkan Token Rapat {{ $meeting->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p class="alert alert-warning">Masukkan token rapat dengan benar!</p>
                    <hr>
                    <div class="absen">
                        {{-- <div class="form d-flex justify-content-around">
                            <div class="form-group form-check">
                                <label class="form-check-label" for="izin">Hadir</label>
                                <input class="form-check-input" type="radio" name="status" value="1" id="izin">
                            </div>
                            <div class="form-group form-check">
                                <label class="form-check-label" for="izin">Izin</label>
                                <input class="form-check-input" type="radio" name="status" value="0" id="izin">
                            </div>
                        </div> --}}
                        <div class="form-group text-box">
                            <label class="font-weight-bold" for="token">Token Rapat</label>
                            <input class="form-control" oninput="this.value = this.value.toUpperCase()" name="token" type="text" id="token_form">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn_submit"  type="button" class="btn btn-primary w-100">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <input type="hidden" name="status" id="status2"> --}}

{{-- </form> --}}

@if (Session::has('failed'))
<script>
    $(document).ready(function () {
        toastr.error('{!! session("failed") !!}', "Gagal!")
        $("#absenceMeetingToken").modal('show');
        $("#status").val(1);
        $("#btn_submit").click(function (e) { 
            e.preventDefault();
            $("#token").val($("#token_form").val());
            $("#presence_form").submit();
        });

});
</script>
@endif

<script>
    
    $(document).ready(function () {
        $("#absen-btn").click(function (e) { 
            e.preventDefault();
            $("#absenceMeetingToken").modal('show');
            $("#status").val(1);
            $("#btn_submit").click(function (e) { 
                e.preventDefault();
                $("#token").val($("#token_form").val());
                $("#presence_form").submit();
            });

            // Swal.fire({
                    // title: 'Apakah anda yakin?',
                    //   html: `<input type="text" id="login" class="swal2-input" placeholder="Username">
                        // <input type="password" id="password" class="swal2-input" placeholder="Password">`,
// 
                    // text: "Anda akan melakukan presensi!",
                    // icon: 'question',
                    // showCancelButton: true,
                    // confirmButtonColor: '#3085d6',
                    // cancelButtonColor: '#d33',
                    // confirmButtonText: 'Absen',
                    // cancelButtonText: 'Batal'
                // }).then((result) => {
                // if (result.isConfirmed) {
                    // Swal.fire({
                        // title: 'Berhasil',
                        // text: 'Anda berhasil melakukan absen',
                        // icon: 'success',
                        // timer: 2000, 
                    // }).then(function() {
    // 
                        // $("#status").val(1);
                    // })
                // }
            // })

        });
    });
</script>

@endsection
