<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
	protected $table = 'profile';

	protected $primaryKey = 'id';

	protected $allowedFields = ['company_name', 'abbreviation', 'email', 'phone_number', 'landline_number', 'alternate_phone_number', 'otherid', 'gst', 'pan_no', 'company_logo', 'company_business_address', 'city', 'state', 'country', 'pincode', 'purchase_order_prefix', 'invoice_prefix', 'booking_prefix', 'created_at', 'updated_at'];
}
