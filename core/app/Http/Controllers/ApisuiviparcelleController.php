<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suivi_parcelle;
use App\Models\SuiviParcelle;
use App\Models\SuiviParcellesAgroforesterie;
use App\Models\SuiviParcellesAnimal;
use App\Models\SuiviParcellesOmbrage;
use App\Models\SuiviParcellesParasite;
use Illuminate\Support\Facades\DB;

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
      
        //
        $input = $request->all();  
        
        $suiviparcelle = SuiviParcelle::create($input);

        if($suiviparcelle !=null ){
            $id = $suiviparcelle->id;
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

        return response()->json($suiviparcelle, 201);
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
