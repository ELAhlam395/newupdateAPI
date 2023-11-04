<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIProvider extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="_a_p_i_provider";
    protected $fillable = ['name', 'link'];

}
