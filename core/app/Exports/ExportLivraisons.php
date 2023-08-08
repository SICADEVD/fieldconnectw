<?php

namespace App\Exports;

use App\Models\LivraisonInfo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ExportLivraisons implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function view(): View
    {
        // TODO: Implement view() method.
        return view('manager.livraison.LivraisonsAllExcel',[
            'livraisons' => LivraisonInfo::joinRelationship('senderCooperative')->where('sender_cooperative_id',auth()->user()->cooperative_id)->get()
        ]);
    } 
}
