<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acc_Prv_Srv extends Model
{
    use HasFactory;

   
  
    public function tab4()
{
return $this->belongsTo(Team::class,'Id_team');
}
    
}
