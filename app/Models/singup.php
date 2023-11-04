<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class singup extends Model
{
    use HasFactory;
   protected $table="singuptable";
    protected $fillable = [
        'fname',
        'lname',
        'name',
        'email',
        'password',
        'rd',
        'tm'

    ];
}
