<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationInsecte;
use App\Models\ApplicationMatieresactive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
	
      
      
        $input = $request->all();   
      
        if($request->photoZoneTampons){ 
           
          $image = $request->photoZoneTampons;  
          $image = Str::after($image,'base64,');
          $image = str_replace(' ', '+', $image);
          $imageName = (string) Str::uuid().'.'.'jpg';
           File::put(storage_path(). "/app/public/applications/" . $imageName, base64_decode($image)); 
           $photoZoneTampons = "public/applications/$imageName"; 

          $input['photoZoneTampons'] = $photoZoneTampons; 
        }
        if($request->photoDouche){  
          $image = $request->photoDouche;  
          $image = Str::after($image,'base64,');
          $image = str_replace(' ', '+', $image);
          $imageName = (string) Str::uuid().'.'.'jpg';
           File::put(storage_path(). "/app/public/applications/" . $imageName, base64_decode($image)); 
          $photoDouche = "public/applications/$imageName"; 

          $input['photoDouche'] = $photoDouche; 
        }
        $application = Application::create($input); 

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
