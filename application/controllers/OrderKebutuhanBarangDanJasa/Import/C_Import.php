<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Import extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('encrypt');
        $this->load->library('Excel');
        //load the login model
        $this->load->library('session');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
        $this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
        $this->load->model('OrderKebutuhanBarangDanJasa/Import/M_import');


        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }

        if ($this->session->is_logged == FALSE) {
            redirect();
        }

        date_default_timezone_set("Asia/Bangkok");
    }

    public function UploadProcess()
    {
        $fileName     = $_FILES['userfile']['name'];
        $config['upload_path']         = ('./assets/upload/Okebaja/import/');
        $config['file_name']        = $fileName;
        $config['allowed_types']    = 'xls|xlsx|csv';
        $config['max_size']            = 20480;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('userfile')) {
            $error = $this->upload->display_errors();
            $message = '<div class="row">' . $error . '</div>';
            echo $message;
        } else {
            $media    = $this->upload->data();
            $inputFileName     = './assets/upload/Okebaja/import/' . $media['file_name'];
            // print_r($inputFileName);
            // exit();

            if (is_file($inputFileName)) {
                // echo('ada');
                chmod($inputFileName, 0777); ## this should change the permissions
            } else {
                // echo('nothing');
            }

            try {
                $inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
                $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $sheet              = $objPHPExcel->getSheet(0);
            $highestRow         = $sheet->getHighestRow();
            $highestColumn  = $sheet->getHighestColumn();
            $errStock           = 0;
            $delCheckPoint  = 0;
            $errSection         = '';
            $errEmpty         = '';
            $data['AllData'] = $highestRow;
            $data['success'] = 0;
            $data['failed'] = 0;
            $data['itemNotExist'] = NULL;
            $itemNotExis = array();

            $data['item_oke'] = array();
            $data['item_not_oke'] = array();

            for ($row = 3; $row <= $highestRow; $row++) {
                $itemCode = $sheet->getCell('A' . $row);
                $qty = $sheet->getCell('B' . $row);
                $uom = $sheet->getCell('C' . $row);
                $nbde = $sheet->getCell('D' . $row)->getValue();
                $needby_date = PHPExcel_Shared_Date::ExcelToPHP($nbde);
                $nbd = date('d/m/Y', $needby_date);
                $destinationType = $sheet->getCell('E' . $row);
                $organization = $sheet->getCell('F' . $row);
                $location = $sheet->getCell('G' . $row);
                $subinventory = $sheet->getCell('H' . $row);
                $alasanOrder = $sheet->getCell('I' . $row);
                $alasanUrgensi = $sheet->getCell('J' . $row);
                $noteToPengelola = $sheet->getCell('K' . $row);

                $urgentFlag = 'N';

                $note = '';


                $validasi = $this->M_import->validasiLengkap($itemCode, $organization, $subinventory);

                if (!$validasi) {
                    $note .= '- Item tidak dapat diproses karena item bukan item inventory, atau organization salah/tidak tersedia untuk item ini, dan atau subinventory salah/tidak tersedia untuk item ini';
                    $org_id = '';
                } else if ($validasi[0]['PULLER'] == null) {
                    $note .= 'Item Belum di Set';
                } else if (strlen($noteToPengelola) > 470) {
                    $note .= 'Note to Pengelola terlalu Panjang, maksimal 470 karakter';
                } else {
                    $inv_item_id = $validasi[0]['INVENTORY_ITEM_ID'];
                    if ($uom != $validasi[0]['PRIMARY_UOM'] && $uom != $validasi[0]['SECONDARY_UOM']) {
                        $note .= '- UOM salah / tidak cocok<br>';
                    }

                    if ($destinationType != 'INVENTORY') {
                        $note .= '- Destination Type harus INVENTORY<br>';
                    }

                    if ($organization == 'OPM') {
                        $org_id = 101;
                    } elseif ($organization == 'ODM') {
                        $org_id = 102;
                    } elseif ($organization == 'IDM') {
                        $org_id = 122;
                    } elseif ($organization == 'IPM') {
                        $org_id = 286;
                    }

                    if (!$qty) {
                        $note .= '- Quantity harus terisi';
                    }

                    if (!$nbd) {
                        $note .= '- NBD harus terisi';
                    } else {
                        $nebd = str_replace('/', '-', $nbd);

                        $tanggalUser = strtotime($nebd);

                        if ($validasi) {
                            $estimasi = strtotime($validasi[0]['DEFAULT_NBD']);

                            if ($tanggalUser < $estimasi) {
                                if ($alasanUrgensi == '') {
                                    $note .= '- Order berstatus Urgent, Alasan Urgensi wajib diisi!';
                                } else {
                                    $urgentFlag = 'Y';
                                }
                            }
                        }
                    }

                    $validasi_lokasi = $this->M_import->validasi_lokasi($location);

                    if (!$validasi_lokasi) {
                        $note .= 'Lokasi Tidak Ditemukan';
                        $loc_id = '';
                    } else {
                        $loc_id = $validasi_lokasi[0]['LOCATION_ID'];
                    }

                    // if ($location != 'Yogyakarta' && $location != 'Tuksono') {
                    //     $note .= '- Location harus Yogyakarta atau Tuksono<br>';
                    //     $loc_id = '';
                    // } else if ($location == 'Yogyakarta') {
                    //     $loc_id = 142;
                    // } else if ($organization == 'Tuksono') {
                    //     $loc_id = 16103;
                    // }
                }

                if ($note == '') {
                    $notes = 'Order ini dapat diproses';
                    $item = array(
                        'item_code' => $itemCode,
                        'inv_item_id' => $validasi[0]['INVENTORY_ITEM_ID'],
                        'deskripsi' => $validasi[0]['DESCRIPTION'],
                        'qty' => $qty,
                        'uom' => $uom,
                        'nbd' => $nebd,
                        'destination_type' => $destinationType,
                        'organization' => $organization,
                        'org_id' => $org_id,
                        'location' => $location,
                        'loc_id' => $loc_id,
                        'subinventory' => $subinventory,
                        'alasan_order' => $alasanOrder,
                        'alasan_urgensi' => $alasanUrgensi,
                        'note_to_pengelola' => $noteToPengelola,
                        'notes' => $notes,
                        'urgent_flag' => $urgentFlag,
                        'cut_off' => $validasi[0]['CUTOFF_TERDEKAT']

                    );

                    array_push($data['item_oke'], $item);
                } else {
                    $notes = $note;
                    $item = array(
                        'item_code' => $itemCode,
                        'qty' => $qty,
                        'uom' => $uom,
                        'nbd' => $nbd,
                        'destination_type' => $destinationType,
                        'organization' => $organization,
                        'location' => $location,
                        // 'loc_id' => $loc_id,
                        'subinventory' => $subinventory,
                        'alasan_order' => $alasanOrder,
                        'alasan_urgensi' => $alasanUrgensi,
                        'note_to_pengelola' => $noteToPengelola,
                        'notes' => $notes
                    );

                    array_push($data['item_not_oke'], $item);
                }
            }

            $returnTable = $this->load->view('OrderKebutuhanBarangDanJasa/Import/V_Table', $data, true);

            echo ($returnTable);
        }
    }
}
