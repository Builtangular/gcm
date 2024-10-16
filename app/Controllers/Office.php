<?php
namespace App\Controllers;
use App\Models\OfficeModel;
use App\Models\CompanyModel;
use App\Models\StateModel;
use App\Models\UserModel;
use App\Models\ModulesModel;


class Office extends BaseController {

        public $_access;

        public function __construct()
        {
            $u = new UserModel();
            $access = $u->setPermission();
            $this->_access = $access; 
        }

        public function index()
        {
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
              $officeModel = new OfficeModel();
              $this->view['office_data'] = $officeModel->where('status',1)->orderBy('id', 'DESC')->paginate(10);
              $this->view['pagination_link'] = $officeModel->pager;
              $this->view['page_data'] = [
                'page_title' => view( 'partials/page-title', [ 'title' => 'Company','li_1' => '123','li_2' => 'deals' ] )
                ];
              return view('Office/index',$this->view);
          }
        }

        public function create()
        {
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
              helper(['form', 'url']);
              $this->view ['page_data']= [
                'page_title' => view( 'partials/page-title', [ 'title' => 'Add Office','li_2' => 'profile' ] )
                ];

                $companyModel = new CompanyModel();
                $stateModel = new StateModel();
                $this->view['company'] = $companyModel->where(['status'=>'Active'])->orderBy('name','ASC')->findAll();
                $this->view['state'] = $stateModel->where(['isStatus'=>'1'])->orderBy('state_name','ASC')->orderBy('state_id')->findAll();
                $request = service('request');
                if($this->request->getMethod()=='POST'){
                  $error = $this->validate([
                    'office_name'	  =>	'required|trim|is_unique[office.name]',
                    'company_name'	=>	'required',
                    'office_code'   =>  'required',
                    'address'       =>  'required',
                    'state'         =>  'required',
                    'city'          =>  'required',
                    'postcode'      =>  'required',
                  ]);
                  if(!$error) {
                    $this->view['error'] 	= $this->validator;
                  }else {
                    $officeModel = new OfficeModel();
                    $officeModel->save([
                      'company_id'	=>	$this->request->getVar('company_name'),
                      'name'	=>	$this->request->getVar('office_name'),
                      'gst'	=>	$this->request->getVar('gst'),
                      'office_code'	=>	 $request->getPost('office_code'),
                      'city'    =>  $request->getPost('city'),
                      'address'	=>	$request->getPost('address'),
                      'state'	=>	$request->getPost('state'),
                      'postcode'	=>	$request->getPost('postcode'),
                      'booking_prefix'	=>	$request->getPost('book_prefix'),
                      'status'  => 1,
                      'created_at'  =>  date("Y-m-d h:i:sa"),
                      'creator_ip_address'=>	$_SERVER['REMOTE_ADDR'],
                      'user_id'     => 1
                    ]);
                    $session = \Config\Services::session();
                    $session->setFlashdata('success', 'Office Added');
                    return $this->response->redirect(site_url('/office'));
                  }
                }
                return view( 'Office/create',$this->view );
          }
        }

         public function edit($id=null)
         {
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
              $companyModel = new CompanyModel();
              $stateModel = new StateModel();
                
              $this->view['company'] = $companyModel->where(['status'=>'Active'])->orderBy('name','ASC')->findAll();
              $this->view['state'] = $stateModel->where(['isStatus'=>'1'])->orderBy('state_id')->findAll();

              $officeModel = new OfficeModel();
              $this->view['office_data'] = $officeModel->where('id', $id)->first();
              
              $request = service('request');
              if($this->request->getMethod()=='POST'){
                $id = $this->request->getVar('id');
                $error = $this->validate([
                  'office_name'	  =>	'required|trim|is_unique[office.name, office.id,'.$id.']',
                  'company_name'	=>	'required',
                  'office_code'   =>  'required',
                  'address'       =>  'required',
                  'state'         =>  'required',
                  'city'          =>  'required',
                  'postcode'      =>  'required',
                ]);
                if(!$error)
                {
                  $this->view['error'] 	= $this->validator;
                  
                }else {
                  $officeModel = new OfficeModel();
                  $officeModel->update($id,[
                    'company_id'	=>	$this->request->getVar('company_name'),
                    'name'	=>	$this->request->getVar('office_name'),
                    'gst'	=>	$this->request->getVar('gst'),
                    'office_code'	=>	 $request->getPost('office_code'),
                    'address'	=>	$request->getPost('address'),
                    'state'	=>	$request->getPost('state'),
                    'city'	=>	$request->getPost('city'),
                    'postcode'	=>	$request->getPost('postcode'),
                    'booking_prefix'	=>	$request->getPost('book_prefix'),
                    'status'  => 1,
                    'updated_at'  =>  date("Y-m-d h:i:sa"),
                    'creator_ip_address'=>	$_SERVER['REMOTE_ADDR'],
                    'user_id'     => 1
                  ]);
                  $session = \Config\Services::session();
      
                  $session->setFlashdata('success', 'Office updated');
                  return $this->response->redirect(site_url('/office'));
                }
      
                
              }

              return view('Office/edit_office', $this->view);
          }

         }

         public function delete($id){
          
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
              $companyModel = new OfficeModel();
              $companyModel->where('id', $id)->delete($id);
              $session = \Config\Services::session();
              $session->setFlashdata('success', 'Office Deleted');
              return $this->response->redirect(site_url('/office'));
          }
         }

         
        public function preview($id=null){
          
          $access = $this->_access; 
          if($access === 'false'){
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
          }else{
              $companyModel = new CompanyModel();
              $stateModel = new StateModel();
                
              $this->view['company'] = $companyModel->where(['status'=>'Active'])->orderBy('id')->findAll();
              $this->view['state'] = $stateModel->where(['isStatus'=>'1'])->orderBy('state_id')->findAll();

              $officeModel = new OfficeModel();
              $this->view['office_data'] = $officeModel->where('id', $id)->first();
              
              return view('Office/details', $this->view);
          }
        }

        public function status($id=null){
          $access = $this->_access; 
          if($access === 'false'){
              $session = \Config\Services::session();
              $session->setFlashdata('error', 'You are not permitted to access this page');
              return $this->response->redirect(site_url('/dashboard'));
          }else{

              $officeModel = new OfficeModel();
              $cModel = $officeModel->where('id', $id)->first();
              if(isset($cModel)){
                if($cModel['status'] == 0){
                  $status = 1;
                }else{
                  $status = 0;
                }
              }
              $officeModel->update($id,[
                  'status'              => $status,
                  'updated_at'         =>  date("Y-m-d h:i:sa"),
              ]);
              $session = \Config\Services::session();
              $session->setFlashdata('success', 'Office Status updated');
              return $this->response->redirect(site_url('/office'));
          }
      }

        public function searchByStatus(){
          if($this->request->getMethod()=='POST'){
            $status = $this->request->getVar('status');
            $oModel = new OfficeModel();
            $this->view['oModel'] = $oModel->where('status', $status)->orderBy('id', 'DESC')->findAll();
            $this->view['page_data'] = [
            'page_title' => view( 'partials/page-title', [ 'title' => 'Offices','li_1' => '123','li_2' => 'deals' ] )
            ];
            return view('Office/search',$this->view);
          }
        }
}
?>