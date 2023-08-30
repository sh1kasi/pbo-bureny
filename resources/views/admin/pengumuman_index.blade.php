@extends('layouts.template')

@section('content')
    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="header d-flex justify-content-between mb-4">
                                <h4 class="card-title">Master Pengumuman</h4>
                                <a href="{{ route('admin_create_pengumuman_index') }}"><button
                                        class="btn btn-success"><i class="fa fa-edit"></i> Tulis Pengumuman</button></a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pengumumanTable">
                                    <thead class="">
                                        <tr>
                                            <td>No</td>
                                            <td>Pesan</td>
                                            <td>Pembuat</td>
                                            <td>Aksi</td>
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
            $("#pengumumanTable").DataTable({
                serverSide: true,
                processing: true,
                searching: true,
                filter: true,
                pageLength: 10,
                ajax: {
                    type: "GET",
                    url: "{{ route('pengumuman_data') }}"
                },
                columns: [
                    {data: "DT_RowIndex", name: "nomor"},
                    {data: "pesan", name: "pesan"},
                    {data: "pembuat", name: "pembuat"},
                    {data: "aksi", name: "aksi"},
                ],
            });
        });
    </script>

@endsection