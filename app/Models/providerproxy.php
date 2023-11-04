<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class providerproxy extends Model
{
    use HasFactory;
    protected $table="providerproxy";
    protected $fillable = [
      'nameprovider',
      'linkprovider',


    ];
}
