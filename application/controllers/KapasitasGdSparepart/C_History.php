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
			redirect('');
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
        $hasil = $this->olahdata();
        $data['data'] = $hasil;
        $data['jml_diesel'] = $this->getJenisItem('DIESEL');
        $data['jml_vbelt'] = $this->getJenisItem('VBELT');
        $data['jml_sap'] = $this->getJenisItem('SAP');
        $data['datapic'] = $this->datapic(date('d/m/Y'), date('d/m/Y'));
        // echo "<pre>";print_r($data);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('KapasitasGdSparepart/V_History', $data);
        $this->load->view('V_Footer',$data);
    }

    public function olahdata(){
        $val = $this->M_history->getDataSPB('');
        $coly = $this->M_history->cekPacking();
        $tampung = array();
        $colypcs = array();
        $masuk = array();
        $tgl = array();
        $a = 0;
        $m = 0;
        $date = date('Ymd');
        if ($val[0]['TGL_INPUT'] != $date) {
            array_push($tgl, $date);
            $tampung[$a]['TANGGAL']     = $date;
            $tampung[$a]['TGL_INPUT']   = strtoupper(date('d-M-y'));
            $plyn = $this->caripelayanan($val, date('d/m/Y'));
            $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
            $tampung[$a]['ITEM_PLYN']   = $plyn['item'];

            $pglr = $this->caripengeluaran($val, date('d/m/Y'));
            $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
            $tampung[$a]['ITEM_PGLR']   = $pglr['item'];

            $packing     = $this->caripacking($val, date('d/m/Y'), $coly);
            $tampung[$a]['PACKING']     = $packing['waktu'];
            $tampung[$a]['COLY']        = $packing['coly'];
            $tampung[$a]['LEMBAR_PACK'] = $packing['lembar_pack'];
            $tampung[$a]['PCS_PACK']    = $packing['pcs_pack'];
            $tampung[$a]['JML_PACK']    = $packing['jml_pack'];
            $tampung[$a]['ITEM_KELUAR'] = $packing['item_out'];
            $tampung[$m]['LEMBAR_MASUK'] = 0;
            $tampung[$m]['PCS_MASUK']   = 0;
            $tampung[$m]['ITEM_MASUK']  = 0;
        $a++; $m++;
        }
        for ($i=0; $i < count($val); $i++) { 
            if (!in_array($val[$i]['TGL_INPUT'], $tgl)) {
                array_push($tgl, $val[$i]['TGL_INPUT']);
                $tampung[$a]['TANGGAL']     = $val[$i]['TGL_INPUT'];
                $tampung[$a]['TGL_INPUT']   = $val[$i]['JAM'];
                $masuk     = $this->caridatamasuk($val, $val[$i]['JAM_INPUT']);
                $tampung[$a]['ITEM_MASUK']  = $masuk['item_in'];
                $tampung[$a]['LEMBAR_MASUK']= $masuk['lembar_masuk'];
                $tampung[$a]['PCS_MASUK']   = $masuk['pcs_masuk'];

                $plyn = $this->caripelayanan($val, $val[$i]['JAM_INPUT']);
                $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                $tampung[$a]['ITEM_PLYN']   = $plyn['item'];

                $pglr = $this->caripengeluaran($val, $val[$i]['JAM_INPUT']);
                $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                $tampung[$a]['ITEM_PGLR']   = $pglr['item'];

                $packing     = $this->caripacking($val, $val[$i]['JAM_INPUT'], $coly);
                $tampung[$a]['PACKING']     = $packing['waktu'];
                $tampung[$a]['COLY']        = $packing['coly'];
                $tampung[$a]['LEMBAR_PACK'] = $packing['lembar_pack'];
                $tampung[$a]['PCS_PACK']    = $packing['pcs_pack'];
                $tampung[$a]['JML_PACK']    = $packing['jml_pack'];
                $tampung[$a]['ITEM_KELUAR'] = $packing['item_out'];
                
            $a++;
            }            
        }
        
        $haha = array();
        foreach ($val as $key => $value) {
            if (!in_array($value['TGL_PELAYANAN'], $tgl) && $value['TGL_PELAYANAN'] != '') {
                if (!in_array($value['TGL_PELAYANAN'], $haha)) {
                    array_push($tgl, $value['TGL_PELAYANAN']);
                    array_push($haha, $value['TGL_PELAYANAN']);
                    $tampung[$a]['TANGGAL']   = $value['TGL_PELAYANAN'];
                    $tampung[$a]['TGL_INPUT']   = $value['SELESAI_PELAYANAN'];
                    $tampung[$a]['LEMBAR_MASUK'] = 0;
                    $tampung[$a]['PCS_MASUK']   = 0;
                    $tampung[$a]['ITEM_MASUK']  = 0;
    
                    $plyn = $this->caripelayanan($val, $value['SELESAI_PELAYANAN2']);
                    $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                    $tampung[$a]['ITEM_PLYN']   = $plyn['item'];
    
                    $pglr = $this->caripengeluaran($val, $value['SELESAI_PELAYANAN2']);
                    $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                    $tampung[$a]['ITEM_PGLR']   = $pglr['item'];
    
                    $packing     = $this->caripacking($val, $value['SELESAI_PELAYANAN2'], $coly);
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
                    $tampung[$a]['LEMBAR_MASUK'] = 0;
                    $tampung[$a]['PCS_MASUK']   = 0;
                    $tampung[$a]['ITEM_MASUK']  = 0;
    
                    $plyn = $this->caripelayanan($val, $value['SELESAI_PENGELUARAN2']);
                    $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                    $tampung[$a]['ITEM_PLYN']   = $plyn['item'];
    
                    $pglr = $this->caripengeluaran($val, $value['SELESAI_PENGELUARAN2']);
                    $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                    $tampung[$a]['ITEM_PGLR']   = $pglr['item'];
    
                    $packing     = $this->caripacking($val, $value['SELESAI_PENGELUARAN2'], $coly);
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
                    $tampung[$a]['LEMBAR_MASUK'] = 0;
                    $tampung[$a]['PCS_MASUK']   = 0;
                    $tampung[$a]['ITEM_MASUK']  = 0;
    
                    $plyn = $this->caripelayanan($val, $value['SELESAI_PACKING2']);
                    $tampung[$a]['PELAYANAN']   = $plyn['waktu'];
                    $tampung[$a]['ITEM_PLYN']   = $plyn['item'];
    
                    $pglr = $this->caripengeluaran($val, $value['SELESAI_PACKING2']);
                    $tampung[$a]['PENGELUARAN'] = $pglr['waktu'];
                    $tampung[$a]['ITEM_PGLR']   = $pglr['item'];
    
                    $packing     = $this->caripacking($val, $value['SELESAI_PACKING2'], $coly);
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

    public function caripelayanan($val, $jam){
        $waktu = 0;
        $inijml = 0;
        $item_plyn = 0;
        for ($l=0; $l < count($val); $l++) { 
            if ($jam == $val[$l]['SELESAI_PELAYANAN2']) {
                $wkt1 = explode(":", $val[$l]['WAKTU_PELAYANAN']);
                $wkt2 = ($wkt1[0]*3600) + ($wkt1[1]*60) + $wkt1[2];
                $waktu += $wkt2;
                $inijml += 1;
                $item_plyn += $val[$l]['JUMLAH_ITEM'];
            }
        }
        if ($inijml == 0) {
            $bagi = 1;
        }else {
            $bagi = $inijml;
        }
        $iniwaktu = round($waktu / $bagi);
        $hasil = array('waktu' => $iniwaktu,
                        'item' => $item_plyn);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }
    
    public function caripengeluaran($val, $jam){
        $waktu = 0;
        $inijml = 0;
        $item_pglr = 0;
        for ($l=0; $l < count($val); $l++) { 
            if ($jam == $val[$l]['SELESAI_PENGELUARAN2']) {
                $wkt1 = explode(":", $val[$l]['WAKTU_PENGELUARAN']);
                $wkt2 = ($wkt1[0]*3600) + ($wkt1[1]*60) + $wkt1[2];
                $waktu += $wkt2;
                $inijml += 1;
                $item_pglr += $val[$l]['JUMLAH_ITEM'];
            }
        }
        if ($inijml == 0) {
            $bagi = 1;
        }else {
            $bagi = $inijml;
        }
        $iniwaktu = round($waktu / $bagi);
        $hasil = array('waktu' => $iniwaktu,
                        'item' => $item_pglr);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }
    
    public function caripacking($val, $jam, $datacoly){
        $waktu = 0;
        $inijml = 0;
        $coly = 0;
        $lembar_pack = 0;
        $pcs_pack = 0;
        $out = 0;
        for ($l=0; $l < count($val); $l++) { 
            if ($jam == $val[$l]['SELESAI_PACKING2']) {
                $wkt1 = explode(":", $val[$l]['WAKTU_PACKING']);
                $wkt2 = ($wkt1[0]*3600) + ($wkt1[1]*60) + $wkt1[2];
                $waktu += $wkt2;
                $inijml += 1;
                $lembar_pack += 1;
                $pcs_pack += $val[$l]['JUMLAH_PCS'];
                $out += $val[$l]['JUMLAH_ITEM'];
                foreach ($datacoly as $key => $col) {
                    if ($col['nomor_do'] == $val[$l]['NO_DOKUMEN']) {
                        $coly += $col['jumlah'];
                        // $coly += 1;
                    }
                }
            }
        }
        if ($inijml == 0) {
            $bagi = 1;
        }else {
            $bagi = $inijml;
        }
        $iniwaktu = round($waktu / $bagi);
        $jml_pack = round($pcs_pack/50);
        $hasil = array('waktu' => $iniwaktu,
                        'coly' => $coly,
                        'lembar_pack' => $lembar_pack,
                        'pcs_pack' => $pcs_pack,
                        'item_out' => $out,
                        'jml_pack' => $jml_pack);
        // echo "<pre>";print_r($hasil);exit();
        return $hasil;
    }

    public function caridatamasuk($val, $date){
        $in = 0;
        $lembar_masuk = 0;
        $pcs_masuk = 0;
        for ($l=0; $l < count($val) ; $l++) { 
            if ($date == $val[$l]['JAM_INPUT']) {
                $in += $val[$l]['JUMLAH_ITEM'];
                $pcs_masuk += $val[$l]['JUMLAH_PCS'];
                $lembar_masuk += 1;
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
        $pic = $this->M_history->getPIC();
        $val = $this->M_history->getDataSPB('');
        // echo "<pre>";print_r($val);exit();
        $datanya = array();
        $doc_plyn_kosong = $item_plyn_kosong = $pcs_plyn_kosong = 0;
        $doc_pglr_kosong = $item_pglr_kosong = $pcs_pglr_kosong = 0;
        $doc_pck_kosong = $item_pck_kosong = $pcs_pck_kosong = 0;
        foreach ($pic as $key => $p) {
            $doc_plyn = $item_plyn = $pcs_plyn = 0;
            $doc_pglr = $item_pglr = $pcs_pglr = 0;
            $doc_pck = $item_pck = $pcs_pck = 0;
            foreach ($val as $key => $value) {
                if ($p['PIC'] == $value['PIC_PELAYAN'] && $value['SELESAI_PELAYANAN2'] >= $date1 && $value['SELESAI_PELAYANAN2'] <= $date2) {
                    $doc_plyn += 1;
                    $item_plyn += $value['JUMLAH_ITEM'];
                    $pcs_plyn += $value['JUMLAH_PCS'];
                }elseif (empty($value['PIC_PELAYAN'])  && $value['SELESAI_PELAYANAN2'] >= $date1 && $value['SELESAI_PELAYANAN2'] <= $date2) {
                    $doc_plyn_kosong += 1;
                    $item_plyn_kosong += $value['JUMLAH_ITEM'];
                    $pcs_plyn_kosong += $value['JUMLAH_PCS'];
                }
                
                if ($p['PIC'] == $value['PIC_PENGELUARAN']  && $value['SELESAI_PENGELUARAN2'] >= $date1 && $value['SELESAI_PENGELUARAN2'] <= $date2) {
                    $doc_pglr += 1;
                    $item_pglr += $value['JUMLAH_ITEM'];
                    $pcs_pglr += $value['JUMLAH_PCS'];
                }elseif (empty($value['PIC_PENGELUARAN']) && $value['SELESAI_PENGELUARAN2'] >= $date1 && $value['SELESAI_PENGELUARAN2'] <= $date2) {
                    $doc_pglr_kosong += 1;
                    $item_pglr_kosong += $value['JUMLAH_ITEM'];
                    $pcs_pglr_kosong += $value['JUMLAH_PCS'];
                }
                
                if ($p['PIC'] == $value['PIC_PACKING'] && $value['SELESAI_PACKING2'] >= $date1 && $value['SELESAI_PACKING2'] <= $date2) {
                    $doc_pck += 1;
                    $item_pck += $value['JUMLAH_ITEM'];
                    $pcs_pck += $value['JUMLAH_PCS'];
                }elseif (empty($value['PIC_PACKING']) && $value['SELESAI_PACKING2'] >= $date1 && $value['SELESAI_PACKING2'] <= $date2) {
                    $doc_pglr_kosong += 1;
                    $item_pglr_kosong += $value['JUMLAH_ITEM'];
                    $pcs_pglr_kosong += $value['JUMLAH_PCS'];
                }

            }

            // if ($doc_plyn == 0 && $doc_pglr == 0 && $doc_pck == 0) {
            // }else {
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
            // }
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
