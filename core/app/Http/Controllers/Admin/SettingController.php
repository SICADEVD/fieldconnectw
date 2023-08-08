<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use App\Models\CourierInfo;
use App\Models\CourierPayment;
use App\Models\CourierProduct;
use App\Models\Campagne; 
use App\Models\TravauxDangereux;
use App\Models\TravauxLegers;
use App\Models\ArretEcole;
use App\Models\CategorieQuestionnaire;
use App\Models\Questionnaire;
use App\Models\ThemesFormation;
use App\Models\TypeFormation;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{

    public function configIndex()
    {
        $pageTitle = "Manage Unit";
        $configs     = Unit::orderBy('name')->paginate(getPaginate());
        return view('admin.config.config', compact('pageTitle', 'configs'));
    }

    public function configStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        if ($request->id) {
            $config    = Unit::findOrFail($request->id);
            $message = 'Unit updated successfully';
        } else {
            $config = new Unit();
        }
        $config->name   = $request->name;
        $config->save();
        $notify[] = ['success', isset($message) ? $message : 'Unit added successfully'];
        return back()->withNotify($notify);
    }

    public function campagneIndex()
    {
        $pageTitle = "Manage Campagne"; 
        $campagnes     = Campagne::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.config.campagne', compact('pageTitle', 'campagnes'));
    }

    public function campagneStore(Request $request)
    {
        $request->validate([
            'produit'  => 'required',
            'nom'  => 'required',
            'periode_debut'  => 'required',
            'periode_fin'  => 'required', 
            'prix_achat' => 'required|gt:0|numeric',
            'prime' => 'required|gt:0|numeric',
        ]);

        if ($request->id) {
            $campagne    = Campagne::findOrFail($request->id);
            $message = "Campagne a été mise à jour avec succès.";
        } else {
            $campagne = new Campagne();
        }
        $campagne->produit    = $request->produit ;
        $campagne->nom = $request->nom;
        $campagne->periode_debut = $request->periode_debut;
        $campagne->periode_fin = $request->periode_fin;
        $campagne->prix_achat   = $request->prix_achat;
        $campagne->prime   = $request->prime;
        $campagne->save();
        $notify[] = ['success', isset($message) ? $message  : 'Campagne a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function travauxDangereuxIndex()
    {
        $pageTitle = "Manage Travaux Dangereux"; 
        $travauxDangereux     = TravauxDangereux::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.config.travauxDangereux', compact('pageTitle', 'travauxDangereux'));
    }

    public function travauxDangereuxStore(Request $request)
    {
        $request->validate([ 
            'nom'  => 'required', 
        ]);

        if ($request->id) {
            $travauxDangereux    = TravauxDangereux::findOrFail($request->id);
            $message = "Travaux Dangereux a été mise à jour avec succès.";
        } else {
            $travauxDangereux = new TravauxDangereux();
        } 
        $travauxDangereux->nom = trim($request->nom); 
        $travauxDangereux->save();
        $notify[] = ['success', isset($message) ? $message  : 'Travaux Dangereux a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function travauxLegersIndex()
    {
        $pageTitle = "Manage Travaux Legers"; 
        $travauxLegers     = TravauxLegers::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.config.travauxLegers', compact('pageTitle', 'travauxLegers'));
    }

    public function travauxLegersStore(Request $request)
    {
        $request->validate([ 
            'nom'  => 'required', 
        ]);

        if ($request->id) {
            $travauxLegers    = TravauxLegers::findOrFail($request->id);
            $message = "Travaux Legers a été mise à jour avec succès.";
        } else {
            $travauxLegers = new TravauxLegers();
        } 
        $travauxLegers->nom = trim($request->nom); 
        $travauxLegers->save();
        $notify[] = ['success', isset($message) ? $message  : 'Travaux Legers a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function arretEcoleIndex()
    {
        $pageTitle = "Manage Arret Ecole"; 
        $arretEcole     = ArretEcole::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.config.arretEcole', compact('pageTitle', 'arretEcole'));
    }

    public function arretEcoleStore(Request $request)
    {
        $request->validate([ 
            'nom'  => 'required', 
        ]);

        if ($request->id) {
            $arretEcole    = ArretEcole::findOrFail($request->id);
            $message = "Arret Ecole a été mise à jour avec succès.";
        } else {
            $arretEcole = new ArretEcole();
        } 
        $arretEcole->nom = trim($request->nom); 
        $arretEcole->save();
        $notify[] = ['success', isset($message) ? $message  : 'Arret Ecole a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function typeFormationIndex()
    {
        $pageTitle = "Manage Type Formation"; 
        $typeFormation     = TypeFormation::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.config.typeFormation', compact('pageTitle', 'typeFormation'));
    }

    public function typeFormationStore(Request $request)
    {
        $request->validate([ 
            'nom'  => 'required', 
        ]);

        if ($request->id) {
            $typeFormation    = TypeFormation::findOrFail($request->id);
            $message = "Type Formation a été mise à jour avec succès.";
        } else {
            $typeFormation = new TypeFormation();
        } 
        $typeFormation->nom = trim($request->nom); 
        $typeFormation->save();
        $notify[] = ['success', isset($message) ? $message  : 'Type Formation a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function themeFormationIndex()
    {
        $pageTitle = "Manage theme de Formation"; 
        $themeFormation     = ThemesFormation::with('typeFormation')->orderBy('id','desc')->paginate(getPaginate());
        $typeFormation = TypeFormation::get();
        return view('admin.config.themeFormation', compact('pageTitle', 'themeFormation','typeFormation'));
    }

    public function themeFormationStore(Request $request)
    {
        $request->validate([ 
            'nom'  => 'required',
            'typeformation'=>'required',
        ]);

        if ($request->id) {
            $themeFormation    = ThemesFormation::findOrFail($request->id);
            $message = "theme de Formation a été mise à jour avec succès.";
        } else {
            $themeFormation = new ThemesFormation();
        } 
        $themeFormation->nom = trim($request->nom); 
        $themeFormation->type_formation_id = $request->typeformation;
        $themeFormation->save();
        $notify[] = ['success', isset($message) ? $message  : 'theme de Formation a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function categorieQuestionnaireIndex()
    {
        $pageTitle = "Manage Categorie Questionnaire"; 
        $categorieQuestionnaire     = CategorieQuestionnaire::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.config.categorieQuestionnaire', compact('pageTitle', 'categorieQuestionnaire'));
    }

    public function categorieQuestionnaireStore(Request $request)
    {
        $request->validate([ 
            'titre'  => 'required', 
        ]);

        if ($request->id) {
            $categorieQuestionnaire    = CategorieQuestionnaire::findOrFail($request->id);
            $message = "Categorie Questionnaire a été mise à jour avec succès.";
        } else {
            $categorieQuestionnaire = new CategorieQuestionnaire();
        } 
        $categorieQuestionnaire->titre = trim($request->titre); 
        $categorieQuestionnaire->save();
        $notify[] = ['success', isset($message) ? $message  : 'Categorie Questionnaire a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }

    public function questionnaireIndex()
    {
        $pageTitle = "Manage Questionnaire"; 
        $questionnaire     = Questionnaire::with('categorieQuestion')->orderBy('id','desc')->paginate(getPaginate());
        $categorieQuestion = CategorieQuestionnaire::get();
        return view('admin.config.questionnaire', compact('pageTitle', 'questionnaire','categorieQuestion'));
    }

    public function questionnaireStore(Request $request)
    {
        $request->validate([ 
            'nom'  => 'required',
            'categoriequestionnaire'=>'required',
        ]);

        if ($request->id) {
            $questionnaire    = Questionnaire::findOrFail($request->id);
            $message = "Questionnaire a été mise à jour avec succès.";
        } else {
            $questionnaire = new Questionnaire();
        } 
        $questionnaire->nom = trim($request->nom); 
        $questionnaire->categorie_questionnaire_id = $request->categoriequestionnaire;
        $questionnaire->save();
        $notify[] = ['success', isset($message) ? $message  : 'Questionnaire a été ajouté avec succès.'];
        return back()->withNotify($notify);
    }
    
    public function campagneStatus($id)
    {
        return Campagne::changeStatus($id);
    }
    public function travauxDangereuxStatus($id)
    {
        return TravauxDangereux::changeStatus($id);
    }

    public function travauxLegersStatus($id)
    {
        return TravauxLegers::changeStatus($id);
    }
    public function arretEcoleStatus($id)
    {
        return ArretEcole::changeStatus($id);
    }
    public function typeFormationStatus($id)
    {
        return TypeFormation::changeStatus($id);
    }
    public function themeFormationStatus($id)
    {
        return ThemesFormation::changeStatus($id);
    }

    public function categorieQuestionnaireStatus($id)
    {
        return CategorieQuestionnaire::changeStatus($id);
    }

    public function questionnaireStatus($id)
    {
        return Questionnaire::changeStatus($id);
    }
}
