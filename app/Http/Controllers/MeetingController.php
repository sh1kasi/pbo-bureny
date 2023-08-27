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
                return Carbon::parse($row->tanggal)->translatedFormat("j F Y") . " (" .$row->dari_jam . " - " . $row->sampai_jam . ")";
            })
            ->editColumn('action', function($row) {
                $now = Carbon::now();
                $start_hour_date = Carbon::parse($row->tanggal ." ". $row->dari_jam);
                $can_edit_check = $now->lessThan($start_hour_date);
                if ($can_edit_check) {
                    return "
                            <div class='d-flex justify-content-center gap-2'>
                                <a href='". route('detail_meeting', $row->id) ."'> <button class='btn btn-primary'><i class='fa fa-info-circle'></i></button></a>
                                <button class='btn btn-warning' onclick='modalEditMeeting(" . '"'.$row->name. '"' . ", ".'"'.$row->tanggal.'"'.", ".'"'.$row->token.'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.route('admin_edit_meeting_store', $row->id).'"'.")' data-bs-toggle='modal' data-bs-target='#editMeeting'><i class='fa fa-lg fa-edit'></i></button>
                                <button class='btn btn-danger' onclick='deleteMeeting(" . $row->id . ", ".'"'.$row->name.'"'.", ".'"'.route('admin_meeting_delete', $row->id).'"'.")'><i class='fa fa-trash'></i></button>
                            </div>
                           ";
                } else {
                    return "
                            <div class='d-flex justify-content-center gap-2'>
                                <a href='". route('detail_meeting', $row->id) ."'> <button class='btn btn-primary'><i class='fa fa-info-circle'></i></button></a>
                                <button class='btn btn-warning' disabled onclick='modalEditMeeting(" . '"'.$row->name. '"' . ", ".'"'.$row->tanggal.'"'.", ".'"'.$row->token.'"'.", ".'"'. $row->id .'"'.",   ".'"'.$row->dari_jam.'"'.", ".'"'.$row->sampai_jam.'"'.", ".'"'.route('admin_edit_meeting_store', $row->id).'"'.")' data-bs-toggle='modal' data-bs-target='#editMeeting'><i class='fa fa-lg fa-edit'></i></button>
                                <button class='btn btn-danger' onclick='deleteMeeting(" . $row->id . ", ".'"'.$row->name.'"'.", ".'"'.route('admin_meeting_delete', $row->id).'"'.")'><i class='fa fa-trash'></i></button>
                            </div>
                           ";
                }
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
                'token' => 'required',
                'dari_jam' => 'required',
                'sampai_jam' => 'required',
            ],[
                'name.required' => 'Kolom nama wajib diisi!',
                'tanggal.required' => 'Kolom Tanggal wajib diisi!',
                'dari_jam.required' => 'Kolom jam wajib diisi!',
                'sampai_jam.required' => 'Kolom jam wajib diisi!',
                'token.required' => 'Kolom token wajib diisi!'
            ]);

            // dd($request);
            $tanggal_start_jam = Carbon::parse($request->tanggal ."". $request->dari_jam);
            $tanggal = Carbon::parse($request->tanggal)->format("Y-m-d");
            $now = Carbon::now();
            // dd($tanggal_start_jam);
            // dd($now->lessThanOrEqualTo($tanggal_start_jam));

            if ($request->sampai_jam <= $request->dari_jam || $tanggal_start_jam->lessThanOrEqualTo($now)) {
                // dd('asdf');
                return redirect()->back()->with('failed', 'Jam rapat yang ada masukkan tidak valid')->withInput();
            } else {
                $dari_jam = Carbon::parse($request->dari_jam);
                $sampai_jam = Carbon::parse($request->sampai_jam);
                $crash = Meeting::whereDate('tanggal', $tanggal)->whereTime('dari_jam', '<=', $sampai_jam)->whereTime('sampai_jam', '>=', $dari_jam)->get();
                // $crash = Meeting::whereDate('tanggal', $tanggal)->whereTime('dari_jam', '<=', $dari_jam)->whereTime('sampai_jam', '>=', $sampai_jam)->get();

                // dd($crash);
    
                if (count($crash) != 0) {
                    return redirect()->back()->with('failed', 'Jam rapat yang anda input bertabrakan dengan jam rapat yang lain!');
                } else {
                    $meeting = new Meeting;
                    $meeting->name = $request->name;
                    $meeting->tanggal = Carbon::parse($request->tanggal);
                    $meeting->token = $request->token;
                    $meeting->dari_jam = $request->dari_jam;
                    $meeting->sampai_jam = $request->sampai_jam;
                    $meeting->pembuat = auth()->user()->name;
                    $meeting->save();
    
                    return redirect()->route('admin_meeting_index')->with('success', 'Berhasil menambahkan rapat');
            }

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

            // dd($request);

            $dari_jam = Carbon::parse($request->dari_jam);
            $sampai_jam = Carbon::parse($request->sampai_jam);
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');

            $tanggal_start_jam = Carbon::parse($request->tanggal ."". $request->dari_jam);
            // $tanggal = Carbon::parse($request->tanggal)->format("Y-m-d");
            $now = Carbon::now();


            $meeting = Meeting::find($id);

                // dd($request->dari_jam);

            if ($meeting->tanggal === $tanggal && substr($meeting->dari_jam, 0, -3) == $request->dari_jam && substr($meeting->sampai_jam, 0, -3) == $request->sampai_jam) {
                $crash = [];
                // dd('sama');
            } else {
                $crash = Meeting::where('id', '!=', $meeting->id)->whereDate('tanggal', $tanggal)->whereTime('dari_jam', '<=', $sampai_jam)->whereTime('sampai_jam', '>=', $dari_jam)->get();
            }

            if ($request->sampai_jam <= $request->dari_jam || $tanggal_start_jam->lessThanOrEqualTo($now)) {
                return redirect()->back()->with('failed-edit', 'Jam rapat yang anda masukkan tidak valid!')->with('failed_url_form', route('admin_edit_meeting_store', $meeting->id))->withInput();
            }



            if (count($crash) != 0) {
                return redirect()->back()->with('failed-edit', 'Jam rapat yang anda input bertabrakan dengan jam rapat yang lain!')->withInput();
            } else {
                $meeting->name = $request->name;
                $meeting->tanggal = Carbon::parse($request->tanggal);
                $meeting->token = $request->token;
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

        public function detail_meeting($id) {
            $meeting = Meeting::find($id);

            return view('admin.detail_meeting_index', compact('meeting', 'id'));
        }

        public function detail_meeting_data($id) {
            $meeting = Meeting::find($id);
            $user_meeting = $meeting->users()->get();
            
            return datatables($user_meeting)
            ->addColumn('name', function($row) {
                $user = User::where('id', $row->pivot->user_id)->first();
                return $user->name;
            })
            ->addColumn('status', function($row) {
                if ($row->pivot->status == 1) {
                    return "<span class='alert alert-success'>Hadir</span>";
                } else {
                    return "<span class='alert alert-warning'>Izin (" . $row->pivot->alasan . ")</span>";
                }
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);

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
            ->addColumn('status', function($row) {
                $data = $row->users()->wherePivot('user_id', auth()->user()->id)->first();
                // dd($data);
                // return $data->pivot->status;
                if ($data == null) {
                    return "<p class='text-center'>-</p>";
                } elseif ($data->pivot->status == 1) {
                    return "<p class='alert alert-success text-center'>Hadir</p>";
                } elseif ($data->pivot->status == 0) {
                    return "<p class='alert alert-warning text-center'>Izin (" .$data->pivot->alasan . ")</p>";
                }
            })
            ->editColumn('action', function($row) {

                $data = $row->users()->wherePivot('user_id', auth()->user()->id)->first();
                $start_hour_date = Carbon::parse($row->tanggal ." ". $row->dari_jam);
                $end_hour_date = Carbon::parse($row->tanggal ." ". $row->sampai_jam);

                $now = Carbon::now();
                $can_edit_check = $now->lessThan($end_hour_date->addHour(2));


                // return is_null($data);

                // dd($can_edit_check);

                // if ($data->pivot->status == 0) {
                //     return "
                //     <div class='d-flex gap-2'>
                //         <a href='".route('presence_user', $row->id)."' class='pe-none'><button class='btn btn-secondary'><i class='fa fa-check'></i> Absen</button></a>
                //         <a href='".route('edit_presence_user', $row->id)."'><button class='btn btn-warning'><i class='fa fa-edit'></i> Edit</button></a>
                //     </div>
                //    ";
                // }

                
                if (!is_null($data)) {
                    if ($data->pivot->status == 1) {
                        return "
                            <a href='".route('presence_user', $row->id)."' class='pe-none'><button class='btn btn-secondary'><i class='fa fa-check'></i> Absen </button></a>
                           ";
                    }
                    if ($can_edit_check) {
                        return "
                                <div class='d-flex gap-2'>
                                    <a href='".route('presence_user', $row->id)."' class='pe-none'><button class='btn btn-secondary'><i class='fa fa-check'></i> Absen</button></a>
                                    <a href='".route('edit_presence_user', $row->id)."'><button class='btn btn-warning'><i class='fa fa-edit'></i> Edit</button></a>
                                </div>
                               ";
                    } else {
                        return "
                                <div class='d-flex gap-2'>
                                    <a href='".route('presence_user', $row->id)."' class='pe-none'><button class='btn btn-secondary'><i class='fa fa-check'></i> Absen</button></a>
                                    <a href='".route('edit_presence_user', $row->id)."' class='pe-none'><button class='btn btn-secondary'><i class='fa fa-edit'></i> Edit</button></a>
                                </div>
                               ";

                    }
                } else {
                    return "
                            <a href='".route('presence_user', $row->id)."'><button class='btn btn-primary'><i class='fa fa-check'></i> Absen </button></a>
                           ";
                            // dd('b');

                }

                
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
        }

        public function presence_user($id) {
            $meeting = Meeting::find($id);
            return view('user.absences_meeting', compact("meeting", "id"));
        }

        public function edit_presence_user($id) {
            $meeting = Meeting::find($id);
            $meetingPivot = $meeting->users()->wherePivot('user_id', auth()->user()->id)->first()->pivot;
            return view('user.edit_absences_meeting', compact("meeting", "id", "meetingPivot"));
        }



        public function user_store(Request $request, $id) {

            
            
            $user = User::find(auth()->user()->id);
            $meeting = Meeting::find($id);

            
            if (!empty($request->alasan)) {
                // dd(!empty($request->alasan));
                $user->meetings()->attach($meeting->id, ['status' => "0", 'alasan' => $request->alasan]);
                return redirect()->route('user_meeting_index')->with('success', 'Berhasil melakukan absen!');
            } else {
                if ($request->token === $meeting->token) {
                    $user->meetings()->attach($meeting->id, ['status' => $request->status, 'alasan' => $request->alasan]);
                    return redirect()->route('user_meeting_index')->with('success', 'Berhasil melakukan absen!');
                } else {
                    return back()->with('failed', 'Token yang anda masukkan salah!');
                }
            }


        //     $validator = Validator::make($request->all(), [
        //         'status' => 'required',
        //         'alasan' => 'nullable',
        //     ],[
        //         'status.required' => 'Wajib pilih satu',
        //         'alasan.required' => 'Alasan wajib diisi!'
        //     ]);

            

        //     if ($validator->fails()) {
        //         return redirect()->back()->with('status', 400);
        //     }
            
        }
        public function edit_user_store(Request $request, $id) {

            
            
            $user = User::find(auth()->user()->id);
            $meeting = Meeting::find($id);

            // dd($request);

            
            if (!empty($request->alasan)) {
                // dd(!empty($request->alasan));
                $user->meetings()->attach($meeting->id, ['status' => "0", 'alasan' => $request->alasan]);
                return redirect()->route('user_meeting_index')->with('success', 'Berhasil melakukan absen!');
            } else {
                if ($request->token === $meeting->token) {
                    $user->meetings()->detach($meeting->id);
                    $user->meetings()->attach($meeting->id, ['status' => $request->status, 'alasan' => $request->alasan]);
                    // DD($user->meetings()->attach($meeting->id, ['status' => $request->status, 'alasan' => $request->alasan]));
                    return redirect()->route('user_meeting_index')->with('success', 'Berhasil melakukan absen!');
                } else {
                    return back()->with('failed', 'Token yang anda masukkan salah!');
                }
            }


        //     $validator = Validator::make($request->all(), [
        //         'status' => 'required',
        //         'alasan' => 'nullable',
        //     ],[
        //         'status.required' => 'Wajib pilih satu',
        //         'alasan.required' => 'Alasan wajib diisi!'
        //     ]);

            

        //     if ($validator->fails()) {
        //         return redirect()->back()->with('status', 400);
        //     }
            
        }
    // End of User Side
    
}   
