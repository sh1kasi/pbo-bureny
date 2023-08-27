@extends('layouts.template')

@section('title')
Pengumuman
@endsection

@section('content')

<style>
    .card-pengumuman:hover {
        cursor: pointer;
    }

</style>

@php
use Carbon\Carbon;

@endphp
{{-- @if (is_null($_GET))
    @dd('onok')    
@else
    @dd('kosong')
@endif --}}

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <h4 class="mb-3">Pengumuman</h4>
                @forelse ($pengumuman as $data)
                {{-- @dd($data->created_at->diffForHumans()) --}}
                <div id="read_border_{{$data->id}}" onclick="markAsRead({{ $data->id }}, '{{ route('read_pengumuman', $data->id) }}')" class="card border {{ $data->status === 'belum_dibaca' ? 'border-primary' : 'border-secondary' }} mb-2 text-dark rounded-2 card-pengumuman">

                    <div id="read_bg_{{ $data->id }}" class="card-body fs-5 d-flex justify-content-between"
                        style="{{ $data->status === 'belum_dibaca' ? 'background-color: #e4f0ff' : '' }}">
                        @if ($data->status === "belum_dibaca")
                        <span id="notif_{{ $data->id }}"
                            class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"
                            style="background-color: red !important">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                        @endif
                        <span class="m-0">{{ $data->judul }}</span>
                        <span>
                            @if ($now === $data->created_at->translatedFormat("Y-m-d"))
                            Hari ini, {{ $data->created_at->translatedFormat("H:i") }}
                            @elseif (Carbon::yesterday()->format("Y-m-d") ===
                            $data->created_at->translatedFormat("Y-m-d"))
                            Kemarin, {{ $data->created_at->translatedFormat("H:i") }}
                            @else
                            {{ $data->created_at->translatedFormat("m/d/Y") }}
                            {{ $data->created_at->translatedFormat("H:i") }}
                            @endif
                        </span>
                    </div>

                </div>
                @empty
                <div class="text-center fs-4">Pengumuman Kosong</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

{{-- Start Modal --}}
<div class="modal fade" id="detailPengumuman" tabindex="-1" role="dialog" aria-labelledby="detailPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title col-12 text-center" id="detailPengumumanLabel">ACARA PENGUMUMAN</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body" id="pengumuman-content">

        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
{{-- End Modal --}}

<script>

    // $(document).ready(function () {
    //     window.url_get = new URLSearchParams(location.search);
    //     let idFromNavbar = url_get.get('id');
    //     // let urlFromNavbar = `pengumuman/read/${idFromNavbar}`
    //     if (idFromNavbar != null) {
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

    //         $.ajax({
    //             type: "post",
    //             url: `pengumuman/read/${idFromNavbar}`,
    //             data: {
    //                 id: idFromNavbar
    //             },
    //             dataType: "json",
    //             success: function (response) {
    //                 $("#detailPengumuman").modal('show');

    //                 $("#detailPengumumanLabel").html("");
    //                 $("#detailPengumumanLabel").html(response.pengumuman.judul);
    //                 $("#pengumuman-content").html("");
    //                 let html = response.pengumuman.pesan
    //                 $("#pengumuman-content").html(html);
                    
    //                 var count_sidebar = response.count_dibaca;
    //                 // console.log(count_sidebar);

    //                 if (count_sidebar > 0) {
    //                     $("#sidebar_notif").html(count_sidebar);
    //                 } else {
    //                     $("#sidebar_notif").addClass('d-none');
    //                 }

    //                 console.log($("#notif_" + idFromNavbar).html());

    //                 $("#notif_" + idFromNavbar).addClass('d-none');
    //                 $("#read_border_" + idFromNavbar).removeClass('border-primary');
    //                 $("#read_border_" + idFromNavbar).addClass('border-secondary');
    //                 $("#read_bg_" + idFromNavbar).attr("style", "background-color: #ffffff");

    //             }
    //         });
    //     }
    // });
    

    function markAsRead(id, url) {
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: url,
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    $("#detailPengumuman").modal('show');

                    $("#detailPengumumanLabel").html("");
                    $("#detailPengumumanLabel").html(response.pengumuman.judul);
                    $("#pengumuman-content").html("");
                    let html = response.pengumuman.pesan
                    $("#pengumuman-content").html(html);
                    
                    var count_sidebar = response.count_dibaca;

                    if (count_sidebar > 0) {
                        $("#sidebar_notif").html(count_sidebar);
                    } else {
                        $("#sidebar_notif").addClass('d-none');
                    }


                    $("#notif_" + response.id).addClass('d-none');
                    $("#navbar_notif_" + response.id).addClass('d-none');
                    $("#read_border_" + id).removeClass('border-primary');
                    $("#read_border_" + id).addClass('border-secondary');
                    $("#read_bg_" + id).attr("style", "background-color: #ffffff");
                    $("#navbar_read_bg_" + id).attr("style", "background-color: #ffffff");

                }
            });

        });
    }

</script>
@endsection
