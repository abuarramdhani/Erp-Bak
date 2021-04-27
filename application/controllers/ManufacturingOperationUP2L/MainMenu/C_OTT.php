<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_OTT extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_masterpersonal');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_ott');

        $this->checkSession();
        date_default_timezone_set("Asia/Jakarta");
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
		}
	}

	public function index()
	{
		//echo 'Tunggu sebentar pak, masih tahap perbaikan. <br>-EDWIN ICT';exit;
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'OTT';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/OTT/V_index', $data);
		$this->load->view('V_Footer', $data);
    }

		// edit rozin
		public function buildOttDataTable()
		{
			$post = $this->input->post();

			foreach ($post['columns'] as $val) {
				$post['search'][$val['data']]['value'] = $val['search']['value'];
			}

			$countall = $this->M_ott->countAllOtt()['count'];
			$countfilter = $this->M_ott->countFilteredOtt($post)['count'];

			$post['pagination']['from'] = $post['start'] + 1;
			$post['pagination']['to'] = $post['start'] + $post['length'];

			$protodata = $this->M_ott->selectOtt($post);

			$data = [];
			foreach ($protodata as $row) {

				$sub_array = [];
				$sub_array[] = '<center>'.$row['pagination'].'</center>';
				$sub_array[] = '<center>
														<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/OTT/read_data/'.$row['id']).'" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
														<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/OTT/update_data/'.$row['id']).'" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
														<a href="'.base_url('ManufacturingOperationUP2L/OTT/delete_data/'.$row['id']).'" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm(\'Are you sure you want to delete this item?\');"><span class="fa fa-trash fa-2x"></span></a>
												<center/>';
				$sub_array[] = '<center>'.$row['nama'].'<center/>';
				$sub_array[] = '<center>'.$row['otttgl'].'<center/>';
				$sub_array[] = '<center>'.$row['kode_cor'].'<center/>';
				$sub_array[] = '<center>'.$row['shift'].'<center/>';
				$sub_array[] = '<center>'.$row['pekerjaan'].'<center/>';
				$sub_array[] = '<center>'.$row['kode'].'<center/>';
				$sub_array[] = '<center>'.$row['nil_ott'].'<center/>';

				$data[] = $sub_array;
			}

			$output = [
				'draw' => $post['draw'],
				'recordsTotal' => $countall,
				'recordsFiltered' => $countfilter,
				'data' => $data,
			];

			die($this->output
							->set_status_header(200)
							->set_content_type('application/json')
							->set_output(json_encode($output))
							->_display());
		}
    public function view_create()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'OTT';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['pekerja'] = $this->M_ott->pekerja();

		for ($i=1;$i<count($data['pekerja']);$i++) {
			$data['data_p'][] = $data['pekerja'][$i]['no_induk'].' | '.$data['pekerja'][$i]['nama'];
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/OTT/V_create', $data);
		$this->load->view('V_Footer', $data);
    }

    public function save_create()
    {
		$realInd = '';
		for ($i=0; $i < count($this->input->post('ottName[]')); $i++) {
			$data[] = explode(' | ', $_POST['ottName'][$i]);
			$realInd .=  $data[$i][0].', ';
		}

		$realNama = rtrim($realInd, ', ');
			$data  = array(
				'nama'			=> $realNama,
				'kode_cor'		=> $this->input->post('print_code'),
				'shift'			=> $this->input->post('txtShift'),
				'pekerjaan'		=> $this->input->post('ottPekerjaan'),
				'otttgl'  		=> $this->input->post('ottTgl'),
				'kode'  		=> $this->input->post('ottKodeP'),
				'date'			=> date('Y-m-d H:i:s'),
				'nil_ott'		=> $this->input->post('ottNilai')
			);
			$this->M_ott->save_create($data);
			$header_id = $this->db->insert_id();

			$real_induk = explode(', ',$realNama);
			for ($x=0; $x < count($real_induk); $x++) {
				$dataAbs  = array(
					'nama'					=> NULL,
					'no_induk'				=> $real_induk[$x],
					'kode'  				=> $this->input->post('ottKodeP'),
					'kode_cor'				=> $this->input->post('print_code'),
					'alasan'				=> NULL,
					'category_produksi'		=> 'OTT',
					'presensi'				=> 'HDR',
					'nilai_ott'				=> $this->input->post('ottNilai'),
					'lembur'				=> FALSE,
					'produksi'				=> 'Y',
					'id_produksi'			=> $header_id,
					'created_date'			=> $this->input->post('ottTgl'),
				);
				$this->M_ott->createAbs($dataAbs);
			}
        redirect(site_url('ManufacturingOperationUP2L/OTT/view_create'));
    }

    public function read_data($id)
    {
        $user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'OTT';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['show'] = $this->M_ott->byId($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/OTT/V_read', $data);
		$this->load->view('V_Footer', $data);
    }

    public function update_data($id)
    {
        $user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'OTT';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['pekerja'] = $this->M_ott->pekerja();

		for ($i=1; $i < count($data['pekerja']); $i++) {
			$data['data_p'][] = $data['pekerja'][$i]['no_induk'].' | '.$data['pekerja'][$i]['nama'];
		}
        $data['show'] = $this->M_ott->byId($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/OTT/V_update', $data);
		$this->load->view('V_Footer', $data);
    }

    public function save_update()
    {
        $id = $this->input->post('ottId');
        $data  = array(
			'nama'			=> $this->input->post('ottName'),
            'kode_cor'		=> $this->input->post('print_code'),
            'shift'			=> $this->input->post('txtShift'),
            'pekerjaan'		=> $this->input->post('ottPekerjaan'),
			'otttgl'  		=> $this->input->post('ottTgl'),
			'kode'  		=> $this->input->post('ottKodeP'),
			'date'			=> date('Y-m-d H:i:s'),
			'nil_ott'		=> $this->input->post('ottNilai')
        );

		$this->M_ott->save_update($data, $id);

		$nama = explode(' | ', $this->input->post('ottName'));
		$dataAbs  = array(
			'nama'					=> $nama[1],
			'no_induk'				=> $nama[0],
			'kode'  				=> $this->input->post('ottKodeP'),
			'kode_cor'				=> $this->input->post('print_code'),
			'alasan'				=> NULL,
			'category_produksi'		=> 'OTT',
			'presensi'				=> 'HDR',
			'nilai_ott'				=> $this->input->post('ottNilai'),
			'lembur'				=> FALSE,
			'produksi'				=> 'Y',
			'created_date'			=> $this->input->post('ottTgl'),
		);

		foreach ($this->M_ott->v_absensi($id) as $b) {
			$this->M_ott->updateAbs($dataAbs, $b['id_absensi']);
		}
        redirect(site_url('ManufacturingOperationUP2L/OTT'));
    }

    public function delete_data($id)
    {
		$this->M_ott->delete($id);
        redirect(site_url('ManufacturingOperationUP2L/OTT'));
    }
}
