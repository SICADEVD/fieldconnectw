<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;  

class ExportProducteurs implements WithMultipleSheets
{
     
  public function sheets(): array 
    {    
      $feuilles=array();  
      $feuilles[] = new InfosProducteurExport();
      $feuilles[] = new InfosMaladiesEnfantExport();   
      $feuilles[] = new InfosTypeculturesExport();  

    $sheets = [ new ProducteursExport(), ];
    $sheets = array_merge($sheets, $feuilles);
   

    return $sheets; 
    }
  
}
