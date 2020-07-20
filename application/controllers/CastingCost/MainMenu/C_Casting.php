<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Casting extends CI_Controller 
{
	public function __construct()
		{
			parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CastingCost/MainMenu/M_Casting');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}

	}

		public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['material'] = $this->M_Casting->getMaterial();
			$data['request'] = $this->M_Casting->getAllRequest();
			$data['request_done'] = $this->M_Casting->getDoneRequest();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			if ($user_name == 'B0585') {
				$this->load->view('CastingCost/V_DashboardCasting',$data);
			}else{
				$this->load->view('CastingCost/V_Casting',$data);
			}
			$this->load->view('V_Footer',$data);
		}

	public function edit_request($id)
		{	
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			//$data['user'] = $usr;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['data_input'] = $this->M_Casting->getRequest($id);
			$data['year'] = $this->M_Casting->getYear();
			$data['period'] = $this->M_Casting->getPeriod();
			$data['costMachine'] = $this->M_Casting->getCostMachine();
			$data['costElectric'] = $this->M_Casting->getCostElectric();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CastingCost/V_EditCasting',$data);;
			$this->load->view('V_Footer',$data);
		}

	public function save_cost_machine()
		{
			$resource = $this->input->post('resource');
			$cost = $this->input->post('cost');
			$this->M_Casting->save_cost_machine($resource,$cost);
		}

	public function save_cost_electric()
		{
			$resource = $this->input->post('resource');
			$cost = $this->input->post('cost');
			$this->M_Casting->save_cost_electric($resource,$cost);
		}

	public function submit()
		{
			$pemesan 		  	= $this->input->post('txt_pemesan');
			$part_number      	= $this->input->post('txt_partNumber');
			$desc 			  	= $this->input->post('txt_description');
			$material_casting 	= $this->input->post('txt_materialCasting');
			$berat_casting 	  	= $this->input->post('berat_casting');
			$berat_remelt 	    = $this->input->post('berat_remelt');
			$berat_cairan 	  	= $this->input->post('berat_cairan');
			$yield_casting 		= $this->input->post('yield_casting');
			$materialInti 		= $this->input->post('txt_materialInti');
			$berat_inti 		= $this->input->post('berat_inti');
			$target_inti 		= str_replace(',', '',$this->input->post('target_inti'));
			$mesin_shelcore 	= $this->input->post('txt_mesin_shelcore');
			$moulding 			= $this->input->post('txt_moulding');
			$scrap 				= $this->input->post('scrap');
			$basic_tonage 		= str_replace(',', '',$this->input->post('basic_tonage'));
			$target_pieces 		= str_replace(',', '',$this->input->post('target_pieces'));
			$cavity_flask 		= $this->input->post('cavity_flask');
			$target_flask 		= str_replace(',', '',$this->input->post('target_flask'));
			$berat_pasir 		= str_replace(',', '',$this->input->post('berat_pasir'));
			$batu_gerinda 		= $this->input->post('batu_gerinda');
			$target_grinding 	= str_replace(',', '',$this->input->post('target_grinding'));
			$pembuatan_pola 	= $this->input->post('pembuatan_pola');
			$user 				= $this->session->user;
			$cek_no_doc 		= $this->M_Casting->cekDoc();
			$no_doc 			= str_pad($cek_no_doc+1, 4, '0', STR_PAD_LEFT);
					if ($berat_casting == '') {
						$berat_casting = NULL;
					}
					if ($berat_remelt == '') {
						$berat_remelt = NULL;
					}
					if ($berat_remelt == '') {
						$berat_remelt = NULL;
					}
					if ($berat_casting == '') {
						$berat_casting = NULL;
					}
					if ($berat_cairan == '') {
						$berat_cairan = NULL;
					}
					if ($yield_casting == '') {
						$yield_casting = NULL;
					}
					if ($berat_inti == '') {
						$berat_inti = NULL;
					}
					if ($target_inti == '') {
						$target_inti = NULL;
					}
					if ($scrap == '') {
						$scrap = NULL;
					}
					if ($basic_tonage == '') {
						$basic_tonage = NULL;
					}
					if ($target_pieces == '') {
						$target_pieces = NULL;
					}
					if ($cavity_flask == '') {
						$cavity_flask = NULL;
					}
					if ($target_flask == '') {
						$target_flask = NULL;
					}
					if ($berat_pasir == '') {
						$berat_pasir = NULL;
					}
					if ($batu_gerinda == '') {
						$batu_gerinda = NULL;
					}
					if ($target_grinding == '') {
						$target_grinding = NULL;
					}
					if ($pembuatan_pola == '') {
						$pembuatan_pola = NULL;
					}
			$data['data_casting'] = array(  
							'orderer' 			  => $pemesan,
							'part_number' 		  => $part_number,
							'description' 		  => $desc,
							'date_template' 	  => date('d-M-Y'),
							'material_casting' 	  => $material_casting,
							'casting_weight' 	  => $berat_casting,
							'remelt_weight' 	  => $berat_remelt,
							'liquid_weight' 	  => $berat_cairan,
							'yield_casting' 	  => $yield_casting,
							'scrap_reject' 		  => $scrap,
							'material_core' 	  => $materialInti,
							'core_weight' 		  => $berat_inti,
							'target_core' 		  => $target_inti,
							'shelcore_machine'    => $mesin_shelcore,
							'molding_machine' 	  => $moulding,
							'target_mold_pieces'  => $target_pieces,
							'cavity' 			  => $cavity_flask,
							'target_mold_flask'   => $target_flask, 
							'sand_mold_weight'    => $berat_pasir,
							'target_grinding'     => $target_grinding,
							'grindstone' 		  => $batu_gerinda,
							'time_making'  		  => $pembuatan_pola,
							'basic_tonage' 		  => $basic_tonage,
							'user_submitter'	  => $user,
							'sign_confirmation'   => '0',
							'date_submition' 	  => 'now()',
							'no_document'		  => $no_doc,
							);
			$data_casting  = $data['data_casting'];
			$this->M_Casting->save($data_casting);
			$this->load->library('Pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('','', 0, '', 15, 15, 16, 16, 9, 9, 'P');
			$filename ='TemplateCasting_'.str_replace(" ","", $desc).'_'.date('d-M-Y').'.pdf';
			$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
			$html = $this->load->view('CastingCost/V_CastingStatement', $data, true);
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html);
			$pdf->Output($filename, 'D');


		}
}