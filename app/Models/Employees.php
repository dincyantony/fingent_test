<?php 
namespace App\Models;

use CodeIgniter\Model;

class Employees extends Model
{
    protected $table = 'employees'; 
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = ['emp_code', 'emp_name','designation','age','experience'];
    protected $useTimestamps = false;

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

}