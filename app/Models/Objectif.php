<?php
namespace App\Models;
use CodeIgniter\Model;

class Sante extends Model
{
    protected $table = "objectifs";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
    protected $useTimestamps = false;
}
?>