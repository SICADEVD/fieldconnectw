<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use App\Models\ApplicationInsecte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\ApplicationMatieresactive;

class ApiapplicationController extends Controller
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
	
        //$input = $request->all();   

        $validationRule = [
            'parcelle'    => 'required|exists:parcelles,id',
            'applicateur'    => 'required|exists:users,id',
            'superficiePulverisee'  => 'required|max:255',
            'marqueProduitPulverise'  => 'required|max:255',
            'raisonApplication'  => 'required|max:255', 
            'delaisReentree'  => 'required|max:255',
            'date_application'  => 'required|max:255',
            'heure_application'  => 'required|max:255', 
        ];
 

        $request->validate($validationRule);
        $application = new Application();  
        $campagne = Campagne::active()->first();
      
        if($request->photoZoneTampons){ 
           
          $image = $request->photoZoneTampons;  
          $image = Str::after($image,'base64,');
          $image = str_replace(' ', '+', $image);
          $imageName = (string) Str::uuid().'.'.'jpg';
           File::put(storage_path(). "/app/public/applications/" . $imageName, base64_decode($image)); 
           $photoZoneTampons = "public/applications/$imageName"; 
          $application->zoneTampons  = $photoZoneTampons;
        }
        if($request->photoDouche){  
          $image = $request->photoDouche;  
          $image = Str::after($image,'base64,');
          $image = str_replace(' ', '+', $image);
          $imageName = (string) Str::uuid().'.'.'jpg';
           File::put(storage_path(). "/app/public/applications/" . $imageName, base64_decode($image)); 
          $photoDouche = "public/applications/$imageName"; 
          $application->presenceDouche  = $photoDouche;
          
        }
        //$application = Application::create($input); 
        
        $application->parcelle_id  = $request->parcelle;  
        $application->campagne_id  = $campagne->id;
        $application->applicateur_id  = $request->applicateur;
        $application->superficiePulverisee  = $request->superficiePulverisee;
        $application->marqueProduitPulverise  = $request->marqueProduitPulverise;
        $application->degreDangerosite  = $request->degreDangerosite;
        $application->raisonApplication  = $request->raisonApplication;
        $application->delaisReentree  = $request->delaisReentree;
        
        
        $application->date_application  = $request->date_application;
        $application->heure_application = $request->heure_application;
        $application->save(); 
        

        if($application !=null ){
          $id = $application->id;
          $datas = $datas2 = []; 
         
          if(count($request->matieresActives)) { 
              ApplicationMatieresactive::where('application_id',$id)->delete();
              $i=0; 
              foreach($request->matieresActives as $data){
                   
                      $datas[] = [
                      'application_id' => $id,  
                      'matiereactive' => $data, 
                  ];  
              } 
          }
          if(count($request->nomInsectesCibles)) { 
              ApplicationInsecte::where('application_id',$id)->delete();
              $i=0; 
              foreach($request->nomInsectesCibles as $data){
                   
                      $datas2[] = [
                      'application_id' => $id,  
                      'insecte' => $data, 
                  ];  
              } 
          }
          ApplicationMatieresactive::insert($datas);
          ApplicationInsecte::insert($datas2);
          
      }
        return response()->json($application, 201);
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
