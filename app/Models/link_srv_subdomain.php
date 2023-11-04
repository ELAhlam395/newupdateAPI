<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class link_srv_subdomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_subdomain',
        'Id_Server',
       
    ];
    public function post()
    {
    return $this->belongsTo(Server::class);
    }
}
