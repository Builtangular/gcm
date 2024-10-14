<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentTypeFieldsModel extends Model
{
    // Common methods can be defined here
   /*  public function insertData($table, $data)
    {
        // Update the record(s) where status is 'active'
        return $this->db->table($table)
                        ->insert($data);
    }

    public function getData($table, $id)
    {
        $this->db->where('payment_type_id',$id);
        $result = $this->db->get($table);
        return $result->row();


        return $this->db->table($table)->where('payment_type_id', $id)->get();
    } */

    protected $table            = 'payment_type_fields';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['payment_type_id', 'field_id', 'mandatory'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
?>