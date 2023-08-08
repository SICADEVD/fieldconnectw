<?php

namespace App\Exports;
  
use Maatwebsite\Excel\Concerns\WithMultipleSheets;  

class ExportSuiviParcelles implements WithMultipleSheets
{
     
  public function sheets(): array 
    {    
      $feuilles=array();  
      $feuilles[] = new AgroforesterieExport(); 
      $feuilles[] = new OmbragesExport(); 
      $feuilles[] = new AnimalsExport(); 
      $feuilles[] = new ParasitesExport(); 

    $sheets = [ new SuiviParcellesExport(), ];
    $sheets = array_merge($sheets, $feuilles);
   

    return $sheets; 
    }
  
}
