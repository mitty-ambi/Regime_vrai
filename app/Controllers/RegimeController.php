<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controllers\BaseController;
use App\Models\Regime;

class RegimeController extends BaseController
{
    public function go_to_regime()
    {   
        return view('CrudRegime');
    }   
}

?>