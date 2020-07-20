<?php
/* 
    about controller name
    > Rest Api server for Blanko Evaluasi App
*/

defined('BASEPATH') or exit('you cannot enter here');

class C_Api extends CI_Controller {
    function __construct(){
        parent::__construct();

        // error in win xp
        // $this->checkSession();
        
        $this->load->model('BlankoEvaluasi/M_blankoevaluasi');
    }

	private function checkSession() {
		if(!$this->session->userdata('is_logged')) {
            echo json_encode(array(
                'error' =>  true,
                'message' => 'Login first to using this api'
            ));
            die;
		}
    }

    private function successResponse($message = 'Sukses', $data) {
        echo json_encode([
            'error' => false,
            'message' => $message,
            'data' => $data
        ]);
    }

    private function errorResponse($message = "Gagal mendapatakan data") {
        echo json_encode([
            'error' => true,
            'message' => $message,
            'data' => []
        ]);
    }
    
    function index() {
        echo json_encode(array(
            'message' => 'How to using this api',
            'list' => [
                [
                    'name' => 'Worker',
                    'about' => 'Get Name & Noind worker',
                    'examples' => '/BlankoEvaluasi/api/workers?keyword=workername'
                ]
            ]
        ));
    }

    function workers() {
        $keyword = strtoupper($this->input->get('keyword')); // john
        $jabatan = $this->input->get('position'); // staff / nonstaff
        $filterSie = $this->input->get('filterSie'); // 1 / 0
        
        if($jabatan == 'staff') {
            $withCode = ['G', 'J']; // kode jabatan staff
        } else if($jabatan == 'nonstaff') {
            $withCode = ['H', 'T', 'K', 'P']; // kode jabatan nonstaff & os
        } else {
            $withCode = null;
        }

        if(!$keyword) return $this->errorResponse('Parameter failed');

        $workersData = $this->M_blankoevaluasi->getWorkers($keyword, $withCode, $filterSie);
        if(!$workersData && !count($workersData)) return $this->successResponse('Data pekerja tidak ditemukan di database', $workersData);
        $found = count($workersData);

        return $this->successResponse("Success, found: {$found} worker", $workersData);
    }

    function workerInformation() {
        $noind = strtoupper($this->input->get('noind'));

        if(!$noind) return $this->errorResponse('Parameter failed');

        $workerInformation = $this->M_blankoevaluasi->getWorkerInformation($noind);
        if(!$workerInformation) return $this->errorResponse('Data pekerja tidak ditemukan di database');

        return $this->successResponse("Success, worker name: {$workerInformation->nama}", $workerInformation);
    }

    function TIMS() {
        $noind = strtoupper($this->input->get('noind'));
        $awal = $this->input->get('from');
        $akhir =  $this->input->get('to');
        $kd_jabatan =  $this->input->get('kd_jabatan');

        if(!$noind || !$awal || !$akhir || !$kd_jabatan) return $this->errorResponse('Parameter failed');

        $awal = date('Y-m-d', strtotime($awal));
        $akhir = date('Y-m-d', strtotime($akhir));

        $getTIMS = $this->M_blankoevaluasi->getTIMS($noind, $awal, $akhir);
        return $this->successResponse('success', $getTIMS);
    }

    function calculationTIMS() {
        $noind = strtoupper($this->input->get('noind'));
        $awal = $this->input->get('from');
        $akhir =  $this->input->get('to');
        $kd_jabatan =  $this->input->get('kd_jabatan');

        if(!$noind || !$awal || !$akhir || !$kd_jabatan) return $this->errorResponse('Parameter failed');

        $awal = date('Y-m-d', strtotime($awal));
        $akhir = date('Y-m-d', strtotime($akhir));

        $staff = ['14', '16'];
        $nonstaff = ['15', '17'];
        $os = ['18'];

        $position = null;
        if(in_array($kd_jabatan, $staff)) {
            $position = 'staff';
        } else if(in_array($kd_jabatan, $nonstaff)) {
            $position = 'nonstaff';
        } else {
            $position = 'os';
        }

        $getTIMS = $this->M_blankoevaluasi->calculationTIMS($noind, $awal, $akhir, $position);
        
        return $this->successResponse('Sukses', array(
            'noind' => $noind,
            'periode' => "$awal - $akhir",
            'passed' => $getTIMS
        ));
    }

}