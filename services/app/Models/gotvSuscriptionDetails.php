<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\newGotvSubValidate;

class gotvSuscriptionDetails extends Model
{
    use HasFactory;

    public function gotv_packe_name(){
        return $this->belongsTo(newGotvSubValidate::class, 'gotv_sub_val_id','id');
    }
}
