<?php

namespace App\Http\Controllers\Manager;

use App\Constants\Status;
use App\Exports\ExportSsrteclmrs;
use App\Http\Controllers\Controller;
use App\Models\ClasseEtude;
use App\Models\Localite;
use App\Models\NiveauxEtude;
use App\Models\Producteur; 
use App\Models\Ssrteclmrs;
use App\Models\SsrteclmrsLieutravauxdangereux;
use App\Models\SsrteclmrsLieutravauxleger;
use App\Models\SsrteclmrsRaisonarretecole;
use App\Models\SsrteclmrsTravauxdangereux;
use App\Models\SsrteclmrsTravauxleger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Excel;

class SsrteclmrsController extends Controller
{

    public function index()
    {
        $pageTitle      = "Gestion des ssrteclmrs";
        $manager   = auth()->user(); 
        $localites = Localite::active()->where('cooperative_id',$manager->cooperative_id)->get();
        $ssrteclmrs = Ssrteclmrs::dateFilter()->searchable(["nomMembre","prenomMembre","sexeMembre","datenaissMembre","codeMembre","lienParente","autreLienParente","frequente","niveauEtude","classe","ecoleVillage","distanceEcole","nomEcole","moyenTransport","avoirFrequente","niveauEtudeAtteint"])->latest('id')->joinRelationship('producteur.localite')->where('cooperative_id',$manager->cooperative_id)->where(function ($q) {
            if(request()->localite != null){
                $q->where('localite_id',request()->localite);
            }
        })->with('producteur')->paginate(getPaginate()); 
        return view('manager.ssrteclmrs.index', compact('pageTitle', 'ssrteclmrs','localites'));
    }
 
    public function create()
    {
        $pageTitle = "Ajouter un ssrteclmrs";
        $manager   = auth()->user();
        $producteurs  = Producteur::with('localite')->get();
        $localites  = Localite::active()->where('cooperative_id',auth()->user()->cooperative_id)->orderBy('nom')->get();
        $lienParente = DB::table('lien_parente')->pluck('nom','nom')->all();
        $raisonArretEcole = DB::table('arret_ecoles')->pluck('nom','nom')->all();
            $travauxDangereux = DB::table('travaux_dangereux')->pluck('nom','nom')->all();
            $lieuTravaux = DB::table('lieux_travaux')->pluck('nom','nom')->all();
            $travauxLegers = DB::table('travaux_legers')->pluck('nom','nom')->all();
            $niveauEtude = NiveauxEtude::get();
            $classes = ClasseEtude::with('niveau')->get();
            
            $moyenTransport = DB::table('moyens_transport')->pluck('nom','nom')->all();

        return view('manager.ssrteclmrs.create', compact('pageTitle', 'producteurs','localites','raisonArretEcole','travauxDangereux','lieuTravaux','travauxLegers','lienParente','niveauEtude','moyenTransport','classes'));
    }

    public function store(Request $request)
    {
        $validationRule = [
            'producteur'    => 'required|exists:producteurs,id',
            'nomMembre' => 'required|max:255',
            'prenomMembre'  => 'required|max:255',
            'sexeMembre'  => 'required|max:255',
            'datenaissMembre'  => 'required|max:255', 
            'lienParente'  => 'required|max:255',
            'frequente'  => 'required|max:255',
            'date_enquete'  => 'required|max:255', 
        ];
 

        $request->validate($validationRule);

        $localite = Localite::where('id', $request->localite)->first();

        if ($localite->status == Status::NO) {
            $notify[] = ['error', 'Cette localité est désactivé'];
            return back()->withNotify($notify)->withInput();
        }
        
        if($request->id) {
            $ssrteclmrs = Ssrteclmrs::findOrFail($request->id); 
            $message = "La ssrteclmrs a été mise à jour avec succès";

        } else {
            $ssrteclmrs = new Ssrteclmrs(); 
            $producteur = Producteur::where('id',$request->producteur)->first();
            $ssrteclmrs->codeMembre = $this->generecodessrte($request->producteur,$producteur->codeProdapp);
            
        } 
        
        $ssrteclmrs->producteur_id  = $request->producteur;  
        $ssrteclmrs->nomMembre  = $request->nomMembre;
        $ssrteclmrs->prenomMembre  = $request->prenomMembre;
        $ssrteclmrs->sexeMembre     = $request->sexeMembre;
        $ssrteclmrs->datenaissMembre    = $request->datenaissMembre;
        $ssrteclmrs->lienParente = $request->lienParente; 
        $ssrteclmrs->autreLienParente    = $request->autreLienParente; 
        $ssrteclmrs->frequente  = $request->frequente;
        $ssrteclmrs->niveauEtude     = $request->niveauEtude;
        $ssrteclmrs->classe    = $request->classe;
        $ssrteclmrs->ecoleVillage = $request->ecoleVillage; 
        $ssrteclmrs->distanceEcole    = $request->distanceEcole;
        $ssrteclmrs->nomEcole     = $request->nomEcole;
        $ssrteclmrs->moyenTransport  = $request->moyenTransport;
        $ssrteclmrs->moyenTransport    = $request->moyenTransport;
        $ssrteclmrs->avoirFrequente = $request->avoirFrequente; 
        $ssrteclmrs->niveauEtudeAtteint    = $request->niveauEtudeAtteint;
        $ssrteclmrs->date_enquete     = $request->date_enquete; 

        $ssrteclmrs->save(); 

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

        $notify[] = ['success', isset($message) ? $message : 'Le ssrteclmrs a été crée avec succès.'];
        return back()->withNotify($notify);
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

    public function edit($id)
    {
        $pageTitle = "Mise à jour de la ssrteclmrs";
        $localites  = Localite::active()->where('cooperative_id',auth()->user()->cooperative_id)->orderBy('nom')->get();
        $producteurs  = Producteur::with('localite')->get();
        $niveauEtude = NiveauxEtude::pluck('nom','id')->all();
        $classes = ClasseEtude::with('niveau')->get();
        $moyenTransport = DB::table('moyens_transport')->pluck('nom','nom')->all();
        $lienParente = DB::table('lien_parente')->pluck('nom','nom')->all();
        $raisonArretEcole = DB::table('arret_ecoles')->get();
            $travauxDangereux = DB::table('travaux_dangereux')->get();
            $lieuTravaux = DB::table('lieux_travaux')->get();
            $travauxLegers = DB::table('travaux_legers')->get();
        $ssrteclmrs   = Ssrteclmrs::findOrFail($id); 
          
         
        return view('manager.ssrteclmrs.edit', compact('pageTitle', 'localites', 'ssrteclmrs','producteurs','raisonArretEcole','travauxDangereux','lieuTravaux','travauxLegers','lienParente','niveauEtude','moyenTransport','classes'));
    } 

    public function status($id)
    {
        return Ssrteclmrs::changeStatus($id);
    }

    public function exportExcel()
    { 
        $filename = 'ssrteclmrs-' . gmdate('dmYhms') . '.xlsx';
        return Excel::download(new ExportSsrteclmrs, $filename);
    }
    
}
