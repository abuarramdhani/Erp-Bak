<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_ProductSearch extends CI_Controller
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
			$this->load->model('FlowProcessDestination/M_productsearch');
			  
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
			$data['result'] = $this->M_productsearch->searchResult(false);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_Index',$data);
			$this->load->view('V_Footer',$data);

		}


	public function getDescription()
		{
			$product_id = $this->input->post('product_id');
			// echo"<pre>";
			// print_r($product_id);
			// exit();
			$data = $this->M_productsearch->searchResult($product_id);
			if ($data) {
				$pi = $product_id;
				$pp = $data[0]['product_id'];
				$pn = $data[0]['product_number'];
				$pd = $data[0]['product_description'];
				$pso = $data[0]['product_status'];
				$ps = ($data[0]['product_status']) ? ($data[0]['product_status'] == 1 ? 'Mass Production' : 'Prototype') : '';
				$ed = ($data[0]['end_date_active']) ? (date('m/d/Y',strtotime($data[0]['end_date_active']))) : '';
				if ($data[0]['gambar_unit']) {
					$gu= '<a target="_blank" href="'.base_url('assets/upload_flow_process/product/').'/'.$data[0]['gambar_unit'].'"> <b> Open File</b>
					</a>';
					$gun = $data[0]['gambar_unit'];
					}else{
						$gun = '';
					$gu = '<b> File not found</b>';
					 } 
					$rs['tgk'] = $this->M_productsearch->resumeTGK($product_id);
					$rs['bomp'] = '-';
					$rs['bomsp'] = '-';
					$rs['jo'] = '1';
					$rs['so'] = '-';
				// $link1 = base_url("FlowProcess/ProductSetup/editProduct/".$product_id);
				// $link2 = base_url("FlowProcess/ProductSetup/openProduct/".$product_id);
				$datares = array('pn' => $pn, 'pd' => $pd, 'pp' => $pp, 'ps' => $ps, 'ed' => $ed,'pso' => $pso, 'gu' =>$gu,'gun' =>$gun,'pi' => $product_id, 'rs' => $rs);
				echo json_encode($datares);
			}
		}

	public function getSearch()
	{
		$param = $this->input->post('term');
		$data = $this->M_productsearch->getSearch(strtoupper($param));
		echo json_encode($data);
	}

	public function viewComponent()
	{
		$product_id = $this->input->post('product_id');
		// echo"<pre>";
		// print_r($product_id);
		// exit();
		$data['component'] = $this->M_productsearch->getComponent($product_id);
		$data['product_id'] = $product_id;
		$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_ViewComponent',$data);
	}

	public function setupComponent()
	{
		$product_id = $this->input->post('product_id');
		$data['product_id'] = $product_id;
		$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_AddComponent',$data);
	}

	public function viewCompbyId()
	{
		$product_id = $this->input->post('product_id');
		// echo"<pre>";
		// print_r($product_id);
		// exit();
		$data['mbuh'] = $this->M_productsearch->viewCompbyId($product_id);
		// echo"<pre>";
		// print_r($data['mbuh']);
		// exit();
		$this->load->view('FlowProcessDestination/MainMenu/ProductSearch/V_ViewComponent2',$data);
	}

	public function deleteFIleGambar()
	{
		$user_id = $this->session->userid;
		$product_id = $this->input->post('product_id');
		$file_gambar = $this->input->post('file_gambar');
		$last_edit_date = date('Y-m-d H:i:s');
		$last_edit_by = $this->session->userid;
		if ($file_gambar) {
			$linkgmb = './assets/upload_flow_process/product/'.$file_gambar;
			if (is_file($linkgmb)) {
				unlink($linkgmb);
			}
			$data =array(
					'last_update_date' => $last_edit_date,
					'last_update_by' => $last_edit_by,
					'gambar_unit' => null
				);
			$this->M_productsearch->deleteFIleGambar($product_id,$data);
		}
	}

}