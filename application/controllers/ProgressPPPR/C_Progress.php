<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Progress extends CI_Controller {

	function __construct()
	{
		parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->model('ProgressPPPR/M_progress');
		
	}

	public function index()
	{
        $this->load->view('ProgressPPPR/V_Head');
        $this->load->view('ProgressPPPR/V_Progress');
        $this->load->view('ProgressPPPR/V_Foot');
    }

    public function searchItem()
    {
        $q = $_GET['q'];
        $data = $this->M_progress->searchItem(strtoupper($q));

        echo json_encode($data);
    }

    public function searchRequester()
    {
        $r = $_GET['r'];
        $data = $this->M_progress->searchRequester(strtoupper($r));

        echo json_encode($data);
    }

    public function getReport()
    {
        $requester = $_POST['requester'];
        $item = $_POST['item'];
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        $data['report'] = $this->M_progress->getReport($requester,$item,$date1,$date2);
        echo $this->load->view('ProgressPPPR/V_TableReport',$data,true);
        // echo json_encode($data);
    }

}

