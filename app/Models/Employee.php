<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name','designation','department','pf_no','mobile','blood_group',
        'address','emergency_contact','valid_to','photo_path','qr_payload','photo_bg'
    ];

    protected $casts = [
        'valid_to' => 'date',
        'qr_payload' => 'array',
    ];
}
