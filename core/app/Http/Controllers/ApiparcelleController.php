<?php

namespace App\Http\Controllers;
use App\Models\Localite;
use App\Models\Parcelle;
use App\Constants\Status;
use App\Models\Producteur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiparcelleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $donnees = Parcelle::get(); 

        return response()->json($donnees , 201);
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
        'producteur'    => 'required|exists:producteurs,id',
        'typedeclaration' => 'required|max:255',
        'anneeCreation'  => 'required|max:255',
        'culture'  => 'required|max:255',
        'superficie'  => 'required|max:255', 
    ];


    $request->validate($validationRule);

    if($request->id) {
        $parcelle = Parcelle::find($request->id);
        $codeParc=$parcelle->codeParc;
        if($codeParc ==''){
            $produc=Producteur::select('codeProdapp')->find($request->producteur);
        if($produc !=null){
        $codeProd = $produc->codeProdapp;
        }else{
        $codeProd='';
        }
        $parcelle->codeParc  =  $this->generecodeparc($request->producteur, $codeProd);
        } 

    } else {
        $parcelle = new Parcelle(); 
        $produc=Producteur::select('codeProdapp')->find($request->producteur);
        if($produc !=null){
        $codeProd = $produc->codeProdapp;
        }else{
        $codeProd='';
        }
        $parcelle->codeParc  =  $this->generecodeparc($request->producteur, $codeProd);
    } 
    
    $parcelle->producteur_id  = $request->producteur;  
    $parcelle->typedeclaration  = $request->typedeclaration;
    $parcelle->anneeCreation  = $request->anneeCreation;
    $parcelle->culture     = $request->culture;
    $parcelle->superficie    = $request->superficie;
    $parcelle->latitude = $request->latitude; 
    $parcelle->longitude    = $request->longitude; 
    if(isset($request->waypoints) && count($request->waypoints)>0) {
      $parcelle->waypoints=implode(',', $request->waypoints);
    }else{
      $parcelle->waypoints ="";
    }
    if($request->superficie){
      $superficie = Str::before($request->superficie,' ');
      if(Str::contains($superficie,","))
      {
        $superficie = Str::replaceFirst( ',','.',$superficie);
        if(Str::contains($superficie,","))
          {
            $superficie = Str::replaceFirst( 'm²','',$superficie);
          } 
      }

      $parcelle->superficie = $superficie;
    }else{
      $parcelle->superficie = 0;
    }
    

    $parcelle->save(); 
    if($parcelle ==null ){
      return response()->json("La parcelle n'a pas été enregistré", 501);
  }

        return response()->json($parcelle, 201);
    }

    private function generecodeparc($idProd,$codeProd)
    { 
      if($codeProd)
      {
        $action = 'non'; 

        $data = Parcelle::select('codeParc')->where([ 
          ['producteur_id',$idProd],
          ['codeParc','!=',null]
          ])->orderby('id','desc')->first();
          
        if($data !=''){
         
            $code = $data->codeParc;  
            
            if($code !=''){
              $chaine_number = Str::afterLast($code,'-');
        $numero = Str::after($chaine_number, 'P');
        $numero = $numero+1;
            }else{
              $numero = 1;
            } 
        $codeParc=$codeProd.'-P'.$numero;

        do{

          $verif = Parcelle::select('codeParc')->where('codeParc',$codeParc)->orderby('id','desc')->first(); 
        if($verif ==null){
            $action = 'non';
        }else{
            $action = 'oui';
            $code = $data->codeParc;  
            
            if($code !=''){
              $chaine_number = Str::afterLast($code,'-');
        $numero = Str::after($chaine_number, 'P');
        $numero = $numero+1;
            }else{
              $numero = 1;
            } 
        $codeParc=$codeProd.'-P'.$numero;

        }

    }while($action !='non');

        }else{ 
            $codeParc=$codeProd.'-P1';
        }
      }
      else{
        $codeParc='';
      }

        return $codeParc;
    }

    public function getparcelleUpdate(Request $request){
       

      $input = $request->all();   
      if($request->userid)
      {
      $userid = $input['userid'];
      $parcelle = DB::select( DB::raw("SELECT pa.*, p.nom, p.prenoms FROM parcelles as pa
      INNER JOIN producteurs as p ON pa.producteur_id=p.id
      WHERE pa.producteur_id ='' OR
        pa.codeParc  ='' OR
        pa.anneeCreation  ='' OR 
        pa.typedeclaration  ='' OR 
        pa.culture  ='' OR 
        pa.superficie  ='' OR 
        pa.latitude  ='' OR 
        pa.longitude  ='' OR 
        pa.waypoints  ='' OR
      typedeclaration !='GPS'
      AND pa.deleted_at IS NULL
      AND pa.userid='$userid'
      
      "));

if(isset($input['id'])){

  if(isset($input['waypoints']) && count($input['waypoints'])>0) {
    $input['waypoints']=serialize($input['waypoints']);
}else{
  $input['waypoints']="";
}
$input['superficie'] = Str::before($input['superficie'],' ');
if(Str::contains($input['superficie'],","))
{
  $input['superficie'] = Str::replaceFirst( ',','.',$input['superficie']);
  if(Str::contains($input['superficie'],","))
    {
      $input['superficie'] = Str::replaceFirst( 'm²','',$input['superficie']);
    }
 // $input['superficie'] = $input['superficie']*0.0001;
}
$parcelle = Parcelle::find($input['id']);
        $parcelle->update($input);
        $parcelle = Parcelle::find($input['id']);
        

}
 
}else{
  $parcelle=array();
}
return response()->json($parcelle, 201);
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
