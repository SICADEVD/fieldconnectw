<?php

namespace App\Exports;

use App\Models\ApplicationInsecte;
use App\Models\SuiviParcellesParasite;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class InsectesExport implements FromView, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function view(): View
    {
        // TODO: Implement view() method.
        
        return view('manager.application.InsectesExcel',[
            'insectes' => ApplicationInsecte::joinRelationship('application.parcelle.producteur.localite')->where('cooperative_id',auth()->user()->cooperative_id)->get()
        ]);
    }

    public function title(): string
    {
        Return "Insectes";
    }
}
