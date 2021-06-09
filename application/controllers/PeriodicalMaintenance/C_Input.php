<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
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
		$this->load->model('PeriodicalMaintenance/M_input');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Input Uraian Kerja';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		
		$admin = ['a'=>'T0015' , 'b'=>'B0847', 'c'=>'B0655', 'd'=>'B0908']; 
		if (empty(array_search($this->session->user, $admin))) {
			unset($data['UserMenu'][0]);
			unset($data['UserMenu'][1]);
			unset($data['UserMenu'][2]);
		}

		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['mesin'] = $this->M_input->getMachine();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Input', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getDataPrevious()
	{
		$mesin 	= $this->input->post('mesin');
		$previous = $this->M_input->getDataPrevious($mesin);
		if (sizeof($previous) != 0) {
			foreach ($previous as $prev => $v) {
				$showPrev = '
				<tr class="clone">
				<td><input type="text" name="nama_mesinpre[]" value="' . $v['NAMA_MESIN'] . '" readonly class="form-control"></td>
				<td><input type="text" name="kondisi_mesinpre[]" value="' . $v['KONDISI_MESIN'] . '" readonly class="form-control"></td>
				<td><input type="text" name="headerpre[]" value="' . $v['HEADER'] . '" readonly class="form-control"></td>
				<td><input type="text" name="uraian_kerjapre[]" value="' . $v['SUB_HEADER'] . '" readonly class="form-control"></td>
				<td><input type="text" name="standarpre[]" value="' . $v['STANDAR'] . '" readonly class="form-control"></td>
				<td><input type="text" name="periodepre[]" value="' . $v['PERIODE'] . '" readonly class="form-control"></td>
				<td><button onclick="Alert()" type="button" class="btn btn-md btn-danger btnRemoveUserResponsibility" disabled><i class="fa fa-trash"></i></button></td>
				</tr>';

				echo $showPrev;
			}
		} else {
		}
	}

	public function Insert()
	{
		$doc_no = $this->input->post('no_dokumen');
		$rev_no 	= $this->input->post('no_revisi');
		$rev_date	= $this->input->post('tgl_revisi');
		$catatan_rev	= $this->input->post('catatan_revisi_mpa');
		$nama_mesin = $this->input->post('nama_mesin');
		$kondisi_mesin 	= $this->input->post('kondisi_mesin');
		$header	= $this->input->post('header');
		$uraian_kerja = $this->input->post('uraian_kerja');
		$standar = $this->input->post('standar');
		$periode = $this->input->post('periode');

		// echo"<pre>";
		// print_r($uraian_kerja);
		// exit();

		$i = 0;
		foreach ($uraian_kerja as $uja) {
			$this->M_input->Insert($doc_no[$i], $rev_no[$i], $rev_date[$i], $catatan_rev[$i],$nama_mesin[$i], $kondisi_mesin[$i], $header[$i], $uja, $standar[$i], $periode[$i]);

			$i++;
		}

		redirect(base_url('PeriodicalMaintenance/Input/'));
	}
}
