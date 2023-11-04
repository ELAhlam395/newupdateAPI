<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accproxy extends Model
{
    use HasFactory;
    protected $table="accountproxy";
    protected $fillable = [
        'idprovprxy',
        'useracc',
       'passwordacc',
        'locationacc',

    ];
}
