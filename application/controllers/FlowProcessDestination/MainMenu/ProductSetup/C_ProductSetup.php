<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_ProductSetup extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('FlowProcessDestination/M_productsetup');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProcessDestination/MainMenu/ProductSetup/V_Index',$data);
			$this->load->view('V_Footer',$data);

		}

	public function SaveProduct()
	{
		$end_date_active = $this->input->post('dateEndDateActive');
		$last_edit_date = date('Y-m-d H:i:s');
		$last_edit_by = $this->session->userid;
		$creation_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userid;
		$start_date_active = date('Y-m-d');
		$end_date_active = date('Y-m-d', strtotime($end_date_active));
		$product_number = $this->input->post('txtProductCode');
		$product_desc = $this->input->post('txtProductDesc');
		$product_status = $this->input->post('statusProduct');
		$gambarUnit = $this->input->post('gambarUnit');
		$product_id = $this->input->post('product_id');
		$gambar_unit_name = "";
		if($_FILES){
			if (file_exists($_FILES['gambarUnit']['tmp_name']) || is_uploaded_file($_FILES['gambarUnit']['tmp_name'])) {
				$ext = explode('.', $_FILES['gambarUnit']['name']);
				$gambar_unit_name = $product_number.'-'.$product_id.'.'.$ext[1];
			}
		}

        $config['upload_path']          = './assets/upload_flow_process/product';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']			= $product_number.'-'.$product_id;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambarUnit'))
        {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                die();
        }

		$data = array(
					'product_id' => $product_id,
					'last_update_date' => $last_edit_date,
					'last_update_by' => $last_edit_by,
					'creation_date' => $creation_date,
					'created_by' => $created_by,
					'start_date_active' => $start_date_active,
					'end_date_active' => $end_date_active,
					'product_number' => $product_number,
					'product_description' => $product_desc,
					'product_status' => $product_status,
					'gambar_unit' => $gambar_unit_name);
		// echo"<pre>"; print_r($data);exit;
		$cekproduk = $this->M_productsetup->checkproduct($product_id);
		if (count($cekproduk)>0){
			$this->M_productsetup->UpdateProduct($product_id,$last_edit_date,$last_edit_by,$creation_date,$created_by,$start_date_active,$end_date_active,$product_number,$product_desc,$product_status,$gambar_unit_name);
		}else{
			$this->M_productsetup->SaveProduct($data);
		}  
		$this->session->set_flashdata('response',"Product Saved!");
		redirect(base_url('FlowProcess/ProductSetup'));

	}

	public function saveEditProduct()
	{
		$id_product = $this->input->post('product_id');
		$end_date_active = $this->input->post('dateEndDateActive');
		$product_number = $this->input->post('txtProductNumber');
		$product_desc = $this->input->post('txtProductDesc');
		$product_status = $this->input->post('statusProduct');
		$last_edit_date = date('Y-m-d H:i:s');
		$last_edit_by = $this->session->userid;
		$end_date_active = ($end_date_active) ?  date('Y-m-d',strtotime($end_date_active)) : null;
		$gambar_unit_name = '';

		$arrayBeda = array();
		if($_FILES){
			if (file_exists($_FILES['gambarUnit']['tmp_name']) || is_uploaded_file($_FILES['gambarUnit']['tmp_name'])) {
				$ext = explode('.', $_FILES['gambarUnit']['name']);
				$gambar_unit_name = $product_number.'-'.$id_product.'.'.$ext[1];
				array_push($arrayBeda,1);

				//del
				$linkgmb = './assets/upload_flow_process/product/'.$gambar_unit_name;
				if (is_file($linkgmb)) {
					unlink($linkgmb);
				}

				//upUl
				$config['upload_path']          = './assets/upload_flow_process/product';
		        $config['allowed_types']        = 'gif|jpg|png';
		        $config['file_name']			= $product_number.'-'.$id_product;

		        $this->load->library('upload', $config);

		        if (!$this->upload->do_upload('gambarUnit'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                print_r($error);
		                die();
		        }

			}
		}

		$dataProduct = $this->M_productsetup->getProduct($id_product);
		foreach ($dataProduct as $key => $value) {
			$ed_exist = ($value['end_date_active']) ? date('m/d/Y',strtotime($value['end_date_active'])) : '';
			if($value['product_number'] == $product_number){array_push($arrayBeda, 0);}else{ array_push($arrayBeda, 1);}
			if($value['product_description'] == $product_desc){array_push($arrayBeda, 0);}else{ array_push($arrayBeda, 1);}
			if($value['product_status'] == $product_status){array_push($arrayBeda, 0);}else{ array_push($arrayBeda, 1);}
			if($ed_exist == $end_date_active){array_push($arrayBeda, 0);}else{ array_push($arrayBeda, 1);}
		}

		if (!in_array(1, $arrayBeda)) {
		}else{
			$dataUpdate = array(
					'last_update_date' => $last_edit_date,
					'last_update_by' => $last_edit_by,
					'end_date_active' =>$end_date_active,
					'product_number' => $product_number,
					'product_description' => $product_desc,
					'product_status' => $product_status);	
			if($gambar_unit_name){
				$dataUpdate['gambar_unit'] = $gambar_unit_name;
			}
			$this->M_productsetup->saveEditProduct($id_product,$dataUpdate);
		}

		redirect(base_url('FlowProcess/ProductSearch'));

	}

    public function do_upload($gambar_kerja,$product_number)
        {
            $config['upload_path']          = './assets/upload_flow_process/product';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['file_name']			= $product_number;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload($gambar_kerja))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                die();
            }
		}
	public function selectprdcode() {
			$term = $this->input->post('term');
			// $productId = $this->input->post('productId');
			$data = $this->M_productsetup->selectprdcode(strtoupper($term));
			// echo "<pre>";
			// print_r($data);
			// exit();
			echo json_encode($data);
	}
	public function search()
		{
			$product_number = $this->input->POST('product_number'); // Ambil data product_number yang dikirim lewat AJAX
			$data = $this->M_productsetup->viewByNoProduct($product_number);
			if( ! empty($data)){ 
			  $callback = array(
				  'status' => 'success',
				  'product_description' => $data[0]['product_description'], // Set array product_description dengan isi kolom product_description pada tabel khs_fpd_data_gambar
				  'status_product' => $data[0]['status_product'], // Set array status_product dengan isi kolom status_product pada tabel khs_fpd_data_gambar
				  'end_date_active' => $data[0]['end_date_active'], // Set array end_date_active dengan isi kolom end_date_active pada tabel khs_fpd_data_gambar
				);
			}else{
				$callback = array('status' => 'failed'); // set array status dengan failed
			}
			echo json_encode($callback); // konversi varibael $callback menjadi JSON
			
		}

		public function searchdetail()
		{
			$prdid = $this->input->POST('prdid'); 
			$data = $this->M_productsetup->view_prd($prdid);
			if( ! empty($data)){ 
				$callback = array(
				 'status' => 'success', 
				 'product_name' => $data[0]['product_name'],
				 'product_code' => $data[0]['product_code'],
				 'product_id' => $data[0]['product_id']
			 );
			}else{
				$callback = array('status' => 'failed'); 
			}
			echo json_encode($callback); 
			
		}

}