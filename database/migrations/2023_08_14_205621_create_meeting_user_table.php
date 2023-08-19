<?php

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meeting_user', function (Blueprint $table) {
            $table->id();
            // $table->string('user_id');
            $table->foreignId('user_id')->references('id')->on('users');
            // $table->string('meeting_id');
            $table->foreignId('meeting_id')->references('id')->on('meetings');
            $table->enum('status', [1, 0])->comment("1 = Hadir | 0 = Tidak Hadir");
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_meeting');
    }
};
