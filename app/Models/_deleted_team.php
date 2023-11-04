<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _deleted_team extends Model
{
    use HasFactory;

    protected $fillable = [

        'Id_Team_deleted',
        'Name_Team_deleted'

    ];

}
