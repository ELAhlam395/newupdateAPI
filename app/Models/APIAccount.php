<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIAccount extends Model
{
    use HasFactory;
    protected $table="_a_p_i_account";
    protected $fillable = [
        'user',
        'password',
       'api_key',
        'api_hash',
        'api_get',
        'api_add',
        'api_delete',
        'api_edit',
        'idprov',


      

    ];
}
