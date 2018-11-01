<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Mixing extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_mixing');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Mixing'] = $this->M_mixing->getMixing();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/Mixing/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('cmbComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMixingQuantityHeader', 'MixingQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperationUP2L/Mixing/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'component_code' => $this->input->post('cmbComponentCodeHeader'),
				'component_description' => $this->input->post('component_description'),
				'production_date' => $this->input->post('txtProductionDateHeader'),
				'mixing_quantity' => $this->input->post('txtMixingQuantityHeader'),
				'job_id' => $this->input->post('txtJobIdHeader'),
				'created_by' => $this->session->userid,
    		);
			$this->M_mixing->setMixing($data);
			$header_id = $this->db->insert_id();

			$produksi = $this->input->post('txt_produksi');
			$lembur = $this->input->post('txt_lembur');
			$presensi = $this->input->post('txt_presensi');
			$ott = $this->input->post('txt_ott');

			$employee = explode('|', $this->input->post('txtJobIdHeader'));
			$no_induk = $employee[0];
			$nama = $employee[1];
			
			$date = date('m-d-Y');
			$data =  array(
						'no_induk' =>  $no_induk,
						'category_produksi' => 'Mixing',
						'id_produksi' => $header_id,
						'presensi' => $presensi,
						'produksi' => $produksi,
						'nilai_ott' => $ott,
						'lembur' => $lembur,
						'created_date' =>  $date
			);
			$this->M_mixing->setAbsensi($data);

			redirect(site_url('ManufacturingOperationUP2L/Mixing'));
		}
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Mixing'] = $this->M_mixing->getMixing($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMixingQuantityHeader', 'MixingQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperationUP2L/Mixing/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'component_code' => $this->input->post('cmbComponentCodeHeader',TRUE),
				'component_description' => $this->input->post('txtComponentDescriptionHeader',TRUE),
				'production_date' => $this->input->post('txtProductionDateHeader',TRUE),
				'mixing_quantity' => $this->input->post('txtMixingQuantityHeader',TRUE),
				'job_id' => $this->input->post('txtJobIdHeader',TRUE),
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_mixing->updateMixing($data, $plaintext_string);

			redirect(site_url('ManufacturingOperationUP2L/Mixing'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Mixing'] = $this->M_mixing->getMixing($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/Mixing/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_mixing->deleteMixing($plaintext_string);

		redirect(site_url('ManufacturingOperationUP2L/Mixing'));
    }



}

/* End of file C_Mixing.php */
/* Location: ./application/controllers/ManufacturingOperationUP2L/MainMenu/C_Mixing.php */
/* Generated automatically on 2017-12-20 14:47:57 */