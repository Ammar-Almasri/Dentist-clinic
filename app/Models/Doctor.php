<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'phone',
        'speciality',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
