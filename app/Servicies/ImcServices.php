<?php
namespace App\Servicies;

class ImcServices {
    function calculerImc(float $poid,float $taille ) : float {
        return $poid / $taille*$taille;
    }
}
?>