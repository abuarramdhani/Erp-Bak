<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_JobHarian extends CI_Controller {

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
		$this->load->model('MonitoringPEIA/JobHarian/M_jobharian');
		  
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
		$this->load->view('MonitoringPEIA/V_Index');
		$this->load->view('V_Footer',$data);
	}

		public function Laporan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['credit'] = $this->M_jobharian->showDataSemua();
		$data['laporan'] = $this->M_jobharian->showDataSemua();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/JobHarian/V_JobHarian', $data);
		$this->load->view('V_Footer',$data);
	}

	public function NewLaporan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['seksi'] = $this->M_jobharian->getAllSeksi();
		// $data['order'] = $this->M_jobharian->getAllOrder();
		// $data['jenisOrder'] = $this->M_jobharian->getAllJenisOrder();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/JobHarian/V_New', $data);
		$this->load->view('V_Footer',$data);
	}

	public function EditLaporan($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['laporan'] = $this->M_jobharian->getLaporan($id);
		// $data['seksi'] = $this->M_jobharian->getAllSeksi();
		// $data['order'] = $this->M_jobharian->getAllOrder();
		// $data['jenisOrder'] = $this->M_jobharian->getAllJenisOrder();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/JobHarian/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function insertSemua()
	{
		$tanggal=date('Y-m-d H:i:s', strtotime($this->input->post("textDate")));
		$nama=$this->input->post("textNama");
		$keterangan=$this->input->post("textKeterangan");

		
		$data = $this->M_jobharian->insertSemua($tanggal,$nama,$keterangan);
		redirect(base_url('ProductionEngineering/JobHarianPIEA/'));
	}

	public function UpdateLaporan()
	{
		$tanggal=date('Y-m-d H:i:s', strtotime($this->input->post("textDate")));
		$nama=$this->input->post("textNama");
		$keterangan=$this->input->post("textKeterangan");
		$id=$this->input->post("textId");

		$data = $this->M_jobharian->UpdateLaporan($tanggal,$nama,$keterangan,$id);
		redirect(base_url('ProductionEngineering/JobHarianPIEA/'));
	}

	public function searchTanggal()
	{
		$tanggalan1=$this->input->post("tgl1");
		$tanggalan2=$this->input->post("tgl2");


		$data = $this->M_jobharian->searchTanggal($tanggalan1,$tanggalan2);
		$no = 1; 
		// foreach ($data as $cl) { 
		//  	echo '<tr row-id="'.$cl['id'].'">
		// 				<td style="text-align:center">'.$no.'</td>
		// 				<td style="text-align:center">'.$cl['tanggal'].'</td>
		// 				<td style="text-align:center">'.$cl['nama'].'</td>
		// 				<td style="text-align:center">'.$cl['keterangan'].'</td>
		// 				<td style="text-align:center" class="col-md-2">
		// 					<div class="btn-group-justified" role="group">
		// 						<a class="btn btn-warning" href="'.base_url().'ProductionEngineering/JobHarian/edit/'.$cl['id'].'">EDIT</a>
		// 						<a class="btn btn-danger hapus" onclick="DeleteLaporan('.$cl['id'].')">DELETE</a>
		// 					</div>
		// 				</td>
		// 			</tr>';
		// 		$no++;}
	}

	public function deleteLaporan($id){

		$data= $this->M_jobharian->deleteLaporan($id);
		redirect(base_url('ProductionEngineering/JobHarianPIEA'));
	}

	public function buatPDF($tanggalan1,$tanggalan2)
	{
		// $tanggalan1=$this->input->post("daterawal");
		// $tanggalan2=$this->input->post("daterakhir");
		$report = $this->M_jobharian->searchTanggal($tanggalan1,$tanggalan2);

		$y=15;
		for ($x=0; $x < $y; $x++) {
				if (!empty($report[$x])) {
					$data_array_2[] = array(
						'tanggal' => $report[$x]['tanggal'],
						'nama' => $report[$x]['nama'],
						'keterangan' => $report[$x]['keterangan'],
						'no' => $x+1
					);
				}
				else{
					$data_array_2[] = array(
						'tanggal' => '',
						'nama' => '',
						'keterangan' => '',
						'no' => ''
					);
				}
			}
		$data['report'] = $data_array_2;

		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','A4-L', 0, '', 9, 9, 9, 9); 
		$filename = 'Report_PIEA_.pdf';
		
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$html = $this->load->view('MonitoringPEIA/V_PDF', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');




		$this->load->view('MonitoringPEIA/V_PDF',$data);

	}

}