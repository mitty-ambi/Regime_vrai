<?php
namespace App\Models;
use CodeIgniter\Model;

class Parametre extends Model
{
    protected $table = "parametre";
    protected $primaryKey = 'id';
    protected $allowedFields = ['imc_ideal'];
    protected $useTimestamps = false;
}
?>