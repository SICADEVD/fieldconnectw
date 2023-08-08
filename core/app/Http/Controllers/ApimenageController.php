<?php

namespace App\Http\Controllers;

use App\Models\Menage;
use App\Models\Localite;
use App\Constants\Status;
use App\Models\Producteur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApimenageController extends Controller
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
		
        
        // $input = $request->all();   
        // $menage = Menage::create($input);
        $validationRule = [
            'producteur'    => 'required|exists:producteurs,id',
            'quartier' => 'required|max:255',
            'sources_energies'  => 'required|max:255',
            'ordures_menageres'  => 'required|max:255',
            'separationMenage'  => 'required|max:255', 
            'eauxToillette'  => 'required|max:255', 
            'eauxVaisselle'  => 'required|max:255', 
            'wc'  => 'required|max:255', 
            'sources_eaux'  => 'required|max:255', 
            'traitementChamps'  => 'required|max:255', 
            'equipements'  => 'required|max:255',
            'activiteFemme'  => 'required|max:255',
            'superficieCacaoFemme'  => 'required|max:255', 
        ];
 

        $request->validate($validationRule);

         
        if($request->id !=null) {
            $menage = Menage::find($request->id);  

        } else {
            $menage = new Menage();  
        } 
        if($menage->producteur_id != $request->producteur) {
            $hasMenage = Menage::where('producteur_id', $request->producteur)->exists();
            if ($hasMenage) { 
                return response()->json("Ce producteur a déjà un menage enregistré", 501);
            }
        }
        
        $menage->producteur_id  = $request->producteur;  
        $menage->quartier  = $request->quartier;
        $menage->sources_energies  = $request->sources_energies;
        $menage->boisChauffe     = $request->boisChauffe;
        $menage->ordures_menageres    = $request->ordures_menageres;
        $menage->separationMenage = $request->separationMenage; 
        $menage->eauxToillette    = $request->eauxToillette;
        $menage->eauxVaisselle    = $request->eauxVaisselle; 
        $menage->wc    = $request->wc; 
        $menage->sources_eaux    = $request->sources_eaux; 
        $menage->machine    = $request->machine; 
        $menage->type_machines    = $request->type_machines; 
        $menage->garde_machines    = $request->garde_machines; 
        $menage->equipements    = $request->equipements; 
        $menage->traitementChamps    = $request->traitementChamps; 
        $menage->nomPersonneTraitant    = $request->nomPersonneTraitant; 
        $menage->numeroPersonneTraitant    = $request->numeroPersonneTraitant; 
        $menage->empruntMachine    = $request->empruntMachine; 
        $menage->gardeEmpruntMachine    = $request->gardeEmpruntMachine; 
        $menage->activiteFemme    = $request->activiteFemme; 
        $menage->nomActiviteFemme    = $request->nomActiviteFemme; 
        $menage->superficieCacaoFemme    = $request->superficieCacaoFemme; 
        $menage->champFemme    = $request->champFemme; 
        $menage->nombreHectareFemme    = $request->nombreHectareFemme;
       
        $menage->save(); 

        if($menage ==null ){
            return response()->json("Le ménage n'a pas été enregistré", 501);
        }
        
        return response()->json($menage, 201);
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
