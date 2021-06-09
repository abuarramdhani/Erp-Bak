<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Arsip extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_arsip');
		$this->load->model('KapasitasGdSparepart/M_packing');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Arsip SPB/DO';
		$data['Menu'] = 'Arsip SPB/DO';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$user_arsip = array('P0256', 'K1778', 'B0892', 'J1365');
		if (in_array($user, $user_arsip)) {
			$data['UserMenu'][] = $UserMenu[7]; // menu Arsip SPB
			$data['user_arsip'] = 'user_arsip';
		}else {
			$data['UserMenu'] = $UserMenu;
			$data['user_arsip'] = 'user_lain';
		}
		$data['user'] = $user;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Arsip', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cari_data(){
		// echo "<pre>";print_r($_POST);exit();
		if ($_POST['search']['value'] != '') {
			$sch = strtoupper($_POST['search']['value']);
			$val = $this->M_arsip->getDataSPB2($sch);
			$jml = count($val);
		}else {
			$val = $this->M_arsip->getDataSPB();
			$jml = count($val);
		}
		if (count($val) < 10) {
			$length = count($val);
		}else if ((count($val) - $_POST['start']) < 10)  {
			$sls = count($val) - $_POST['start'];
			$length = $_POST['start'] + $sls;
		}else {
			$length = $_POST['start'] + 10;
		}
		// echo "<pre>";print_r($length);exit();
		$getdata = array();
		for ($i= $_POST['start']; $i < $length ; $i++) { 
			$coly = $this->M_packing->cekPacking($val[$i]['NO_DOKUMEN']);
			$val[$i]['COLY'] = count($coly); 
			$coly2 = $this->M_arsip->cekColy($val[$i]['NO_DOKUMEN']);
			$val[$i]['COLY'] += count($coly2);
			// $tgl 	= $this->M_arsip->dataSPB($val[$i]['NO_DOKUMEN']);
			// $val[$i]['MTRL'] = $tgl[0]['MTRL'];
			array_push($getdata, $val[$i]);
		}

		$data = array();
        $no = $_POST['start'];
        foreach ($getdata as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['TGL_DIBUAT'];
            $row[] = $val['JAM_INPUT'];
            $row[] = $val['JENIS_DOKUMEN'].'<input type="hidden" id="jenis'.$no.'" value="'.$val['JENIS_DOKUMEN'].'">';
            $row[] = $val['NO_DOKUMEN'].'<input type="hidden" id="nospb'.$no.'" value="'.$val['NO_DOKUMEN'].'">';
            $row[] = $val['JUMLAH_ITEM'];
            $row[] = $val['JUMLAH_PCS'];
            $row[] = $val['MULAI_PELAYANAN'];
            $row[] = $val['SELESAI_PELAYANAN'];
            $row[] = $val['WAKTU_PELAYANAN'];
            $row[] = $val['PIC_PELAYAN'];
            $row[] = $val['MULAI_PACKING'];
            $row[] = $val['SELESAI_PACKING'];
            $row[] = $val['WAKTU_PACKING'];
            $row[] = $val['PIC_PACKING'];
            $row[] = $val['URGENT'].' '.$val['BON'];
            $row[] = $val['CANCEL'];
			$row[] = $val['COLY'];
			$row[] = '<button type="button" class="btn btn-md bg-teal" onclick="editColy('.$no.')">Edit Coly</button>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $jml,
                        "recordsFiltered" => $jml,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);

	}

	public function editColy(){
		$data['jenis']	= $this->input->post('jenis');
		$data['nospb'] 	= $this->input->post('no_spb');
		$data['nomor'] 	= $this->input->post('no');
		$data['ket']	= 'arsip';
		$user = $this->session->user;
		$user_arsip = array('P0256', 'K1778', 'B0892', 'J1365');
		if (in_array($user, $user_arsip)) {
			$data['user_arsip'] = 'user_arsip';
		}else {
			$data['user_arsip'] = 'user_lain';
		}

		$coly_baru = $this->M_arsip->cekColy($data['nospb']);
		if (empty($coly_baru)) {
			$data['data'] = $this->M_packing->cekPacking($data['nospb']);
			$this->load->view('KapasitasGdSparepart/V_ModalArsipColy', $data);
		}else {
			$data['data'] = $coly_baru;
			$this->load->view('KapasitasGdSparepart/V_ModalArsipColy2', $data);
		}
		
		// echo "<pre>";print_r($cek);exit();
	}

	public function searchDataArsip(){
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		
		$val = $this->M_arsip->getDataSPB3($tgl_awal, $tgl_akhir);
		$getdata = array();
		for ($i= 0; $i < count($val) ; $i++) { 
			$coly = $this->M_packing->cekPacking($val[$i]['NO_DOKUMEN']);
			$val[$i]['COLY'] = count($coly);
			$coly2 = $this->M_arsip->cekColy($val[$i]['NO_DOKUMEN']);
			$val[$i]['COLY'] += count($coly2);
			array_push($getdata, $val[$i]);
		}
		// echo "<pre>";print_r($val);exit();
		$data['data'] = $getdata;
		$this->load->view('KapasitasGdSparepart/V_TblArsip', $data);
	}

	public function saveColly2(){
		$no_spb = $this->input->post('no_spb');
		$no_colly = $this->input->post('no_colly');
		$berat = $this->input->post('berat');
		$this->M_arsip->saveColly2($no_spb, $no_colly, $berat);
	}

}
