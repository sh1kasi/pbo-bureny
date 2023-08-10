<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class MeetingController extends Controller
{
    public function index() {
        return view("admin.meeting_index");

        // Testing Session
            // $meeting = Meeting::get();
        // End of Testing Session
    }

    public function data(Request $request) {
        $meeting = Meeting::get();

        return datatables($meeting)
        ->addColumn('tanggal', function($row) {
            return $row->tanggal . " (" .$row->dari_jam . " - " . $row->sampai_jam . ")";
        })
        ->addColumn('action', function($row) {
            return "a";
        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->make(true);
    }

    public function create_index() {
        return view("admin.create.meeting_create_index");
    }

    public function create_store(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'tanggal' => 'required',
            'dari_jam' => 'required',
            'sampai_jam' => 'required',
        ],[
            'name.required' => 'Kolom nama wajib diisi!',
            'tanggal.required' => 'Kolom Tanggal wajib diisi!',
            'dari_jam.required' => 'Kolom jam wajib diisi!',
            'sampai_jam.required' => 'Kolom jam wajib diisi!',
        ]);

        

            $meeting = new Meeting;
            $meeting->name = $request->name;
            $meeting->tanggal = Carbon::parse($request->tanggal);
            $meeting->dari_jam = $request->dari_jam;
            $meeting->sampai_jam = $request->sampai_jam;
            $meeting->pembuat = auth()->user()->name;
            $meeting->save();
            
            return redirect()->route('admin_meeting_index')->with('success', 'Berhasil menambahkan rapat');
        
    }
}
