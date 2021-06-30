<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class C_Rekap extends CI_Controller{
		function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('KapasitasGdPusat/M_rekap');

		$this->checkSession();
	}
    
  	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('');
		}
  	}
    
  	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Total';
		$data['Menu'] = 'Rekap';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');

		// KOM
		$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'KOM1-DM'";
		$RkpKOM = $this->M_rekap->getRekap($query1);
		$item_kom = 0;
		for ($p=0; $p < count($RkpKOM) ; $p++) { 
			$item_kom += $RkpKOM[$p]['JUMLAH_ITEM'];
		}
		$data['item_kom'] = $item_kom;

		$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'KOM1-DM'";
		$selesai = $this->M_rekap->getRekap($query2);
		// $data['selesai_kom'] = $selesai;
		// $data['jml_selesai_kom'] = count($data['selesai_kom']);
		$data['selesai_kom'] = $selesai;
		$selesai_kom = 0;
		for ($p=0; $p < count($selesai) ; $p++) { 
			$selesai_kom += $selesai[$p]['JUMLAH_ITEM'];
		}
		$data['jml_selesai_kom'] = $selesai_kom;

		$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
		AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
		AND gudang = 'KOM1-DM'";
		// $data['tanggungan_kom'] = $this->M_rekap->getTanggungan($query3);
		// $data['jml_tanggungan_kom'] = count($data['tanggungan_kom']);
		$tanggungan = $this->M_rekap->getTanggungan($query3);
		$data['tanggungan_kom'] = $tanggungan;
		$tanggungan_kom = 0;
		for ($p=0; $p < count($tanggungan) ; $p++) { 
			$tanggungan_kom += $tanggungan[$p]['JUMLAH_ITEM'];
		}
		$data['jml_tanggungan_kom'] = $tanggungan_kom;

		// PNL
		$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'PNL-DM'";
		$RkpPNL = $this->M_rekap->getRekap($query1);
		$item_pnl = 0;
		for ($p=0; $p < count($RkpPNL) ; $p++) { 
			$item_pnl += $RkpPNL[$p]['JUMLAH_ITEM'];
		}
		$data['item_pnl'] = $item_pnl;

		$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'PNL-DM'";
		$selesai = $this->M_rekap->getRekap($query2);
		$data['selesai_pnl'] = $selesai;
		$selesai_pnl = 0;
		for ($p=0; $p < count($selesai) ; $p++) { 
			$selesai_pnl += $selesai[$p]['JUMLAH_ITEM'];
		}
		$data['jml_selesai_pnl'] = $selesai_pnl;

		$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
		AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
		AND gudang = 'PNL-DM'";
		$tanggungan = $this->M_rekap->getTanggungan($query3);
		$data['tanggungan_pnl'] = $tanggungan;
		$tanggungan_pnl = 0;
		for ($p=0; $p < count($tanggungan) ; $p++) { 
			$tanggungan_pnl += $tanggungan[$p]['JUMLAH_ITEM'];
		}
		$data['jml_tanggungan_pnl'] = $tanggungan_pnl;

		// FG
		$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'FG-DM'";
		$RkpFG = $this->M_rekap->getRekap($query1);
		$item_fg = 0;
		for ($p=0; $p < count($RkpFG) ; $p++) { 
			$item_fg += $RkpFG[$p]['JUMLAH_ITEM'];
		}
		$data['item_fg'] = $item_fg;

		$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'FG-DM'";
		$selesai = $this->M_rekap->getRekap($query2);
		$data['selesai_fg'] = $selesai;
		$selesai_fg = 0;
		for ($p=0; $p < count($selesai) ; $p++) { 
			$selesai_fg += $selesai[$p]['JUMLAH_ITEM'];
		}
		$data['jml_selesai_fg'] = $selesai_fg;

		$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
		AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
		AND gudang = 'FG-DM'";
		$tanggungan = $this->M_rekap->getTanggungan($query3);
		$data['tanggungan_fg'] = $tanggungan;
		$tanggungan = $this->M_rekap->getTanggungan($query3);
		$tanggungan_fg = 0;
		for ($p=0; $p < count($tanggungan) ; $p++) { 
			$tanggungan_fg += $tanggungan[$p]['JUMLAH_ITEM'];
		}
		$data['jml_tanggungan_fg'] = $tanggungan_fg;

		// MAT
		$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'MAT-PM'";
		$RkpMAT = $this->M_rekap->getRekap($query1);
		$item_mat = 0;
		for ($p=0; $p < count($RkpMAT) ; $p++) { 
			$item_mat += $RkpMAT[$p]['JUMLAH_ITEM'];
		}
		$data['item_mat'] = $item_mat;

		$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'MAT-PM'";
		$selesai = $this->M_rekap->getRekap($query2);
		$data['selesai_mat'] = $selesai;
		$selesai_mat = 0;
		for ($p=0; $p < count($selesai) ; $p++) { 
			$selesai_mat += $selesai[$p]['JUMLAH_ITEM'];
		}
		$data['jml_selesai_mat'] = $selesai_mat;

		$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
		AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
		AND gudang = 'MAT-PM'";
		$tanggungan = $this->M_rekap->getTanggungan($query3);
		$data['tanggungan_mat'] = $tanggungan;
		$tanggungan = $this->M_rekap->getTanggungan($query3);
		$tanggungan_mat = 0;
		for ($p=0; $p < count($tanggungan) ; $p++) { 
			$tanggungan_mat += $tanggungan[$p]['JUMLAH_ITEM'];
		}
		$data['jml_tanggungan_mat'] = $tanggungan_mat;

		//pasang ban
		$data['pasangban'] = $this->M_rekap->getPasangBan($date);
		$realisasi = 0;
		for ($p=0; $p < count($data['pasangban']) ; $p++) { 
			$realisasi += $data['pasangban'][$p]['JUMLAH'];
		}
		$data['realisasi'] = $realisasi;
		// echo "<pre>";print_r($data['realisasi']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdPusat/V_Rekap',$data);
		$this->load->view('V_Footer',$data);
	}


	public function searchRekap(){
		$tglAwl = $this->input->post('tglAwl');
		$tglAkh = $this->input->post('tglAkh');

		$tanggal1 	= new DateTime($tglAwl);
		$tanggal2 	= new DateTime($tglAkh);
		$end 		= $tanggal2->modify('+1 day'); 
		$interval 	= new DateInterval('P1D');
		$daterange 	= new DatePeriod($tanggal1, $interval ,$end);
		$i = 0;
		foreach ($daterange as $date) {
			$tanggal[$i] 	= $date->format("d/m/Y");
			$tgl[$i] 		= $date->format("d-M-Y");
			$i++;
		}
		$data['tglAwal'] = $tanggal[0];
		$x = count($tanggal) -1;
		$data['tglAkhir'] = $tanggal[$x];

		$hasil= array();
		for ($a=0; $a < count($tanggal) ; $a++) {
			$date = $tanggal[$a];

			// KOM
			$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'KOM1-DM'";
			$RkpKOM = $this->M_rekap->getRekap($query1);
			$hasil[$a]['tanggal'] = $tgl[$a];
			$item_kom = 0;
			for ($p=0; $p < count($RkpKOM) ; $p++) { 
				$item_kom += $RkpKOM[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['item_kom'] = $item_kom;

			$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'KOM1-DM'";
			$selesai = $this->M_rekap->getRekap($query2);
			// $hasil[$a]['selesai_kom'] = $selesai;
			// $hasil[$a]['jml_selesai_kom'] = count($hasil[$a]['selesai_kom']);
			$hasil[$a]['selesai_kom'] = $selesai;
			$selesai_kom = 0;
			for ($p=0; $p < count($selesai) ; $p++) { 
				$selesai_kom += $selesai[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_selesai_kom'] = $selesai_kom;

			$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
			AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
			AND gudang = 'KOM1-DM'";
			// $hasil[$a]['tanggungan_kom'] = $this->M_rekap->getTanggungan($query3);
			// $hasil[$a]['jml_tanggungan_kom'] = count($hasil[$a]['tanggungan_kom']);
			$tanggungan = $this->M_rekap->getTanggungan($query3);
			$hasil[$a]['tanggungan_kom'] = $tanggungan;
			$tanggungan_kom = 0;
			for ($p=0; $p < count($tanggungan) ; $p++) { 
				$tanggungan_kom += $tanggungan[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_tanggungan_kom'] = $tanggungan_kom;

			// PNL
			$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'PNL-DM'";
			$RkpPNL = $this->M_rekap->getRekap($query1);
			$item_pnl = 0;
			for ($p=0; $p < count($RkpPNL) ; $p++) { 
				$item_pnl += $RkpPNL[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['item_pnl'] = $item_pnl;

			$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'PNL-DM'";
			$selesai = $this->M_rekap->getRekap($query2);
			$hasil[$a]['selesai_pnl'] = $selesai;
			$selesai_pnl = 0;
			for ($p=0; $p < count($selesai) ; $p++) { 
				$selesai_pnl += $selesai[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_selesai_pnl'] = $selesai_pnl;

			$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
			AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
			AND gudang = 'PNL-DM'";
			$tanggungan = $this->M_rekap->getTanggungan($query3);
			$hasil[$a]['tanggungan_pnl'] = $tanggungan;
			$tanggungan_pnl = 0;
			for ($p=0; $p < count($tanggungan) ; $p++) { 
				$tanggungan_pnl += $tanggungan[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_tanggungan_pnl'] = $tanggungan_pnl;

			// FG
			$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'FG-DM'";
			$RkpFG = $this->M_rekap->getRekap($query1);
			$item_fg = 0;
			for ($p=0; $p < count($RkpFG) ; $p++) { 
				$item_fg += $RkpFG[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['item_fg'] = $item_fg;

			$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'FG-DM'";
			$selesai = $this->M_rekap->getRekap($query2);
			$hasil[$a]['selesai_fg'] = $selesai;
			$selesai_fg = 0;
			for ($p=0; $p < count($selesai) ; $p++) { 
				$selesai_fg += $selesai[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_selesai_fg'] = $selesai_fg;

			$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
			AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
			AND gudang = 'FG-DM'";
			$tanggungan = $this->M_rekap->getTanggungan($query3);
			$hasil[$a]['tanggungan_fg'] = $tanggungan;
			$tanggungan_fg = 0;
			for ($p=0; $p < count($tanggungan) ; $p++) { 
				$tanggungan_fg += $tanggungan[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_tanggungan_fg'] = $tanggungan_fg;

			// MAT
			$query1 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date' AND gudang = 'MAT-PM'";
			$RkpMAT = $this->M_rekap->getRekap($query1);
			$item_mat = 0;
			for ($p=0; $p < count($RkpMAT) ; $p++) { 
				$item_mat += $RkpMAT[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['item_mat'] = $item_mat;

			$query2 = "WHERE TO_CHAR (selesai, 'DD/MM/YYYY') = '$date' AND gudang = 'MAT-PM'";
			$selesai = $this->M_rekap->getRekap($query2);
			$hasil[$a]['selesai_mat'] = $selesai;
			$selesai_mat = 0;
			for ($p=0; $p < count($selesai) ; $p++) { 
				$selesai_mat += $selesai[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_selesai_mat'] = $selesai_mat;

			$query3 = "WHERE TO_CHAR (creation_date, 'DD/MM/YYYY') = '$date'
			AND (TO_CHAR (selesai, 'DD/MM/YYYY') > '$date' OR selesai IS NULL)
			AND gudang = 'MAT-PM'";
			$tanggungan = $this->M_rekap->getTanggungan($query3);
			$hasil[$a]['tanggungan_mat'] = $tanggungan;
			$tanggungan_mat = 0;
			for ($p=0; $p < count($tanggungan) ; $p++) { 
				$tanggungan_mat += $tanggungan[$p]['JUMLAH_ITEM'];
			}
			$hasil[$a]['jml_tanggungan_mat'] = $tanggungan_mat;

			//pasang ban
			$hasil[$a]['pasangban'] = $this->M_rekap->getPasangBan($date);
			$realisasi = 0;
			for ($p=0; $p < count($hasil[$a]['pasangban']) ; $p++) { 
				$realisasi += $hasil[$a]['pasangban'][$p]['JUMLAH'];
			}
			$hasil[$a]['realisasi'] = $realisasi;
		}
		$data['hasil'] = $hasil;
		// echo "<pre>";print_r($hasil);exit();

		$this->load->view('KapasitasGdPusat/V_SearchRekap', $data);
	}
}

?>