<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;  

class ExportApplications  implements WithMultipleSheets
{
     
  public function sheets(): array 
    {    
      $feuilles=array();  
      $feuilles[] = new InsectesExport();
      $feuilles[] = new MatieresactivesExport();    

    $sheets = [ new ApplicationsExport(), ];
    $sheets = array_merge($sheets, $feuilles);
   

    return $sheets; 
    }
  
}
