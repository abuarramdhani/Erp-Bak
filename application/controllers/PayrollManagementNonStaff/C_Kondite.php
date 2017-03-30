<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Kondite extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_kondite');

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

		$data['Title'] = 'Kondite';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Kondite'] = $this->M_kondite->getKondite();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create($term)
	{
		$user_id = $this->session->userid;

		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		//$data['EmployeeAll'] = $this->M_kondite->getEmployeeAll();
		//$data['Section'] = $this->M_kondite->getSection();

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($term == 'seksi') {
			$data['Title'] = 'Input Insentif Kondite Per Seksi';
			$this->load->view('PayrollManagementNonStaff/Kondite/V_create_per_seksi', $data);
		}
		elseif ($term == 'pekerja') {
			$data['Title'] = 'Input Insentif Kondite Per Pekerja';
			$this->load->view('PayrollManagementNonStaff/Kondite/V_create', $data);
		}
		else{
			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}

		$this->load->view('V_Footer',$data);	
	}

	public function doCreate($term){
		if ($term == 'seksi') {
			$tanggal = $this->input->post('txtTanggalHeader');
			$kodesie = $this->input->post('cmbKodesie');
			$noind = $this->input->post('txtNoindHeader');

			for ($i=0; $i < count($noind); $i++) {

				$data = array(
					'noind' => $noind[$i],
					'kodesie' => $kodesie,
					'tanggal' => $tanggal,
					'MK' => $this->input->post('txtMKHeader['.$i.']'),
					'BKI' => $this->input->post('txtBKIHeader['.$i.']'),
					'BKP' => $this->input->post('txtBKPHeader['.$i.']'),
					'TKP' => $this->input->post('txtTKPHeader['.$i.']'),
					'KB' => $this->input->post('txtKBHeader['.$i.']'),
					'KK' => $this->input->post('txtKKHeader['.$i.']'),
					'KS' => $this->input->post('txtKSHeader['.$i.']'),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);
				$this->M_kondite->setKondite($data);

			}

			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		elseif ($term == 'pekerja') {
			$tanggal = $this->input->post('txtTanggalHeader');
			$noind_kodesie = $this->input->post('cmbNoindHeader');
			$explode = explode(' - ', $noind_kodesie);
			$noind = $explode[0];
			$kodesie = $explode[1];

			for ($i=0; $i < count($tanggal); $i++) {

				$data = array(
					'noind' => $noind,
					'kodesie' => $kodesie,
					'tanggal' => $tanggal[$i],
					'MK' => $this->input->post('txtMKHeader['.$i.']'),
					'BKI' => $this->input->post('txtBKIHeader['.$i.']'),
					'BKP' => $this->input->post('txtBKPHeader['.$i.']'),
					'TKP' => $this->input->post('txtTKPHeader['.$i.']'),
					'KB' => $this->input->post('txtKBHeader['.$i.']'),
					'KK' => $this->input->post('txtKKHeader['.$i.']'),
					'KS' => $this->input->post('txtKSHeader['.$i.']'),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);
				$this->M_kondite->setKondite($data);

			}

			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		else{
			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kondite';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Kondite'] = $this->M_kondite->getKondite($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['EmployeeAll'] = $this->M_kondite->getEmployeeAll();
		$data['Section'] = $this->M_kondite->getSection();

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_update', $data);
		$this->load->view('V_Footer',$data);	
	}

	public function doUpdate($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$data = array(
			'noind' => $this->input->post('cmbNoindHeader',TRUE),
			'kodesie' => $this->input->post('cmbKodesieHeader',TRUE),
			'tanggal' => $this->input->post('txtTanggalHeader',TRUE),
			'MK' => $this->input->post('txtMKHeader',TRUE),
			'BKI' => $this->input->post('txtBKIHeader',TRUE),
			'BKP' => $this->input->post('txtBKPHeader',TRUE),
			'TKP' => $this->input->post('txtTKPHeader',TRUE),
			'KB' => $this->input->post('txtKBHeader',TRUE),
			'KK' => $this->input->post('txtKKHeader',TRUE),
			'KS' => $this->input->post('txtKSHeader',TRUE),
			'approval' => $this->input->post('txtApprovalHeader',TRUE),
			'approve_date' => $this->input->post('txtApproveDateHeader',TRUE),
			'approved_by' => $this->input->post('txtApprovedByHeader',TRUE),
			);
		$this->M_kondite->updateKondite($data, $plaintext_string);

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));

	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kondite';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Kondite'] = $this->M_kondite->getKondite($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

	/* DELETE DATA */
	public function delete($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_kondite->deleteKondite($plaintext_string);

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
	}

	public function getPekerja(){
		$kodesie = $this->input->post('kodesie');

		$data = $this->M_kondite->getPekerja($kodesie);

		if (count($data) > 0) {
			foreach ($data as $data) {
				echo '
					<tr>
						   <td width="30%">
						   		'.$data['employee_code'].' - '.$data['employee_name'].'
								  <input type="hidden" class="form-control" name="txtNoindHeader[]" value="'.$data['employee_code'].'" required>
						   </td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtMKHeader[]" placeholder="MK" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtBKIHeader[]" placeholder="BKI" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtBKPHeader[]" placeholder="BKP" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtTKPHeader[]" placeholder="TKP" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKBHeader[]" placeholder="KB" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKKHeader[]" placeholder="KK" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKSHeader[]" placeholder="KS" required></td>
					</tr>
				';
			}
		}
		else{
			echo '
				<tr>
					<td colspan="8" class="text-center"><h4>No Data Found, Please select other Section Code</h4></td>
				</tr>
			';
		}

	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */