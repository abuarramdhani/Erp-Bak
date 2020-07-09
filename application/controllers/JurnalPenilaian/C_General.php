<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_General extends CI_Controller {

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
		$this->load->model('JurnalPenilaian/M_general');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function cariSeksi()
	{
		$keywordSeksi		= 	strtoupper($this->input->get('term'));
		
		$resultSeksi 		= 	$this->M_general->ambilDaftarSeksi($keywordSeksi);
		echo json_encode($resultSeksi);
	}

//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	


}
