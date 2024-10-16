<?php

namespace App\Models;

use CodeIgniter\Model;

class TyreTypeModel extends Model
{
    protected $table            = 'tyre_type';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type', 'status', 'added_date', 'added_by', 'added_ip', 'updated_date', 'updated_by', 'updated_ip'];
}
