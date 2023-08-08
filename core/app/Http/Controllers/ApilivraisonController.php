<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Campagne;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Models\Livraison;
use App\Models\LivraisonInfo;
use App\Models\LivraisonPayment;
use App\Models\LivraisonPrime;
use App\Models\LivraisonProduct;
use App\Models\Livraisons_temporaire;
use App\Models\LivraisonScelle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApilivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sender                      = auth()->user();
        $livraison                     = new LivraisonInfo();
        $livraison->invoice_id         = getTrx();
        $livraison->code               = getTrx();
        $livraison->sender_cooperative_id   = $sender->cooperative_id;
        $livraison->sender_staff_id    = $request->sender_staff;
        $livraison->sender_name        = $request->sender_name;
        $livraison->sender_email       = $request->sender_email;
        $livraison->sender_phone       = $request->sender_phone;
        $livraison->sender_address     = $request->sender_address;
        $livraison->receiver_name      = $request->receiver_name;
        $livraison->receiver_email     = $request->receiver_email;
        $livraison->receiver_phone     = $request->receiver_phone;
        $livraison->receiver_address   = $request->receiver_address;
        $livraison->receiver_cooperative_id = $sender->cooperative_id;
        $livraison->receiver_magasin_section_id = $request->magasin_section;
        $livraison->estimate_date      = $request->estimate_date;
        $livraison->save();

        $subTotal = 0;
        $campagne = Campagne::active()->first();
        $data = $data2 = $data3 = [];
        foreach ($request->items as $item) {
            // $livraisonType = Type::where('id', $item['type'])->first();
            // if (!$livraisonType) {
            //     continue;
            // }
            $price = $campagne->prix_achat * $item['quantity'];
            $subTotal += $price;
           
            $data[] = [
                'livraison_info_id' => $livraison->id,
                'parcelle_id' => $item['parcelle'],
                'campagne_id' => $campagne->id,
                'qty'             => $item['quantity'],
                'type_produit'     => $item['type'],
                'fee'             => $price,
                'type_price'      => $campagne->prix_achat,
                'created_at'      => now(),
            ];
            
            if(count($item['scelle'])){
                $scelles = implode(',', $item['scelle']);
                $scelles = explode(',', $scelles);
                foreach($scelles as $itemscelle){
                    $data2[] = [
                        'livraison_info_id' => $livraison->id,
                        'parcelle_id' => $item['parcelle'],
                        'campagne_id' => $campagne->id,
                        'type_produit'     => $item['type'],
                        'numero_scelle' => $itemscelle,
                        'created_at'      => now(),
                    ];
                }
            }

            if($item['type']=='Certifie'){
                $price_prime = $campagne->prime * $item['quantity'];
                $data3[] = [
                    'livraison_info_id' => $livraison->id,
                    'parcelle_id' => $item['parcelle'],
                    'campagne_id' => $campagne->id,
                    'quantite'             => $item['quantity'], 
                    'montant'             => $price_prime,
                    'prime_campagne'      => $campagne->prime,
                    'created_at'      => now(),
                ];
            }
            

        }

        LivraisonProduct::insert($data);
        LivraisonScelle::insert($data2);
        LivraisonPrime::insert($data3);

        $discount                        = $request->discount ?? 0;
        $discountAmount                  = ($subTotal / 100) * $discount;
        $totalAmount                     = $subTotal - $discountAmount;

        $livraisonPayment                  = new LivraisonPayment();
        $livraisonPayment->livraison_info_id = $livraison->id;
        $livraisonPayment->campagne_id  = $campagne->id;
        $livraisonPayment->amount          = $subTotal;
        $livraisonPayment->discount        = $discountAmount;
        $livraisonPayment->final_amount    = $totalAmount;
        $livraisonPayment->percentage      = $request->discount;
        $livraisonPayment->status          = $request->payment_status;
        $livraisonPayment->save();

        if ($livraisonPayment->status == Status::PAYE) {
            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = $sender->id;
            $adminNotification->title     = 'Livraison Payment ' . $sender->username;
            $adminNotification->click_url = urlPath('admin.livraison.info.details', $livraison->id);
            $adminNotification->save();
        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $sender->id;
        $adminNotification->title     = 'New livraison created to' . $sender->username;
        $adminNotification->click_url = urlPath('admin.livraison.info.details', $livraison->id);
        $adminNotification->save();


        return response()->json($livraison, 201);
    }

    public function getMagasinsection(Request $request){
        $input = $request->all();  
        $userid = $input['userid'];
        //$magasins = DB::table('magasinsections')->where('delegues_id', $userid)->get();
        $magasins = DB::table('magasinsections')->get();
        return response()->json($magasins, 201);
    }
    public function generecodeliv()
    {
       
        $data = Livraison::select('codeLiv')->orderby('id','desc')->limit(1)->get();
         
        if(count($data)>0){
            $code = $data[0]->codeLiv;  
        $chaine_number = Str::afterLast($code,'-');
        if($chaine_number<10){$zero="00000";}
        else if($chaine_number<100){$zero="0000";}
        else if($chaine_number<1000){$zero="000";}
        else if($chaine_number<10000){$zero="00";}
        else if($chaine_number<100000){$zero="0";}
        else{$zero="";}
        }else{
            $zero="00000";
            $chaine_number=0;
        }
        $sub='BL-';
        $lastCode=$chaine_number+1;
        $codeLiv=$sub.$zero.$lastCode;

        return $codeLiv;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	
        //
    }
}
