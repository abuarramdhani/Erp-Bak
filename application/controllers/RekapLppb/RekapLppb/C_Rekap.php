<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Rekap extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('RekapLppb/RekapLppb/M_rekap');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

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
			$this->load->view('RekapLppb/RekapLppb/V_Dashboard',$data);
			$this->load->view('V_Footer',$data);

        }
        
    public function Rekap(){

        $this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Rekap';
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['bulan'] = date('M-Y');
		// $month = strtoupper(date("M"));
		// $year = strtoupper(date("Y"));
		// $data['monthnow'] = ".$month.";

		// $navbulan = array
		// (
		// 		array("1","bln" => "DEC","mon" => "DEC-$year","selisih" => ""),
		// 		array("2","bln" => "NOP","mon" => "NOP-$year","selisih" => ""),
		// 		array("3","bln" => "OCT","mon" => "OCT-$year","selisih" => ""),
		// 		array("4","bln" => "SEP","mon" => "SEP-$year","selisih" => ""),
		// 		array("5","bln" => "AUG","mon" => "AUG-$year","selisih" => ""),
		// 		array("6","bln" => "JUL","mon" => "JUL-$year","selisih" => ""),
		// 		array("7","bln" => "JUN","mon" => "JUN-$year","selisih" => ""),
		// 		array("8","bln" => "MAY","mon" => "MAY-$year","selisih" => ""),
		// 		array("9","bln" => "APR","mon" => "APR-$year","selisih" => ""),
		// 		array("10","bln" => "MAR","mon" => "MAR-$year","selisih" => ""),
		// 		array("11","bln" => "FEB","mon" => "FEB-$year","selisih" => ""),
		// 		array("12","bln" => "JAN","mon" => "JAN-$year","selisih" => "")
		// 		);

		// for ($i=0; $i <count($navbulan) ; $i++) { 
		// 	$prmbulan = $navbulan[$i]['mon'];
		// 	$hasil = $this->M_rekap->getSelisih($prmbulan);
		// 	if ($hasil != null) {
		// 		$navbulan[$i]['selisih'] = $hasil['0']['SELISIH'];
		// 	}
		// } 
		// $data['navbulan']= $navbulan;
		// $prmmonth = strtoupper(date("M-Y"));
		// $data['data'] = $this->M_rekap->getDataRekap($prmmonth);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('RekapLppb/RekapLppb/V_perbaikan',$data);
        $this->load->view('V_Footer',$data);

	}
	
	// public function SearchData()
	// {
	// 	$bulan = $this->input->get('bulan');
	// 	$data['data'] = $this->M_rekap->getDataRekap($bulan);
	// 	$this->load->view('RekapLppb/RekapLppb/V_Result', $data);
	// }

	public function schRekapLppb(){
		$bulan = $this->input->post('bulan');
		$io = $this->input->post('id_org');
		$prmmonth = strtoupper($bulan);
		$data['data'] = $this->M_rekap->getDataRekap($prmmonth, $io);
		// echo "<pre>"; print_r($bulan);exit();
		$this->load->view('RekapLppb/RekapLppb/V_TblRekaperbaikan', $data);
	}

	// public function SaveKirimQC()
	// {
	// 	$number = $this->input->post('number');
	// 	$itemid = $this->input->post('itemid');
	// 	$recnum = $this->input->post('recnum');
	// 	$po = $this->input->post('po');
	// 	$kirimqc = $this->input->post('kirimqc');
	// 	$ket = $this->input->post('ket');

	// 	if ($kirimqc != null) {
	// 		$datekirimqc = date("d-m-Y", strtotime($kirimqc));
	// 	}else{
	// 		exit;
	// 	}

	// 	$cek = $this->M_rekap->cekdata($itemid,$recnum,$po);
	// 	if (count($cek) > 0) {
	// 		$queryupdate = "SET KIRIM_QC = TO_TIMESTAMP('$datekirimqc', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate);
	// 	} else {
	// 		$queryinsert = "TO_TIMESTAMP('$datekirimqc', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket);
	// 	}
	// }

	// public function SaveTerimaQC()
	// {
	// 	$number = $this->input->post('number');
	// 	$itemid = $this->input->post('itemid');
	// 	$recnum = $this->input->post('recnum');
	// 	$po = $this->input->post('po');
	// 	$terimaqc = $this->input->post('terimaqc');
	// 	$ket = $this->input->post('ket');
	// 	if ($terimaqc != null) {
	// 		$dateterimaqc = date("d-m-Y", strtotime($terimaqc));
	// 	}else{
	// 		exit;
	// 	}
	// 	$cek = $this->M_rekap->cekdata($itemid,$recnum,$po);
	// 	if (count($cek) > 0) {
	// 		$queryupdate = "SET TERIMA_QC = TO_TIMESTAMP('$dateterimaqc', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate);
	// 	} else {
	// 		$queryinsert = "TO_TIMESTAMP('$datekirimqc', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket);
	// 	}
	// }
	
	// public function SaveKembaliQC()
	// {
	// 	$number = $this->input->post('number');
	// 	$itemid = $this->input->post('itemid');
	// 	$recnum = $this->input->post('recnum');
	// 	$po = $this->input->post('po');
	// 	$kembaliqc = $this->input->post('kembaliqc');
	// 	$ket = $this->input->post('ket');
	// 	if ($kembaliqc != null) {
	// 		$datekembaliqc = date("d-m-Y", strtotime($kembaliqc));
	// 	}else{
	// 		exit;
	// 	}
	// 	$cek = $this->M_rekap->cekdata($itemid,$recnum,$po);
	// 	if (count($cek) > 0) {
	// 		$queryupdate = "SET KEMBALI_QC = TO_TIMESTAMP('$datekembaliqc', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate);
	// 	} else {
	// 		$queryinsert = "TO_TIMESTAMP('$datekembaliqc', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket);
	// 	}
	// }
	
	
	// public function SaveKirimGudang()
	// {
	// 	$number = $this->input->post('number');
	// 	$itemid = $this->input->post('itemid');
	// 	$recnum = $this->input->post('recnum');
	// 	$po = $this->input->post('po');
	// 	$kirimgudang = $this->input->post('kirimgudang');
	// 	$ket = $this->input->post('ket');
	// 	if ($kirimgudang != null) {
	// 		$datekirimgudang = date("d-m-Y", strtotime($kirimgudang));
	// 	}else{
	// 		exit;
	// 	}
	// 	$cek = $this->M_rekap->cekdata($itemid,$recnum,$po);
	// 	if (count($cek) > 0) {
	// 		$queryupdate = "SET KIRIM_GUDANG = TO_TIMESTAMP('$datekirimgudang', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate);
	// 	} else {
	// 		$queryinsert = "TO_TIMESTAMP('$datekirimgudang', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket);
	// 	}
	// }
	
	
	// public function SaveTerimaGudang()
	// {
	// 	$number = $this->input->post('number');
	// 	$itemid = $this->input->post('itemid');
	// 	$recnum = $this->input->post('recnum');
	// 	$po = $this->input->post('po');
	// 	$terimagudang = $this->input->post('terimagudang');
	// 	$ket = $this->input->post('ket');
	// 	if ($terimagudang != null) {
	// 		$dateterimagudang = date("d-m-Y", strtotime($terimagudang));
	// 	}else{
	// 		exit;
	// 	}
	// 	$cek = $this->M_rekap->cekdata($itemid,$recnum,$po);
	// 	if (count($cek) > 0) {
	// 		$queryupdate = "SET TERIMA_GUDANG = TO_TIMESTAMP('$dateterimagudang', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate);
	// 	} else {
	// 		$queryinsert = "TO_TIMESTAMP('$dateterimagudang', 'DD-MM-YYYY')";
	// 		$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket);
	// 	}
	// }

	public function SaveKirimQC()
	{
		$number = $this->input->post('number');
		$itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		$po = $this->input->post('po');
		$datekirimqc = $this->input->post('kirimqc');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');

		// if ($kirimqc != null) {
		// 	$datekirimqc = date("d-m-Y H:i:s", strtotime($kirimqc));
		// }else{
		// 	exit;
		// }

		$cek = $this->M_rekap->cekdata($itemid,$recnum,$po,$io);
		if (count($cek) > 0) {
			$queryupdate = "SET KIRIM_QC = TO_TIMESTAMP('$datekirimqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate,$io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$datekirimqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket,$io);
		}
	}

	public function SaveTerimaQC()
	{
		$number = $this->input->post('number');
		$itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		$po = $this->input->post('po');
		$terimaqc = $this->input->post('terimaqc');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($terimaqc != null) {
		// 	$dateterimaqc = date("d-m-Y H:i:s", strtotime($terimaqc));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_rekap->cekdata($itemid,$recnum,$po,$io);
		if (count($cek) > 0) {
			$queryupdate = "SET TERIMA_QC = TO_TIMESTAMP('$terimaqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate,$io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$terimaqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket,$io);
		}
	}
	
	public function SaveKembaliQC()
	{
		$number = $this->input->post('number');
		$itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		$po = $this->input->post('po');
		$kembaliqc = $this->input->post('kembaliqc');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($kembaliqc != null) {
		// 	$datekembaliqc = date("d-m-Y H:i:s", strtotime($kembaliqc));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_rekap->cekdata($itemid,$recnum,$po,$io);
		if (count($cek) > 0) {
			$queryupdate = "SET KEMBALI_QC = TO_TIMESTAMP('$kembaliqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate,$io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$kembaliqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket,$io);
		}
	}
	
	
	public function SaveKirimGudang()
	{
		$number = $this->input->post('number');
		$itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		$po = $this->input->post('po');
		$kirimgudang = $this->input->post('kirimgudang');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($kirimgudang != null) {
		// 	$datekirimgudang = date("d-m-Y H:i:s", strtotime($kirimgudang));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_rekap->cekdata($itemid,$recnum,$po,$io);
		if (count($cek) > 0) {
			$queryupdate = "SET KIRIM_GUDANG = TO_TIMESTAMP('$kirimgudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate,$io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$kirimgudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket,$io);
		}
	}
	
	
	public function SaveTerimaGudang()
	{
		$number = $this->input->post('number');
		$itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		$po = $this->input->post('po');
		$terimagudang = $this->input->post('terimagudang');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($terimagudang != null) {
		// 	$dateterimagudang = date("d-m-Y H:i:s", strtotime($terimagudang));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_rekap->cekdata($itemid,$recnum,$po,$io);
		if (count($cek) > 0) {
			$queryupdate = "SET TERIMA_GUDANG = TO_TIMESTAMP('$terimagudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Updatedata($itemid,$recnum,$po,$queryupdate,$io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$terimagudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_rekap->Insertdata($itemid,$recnum,$po,$queryinsert,$ket,$io);
		}
	}


}