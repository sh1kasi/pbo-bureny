@extends('layouts.template')

@section('title')
    Detail Rapat | {{ $meeting->name }}
@endsection

@section('content')
    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Detail Rapat</h4>
                            <p id="judul_rapat">Judul Rapat: {{ $meeting->name }}</p>
                            <p id="waktu">Tanggal/jam:
                            {{ Carbon\Carbon::parse($meeting->tanggal)->translatedFormat("j F Y") }}
                            ({{ $meeting->dari_jam }} - {{ $meeting->sampai_jam }})</p>
                            <p id="pembuat">Pembuat: {{ $meeting->pembuat }}</p>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="detailMeetingTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // console.log({{ $id }});
            var id = {{ $id }}
            $("#detailMeetingTable").DataTable({
                processing: true,
                serverSide: true,
                search: true,
                filter: true,
                language: {
                    emptyTable: "Belum ada yang melakukan absen pada rapat ini",
                },
                ajax: {
                    type: "GET",
                    url: `{{ route('detail_meeting_data', $id) }}`
                },
                columns: [
                    {data: "DT_RowIndex", name: "nomor"},
                    {data: "name", name: "name"},
                    {data: "status", name: "status"},
                ],
                columnDefs: [
                    {className: "text-center", "targets": [2]},
                ],
            });
        });
    </script>
@endsection