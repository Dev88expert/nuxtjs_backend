<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /* this method is used to get attribute elements. */
      public function getTagAttribute($value)
    {   
        if($value){
            return explode(" ",$value);
        }else{
            return null;
        }
    }
}
