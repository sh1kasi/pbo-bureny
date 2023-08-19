<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'meetings';
    protected $guarded = [];

    public function users() {
        // dd($this->belongsToMany(User::class, 'user_meeting', 'meeting_id', 'user_id')->withPivot('id', 'status', 'alasan')->get());
       return $this->belongsToMany(User::class, 'meeting_user', 'meeting_id', 'user_id')->withPivot('id', 'status', 'alasan');
    }
}
