<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\RuanganModel;

class Ruangan extends BaseController
{
	
    protected $ruanganModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->ruanganModel = new RuanganModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'ruangan',
                'title'     		=> 'ruangan'				
			];
		
		return view('ruangan', $data);
			
	}

	public function getAll()
	{
 		$response = $data['data'] = array();	

		$result = $this->ruanganModel->select()->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save('. $value->id .')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove('. $value->id .')"><i class="fa-solid fa-trash"></i>   ' .  lang("App.delete")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$value->id,
$value->nama_ruang,
$value->kode_ruang,
$value->keterangan,

				$ops				
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->ruanganModel->where('id' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function add()
	{
        $response = array();

		$fields['id'] = $this->request->getPost('id');
$fields['nama_ruang'] = $this->request->getPost('nama_ruang');
$fields['kode_ruang'] = $this->request->getPost('kode_ruang');
$fields['keterangan'] = $this->request->getPost('keterangan');


        $this->validation->setRules([
			            'nama_ruang' => ['label' => 'Nama ruang', 'rules' => 'required|min_length[0]|max_length[30]'],
            'kode_ruang' => ['label' => 'Kode ruang', 'rules' => 'required|min_length[0]|max_length[10]'],
            'keterangan' => ['label' => 'Keterangan', 'rules' => 'required|min_length[0]|max_length[40]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->ruanganModel->insert($fields)) {
												
                $response['success'] = true;
                $response['messages'] = lang("App.insert-success") ;	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = lang("App.insert-error") ;
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function edit()
	{
        $response = array();
		
		$fields['id'] = $this->request->getPost('id');
$fields['nama_ruang'] = $this->request->getPost('nama_ruang');
$fields['kode_ruang'] = $this->request->getPost('kode_ruang');
$fields['keterangan'] = $this->request->getPost('keterangan');


        $this->validation->setRules([
			            'nama_ruang' => ['label' => 'Nama ruang', 'rules' => 'required|min_length[0]|max_length[30]'],
            'kode_ruang' => ['label' => 'Kode ruang', 'rules' => 'required|min_length[0]|max_length[10]'],
            'keterangan' => ['label' => 'Keterangan', 'rules' => 'required|min_length[0]|max_length[40]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->ruanganModel->update($fields['id'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = lang("App.update-success");	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = lang("App.update-error");
				
            }
        }
		
        return $this->response->setJSON($response);	
	}
	
	public function remove()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->ruanganModel->where('id', $id)->delete()) {
								
				$response['success'] = true;
				$response['messages'] = lang("App.delete-success");	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = lang("App.delete-error");
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	
