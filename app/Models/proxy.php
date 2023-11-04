<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proxy extends Model
{
    use HasFactory;
    protected $table="proxytable";
    protected $fillable = [
        'ipproxy',
        'port',
        'userproxy',
        'passwordproxy',
        'providerproxy',
        'idaccproxy',
        'teamproxy',
        'ispproxy'
    ];



}
