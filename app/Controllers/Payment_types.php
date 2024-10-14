<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaymentTypeModel;
use App\Models\FieldsModel;
use App\Models\PaymentTypeFieldsModel;
use App\Models\UserModel;

class Payment_types extends BaseController
{
    public $_access;
    public function __construct()
    {
        $this->session = \Config\Services :: session();
        $u = new UserModel();
        $access = $u->setPermission();
        $this->_access = $access;
        $this->PaymentTypeModel = new PaymentTypeModel();
    }
    public function index()
    {
        $this->view['data'] = $this->PaymentTypeModel->select('name,id')->findAll();
        $this->PaymentTypeModel->select('payment_types.*');
        $this->view['data']  = $this->PaymentTypeModel->findAll();
        return view('PaymentType/index', $this->view);
    }

    public function create()
    {
        $access = $this->_access;
        if ($access === 'false') {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            $FieldsModel = new FieldsModel();
            $this->view['fields'] = $FieldsModel->where('status', 'Active')->findAll();
        
            // var_dump($_POST); die;
            $request = service('request');
            if($this->request->getMethod() == "POST") {
                
                $error = $this->validate([
                    'name' =>  'required|alpha_numeric_space|is_unique[payment_types.name]',
                ]);
                if ($error) {
                    $this->view['error']  = $this->validator;
                } else {
                    $this->PaymentTypeModel->save([
                    'name'      =>  $this->request->getVar('payment_type_name'),
                    'created_at'  =>  date("Y-m-d h:i:sa"),
                    ]);
                    $payment_type_id = $this->PaymentTypeModel->getInsertID();
                    // var_dump($payment_type_id); die;
                    $fields_array = $this->request->getVar('fields');
                    // var_dump($fields_array); die;
                    if (!isset($fields_array) || empty($fields_array)) {
                        $this->view['error'] = "Please select atleast one flag";
                    } else {
                        $PaymentTypeFieldsModel = new PaymentTypeFieldsModel();
                        foreach ($fields_array as $key => $value) {
                            $fieldsData = [
                                'payment_type_id' =>  $payment_type_id,
                                'field_id' =>   $value,
                                'mandatory' => $this->request->getVar('radio_' . $value)
                            ];
                            // print_r($fieldsData); 
                            /* $table = 'payment_type_fields';             
                            $result = $PaymentTypeFieldsModel->insertData($table, $fieldsData); */
                            $PaymentTypeFieldsModel->save($fieldsData);
                        }
                        // die;
                    }

                    $session = \Config\Services::session();
                    $session->setFlashdata('success', 'Payment type added successfully');
                    return $this->response->redirect(site_url('/payment_types'));
                }
            }
            return view('PaymentType/create', $this->view);            
        }
    }

    public function edit($id = null)
    {
        $access = $this->_access;
        if ($access === 'false') {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            $this->view['paymenttypedata'] = $this->PaymentTypeModel->where('id', $id)->first();
            $FieldsModel = new FieldsModel();
            $this->view['fields'] = $FieldsModel->where('status', 'Active')->findAll();
            $id = $this->request->getVar('id');

            $PaymentTypeFieldsModel = new PaymentTypeFieldsModel();
            // $table = 'payment_type_fields'; 
            // $this->view['fieldsData'] = $PaymentTypeFieldsModel->getData($table, $id);
            $this->view['fieldsData'] = $PaymentTypeFieldsModel->where('payment_type_id', $id)->findAll();
            
            $this->view['PaymentTypeFieldsModel'] = $PaymentTypeFieldsModel;
            $request = service('request');
            if ($this->request->getMethod() == 'POST') {                
                $error = $this->validate([
                'payment_type_name' =>  'required|alpha_numeric_space',
                'fields' =>  'required',
                ]);
                if (!$error) {
                    $this->view['error']   = $this->validator;
                } else {
                    // $businestsypeModel = new BusinessTypeModel();
                    $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('payment_type_name')));
                    
                    $PaymentType_data = $this->PaymentTypeModel
                        // ->where('status', 'Active')
                        ->where('deleted_at', NULL)
                        ->where('LOWER(REPLACE(name, " ", ""))', $normalizedStr)
                        ->where('id!=', $id)
                        ->orderBy('id')->countAllResults();
                        // var_dump($PaymentType_data); die;
                    if ($PaymentType_data == 0) {
                        $this->PaymentTypeModel->update($id, [
                        'name'  =>  $this->request->getVar('payment_type_name'),
                        'updated_at'  =>  date("Y-m-d h:i:sa"),
                        ]);
                        $PaymentTypeFieldsModelData = $PaymentTypeFieldsModel->where('payment_type_id', $id)->delete();

                        $fields_array = $this->request->getVar('fields');
                            // var_dump($fields_array); die;
                        foreach ($fields_array as $key => $value) {
                            $fieldsData1 = [
                            'payment_type_id'   =>  $id,
                            'field_id'     =>   $value,
                            'mandatory' => $this->request->getVar('radio_' . $value)
                            ];
                            $PaymentTypeFieldsModel->save($fieldsData1);
                        }
                    } else {
                        $this->validator->setError('payment_type_name', 'The field must contain a unique value.');
                        $this->view['error']  = $this->validator;
                        $this->view['paymentFields'] = $PaymentTypeFieldsModel->where('payment_type_id', $id)->findAll();
                        $this->view['paymenttypedata'] = $this->PaymentTypeModel->where('id', $id)->first();
                        return view('PaymentType/edit', $this->view);
                        return false;
                    }
                    $session = \Config\Services::session();
                    $session->setFlashdata('success', 'Payment type updated');
                    return $this->response->redirect(site_url('/payment_types'));
                }
            }

            // print_r($this->view['fieldsData']); die;
            }
            return view('PaymentType/edit', $this->view);
        }
    // }
}

?>