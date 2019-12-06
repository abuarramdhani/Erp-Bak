<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
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
		$this->load->model('RekapLppb/RekapLppb/M_input');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Input';
		$data['Menu'] = 'Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

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
		// 	$hasil = $this->M_input->getSelisih($prmbulan);
		// 	if ($hasil != null) {
		// 		$navbulan[$i]['selisih'] = $hasil['0']['SELISIH'];
		// 	}
		// } 
		// $data['navbulan']= $navbulan;
		// $prmmonth = strtoupper(date("M-Y"));
		// $data['data'] = $this->M_input->getDataRekap($prmmonth);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapLppb/RekapLppb/V_Input');
		$this->load->view('V_Footer',$data);
	}

	public function searchBulan()
	{
        // $bulan = $this->input->post('bulan');
		$io = $this->input->post('id_org');
		$lppbAwl = $this->input->post('lppbAwl');
		$lppbAkh = $this->input->post('lppbAkh');
		$data['io'] = $io;
        // $prmbulan = strtoupper($bulan);
		// echo "<pre>"; print_r($prmbulan); exit();
		
		// if ($bulan != '') {
		// 	$prmmonth = "and to_char(rsh.CREATION_DATE ,'MON-YYYY') = nvl('$prmbulan',to_char(rsh.CREATION_DATE , 'MON-YYYY'))";
		// }else{
		// 	$prmmonth = '';
		// }

		if ($lppbAwl != '' && $lppbAkh != '') {
			$lppb = "AND rsh.receipt_num between '$lppbAwl' and '$lppbAkh'";
		}else if ($lppbAwl != '' && $lppbAkh == '') {
			$lppb = "AND rsh.receipt_num = '$lppbAwl'";
		}else if ($lppbAwl == '' && $lppbAkh != '') {
			$lppb = "AND rsh.receipt_num = '$lppbAkh'";
		}else{
			$lppb = '';
		}


        $data['data'] = $this->M_input->getDataRekap($lppb, $io);
        $this->load->view('RekapLppb/RekapLppb/V_TableInput', $data);

	}

	public function searchRekap($id, $io)
	{
		// echo "wak waww";exit();
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Input';
		$data['Menu'] = 'Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['bulan'] = $id;
        $data['io'] = $io;
        // $prmbulan = strtoupper($bulan);
        // echo "<pre>"; print_r($prmbulan); exit();

		$data['data'] = $this->M_input->getDataRekap2($id, $io);
		// print_r
        // $this->load->view('RekapLppb/RekapLppb/V_TableInput', $data);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapLppb/RekapLppb/V_TblInputRekap',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveKirimQC()
	{
		$number = $this->input->post('number');
		// $itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		// $po = $this->input->post('po');
		$kirimqc = $this->input->post('kirimqc');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');

		// if ($kirimqc != null) {
		// 	$datekirimqc = date("d-m-Y", strtotime($kirimqc));
		// }else{
		// 	exit;
		// }

		$cek = $this->M_input->cekdata($recnum, $io);
		if (count($cek) > 0) {
			$queryupdate = "SET KIRIM_QC = TO_TIMESTAMP('$kirimqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Updatedata($recnum,$queryupdate, $io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$kirimqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Insertdata($recnum,$queryinsert,$ket, $io);
		}
	}

	public function SaveTerimaQC()
	{
		$number = $this->input->post('number');
		// $itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		// $po = $this->input->post('po');
		$terimaqc = $this->input->post('terimaqc');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($terimaqc != null) {
		// 	$dateterimaqc = date("d-m-Y", strtotime($terimaqc));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_input->cekdata($recnum, $io);
		if (count($cek) > 0) {
			$queryupdate = "SET TERIMA_QC = TO_TIMESTAMP('$terimaqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Updatedata($recnum,$queryupdate, $io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$terimaqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Insertdata($recnum,$queryinsert,$ket, $io);
		}
	}
	
	public function SaveKembaliQC()
	{
		$number = $this->input->post('number');
		// $itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		// $po = $this->input->post('po');
		$kembaliqc = $this->input->post('kembaliqc');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($kembaliqc != null) {
		// 	$datekembaliqc = date("d-m-Y", strtotime($kembaliqc));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_input->cekdata($recnum, $io);
		if (count($cek) > 0) {
			$queryupdate = "SET KEMBALI_QC = TO_TIMESTAMP('$kembaliqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Updatedata($recnum,$queryupdate, $io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$kembaliqc', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Insertdata($recnum,$queryinsert,$ket, $io);
		}
	}
	
	
	public function SaveKirimGudang()
	{
		$number = $this->input->post('number');
		// $itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		// $po = $this->input->post('po');
		$kirimgudang = $this->input->post('kirimgudang');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($kirimgudang != null) {
		// 	$datekirimgudang = date("d-m-Y", strtotime($kirimgudang));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_input->cekdata($recnum, $io);
		if (count($cek) > 0) {
			$queryupdate = "SET KIRIM_GUDANG = TO_TIMESTAMP('$kirimgudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Updatedata($recnum,$queryupdate, $io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$kirimgudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Insertdata($recnum,$queryinsert,$ket, $io);
		}
	}
	
	
	public function SaveTerimaGudang()
	{
		$number = $this->input->post('number');
		// $itemid = $this->input->post('itemid');
		$recnum = $this->input->post('recnum');
		// $po = $this->input->post('po');
		$terimagudang = $this->input->post('terimagudang');
		$ket = $this->input->post('ket');
		$io = $this->input->post('io');
		// if ($terimagudang != null) {
		// 	$dateterimagudang = date("d-m-Y", strtotime($terimagudang));
		// }else{
		// 	exit;
		// }
		$cek = $this->M_input->cekdata($recnum, $io);
		if (count($cek) > 0) {
			$queryupdate = "SET TERIMA_GUDANG = TO_TIMESTAMP('$terimagudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Updatedata($recnum,$queryupdate, $io);
		} else {
			$queryinsert = "TO_TIMESTAMP('$terimagudang', 'DD-MM-YYYY HH24:MI:SS')";
			$this->M_input->Insertdata($recnum,$queryinsert,$ket, $io);
		}
	}
}
	
	