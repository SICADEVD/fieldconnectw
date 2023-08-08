<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class ApievaluationController extends Controller
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
         $note=0; 
         $totalnote=0;
        if(isset($input['reponse']) && count($input['reponse'])>0){
              foreach($input['reponse'] as $value){
                $note = $note + $value;
              }
            
        }
        
        $input['note'] = $note; 

    $evaluation = Evaluation::create($input);

    
        if($evaluation !=null){

        $id = $evaluation->id;
          if(isset($input['reponse']) && count($input['reponse'])>0 ) {
             
            $i=0;
            foreach($input['reponse'] as $key => $data){
              DB::table('evaluation_questionnaire')->insert(['evaluation_id'=>$id,'questionnaire_id'=>$key,'notation'=>$data]);
              $i++;
            }
            
        }
       
 
      }

         return response()->json($evaluation, 201);
    }

    public function getQuestionnaire(){
        $categoriequestionnaire = DB::table('categoriequestionnaires')->get();
        $donnees = DB::table('questionnaires')->get();
        $questionnaires = array();
        $gestlist =array();
        foreach($categoriequestionnaire as $categquest)
        {
 
            foreach($donnees as $data){
                if($data->categoriequestionnaires_id==$categquest->id){
                    $gestlist[] = array('id'=>$data->id, 'libelle'=>$data->questionnaires_nom);
                    
                }
            }
            $questionnaires[] = array('titre'=>$categquest->titre, "questionnaires"=>$gestlist); 
             
             $gestlist =array(); 
        }
        
            
        return response()->json($questionnaires , 201);
    }
    public function getNotation(){
        $donnees = DB::table('notations')->get();
        return response()->json($donnees , 201);
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
