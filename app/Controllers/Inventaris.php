<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\InventarisModel;

class Inventaris extends BaseController
{
	
    protected $inventarisModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->inventarisModel = new InventarisModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'inventaris',
                'title'     		=> 'inventaris'				
			];
		
		return view('inventaris', $data);
			
	}

	public function getAll()
	{
 		$response = $data['data'] = array();	

		$result = $this->inventarisModel->select()->findAll();
		
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
$value->nama,
$value->kondisi,
$value->keterangan,
$value->kode_inventaris,
$value->tanggal_register,
$value->stok,
$value->id_ruang,
$value->id_jenis,
$value->id_petugas,

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
			
			$data = $this->inventarisModel->where('id' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function add()
	{
        $response = array();

		$fields['id'] = $this->request->getPost('id');
$fields['nama'] = $this->request->getPost('nama');
$fields['kondisi'] = $this->request->getPost('kondisi');
$fields['keterangan'] = $this->request->getPost('keterangan');
$fields['kode_inventaris'] = $this->request->getPost('kode_inventaris');
$fields['tanggal_register'] = $this->request->getPost('tanggal_register');
$fields['stok'] = $this->request->getPost('stok');
$fields['id_ruang'] = $this->request->getPost('id_ruang');
$fields['id_jenis'] = $this->request->getPost('id_jenis');
$fields['id_petugas'] = $this->request->getPost('id_petugas');


        $this->validation->setRules([
			            'nama' => ['label' => 'Nama', 'rules' => 'required|min_length[0]|max_length[30]'],
            'kondisi' => ['label' => 'Kondisi', 'rules' => 'required|min_length[0]|max_length[20]'],
            'keterangan' => ['label' => 'Keterangan', 'rules' => 'required|min_length[0]|max_length[30]'],
            'kode_inventaris' => ['label' => 'Kode Inventaris', 'rules' => 'required|min_length[0]|max_length[10]'],
            'tanggal_register' => ['label' => 'Tanggal Register', 'rules' => 'required|valid_date|min_length[0]'],
            'stok' => ['label' => 'Stok', 'rules' => 'required|numeric|min_length[0]|max_length[2]'],
            'id_ruang' => ['label' => 'Id ruang', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_jenis' => ['label' => 'Id jenis', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_petugas' => ['label' => 'Id petugas', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->inventarisModel->insert($fields)) {
												
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
$fields['nama'] = $this->request->getPost('nama');
$fields['kondisi'] = $this->request->getPost('kondisi');
$fields['keterangan'] = $this->request->getPost('keterangan');
$fields['kode_inventaris'] = $this->request->getPost('kode_inventaris');
$fields['tanggal_register'] = $this->request->getPost('tanggal_register');
$fields['stok'] = $this->request->getPost('stok');
$fields['id_ruang'] = $this->request->getPost('id_ruang');
$fields['id_jenis'] = $this->request->getPost('id_jenis');
$fields['id_petugas'] = $this->request->getPost('id_petugas');


        $this->validation->setRules([
			            'nama' => ['label' => 'Nama', 'rules' => 'required|min_length[0]|max_length[30]'],
            'kondisi' => ['label' => 'Kondisi', 'rules' => 'required|min_length[0]|max_length[20]'],
            'keterangan' => ['label' => 'Keterangan', 'rules' => 'required|min_length[0]|max_length[30]'],
            'kode_inventaris' => ['label' => 'Kode Inventaris', 'rules' => 'required|min_length[0]|max_length[10]'],
            'tanggal_register' => ['label' => 'Tanggal Register', 'rules' => 'required|valid_date|min_length[0]'],
            'stok' => ['label' => 'Stok', 'rules' => 'required|numeric|min_length[0]|max_length[2]'],
            'id_ruang' => ['label' => 'Id ruang', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_jenis' => ['label' => 'Id jenis', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_petugas' => ['label' => 'Id petugas', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->inventarisModel->update($fields['id'], $fields)) {
				
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
		
			if ($this->inventarisModel->where('id', $id)->delete()) {
								
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
