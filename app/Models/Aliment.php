<?php
namespace App\Models;
use CodeIgniter\Model;

class Aliment extends Model
{
    protected $table = "aliments";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'calories', 'type'];
    protected $useTimestamps = false;
}
?>