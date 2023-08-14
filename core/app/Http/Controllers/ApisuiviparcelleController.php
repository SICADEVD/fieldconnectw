<?php

namespace App\Http\Controllers;

use App\Models\Localite;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\SuiviParcelle;
use App\Models\Suivi_parcelle;
use Illuminate\Support\Facades\DB;
use App\Models\SuiviParcellesAnimal;
use App\Models\SuiviParcellesOmbrage;
use App\Models\SuiviParcellesParasite;
use App\Models\SuiviParcellesAgroforesterie;

class ApisuiviparcelleController extends Controller
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
        $validationRule = [
            'parcelle'    => 'required|exists:parcelles,id',
            'campagne' => 'required|max:255',  
            'dateVisite'  => 'required|max:255', 
        ];
        
        $request->validate($validationRule);
        $localite = Localite::where('id', $request->localite)->first();
        if ($localite->status == Status::NO) {
            $notify ='Cette localité est désactivée';
            return back()->withNotify($notify)->withInput();
        }
        if($request->id) {
            $suivi_parcelle = SuiviParcelle::findOrFail($request->id);
            $message = "Le suivi parcelle a été mise à jour avec succès";
        } else {
            $suivi_parcelle = new SuiviParcelle();  
        } 

        $suivi_parcelle->parcelle_id  = $request->parcelle;  
        $suivi_parcelle->campagne_id  = $request->campagne;
        $suivi_parcelle->varietes_cacao  = $request->varietes_cacao;
        $suivi_parcelle->autreVariete  = $request->autreVariete;
        $suivi_parcelle->existeCoursEaux  = $request->existeCoursEaux;
        $suivi_parcelle->cours_eaux  = $request->cours_eaux;
        $suivi_parcelle->pente  = $request->pente;
        $suivi_parcelle->varieteAbres  = $request->varieteAbres;
        $suivi_parcelle->nombreSauvageons  = $request->nombreSauvageons;
        $suivi_parcelle->arbresagroforestiers  = $request->arbresagroforestiers;
        $suivi_parcelle->activiteTaille  = $request->activiteTaille;
        $suivi_parcelle->activiteEgourmandage = $request->activiteEgourmandage; 
        $suivi_parcelle->activiteDesherbageManuel = $request->activiteDesherbageManuel;
        $suivi_parcelle->activiteRecolteSanitaire = $request->activiteRecolteSanitaire;
        $suivi_parcelle->intrantNPK = $request->intrantNPK;  
        $suivi_parcelle->nombresacsNPK = $request->nombresacsNPK; 
        $suivi_parcelle->intrantFiente = $request->intrantFiente; 
        $suivi_parcelle->nombresacsFiente    = $request->nombresacsFiente;
        $suivi_parcelle->intrantComposte    = $request->intrantComposte;
        $suivi_parcelle->nombresacsComposte    = $request->nombresacsComposte;
        $suivi_parcelle->presencePourritureBrune    = $request->presencePourritureBrune;
        $suivi_parcelle->presenceBioAgresseur    = $request->presenceBioAgresseur;
        $suivi_parcelle->presenceInsectesRavageurs    = $request->presenceInsectesRavageurs;
        $suivi_parcelle->presenceFourmisRouge    = $request->presenceFourmisRouge; 
        $suivi_parcelle->presenceAraignee    = $request->presenceAraignee; 
        $suivi_parcelle->presenceVerTerre    = $request->presenceVerTerre; 
        $suivi_parcelle->presenceMenteReligieuse    = $request->presenceMenteReligieuse; 
        $suivi_parcelle->presenceSwollenShoot    = $request->presenceSwollenShoot; 
        $suivi_parcelle->presenceInsectesParasites    = $request->presenceInsectesParasites; 
        $suivi_parcelle->nomInsecticide    = $request->nomInsecticide; 
        $suivi_parcelle->nombreInsecticide    = $request->nombreInsecticide; 
        $suivi_parcelle->nomFongicide    = $request->nomFongicide; 
        $suivi_parcelle->nombreFongicide    = $request->nombreFongicide; 
        $suivi_parcelle->nomHerbicide    = $request->nomHerbicide; 
        $suivi_parcelle->nombreHerbicide    = $request->nombreHerbicide; 
        $suivi_parcelle->nombreDesherbage    = $request->nombreDesherbage; 
        $suivi_parcelle->dateVisite    = $request->dateVisite;  

        $suivi_parcelle->save(); 

        if($suivi_parcelle !=null ){
            $id = $suivi_parcelle->id;
            $datas = [];
            $datas2 = [];
            $datas3 = [];
            $datas4 = [];
            if(($request->varietesOmbrage !=null)) { 
                SuiviParcellesOmbrage::where('suivi_parcelle_id',$id)->delete();
                $i=0; 
                foreach($request->varietesOmbrage as $data){
                    if($data !=null)
                    {
                        $datas[] = [
                        'suivi_parcelle_id' => $id, 
                        'ombrage' => $data, 
                        'nombre' => $request->nombreOmbrage[$i]
                    ];
                    } 
                  $i++;
                } 
            }

            if(($request->agroforestiers !=null)) { 
                SuiviParcellesAgroforesterie::where('suivi_parcelle_id',$id)->delete();
                $i=0; 
                foreach($request->agroforestiers as $data){
                    if($data !=null)
                    {
                        $datas2[] = [
                        'suivi_parcelle_id' => $id, 
                        'agroforesterie' => $data, 
                        'nombre' => $request->nombreagroforestiers[$i]
                    ];
                    } 
                  $i++;
                } 
            }
            if(($request->insectesParasites !=null)) { 
                SuiviParcellesParasite::where('suivi_parcelle_id',$id)->delete();
                $i=0; 
                foreach($request->insectesParasites as $data){
                    if($data !=null)
                    {
                        $datas3[] = [
                            'suivi_parcelle_id' => $id, 
                            'parasite' => $data, 
                            'nombre' => $request->nombreinsectesParasites[$i]
                        ];
                    } 
                  $i++;
                } 
            }
            if(($request->animauxRencontres !=null)) { 
                SuiviParcellesAnimal::where('suivi_parcelle_id',$id)->delete();
                $i=0; 
                foreach($request->animauxRencontres as $data){
                    if($data !=null)
                    {
                        $datas4[] = [
                            'suivi_parcelle_id' => $id, 
                            'animal' => $data
                        ];
                    } 
                  $i++;
                } 
            }

        SuiviParcellesAnimal::insert($datas4);
        SuiviParcellesParasite::insert($datas3);
        SuiviParcellesAgroforesterie::insert($datas2); 
        SuiviParcellesOmbrage::insert($datas);
        }

        return response()->json($suivi_parcelle, 201);
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
