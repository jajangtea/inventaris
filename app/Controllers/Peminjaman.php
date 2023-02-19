<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PeminjamanModel;

class Peminjaman extends BaseController
{
	
    protected $peminjamanModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->peminjamanModel = new PeminjamanModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'peminjaman',
                'title'     		=> 'peminjaman'				
			];
		
		return view('peminjaman', $data);
			
	}

	public function getAll()
	{
 		$response = $data['data'] = array();	

		$result = $this->peminjamanModel->select()->findAll();
		
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
$value->tanggal_pinjam,
$value->tanggal_kembali,
$value->jumlah,
$value->status_peminjaman,
$value->id_inventaris,
$value->id_pegawai,

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
			
			$data = $this->peminjamanModel->where('id' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function add()
	{
        $response = array();

		$fields['id'] = $this->request->getPost('id');
$fields['tanggal_pinjam'] = $this->request->getPost('tanggal_pinjam');
$fields['tanggal_kembali'] = $this->request->getPost('tanggal_kembali');
$fields['jumlah'] = $this->request->getPost('jumlah');
$fields['status_peminjaman'] = $this->request->getPost('status_peminjaman');
$fields['id_inventaris'] = $this->request->getPost('id_inventaris');
$fields['id_pegawai'] = $this->request->getPost('id_pegawai');


        $this->validation->setRules([
			            'tanggal_pinjam' => ['label' => 'Tanggal Pinjam', 'rules' => 'required|valid_date|min_length[0]'],
            'tanggal_kembali' => ['label' => 'Tanggal Kembali', 'rules' => 'required|valid_date|min_length[0]'],
            'jumlah' => ['label' => 'Jumlah', 'rules' => 'required|numeric|min_length[0]|max_length[2]'],
            'status_peminjaman' => ['label' => 'Status peminjaman', 'rules' => 'required|min_length[0]|max_length[10]'],
            'id_inventaris' => ['label' => 'Id inventaris', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_pegawai' => ['label' => 'Id pegawai', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->peminjamanModel->insert($fields)) {
												
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
$fields['tanggal_pinjam'] = $this->request->getPost('tanggal_pinjam');
$fields['tanggal_kembali'] = $this->request->getPost('tanggal_kembali');
$fields['jumlah'] = $this->request->getPost('jumlah');
$fields['status_peminjaman'] = $this->request->getPost('status_peminjaman');
$fields['id_inventaris'] = $this->request->getPost('id_inventaris');
$fields['id_pegawai'] = $this->request->getPost('id_pegawai');


        $this->validation->setRules([
			            'tanggal_pinjam' => ['label' => 'Tanggal Pinjam', 'rules' => 'required|valid_date|min_length[0]'],
            'tanggal_kembali' => ['label' => 'Tanggal Kembali', 'rules' => 'required|valid_date|min_length[0]'],
            'jumlah' => ['label' => 'Jumlah', 'rules' => 'required|numeric|min_length[0]|max_length[2]'],
            'status_peminjaman' => ['label' => 'Status peminjaman', 'rules' => 'required|min_length[0]|max_length[10]'],
            'id_inventaris' => ['label' => 'Id inventaris', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_pegawai' => ['label' => 'Id pegawai', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->peminjamanModel->update($fields['id'], $fields)) {
				
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
		
			if ($this->peminjamanModel->where('id', $id)->delete()) {
								
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
