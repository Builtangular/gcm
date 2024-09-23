<?php

namespace App\Controllers;
   
use App\Models\PaymentModel;
use App\Models\ProfileModel;
use App\Models\VehicleModel;
use App\Models\BookingsModel;
use App\Models\CustomersModel;
use App\Models\TaxInvoiceModel;
use App\Models\ExpenseHeadModel;
use App\Models\PaymentTypeModel;
use App\Models\FuelPumpBrandModel;
use App\Controllers\BaseController;
use App\Models\BookingExpensesModel;
use App\Models\DriverModel;
use App\Models\ProformaInvoiceModel;
use CodeIgniter\HTTP\ResponseInterface;

class Payments extends BaseController
{ 
    public $session; 
    public $BookingsModel;
    public $TaxInvoiceModel;
    public $BEModel;
    public $ExpenseHeadModel;
    public $CModel;
    public $added_by;
    public $PaymentTypeModel;
    public $PaymentModel;
    public $VehicleModel;
    public $FuelPumpBrandModel;
    public $DModel;
    public function __construct()
    { 
      $this->session = \Config\Services::session(); 
      $this->BookingsModel = new BookingsModel();
      $this->TaxInvoiceModel= new TaxInvoiceModel();
      $this->BEModel = new BookingExpensesModel();
      $this->ExpenseHeadModel = new ExpenseHeadModel();    
      $this->CModel = new CustomersModel();
      $this->added_by = isset($_SESSION['id']) ? $_SESSION['id'] : '0'; 
      $this->PaymentTypeModel = new PaymentTypeModel();
      $this->PaymentModel = new PaymentModel();
      $this->VehicleModel = new VehicleModel();
      $this->FuelPumpBrandModel = new FuelPumpBrandModel();
      $this->DModel = new DriverModel();
    }
  
    public function index()
    {      
        $this->view['payments']  = $this->PaymentModel
        ->select('payments.*,p.party_name,pt.name payment_type,v.rc_number')
        ->join('driver d','d.id= payments.driver_id')
        ->join('party p', 'p.id = d.party_id','left') 
        ->join('payment_types pt','pt.id= payments.payment_type_id') 
        ->join('vehicle v', 'v.id = payments.vehicle_id','left') 
        ->findAll();
        // echo ' <pre>';print_r($this->view['payments']); exit;
        return view('Payment/index', $this->view); 
    }  

    function create(){
        $this->view['drivers'] = $this->DModel->select('driver.*, party.party_name as driver_name') 
        ->join('party', 'party.id = driver.party_id') 
        ->orderBy('party.party_name', 'asc')
        ->findAll();
  
        $this->view['fuel_pump_brands']  = $this->FuelPumpBrandModel->where('status',1)->findAll();
        $this->view['vehicles']  = $this->VehicleModel->where('status',1)->findAll();
        $this->view['payment_types']  = $this->PaymentTypeModel->findAll();

        $this->view['bookings'] = $this->BookingsModel->findAll(); 

        //get vendors
        $this->view['vendors'] = $this->CModel
        ->select('customer.id,p.party_name')
        ->join('party p', 'p.id = customer.party_id') 
        ->where("FIND_IN_SET (6,customer.party_type_id)")
        ->findAll(); 

        if($this->request->getPost()){
            $error = $this->validate([
                'driver_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The driver field is required'
                    ],
                ],
                'payment_type_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The payment type field is required'
                    ],
                ], 
                'amount' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The amount field is required'
                    ],
                ],
                'payment_mode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'The payment mode field is required'
                    ],
                ], 
            ]);
            if($this->request->getPost('payment_type_id') == 1){
                $this->validate([
                    'fuel_fill_type' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The fuel fill type field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('vendor_id') == 2){
                $this->validate([
                    'vendor_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The vendor field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('vendor_id') == 1 || $this->request->getPost('vendor_id') == 2){
                $this->validate([
                    'vehicle_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The vehicle field is required'
                        ],
                    ],
                ]);

                $this->validate([
                    'quantity' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The quantity field is required'
                        ],
                    ],
                ]);

                $this->validate([
                    'km_reading' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The km reading is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('fuel_fill_type') == 1){
                $this->validate([
                    'transfer_from_vehicle_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The transfer from vehicle field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('fuel_fill_type') == 2){
                $this->validate([
                    'fuel_pump_brand_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The fuel pump brand field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_mode') == 1){
                $this->validate([
                    'card_no' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The card no field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_mode') == 2){
                $this->validate([
                    'upi_no' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The upi no field is required'
                        ],
                    ],
                ]);
            }

            if($this->request->getPost('payment_mode') == 3){
                $this->validate([
                    'account_no' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'The account no field is required'
                        ],
                    ],
                ]);
            }
            $validation = \Config\Services::validation();
            // echo 'POst dt<pre>';print_r($this->request->getPost());
            // echo 'getErrors<pre>';print_r($validation->getErrors()); exit;
            if (!empty($validation->getErrors())) {
                $this->view['error'] = $this->validator;
            } else {  
              $data['fuel_fill_type'] = $this->request->getVar('fuel_fill_type');
              $data['vehicle_id'] = $this->request->getVar('vehicle_id');
              $data['driver_id'] = $this->request->getVar('driver_id');
              $data['transfer_from_vehicle_id'] = $this->request->getVar('transfer_from_vehicle_id');
              $data['km_reading'] = $this->request->getVar('km_reading');
              $data['quantity'] = $this->request->getVar('quantity');
              $data['fuel_pump_brand_id'] = $this->request->getVar('fuel_pump_brand_id');
              $data['vendor_id'] = $this->request->getVar('vendor_id');
              $data['amount'] = $this->request->getVar('amount');
              $data['payment_type_id'] = $this->request->getVar('payment_type_id');
              $data['payment_mode'] = $this->request->getVar('payment_mode');
              $data['card_no'] = $this->request->getVar('card_no');
              $data['upi_no'] = $this->request->getVar('upi_no');
              $data['account_no'] = $this->request->getVar('account_no');
              $data['transaction_no'] = $this->request->getVar('transaction_no');
              $data['reason_id'] = $this->request->getVar('reason_id'); 
              $data['created_by'] =  $this->added_by;
              $this->PaymentModel->save($data); 
              // echo 'data<pre>';print_r($data);exit;
              $this->session->setFlashdata('success', 'Payment Added Successfully');
      
              return $this->response->redirect(base_url('/payments'));
            }
          }

        return view('Payment/form', $this->view); 
    }
}
