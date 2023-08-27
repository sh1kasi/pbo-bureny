@extends('layouts.template')

@section('title')
Rapat | Admin
@endsection

@section('content')
<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="header d-flex justify-content-between mb-4">
                            <h4 class="card-title">Rapat</h4>
                            <a href="{{ route('admin_create_meeting_index') }}"><button
                                    class="btn btn-success">Tambah</button></a>
                        </div>
                        <div class="table-responsive">
                            <table class="w-100 table table-bordered mt-3" id="meeting_table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Rapat</th>
                                        <th>Tanggal/Jam Rapat</th>
                                        <th>Pembuat</th>
                                        <th>token</th>
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

<form action="/admin/rapat/delete/" method="post" id="form_delete">
    @csrf
</form>

@include('admin.modal.meeting_edit_modal')

@if (Session::has('success'))
<script>
    toastr.success('{!! session("success") !!}', "Berhasil")

</script>
@endif


<script>
    $(document).ready(function () {
        $("#meeting_table").DataTable({
            ajax: {
                type: "GET",
                url: "{{ route('meeting_data') }}"
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
                    data: "token",
                    name: "token"
                },
                {
                    data: "action",
                    name: "action"
                },
            ],
            processing: true,
            serverSide: true,
            filter: true,
            searching: true,
            language: {
                emptyTable: "Data kosong",
            },
        });

    });

    function deleteMeeting(id, name, url) {
        $(document).ready(function () {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data yang terhapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#form_delete").attr("action", url);
                    Swal.fire(
                        'Terhapus!',
                        `Rapat ${name} berhasil terhapus.`,
                        'success'
                    )
                    $("#form_delete").submit();
                }
            })
        });
    }

</script>

@endsection
