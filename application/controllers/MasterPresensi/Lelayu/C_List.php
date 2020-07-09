<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class C_List extends CI_Controller
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
    $this->load->library('Log_Activity');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPresensi/Lelayu/M_lelayu');
    ini_set('date.timezone', 'Asia/Jakarta');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('');
    }
  }

  public function index()
  {
    $user = $this->session->username;
    $user_id = $this->session->userid;

    $data['Title'] = 'List Data Lelayu';
    $data['Menu'] = 'Master Presensi';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['data'] = $this->M_lelayu->getDataList();
    $data['namaPekerja'] = $this->M_lelayu->getPekerja();
    $data['tertanda'] = $this->M_lelayu->getTertandaKasbon();

    $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/Lelayu/ListData/V_list_data');
		$this->load->view('V_Footer',$data);
  }

  public function hapus($id)
  {
    $this->M_lelayu->delete($id);
    $this->M_lelayu->deletePekerjaPotong($id);

    $aksi = 'Lelayu';
    $detail = 'Menghapus Data Lelayu dengan id_lelayu '.$id;

    $this->log_activity->activity_log($aksi, $detail);

		redirect(base_url('MasterPresensi/Lelayu/ListData'));
  }

  public function detail()
  {
    $id = $_POST['lelayu_id'];
    $data = $this->M_lelayu->getDetailList($id);
    echo json_encode($data);
  }

  public function exportPDF($id)
  {
    $aksi = 'Lelayu';
    $detail = 'Export PDF Data Lelayu dengan id_lelayu '.$id;

    $this->log_activity->activity_log($aksi, $detail);

    $date = date('d-m-Y');
    $data['today'] = date("d M Y",strtotime($date));
    $today = date('d-m-Y H:i:s');
    $noind = $this->session->user;
    $nama = $this->M_lelayu->namaUser($noind);
    $data['user_name'] = $this->M_lelayu->getAtasan();
    $data['pekerjaTerpotong'] = $this->M_lelayu->getPekerjaTerpotong($id);
    $dta = $data['pekerjaTerpotong'];

    ///// downloadpdf

    $j = 0;
		$k = 0;
		$l = 0;
		for ($i=0; $i < count($dta) ; $i++) {
			if($k-1 < 0){
				$ka=0;
			}else{
				$ka= $k-1;
			}

			if($dta[$i]['nominal'] == $dta[$ka]['nominal']){
				$newArr[$j][$i]['lelayu_id'] = $dta[$i]['lelayu_id'];
        $newArr[$j][$i]['noind'] = $dta[$i]['noind'];
        $newArr[$j][$i]['nominal'] = $dta[$i]['nominal'];
        $newArr[$j][$i]['nama'] = $dta[$i]['nama'];
				$k++;
			}elseif($dta[$i] != $dta[$ka]){
				$k++;
				$j++;
        $newArr[$j][$i]['lelayu_id'] = $dta[$i]['lelayu_id'];
        $newArr[$j][$i]['noind'] = $dta[$i]['noind'];
        $newArr[$j][$i]['nominal'] = $dta[$i]['nominal'];
        $newArr[$j][$i]['nama'] = $dta[$i]['nama'];
			}
		}

    $data['newArr'] = $newArr;
    $potong = $newArr;
    $pekerja = $this->M_lelayu->getDataPDF($id);

    $tanggalLelayu = $pekerja[0]['tgl_lelayu'];
    $tanggalLelayu = date("d M Y",strtotime($tanggalLelayu));
    $jenkel = trim($pekerja[0]['jk']);
			 if ($jenkel == 'L') {
				 	$jk = 'Bp. ';
				}elseif ($jenkel == 'P') {
					$jk = 'Ibu. ';
				}

    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8','A4-P', 8, 5, 10, 10, 30, 15, 8, 20);
    $filename = 'Pekerja Terpotong Lelayu'.$date.'.pdf';

    $html = $this->load->view('MasterPresensi/Lelayu/ListData/V_PDF',$data,true);
    $pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%"><h2><b>Data Pekerja Yang Terkena Potongan SPSI</b></h2></td>
						<td><h4>Dicetak Oleh '.$noind.' - '.$nama.' pada Tanggal '.$today.'</h4></td>
					</tr>
          <tr>
            <td colspan="2"><h4>Lelayu dari : '.$jk.ucwords(mb_strtolower($pekerja[0]['nama'])).'('.$pekerja[0]['noind'].')</h4></td>
          </tr>
					<tr>
						<td colspan="2"><h4>Seksi : '.ucwords(mb_strtolower($pekerja[0]['seksi'])).'</h4></td>
					</tr>
					<tr>
						<td colspan="2"><h4> Tanggal Lelayu : '.$tanggalLelayu.'</h4></td>
					</tr>
				</table>
			');

    $pdf->WriteHTML($html, 2);
    $pdf->setTitle($filename);
    $pdf->Output($filename, 'I');
  }

  public function exportKasBon($id)
  {
    $aksi = 'Lelayu';
    $detail = 'Mengexport Kasbon Lelayu dengan id_lelayu '.$id;

    $this->log_activity->activity_log($aksi, $detail);

    $data['data'] = $this->M_lelayu->getDataList();
    $data['date'] = date('d-m-Y');
    $date = $data['date'];
    $data['kasbon'] = $this->M_lelayu->getDataPDF($id);
    $nama = $data['kasbon'];
    $getKsYogya = $this->M_lelayu->getKsYogya();
    $newArray = array();
    foreach ($getKsYogya as $ke) {
      $newArray[] = $ke['section_code'];
    }
    $data['kodesie_yogya'] = $newArray;

    $data['tertanda'] = $_POST['Penerima_kasbon'];
    $data['menyetujui'] = $_POST['Menyetujui_kasbon'];

    $total = $nama[0]['uang_duka_perusahaan'] + $nama[0]['kain_kafan_perusahaan'];
    $total1 = $nama[0]['spsi_nonmanajerial_nominal']+$nama[0]['spsi_spv_nominal']+$nama[0]['spsi_kasie_nominal']+$nama[0]['spsi_askanit_nominal'];
    $data['terbilang_total'] = $this->terbilang($total)." Rupiah";
    $data['terbilang_total1'] = $this->terbilang($total1)." Rupiah";

    $data['sumAA'] = $this->M_lelayu->getPkjByLoc(false, $id);
    $data['sumAB'] = $this->M_lelayu->getPkjByLoc("04", $id);
    $data['sumAC'] = $this->M_lelayu->getPkjByLoc("02", $id);
    $data['sumTotal'] = $data['sumAA'] + $data['sumAB'] + $data['sumAC'];

    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8','A4-P', 8, 5, 10, 10, 30, 15, 8, 20);
    $filename = 'KAS_BON_LELAYU'.' '.$date.'.pdf';

    $html = $this->load->view('MasterPresensi/Lelayu/ListData/V_kas_bon',$data,true);
    $pdf->WriteHTML($html, 2);
    $pdf->setTitle($filename);
    $pdf->Output($filename, 'I');
  }

  //-----------------------------------------------------Terbilang-------------------------------------------------------//
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		}
		else if ($nilai <20)
		{
			$temp = $this->penyebut($nilai - 10). " belas";
		}
		else if ($nilai < 100)
		{
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		}
		else if ($nilai < 200)
		{
			$temp = " seratus" . $this->penyebut($nilai - 100);
		}
		else if ($nilai < 1000)
		{
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		}
		else if ($nilai < 2000)
		{
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		}
		else if ($nilai < 1000000)
		{
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		}
		else if ($nilai < 1000000000)
		{
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		}
		else if ($nilai < 1000000000000)
		{
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		}
		else if ($nilai < 1000000000000000)
		{
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}
		return $hasil;
	}
 //------------------------------------------------Selesai Terbilang--------------------------------------------------------//

  public function exportExcel()
  {
    $aksi = 'Lelayu';
    $detail = 'Mengexport Semua Data Lelayu';

    $this->log_activity->activity_log($aksi, $detail);

    $data['date'] = date("d-m-Y");
    $data['exportExcel'] = $this->M_lelayu->getDataListExcel();
    $data['atasan'] = $this->M_lelayu->getAtasan();

    $this->load->library("Excel");
    $this->load->view('MasterPresensi/Lelayu/ListData/V_excel',$data);
  }

  public function exportExcelSPSI($id)
  {
    $aksi = 'Lelayu';
    $detail = 'Mengexport Semua Data Lelayu';

    $this->log_activity->activity_log($aksi, $detail);
    
    $data['date'] = date("d-m-Y");
    $data['exportExcelSPSI'] = $this->M_lelayu->getPekerjaTerpotong($id);
    $data['LelayuSPSI'] = $this->M_lelayu->getDataPDF($id);
    $data['atasan'] = $this->M_lelayu->getAtasan();
    $jenkel = trim($data['LelayuSPSI'][0]['jk']);
			 if ($jenkel == 'L') {
				 	$data['jk'] = 'Bp. ';
				}elseif ($jenkel == 'P') {
					$data['jk'] = 'Ibu. ';
				}

    $this->load->library("Excel");
    $this->load->view('MasterPresensi/Lelayu/ListData/V_excel_spsi',$data);
  }

}

?>
