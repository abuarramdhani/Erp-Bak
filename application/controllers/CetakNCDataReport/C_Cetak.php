<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cetak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		// $this->load->model('CetakNCDataReport/M_cetak');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		// $this->checkSession();
		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Cetak NC Data Report';
		$data['Menu'] = 'Cetak NC Data Report';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakNCDataReport/V_Cetak',$data);
		$this->load->view('V_Footer',$data);
    }
    
    public function CetakData(){
        // echo "<pre>";print_r($_FILES);exit();
        if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
        // $filename = "img/".$_FILES['img_file']['name'];
        $filename = "img/tmk.png";
        $temp_name = $_FILES['img_file']['tmp_name'];
        // Check if file already exists
        if (file_exists($filename)) {
            move_uploaded_file($temp_name,$filename);
        }else{
            move_uploaded_file($temp_name,$filename);
        }

        $tampung = array();
        $a = 0;
		for ($i=0; $i < count($_FILES['txt_file']['name']) ; $i++) { 
            $tampung[0]['toolno'] 		= $this->input->post('toolno');
            $tampung[0]['partname'] 	= $this->input->post('partname');
            $tampung[0]['programmer'] 	= $this->input->post('programmer');
            $tampung[0]['shift'] 		= $this->input->post('shift');
            $tampung[0]['date'] 		= date('d F Y');
			$file=  $_FILES['txt_file']['tmp_name'][$i];  
			$f =fopen($file,'r');
			$title = explode(".", $_FILES['txt_file']['name'][$i]);
			$title = $title[0];
			while(($fileop=fgetcsv($f,1000,","))!=false){
				$kata2 = substr($fileop[0],0,2);
				if ($kata2 == ' T') {
					$tampung[$a]['title'][] = $title;
					$tampung[$a]['T'][] = $fileop[0];
				}elseif ($kata2 == ' (') {
					$kurung = substr($fileop[0],3);
					$kurung = substr($kurung,0,-3);
					$tampung[$a]['toolname'][] = $kurung;
				}
			} 
			$a++;
		}
		
		$data['data'] = $tampung;
		// echo "<pre>";print_r($tampung);exit();

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4', 0, '', 5, 5, 5, 5, 0, 0);
		$filename 	= 'ImportToolRoom.pdf';
        $html = $this->load->view('CetakNCDataReport/V_PdfCetak', $data, true);
        ob_end_clean();
        $pdf->WriteHTML($html);			
        $pdf->Output($filename, 'I');
    }
}