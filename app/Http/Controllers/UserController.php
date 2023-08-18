<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {

        $member = User::get();

        return view("admin.member_index", compact('member'));
    }

    public function data() {
        $user = User::get();
        return datatables($user)
        ->addColumn('action', function($row) {
            // $data = {'name' => $row->name, "tanggal"}
            return "
                        <a href='/admin/anggota/edit/". $row->id ."'> <button class='btn btn-warning'><i class='fa fa-edit'></i></button></a>
                        <a href='/admin/anggota/delete/". $row->id ."'><button class='btn btn-danger'><i class='fa fa-trash'></i></button></a>
                        <a href='/admin/anggota/detail/". $row->id ."'><button class='btn btn-primary'><i class='fa fa-lg fa-info-circle'></i></button></a>
                    ";
        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->make(true);
    }

}
