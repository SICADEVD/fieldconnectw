<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    public function systemInfo(){
        $laravelVersion = app()->version();
        $timeZone = config('app.timezone');
        $pageTitle = 'Application Information';
        return view('manager.system.info',compact('pageTitle', 'laravelVersion','timeZone'));
    }

    public function optimize(){
        $pageTitle = 'Clear System Cache';
        return view('manager.system.optimize',compact('pageTitle'));
    }

    public function permission(){
        $pageTitle = 'Création des permissions de routes';
        return view('manager.system.permission',compact('pageTitle'));
    }

    public function optimizeClear(){
        Artisan::call('optimize:clear');
        $notify[] = ['success','Cache cleared successfully'];
        return back()->withNotify($notify);
    }

    public function permissionRoutes(){
        Artisan::call('permission:create-permission-routes');
        $notify[] = ['success','Les permissions des routes ont été créees'];
        return back()->withNotify($notify);
    }

    public function systemServerInfo(){
        $currentPHP = phpversion();
        $pageTitle = 'Server Information';
        $serverDetails = $_SERVER;
        return view('manager.system.server',compact('pageTitle', 'currentPHP', 'serverDetails'));
    }
}
