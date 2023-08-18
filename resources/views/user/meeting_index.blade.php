@extends('layouts.template')

@section('title')
    Rapat
@endsection

@section('content')
    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Absen Rapat</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="meeting_user_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Nama Rapat</th>
                                                <th>Tanggal/Jam Rapat</th>
                                                <th>Pembuat</th>
                                                <th>Aksi</th>
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
    </div>

    @include('user.modal.absences_user_modal')

    <script>
        $(document).ready(function () {
            $("#meeting_user_table").DataTable({
                serverSide: true,
                processing: true,
                filter: true,
                searching: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('user_meeting_data') }}"
                },
                columns: [{
                    data: "DT_RowIndex",
                    name: "id"
                },
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "tanggal",
                    name: "date"
                },
                {
                    data: "pembuat",
                    name: "pembuat"
                },
                {
                    data: "action",
                    name: "Paction"
                },
            ],
            columnDefs: [
                {className: 'd-flex justify-content-center', targets:4}
            ]
            });
        });
    </script>
@endsection