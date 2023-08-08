<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CooperativeController extends Controller
{

    public function index()
    {
        $pageTitle = "Gestion des coopératives";
        $cooperatives  = Cooperative::searchable(['codeCoop','codeApp','name', 'email', 'phone', 'address'])->orderBy('name', 'DESC')->paginate(getPaginate());
        return view('admin.cooperative.index', compact('pageTitle', 'cooperatives'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|max:40',
            'email'   => 'required|email|max:40',
            'phone'   => 'required|max:40',
            'address' => 'required|max:255',
            'web' => 'required|max:255',
            'mobile' => 'required|max:255',
        ]);
        
        if ($request->id) {
            $cooperative  = Cooperative::findOrFail($request->id);
            $message = "La coopérative a été mise à jour avec succès";
        } else {
            $cooperative  = new Cooperative();
            $message = "La coopérative a été ajoutée avec succès";
        }

        $cooperative->codeCoop    = $request->codeCoop;
        $cooperative->name    = $request->name;
        $cooperative->email   = $request->email;
        $cooperative->phone   = $request->phone;
        $cooperative->address = $request->address;
        $cooperative->web = $request->web;
        $cooperative->mobile = $request->mobile;
        $cooperative->codeApp   = isset($request->codeApp) ? $request->codeApp : $this->generecodeapp($request->name); 
        $cooperative->save();

        $notify[] = ['success',$message];
        return back()->withNotify($notify);
    }

    private function generecodeapp($name)
    {

        $data = Cooperative::select('codeApp')->orderby('id','desc')->limit(1)->get();

        if(count($data)>0){
            $code = $data[0]->codeApp;

        $chaine_number = Str::afterLast($code,'-');

        if($chaine_number<10){$zero="00";}
        else if($chaine_number<100){$zero="0";}
        else{$zero="";}
        }else{
            $zero="00";
            $chaine_number=0;
        }


        $abrege=Str::upper(Str::substr($name,0,3));
        $sub=$abrege.'-';
        $lastCode=$chaine_number+1;
        $codeP=$sub.$zero.$lastCode;

        return $codeP;
    }

    public function status($id)
    {
        return Cooperative::changeStatus($id);
    }
}
