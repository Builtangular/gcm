<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialsModel extends Model
{
    protected $table            = 'materials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'status', 'added_date', 'added_by', 'added_ip', 'updated_date', 'updated_by', 'updated_ip', 'isDeleted'];
}
