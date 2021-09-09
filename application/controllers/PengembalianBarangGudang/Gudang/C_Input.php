<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Input extends CI_Controller {
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

        $data['Title'] = 'Input Pengembalian Barang';
        $data['Menu'] = 'Input';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PengembalianBarangGudang/V_Input');
        $this->load->view('V_Footer',$data);
    }

    public function getTipeProduk(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_pengembalianbrg->getTipeProduk($term);
        echo json_encode($data);
    }
    
    public function getKodeKomponen(){
        $kode_produk = $this->input->get('kode_produk');
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_pengembalianbrg->getKodeKomponen($kode_produk, $term);
        echo json_encode($data);
    
    }

    public function getPic(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_pengembalianbrg->getPic($term);
        echo json_encode($data);
    }

    public function InputPengembalian(){
        $proses_assembly = $this->input->post('proses_assembly');
        $kode_komponen = $this->input->post('kode_komponen');
        $qty_komponen = $this->input->post('qty_komponen');
        $alasan_pengembalian = $this->input->post('alasan_pengembalian');
        $pic_assembly = $this->input->post('pic_assembly');
        $pic_gudang = $this->input->post('pic_gudang');
        $tgl_input = gmdate("Y/m/d H:i:s", time()+60*60*7);
        $status_verifikasi = 'Belum Verifikasi';
        $mo_rej = 0;
        $mo_seksi = 0;
        // print_r($kode_komponen); exit();

        $data = [
            'proses_assembly' => $proses_assembly,
            'kode_komponen' => $kode_komponen,
            'qty_komponen' => $qty_komponen,
            'alasan_pengembalian' => $alasan_pengembalian,
            'pic_assembly' => $pic_assembly,
            'pic_gudang' => $pic_gudang,
            'tgl_input' => $tgl_input,
            'status_verifikasi' => $status_verifikasi,
            'mo_rej' => $mo_rej,
            'mo_seksi' => $mo_seksi
        ];

        // print_r($data); exit();

        $this->M_pengembalianbrg->InputPengembalian($data);
        // redirect(base_url("PengembalianBarangGudang/Input"));
    }

    public function getDataInput(){
        $data['user'] = $this->session->user;
        // print_r($data['user']); exit();
        $data['input'] = $this->M_pengembalianbrg->getDataInput();
        // print_r($data['input']); exit();
        $this->load->view('PengembalianBarangGudang/V_Ajax_Input', $data);
    }

    public function UpdateStatusVerif(){
		$id_pengembalian = $this->input->post('id_pengembalian');
        $status_verifikasi = $this->input->post('status_verifikasi');
        $tgl_order_verif = gmdate("Y/m/d H:i:s", time()+60*60*7);
		
		if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang !!";
        } else {
            $response = $this->M_pengembalianbrg->UpdateStatusVerif($id_pengembalian, $status_verifikasi, $tgl_order_verif);
			echo json_encode($response);
		}
    }

    public function EmailQC($id_pengembalian){
        // print_r($id_pengembalian); exit();
        $getData = $this->M_pengembalianbrg->getData($id_pengembalian);
        // print_r($getData); exit();

        $getEmail = $this->M_pengembalianbrg->getEmailQC();
        $UserEmail = $getEmail[0]['email'];

        $link = base_url("VerifikasiPengembalianBarang/Verifikasi");

        $mail = new PHPMailer();
		$mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        
        $mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;
		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
        $mail->addAddress($UserEmail);
        
        $isi = 'Pengajuan Order Verifikasi QC, dengan detail berikut :<br/>
        Kode Komponen &nbsp;: '.$getData[0]['KODE_KOMPONEN'].'<br/>
        Nama Komponen &nbsp;: '.$getData[0]['NAMA_KOMPONEN'].'<br/>
        Qty Komponen &nbsp;: '.$getData[0]['QTY_KOMPONEN'].'<br/>
        Kasus &nbsp;: '.$getData[0]['ALASAN_PENGEMBALIAN'].'<br/>
        Mohon untuk memberikan hasil verifikasi dalam waktu max 2x24 jam<br/><br/>
        Klik link untuk memberikan hasil verifikasi <a href="'.$link.'" >disini</a>.
        <br/>';

        $mail->Subject = 'Pengajuan Order Verifikasi QC';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			$result = "Error";
		} else {
			$result = "Success";
			echo json_encode($result);
		}
    }

    public function createallMORej(){
        // echo "<pre>"; print_r ($_POST); exit();
        $user_id = $this->session->user;
        $ip_address =  $this->input->ip_address();
        $id_pengembalian 	= $this->input->post('id_pengembalian2');
        $tipe_produk 	= $this->input->post('tipe_produk');
        $id_komponen 	= $this->input->post('id_komponen');
        $kode_komponen 	= $this->input->post('kode_komponen');
        $nama_komponen 	= $this->input->post('nama_komponen');
        $qty_komponen 	= $this->input->post('qty_komponen');
        $uom 	= $this->input->post('uom');
        $alasan_pengembalian 	= $this->input->post('alasan_pengembalian');
        $pic_assembly 	= $this->input->post('pic_assembly');
        $pic_gudang 	= $this->input->post('pic_gudang');
        $status_verifikasi 	= $this->input->post('status_verifikasi');
        $selected = $this->input->post('selectedKompPBG2');
        $arraySelected = explode('+', $selected);
        $fromsub = 'DMC';
        $fromloc = 1432; //KOM-DMC
        $tosub = 'REJECT-DM';
        $toloc = 785; //KOM-TKS REJ
        // print_r($id_komponen); exit();

        $noMo = $this->M_pengembalianbrg->getNoMo();

        // print_r($arraySelected); exit();
        
        $array_mo = array();

        $no = 1;
        foreach ($id_pengembalian as $key => $value) {
            if (in_array($value, $arraySelected)){
                // print_r($value); exit();
                $checkMoRej = $this->M_pengembalianbrg->checkMoRej($value);
                // $no_mo = $checkMoRej[0]['NO_MO'];
                // print_r($checkMoRej); exit();
                if (count($checkMoRej) > 0) {
                    foreach ($checkMoRej as $keymo => $valuemo) {
                        $no_mo = $valuemo;
                        // array_push($array_mo, $no_mo);
                        // pengecekan supaya pdfnya ga double
                        if(in_array($no_mo, $array_mo)){
                                
                        }else{
                            array_push($array_mo, $no_mo);
                        }
                    }
                }else{
                    $getAtt = $this->M_pengembalianbrg->getAtt($value, $fromsub, $fromloc);
                    $errQty = array();
                    foreach ($getAtt as $kQty => $vQty) {
                        if ($vQty['QTY_KOMPONEN'] > $vQty['ATT']){
                            $err = 1;
                        }else{
                            $err = 0;
                        }
                        $errQty[] = $err;
                    }

                    if (!in_array(1, $errQty)) {
                        $data = array(
                            'NO_URUT' => $no,
                            'INVENTORY_ITEM_ID' => $id_komponen[$key],
                            'QUANTITY' => $qty_komponen[$key],
                            'UOM' => $uom[$key],
                            'IP_ADDRESS' => $ip_address,
                            'NO_MO' => $noMo[0]['NO_MO']
                        );
                        // echo "<pre>"; print_r($data);exit();
                    }
                    // echo "<pre>"; print_r($data);exit();
                    $this->M_pengembalianbrg->createTemp($data);

                    $this->M_pengembalianbrg->UpdateMoRej($value, $noMo[0]['NO_MO']);

                    $checkMoRej = $this->M_pengembalianbrg->checkMoRej($value);
                    
                    // seharusnya ini setelah hapus temp
                    foreach ($checkMoRej as $keymo => $valuemo) {
                        $no_mo = $valuemo;
                        // array_push($array_mo, $no_mo);
                        // pengecekan supaya pdfnya ga double
                        if(in_array($no_mo, $array_mo)){
                                
                        }else{
                            array_push($array_mo, $no_mo);
                        }
                    }

                    $no++;
                    
                }
            }
        }

        if ($data) {
			foreach ($data as $key => $value) {
                $this->M_pengembalianbrg->createMo($fromsub, $fromloc, $tosub, $toloc, $ip_address, $data['NO_MO'], $user_id);
        
                $this->M_pengembalianbrg->deleteTemp($ip_address, $data['NO_MO']);
            }
		}
        
        // echo "<br>"; print_r($array_mo); exit();

        if ($array_mo) {
			$this->pdf($array_mo);
		}else{
			exit('Terjadi Kesalahan :(');
        }
        
        // -------------------- Tanpa Create PDF --------------------

        // $noMo = $this->M_pengembalianbrg->getNoMo();

        // // print_r($arraySelected); exit();
        
        // $array_mo = array();

        // $no = 1;
        // foreach ($id_pengembalian as $key => $value) {
        //     if (in_array($value, $arraySelected)){
        //         $checkMoRej = $this->M_pengembalianbrg->checkMoRej($value);
        //         if (count($checkMoRej) > 0) {
        //             foreach ($checkMoRej as $keymo => $valuemo) {
        //                 $no_mo = $valuemo;
        //                 array_push($array_mo, $no_mo);
        //             }
        //         }else{
        //             $getAtt = $this->M_pengembalianbrg->getAtt($value, $fromsub, $fromloc);
        //             $errQty = array();
        //             foreach ($getAtt as $kQty => $vQty) {
        //                 if ($vQty['QTY_KOMPONEN'] > $vQty['ATT']){
        //                     $err = 1;
        //                 }else{
        //                     $err = 0;
        //                 }
        //                 $errQty[] = $err;
        //             }

        //             if (!in_array(1, $errQty)) {
        //                 $data = array(
        //                     'NO_URUT' => $no,
        //                     'INVENTORY_ITEM_ID' => $id_komponen[$key],
        //                     'QUANTITY' => $qty_komponen[$key],
        //                     'UOM' => $uom[$key],
        //                     'IP_ADDRESS' => $ip_address,
        //                     'NO_MO' => $noMo[0]['NO_MO']
        //                 );
        //             }
        //             // echo "<pre>"; print_r($data);exit();
        //             $this->M_pengembalianbrg->createTemp($data);

        //             $this->M_pengembalianbrg->UpdateMoRej($value, $noMo[0]['NO_MO']);

        //             $no++;
        //         }
        //     }
        // }
        // // echo "<pre>"; print_r($data);exit();

        // foreach ($data as $key => $value) {
        //     $this->M_pengembalianbrg->createMo($fromsub, $fromloc, $tosub, $toloc, $ip_address, $data['NO_MO'], $user_id);

        //     $this->M_pengembalianbrg->deleteTemp($ip_address, $data['NO_MO']);
        // }

    }

    public function pdf($array_mo2){
        // echo "<pre>"; print_r($array_mo2);exit();
        $array_mo = array();
        foreach ($array_mo2 as $key => $val) {
			$no_mo = $val['NO_MO'];
			array_push($array_mo, $no_mo);
        }
        // echo "<pre>"; print_r($array_mo);exit();
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

            $dataall[$a] = $this->M_pengembalianbrg->getDataMo($moveOrder);

            $a++;
        }
        
        // echo "<pre>"; print_r($dataall); exit();

        foreach ($dataall as $key => $value) {
            // echo "<pre>";print_r($value);exit();
            $data['datalist'] = $value;
            $data['tanggal'] = date('d-M-Y');

            $Header 	= $this->load->view('PengembalianBarangGudang/V_Header', $data,true);
            $Content 	= $this->load->view('PengembalianBarangGudang/V_Content', $data,true);
            $Footer 	= $this->load->view('PengembalianBarangGudang/V_Footer', $data,true);
            $pdf->WriteHTML($Header);
            $pdf->WriteHTML($Content);
            $pdf->WriteHTML($Footer);
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

    public function deleteIputan(){
        $id_pengembalian	= $this->input->post('id_pengembalian');
        // echo "<pre>"; print_r($id_pengembalian); exit();

        $this->M_pengembalianbrg->deleteInputan($id_pengembalian);
    }

}

?>