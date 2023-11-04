<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\link_srv_subdomain;
use Illuminate\Pagination\Paginator;

class Server extends Model
{
    //use HasFactory;

    use HasFactory;

   // protected $dates = ['deleted_at'];
 

    protected $fillable = [
        'id',
        'Ip',
        'Password',
        'Name',
        'Due_Date',
        'Date_Creation',
        'Name_Provider',
        'Price',
        'Payment_Method',
        'Additionnal_ips',
        'Comment',
        'Id_Acc_prov',
        'Id_domain',
        'TEAM5',
        'PROVIDER'
    ];


    public function tab2()
{
return $this->belongsTo(Domain::class,'Id_domain');
}



public function tab3()
{
return $this->belongsTo(Acc_Prv_Srv::class,'Id_Acc_prov');
}
public function tab5()
{
return $this->belongsTo(Provider_Server::class,'PROVIDER');
}




 
}
