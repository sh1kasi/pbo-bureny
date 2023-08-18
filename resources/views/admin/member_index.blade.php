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

<script>
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
