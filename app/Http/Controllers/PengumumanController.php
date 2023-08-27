<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengumumanController extends Controller
{
    public function index() {
        return view('admin.pengumuman_index');
    } 

    public function data(Request $request) {
        $pengumuman = Pengumuman::groupBy('pesan')->get();

        return datatables($pengumuman)
        ->editColumn('pesan', function($row)  use ($pengumuman){
            
            return $row->pesan;
        })
        ->addColumn('aksi', function($row) {
            return "
                    <div class='d-flex justify-content-center gap-2'>
                        <button class='btn btn-primary'><i class='fa fa-info-circle'></i></button>
                        <button class='btn btn-warning'><i class='fa fa-lg fa-edit'></i></button>
                    </div>
                   ";
        })
        ->addIndexColumn()
        ->escapeColumns([])
        ->make(true);
    }

    public function create_index() {
        return view('admin.create.pengumuman_create_index');
    }

    public function create_store(Request $request) {
        // dd($request);
        $this->validate($request, [
            "judul" => 'required',
            "pesan" => "required",
        ],[
            "judul.required" => 'Wajib isi kolom pesan!',
            "pesan.required" => "Wajib isi form pengumuman!",
        ]);


       $user = User::where('role', '!=', 'admin')->get();
        
        foreach ($user as $data) {
            $pengumuman = new Pengumuman();
            $pengumuman->user_id = $data->id;
            $pengumuman->judul = $request->judul;
            $pengumuman->pesan = $request->pesan;
            $pengumuman->pembuat = auth()->user()->name;
            $pengumuman->status = "belum_dibaca";
            $pengumuman->save();
        }
        // dd($pengumuman);
        return redirect()->route('admin_pengumuman_index')->with('success', 'Berhasil menulis pengumuman');
    }

    public function user_index() {

        $pengumuman  = Pengumuman::where('user_id', auth()->user()->id)->orderBy('status', "DESC")->get();
        $now = Carbon::now()->format("Y-m-d");
        

        return view('user.pengumuman', compact('pengumuman', 'now'));
    }

    public function markAsRead($id, Request $request) {
        $pengumuman = Pengumuman::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        $pengumuman->status = 'dibaca';
        $pengumuman->save();

        $count_dibaca = Pengumuman::where('user_id', auth()->user()->id)->where('status', 'belum_dibaca')->count();
        // dd($count_dibaca);

        return response()->json([
            'pengumuman' => $pengumuman,
            'id' => $pengumuman->id,
            'count_dibaca' => $count_dibaca,
        ]);
    }
}
