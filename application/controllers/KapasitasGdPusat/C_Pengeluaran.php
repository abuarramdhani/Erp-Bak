<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class C_Pengeluaran extends CI_Controller{
        function __construct(){
            parent::__construct();
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->helper('html');
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->library('encrypt');

            $this->load->model('SystemAdministration/MainMenu/M_user');
            $this->load->model('KapasitasGdPusat/M_pengeluaran');
            
            $this->checkSession();
        }

        public function checkSession(){
            if($this->session->is_logged){

            } else {
                redirect('');
            }
        }

        //------------------------------ Menu PENGELUARAN ----------------------------------------------------
        public function Pengeluaran(){
            $user = $this->session->username;
            $user_id = $this->session->userid;

            $data['Title'] = 'Pengeluaran Gudang Utara';
            $data['Menu'] = 'Pengeluaran';
            $data['SubMenuOne'] = '';
            $data['SubMenuTwo'] = '';

            $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
            $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
            $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('KapasitasGdPusat/V_Pengeluaran');
            $this->load->view('V_Footer',$data);
        }

        public function cek_data(){
            $subinv = $this->input->post('subinv');
            $no_dokumen = $this->input->post('no_dokumen');
            // echo "<pre>";print_r($no_dokumen);exit();

            $cekdokumen = $this->M_pengeluaran->cekdokumen($subinv, $no_dokumen);
            $cekdokumen2 = $this->M_pengeluaran->getCek($subinv, $no_dokumen);

            if ($cekdokumen != null) {
                $data['ket1'] = 'No Dokumen sudah ada';
                $data['ket2'] = null;
                $data['cek'] = $this->M_pengeluaran->getCek($subinv, $no_dokumen);
            }else if ($cekdokumen2 == null) {
                $data['ket1'] = null;
                $data['ket2'] = 'Dokumen tidak ditemukan';
                $data['cek'] = $this->M_pengeluaran->getCek($subinv, $no_dokumen);
            }else{
                $data['ket1'] = null;
                $data['ket2'] = null;
                $data['cek'] = $this->M_pengeluaran->getCek($subinv, $no_dokumen);
            }

            $this->load->view('KapasitasGdPusat/V_TblPengeluaran', $data);
        }

        public function input_data(){
            $NO_DOKUMEN     = $this->input->post('no_dokumen');
            $JENIS_DOKUMEN	= $this->input->post('jenis_dokumen');
            $GUDANG			= $this->input->post('subinv');
            $ITEM	        = $this->input->post('item');
            $DESC	        = $this->input->post('desc');
            $QTY            = $this->input->post('qty');
            // $JUMLAH_ITEM    = count($ITEM);
            $CREATION_DATE	= gmdate("Y/m/d H:i:s", time()+60*60*7);

            foreach ($ITEM as $key => $l) {
                $data = [
                    'NO_DOKUMEN' => $NO_DOKUMEN,
                    'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                    'GUDANG' => $GUDANG,
                    'ITEM' => $ITEM[$key],
                    'DESC' => $DESC[$key],
                    'QTY' => $QTY[$key],
                    'CREATION_DATE' => $CREATION_DATE,
                ];
                $this->M_pengeluaran->save($data);
            }

            // $this->M_pengeluaran->save($NO_DOKUMEN, $JENIS_DOKUMEN, $GUDANG, $ITEM, $DESC, $QTY, $CREATION_DATE);
            
            redirect(base_url("KapasitasGdPusat/Pengeluaran"));
        }

        public function get_data_pengeluaran(){
            $data['get_data'] = $this->M_pengeluaran->getData();
            $this->load->view('KapasitasGdPusat/V_Ajax_Pengeluaran', $data);
        }

        public function getPIC(){
            $term = $this->input->get('term',TRUE);
            $term = strtoupper($term);
            $data = $this->M_pengeluaran->getPIC($term);
            echo json_encode($data);
        }

        public function getMulai(){
            $date 	        = $this->input->post('date');
            $jenis_dokumen	= $this->input->post('jenis_dokumen');
            $no_dokumen 	= $this->input->post('no_dokumen');
            $pic 	        = $this->input->post('pic');
            
            $cek = $this->M_pengeluaran->cekMulai($no_dokumen, $jenis_dokumen);
            if ($cek[0]['WAKTU'] == '') {
                $this->M_pengeluaran->SavePengeluaran($date, $jenis_dokumen, $no_dokumen, $pic);
            }
        }

        // public function getSelesai(){
        //     $date           = $this->input->post('date');
        //     $jenis_dokumen  = $this->input->post('jenis_dokumen');
        //     $no_dokumen     = $this->input->post('no_dokumen');
        //     $mulai          = $this->input->post('mulai');
        //     $selesai        = $this->input->post('waktu');
        //     $pic            = $this->input->post('pic');

        //     // echo "<pre>";print_r($date);exit();

        //     $cek = $this->M_pengeluaran->cekMulai($no_dokumen, $jenis_dokumen);
        //     if ($cek[0]['WAKTU'] == '') {
        //         $waktu1 	= strtotime($mulai);
        //         $waktu2 	= strtotime($selesai);
        //         $selisih 	= ($waktu2 - $waktu1);
        //         $jam 		= floor($selisih/(60*60));
        //         $menit 		= $selisih - $jam * (60 * 60);
        //         $htgmenit 	= floor($menit/60) * 60;
        //         $detik 		= $menit - $htgmenit;
        //         $slsh 		= $jam.':'.floor($menit/60).':'.$detik;
        //     }else {
        //         $a 			= explode(':', $cek[0]['WAKTU']);
        //         $jamA 		= $a[0] * 3600;
        //         $menitA 	= $a[1] * 60;
        //         $waktuA 	= $jamA + $menitA + $a[2];
    
        //         $waktu1 	= strtotime($mulai);
        //         $waktu2 	= strtotime($selesai);
        //         $waktuB 	= ($waktu2 - $waktu1);
        //         $jumlah 	= $waktuA + $waktuB;
        //         $jam 		= floor($jumlah/(60*60));
        //         $menit 		= $jumlah - $jam * (60 * 60);
        //         $htgmenit 	= floor($menit/60) * 60;
        //         $detik 		= $menit - $htgmenit;
        //         $slsh 		= $jam.':'.floor($menit/60).':'.$detik;
        //     }

        //     $this->M_pengeluaran->SelesaiPengeluaran($date, $jenis_dokumen, $no_dokumen, $slsh, $pic);
        // }

        public function deleteDokumen(){
            $jenis_dokumen	= $this->input->post('jenis_dokumen');
            $no_dokumen 	= $this->input->post('no_dokumen');

            $this->M_pengeluaran->deleteDokumen($jenis_dokumen, $no_dokumen );
        }

        public function getSelesai2(){
            $date           = $this->input->post('date');
            $jenis_dokumen	= $this->input->post('jenis_dokumen');
            $no_dokumen 	= $this->input->post('no_dokumen');
            $mulai 	        = $this->input->post('mulai');
            $selesai        = $this->input->post('waktu');
            $pic 	        = $this->input->post('pic');
            $jml 	        = $this->input->post('j');
            // echo "<pre>";print_r($jml);exit();
    
            $cek = $this->M_pengeluaran->cekMulai($no_dokumen, $jenis_dokumen);
            if ($cek[0]['WAKTU'] == '') {
                $waktu1 	= strtotime($mulai);
                $waktu2 	= strtotime($selesai);
                $selisih 	= ($waktu2 - $waktu1)/$jml;
                $jam 		= floor($selisih/(60*60));
                $menit 		= $selisih - $jam * (60 * 60);
                $htgmenit 	= floor($menit/60) * 60;
                $detik 		= floor($menit - $htgmenit);
                $slsh 		= $jam.':'.floor($menit/60).':'.$detik;
            }else {
                $a 			= explode(':', $cek[0]['WAKTU']);
                $jamA 		= $a[0] * 3600;
                $menitA 	= $a[1] * 60;
                $waktuA 	= $jamA + $menitA + $a[2];
    
                $waktu1 	= strtotime($mulai);
                $waktu2 	= strtotime($selesai);
                $waktuB 	= ($waktu2 - $waktu1)/$jml;
                $jumlah 	= $waktuA + $waktuB;
                $jam 		= floor($jumlah/(60*60));
                $menit 		= $jumlah - $jam * (60 * 60);
                $htgmenit 	= floor($menit/60) * 60;
                $detik 		= floor($menit - $htgmenit);
                $slsh 		= $jam.':'.floor($menit/60).':'.$detik;
            }
            
            $this->M_pengeluaran->SelesaiPengeluaran($date, $jenis_dokumen, $no_dokumen, $slsh, $pic);
        }

        public function getDetail(){
            $no_dokumen = $this->input->post('no_dokumen');
            // $detail = $this->M_pengeluaran->dataDetail($no_dokumen);
            // echo "<pre>";print_r($detail);exit();
            if(sizeof($no_dokumen) == 1){
                $no_dokumen = $this->input->post('no_dokumen');
                $data['detail'] = $this->M_pengeluaran->dataDetail($no_dokumen);
                $this->load->view('KapasitasGdPusat/V_Ajax_Detail1', $data);
            }else{
                $hasil = array();
                for ($i= 0; $i<sizeof($no_dokumen) ; $i++) { 
                    $detail = $this->M_pengeluaran->dataDetail($no_dokumen[$i]);

                    array_push($hasil, $detail);
                }
                $data['detail'] = $hasil;
                $this->load->view('KapasitasGdPusat/V_Ajax_Detail_Checked', $data);
            }
        }

        public function getDetailItem(){
            $no_dokumen = $this->input->post('no_dokumen');

            $data['detail'] = $this->M_pengeluaran->dataDetailItem($no_dokumen);
            // // echo "<pre>";print_r($data['detail']);exit();

            $this->load->view('KapasitasGdPusat/V_Ajax_Detail_Item', $data);
        }

        public function hpsDetailDok(){
            $no_dokumen 	= $this->input->post('no_dokumen');
            $item	= $this->input->post('item');

            $this->M_pengeluaran->hpsDetailDok($no_dokumen, $item);
        }

        public function editQty(){
            $no_dokumen 	= $this->input->post('no_dokumen');
            $item	= $this->input->post('item');
            $qty	= $this->input->post('qty');

            $this->M_pengeluaran->editQty($no_dokumen, $item, $qty);
        }

        //------------------------------------- Menu MONITORING PENGELUARAN -------------------------------------
        public function MonitoringPengeluaran(){
            $user = $this->session->username;
            $user_id = $this->session->userid;

            $data['Title'] = 'Monitoring Pengeluaran Gudang Utara';
            $data['Menu'] = 'Monitoring Pengeluaran';
            $data['SubMenuOne'] = '';
            $data['SubMenuTwo'] = '';

            $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
            $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
            $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('KapasitasGdPusat/V_MonPengeluaran');
            $this->load->view('V_Footer',$data);
        }
        
        public function getMonPengeluaran(){
            $search         = $this->input->post('search_by');
            $no_dokumen	    = $this->input->post('no_dokumen');
            $jenis_dokumen	= $this->input->post('jenis_dokumen');
            $tglAwal		= $this->input->post('tglAwal');
            $tglAkhir		= $this->input->post('tglAkhir');
            $pic			= $this->input->post('pic');
            // $item			= $this->input->post('item');
            $subinv			= $this->input->post('subinv');
            $data['searchby'] = $search;

            // echo "<pre>";print_r ($subinv);exit();

            // if ($search == 'export') {
            //     $dataExport = $this->M_pengeluaran->getExport($jenis_dokumen, $tglAwal, $tglAkhir, $subinv);
            //     // echo "<pre>";print_r ($dataGET);exit();
                
            //     $a= 0;
            //     $array_sudah = array();
            //     $array_terkelompok = array();
            //     foreach ($dataExport as $key => $value) {
            //         if (!in_array($value['NO_DOKUMEN'], $array_sudah)) {
            //             array_push($array_sudah, $value['NO_DOKUMEN']);
            //             $cari = $this->detail($value);
            //             $getDetail = $cari['getDetail'];
            //             $status = $cari['status'];
            //             $a++;
            //             $array_terkelompok[$value['NO_DOKUMEN']]['header'] = $value;
            //             $array_terkelompok[$value['NO_DOKUMEN']]['header']['statusket'] = $status;
            //             $array_terkelompok[$value['NO_DOKUMEN']]['detail'] = $getDetail;
            //         }
            //     }
            //     $data['value'] = $array_terkelompok;

            //     $this->load->view('KapasitasGdPusat/V_Result', $data);
            // }else{
                $dataMon = $this->M_pengeluaran->getMonPengeluaran($no_dokumen, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $subinv);
                // echo "<pre>";print_r ($dataMon);exit();
                // pengelompokan data
                $a= 0;
                $array_sudah = array();
                $array_terkelompok = array();
                foreach ($dataMon as $key => $value) {
                    if (!in_array($value['NO_DOKUMEN'], $array_sudah)) {
                        array_push($array_sudah, $value['NO_DOKUMEN']);
                        $cari = $this->detail($value);
                        $getDetail = $cari['getDetail'];
                        $status = $cari['status'];
                        $a++;
                        $array_terkelompok[$value['NO_DOKUMEN']]['header'] = $value;
                        $array_terkelompok[$value['NO_DOKUMEN']]['header']['statusket'] = $status;
                        $array_terkelompok[$value['NO_DOKUMEN']]['detail'] = $getDetail;
                    }
                }
                $data['value'] = $array_terkelompok;
            
                // if ($search == "belumterlayani") {
                //     $this->load->view('KapasitasGdPusat/V_Result2', $data);
                // }else{
                    $this->load->view('KapasitasGdPusat/V_TblMonPengeluaran', $data);
                // }
            // }

        }

        public function detail($value){
            $cari = array();
            $cari['getDetail'] = $this->M_pengeluaran->getDetail($value['NO_DOKUMEN']);

            if ($value['JENIS_DOKUMEN'] == 'PICKLIST') {
                $getKet = $this->M_pengeluaran->getKetPicklist($value['NO_DOKUMEN']);
            }elseif ($value['JENIS_DOKUMEN'] == 'BON') {
                $getKet = $this->M_pengeluaran->getKetBon($value['NO_DOKUMEN']);
            }elseif ($value['JENIS_DOKUMEN'] == 'MO') {
                $getKet = $this->M_pengeluaran->getKetMo($value['NO_DOKUMEN']);
            }elseif ($value['JENIS_DOKUMEN'] == 'IO') {
                $getKet = $this->M_pengeluaran->getKetIo($value['NO_DOKUMEN']);
            }elseif ($value['JENIS_DOKUMEN'] == 'DO') {
                $getKet = $this->M_pengeluaran->getKetDo($value['NO_DOKUMEN']);
            }

            $hitung_bd = count($cari['getDetail']);
            $hitung_ket = count($getKet);
            if ($hitung_bd <= $hitung_ket) {
				$cari['status']= 'Sudah terlayani';
			} else {
				$cari['status'] = 'Belum terlayani';
            }
            
            return $cari;
        }

    }
?>