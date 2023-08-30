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
        if (auth()->user()->role === "super_admin") {
            $user = User::where('id', '!=', auth()->user()->id)->get();
        } else {
            $user = User::where('id', '!=', auth()->user()->id)->where('role', 'user')->get();
        }
        return datatables($user)
        ->editColumn('action', function($row) {
            // $data = {'name' => $row->name, "tanggal"}
            if (auth()->user()->role === 'super_admin') {
                return "
                            <div class='d-flex gap-2'>    
                                 <button class='btn btn-danger' type='button' onclick='user_delete(".$row->id.", ".'"'.route('user_delete', $row->id).'"'.")'><i class='fa fa-trash'></i></button>
                                
                                <button class='btn btn-sm btn-info' onclick='promote_user(".$row->id.", ".'"'.route('promote_to_admin', $row->id).'"'.")' type='submit'>Jadikan Admin</button>
                            </div>
                        ";
            } else {
                return "
                            <button class='btn btn-danger' type='button' onclick='user_delete(".$row->id.", ".'"'.route('user_delete', $row->id).'"'.")'><i class='fa fa-trash'></i></button>
                        ";
            }
            
        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->make(true);
    }

    public function delete_user($id, Request $request) {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    public function promote_user($id, Request $request) {
        $user = User::find($id);
        $user->role = 'admin';
        $user->save();
        return redirect()->back()->with('success', 'Berhasil mengubah role user');
    }

}
