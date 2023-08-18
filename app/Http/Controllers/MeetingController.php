<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class MeetingController extends Controller
{

    // Admin Side
        public function index() {
            return view("admin.meeting_index");
        }

        public function data(Request $request) {
            $meeting = Meeting::get();

            return datatables($meeting)
            ->addColumn('tanggal', function($row) {
                return $row->tanggal . " (" .$row->dari_jam . " - " . $row->sampai_jam . ")";
            })
            ->addColumn('action', function($row) {
                return "
                        <a href='/admin/rapat/detail/". $row->id ."'> <button class='btn btn-primary'><i class='fa fa-info-circle'></i></button></a>
                        <button class='btn btn-warning' onclick='modalEditMeeting(" . '"'.$row->name. '"' . ", ".'"'.$row->tanggal.'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.")' data-bs-toggle='modal' data-bs-target='#editMeeting'><i class='fa fa-lg fa-edit'></i></button>
                        <button class='btn btn-danger' onclick='deleteMeeting(" . $row->id . ", ".'"'.$row->name.'"'.")'><i class='fa fa-trash'></i></button>
                       ";
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

            $dari_jam = Carbon::parse($request->dari_jam);
            $sampai_jam = Carbon::parse($request->sampai_jam);

            $crash = Meeting::whereDate('tanggal', $request->tanggal)->whereTime('dari_jam', '<=', $sampai_jam)->whereTime('sampai_jam', '>=', $dari_jam)->get();

            if (count($crash) != 0) {
                return redirect()->back()->with('failed', 'Jam rapat yang anda input bertabrakan dengan jam rapat yang lain!');
            } else {
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

        public function edit_store($id, Request $request) {
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

            $dari_jam = Carbon::parse($request->dari_jam);
            $sampai_jam = Carbon::parse($request->sampai_jam);

            $meeting = Meeting::find($id);

                // dd($request->dari_jam);

            if ($meeting->tanggal === $request->tanggal && substr($meeting->dari_jam, 0, -3) == $request->dari_jam && substr($meeting->sampai_jam, 0, -3) == $request->sampai_jam) {
                $crash = [];
                // dd('sama');
            } else {
                $crash = Meeting::whereDate('tanggal', $request->tanggal)->whereTime('dari_jam', '<=', $sampai_jam)->whereTime('sampai_jam', '>=', $dari_jam)->get();
            }


            if (count($crash) != 0) {
                return redirect()->back()->with('failed-edit', 'Jam rapat yang anda input bertabrakan dengan jam rapat yang lain!');
            } else {
                $meeting->name = $request->name;
                $meeting->tanggal = Carbon::parse($request->tanggal);
                $meeting->dari_jam = $request->dari_jam;
                $meeting->sampai_jam = $request->sampai_jam;
                $meeting->pembuat = auth()->user()->name;
                $meeting->save();

                return redirect()->route('admin_meeting_index')->with('success', 'Berhasil mengedit rapat');
            }


        } 

        public function delete($id) {
            Meeting::find($id)->delete();

            return redirect()->route('admin_meeting_index')->with('success', 'Berhasil menghapus rapat');
        }
    // End of Admin Side

    // User Side
        public function user_index() {
            return view('user.meeting_index');
        }

        public function user_meeting_data(Request $request) {
            $meeting = Meeting::get();

            return datatables($meeting)
            ->addColumn('tanggal', function($row) {
                return Carbon::parse($row->tanggal)->translatedFormat('j F Y') . " (" .$row->dari_jam . " - " . $row->sampai_jam . ")";
            })
            ->addColumn('action', function($row) {
                $data = $row->users()->wherePivot('user_id', auth()->user()->id)->first();

                $now = Carbon::now();

                $test_carbon = $now->between(Carbon::parse($row->dari_jam), Carbon::parse($row->sampai_jam)->addHour(2));

                if ($row->tanggal == $now->format("Y-m-d") && $test_carbon ) {
                    
                        if ($data == null) {
                            return "
                                    <button class='btn btn-success' data-bs-target='#absenceMeeting' data-bs-toggle='modal' onclick='absenceMeeting(" . '"'.$row->name. '"' . ", ".'"'.Carbon::parse($row->tanggal)->translatedFormat("j F Y").'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.$row->pembuat.'"'.", ".'"Kosong"'.", ".'"'.false.'"'.")'>Absen</button>
                                   ";
                        }
                        if ($data->pivot->status == 1) {
                            return "
                                    <button class='btn btn-success' data-bs-target='#absenceMeeting' data-bs-toggle='modal' onclick='absenceMeeting(" . '"'.$row->name. '"' . ", ".'"'.Carbon::parse($row->tanggal)->translatedFormat("j F Y").'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.$row->pembuat.'"'.", ".'"'.$data->pivot->status.'"'.", ".'"'.$data->pivot->alasan.'"'.", ".'"'.false.'"'.")'><i class='fa fa-check'></i></button>
                                   ";
                        } elseif ($data->pivot->status == 0) {
                            return "
                                    <button class='btn btn-warning' data-bs-target='#absenceMeeting' data-bs-toggle='modal' onclick='absenceMeeting(" . '"'.$row->name. '"' . ", ".'"'.Carbon::parse($row->tanggal)->translatedFormat("j F Y").'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.$row->pembuat.'"'.", ".'"'.$data->pivot->status.'"'.", ".'"'.$data->pivot->alasan.'"'.", ".'"'.false.'"'.")'><i class='fa fa-x-twitter'></i></button>
                                   ";
                        }
                } else {
                    if ($data == null) {
                        return "
                                <button class='btn btn-warning' data-bs-target='#absenceMeeting' data-bs-toggle='modal' onclick='absenceMeeting(" . '"'.$row->name. '"' . ", ".'"'.Carbon::parse($row->tanggal)->translatedFormat("j F Y").'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.$row->pembuat.'"'.", ".'"d"'.", ".'"kosong"'.", ".'"'.true.'"'.")'>Absen</button>
                               ";
                    }
                    if ($data->pivot->status == 1) {
                        return "
                                <button class='btn btn-success' data-bs-target='#absenceMeeting' data-bs-toggle='modal' onclick='absenceMeeting(" . '"'.$row->name. '"' . ", ".'"'.Carbon::parse($row->tanggal)->translatedFormat("j F Y").'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.$row->pembuat.'"'.", ".'"'.$data->pivot->status.'"'.", ".'"'.$data->pivot->alasan.'"'.", ".'"'.false.'"'.")'><i class='fa fa-check'></i></button>
                               ";
                    } elseif ($data->pivot->status == 0) {
                        return "
                                <button class='btn btn-warning' data-bs-target='#absenceMeeting' data-bs-toggle='modal' onclick='absenceMeeting(" . '"'.$row->name. '"' . ", ".'"'.Carbon::parse($row->tanggal)->translatedFormat("j F Y").'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.$row->pembuat.'"'.", ".'"'.$data->pivot->status.'"'.", ".'"'.$data->pivot->alasan.'"'.", ".'"'.false.'"'.")'><i class='fa fa-check'></i></button>
                               ";
                    } 
                }

                
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
        }

        public function user_store(Request $request) {
            $user = User::find(auth()->user()->id);
            $meeting = Meeting::find($request->id);

            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'alasan' => 'nullable',
            ],[
                'status.required' => 'Wajib pilih satu',
                'alasan.required' => 'Alasan wajib diisi!'
            ]);

            

            if ($validator->fails()) {
                return redirect()->back()->with('status', 400);
            }
            
            $user->meetings()->attach($meeting->id, ['status' => $request->status, 'alasan' => $request->alasan]);
            return redirect()->route('user_meeting_index')->with('success', 'Berhasil melakukan absen!');
        }
    // End of User Side
    
}   
