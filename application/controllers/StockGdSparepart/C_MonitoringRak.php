<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MonitoringRak extends CI_Controller
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
		$this->load->model('StockGdSparepart/M_monitoringrak');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function Lantai2()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Lantai 2';
		$data['Menu'] = 'Lantai 2';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_Lantai2', $data);
		$this->load->view('V_Footer',$data);
  }

	public function DetailLt2($lokasi)
	{
		if ($lokasi == 'AREA%20SHAFT') {
			$lokasi = 'AREA SHAFT';
		}else {
			$lokasi = $lokasi;
		}
		$lantai = 'Lantai 2';
		$this->Detail($lokasi, $lantai);
	}

	public function Detail($lokasi, $lantai){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Rak';
		$data['Menu'] = 'Monitoring Rak';
		$data['SubMenuOne'] = $lantai;
		$data['SubMenuTwo'] = $lantai;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_monitoringrak->getdata($lokasi);
		$data['lokasi'] = $lokasi;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_DetailRak', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Cetak()
	{
		$data['lokasi'] = $this->input->post('lokasi');
		$data['data'] = $this->M_monitoringrak->getdata($data['lokasi']);
		// echo "<pre>";print_r($data['data']);exit();
		
		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','f4', 0, '', 10, 10, 28, 10, 7, 4);
		$filename 	= 'monitoringrak.pdf';
		$head 	= $this->load->view('StockGdSparepart/V_Headpdf', $data, true);	
		$html 	= $this->load->view('StockGdSparepart/V_PdfRak', $data, true);	
			
		ob_end_clean();
		$pdf->SetHTMLHeader($head);		
		$pdf->WriteHTML($html);	
		$pdf->Output($filename, 'I');
	}
}