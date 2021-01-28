<?php
defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');

        $this->load->library('session');
        // $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('BOMRouting/M_index');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    //------------------------show the dashboard-----------------------------
    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['Title'] = 'Pendaftaran BOM Routing';

        $menu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $user 	 = $this->session->user;
        // $user = 'F23222';
        $getUser = $this->M_index->CekUserAll($user);
        if (!empty($getUser)) {
            $data['UserMenu'] = $menu;
        } else {
            unset($menu[2]);
            unset($menu[1]);
            $data['UserMenu'] = $menu;
            echo '
			<div style="width: 100vw;height: 100vh;background:rgb(0, 145, 191); z-index: 999999; position: absolute; display:block">
			  <div class="row">
			    <div class="container">
					<h2 style="color:white;padding:70px;">Anda belum memiliki mengakses untuk aplikasi ini, harap hubungi admin PE ;)
					<br>Terima Kasih.
					</h2>
					<a style="color:white;margin:70px;" href="'.base_url("").'" class="btn btn-info btn-circle btn-lg" style="color:white">
						Back
					</a >
			    </div>
			  </div>
			</div>

			';
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BOMRouting/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function InputBOMRouting()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] 					= 'Dashboard';
        $data['SubMenuOne'] 		= '';
        $data['Title'] 					= 'Input BOM Routing';

        $data['UserMenu'] 			= $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BOMRouting/V_Input', $data);
        $this->load->view('V_Footer', $data);
    }

    public function ViewBOMRouting($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] 					= 'Dashboard';
        $data['SubMenuOne'] 		= '';
        $data['Title'] 					= 'View BOM Routing';

        $data['UserMenu'] 			= $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['headerRow'] 			= $this->M_index->getHeader($id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BOMRouting/V_View', $data);
        $this->load->view('V_Footer', $data);
    }

    public function Create()
    {
        $time = date('m/y');
        $lastNoDocument = $this->M_index->getLatestNoNumber($time);
        if (empty($lastNoDocument[0]['last_number'])) {
            $newNoDocument = '01/PRG/AL&DI/'.$time;
        } else {
            $newNumber = $lastNoDocument[0]['last_number']+1;
            if (strlen($newNumber) < 2) {
                $newNumber = str_pad($newNumber, 2, "0", STR_PAD_LEFT);
            }
            $newNoDocument = $newNumber.'/PRG/AL&DI/'.$time;
        }
        $dataHeader = array(
            'no_document'					=> $newNoDocument,
            'tgl_pembuatan' 			=> $this->input->post('txtTanggalPembuatan'),
            'nama_barang' 				=> $this->input->post('txtNamaBarang'),
            'seksi'								=> $this->input->post('txtSeksi'),
            'io'									=> $this->input->post('txtIO'),
            'kode_item_parent' 		=> $this->input->post('txtKodeParent'),
            'deskripsi' 					=> $this->input->post('txtDescription'),
            'tgl_berlaku' 				=> $this->input->post('txtTanggalBerlaku'),
            'perubahan' 					=> $this->input->post('txtPerubahan')
            );

        $this->M_index->setHeader($dataHeader);
        $id_header = $this->db->insert_id();

        $noUrut = $this->input->post('noSub[]');
        for ($i = 0; $i < count($noUrut); $i++) {
            $dataPenyusun[] = array(
                'kode_komponen_penyusun'	=> $this->input->post('txtKodePenyusun[' . $i . ']'),
                'deskripsi_penyusun' 			=> $this->input->post('txtDescriptionPenyusun[' . $i . ']'),
                'quantity' 								=> $this->input->post('txtQuantity[' . $i . ']'),
                'uom'											=> $this->input->post('txtOUM[' . $i . ']'),
                'supply_type'							=> $this->input->post('txtSupplytype[' . $i . ']'),
                'supply_subinventory'			=> $this->input->post('txtSupplySub[' . $i . ']'),
                'supply_locator' 					=> $this->input->post('txtSupplyLocator[' . $i . ']'),
                'subinventory_picklist' 	=> $this->input->post('txtSubPicklist[' . $i . ']'),
                'locator_picklist' 				=> $this->input->post('txtLocatorPicklist[' . $i . ']'),
                'id_header'								=> $id_header,
                );
            $this->M_index->setComponent($dataPenyusun[$i]);
        }
        redirect(base_url('PendaftaranBomRouting/InputBOMRouting'));
    }

    public function updateAddPenyusun($id_header)
    {
        $noUrut = $this->input->post('noSub[]');
        for ($i = 0; $i < count($noUrut); $i++) {
            $dataPenyusun[] = array(
              'kode_komponen_penyusun'	=> $this->input->post('txtKodePenyusun[' . $i . ']'),
              'deskripsi_penyusun' 			=> $this->input->post('txtDescriptionPenyusun[' . $i . ']'),
              'quantity' 								=> $this->input->post('txtQuantity[' . $i . ']'),
              'uom'											=> $this->input->post('txtOUM[' . $i . ']'),
              'supply_type'							=> $this->input->post('txtSupplytype[' . $i . ']'),
              'supply_subinventory'			=> $this->input->post('txtSupplySub[' . $i . ']'),
              'supply_locator' 					=> $this->input->post('txtSupplyLocator[' . $i . ']'),
              'subinventory_picklist' 	=> $this->input->post('txtSubPicklist[' . $i . ']'),
              'locator_picklist' 				=> $this->input->post('txtLocatorPicklist[' . $i . ']'),
              'id_header'								=> $id_header,
              );
            $this->M_index->setComponent($dataPenyusun[$i]);
        }
        redirect(base_url('PendaftaranBomRouting/ListBOMRouting/ViewBOMRouting/'.$id_header));
    }

    public function ListBOMRouting()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] 					= 'Dashboard';
        $data['SubMenuOne'] 		= '';
        $data['Title'] 					= 'List BOM Routing';

        $menu							 			= $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $user 	 = $this->session->user;
        // $user = 'F2325';
        $getUser = $this->M_index->CekUser($user);

        if (!empty($getUser)) {
            unset($menu[2]);
            $data['UserMenu'] = $menu;
        } else {
            $data['UserMenu'] = $menu;
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BOMRouting/V_List', $data);
        $this->load->view('V_Footer', $data);
    }

    //UserManagement

    public function UserManagement()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] 					= 'Dashboard';
        $data['SubMenuOne'] 		= '';
        $data['Title'] 					= 'User Management Account Access';

        $data['UserMenu']				= $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['get']						= $this->M_index->getUser();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BOMRouting/V_User', $data);
        $this->load->view('V_Footer', $data);
    }

    // serverside1
    public function getdataHeader()
    {
        $fetch_data = $this->M_index->make_datatables();
        $data = array();
        $no=1;
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $no++;
            $sub_array[] = $row->no_document;
            $sub_array[] = $row->tgl_pembuatan;
            $sub_array[] = $row->kode_item_parent;
            $sub_array[] = $row->nama_barang;
            $sub_array[] = $row->seksi;
            $sub_array[] = $row->io;
            $sub_array[] = $row->tgl_berlaku;
            $sub_array[] = '
					<a href="'.base_url("PendaftaranBomRouting/ListBOMRouting/ViewBOMRouting/{$row->id}").'" class="btn btn-info btn-circle btn-sm" style="color:white">
						<i class="fa fa-info-circle"></i>
					</a >
          <a href="'.base_url("PendaftaranBomRouting/InputBOMRouting/GeneratePDF").'" class="btn btn-danger btn-circle btn-sm" style="color:white" target="_blank">
            <i class="fa fa-file-pdf-o"></i>
          </a >
					<button onclick="DeleteHeader('.$row->id.')" class="btn btn-danger btn-circle btn-sm" style="color:white">
						<i class="fa fa-trash-o"></i>
					</button >';

            $data[] = $sub_array;
        }
        $output = array(
         "draw"                  =>     intval($_POST["draw"]),
         "recordsTotal"          =>     $this->M_index->get_all_data(),
         "recordsFiltered"       =>     $this->M_index->get_filtered_data(),
         "data"                  =>     $data
    );
        echo json_encode($output);
    }

    //serverSide2
    public function getdataPenyusun()
    {
        $id_header  = $this->input->post('txt_id_header');
        $fetch_data = $this->M_index->make_datatables2($id_header);
        $data = array();
        $no=1;
        // echo "<pre>";
        // print_r($fetch_data);
        // die;
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $no++;
            // $sub_array[] = '
            // <input class="form-control" type="text" placeholder="Type" value="'.$row->kode_komponen_penyusun.'">
            // ';
            //  $sub_array[] = '
            //  <textarea rows="2" title="" class="form-control" id="" placeholder="Deskripsi Komponen Penyusun">'.$row->deskripsi_penyusun.'</textarea>
            //  ';
            //  $sub_array[] = '
            //  <input class="form-control" type="number" placeholder="Quantity" value="'.$row->id_header.'">
            //  ';
            //  $sub_array[] = '
            //  <select class="form-control select2" data-placeholder="" value="'.$row->quantity.'">
            // 	 <option>lorem 2</option>
            // 	 <option value="">lorem</option>
            //  </select>
            //  ';
            //  if ($row->supply_type == 'Operation Pull (Picklist)') {
            // 	 $a = "selected";
            //  }elseif ($row->supply_type == "Operation Pull") {
            // 	 $b = "selected";
            // }elseif ($row->supply_type == "Push") {
            // 	 $c = "selected";
            // }else {
            // }
            // 	 // <option '.if ($row->supply_type == "Operation Pull (Picklist)"){ echo "selected"}.' value="Operation Pull (Picklist)">Operation Pull (Picklist)</option>
            // 	 // <option '.if ($row->supply_type == "Operation Pull"){ echo "selected"}.' value="Operation Pull" >Operation Pull</option>
            // 	 // <option '.if ($row->supply_type == "Push"){ echo "selected"}.' value="Push">Push</option>
            // 	 $sub_array[] = '
            // 	 <select class="form-control" id="txtSupplytype" data-placeholder="Supply Type">
            // 		 <option value=""></option>
            // 		 <option value="Operation Pull (Picklist)">Operation Pull (Picklist)</option>
            // 		 <option value="Operation Pull" >Operation Pull</option>
            // 		 <option value="Push">Push</option>
            // 	 </select>
            // 		 ';
            //  	  $sub_array[] = '
            //  	  <input class="form-control" type="text" placeholder="" value="'.$row->supply_subinventory.'">
            //  	  ';
            //  	  $sub_array[] = '
            //  	  <input class="form-control" type="text" placeholder="" value="'.$row->supply_locator.'">
            //  	  ';
            //  	  $sub_array[] = '
            //  	  <input class="form-control" type="text" placeholder="" value="'.$row->subinventory_picklist.'">
            //  	  ';
            //  	  $sub_array[] = '
            //  	  <input class="form-control" type="text" placeholder="" value="'.$row->locator_picklist.'">
            //  	  ';
            //versi2
            $sub_array[] = $row->kode_komponen_penyusun;
            $sub_array[] = $row->deskripsi_penyusun;
            $sub_array[] = $row->quantity;
            $sub_array[] = $row->uom;
            $sub_array[] = $row->supply_type;
            $sub_array[] = $row->supply_subinventory;
            $sub_array[] = $row->supply_locator;
            $sub_array[] = $row->subinventory_picklist;
            $sub_array[] = $row->locator_picklist;
            $sub_array[] = '
					 <div style="width:100%">
						 <center>
						 <button type="button" onclick="getPenyusun('.$row->id.')" class="btn btn-info btn-circle btn-sm" style="color:white" data-toggle="modal" data-target="#MyModal">
							 <i class="fa fa-info-circle"></i>
						 </button>
						 <button type="button" onclick="DeletePenyusun('.$row->id.')" class="btn btn-danger btn-circle btn-sm" style="color:white">
							 <i class="fa fa-trash"></i>
						 </button>
						 </center>
					 </div>

					';
            $data[] = $sub_array;
        }
        $output = array(
                 "draw"                  =>     intval($_POST["draw"]),
                 "recordsTotal"          =>     $this->M_index->get_all_data2(),
                 "recordsFiltered"       =>     $this->M_index->get_filtered_data2(),
                 "data"                  =>     $data
        );
        echo json_encode($output);
    }

    public function getDataComponent()
    {
        $id = $this->input->post('update_id');
        echo json_encode($this->M_index->get_component_update($id));
    }

    public function deleteCompPenyusun()
    {
        $data = $this->input->post('penyusun_id');
        $this->M_index->delete_penyusun($data);
        echo json_encode('success');
    }

    public function updateHeader()
    {
        $data = [
            'no_document'					=> $this->input->post('pbr_nodocx'),
            'tgl_pembuatan' 			=> $this->input->post('pbr_tgl'),
            'nama_barang' 				=> $this->input->post('pbr_barang'),
            'seksi'								=> $this->input->post('pbr_seksi'),
            'io'									=> $this->input->post('pbr_io'),
            'kode_item_parent' 		=> $this->input->post('pbr_kode'),
            'deskripsi' 					=> $this->input->post('pbr_deskripsi'),
            'tgl_berlaku' 				=> $this->input->post('pbr_berlaku'),
            'perubahan' 					=> $this->input->post('pbr_perubahan')
        ];
        $id = $this->input->post('id');
        $this->M_index->updateHeader($data, $id);
        echo json_encode($id);
    }

    public function updatePenyusun()
    {
        $data = [
            'kode_komponen_penyusun'			=> $this->input->post('penyusun'),
            'quantity' 										=> $this->input->post('qty'),
            'uom' 												=> $this->input->post('uom'),
            'deskripsi_penyusun'					=> $this->input->post('deskripsi'),
            'supply_type'									=> $this->input->post('subtype'),
            'supply_subinventory' 				=> $this->input->post('supplysub'),
            'supply_locator' 							=> $this->input->post('supplyloc'),
            'subinventory_picklist' 			=> $this->input->post('subpicklist'),
            'locator_picklist' 						=> $this->input->post('locatorpicklist')
        ];
        $id = $this->input->post('id');
        $this->M_index->MupdatePenyusun($data, $id);
        echo json_encode($id);
    }

    public function GeneratePDF()
    {
        $data = '';

        $this->load->library('Pdf');
        $pdf 		= $this->pdf->load();
        $pdf 		= new mPDF('utf-8', 'A4-L', 0, '', 3, 3, 3, 3, 3, 3);

        //ob_end_clean() ;
        $filename 	= 'Dokumen_BOM_'.date('d-M-Y').'.pdf';
        $aku 				= $this->load->view('BOMRouting/pdf/V_GeneratePDF', $data, true);
        $pdf->WriteHTML($aku);
        $pdf->Output($filename, 'I');
    }

    public function getUserAll()
    {
        $term = $this->input->post('term');
        echo json_encode($this->M_index->CariSelect2($term));
    }

    public function getDataUserUpdate()
    {
        $id = $this->input->post('user_id');
        echo json_encode($this->M_index->getUserUpdate($id));
    }

    public function getDataUserCreate()
    {
        $id = $this->input->post('user_id');
        echo json_encode($this->M_index->getDataUserCreate($id));
        // echo json_encode($id);
    }

    public function CreateUser()
    {
        $dataHeader = array(
            'nama'					=> $this->input->post('txtUser'),
            'no_induk' 			=> $this->input->post('txtNoInduk'),
            'role_access' 	=> $this->input->post('txtPermission'),
            );

        $this->M_index->setUser($dataHeader);
        redirect(base_url('PendaftaranBomRouting/UserManagement'));
    }


    //musuh bercanda...
    public function UpdateUser()
    {
        $id   = $this->input->post('txt_id_us');
        $cek1 = $this->input->post('txtUser');
        $cek2 = $this->input->post('txtNoInduk');
        $cek3 = $this->input->post('txtPermission');

        $dataHeader = array(
                // 'nama'					=> $this->input->post('txtUser'),
                // 'no_induk' 			=> $this->input->post('txtNoInduk'),
                'role_access'   => $this->input->post('txtPermission'),
                );
        $this->M_index->updateUser($id, $dataHeader);

        redirect(base_url('PendaftaranBomRouting/UserManagement'));
    }

    public function deleteHeader()
    {
        $id  = $this->input->post('id');
        $this->M_index->delete_header($id);
        redirect(base_url('PendaftaranBomRouting/UserManagement'));
    }

    public function deleteUser($id)
    {
        $this->M_index->delete_user($id);
        redirect(base_url('PendaftaranBomRouting/UserManagement'));
    }

    public function sendEmail()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] 					= 'Dashboard';
        $data['SubMenuOne'] 		= '';
        $data['Title'] 					= 'BOM ROUTING SEND EMAIL';

        $data['UserMenu']				= $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['get']						= $this->M_index->getUser();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BOMRouting/V_SendEmail', $data);
        $this->load->view('V_Footer', $data);
    }

    public function sendEmailSubmit()
    {
        $PBRemail 		=  $this->input->post('PBRemail');
        $PBRccemail 	=  $this->input->post('PBRccemail');
        // $PBRbccemail 	=  $this->input->post('PBRbccemail');
        $PBRsubject		=  $this->input->post('PBRsubj');
        $PBRisi				=  $this->input->post('PBRisi');
        $toEmail			= preg_replace('/\s+/', '', explode(',', $PBRemail));
        $ccEmail			= preg_replace('/\s+/', '', explode(',', $PBRccemail));
        //$bccEmail		= preg_replace('/\s+/', '', explode(',', $PBRbccemail));

        if (empty($PBRisi)) {
            $PBRisi = '';
        }

        // Load library email
        $this->load->library('PHPMailerAutoload');
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        // Set connection SMTP Webmail
        $mail->isSMTP();
        $mail->Host 			= 'mail.quick.com';
        $mail->Port 			= 25;
        $mail->SMTPAuth 	= true;
        //$mail->SMTPDebug = 1;
        //$mail->SMTPSecure = 'ssl';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true)
            );

        $mail->Username = 'no-reply@quick.com';
        $mail->Password = '123456';
        $mail->WordWrap = 50;

        // Set email content to sent
        $mail->setFrom('no-reply@quick.com', 'Admin Bumi Bulat CV. KHS');
        foreach ($ccEmail as $key => $ccE) {
            $mail->AddCC($ccE);
        }
        foreach ($toEmail as $key => $toE) {
            $mail->addAddress($toE);
        }

        //this is for Attachment
        if (isset($_FILES['PBRfile_att']) && $_FILES['PBRfile_att']['error'] == UPLOAD_ERR_OK) {
            $mail->AddAttachment($_FILES['PBRfile_att']['tmp_name'], $_FILES['PBRfile_att']['name']);
        };
        $mail->Subject = $PBRsubject;
        $mail->msgHTML($PBRisi);

        // Send email
        if (!$mail->send()) {
            echo json_encode($mail->ErrorInfo);
        } else {
            echo json_encode('Message sent!');
        }
    }
}
