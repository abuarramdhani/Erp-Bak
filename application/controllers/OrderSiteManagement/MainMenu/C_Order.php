<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Order extends CI_Controller
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
		$this->load->model('OrderSiteManagement/MainMenu/M_order');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Create Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Order'] = $this->M_order->getOrder();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSiteManagement/Order/V_create', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function SaveDataOrderSM()
	{
		$user_id = $this->session->userid;

		$data = array(
				'tgl_order' => $this->input->post('tgl_order'),
				'jenis_order' => $this->input->post('jenis_order'),
				'seksi_order' => $this->input->post('seksi_order'),
				'due_date' => $this->input->post('duedate'),
				'tgl_terima' => $this->input->post('tgl_terima'),
				'remarks' => $this->input->post('remarks'),
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $user_id,
    		);
		$this->M_order->setOrder($data);
		$header_id = $this->db->insert_id();

		$jml_order = $this->input->post('jumlah');
		foreach ($jml_order as $jo => $key) {
			$jml_order = $this->input->post('jumlah');
			$satuan = $this->input->post('satuan');
			$ket_order = $this->input->post('keterangan');
			$lampiran = $this->input->post('lampiran');

			$lines = array(
					 'id_order' => $header_id,
					 'jumlah' => $jml_order[$jo],
					 'satuan' => $satuan[$jo],
					 'keterangan' => $ket_order[$jo],
					 'lampiran' => $lampiran[$jo],
					 'created_date' => date('Y-m-d H:i:s'),
					 'created_by' => $user_id,
			);
			$this->M_order->saveOrderDetail($lines);
		}
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Create Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('OrderSiteManagement/Order/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader'),
				'tgl_order' => $this->input->post('txtTglOrderHeader'),
				'jenis_order' => $this->input->post('cmbJenisOrderHeader'),
				'seksi_order' => $this->input->post('cmbSeksiOrderHeader'),
				'due_date' => $this->input->post('txtDueDateHeader'),
				'tgl_terima' => $this->input->post('txtTglTerimaHeader'),
				'remarks' => $this->input->post('chkRemarksHeader'),
    		);
			$this->M_order->setOrder($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('OrderSiteManagement/Order'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Safety Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Order'] = $this->M_order->getOrder($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('OrderSiteManagement/Order/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader',TRUE),
				'tgl_order' => $this->input->post('txtTglOrderHeader',TRUE),
				'jenis_order' => $this->input->post('cmbJenisOrderHeader',TRUE),
				'seksi_order' => $this->input->post('cmbSeksiOrderHeader',TRUE),
				'due_date' => $this->input->post('txtDueDateHeader',TRUE),
				'tgl_terima' => $this->input->post('txtTglTerimaHeader',TRUE),
				'remarks' => $this->input->post('chkRemarksHeader',TRUE),
    			);
			$this->M_order->updateOrder($data, $plaintext_string);

			redirect(site_url('OrderSiteManagement/Order'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Create Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Order'] = $this->M_order->getOrder($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSiteManagement/Order/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_order->deleteOrder($plaintext_string);

		redirect(site_url('OrderSiteManagement/Order'));
    }



}

/* End of file C_Order.php */
/* Location: ./application/controllers/OrderSiteManagement/MainMenu/C_Order.php */
/* Generated automatically on 2018-06-26 09:50:15 */