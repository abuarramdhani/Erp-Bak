<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MonitoringCBO extends CI_Controller {

	public function __construct()
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
		$this->load->model('MonitoringCBO/M_cbo');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	//------------------------show the dashboard-----------------------------
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
		$this->load->view('MonitoringCBO/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function searchReport()
	{
		$tanggal=$this->input->post("tgl");
		$shift=$this->input->post("shift");
		$line=$this->input->post("line");
		$komponen=$this->input->post("komp");


		$data = $this->M_cbo->getReport($tanggal,$shift,$line,$komponen);
		foreach ($data as $cl) { 
		 	echo '<tr row-id="1">
						<td>
						'.$cl['tipe'].'
						</td>
						<td style="min-width:100px">
						'.$cl['hasil_cat'].'
						</td>
						<td style="min-width:100px">
						'.$cl['ok'].'
						</td>
						<td style="min-width:100px">
						'.$cl['reject'].'
						</td>
						<td style="min-width:100px">
							'.$cl['belang_a'].'
						</td>
						<td style="min-width:100px">
							'.$cl['belang_b'].'
						</td>
						<td style="min-width:100px">
							'.$cl['belang_c'].'
						</td>
						<td style="min-width:100px">
							'.$cl['dlewer_a'].'
						</td>
						<td style="min-width:100px">
							'.$cl['dlewer_b'].'
						</td>
						<td style="min-width:100px">
							'.$cl['dlewer_c'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_cat_a'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_cat_b'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_cat_c'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kropos_a'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kropos_b'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kropos_c'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_spat_a'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_spat_b'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_spat_c'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_mat_a'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_mat_b'].'
						</td>
						<td style="min-width:100px">
							'.$cl['kasar_mat_c'].'
						</td>
						<td style="min-width:100px">
							'.$cl['lain_lain'].'
						</td>
					</tr>
					';
	}
}

	public function regen()
	{
		$back = 1;

		check:
		$front = date('ymd');
		$nomor_urut = $front.str_pad($back, 3, "0", STR_PAD_LEFT);
		$check = $this->M_cbo->cekNomor($nomor_urut);
		if (!empty($check)) {
		$back++;
		GOTO check;
		}
		echo $nomor_urut;

		$tanggal=$this->input->post("tgl");
		$shift=$this->input->post("shift");
		$line=$this->input->post("line");
		$komponen=$this->input->post("komp");

		$data = $this->M_cbo->insertCBO($nomor_urut,$tanggal,$shift,$line,$komponen);

		$tipe = $this->M_cbo->tipe();
		
		
		foreach ($tipe as $key) {
			# code...
			$data = $this->M_cbo->insertDetail($nomor_urut,$key['DESCRIPTION']);

		}
		$data['detail'] = $this->M_cbo->getDetail($nomor_urut);
		foreach ($data['detail'] as $key) {
				$tipe = "'".$key['tipe']."'";
				$hasilCat = "'hasil_cat'";
				$ok = "'ok'";
				$reject = "'reject'";
				$belang_a = "'belang_a'";
				$belang_b = "'belang_b'";
				$belang_c = "'belang_c'";
				$dlewer_a = "'dlewer_a'";
				$dlewer_b = "'dlewer_b'";
				$dlewer_c = "'dlewer_c'";
				$kasar_cat_a = "'kasar_cat_a'";
				$kasar_cat_b = "'kasar_cat_b'";
				$kasar_cat_c = "'kasar_cat_c'";
				$kropos_a = "'kropos_a'";
				$kropos_b = "'kropos_b'";
				$kropos_c = "'kropos_c'";
				$kasar_spat_a = "'kasar_spat_a'";
				$kasar_spat_b = "'kasar_spat_b'";
				$kasar_spat_c = "'kasar_spat_c'";
				$kasar_mat_a = "'kasar_mat_a'";
				$kasar_mat_b = "'kasar_mat_b'";
				$kasar_mat_c = "'kasar_mat_c'";
				$lain_lain = "'lain_lain'";
				echo '
				<tr row-id="1">
						<td style="width:100px">
						'.$key['tipe'].'
						<input type="hidden" id="no_cbo" value="'.$key['no_cbo'].'"/>
						</td>
						<td style="width:100px">
						'.$key['hasil_cat'].'
						</td>
						<td style="width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$hasilCat.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="width:100px">
						'.$key['ok'].'
						</td>
						<td style="width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$ok.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['reject'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$reject.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['belang_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$belang_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['belang_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$belang_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['belang_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$belang_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['dlewer_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$dlewer_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['dlewer_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$dlewer_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['dlewer_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$dlewer_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_cat_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_cat_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_cat_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_cat_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_cat_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_cat_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kropos_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kropos_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kropos_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kropos_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kropos_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kropos_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_spat_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_spat_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_spat_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_spat_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_spat_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_spat_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_mat'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_mat_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_mat'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_mat_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_mat'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_mat_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['lain_lain'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$lain_lain.')" type="number" name="hasilCat" class="form-control">
						</td>
					</tr>';
		}

	}

	public function cek_cbo()
	{
		$tanggal=$this->input->post("tgl");
		$shift=$this->input->post("shift");
		$line=$this->input->post("line");
		$komponen=$this->input->post("komp");

		$data = $this->M_cbo->cekCBO($tanggal,$shift,$line,$komponen);
		foreach ($data as $key) {
			echo $key['no_cbo'];

		}
	}

	public function cbo_edit()
	{
		$tanggal=$this->input->post("tgl");
		$shift=$this->input->post("shift");
		$line=$this->input->post("line");
		$komponen=$this->input->post("komp");

		$data = $this->M_cbo->cekCBO($tanggal,$shift,$line,$komponen);
		foreach ($data as $cbo) {
			echo $cbo['no_cbo'];

		}
		$data['detail'] = $this->M_cbo->getDetail($cbo['no_cbo']);
		foreach ($data['detail'] as $key) {
				$tipe = "'".$key['tipe']."'";
				$hasilCat = "'hasil_cat'";
				$ok = "'ok'";
				$reject = "'reject'";
				$belang_a = "'belang_a'";
				$belang_b = "'belang_b'";
				$belang_c = "'belang_c'";
				$dlewer_a = "'dlewer_a'";
				$dlewer_b = "'dlewer_b'";
				$dlewer_c = "'dlewer_c'";
				$kasar_cat_a = "'kasar_cat_a'";
				$kasar_cat_b = "'kasar_cat_b'";
				$kasar_cat_c = "'kasar_cat_c'";
				$kropos_a = "'kropos_a'";
				$kropos_b = "'kropos_b'";
				$kropos_c = "'kropos_c'";
				$kasar_spat_a = "'kasar_spat_a'";
				$kasar_spat_b = "'kasar_spat_b'";
				$kasar_spat_c = "'kasar_spat_c'";
				$kasar_mat_a = "'kasar_mat_a'";
				$kasar_mat_b = "'kasar_mat_b'";
				$kasar_mat_c = "'kasar_mat_c'";
				$lain_lain = "'lain_lain'";
				echo '
				<tr row-id="1">
						<td>
						'.$key['tipe'].'
						<input type="hidden" id="no_cbo" value="'.$key['no_cbo'].'"/>
						</td>
						<td style="min-width:100px">
						'.$key['hasil_cat'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$hasilCat.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['ok'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$ok.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['reject'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$reject.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['belang_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$belang_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['belang_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$belang_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['belang_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$belang_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['dlewer_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$dlewer_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['dlewer_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$dlewer_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['dlewer_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$dlewer_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_cat_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_cat_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_cat_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_cat_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_cat_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_cat_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kropos_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kropos_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kropos_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kropos_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kropos_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kropos_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_spat_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_spat_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_spat_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_spat_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_spat_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_spat_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_mat_a'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_mat_a.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_mat_b'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_mat_b.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['kasar_mat_c'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$kasar_mat_c.')" type="number" name="hasilCat" class="form-control">
						</td>
						<td style="min-width:100px">
						'.$key['lain_lain'].'
						</td>
						<td style="min-width:100px">
							<input onkeypress="UpdateDetail(event,this,'.$tipe.','.$lain_lain.')" type="number" name="hasilCat" class="form-control">
						</td>
					</tr>';
		}

		}

	public function CBO_Input()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['komponen'] = $this->M_cbo->komponen();
		$data['shift'] = $this->M_cbo->shift();
		$data['line'] = $this->M_cbo->line();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/CBO/V_input', $data);
		$this->load->view('V_Footer',$data);
	}

	public function CBO_Grafik()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['komponen'] = $this->M_cbo->komponen();
		$data['shift'] = $this->M_cbo->shift();
		$data['line'] = $this->M_cbo->line();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/CBO/V_grafik', $data);
		$this->load->view('V_Footer',$data);
	}

	public function grafik()
	{
		$tanggal1=$this->input->post("tanggal1");
		$tanggal2=$this->input->post("tanggal2");
		$shift=$this->input->post("shift");
		$line=$this->input->post("line");
		$komponen=$this->input->post("komponen");
		
		$data['cbo'] = $this->M_cbo->getGrafik($tanggal1,$tanggal2,$shift,$line,$komponen);
		echo json_encode($data);
	}

	public function CBO_Report()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['komponen'] = $this->M_cbo->komponen();
		$data['shift'] = $this->M_cbo->shift();
		$data['line'] = $this->M_cbo->line();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/CBO/V_report', $data);
		$this->load->view('V_Footer',$data);
	}

	public function UpdateDetail()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		$col=$this->input->post("col");

		$data = $this->M_cbo->UpdateDetail($input,$no_urut,$tipe,$col);	
		
		if($data==1){
			$qty = $this->M_cbo->getQTY($col,$tipe,$no_urut);
			foreach ($qty as $q) {
				echo $q[$col];
			}
		}
	}

	public function Ok()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateOk($input,$no_urut,$tipe);
		
	}

	public function Reject()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateReject($input,$no_urut,$tipe);
		
	}

	public function Belang()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateBelang($input,$no_urut,$tipe);
		
	}

	public function Dlewer()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateDlewer($input,$no_urut,$tipe);
		
	}

	public function KasarCat()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateKasarCat($input,$no_urut,$tipe);
		
	}

	public function Kropos()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateKropos($input,$no_urut,$tipe);
		
	}

	public function KasarSpat()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateKasarSpat($input,$no_urut,$tipe);
		
	}

	public function KasarMat()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateKasarMat($input,$no_urut,$tipe);
		
	}

	public function Lain()
	{
		$input=$this->input->post("HasilCat");
		$no_urut=$this->input->post("inp_cbo");
		$tipe=$this->input->post("type");
		
		$data = $this->M_cbo->UpdateLain($input,$no_urut,$tipe);
		
	}

	public function insertKomponen()
	{
		$komponen=$this->input->post("textKomponen");
		
		$data = $this->M_cbo->insertKomponen($komponen);
		redirect(base_url('CBOPainting/Setup/Komponen/'));
	}

	public function Komponen()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['komponen'] = $this->M_cbo->komponen();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/Komponen/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function NewKomponen()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['komponen'] = $this->M_cbo->komponen();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/Komponen/V_new', $data);
		$this->load->view('V_Footer',$data);
	}


	public function EditKomponen($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['komponen'] = $this->M_cbo->getKomponen($id);
		// echo '<pre>'; print_r($data['seksi']); echo '</pre>';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/Komponen/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function UpdateKomponen()
	{
		$komponen=$this->input->post("textKomponen");
		$id=$this->input->post("textId");

		
		$data = $this->M_cbo->UpdateKomponen($komponen,$id);
		redirect(base_url('CBOPainting/Setup/Komponen/'));
	}

	public function deleteKomponen($id){

		$data= $this->M_cbo->deleteKomponen($id);
		redirect(base_url('CBOPainting/Setup/Komponen/'));
	}

	public function Tipe()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tipe'] = $this->M_cbo->tipe();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/Tipe/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function NewTipe()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tipe'] = $this->M_cbo->tipe();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/Tipe/V_new', $data);
		$this->load->view('V_Footer',$data);
	}

	public function insertTipe()
	{
		$tipe=$this->input->post("textTipe");
		
		$data = $this->M_cbo->insertTipe($tipe);
		redirect(base_url('CBOPainting/Setup/Tipe/'));
	}

	public function EditTipe($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tipe'] = $this->M_cbo->getTipe($id);
		// echo '<pre>'; print_r($data['seksi']); echo '</pre>';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCBO/Tipe/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function UpdateTipe()
	{
		$tipe=$this->input->post("textTipe");
		$id=$this->input->post("textId");

		
		$data = $this->M_cbo->UpdateTipe($tipe,$id);
		redirect(base_url('CBOPainting/Setup/Tipe/'));
	}

	public function deleteTipe($id){

		$data= $this->M_cbo->deleteTipe($id);
		redirect(base_url('CBOPainting/Setup/Tipe/'));
	}


	public function searchTanggal()
	{
		$tanggalan1=$this->input->post("tgl1");
		$tanggalan2=$this->input->post("tgl2");


		$data = $this->M_creditlimit->searchTanggal($tanggalan1,$tanggalan2);
		$no = 1; 
		foreach ($data as $cl) { 
		 	echo '<tr row-id="'.$cl['id'].'">
						<td style="text-align:center">'.$no.'</td>
						<td style="text-align:center">'.$cl['tanggal'].'</td>
						<td style="text-align:center">'.$cl['seksi'].'</td>
						<td style="text-align:center">'.$cl['nama'].'</td>
						<td style="text-align:center">'.$cl['order_'].'</td>
						<td style="text-align:center">'.$cl['jenis_order'].'</td>
						<td style="text-align:center">'.$cl['keterangan'].'</td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-default" href="'.base_url().'ProductionEngineering/Laporan/edit/'.$cl['id'].'">EDIT</a>
								<a class="btn btn-default hapus" onclick="DeleteLaporan('.$cl['id'].')">DELETE</a>
							</div>
						</td>
					</tr>';
				$no++;}
	}

	public function deleteOrder($id){

		$data= $this->M_creditlimit->deleteOrder($id);
		redirect(base_url('ProductionEngineering/Order/'));
	}

	public function deleteJenisOrder($id){

		$data= $this->M_creditlimit->deleteJenisOrder($id);
		redirect(base_url('ProductionEngineering/JenisOrder/'));
	}

	public function buatPDF($tanggal,$shift,$line,$komponen)
	{
		$kom = str_replace('%20', ' ', $komponen);
		$report = $this->M_cbo->getReport($tanggal,$shift,$line,$kom);
		
	
		$data['report'] = $report;

		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','A4-L', 0, '', 9, 9, 9, 9); 
		$filename = 'Report_CBO_.pdf';
		
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$html = $this->load->view('MonitoringCBO/V_PDF', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}

	public function exportReport()
	{
	$tanggal=$this->input->post("textDate");
	$shift=$this->input->post("slcshift");
	$line=$this->input->post("slcline");
	$komponen=$this->input->post("slckomponen");

	$this->load->library('Excel');
	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();
	$styleThead = array(
	'font'  => array(
	'bold'  => true,
	'color' => array('rgb' => 'FFFFFF'),
	'size'	=> 14,
	),
	'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
	)
	);
	$styleBorder = array(
	'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
	)
	);
	$styleTitle = array(
	'font'  => array(
	'bold'  => true,
	'color' => array('rgb' => '000000'),
	'size'	=> 24,
	),
	'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        	)
	);	

	$styleTitle1 = array(
	'font'  => array(
	'bold'  => true,
	'color' => array('rgb' => '000000'),
	'size'	=> 11,
	),
	'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        	)
	);

	$data = $this->M_cbo->getReport($tanggal,$shift,$line,$komponen);

	$worksheet->getColumnDimension('A')->setWidth(30);
	$worksheet->getColumnDimension('B')->setWidth(8);
	$worksheet->getColumnDimension('C')->setWidth(5);
	$worksheet->getColumnDimension('D')->setWidth(5);
	$worksheet->getColumnDimension('E')->setWidth(5);
	$worksheet->getColumnDimension('F')->setWidth(5);
	$worksheet->getColumnDimension('G')->setWidth(5);
	$worksheet->getColumnDimension('H')->setWidth(5);
	$worksheet->getColumnDimension('I')->setWidth(5);
	$worksheet->getColumnDimension('J')->setWidth(5);
	$worksheet->getColumnDimension('K')->setWidth(5);
	$worksheet->getColumnDimension('L')->setWidth(5);
	$worksheet->getColumnDimension('M')->setWidth(5);
	$worksheet->getColumnDimension('N')->setWidth(5);
	$worksheet->getColumnDimension('O')->setWidth(5);
	$worksheet->getColumnDimension('P')->setWidth(5);
	$worksheet->getColumnDimension('Q')->setWidth(5);
	$worksheet->getColumnDimension('R')->setWidth(5);
	$worksheet->getColumnDimension('S')->setWidth(5);
	$worksheet->getColumnDimension('T')->setWidth(5);
	$worksheet->getColumnDimension('U')->setWidth(5);
	$worksheet->getColumnDimension('V')->setWidth(5);
	$worksheet->getColumnDimension('W')->setWidth(8);

	$worksheet->getStyle('A6:D1')->applyFromArray($styleThead);
	$worksheet	->getStyle('A6:D1')
	->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()
	->setARGB('337ab7');

	// ----------------- Set table header -----------------
	$worksheet->mergeCells('A1:D1');
	$worksheet->getStyle('A1:D1')->applyFromArray($styleTitle);
	$worksheet->mergeCells('A3:A5');
	$worksheet->mergeCells('B3:B5');
	$worksheet->mergeCells('C3:D3');
	$worksheet->mergeCells('C4:C5');
	$worksheet->mergeCells('D4:D5');
	$worksheet->mergeCells('E3:M3');
	$worksheet->mergeCells('E4:G4');
	$worksheet->mergeCells('H4:J4');
	$worksheet->mergeCells('K4:M4');
	$worksheet->mergeCells('N3:V3');
	$worksheet->mergeCells('N4:P4');
	$worksheet->mergeCells('Q4:S4');
	$worksheet->mergeCells('T4:V4');
	$worksheet->mergeCells('W3:W5');
	$worksheet->getStyle('A3:W3')->applyFromArray($styleBorder);
	$worksheet->getStyle('A3:W3')->applyFromArray($styleTitle1);
	$worksheet->getStyle('A4:W4')->applyFromArray($styleBorder);
	$worksheet->getStyle('A4:W4')->applyFromArray($styleTitle1);
	$worksheet->getStyle('A5:W5')->applyFromArray($styleBorder);
	$worksheet->getStyle('A5:W5')->applyFromArray($styleTitle1);
	// $worksheet->getStyle("A1:L1")->getFont()->setSize(18);
	$worksheet->setCellValue('A1', 'HASIL MONITORING CBO');

	$worksheet->setCellValue('A3', 'Tipe');
	$worksheet->setCellValue('B3', 'Hasil Cat');
	$worksheet->setCellValue('C3', 'Hasil CBO');
	$worksheet->setCellValue('C4', 'Ok');
	$worksheet->setCellValue('D4', 'Reject');
	$worksheet->setCellValue('E3', 'Repair Proses');
	$worksheet->setCellValue('E4', 'Belang');
	$worksheet->setCellValue('E5', 'A');
	$worksheet->setCellValue('F5', 'B');
	$worksheet->setCellValue('G5', 'C');
	$worksheet->setCellValue('H4', 'Dlewer');
	$worksheet->setCellValue('H5', 'A');
	$worksheet->setCellValue('I5', 'B');
	$worksheet->setCellValue('J5', 'C');
	$worksheet->setCellValue('K4', 'Kasar Cat');
	$worksheet->setCellValue('K5', 'A');
	$worksheet->setCellValue('L5', 'B');
	$worksheet->setCellValue('M5', 'C');
	$worksheet->setCellValue('N3', 'Repair Material');
	$worksheet->setCellValue('N4', 'Kropos');
	$worksheet->setCellValue('N5', 'A');
	$worksheet->setCellValue('O5', 'B');
	$worksheet->setCellValue('P5', 'C');
	$worksheet->setCellValue('Q4', 'Kasar Spat');
	$worksheet->setCellValue('Q5', 'A');
	$worksheet->setCellValue('R5', 'B');
	$worksheet->setCellValue('S5', 'C');
	$worksheet->setCellValue('T4', 'Kasar Mat');
	$worksheet->setCellValue('T5', 'A');
	$worksheet->setCellValue('U5', 'B');
	$worksheet->setCellValue('V5', 'C');
	$worksheet->setCellValue('W3', 'Lain-lain');


	// ----------------- Set table body -----------------
	$no = 1;
	$highestRow = $worksheet->getHighestRow()+1;
	foreach ($data as $dt) {
	$worksheet->getStyle('A'.$highestRow.':W'.$highestRow)->applyFromArray($styleBorder);

	$worksheet->setCellValue('A'.$highestRow, $dt['tipe']);
	$worksheet->setCellValue('B'.$highestRow, $dt['hasil_cat']);
	$worksheet->setCellValue('C'.$highestRow, $dt['ok']);
	$worksheet->setCellValue('D'.$highestRow, $dt['reject']);
	$worksheet->setCellValue('E'.$highestRow, $dt['belang_a']);
	$worksheet->setCellValue('F'.$highestRow, $dt['belang_b']);
	$worksheet->setCellValue('G'.$highestRow, $dt['belang_c']);
	$worksheet->setCellValue('H'.$highestRow, $dt['dlewer_a']);
	$worksheet->setCellValue('I'.$highestRow, $dt['dlewer_b']);
	$worksheet->setCellValue('J'.$highestRow, $dt['dlewer_c']);
	$worksheet->setCellValue('K'.$highestRow, $dt['kasar_cat_a']);
	$worksheet->setCellValue('L'.$highestRow, $dt['kasar_cat_b']);
	$worksheet->setCellValue('M'.$highestRow, $dt['kasar_cat_c']);
	$worksheet->setCellValue('N'.$highestRow, $dt['kropos_a']);
	$worksheet->setCellValue('O'.$highestRow, $dt['kropos_b']);
	$worksheet->setCellValue('P'.$highestRow, $dt['kropos_c']);
	$worksheet->setCellValue('Q'.$highestRow, $dt['kasar_spat_a']);
	$worksheet->setCellValue('R'.$highestRow, $dt['kasar_spat_b']);
	$worksheet->setCellValue('S'.$highestRow, $dt['kasar_spat_c']);
	$worksheet->setCellValue('T'.$highestRow, $dt['kasar_mat_a']);
	$worksheet->setCellValue('U'.$highestRow, $dt['kasar_mat_b']);
	$worksheet->setCellValue('V'.$highestRow, $dt['kasar_mat_c']);
	$worksheet->setCellValue('W'.$highestRow, $dt['lain_lain']);

	$highestRow++;


	}

	// ----------------- Final Process -----------------
	$worksheet->setTitle('Monitoring CBO');
	// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Hasil_CBO'.time().'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("php://output");

	}

}