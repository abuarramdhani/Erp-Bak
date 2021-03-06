<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
/**
 * 
 */
class C_Civil_setting extends CI_Controller
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
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CivilMaintenanceOrder/M_civil');

		if ((bool)$this->session->is_logged === false) redirect('');
	}

	public function jenis_order()
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Jenis Order', 'Setting', 'jenis Order', '');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('CivilMaintenanceOrder/Setting/V_Jenis_Order', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getlist_jenis_order()
	{
		$data['list'] = $this->M_civil->getTableJenisOrder();
		$html = $this->load->view('CivilMaintenanceOrder/Setting/V_Table_Jenis_Order', $data);
		return $html;
	}

	public function add_jenis_order()
	{
		$user = $this->session->user;
		$jnsOrder = $this->input->post('jenisOrder');
		$data = array('jenis_order'	=>	$jnsOrder);
		$ins = $this->M_civil->addJnsOrder($data);
		$thread = array(
			'thread_detail'	=>	'Add Jenis Order ' . $ins . ' (' . $jnsOrder . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$user
		);
		$this->M_civil->saveThread($thread);
		return $ins ? 'success' : 'gagal';
	}

	public function del_jnsOrder()
	{
		$id = $this->input->post('id');
		$nama = $this->M_civil->getSettingbyId($id, 'cvl.cvl_jenis_order', 'jenis_order_id')->row()->jenis_order;
		$thread = array(
			'thread_detail'	=>	'Delete Jenis Order ' . $id . ' (' . $nama . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		$this->M_civil->delJnsOrder($id);
	}

	public function up_jnsOrder()
	{
		$txt = $this->input->post('upjenisOrder');
		$id = $this->input->post('idJnsOrder');
		$thread = array(
			'thread_detail'	=>	'Update Jenis Order ' . $id . ' (' . $txt . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		$data = array('jenis_order'	=>	$txt);
		$this->M_civil->upJnsOrder($data, $id);
	}

	public function jenis_pekerjaan()
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Jenis Pekerjaan', 'Setting', 'Jenis Pekerjaan', '');

		$data['list'] = $this->M_civil->listJnsPkj();
		$data['detail'] = $this->M_civil->listJnsPkjDetail();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('CivilMaintenanceOrder/Setting/V_Jenis_Pekerjaan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function add_jns_pkj()
	{
		$pkj = $this->input->post('pekerjaan');
		$ket = $this->input->post('ket');
		$data = array(
			'jenis_pekerjaan'	=>	$pkj,
			'keterangan'	=>	$ket
		);
		$add = $this->M_civil->addJnsOrder($data, 'cvl.cvl_jenis_pekerjaan');

		$thread = array(
			'thread_detail'	=>	'Add Jenis Pekerjaan ' . $add . ' (' . $pkj . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		redirect('civil-maintenance-order/setting/jenis_pekerjaan');
	}

	public function add_jns_pkj_detail()
	{
		$pkj = $this->input->post('jenisPekerjaan');
		$detail = $this->input->post('pekerjaanDetail');
		$ket = $this->input->post('ket');
		$data = array(
			'jenis_pekerjaan_id'	=>	$pkj,
			'detail_pekerjaan'	=> $detail,
			'keterangan'	=>	$ket
		);
		$add = $this->M_civil->addJnsOrder($data, 'cvl.cvl_jenis_pekerjaan_detail');

		$thread = array(
			'thread_detail'	=>	'Add Jenis Pekerjaan Detail ' . $add . ' (' . $pkj . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		redirect('civil-maintenance-order/setting/jenis_pekerjaan');
	}

	public function del_jnsPkj()
	{
		$id = $this->input->get('id');
		$nama = $this->M_civil->getSettingbyId($id, 'cvl.cvl_jenis_pekerjaan', 'jenis_pekerjaan_id')->row()->jenis_pekerjaan;
		$this->M_civil->delJnsPkj($id);

		$thread = array(
			'thread_detail'	=>	'Delete Jenis Pekerjaan ' . $id . ' (' . $nama . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		redirect('civil-maintenance-order/setting/jenis_pekerjaan');
	}

	public function up_jns_pkj()
	{
		$txt = $this->input->post('upjenisOrder');
		$ket = $this->input->post('upKet');
		$id = $this->input->post('idJnsOrder');

		$data = array('jenis_pekerjaan'	=>	$txt, 'keterangan'	=>	$ket);
		$this->M_civil->upJnsPkj($data, $id);

		$thread = array(
			'thread_detail'	=>	'Update Jenis Pekerjaan ' . $id . ' (' . $txt . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/setting/jenis_pekerjaan');
	}

	public function up_jns_pkj_detail()
	{
		$detail = $this->input->post('upjenisOrderDetail');
		$pekerjaan_id = $this->input->post('upjenisPekerjaan');
		$ket = $this->input->post('upKet');
		$detail_id = $this->input->post('idJnsPekerjaanDetail');

		$data = array(
			'jenis_pekerjaan_id'	=>	$pekerjaan_id,
			'detail_pekerjaan'	=>	$detail,
			'keterangan'	=>	$ket
		);
		$this->M_civil->upJnsPkjDetail($data, $detail_id);

		$thread = array(
			'thread_detail'	=>	'Update Jenis Pekerjaan Detail ' . $detail_id . ' (' . $detail . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/setting/jenis_pekerjaan');
	}

	public function status_order()
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Status Order', 'Setting', 'Status Order', '');

		$data['list'] = $this->M_civil->getStatusOrder();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('CivilMaintenanceOrder/Setting/V_Status_Order', $data);
		$this->load->view('V_Footer', $data);
	}

	/**
	 * TAMBAH STATUS ORDER
	 */
	public function add_sto()
	{
		$st = $this->input->post('status');
		$color = $this->input->post('color') ?: NULL;

		$data = array(
			'status'	=>	$st,
			'status_color' => $color
		);

		$add = $this->M_civil->addJnsOrder($data, 'cvl.cvl_order_status');

		$thread = array(
			'thread_detail'	=>	'Add Status Order ' . $add . ' (' . $st . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		redirect('civil-maintenance-order/setting/status_order');
	}

	/**
	 * HAPUS STATUS ORDER
	 */
	public function del_sto()
	{
		$id = $this->input->get('id');
		$nama = $this->M_civil->getSettingbyId($id, 'cvl.cvl_order_status', 'status_id')->row()->status;
		$this->M_civil->delsto($id);

		$thread = array(
			'thread_detail'	=>	'Delete Status Order ' . $id . ' (' . $nama . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/setting/status_order');
	}

	/**
	 * UPDATE STATUS ORDER
	 */
	public function up_sto()
	{
		$id = $this->input->post('idJnsOrder');
		$txt = $this->input->post('upjenisOrder');
		$color = $this->input->post('color') ?: NULL;

		$data = array('status'	=>	$txt, 'status_color' => $color);

		$this->M_civil->upsto($data, $id);

		$thread = array(
			'thread_detail'	=>	'Update Status Order ' . $id . ' (' . $txt . ')',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
		);
		$this->M_civil->saveThread($thread);

		redirect('civil-maintenance-order/setting/status_order');
	}

	public function getket_jenis_order()
	{
		$id = $this->input->get('id');
		$jenis_pkj = $this->M_civil->getJenisPekerjaanbyId($id)->row_array();
		echo json_encode($jenis_pkj);
	}

	public function getket_jenis_pekerjaan_detail()
	{
		$id = $this->input->get('id');
		$jenis_pkj = $this->M_civil->getJenisPekerjaanDetailbyId($id)->row_array();
		echo json_encode($jenis_pkj);
	}
}
