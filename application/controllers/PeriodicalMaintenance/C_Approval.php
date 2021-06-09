<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Approval extends CI_Controller
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
		$this->load->model('PeriodicalMaintenance/M_approval');
		$this->load->model('PeriodicalMaintenance/M_monitoring');


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
        $this->checkSession();
		$user_id = $this->session->userid;
		$employee_code = $this->session->user;

		$data['Title'] = 'Approval Periodical Maintenance';
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

		$data['approval_staffmtn'] = $this->M_approval->getApprovalMPA($employee_code, "1");
        $data['approval_seksi'] = $this->M_approval->getApprovalMPA($employee_code, "2");
		$data['approver2'] = $this->M_approval->getNoInduk();
		
		// echo"<pre>"; print_r($data['approver2']); exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Approval', $data);
        $this->load->view('V_Footer', $data);
        
    }
    

    public function updateApproval1()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
        $employee_code = $this->session->user;
        
        $nodoc 	= $this->input->post('nodoc');
		// $req2 = $this->input->post('req2'); 
		// date_default_timezone_set('Asia/Jakarta');
		// $currentdate = date("Y-m-d H:i:s");
		// echo $currentdate;exit;     

		$this->M_approval->updateApproval1($nodoc, $employee_code);
    }
    
    public function updateApproval2()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
        $employee_code = $this->session->user;
        
        $nodoc 	= $this->input->post('nodoc');

		$this->M_approval->updateApproval2($nodoc, $employee_code);
	}

	public function updateApprovalSeksi()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
        $employee_code = $this->session->user;
        
        $nodoc 	= $this->input->post('nodoc');
		$req2 = $this->input->post('req2'); 
		// date_default_timezone_set('Asia/Jakarta');
		// $currentdate = date("Y-m-d H:i:s");
		// echo $currentdate;exit;     

		$this->M_approval->updateApprovalSeksi($nodoc, $req2);
    }

	public function printForm($nodoc)
	{
		// $nodoc 	= $id;
		
		$data['totalDurasi'] = $this->M_monitoring->getSumDurasi($nodoc);
		$data['sparepart'] = $this->M_monitoring->getDataSparepart($nodoc);
		$data['header'] = $this->M_monitoring->getDataHeader($nodoc);

		$datapdf = $this->M_monitoring->getDataMon($nodoc);

		$data['gambar'] = $this->M_monitoring->getDataGambar($datapdf[0]['NAMA_MESIN']);

		// echo "<pre>"; 
		// print_r($datapdf); exit();

		$array_Resource = array();
		for ($i = 0; $i < sizeof($datapdf); $i++) {
			if ($datapdf[$i]['KONDISI_MESIN'] == null) {
				$alter[$i] = '';
			} else {
				$alter[$i] = $datapdf[$i]['KONDISI_MESIN'];
			}
			$array_Resource['KONDISI_MESIN'][$alter[$i]][$i] = $datapdf[$i]['SUB_HEADER'];
			$array_Resource['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']][$i] = $datapdf[$i]['SUB_HEADER'];
		}

		$array_pdf = array();
		$i = 0;
		foreach ($datapdf as $pdf) {
			$array_pdf[$i]['TYPE_MESIN'] = $pdf['TYPE_MESIN'];
			$array_pdf[$i]['PERIODE_CHECK'] = $pdf['PERIODE_CHECK'];
			$array_pdf[$i]['NAMA_MESIN'] = $pdf['NAMA_MESIN'];
			$array_pdf[$i]['KONDISI_MESIN'] = $pdf['KONDISI_MESIN'];
			$array_pdf[$i]['HEADER_MESIN'] = $pdf['HEADER_MESIN'];
			$array_pdf[$i]['SUB_HEADER'] = $pdf['SUB_HEADER'];
			$array_pdf[$i]['STANDAR'] = $pdf['STANDAR'];
			$array_pdf[$i]['PERIODE'] = $pdf['PERIODE'];
			$array_pdf[$i]['DURASI'] = $pdf['DURASI'];
			$array_pdf[$i]['KONDISI'] = $pdf['KONDISI'];
			$array_pdf[$i]['CATATAN'] = $pdf['CATATAN'];

			$array_pdf[$i]['SCHEDULE_DATE'] = $pdf['SCHEDULE_DATE'];
			$array_pdf[$i]['ACTUAL_DATE'] = $pdf['ACTUAL_DATE'];
			$array_pdf[$i]['STATUS'] = $pdf['STATUS'];
			$array_pdf[$i]['JAM_MULAI'] = $pdf['JAM_MULAI'];
			$array_pdf[$i]['JAM_SELESAI'] = $pdf['JAM_SELESAI'];
			$array_pdf[$i]['PELAKSANA'] = $pdf['PELAKSANA'];

			$array_pdf[$i]['REQUEST_BY'] = $pdf['REQUEST_BY'];
			$array_pdf[$i]['REQUEST_BY_NAME'] = $this->M_approval->getNama( $pdf['REQUEST_BY']);
			$array_pdf[$i]['CREATION_DATE'] = $pdf['CREATION_DATE'];
			$array_pdf[$i]['REQUEST_TO'] = $pdf['REQUEST_TO'];
			$array_pdf[$i]['REQUEST_TO_2'] = $pdf['REQUEST_TO_2'];
			$array_pdf[$i]['APPROVED_BY'] = $pdf['APPROVED_BY'];
			$array_pdf[$i]['APPROVED_BY_NAME'] = $this->M_approval->getNama( $pdf['APPROVED_BY']);
			$array_pdf[$i]['APPROVED_DATE'] = $pdf['APPROVED_DATE'];
			$array_pdf[$i]['APPROVED_BY_2'] = $pdf['APPROVED_BY_2'];
			$array_pdf[$i]['APPROVED_BY_2_NAME'] = $this->M_approval->getNama( $pdf['APPROVED_BY_2']);
			$array_pdf[$i]['APPROVED_DATE_2'] = $pdf['APPROVED_DATE_2'];
			$array_pdf[$i]['DOCUMENT_NUMBER'] = $pdf['DOCUMENT_NUMBER'];

			$array_pdf[$i]['CATATAN_TEMUAN'] = $pdf['CATATAN_TEMUAN'];

			$i++;
		}

		$data['arrayR'] = $array_Resource;
		$data['datapdf'] = $array_pdf;

		// echo "<pre>"; 
		// print_r($data['datapdf']); exit();

		ob_start();
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();

		$margin_left = 3; // sizes are defines in millimetres
		$margin_right = 3;
		$margin_top = 40;
		$margin_bottom = 100;
		$header = 3;
		$footer = 3;
		$orientation = "P"; // can be P (Portrait) or L (Landscape)
		$pdf=new mPDF('utf-8',array(210,330), 0, '', $margin_left, $margin_right, $margin_top, $margin_bottom, $header, $footer, $orientation);

		$tglNama = date("d/m/Y-H:i:s");
		$filename = 'Periodical_Maintenance_' . $tglNama . '.pdf';
		$head = $this->load->view('PeriodicalMaintenance/V_CetakanHead', $data, true);
		$html = $this->load->view('PeriodicalMaintenance/V_Cetakan_DetailBackup', $data, true);
		$foot = $this->load->view('PeriodicalMaintenance/V_CetakanFoot', $data, true);
		$html2 = $this->load->view('PeriodicalMaintenance/V_Cetakan_Lampiran', $data, true);

		ob_end_clean();
		$pdf->shrink_tables_to_fit = 1;
		$pdf->use_kwt = true; 
		$pdf->setHTMLHeader($head);
		$pdf->setHTMLFooter($foot);
		$pdf->WriteHTML($html);
		if(sizeof($data['gambar'])>0){
			$pdf->WriteHTML($html2);
		}

		$pdf->Output($filename, 'I');
	}

}
