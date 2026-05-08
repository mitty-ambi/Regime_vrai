<?php
namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);


use App\Controllers\BaseController;
use App\Models\Regime;

class RegimeController extends BaseController
{
    protected $regimeModel;
    public function __construct()
    {
        
    }
    public function go_to_regime()
    {
        $regime = new Regime();
        $data['liste_regime'] = $regime->findAll();
        return view('CrudRegime', $data);
    }

}