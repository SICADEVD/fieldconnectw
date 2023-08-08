<?php

namespace App\Exports;

use App\Models\Producteur; 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ProducteursExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function view(): View
    {
        // TODO: Implement view() method.
        return view('manager.producteur.ProducteursAllExcel',[
            'producteurs' => Producteur::joinRelationship('localite')->where('cooperative_id',auth()->user()->cooperative_id)->get()
        ]);
    }
}
