<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_History extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_history');
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

		$data['Title'] = 'Analisis SPB/DO';
		$data['Menu'] = 'Analisis';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        // $hasil = $this->olahdata();
        // $data['data'] = $hasil;
        // $data['jml_diesel'] = $this->getJenisItem('DIESEL');
        // $data['jml_vbelt'] = $this->getJenisItem('VBELT');
        // $data['jml_sap'] = $this->getJenisItem('SAP');
        // $data['datapic'] = $this->datapic(date('d/m/Y'), date('d/m/Y'));
        // echo "<pre>";print_r($data);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('KapasitasGdSparepart/V_History', $data);
        $this->load->view('V_Footer',$data);
    }

    public function searchDataHistory(){
        $data['data'] = $this->olahdata();
        $data['jml_diesel'] = $this->getJenisItem('DIESEL');
        $data['jml_vbelt'] = $this->getJenisItem('VBELT');
        $data['jml_sap'] = $this->getJenisItem('SAP');
        $this->load->view('KapasitasGdSparepart/V_TblDataHistory', $data);
    }

    public function olahdata(){
        $val = $this->M_history->getDataSPB('');
        $datamasuk = $this->M_history->getdatamasuk();
        $datapelayanan = $this->M_history->getdatapelayanan();
        $datapengeluaran = $this->M_history->getdatapengeluaran();
        $datapacking = $this->M_history->getdatapacking();
        // echo "<pre>";print_r($val);exit();
        $tampung = array();
        $colypcs = array();
        $masuk = array();
        $tgl = array();
        $a = 0;
        $m = 0;
        
        $haha = array();
        foreach ($val as $key => $value) {
            if (!in_array($value['TGL_PELAYANAN'], $tgl) && $value['TGL_PELAYANAN'] != '') {
                if (!in_array($value['TGL_PELAYANAN'], $haha)) {
                    array_push($tgl, $value['TGL_PELAYANAN']);
                    array_push($haha, $value['TGL_PELAYANAN']);
                    $tampung[$a]['TANGGAL']   = $value['TGL_PELAYANAN'];
                    $tampung[$a]['TGL_INPUT']   = $value['SELESAI_PELAYANAN'];
                    $masuk     = $this->caridatamasuk($val, $value['SELESAI_PELAYANAN'], $datamasuk);
                    $tampung[$a]['ITEM_MASUK']  = $masuk['item_in'];
                    $tampung[$a]['LEMBAR_MASUK']= $masuk['lembar_masuk'];
                    $tampung[$a]['PCS_MASUK']   = $masuk['pcs_masuk'];
    
                    $plyn = $this->caripelayanan($val, $value['SELESAI_PELAYANAN'], $datapelayanan);
                    $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                    $tampung[$a]['ITEM_PLYN']   = $plyn['item'];
                    $tampung[$a]['LEMBAR_PLYN'] = $plyn['lembar'];
    
                    $pglr = $this->caripengeluaran($val, $value['SELESAI_PELAYANAN'], $datapengeluaran);
                    $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                    $tampung[$a]['ITEM_PGLR']   = $pglr['item'];
                    $tampung[$a]['LEMBAR_PGLR'] = $pglr['lembar'];
    
                    $packing     = $this->caripacking($val, $value['SELESAI_PELAYANAN'], $datapacking);
                    $tampung[$a]['PACKING']     = $packing['waktu'];
                    $tampung[$a]['COLY']        = $packing['coly'];
                    $tampung[$a]['LEMBAR_PACK'] = $packing['lembar_pack'];
                    $tampung[$a]['PCS_PACK']    = $packing['pcs_pack'];
                    $tampung[$a]['JML_PACK']    = $packing['jml_pack'];
                    $tampung[$a]['ITEM_KELUAR'] = $packing['item_out'];
                    $a++;
                }
            }
            if (!in_array($value['TGL_PENGELUARAN'], $tgl) && $value['TGL_PENGELUARAN'] != '') {
                if (!in_array($value['TGL_PENGELUARAN'], $haha)) {
                    array_push($tgl, $value['TGL_PENGELUARAN']);
                    array_push($haha, $value['TGL_PENGELUARAN']);
                    $tampung[$a]['TANGGAL']   = $value['TGL_PENGELUARAN'];
                    $tampung[$a]['TGL_INPUT']   = $value['SELESAI_PENGELUARAN'];
                    $masuk     = $this->caridatamasuk($val, $value['SELESAI_PENGELUARAN'], $datamasuk);
                    $tampung[$a]['ITEM_MASUK']  = $masuk['item_in'];
                    $tampung[$a]['LEMBAR_MASUK']= $masuk['lembar_masuk'];
                    $tampung[$a]['PCS_MASUK']   = $masuk['pcs_masuk'];
    
                    $plyn = $this->caripelayanan($val, $value['SELESAI_PENGELUARAN'], $datapelayanan);
                    $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                    $tampung[$a]['ITEM_PLYN']   = $plyn['item'];
                    $tampung[$a]['LEMBAR_PLYN'] = $plyn['lembar'];
    
                    $pglr = $this->caripengeluaran($val, $value['SELESAI_PENGELUARAN'], $datapengeluaran);
                    $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                    $tampung[$a]['ITEM_PGLR']   = $pglr['item'];
                    $tampung[$a]['LEMBAR_PGLR'] = $pglr['lembar'];
    
                    $packing     = $this->caripacking($val, $value['SELESAI_PENGELUARAN'], $datapacking);
                    $tampung[$a]['PACKING']     = $packing['waktu'];
                    $tampung[$a]['COLY']        = $packing['coly'];
                    $tampung[$a]['LEMBAR_PACK'] = $packing['lembar_pack'];
                    $tampung[$a]['PCS_PACK']    = $packing['pcs_pack'];
                    $tampung[$a]['JML_PACK']    = $packing['jml_pack'];
                    $tampung[$a]['ITEM_KELUAR'] = $packing['item_out'];
                    $a++;
                }
            }
            if (!in_array($value['TGL_PACKING'], $tgl) && $value['TGL_PACKING'] != '') {
                if (!in_array($value['TGL_PACKING'], $haha)) {
                    array_push($tgl, $value['TGL_PACKING']);
                    array_push($haha, $value['TGL_PACKING']);
                    $tampung[$a]['TANGGAL']   = $value['TGL_PACKING'];
                    $tampung[$a]['TGL_INPUT']   = $value['SELESAI_PACKING'];
                    $masuk     = $this->caridatamasuk($val, $value['SELESAI_PACKING'], $datamasuk);
                    $tampung[$a]['ITEM_MASUK']  = $masuk['item_in'];
                    $tampung[$a]['LEMBAR_MASUK']= $masuk['lembar_masuk'];
                    $tampung[$a]['PCS_MASUK']   = $masuk['pcs_masuk'];
    
                    $plyn = $this->caripelayanan($val, $value['SELESAI_PACKING'], $datapelayanan);
                    $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                    $tampung[$a]['ITEM_PLYN']   = $plyn['item'];
                    $tampung[$a]['LEMBAR_PLYN'] = $plyn['lembar'];
    
                    $pglr = $this->caripengeluaran($val, $value['SELESAI_PACKING'], $datapengeluaran);
                    $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                    $tampung[$a]['ITEM_PGLR']   = $pglr['item'];
                    $tampung[$a]['LEMBAR_PGLR'] = $pglr['lembar'];
    
                    $packing     = $this->caripacking($val, $value['SELESAI_PACKING'], $datapacking);
                    $tampung[$a]['PACKING']     = $packing['waktu'];
                    $tampung[$a]['COLY']        = $packing['coly'];
                    $tampung[$a]['LEMBAR_PACK'] = $packing['lembar_pack'];
                    $tampung[$a]['PCS_PACK']    = $packing['pcs_pack'];
                    $tampung[$a]['JML_PACK']    = $packing['jml_pack'];
                    $tampung[$a]['ITEM_KELUAR'] = $packing['item_out'];
                    $a++;
                }
            }
        }
        array_multisort($tgl, SORT_DESC, $tampung);
        $data['data'] = $tampung;
        // echo "<pre>";print_r($tampung);exit();
        return $tampung;
    }

    public function caripelayanan($val, $jam, $data){
        $waktu = 0;
        $inijml = 0;
        $item_plyn = 0;
        // for ($l=0; $l < count($val); $l++) { 
        //     if ($jam == $val[$l]['SELESAI_PELAYANAN2']) {
        //         $wkt1 = explode(":", $val[$l]['WAKTU_PELAYANAN']);
        //         $wkt2 = ($wkt1[0]*3600) + ($wkt1[1]*60) + $wkt1[2];
        //         $waktu += $wkt2;
        //         $inijml += 1;
        //         $item_plyn += $val[$l]['JUMLAH_ITEM'];
        //     }
        // }
        for ($i=0; $i < count($data) ; $i++) { 
            if ($jam == $data[$i]['TGL_SELESAI_PELAYANAN']) {
                $waktu += $data[$i]['DETIK'];
                $inijml += $data[$i]['JUMLAH_LEMBAR'];
                $item_plyn += $data[$i]['SUM_JUMLAH_ITEM'];
            }
        }
        if ($inijml == 0) {
            $bagi = 1;
        }else {
            $bagi = $inijml;
        }
        $iniwaktu = round($waktu / $bagi);
        $hasil = array('waktu' => $iniwaktu,
                        'item' => $item_plyn,
                        'lembar' => $inijml);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }
    
    public function caripengeluaran($val, $jam, $data){
        $waktu = 0;
        $inijml = 0;
        $item_pglr = 0;
        // for ($l=0; $l < count($val); $l++) { 
        //     if ($jam == $val[$l]['SELESAI_PENGELUARAN2']) {
        //         $wkt1 = explode(":", $val[$l]['WAKTU_PENGELUARAN']);
        //         $wkt2 = ($wkt1[0]*3600) + ($wkt1[1]*60) + $wkt1[2];
        //         $waktu += $wkt2;
        //         $inijml += 1;
        //         $item_pglr += $val[$l]['JUMLAH_ITEM'];
        //     }
        // }
        for ($i=0; $i < count($data) ; $i++) { 
            if ($jam == $data[$i]['TGL_SELESAI_PENGELUARAN']) {
                $waktu += $data[$i]['DETIK'];
                $inijml += $data[$i]['JUMLAH_LEMBAR'];
                $item_pglr += $data[$i]['SUM_JUMLAH_ITEM'];
            }
        }
        if ($inijml == 0) {
            $bagi = 1;
        }else {
            $bagi = $inijml;
        }
        $iniwaktu = round($waktu / $bagi);
        $hasil = array('waktu' => $iniwaktu,
                        'item' => $item_pglr,
                        'lembar' => $inijml);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }
    
    public function caripacking($val, $jam, $data){
        $waktu = 0;
        $inijml = 0;
        $coly = 0;
        $lembar_pack = 0;
        $pcs_pack = 0;
        $out = 0;
        $nospb = '';
        for ($l=0; $l < count($val); $l++) { 
            if ($jam == $val[$l]['SELESAI_PACKING']) {
                $nospb .= empty($nospb) ? $val[$l]['NO_DOKUMEN'] : ', '.$val[$l]['NO_DOKUMEN'];
        //         $wkt1 = explode(":", $val[$l]['WAKTU_PACKING']);
        //         $wkt2 = ($wkt1[0]*3600) + ($wkt1[1]*60) + $wkt1[2];
        //         $waktu += $wkt2;
        //         $inijml += 1;
        //         $lembar_pack += 1;
        //         $pcs_pack += $val[$l]['JUMLAH_PCS'];
        //         $out += $val[$l]['JUMLAH_ITEM'];
                // foreach ($datacoly as $key => $col) {
                //     if ($col['nomor_do'] == $val[$l]['NO_DOKUMEN']) {
                //         $coly += $col['jumlah'];
                //         // $coly += 1;
                //     }
                // }
            }
        }
        // echo "<pre>";print_r($nospb);exit();
        for ($i=0; $i < count($data) ; $i++) { 
            if ($jam == $data[$i]['TGL_SELESAI_PACKING']) {
                $waktu += $data[$i]['DETIK'];
                $inijml += $data[$i]['JUMLAH_LEMBAR'];
                $out += $data[$i]['SUM_JUMLAH_ITEM'];
                $pcs_pack += $data[$i]['SUM_JUMLAH_PCS'];
            }
        }
        if ($inijml == 0) {
            $bagi = 1;
        }else {
            $bagi = $inijml;
            $caricoly = $this->M_history->cekPacking($nospb);
            // echo "<pre>";print_r($caricoly);exit();
            $coly += $caricoly[0]['total'];
        }
        $iniwaktu = round($waktu / $bagi);
        $jml_pack = round($pcs_pack/50);
        $hasil = array('waktu' => $iniwaktu,
                        'coly' => $coly,
                        'lembar_pack' => $inijml,
                        'pcs_pack' => $pcs_pack,
                        'item_out' => $out,
                        'jml_pack' => $jml_pack);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }

    public function caridatamasuk($val, $date, $masuk){
        $in = 0;
        $lembar_masuk = 0;
        $pcs_masuk = 0;
        // for ($l=0; $l < count($val) ; $l++) { 
        //     if ($date == $val[$l]['JAM_INPUT']) {
        //         $in += $val[$l]['JUMLAH_ITEM'];
        //         $pcs_masuk += $val[$l]['JUMLAH_PCS'];
        //         $lembar_masuk += 1;
        //     }
        // }
        for ($i=0; $i < count($masuk) ; $i++) { 
            if ($date == $masuk[$i]['TGL_INPUT']) {
                $in += $masuk[$i]['SUM_JUMLAH_ITEM'];
                $pcs_masuk += $masuk[$i]['SUM_JUMLAH_PCS'];
                $lembar_masuk += $masuk[$i]['JUMLAH_LEMBAR'];
            }
        }
        $hasil = array('lembar_masuk' => $lembar_masuk,
                'pcs_masuk' => $pcs_masuk,
                'item_in' => $in);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }

    
    public function getJenisItem($jenis){
        $getdata = $this->M_history->getItemDOSPB();
        // echo "<pre>";print_r($tgl);exit();
        $pelayanan = $pengeluaran = $packing = $jumlah = $item = $pcs = 0;
        foreach ($getdata as $key => $value) {
            if ($value['FINAL'] == $jenis) {
                // if ($value['WAKTU_PELAYANAN']) {
                //     $wkt_plyn = explode(":", $value['WAKTU_PELAYANAN']);
                //     $wkt_plyn2 = ($wkt_plyn[0]*3600) + ($wkt_plyn[1]*60) + $wkt_plyn[2];
                //     $pelayanan += $wkt_plyn2;
                // }
                
                // if ($value['WAKTU_PENGELUARAN']) {
                //     $wkt_pglr = explode(":", $value['WAKTU_PENGELUARAN']);
                //     $wkt_pglr2 = ($wkt_pglr[0]*3600) + ($wkt_pglr[1]*60) + $wkt_pglr[2];
                //     $pengeluaran += $wkt_pglr2;
                // }
                
                // if ($value['WAKTU_PACKING']) {
                //     $wkt_pck = explode(":", $value['WAKTU_PACKING']);
                //     $wkt_pck2 = ($wkt_pck[0]*3600) + ($wkt_pck[1]*60) + $wkt_pck[2];
                //     $packing += $wkt_pck2;
                // }

                $jumlah += 1;
                $item += $value['JUMLAH_ITEM'];
                $pcs += $value['JUMLAH_PCS'];
            }
        }
        $pcs = $pcs /100;
        $item = $item /10;
        $hasil = array($jumlah, $item, $pcs);
        return $hasil;
    }

    public function detailJenisItem(){
        $tanggal = $this->input->post('tanggal');
        
        $getdata = $this->M_history->getItemDOSPB();
        $datanya = array();
        foreach ($getdata as $key => $value) {
            if ($value['JAM_INPUT'] == $tanggal) {
                array_push($datanya, $value);
            }
        }
        // echo "<pre>";print_r($datanya);exit();
        $data['data'] = $datanya;
        $this->load->view('KapasitasGdSparepart/V_ModalJenisItem', $data);
    }

    public function datapic($date1, $date2){
        $pic    = $this->M_history->getPIC();
        $val    = $this->M_history->getDataSPB('');
        $tgl1   = explode('/', $date1);
        $date1  = $tgl1[2].$tgl1[1].$tgl1[0];
        $tgl2   = explode('/', $date2);
        $date2  = $tgl2[2].$tgl2[1].$tgl2[0];

        $datanya = array();
        $doc_plyn_kosong = $item_plyn_kosong = $pcs_plyn_kosong = 0;
        $doc_pglr_kosong = $item_pglr_kosong = $pcs_pglr_kosong = 0;
        $doc_pck_kosong = $item_pck_kosong = $pcs_pck_kosong = 0;
        $sdh_plyn = $sdh_pglr = $sdh_pck = array();
        foreach ($pic as $key => $p) {
            $doc_plyn = $item_plyn = $pcs_plyn = 0;
            $doc_pglr = $item_pglr = $pcs_pglr = 0;
            $doc_pck = $item_pck = $pcs_pck = 0;
            foreach ($val as $key => $value) {
                if ($p['PIC'] == $value['PIC_PELAYAN'] && $value['TGL_PELAYANAN'] >= $date1 && $value['TGL_PELAYANAN'] <= $date2) {
                    $doc_plyn += 1;
                    $item_plyn += $value['JUMLAH_ITEM'];
                    $pcs_plyn += $value['JUMLAH_PCS'];
                }elseif (empty($value['PIC_PELAYAN'])  && $value['TGL_PELAYANAN'] >= $date1 && $value['TGL_PELAYANAN'] <= $date2 && !in_array($value['NO_DOKUMEN'], $sdh_plyn)) {
                    $doc_plyn_kosong += 1;
                    $item_plyn_kosong += $value['JUMLAH_ITEM'];
                    $pcs_plyn_kosong += $value['JUMLAH_PCS'];
                    array_push($sdh_plyn, $value['NO_DOKUMEN']);
                }
                
                if ($p['PIC'] == $value['PIC_PENGELUARAN']  && $value['TGL_PENGELUARAN'] >= $date1 && $value['TGL_PENGELUARAN'] <= $date2) {
                    $doc_pglr += 1;
                    $item_pglr += $value['JUMLAH_ITEM'];
                    $pcs_pglr += $value['JUMLAH_PCS'];
                }elseif (empty($value['PIC_PENGELUARAN']) && $value['TGL_PENGELUARAN'] >= $date1 && $value['TGL_PENGELUARAN'] <= $date2 && !in_array($value['NO_DOKUMEN'], $sdh_pglr)) {
                    $doc_pglr_kosong += 1;
                    $item_pglr_kosong += $value['JUMLAH_ITEM'];
                    $pcs_pglr_kosong += $value['JUMLAH_PCS'];
                    array_push($sdh_pglr, $value['NO_DOKUMEN']);
                }
                
                if ($p['PIC'] == $value['PIC_PACKING'] && $value['TGL_PACKING'] >= $date1 && $value['TGL_PACKING'] <= $date2) {
                    $doc_pck += 1;
                    $item_pck += $value['JUMLAH_ITEM'];
                    $pcs_pck += $value['JUMLAH_PCS'];
                }elseif (empty($value['PIC_PACKING']) && $value['TGL_PACKING'] >= $date1 && $value['TGL_PACKING'] <= $date2 && !in_array($value['NO_DOKUMEN'], $sdh_pck)) {
                    $doc_pck_kosong += 1;
                    $item_pck_kosong += $value['JUMLAH_ITEM'];
                    $pcs_pck_kosong += $value['JUMLAH_PCS'];
                    array_push($sdh_pck, $value['NO_DOKUMEN']);
                }

            }

                $hasil = array('PIC' => $p['PIC'],
                                'DOKUMEN_PELAYANAN' => $doc_plyn,
                                'ITEM_PELAYANAN' => $item_plyn,
                                'PCS_PELAYANAN' => $pcs_plyn,
                                'DOKUMEN_PENGELUARAN' => $doc_pglr,
                                'ITEM_PENGELUARAN' => $item_pglr,
                                'PCS_PENGELUARAN' => $pcs_pglr,
                                'DOKUMEN_PACKING' => $doc_pck,
                                'ITEM_PACKING' => $item_pck,
                                'PCS_PACKING' => $pcs_pck,
                        );  
                array_push($datanya, $hasil);
        }
        $hasil_kosong = array('PIC' => '',
                        'DOKUMEN_PELAYANAN' => $doc_plyn_kosong,
                        'ITEM_PELAYANAN' => $item_plyn_kosong,
                        'PCS_PELAYANAN' => $pcs_plyn_kosong,
                        'DOKUMEN_PENGELUARAN' => $doc_pglr_kosong,
                        'ITEM_PENGELUARAN' => $item_pglr_kosong,
                        'PCS_PENGELUARAN' => $pcs_pglr_kosong,
                        'DOKUMEN_PACKING' => $doc_pck_kosong,
                        'ITEM_PACKING' => $item_pck_kosong,
                        'PCS_PACKING' => $pcs_pck_kosong,
                );  
        array_push($datanya, $hasil_kosong);
        // echo "<pre>";print_r($datanya);exit();
        return $datanya;
    }

    public function searchDataPIC(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $data['datapic'] = $this->datapic($tgl_awal, $tgl_akhir);
        $this->load->view('KapasitasGdSparepart/V_TblPICHistory', $data);
    }

}
