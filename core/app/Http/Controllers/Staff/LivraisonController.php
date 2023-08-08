<?php

namespace App\Http\Controllers\Staff;

use App\Constants\Status;
use App\Exports\ExportLivraisons;
use App\Http\Controllers\Controller;
use App\Models\LivraisonInfo;

class LivraisonController extends Controller
{

    public function livraisonInfo()
    {
        $pageTitle    = "Liste des Livraisons";
        $livraisonInfos = $this->livraisons();
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    public function sentInQueue()
    {
        $pageTitle    = "Liste des livraisons en attente";
        $livraisonInfos = $this->livraisons('queue');
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    public function sentLivraison()
    {
        $manager      = auth()->user();
        $pageTitle    = "Liste des livraisons envoyées";
        $livraisonInfos = LivraisonInfo::where('sender_cooperative_id', $manager->cooperative_id)->where('status', '!=', Status::COURIER_QUEUE)->dateFilter()->searchable(['code'])->with('senderCooperative', 'receiverCooperative', 'senderStaff', 'receiverStaff', 'paymentInfo')->paginate(getPaginate());
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    public function deliveryInQueue()
    {
        $pageTitle    = "Liste des livraisons en attente de reception";
        $livraisonInfos = $this->livraisons('deliveryQueue');
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    public function dispatchLivraison()
    {
        $pageTitle    = "Liste des livraisons expédiées";
        $livraisonInfos = $this->livraisons('dispatched');
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    public function delivered()
    {
        $pageTitle    = "Liste des livraisons reçues";
        $livraisonInfos = $this->livraisons('delivered');
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    public function upcoming()
    {
        $pageTitle    = "Liste des livraisons encours";
        $livraisonInfos = $this->livraisons('upcoming');
        return view('staff.livraison.index', compact('pageTitle', 'livraisonInfos'));
    }

    protected function livraisons($scope = null)
    {
        $user     = auth()->user();
        $livraisons = LivraisonInfo::where(function ($query) use ($user) {
            $query->where('sender_cooperative_id', $user->cooperative_id)->orWhere('receiver_cooperative_id', $user->cooperative_id);
        });
        if ($scope) {
            $livraisons = $livraisons->$scope();
        }
        $livraisons = $livraisons->dateFilter()->searchable(['code'])->with('senderCooperative', 'receiverCooperative', 'senderStaff', 'receiverStaff', 'paymentInfo')->paginate(getPaginate());
        return $livraisons;
    }

    public function invoice($id)
    {
        $id                  = decrypt($id);
        $pageTitle           = "Facture";
        $livraisonInfo         = LivraisonInfo::with('payment')->findOrFail($id);
        return view('staff.livraison.invoice', compact('pageTitle', 'livraisonInfo'));
    }

    public function exportExcel()
    {
        return (new ExportLivraisons())->download('livraisons.xlsx');
    }

}
