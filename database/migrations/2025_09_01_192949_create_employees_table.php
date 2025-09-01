<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employees', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('designation');
            $t->string('department')->nullable();
            $t->string('pf_no')->nullable();
            $t->string('mobile')->nullable();
            $t->string('blood_group')->nullable();
            $t->string('address')->nullable();
            $t->string('emergency_contact')->nullable();
            $t->date('valid_to')->nullable();
            $t->string('photo_path')->nullable();   // storage/app/public/photos/...
            $t->json('qr_payload')->nullable();     // put only opaque IDs/tokens
            $t->string('photo_bg')->nullable();     // e.g. "#e9f2ff"
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('employees'); }
};
