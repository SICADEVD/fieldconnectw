<?php

namespace App\Http\Controllers;

use App\Models\Estimation;
use App\Models\Ssrteclmrs;
use App\Models\SsrteclmrsLieutravauxdangereux;
use App\Models\SsrteclmrsLieutravauxleger;
use App\Models\SsrteclmrsRaisonarretecole;
use App\Models\SsrteclmrsTravauxdangereux;
use App\Models\SsrteclmrsTravauxleger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Facades\DB;

class ApissrteclrmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	
        //
        
    }

    public function getNiveauxclasse(){
      $niveauxetudes = DB::table('niveaux_etudes')->select('nom','id')->get();
      $donnees = DB::table('classes')->get();
      $niveaux_classe = array();
      foreach($niveauxetudes as $res)
      {

          foreach($donnees as $data){
              if($data->parent_id==$res->id){
                  $gestlist[] = array('id'=>$data->id, 'libelle'=>$data->nom);
                  
              }
          }
          $niveaux_classe[] = array(
              'niveau'=>$res->nom,
              'idniveau'=>$res->id,
               "classe"=>$gestlist); 
           
           $gestlist =array(); 
      }
      return response()->json($niveaux_classe , 201);
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
     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
	
        $input = $request->all();   
    $producteur = DB::table('producteurs')->where('id',$input['producteur_id'])->first();
   $input['codeMembre']=$this->generecodessrte($input['producteur_id'],$producteur->codeProdapp); 
 
       $ssrteclmrs = Ssrteclmrs::create($input); 

       if($ssrteclmrs !=null ){
        $id = $ssrteclmrs->id;
        $datas = $datas2 =$datas3 =$datas4 =$datas5 =[];  
        
        if($request->raisonArretEcole !=null) { 
            SsrteclmrsRaisonarretecole::where('ssrteclmrs_id',$id)->delete();
            $i=0; 
            foreach($request->raisonArretEcole as $data){
                 
                    $datas[] = [
                    'ssrteclmrs_id' => $id,  
                    'raisonarretecole' => $data, 
                ];  
            } 
        }
        if($request->travauxDangereux !=null) { 
            SsrteclmrsTravauxdangereux::where('ssrteclmrs_id',$id)->delete();
            $i=0; 
            foreach($request->travauxDangereux as $data){
                 
                    $datas2[] = [
                    'ssrteclmrs_id' => $id,  
                    'travauxdangereux' => $data, 
                ];  
            } 
        }
        if($request->lieuTravauxDangereux !=null) { 
            SsrteclmrsLieutravauxdangereux::where('ssrteclmrs_id',$id)->delete();
            $i=0; 
            foreach($request->lieuTravauxDangereux as $data){
                 
                    $datas3[] = [
                    'ssrteclmrs_id' => $id,  
                    'lieutravauxdangereux' => $data, 
                ];  
            } 
        }
        if($request->travauxLegers !=null) { 
            SsrteclmrsTravauxleger::where('ssrteclmrs_id',$id)->delete();
            $i=0; 
            foreach($request->travauxLegers as $data){
                 
                    $datas4[] = [
                    'ssrteclmrs_id' => $id,  
                    'travauxlegers' => $data, 
                ];  
            } 
        }
        if($request->lieuTravauxLegers !=null) { 
            SsrteclmrsLieutravauxleger::where('ssrteclmrs_id',$id)->delete();
            $i=0; 
            foreach($request->lieuTravauxLegers as $data){
                 
                    $datas5[] = [
                    'ssrteclmrs_id' => $id,  
                    'lieutravauxlegers' => $data, 
                ];  
            } 
        }
        SsrteclmrsRaisonarretecole::insert($datas);
        SsrteclmrsTravauxdangereux::insert($datas2);
        SsrteclmrsLieutravauxdangereux::insert($datas3);
        SsrteclmrsTravauxleger::insert($datas4);
        SsrteclmrsLieutravauxleger::insert($datas5);
        
    }

        return response()->json($ssrteclmrs, 201);
    }
    
    private function generecodessrte($idProd,$codeProd)
    { 
      if($codeProd)
      {
        $data = Ssrteclmrs::select('codeMembre')->where([ 
          ['producteur_id',$idProd]
          ])->orderby('id','desc')->first();
          
        if($data !=''){
         
            $code = $data->codeMembre;  
            
            if($code !=''){
              $chaine_number = Str::afterLast($code,'-');
        $numero = Str::after($chaine_number, 'E');
        $numero = $numero+1;
            }else{
              $numero = 1;
            }
        
        $codeParc=$codeProd.'-E'.$numero;

        }else{ 
            $codeParc=$codeProd.'-E1';
        }
      }
      else{
        $codeParc='';
      }

        return $codeParc;
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
