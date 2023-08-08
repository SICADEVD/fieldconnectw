<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class SuiviFormationTheme extends Model
{
    use Searchable, GlobalStatus, PowerJoins; 

    public function suiviFormation()
    {
        return $this->belongsTo(SuiviFormation::class);
    }

    public function theme()
    {
        return $this->belongsTo(ThemesFormation::class,'themes_formation_id');
    }
     
     
}