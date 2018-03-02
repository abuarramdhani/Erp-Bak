<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_AccountReceivables extends CI_Controller {

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
		$this->load->model('MonitoringPEIA/CreditLimit/M_creditlimit');
		  
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
		$data['credit'] = $this->M_creditlimit->showDataSemua();
		$data['laporan'] = $this->M_creditlimit->showDataSemua();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Laporan/V_Index', $data);
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

		$data['seksi'] = $this->M_creditlimit->getAllSeksi();
		$data['order'] = $this->M_creditlimit->getAllOrder();
		$data['jenisOrder'] = $this->M_creditlimit->getAllJenisOrder();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Laporan/V_new', $data);
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

		$data['laporan'] = $this->M_creditlimit->getLaporan($id);
		$data['seksi'] = $this->M_creditlimit->getAllSeksi();
		$data['order'] = $this->M_creditlimit->getAllOrder();
		$data['jenisOrder'] = $this->M_creditlimit->getAllJenisOrder();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Laporan/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Seksi()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_creditlimit->seksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Seksi/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function NewSeksi()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_creditlimit->seksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Seksi/V_new', $data);
		$this->load->view('V_Footer',$data);
	}

	public function EditSeksi($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_creditlimit->getSeksi($id);
		// echo '<pre>'; print_r($data['seksi']); echo '</pre>';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Seksi/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function NewOrder()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3(
		$user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_creditlimit->seksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Order/V_new', $data);
		$this->load->view('V_Footer',$data);
	}

	public function EditOrder($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['order_'] = $this->M_creditlimit->getOrder($id);
		 // echo '<pre>'; print_r($data['order_']); echo '</pre>';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Order/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function NewJenisOrder()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_creditlimit->seksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/JenisOrder/V_new', $data);
		$this->load->view('V_Footer',$data);
	}

	public function EditJenisOrder($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_creditlimit->seksi();
		$data['jenisOrder'] = $this->M_creditlimit->getJenisOrder($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/JenisOrder/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Order()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['order'] = $this->M_creditlimit->order();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function JenisOrder()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jenisorder'] = $this->M_creditlimit->jenisOrder();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/JenisOrder/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function insertSemua()
	{
		$tanggal=$this->input->post("textDate");
		$seksi=$this->input->post("slcseksi");
		$nama=$this->input->post("textNama");
		$order_=$this->input->post("slcorder");
		$jenis_order=$this->input->post("slcjenis");
		$keterangan=$this->input->post("textKeterangan");

		
		$data = $this->M_creditlimit->insertSemua($tanggal,$seksi,$nama,$order_,$jenis_order,$keterangan);
		redirect(base_url('ProductionEngineering/Laporan/'));
	}

	public function insertSeksi()
	{
		$seksi=$this->input->post("textSeksi");
		$deskripsi=$this->input->post("textDeskripsi");
		
		$data = $this->M_creditlimit->insertSeksi($seksi,$deskripsi);
		redirect(base_url('ProductionEngineering/Seksi/'));
	}

	public function UpdateLaporan()
	{
		$tanggal=$this->input->post("textDate");
		$seksi=$this->input->post("slcseksi");
		$nama=$this->input->post("textNama");
		$order_=$this->input->post("slcorder");
		$jenis_order=$this->input->post("slcjenis");
		$keterangan=$this->input->post("textKeterangan");
		$id=$this->input->post("textId");

		
		$data = $this->M_creditlimit->UpdateLaporan($tanggal,$seksi,$nama,$order_,$jenis_order,$keterangan,$id);
		redirect(base_url('ProductionEngineering/Laporan/'));
	}

	public function UpdateSeksi()
	{
		$seksi=$this->input->post("textSeksi");
		$deskripsi=$this->input->post("textDeskripsi");
		$id=$this->input->post("textId");
		
		$data = $this->M_creditlimit->UpdateSeksi($seksi,$deskripsi,$id);
		redirect(base_url('ProductionEngineering/Seksi/'));
	}

	public function insertOrder()
	{
		$order_=$this->input->post("textOrder_");
		$deskripsi=$this->input->post("textDeskripsiOrder");
		
		$data = $this->M_creditlimit->insertOrder($order_,$deskripsi);
		redirect(base_url('ProductionEngineering/Order/'));
	}

	public function UpdateOrder()
	{
		$order_=$this->input->post("textOrder_");
		$deskripsi=$this->input->post("textDeskripsiOrder");
		$id=$this->input->post("textId");
		
		$data = $this->M_creditlimit->UpdateOrder($order_,$deskripsi,$id);
		redirect(base_url('ProductionEngineering/Order/'));
	}

	public function insertJenisOrder()
	{
		$jenisorder=$this->input->post("textJenisOrder");
		$deskripsi=$this->input->post("textDeskripsiJenisOrder");
		
		$data = $this->M_creditlimit->insertJenisOrder($jenisorder,$deskripsi);
		redirect(base_url('ProductionEngineering/JenisOrder/'));
	}

	public function UpdateJenisOrder()
	{
		$jenisorder=$this->input->post("textJenisOrder");
		$deskripsi=$this->input->post("textDeskripsiJenisOrder");
		$id=$this->input->post("textId");
		
		$data = $this->M_creditlimit->UpdateJenisOrder($jenisorder,$deskripsi,$id);
		redirect(base_url('ProductionEngineering/JenisOrder/'));
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

	public function deleteSeksi($id){

		$data= $this->M_creditlimit->deleteSeksi($id);
		redirect(base_url('ProductionEngineering/Seksi/'));
	}
	public function deleteOrder($id){

		$data= $this->M_creditlimit->deleteOrder($id);
		redirect(base_url('ProductionEngineering/Order/'));
	}

	public function deleteJenisOrder($id){

		$data= $this->M_creditlimit->deleteJenisOrder($id);
		redirect(base_url('ProductionEngineering/JenisOrder/'));
	}

	public function deleteLaporan($id){

		$data= $this->M_creditlimit->deleteLaporan($id);
		redirect(base_url('ProductionEngineering/Laporan/'));
	}

	public function buatPDF($tanggalan1,$tanggalan2)
	{
		// $tanggalan1=$this->input->post("daterawal");
		// $tanggalan2=$this->input->post("daterakhir");
		$report = $this->M_creditlimit->searchTanggal($tanggalan1,$tanggalan2);

		$y=15;
		for ($x=0; $x < $y; $x++) {
				if (!empty($report[$x])) {
					$data_array_2[] = array(
						'tanggal' => $report[$x]['tanggal'],
						'seksi' => $report[$x]['seksi'],
						'nama' => $report[$x]['nama'],
						'order_' => $report[$x]['order_'],
						'jenis_order' => $report[$x]['jenis_order'],
						'keterangan' => $report[$x]['keterangan'],
						'no' => $x+1
					);
				}
				else{
					$data_array_2[] = array(
						'tanggal' => '',
						'seksi' => '',
						'nama' => '',
						'order' => '',
						'jenisOrder' => '',
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