<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {
    public function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
        $this->load->library('session');
		$this->load->library('form_validation');
        $this->load->library('PHPMailerAutoload');
        $this->load->library('ciqrcode');
        
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PengembalianBarangGudang/M_pengembalianbrg');
        
        $this->checkSession();
    }

    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
    }

    public function index(){
		$user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring Pengembalian Barang';
        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['getPengembalian'] = $this->M_pengembalianbrg->getDataMon();
        // print_r($data['getPengembalian']); exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PengembalianBarangGudang/V_Monitoring',$data);
        $this->load->view('V_Footer',$data);
    }

    public function createallMOSeksi(){
        // echo "<pre>"; print_r ($_POST); exit();
        $user_id = $this->session->user;
        $ip_address = $this->input->ip_address();
        $id_pengembalian = $this->input->post('id_pengembalian');
        $id_komponen = $this->input->post('id_komponen');
        $kode_komponen = $this->input->post('kode_komponen');
        $nama_komponen = $this->input->post('nama_komponen');
        $qty_komponen = $this->input->post('qty_komponen');
        $uom = $this->input->post('uom');
        $alasan_pengembalian = $this->input->post('alasan_pengembalian');
        $pic_assembly = $this->input->post('pic_assembly');
        $pic_gudang = $this->input->post('pic_gudang');
        $status_verifikasi = $this->input->post('status_verifikasi');
        $keterangan = $this->input->post('keterangan');
        $tosub = $this->input->post('subinv');
        $toloc = $this->input->post('locator');
        $selected = $this->input->post('slcKompPBGSeksi');
        $arraySelected = explode('+', $selected);
        $fromsub = 'REJECT-DM';
        $fromloc = 785; //KOM-TKS REJ
        // echo "<pre>"; print_r ($arraySelected); exit();

        // $noMo = $this->M_pengembalianbrg->getNoMo();
        // echo "<pre>"; print_r ($noMo); exit();

        $array_mo = array();
        
        $cek = array();

        $no = 1;
        foreach ($id_pengembalian as $key => $value) {
            if (in_array($value, $arraySelected)){
                // echo "<pre>"; print_r($value);
                $checkMoSeksi = $this->M_pengembalianbrg->checkMoSeksi($value);
                // $no_mo = $checkMoSeksi[0]['NO_MO'];
                // echo "<pre>"; print_r($checkMoSeksi);
                if (count($checkMoSeksi) > 0) {
                    foreach ($checkMoSeksi as $keymo => $valuemo) {
                        $no_mo = $valuemo;
                        // array_push($array_mo, $no_mo);
                        // pengecekan supaya pdfnya ga double
                        if(in_array($no_mo, $array_mo)){
                                
                        }else{
                            array_push($array_mo, $no_mo);
                        }
                    }
                }else{
                    // $data = array();

                    $getAtt = $this->M_pengembalianbrg->getAtt($value, $fromsub, $fromloc);
                    // echo "<pre>"; print_r($getAtt);
                    $errQty = array();
                    foreach ($getAtt as $kQty => $vQty) {
                        if ($vQty['QTY_KOMPONEN'] > $vQty['ATT']){
                            $err = 1;
                        }else{
                            $err = 0;
                        }
                        $errQty[] = $err;
                        // echo "<pre>"; print_r($errQty);
                    }
                    // print_r($errQty);
                    if (!in_array(1, $errQty)) {
                        // $data = array(
                        $data[$tosub[$key]][$toloc[$key]][]= array(
                            'NO_URUT' => '',
                            'ID_PENGEMBALIAN' => $value,
                            'INVENTORY_ITEM_ID' => $id_komponen[$key],
                            'QUANTITY' => $qty_komponen[$key],
                            'UOM' => $uom[$key],
                            'IP_ADDRESS' => $ip_address,
                            'NO_MO' => '',
                            'SUBINV' => $tosub[$key],
                            'LOCATOR' => $toloc[$key],
                            'KETERANGAN' => $keterangan[$key]
                        );
                        // echo "<pre>"; print_r($data);
                    }
                    // echo "<pre>"; print_r($data);
                    
                    $no++;
                }
                
            }
            // echo "<pre>"; print_r($data);
            
        }
        // echo "<pre>"; print_r($data);
        if ($data) {
            foreach ($data as $sub => $vSub) {
                // echo "<pre>"; print_r($vSub);
                $i = 1;
                foreach ($vSub as $loc => $val) {
                    $noMo = $this->M_pengembalianbrg->getNoMo();
                    // echo "<pre>"; print_r($val);
                    foreach ($val as $key => $value2) {
                        $dataNew = $value2;
                        $dataNew['NO_URUT'] = $i;
                        $dataNew['NO_MO'] = $noMo[0]['NO_MO'];

                        $id_pengembalian = $dataNew['ID_PENGEMBALIAN'];
                        $nomor_mo = $noMo[0]['NO_MO'];
                        $ket = $dataNew['KETERANGAN'];
                        // create TEMP & UPDATE
                        // echo "insert<br>";
                        // print_r($dataNew);
                        $this->M_pengembalianbrg->createTemp($dataNew);
                        $this->M_pengembalianbrg->UpdateMoSeksi($id_pengembalian, $nomor_mo);

                        // echo "<pre>";  print_r($ket);
                        $i++;
                    }
                    //create MO       
                    $this->M_pengembalianbrg->createMO($fromsub, $fromloc, $sub, $loc, $ip_address, $nomor_mo, $user_id);

                    // delete
                    $this->M_pengembalianbrg->deleteTemp($ip_address, $nomor_mo);

                    $checkMoSeksi = $this->M_pengembalianbrg->checkMoSeksi($id_pengembalian);
                
                    foreach ($checkMoSeksi as $keymo => $valuemo) {
                        $no_mo = $valuemo;
                        // pengecekan supaya pdfnya ga double
                        if(in_array($no_mo, $array_mo)){
                                
                        }else{
                            array_push($array_mo, $no_mo);
                        }
                    }
                }
            }
        }

        if ($array_mo) {
			$this->pdfSeksi($array_mo);
		}else{
			exit('Terjadi Kesalahan :(');
        }
    }

    // create mo seksi per seksi penerima barang
    // public function createallMOSeksi(){
    //     // echo "<pre>"; print_r ($_POST); exit();
    //     $user_id = $this->session->user;
    //     $ip_address = $this->input->ip_address();
    //     $id_pengembalian = $this->input->post('id_pengembalian');
    //     $id_komponen = $this->input->post('id_komponen');
    //     $kode_komponen = $this->input->post('kode_komponen');
    //     $nama_komponen = $this->input->post('nama_komponen');
    //     $qty_komponen = $this->input->post('qty_komponen');
    //     $uom = $this->input->post('uom');
    //     $alasan_pengembalian = $this->input->post('alasan_pengembalian');
    //     $pic_assembly = $this->input->post('pic_assembly');
    //     $pic_gudang = $this->input->post('pic_gudang');
    //     $status_verifikasi = $this->input->post('status_verifikasi');
    //     $keterangan = $this->input->post('keterangan');
    //     $tosub = $this->input->post('subinv');
    //     $toloc = $this->input->post('locator');
    //     $selected = $this->input->post('slcKompPBGSeksi');
    //     $arraySelected = explode('+', $selected);
    //     $fromsub = 'REJECT-DM';
    //     $fromloc = 785; //KOM-TKS REJ
    //     // echo "<pre>"; print_r ($arraySelected); exit();

    //     $noMo = $this->M_pengembalianbrg->getNoMo();
    //     // echo "<pre>"; print_r ($noMo); exit();

    //     $array_mo = array();

    //     $no = 1;
    //     foreach ($id_pengembalian as $key => $value) {
    //         if (in_array($value, $arraySelected)){
    //             // print_r($value);
    //             $checkMoSeksi = $this->M_pengembalianbrg->checkMoSeksi($value);
    //             // $no_mo = $checkMoSeksi[0]['NO_MO'];
    //             // print_r($checkMoSeksi);
    //             if (count($checkMoSeksi) > 0) {
    //                 foreach ($checkMoSeksi as $keymo => $valuemo) {
    //                     $no_mo = $valuemo;
    //                     // array_push($array_mo, $no_mo);
    //                     // pengecekan supaya pdfnya ga double
    //                     if(in_array($no_mo, $array_mo)){
                                
    //                     }else{
    //                         array_push($array_mo, $no_mo);
    //                     }
    //                 }
    //             }else{
    //                 $getAtt = $this->M_pengembalianbrg->getAtt($value, $fromsub, $fromloc);
    //                 // print_r($getAtt);
    //                 $errQty = array();
    //                 foreach ($getAtt as $kQty => $vQty) {
    //                     if ($vQty['QTY_KOMPONEN'] > $vQty['ATT']){
    //                         $err = 1;
    //                     }else{
    //                         $err = 0;
    //                     }
    //                     $errQty[] = $err;
    //                 }
    //                 // print_r($errQty);
    //                 if (!in_array(1, $errQty)) {
    //                     $data = array(
    //                         'NO_URUT' => $no,
    //                         'INVENTORY_ITEM_ID' => $id_komponen[$key],
    //                         'QUANTITY' => $qty_komponen[$key],
    //                         'UOM' => $uom[$key],
    //                         'IP_ADDRESS' => $ip_address,
    //                         'NO_MO' => $noMo[0]['NO_MO'],
    //                         'SUBINV' => $tosub[$key],
    //                         'LOCATOR' => $toloc[$key]
    //                     );
    //                 }
    //                 // print_r($data);
    //                 $this->M_pengembalianbrg->createTemp($data);

    //                 $this->M_pengembalianbrg->UpdateMoSeksi($value, $noMo[0]['NO_MO']);

    //                 $checkMoSeksi = $this->M_pengembalianbrg->checkMoSeksi($value);
                
    //                 foreach ($checkMoSeksi as $keymo => $valuemo) {
    //                     $no_mo = $valuemo;
    //                     // pengecekan supaya pdfnya ga double
    //                     if(in_array($no_mo, $array_mo)){
                                
    //                     }else{
    //                         array_push($array_mo, $no_mo);
    //                     }
    //                 }

    //                 $no++;
                    
    //             }
    //         }
    //     }
    //     // echo "<pre>"; print_r($data);
    //     if ($data) {
	// 		foreach ($data as $key => $value) {

    //             $this->M_pengembalianbrg->createMo($fromsub, $fromloc, $data['SUBINV'], $data['LOCATOR'], $ip_address, $data['NO_MO'], $user_id);
        
    //             $this->M_pengembalianbrg->deleteTemp($ip_address, $data['NO_MO']);
    //         }
	// 	}

    //     if ($array_mo) {
	// 		$this->pdf($array_mo);
	// 	}else{
	// 		exit('Terjadi Kesalahan :(');
    //     }
    // }

    public function pdfSeksi($array_mo2){
        // echo "<pre>"; print_r($array_mo2);exit();
        $array_mo = array();
        foreach ($array_mo2 as $key => $val) {
			$no_mo = $val['NO_MO'];
			array_push($array_mo, $no_mo);
        }

        $temp_filename = array();
        foreach ($array_mo as $key => $mo) {
            $moveOrder = $mo;

            $data = $this->M_pengembalianbrg->getDataMo($moveOrder);

            // ------ GENERATE QRCODE ------
            if(!is_dir('./assets/img')){
                mkdir('./assets/img', 0777, true);
                chmod('./assets/img', 0777);
            }

            foreach ($data as $v) {
                $params['data']		= $v['NO_BTAG'];
                $params['level']	= 'H';
                $params['size']		= 3;
                $config['black']	= array(224,255,255);
                $config['white']	= array(70,130,180);
                $params['savename'] = './assets/img/'.$v['NO_BTAG'].'.png';
                $this->ciqrcode->generate($params);
                array_push($temp_filename, $params['savename']);
            }
        }

        // ------ GENERATE PDF ------
        $this->load->library('Pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8','A5-L', 0, '', 3, 3, 3, 3, 3, 3);	
        $filename = 'MO Reject_'.time().'.pdf';

        $a = 1;
		foreach ($array_mo as $key => $mo) {
            $moveOrder = $mo;

            $dataall[$a] = $this->M_pengembalianbrg->getDataMoSeksi($moveOrder);

            $a++;
        }
        
        // echo "<pre>"; print_r($dataall); exit();

        foreach ($dataall as $key => $value) {
            // echo "<pre>";print_r($value);exit();
            $data['datalist'] = $value;
            $data['tanggal'] = date('d-M-Y');

            if ($value[0]['TO_SUBINVENTORY_CODE'] == 'DMC') {
                $Header 	= $this->load->view('PengembalianBarangGudang/V_Header', $data,true);
                $Content 	= $this->load->view('PengembalianBarangGudang/V_Content', $data,true);
                $Footer 	= $this->load->view('PengembalianBarangGudang/V_Footer', $data,true);
                $pdf->WriteHTML($Header);
                $pdf->WriteHTML($Content);
                $pdf->WriteHTML($Footer);
            } else {
                $Header 	= $this->load->view('PengembalianBarangGudang/V_Header_Reject', $data,true);
                $Content 	= $this->load->view('PengembalianBarangGudang/V_Content_Reject', $data,true);
                $Footer 	= $this->load->view('PengembalianBarangGudang/V_Footer_Reject', $data,true);
                $pdf->WriteHTML($Header);
                $pdf->WriteHTML($Content);
                $pdf->WriteHTML($Footer);
            }
        }

        // echo "<pre>"; print_r($data); exit();

        $pdf->Output($filename, 'I');

        if (!empty($temp_filename)) {
            foreach ($temp_filename as $tf) {
                if(is_file($tf)){
                    unlink($tf);
                }
            }
        }
    }
    // create mo per 1 item
    // public function CreateMoSeksi($id_pengembalian){
    //     $user_id = $this->session->user;
    //     $getData = $this->M_pengembalianbrg->getPengembalian($id_pengembalian);
    //     $ip_address =  $this->input->ip_address();
    //     $kodekomp = $getData[0]['KODE_KOMPONEN'];
    //     $fromsub = 'REJECT-DM';
    //     $fromloc = 785; //KOM-TKS REJ
    //     $tosub = $getData[0]['SUBINV_PENERIMA_BARANG'];
    //     $toloc = $getData[0]['LOCATOR_PENERIMA_BARANG'];
    //     // print_r($toloc); exit();

    //     $checkMoSeksi = $this->M_pengembalianbrg->checkMoSeksi($id_pengembalian);
    //     // print_r($checkMoSeksi); exit();
    //     $array_mo = array();

    //     if (count($checkMoSeksi) > 0) {
    //         foreach ($checkMoSeksi as $key => $value) {
	// 			$no_mo = $value;
	// 			array_push($array_mo, $no_mo);
	// 			//tinggal cetak jika sudah ada mo
	// 		}
	// 		$this->pdf($array_mo);
    //     }else{
    //         $getAtt = $this->M_pengembalianbrg->getAtt($id_pengembalian, $fromsub, $fromloc);
    //         $io = $getAtt[0]['ORGANIZATION_ID'];
    //         $noMo = $this->M_pengembalianbrg->getNoMo();
    //         // $no_mo = $noMo[0]['NO_MO'];
    //         // print_r($getAtt); exit();

    //         if ($getAtt[0]['ATT'] > $getData[0]['QTY_KOMPONEN']){
    //             $data = array(
    //                 'NO_URUT' => '1',
    //                 'INVENTORY_ITEM_ID' => $getAtt[0]['INVENTORY_ITEM_ID'],
    //                 'QUANTITY' => $getData[0]['QTY_KOMPONEN'],
    //                 'UOM' => $getAtt[0]['PRIMARY_UOM_CODE'],
    //                 'IP_ADDRESS' => $ip_address,
    //                 'NO_MO' => $noMo[0]['NO_MO'],
    //                 'DESCRIPTION' => $getData[0]['ALASAN_PENGEMBALIAN']
    //             );
    //             // echo "<pre>"; print_r($data);exit();
    //             $this->M_pengembalianbrg->createTemp($data);

    //             $this->M_pengembalianbrg->createMo($fromsub, $fromloc, $tosub, $toloc, $ip_address, $data['NO_MO'], $user_id);

    //             // $this->M_pengembalianbrg->AllocateMo($data['NO_MO'], $io, $data['INVENTORY_ITEM_ID'], $data['QUANTITY']);

    //             $this->M_pengembalianbrg->UpdateMoSeksi($id_pengembalian, $data['NO_MO']);

    //             $this->M_pengembalianbrg->deleteTemp($ip_address, $data['NO_MO']);

    //             $checkMoSeksi = $this->M_pengembalianbrg->checkMoSeksi($id_pengembalian);

    //             foreach ($checkMoSeksi as $key => $value) {
    //                 $no_mo = $value;
    //                 array_push($array_mo, $no_mo);
    //                 //tinggal cetak jika sudah ada mo

    //                 // exit();echo "<pre>"; print_r($array_mo);exit();
    //             }
    //         }
            
    //         if ($array_mo) {
    //             $this->pdf($array_mo);
    //         }else{
    //             exit('Terjadi Kesalahan :(');
    //         }
    //     }
    // }
    
}

?>