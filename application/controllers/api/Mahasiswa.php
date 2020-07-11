<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends CI_Controller
{
   use REST_Controller {
      REST_Controller::__construct as private __resTraitConstruct;
  }

   public function __construct()
   {
      parent::__construct();
      $this->__resTraitConstruct();
      $this->load->model('Mahasiswa_model','Mahasiswa');

      $this->methods['index_get']['limit'] = 10;
   }

   public function index_get()
   {
      $id = $this->get('id');
      if ($id === null) {
         $mahasiswa = $this->Mahasiswa->getMahasiswa();
      } else {
         $mahasiswa = $this->Mahasiswa->getMahasiswa($id);
      }
      // var_dump($mahasiswa);

      if($mahasiswa) {
         $message = [
            'status' => true,
            'data' => $mahasiswa
         ];
         $this->response($message, 200);
      } else {
         $message = [
            'status' => false,
            'message' => 'id not fount'
         ];
         $this->response($message, 404);
      }
   }

   public function index_delete()
   {
      $id = $this->delete('id');

      if ($id === null) {
         $message = [
            'status' => false,
            'message' => 'provide an id !'
         ];
         $this->response($message, 400);
      } else {
         if ($this->Mahasiswa->deleteMahasiswa($id) > 0) {
            // ok
            $message = [
               'status' => true,
               'id' => $id,
               'message' => 'deleted.'
            ];
            $this->response($message, 200);
         } else {
            // id not found
            $message = [
               'status' => false,
               'message' => 'id not found.'
            ];
            $this->response($message, 204);
         }
      }
   }

   public function index_post()
   {
      $data = [
         'nrp' => $this->post('nrp'),
         'nama' => $this->post('nama'),
         'email' => $this->post('email'),
         'jurusan' => $this->post('jurusan')
      ];

      if ($this->Mahasiswa->createMahasiswa($data) > 0) {
         $message = [
            'status' => true,
            'message' => 'new mahasiswa has been created.'
         ];
        $this->response($message, 201);
      } else {
         $message = [
            'status' => false,
            'message' => 'failed to create new data.'
         ];
         $this->response($message, 204);
      }
   }

   public function index_put()
   {
      $id = $this->put('id');
      $data = [
         'nrp' => $this->put('nrp'),
         'nama' => $this->put('nama'),
         'email' => $this->put('email'),
         'jurusan' => $this->put('jurusan')
      ];

      if ($this->Mahasiswa->updateMahasiswa($data, $id) > 0) {
         $message = [
            'status' => true,
            'message' => 'data mahasiswa has been updated.'
         ];
        $this->response($message, 201);
      } else {
         $message = [
            'status' => false,
            'message' => 'failed to create new data.'
         ];
         $this->response($message, 204);
      }
   }
}
