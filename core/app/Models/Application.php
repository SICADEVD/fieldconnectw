<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Application extends Model
{
    use Searchable, GlobalStatus, PowerJoins;

    public function parcelle()
    {
        return $this->belongsTo(Parcelle::class);
    }

    public function campagne()
    {
        return $this->belongsTo(Campagne::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'applicateur_id');
    }
     
    public function insectes()
    {
        return $this->hasMany(ApplicationInsecte::class, 'application_id', 'id');
    }
     
    public function matiereactives()
    {
        return $this->hasMany(ApplicationMatieresactive::class, 'application_id', 'id');
    }
}