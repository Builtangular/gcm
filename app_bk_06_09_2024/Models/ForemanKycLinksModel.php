<?php

namespace App\Models;

use CodeIgniter\Model;

class ForemanKycLinksModel extends Model
{
    protected $table            = 'foreman_kyc_links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['token', 'gen_for', 'gen_date', 'gen_by', 'gen_ip', 'link_used'];
}
