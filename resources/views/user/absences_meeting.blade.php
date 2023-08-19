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
                                <div class="form d-flex justify-content-evenly">
                                    <div class="form-group form-check">
                                        @if ($meeting->tanggal == $now->format("Y-m-d") && $check)
                                            <button class="btn btn-success btn-lg" value="1" id="absen-btn">Absen</button>
                                        @else
                                            <button class="btn btn-secondary btn-lg" disabled value="1" id="absen-btn">Absen</button>
                                        @endif
                                        <input type="hidden" name="status" id="status">
                                        <input type="hidden" name="alasan" id="alasan">
                                    </div>
                                </form>
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

<script>

    $(document).ready(function () {
        $("#absen-btn").click(function (e) { 
            e.preventDefault();
            Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda akan melakukan presensi!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Absen',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Anda berhasil melakukan absen',
                        icon: 'success',
                        timer: 2000, 
                    }).then(function() {
    
                        $("#status").val(1);
                        $("#presence_form").submit();
                    })
                }
            })
        });
    });
</script>

@endsection
