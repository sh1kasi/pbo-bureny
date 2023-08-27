@extends('layouts.template')

@section('title')
    Dashboard
@endsection

@section('content')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col-md-6">
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <h4>Jumlah Anggota: &nbsp; {{ $count_user }}</h4>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <h4>Total Rapat: &nbsp; {{ $count_meeting }}</h4>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title">Rapat yang akan datang: </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Rapat</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($incoming_meeting as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{  $item->tanggal }} ({{ $item->dari_jam }} - {{ $item->sampai_jam }})</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" align="center">Data Kosong</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    
@endsection