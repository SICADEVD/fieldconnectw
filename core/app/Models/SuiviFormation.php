<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class SuiviFormation extends Model
{
    use Searchable, GlobalStatus, PowerJoins;

    public function localite()
    {
        return $this->belongsTo(Localite::class, 'localite_id');
    }
    public function typeFormation()
    {
        return $this->belongsTo(TypeFormation::class, 'type_formation_id');
    }
    public function campagne()
    {
        return $this->belongsTo(Campagne::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function formationProducteur()
    {
        return $this->hasMany(SuiviFormationProducteur::class, 'suivi_formation_id', 'id');
    }
    public function formationTheme()
    {
        return $this->hasMany(SuiviFormationTheme::class, 'suivi_formation_id', 'id');
    }
     
     
}