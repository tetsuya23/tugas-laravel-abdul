<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }

}
