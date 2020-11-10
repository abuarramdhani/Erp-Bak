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
			redirect('index');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Arsip SPB/DO';
		$data['Menu'] = 'Arsip SPB/DO';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

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
            $row[] = $val['MULAI_PENGELUARAN'];
            $row[] = $val['SELESAI_PENGELUARAN'];
            $row[] = $val['WAKTU_PENGELUARAN'];
            $row[] = $val['PIC_PENGELUARAN'];
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

		$data['data'] = $this->M_packing->cekPacking($data['nospb']);
		
		$this->load->view('KapasitasGdSparepart/V_ModalArsipColy', $data);
		// echo "<pre>";print_r($cek);exit();
	}

}
