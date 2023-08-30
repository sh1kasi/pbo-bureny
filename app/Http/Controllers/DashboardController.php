<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $count_user = User::where('role', 'user')->count();
        $count_meeting = Meeting::count();
        $incoming_meeting = Meeting::whereDate('tanggal', '>', Carbon::now()->format('Y-m-d'))->orderBy('tanggal', 'DESC')->limit(3 )->get();
        return view("admin.dashboard_index", compact('count_user', 'count_meeting', 'incoming_meeting'));
    }
}
