<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FieldsModel;
use App\Models\UserModel;

class Fields extends BaseController
{
    public $_access;
    public function __construct()
    {
        $this->session = \Config\Services :: session();
        $u = new UserModel();
        $access = $u->setPermission();
        $this->_access = $access;
        $this->fieldsModel = new FieldsModel();
    }
    public function index(){
        $access = $this->_access;
        if ($access === 'false') {
          $session = \Config\Services::session();
          $session->setFlashdata('error', 'You are not permitted to access this page');
          return $this->response->redirect(site_url('/dashboard'));
        } else {
    
          $this->view['fields_data'] = $this->fieldsModel->orderBy('id', 'DESC')->findAll();
          $this->view['pagination_link'] = $this->fieldsModel->pager;
          $this->view['page_data'] = [
            'page_title' => view('partials/page-title', ['name' => 'fields', 'li_1' => '123', 'li_2' => 'deals'])
          ];
          return view('Fields/index', $this->view);
        }
    }
    public function create()
    {
        $access = $this->_access;
        if ($access === 'false') {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'You are not permitted to access this page');
            return $this->response->redirect(site_url('/dashboard'));
        } else {
            helper(['form', 'url']);
            $this->view['page_data'] = [
                'page_title' => view('partials/page-title', ['name' => 'Add Fields', 'li_2' => 'profile'])
            ];
            $request = service('request');
            if ($this->request->getMethod() == "POST") {

                // var_dump($_POST); die;
                $error = $this->validate([
                    'name'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
                  ]);
                //   var_dump($error); die;
                  if (!$error) {
                    $this->view['error']   = $this->validator;
                  } else {
                    $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('name')));
                    $fields_data = $this->fieldsModel
                      ->where('status', 'Active')
                      ->where('deleted_at', NULL)
                      ->where('LOWER(REPLACE(name, " ", ""))', $normalizedStr)
                      ->orderBy('id')->countAllResults();
                    //   var_dump($fields_data); die;
                    if ($fields_data == 0) {
                      $this->fieldsModel->save([
                        'name' =>  $this->request->getVar('name'),
                        'status'  => 'Active',
                        'created_at'  =>  date("Y-m-d h:i:sa"),
                      ]);
                    } else {
                      $this->validator->setError('name', 'The field must contain a unique value.');
                      $this->view['error']  = $this->validator;
                      return view('Fields/create', $this->view);
                      return false;
                    }

                    $session = \Config\Services::session();
                    $session->setFlashdata('success', 'Fields Added');
                    return $this->response->redirect(site_url('/fields'));
                }
            }
            return view('Fields/create', $this->view);
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
            $request = service('request');
            $this->view['fields_data'] = $this->fieldsModel->where('id', $id)->first();
            // var_dump($this->view['fields_data']); die;
            if ($this->request->getMethod() == 'POST') {
                $id = $this->request->getVar('id');
                $error = $this->validate([
                    'name'   =>  'required|min_length[3]|max_length[50]|alpha_numeric_space',
                ]);
                if (!$error) {
                $this->view['error']   = $this->validator;
                } else {
                    // var_dump(id); die;
                    $normalizedStr = strtolower(str_replace(' ', '', $this->request->getVar('name')));
                    $fields_data = $this->fieldsModel
                    ->where('status', $this->request->getVar('status'))
                    ->where('deleted_at', NULL)
                    ->where('LOWER(REPLACE(name, " ", ""))', $normalizedStr)
                    ->where('id!=', $id)
                    ->orderBy('id')->countAllResults();
                    if ($fields_data == 0) {
                    $this->fieldsModel->update($id, [
                        'name'  =>  $this->request->getVar('name'),
                        'status' => $this->request->getVar('status'),
                        'updated_at'  =>  date("Y-m-d h:i:sa"),
                    ]);
                    } else {
                    $this->validator->setError('name', 'The field must contain a unique value.');
                    $this->view['error']  = $this->validator;
                    return view('Fields/create', $this->view);
                    return false;
                    }
                    $session = \Config\Services::session();
                    $session->setFlashdata('success', 'Fields updated');
                    return $this->response->redirect(site_url('/fields'));
                }
            }
            return view('Fields/edit', $this->view);
        }
    }
    public function delete($id)
    {
        $access = $this->_access;
        if ($access === 'false') {
        $session = \Config\Services::session();
        $session->setFlashdata('error', 'You are not permitted to access this page');
        return $this->response->redirect(site_url('/dashboard'));
        } else {
        $this->fieldsModel->where('id', $id)->delete($id);
        $session = \Config\Services::session();
        $session->setFlashdata('success', 'Fields Deleted');
        return $this->response->redirect(site_url('/fields'));
        }
    }
}
?>