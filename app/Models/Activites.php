<?php
namespace App\Models;
use CodeIgniter\Model;

class Activites extends Model
{
    protected $table = "activites";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'calories_brulees'];
    protected $useTimestamps = false;

    public function associerRegime($id_regime, $id_activite)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('regime_activite');

        $exists = $builder->where('id_regime', $id_regime)
            ->where('id_activite', $id_activite)
            ->get()
            ->getRow();

        if (!$exists) {
            return $builder->insert([
                'id_regime' => $id_regime,
                'id_activite' => $id_activite
            ]);
        }
        return false;
    }
}