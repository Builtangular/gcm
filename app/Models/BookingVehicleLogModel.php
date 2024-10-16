<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingVehicleLogModel extends Model
{
    protected $table            = 'booking_vehicle_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['booking_id', 'vehicle_id', 'assign_date', 'assign_by','vehicle_location','unassign_date','unassigned_by','lr_update_vehicle_date','reason_id','remarks'];
}
