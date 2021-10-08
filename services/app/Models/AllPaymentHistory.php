<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllPaymentHistory extends Model
{
    use HasFactory;
    public function dstv_package_name(){
        return $this->belongsTo(newDSTVSubValidate::class, 'dstv_sub_val_id','id');
    }
    use HasFactory;
}
