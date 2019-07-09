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
		$this->load->model('LaporanKerjaHarian/PekerjaBatch/M_lkhtargetwaktu');
		if($this->session->userdata('logged_in') != TRUE) {
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function index($type) {
		if(!$this->session->is_logged) { redirect(base_url()); }
		if(empty($type)) { redirect(base_url('LkhPekerjaBatch/TargetWaktu/ListData')); }
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
		$data['type'] = strtolower($type);

		$this->load->view('V_Header', $data);
		switch($data['type']) {
			case 'draft':
				$data['Title'] = $data['UserSubMenuOne'][0]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][0]['menu_title'];
				break;
			case 'unapproved':
				$data['Title'] = $data['UserSubMenuOne'][1]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][1]['menu_title'];
				break;
			case 'rejected':
				$data['Title'] = $data['UserSubMenuOne'][2]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][2]['menu_title'];
				break;
			case 'approved':
				$data['Title'] = $data['UserSubMenuOne'][3]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][3]['menu_title'];
				break;
			default:
				$data['Title'] = $data['UserSubMenuOne'][4]['menu'];
				$data['SubMenuOne'] = $data['UserSubMenuOne'][4]['menu_title'];
				break;
		}
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('LaporanKerjaHarian/PekerjaBatch/TargetWaktu/V_ListData', $data);
		$this->load->view('V_Footer', $data);
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
		$list = $this->M_lkhtargetwaktu->getList($pekerja);
		$data = array();
		$counter = 0;
		foreach ($list as $key) {
			$row = array();
			$approvalStatus = $this->M_lkhtargetwaktu->getApproval($periode, $key->employee_code);
			if(strtolower($type) == 'listdata' || strtolower($approvalStatus) == strtolower($type)) {
				$row[] = ($counter + 1).'.';
				$row[] = "<div style='text-align: center;'><input type='checkbox' name='checkBoxDataList[]' id='checkbox-lkh-".$counter."' class='checkBoxDataList'/></div>";
				if($counter < (count($list) - 1)) {
					$row[] = "<div style='text-align: center;'><form action='".base_url('LkhPekerjaBatch/TargetWaktu/Detail')."' method='POST'><input name='filterPekerja' id='row-lkh-".$counter."' type='text' value='".$key->employee_code."' hidden/><input name='filterPeriode' type='text' value='".$periodeRaw."' hidden/><button type='submit' data-toggle='tooltip' data-placement='bottom' data-original-title='Detail Data' class='btn btn-primary' style='margin-right: 6px;'><i class='fa fa-info-circle'></i></button><button type='button' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='javascript:deleteListLkhPekerja(\"".$key->employee_code."\", \"".$counter."\");' class='btn btn-danger'><i class='fa fa-trash'></i></button></form><form action='".base_url('LkhPekerjaBatch/TargetWaktu/ListData/Delete')."' method='POST' hidden><input name='filterPekerja' type='text' value='".$key->employee_code."' hidden/><button type='submit' id='delete-row-lkh-".$counter."' hidden></button</form></div>";
				} else {
					$row[] = "<div style='text-align: center;'><form action='".base_url('LkhPekerjaBatch/TargetWaktu/Detail')."' method='POST'><input name='filterPekerja' id='row-lkh-".$counter."' type='text' value='".$key->employee_code."' hidden/><input name='filterPeriode' type='text' value='".$periodeRaw."' hidden/><button type='submit' class='btn btn-primary' style='margin-right: 6px;'><i class='fa fa-info-circle'></i></button><button type='button' onclick='javascript:deleteListLkhPekerja(\"".$key->employee_code."\", \"".$counter."\");' class='btn btn-danger'><i class='fa fa-trash'></i></button></form><form action='".base_url('LkhPekerjaBatch/TargetWaktu/Delete')."' method='POST' hidden><input name='filterPekerja' type='text' value='".$key->employee_code."' hidden/><button type='submit' id='delete-row-lkh-".$counter."' hidden></button</form></div>";
				}
				$row[] = $key->employee_code.' - '.$key->employee_name;
				$recordPekerjaan = $this->M_lkhtargetwaktu->getRecordPekerjaan($periode, $key->employee_code);
				$row[] = ($recordPekerjaan) ? $recordPekerjaan : '<div style="text-align: center">-</div>';
				$nilaiKondite = $this->M_lkhtargetwaktu->getNilaiInsentifKondite($periode, $key->employee_code);
				$row[] = ($nilaiKondite) ? $nilaiKondite : '<div style="text-align: center">-</div>';
				$row[] = ($approvalStatus) ? '<div style="text-align: center">'.$approvalStatus.'</div>' : '<div style="text-align: center">-</div>';
				$data[] = $row;
				$counter++;
			}
		}
		$output = array(
			'draw' => $_POST['draw'], 
			'recordsTotal' => $this->M_lkhtargetwaktu->getListCountAll($pekerja),
			'recordsFiltered' => $this->M_lkhtargetwaktu->getListCountFiltered($pekerja),
			'data' => $data
		);
		echo json_encode($output);
	}
}