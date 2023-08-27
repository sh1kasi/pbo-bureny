@extends('layouts.template')

@section('title')
Anggota | Admin
@endsection

@section('content')
<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Anggota</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3" id="user_table">
                                <thead class="thead-dark">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="sdjfdjsjfds/" method='post' id='user_delete'>
@csrf                        
</form>   

<form action="sdfsfa/" method='post' id="user_promote">
    @csrf
</form>

@if (session()->has('success'))
    <script>
        $(document).ready(function () {
            toastr.success("{!! session('success') !!}", "Berhasil")
        });
    </script>
@endif

<script>

    function user_delete(id, url) {
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
                    $("#user_delete").attr("action", url);
                    Swal.fire(
                        'Terhapus!',
                        `User tersebut berhasil terhapus.`,
                        'success'
                        )
                    $("#user_delete").submit();
                }
            })
        });
    }

    function promote_user(id, url) {
        $(document).ready(function () {
            Swal.fire({
                title: 'Anda yakin?',
                text: "User akan berubah menjadi admin!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ubah!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#user_promote").attr("action", url);
                    Swal.fire(
                        'Berhasil!',
                        `User tersebut berhasil menjadi Admin.`,
                        'success'
                        )
                    $("#user_promote").submit();
                }
            })
        });
    }

    $(document).ready(function () {
        $("#user_table").DataTable({
            processing: true,
            serverSide: true,
            filter: true,
            searching: true,
            paging: true,
            pageLength: 10,
            ajax: {
                type: "GET",
                url: "{{ route('user_data') }}"
            },
            columns: [{
                    data: "DT_RowIndex",
                    name: "id"
                },
                {
                    data: "name",
                    name: "username"
                },
                {
                    data: "role",
                    name: "role"
                },
                {
                    data: "action",
                    name: "action"
                },
            ],
            columnDefs: [{
                "targets": 3,
                "className": "text-center w-25",
            }, ],
        });
    });

</script>


@endsection
