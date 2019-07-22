<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_ListData extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('LaporanKerjaHarian/AtasanSingle/M_lkhtargetwaktu');
	}

	public function index($type) {
		if(!$this->session->is_logged) { redirect(base_url()); }
		if(empty($type)) { redirect(base_url('LkhAtasanSingle/TargetWaktu/ListData')); }
		$user_id = $this->session->userid;
		$data['filterPeriode'] = (empty($this->input->post('filterPeriode'))) ? date('m/Y') : $this->input->post('filterPeriode');
		$data['filterPekerja'] = (empty($this->input->post('filterPekerja'))) ? '' : explode(',', $this->input->post('filterPekerja'));
		$this->session->set_flashdata('periode', $data['filterPeriode']);
		$this->session->set_flashdata('pekerja', $data['filterPekerja']);
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['Title'] = $data['UserMenu'][0]['user_group_menu_name'];
		$data['Menu'] = $data['UserMenu'][0]['menu_title'];
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['type'] = $type;
		$this->load->view('V_Header', $data);
		switch(strtolower($data['type'])) {
			case 'unapproved':
				$data['Title'] = $data['UserSubMenuOne'][0]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][0]['menu_title'];
				break;
			case 'rejected':
				$data['Title'] = $data['UserSubMenuOne'][1]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][1]['menu_title'];
				break;
			case 'approved':
				$data['Title'] = $data['UserSubMenuOne'][2]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][2]['menu_title'];
				break;
			default:
				$data['Title'] = $data['UserSubMenuOne'][3]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][3]['menu_title'];
				break;
		}
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('LaporanKerjaHarian/AtasanSingle/TargetWaktu/V_ListData', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getListFilterPekerja() {
		echo json_encode($this->M_lkhtargetwaktu->getListFilterPekerja($this->input->post('term'), $this->input->post('periode')));
	}

	public function getList() {
		$periodeRaw = (empty($this->input->post('periode'))) ? date('m/Y') : $this->input->post('periode');
		$periode = explode('/', $periodeRaw);
		$pekerja = (empty($this->input->post('pekerja'))) ? '' : $this->input->post('pekerja');
		$type = (empty($this->input->post('type'))) ? 'listdata' : $this->input->post('type');
		if(!empty($pekerja)) {
			$pekerja = explode(',', $pekerja);
			for ($i=0; $i < count($pekerja); $i++) {
				$pekerja[$i] = explode(' - ', $pekerja[$i]);
				$pekerja[$i] = $pekerja[$i][0];
			}
		}
		$counter = 1;
		$data = array();
		$list = $this->M_lkhtargetwaktu->getList($periode, $pekerja, strtolower($type));
		foreach ($list as $key) {
			$row = array();
			$row[] = '<div class="text-center">'.$counter.'.</div>';
			$row[] = "<div style='text-align: center;'><form action='".base_url('LkhAtasanSingle/TargetWaktu/Detail')."' method='POST'><input name='filterPekerja' id='employee-code-row-".$counter."' type='text' value='".$key->employee_code."' hidden/><input name='filterPeriode' id='periode-row-".$counter."' type='text' value='".$periodeRaw."' hidden/><input name='type' type='text' value='".$type."' hidden/><button type='submit' class='btn btn-primary' style='margin-right: 6px;'><i class='fa fa-info-circle'></i><span style='margin-left: 6px;'>Detail</span></button></form></div>";
			$row[] = '<span id="employee-name-row-'.$counter.'">'.$key->pekerja.'</span>';
			$row[] = '<div style="text-align: center" id="employee-record-pekerjaan-row-'.$counter.'">'.$key->record_pekerjaan.'</div>';
			$row[] = '<div style="text-align: center" id="employee-record-kondite-row-'.$counter.'">'.$key->record_kondite.'</div>';
			$row[] = '<div style="text-align: center" id="employee-status-row-'.$counter.'">'.(($key->status == 'Unapproved') ? 'Request Approval' : $key->status).'</div>';
			$row[] = $key->status;
			$data[] = $row;
			$counter++;
		}
		$output = array(
			'draw' => $_POST['draw'], 
			'recordsTotal' => $this->M_lkhtargetwaktu->getListCountAll($periode, $pekerja, strtolower($type)),
			'recordsFiltered' => $this->M_lkhtargetwaktu->getListCountFiltered($periode, $pekerja, strtolower($type)),
			'data' => $data
		);
		echo json_encode($output);
	}

	public function kirimApproval() {
		echo json_encode($this->M_lkhtargetwaktu->kirimApproval($this->input->post('periode'), $this->input->post('pekerja'), $this->input->post('approver1'), $this->input->post('approver2')));
	}

	public function deleteDataKegiatanBatch() {
		echo json_encode($this->M_lkhtargetwaktu->deleteDataKegiatanBatch($this->input->post('periode'), $this->input->post('pekerja')));
	}

	public function deleteDataKegiatan() {
		echo json_encode($this->M_lkhtargetwaktu->deleteDataKegiatan($this->input->post('periode'), $this->input->post('pekerja')));
	}
}