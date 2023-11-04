<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvListd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="_provider_listed";
    protected $fillable = [
        'name',
        'login',
        'comment',
    ];
}
