<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Magasin_section extends Model
{
    use Searchable, GlobalStatus, PowerJoins;
    public function user()
    {
        return $this->belongsTo(User::class,'staff_id');
    }
 
}