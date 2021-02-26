<?php
defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');
class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        $this->load->library('encrypt');
        //load the login model
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->model('M_Index');
        $this->load->library('upload');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('FlowProses/M_fp');

        date_default_timezone_set('Asia/Jakarta');

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

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
        if (!empty($acc)) {
          $access = $acc->user_access;
        }else {
          $access = null;
        }
        if ($access == 'Super User') {
          // code...
        }elseif ($access == 'Admin (Serah Terima)') {
          unset($data['UserMenu'][1]);
          unset($data['UserMenu'][4]);
          unset($data['UserMenu'][5]);
        }elseif ($access == 'Admin (Operation)') {
          unset($data['UserMenu'][2]);
          unset($data['UserMenu'][5]);
        }elseif (empty($access)){
          echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
          die;
        }

        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Index');
        $this->load->view('V_Footer', $data);
    }

    public function cekOracleProses()
    {
      $cek = $this->M_fp->cekOracleProses($this->input->post('code'));
      if (!empty($cek)) {
        echo json_encode($cek);
      }else {
        echo json_encode(0);
      }
    }

    public function gambarkerja()
    {
      // if product mass
      $product_id = $this->input->post('product_id');
      $id = $this->input->post('product_component_id');
      $jenis = $this->input->post('jenis');
      $filename = $this->M_fp->getFileName($id, $jenis);
      // echo "<pre>";
      // print_r($filename);die;
      $newFormat = str_replace('/', '-', $filename['file_location'].$filename['file_name'].'.pdf');
      $encrypted_string_design = $this->encrypt->encode($newFormat);
      $encrypted_string_design = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string_design);
      $data['link'] = $encrypted_string_design;
      $data['employee'] = trim($this->session->employee);
      $this->load->view('FlowProses/ajax/V_Iframe', $data);
    }

    public function gambarkerjaBachAdd()
    {
      // if product mass
      $product_id = $this->input->post('product_id');
      $id = $this->input->post('product_component_id');
      $jenis = $this->input->post('jenis');
      $filename = $this->M_fp->getFileName($id, $jenis);
      // echo "<pre>";
      // print_r($filename);die;
      $newFormat = str_replace('/', '-', $filename['file_location'].$filename['file_name'].'.pdf');
      $encrypted_string_design = $this->encrypt->encode($newFormat);
      $encrypted_string_design = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string_design);
      $data['link'] = $encrypted_string_design;
      $data['employee'] = trim($this->session->employee);
      $this->load->view('FlowProses/ajax/V_Iframe_2', $data);
    }

    public function Product()
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $data['get'] = $this->M_fp->getProduct();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('FlowProses/V_Product');
      $this->load->view('V_Footer', $data);
    }

    public function Memo()
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Memo';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }
      if ($access == 'Super User' || $access == 'Admin (Serah Terima)') {
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_fp->getMemo('Product');
        $data['product'] = $this->M_fp->getProduct();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Memo');
        $this->load->view('V_Footer', $data);
      }else {
        $data['message'] = 'Anda '.$this->session->user.' Tidak Memiliki Akses Fitur Memo.';
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Cek', $data);
        $this->load->view('V_Footer', $data);
      }
    }

    public function getComponentMemoProduct($value='')
    {
      $data['get'] = $this->M_fp->getMemo($this->input->post('type'));
      $data['type'] = $this->input->post('type');
      // echo "<pre>";
      // print_r($data['get']);
      $this->load->view('FlowProses/ajax/V_Memoea', $data);
    }

    public function getComponentMemo()
    {
      if ($this->input->is_ajax_request()) {
        $data['memo'] = $this->input->post('memo');
        $data['memo_id'] = $this->input->post('memo_id');
        $data['type'] =  $this->input->post('type');

        $data['cek'] = $this->db->where('memo_number', $this->input->post('memo'))->get('md.md_component_approved')->num_rows();

        $id = $data['memo_id'];
        $lineHisto 	= $this->M_fp->getMemoLine($id, $data['memo'], $data['type']);
        $lineNew 		= $this->M_fp->getMemoLineNew($id, $data['memo'], $data['type']);

        $dtTemp = array();
        $kpsr = $this->M_fp->kpsrMemoProduct($data['memo'], $data['type']);
        if (!empty($kpsr)) {
          foreach ($kpsr as $key => $value) {
            $cek_kom_in_histo = $this->M_fp->cek_kom_in_histo($value['product_component_id'], $data['type']);
            if (!empty($cek_kom_in_histo)) {
              $tampung_new_comp_in_histo[] = $cek_kom_in_histo;
            }
          }
        }

        if (empty($tampung_new_comp_in_histo)) {
          $tampung_new_comp_in_histo = [];
        }else {
          foreach ($tampung_new_comp_in_histo as $key => $value) {
            $lnnew_in_histo = array(
                    'history_id' => 0,
                    'historyparent' => 0,
                    'product_component_id' => $value['product_component_id'],
                    'product_id' => $value['product_id'],
                    'nama_komponen' => $value['component_name'],
                    'component_code_old' => '-',
                    'kodebaru' => $value['component_code'],
                    'revision_date' => $value['revision_date'],
                    'norevisi' => '0',
                    'detailperubahan' => empty($value['change_detail']) ? $value['information'] : $value['change_detail'],
                    'sifatperubahan' => $value['change_type'],
                    'gambarkerjalama' => $value['status_design'],
                    'statuskomponen' => $value['status_component'],
                    'status' => $value['status']
                );
            array_push($dtTemp, $lnnew_in_histo);
          }
        }
        //end

        if (!empty($lineHisto[0]['product_component_id'])) {
          $getdataoldupdate = $this->M_fp->getMemoLineNewUniqueUpdate($id, $data['memo'], $lineHisto[0]['product_component_id'], $data['type']);
        }
        // if (empty($lineNew)) {
        //     $lineNew 	= $this->M_fp->getMemoLineNewProt($id, $data['memo']);
        // }

        foreach ($lineNew as  $lnw) {
            $strip = '0';
            if ($lnw['revision'] != 0) {
              $strip = $lnw['revision'];
            }
            $lnwray = array(
                'history_id' 					 => 0,
                'historyparent' 			 => 0,
                'product_component_id' => $lnw['product_component_id'],
                'product_id'           => $lnw['product_id'],
                'nama_komponen' 			 => $lnw['component_name'],
                'component_code_old' 	 => '-',
                'kodebaru' 						 => $lnw['component_code'],
                'norevisi' 						 => $strip,
                'revision_date'				 => $lnw['revision_date'],
                'detailperubahan' 		 => $lnw['change_detail'],
                'sifatperubahan' 			 => $lnw['change_type'],
                'status'							 => $lnw['status'],
                'gambarkerjalama' 		 => $lnw['status_design'],
                'statuskomponen' 			 => $lnw['status_component']
            );
            array_push($dtTemp, $lnwray);
        }

        if (!empty($lineHisto)) {
          if ($lineHisto[0]['jenis'] == 'Prototype') {
              foreach ($getdataoldupdate as $lhray) {
                  array_push($dtTemp, $lhray);
              }
          } else {
              foreach ($lineHisto as $lhray) {
                  array_push($dtTemp, $lhray);
              }
          }
        }

        foreach ($dtTemp as $key => $value) {
          $design = $this->M_fp->getimgCek($value['product_component_id'], $data['type']);
          $dtTemp[$key]['file_location'] = $design['file_location'];
          $dtTemp[$key]['file_name'] = $design['file_name'];
        }

        $data['get'] = $dtTemp;

        // echo "<pre>";print_r($dtTemp);

        if (!empty($data['get'])) {
          $this->load->view('FlowProses/ajax/V_Detail_Memo', $data);
        }else {
          echo json_encode(null);
        }
      }
    }

    public function updateComponentMemo()
    {
      if ($this->input->is_ajax_request()) {
        $memo = $this->input->post('memo');
        $cek = $this->db->where('memo_number', $memo)->get('md.md_component_approved')->num_rows();
        if ($cek == 0) {
          $getComponent = $this->M_fp->getComponentMemo($this->input->post('memo'), $this->input->post('type'));
          foreach ($getComponent as $key => $value) {
           unset($getComponent[$key]['component_name']);
          }
          foreach ($getComponent as $key => $value) {
            // echo "<pre>";
            // print_r($value);
           $this->db->insert('md.md_component_approved', $value);
          }
          if ($this->db->affected_rows() == 1) {
            echo json_encode(1);
          }else {
            echo json_encode(2);
          }
        }else {
          echo json_encode(3);
        }
      }
    }

    public function updateComponentMemoCancel($value='')
    {
      if ($this->input->is_ajax_request()) {
        $memo = $this->input->post('memo');
         $this->db->delete('md.md_component_approved', ['memo_number' => $memo]);
         if ($this->db->affected_rows() == 1) {
           echo json_encode(1);
         }else {
           echo json_encode(2);
         }
      }
    }

    public function ImportProduct()
    {
      $data['data_input']  = array();
      $file_data = $_FILES['excel_file']['tmp_name'];
      $load = PHPExcel_IOFactory::load($file_data);
      $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
      $jml = count($sheets) + 1;
      //
      for ($i=3; $i < $jml; $i++) {
          $arrayData = array(
                   'product_code'  => $sheets[$i]['B'],
                   'product_name'	 => $sheets[$i]['C'],
                   'product_id'	   => $sheets[$i]['D'],
                   );

          if (empty($sheets[$i]['A'])) {
            break;
          }
          $id = $sheets[$i]['D'];
          $cekproduk = $this->db->where('product_id', $id)->get('md.md_product')->row_array();

          if (!empty($cekproduk)) {
            $this->db->where('product_id', $id)->update('md.md_product', $arrayData);
          } else {
            $this->db->insert('md.md_product', $arrayData);
          }
      }
      redirect('FlowProses/Product');
    }

    public function fpssc()
    {
      $fetch_data = $this->M_fp->make_datatables();
      $data = [];
      $no=1;
      foreach ($fetch_data as $row) {
          $sub_array   = [];
          $sub_array[] = '<center>'.$no++.'</center>';
          $sub_array[] = $row->product_name;
          $sub_array[] = $row->product_component_code;
          $sub_array[] = $row->component_code;
          $sub_array[] = $row->component_name;
          $sub_array[] = $row->revision;
          $sub_array[] = substr($row->revision_date, 0, 10);
          $sub_array[] = $row->material_type;
          $sub_array[] = '-';
          $sub_array[] = $row->weight;
          $sub_array[] = $row->status;
          $sub_array[] = '-';
          $sub_array[] = $row->memo_number;
          $sub_array[] = $row->information;
          $sub_array[] = $row->last_update_date;
          $sub_array[] = $row->change_type;
          $sub_array[] = '<button type="button" onclick="getgambarkerja(\''.$row->product_id.'\', \''.$row->product_component_id.'\', \'Product\', \''.$row->component_code.'\')" class="btn btn-primary" name="button" data-toggle="modal" data-target="#modalfpgambar"> <b class="fa fa-image"></b> </button>';
          $sub_array[] = $row->qty;

          $data[] = $sub_array;
      }

      $output = array(
           "draw"              =>  intval($_POST["draw"]),
           "recordsTotal"      =>  $this->M_fp->get_all_data(),
           "initComplete"		   =>  $this->M_fp->get_filtered_data(),
           "recordsFiltered"   =>  $this->M_fp->get_filtered_data(),
           "data"              =>  $data
      );

      echo json_encode($output);
    }

    public function prototype_comp()
    {
      $this->load->view('FlowProses/ajax/V_Prototype');
    }

    public function fpssc_proto()
    {
      $fetch_data = $this->M_fp->make_datatables_proto();
      $data = [];
      $no=1;
      foreach ($fetch_data as $row) {
          $sub_array   = [];
          $sub_array[] = '<center>'.$no++.'</center>';
          $sub_array[] = $row->product_name;
          $sub_array[] = $row->product_component_code;
          $sub_array[] = $row->component_code;
          $sub_array[] = $row->component_name;
          $sub_array[] = $row->revision;
          $sub_array[] = substr($row->revision_date, 0, 10);
          $sub_array[] = $row->material_type;
          $sub_array[] = '-';
          $sub_array[] = $row->weight;
          $sub_array[] = $row->status;
          $sub_array[] = '-';
          $sub_array[] = $row->memo_number;
          $sub_array[] = $row->information;
          $sub_array[] = $row->last_update_date;
          $sub_array[] = $row->change_type;
          $sub_array[] = '<button type="button" onclick="getgambarkerja(\''.$row->product_id.'\', \''.$row->product_component_id.'\', \'Prototype\', \''.$row->component_code.'\')" class="btn btn-primary" name="button" data-toggle="modal" data-target="#modalfpgambar"> <b class="fa fa-image"></b> </button>';
          $sub_array[] = $row->qty;

          $data[] = $sub_array;
      }

      $output = array(
           "draw"              =>  intval($_POST["draw"]),
           "recordsTotal"      =>  $this->M_fp->get_all_data_proto(),
           "initComplete"		   =>  $this->M_fp->get_filtered_data_proto(),
           "recordsFiltered"   =>  $this->M_fp->get_filtered_data_proto(),
           "data"              =>  $data
      );

      echo json_encode($output);
    }


    public function Component(){
      $this->checkSession();
      $user_id = $this->session->userid;
      $cekfile = $_FILES;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }

      if (empty($cekfile)) {

        if ($access == 'Super User' || $access == 'Admin (Serah Terima)') {
          // $data['get'] = $this->db->get('md.md_product_component')->result_array();
          $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
          $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

          $data['product'] =$this->M_fp->getProduct();
          $data['error'] = '';
          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('FlowProses/V_Component');
          $this->load->view('V_Footer', $data);
        }else {
          $data['message'] = 'Anda '.$this->session->user.' Tidak Memiliki Akses Fitur Component.';
          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('FlowProses/V_Cek', $data);
          $this->load->view('V_Footer', $data);
        }

      }else {
        // ini fitur sebelum negara api menyerang
        $data['data_input']  = array();
        $file_data = $_FILES['excel_file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file_data);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        $jml = count($sheets) + 1;
        for ($i=2; $i < $jml; $i++) {
            $arrayData = array(
                     'product_component_id'	     => $sheets[$i]['A'],
                     'product_component_code'	   => $sheets[$i]['B'],
                     'component_code'					   => $sheets[$i]['C'],
                     'component_name'					   => $sheets[$i]['D'],
                     'revision'									 => $sheets[$i]['E'],
                     'revision_date'						 => $sheets[$i]['F'],
                     'material_type' 					   => $sheets[$i]['G'],
                     'weight'									   => $sheets[$i]['H'],
                     'status'									   => $sheets[$i]['I'],
                     'information'							 => $sheets[$i]['J'],
                     'created_date'              => $sheets[$i]['L'],
                     'last_update_date'          => $sheets[$i]['N'],
                     'product_id'                => $sheets[$i]['O'],
                     'change_detail'             => $sheets[$i]['P'],
                     'change_type'               => $sheets[$i]['Q'],
                     'status_design'             => $sheets[$i]['R'],
                     'status_component'          => $sheets[$i]['S'],
                     'history_id_sub'            => $sheets[$i]['T'],
                     'qty' 											 => $sheets[$i]['U'],
                     'memo_number'							 => $sheets[$i]['W'],
                     );

            if (empty($sheets[$i]['A'])) {
              break;
            }
            $id = $sheets[$i]['A'];
            $cekproduk = $this->db->where('product_component_id', $id)->get('md.md_product_component')->row_array();

            if (!empty($cekproduk)) {
              $this->db->where('product_component_id', $id)->update('md.md_product_component', $arrayData);
            } else {
              $this->db->insert('md.md_product_component', $arrayData);
            }
        }
        $data['get'] = $this->db->get('md.md_product_component')->result_array();
        $data['error'] = '<br><div class="alert alert-success alert-dismissible no-border fade in mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">
                                <i class="fa fa-close"></i>
                              </span>
                            </button>
                            <strong>Data telah berhasil diperbarui !</strong>
                          </div>';
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Component');
        $this->load->view('V_Footer', $data);
      }

    }

    public function ops($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }
      if ($access == 'Super User' || $access == 'Admin (Operation)') {
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->db->get('md.md_operation_std')->result_array();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Operation_Std');
        $this->load->view('V_Footer', $data);
      }else {
        $data['message'] = 'Anda '.$this->session->user.' Tidak Memiliki Akses Fitur Operation Proccess Standard.';
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Cek', $data);
        $this->load->view('V_Footer', $data);
      }

    }

    public function delops($id)
    {
      if (!empty($id)) {
        $this->db->delete('md.md_operation_std', ['id' => $id]);
        if ($this->db->affected_rows() == 1) {
          redirect('FlowProses/OperationProcessStandard');
        }else {
          echo "Something Wrong";
        }
      }else {
        echo "NO Param Send!!";
      }
    }

    public function saveOperationstd()
    {
      if ($this->input->is_ajax_request()) {
        if (!empty($this->input->post('id'))) {
          $this->db->where('id', $this->input->post('id'))->update('md.md_operation_std', $_POST);
        }else {
          unset($_POST['id']);
          $this->db->insert('md.md_operation_std', $_POST);
        }
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }
      }
    }

    public function Operationstd()
    {
      $data['get'] = $this->db->get('md.md_operation_std')->result_array();
      $this->load->view('FlowProses/ajax/V_Detail_Std', $data);
    }

    public function Operation($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }

      if ($access == 'Super User' || $access == 'Admin (Operation)') {
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->db->get('md.md_operation')->result_array();
        $data['product'] = $this->M_fp->getProduct();
        // $data['proses'] = $this->db->order_by('operation_std', 'asc')->get('md.md_operation_std')->result_array();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Operation');
        $this->load->view('V_Footer', $data);
      }else {
        $data['message'] = 'Anda '.$this->session->user.' Tidak Memiliki Akses Fitur Operation Proccess.';
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Cek', $data);
        $this->load->view('V_Footer', $data);
      }

    }

    public function UpdateSequence()
    {
      $data = $this->input->post('data');
      foreach ($data as $key => $value) {
        if (!empty($value['id'])) {
          $data_filter[] = $value;
        }
      }
      if (!empty($data_filter)) {
        $data = $data_filter;
        foreach ($data as $key => $val) {
          if (!empty($val['id'])) {
            $this->db->where('id', $val['id'])->update('md.md_operation', ['sequence' => $val['sequence']]);
            if ($this->db->affected_rows() == 1) {
              $res =  1;
            }else {
              $res = 0;
            }
          }else {
            $res = 0;
          }
        }
        if ($res == 1) {
          echo json_encode(1);
        }else {
          echo json_encode(0);
        }
      }else {
        echo json_encode(0);
      }
      // echo "<pre>";print_r($data_filter);die;
    }

    public function addrow($value='')
    {
      $data['destination'] = $this->input->post('destination');
      $data['proses'] = $this->input->post('proses');
      $data['machine_req'] = $this->input->post('machine_req');
      $data['next_row'] = $this->input->post('next_row');
      // echo "<pre>";
      // print_r($data);
      // die;
      $this->load->view('FlowProses/ajax/V_new_proses_item', $data);
    }

    public function add_adjuvant()
    {
      $data = $this->input->post('master');
      foreach ($data as $key => $value) {
        $this->db->insert('md.md_adjuvant', $value);
      }
      if ($this->db->affected_rows() == 1) {
        echo json_encode(1);
      }else {
        echo json_encode(0);
      }
    }

    public function update_adjuvant()
    {
      $data = $this->input->post('master');

      $this->db->delete('md.md_adjuvant', ['id_operation' => $data[0]['id_operation']]);
      foreach ($data as $key => $value) {
        //revisi kondisi
        unset($value['id']);
        $this->db->insert('md.md_adjuvant', $value);
      }

      if ($this->db->affected_rows() == 1) {
        echo json_encode(1);
      }else {
        echo json_encode(0);
      }
    }

    public function getDetailPB()
    {
      $res = $this->db->where('id_operation', $this->input->post('id'))->get('md.md_adjuvant')->result_array();
      if (!empty($res)) {
        echo json_encode($res);
      }else {
        echo json_encode(0);
      }
    }

    public function GetComp($value='')
    {
      // $type = $this->input->post('type');
      $product_id = $this->input->post('product_id');
      $data['get'] = $this->M_fp->getComp($product_id);
      $data['status'] = $this->db->get('md.md_status')->result_array();
      $data['warning'] = $this->M_fp->getUnsetProses($product_id);
      $data['oracle_item'] = $this->db->where('product_id', $product_id)->get('md.md_oracle_item')->result_array();
      if (!empty($product_id)) {
        $this->load->view('FlowProses/ajax/V_Detail', $data);
      }
    }

    public function GetCompCheckOperation($value='')
    {
      $type = $this->input->post('type');
      $product_id = $this->input->post('product_id');
      $data['get'] = $this->db->where('product_type', $type)->where('product_id', $product_id)->get('md.md_operation')->result_array();
      if (!empty($product_id)) {
        $this->load->view('FlowProses/ajax/V_Detail_Operation', $data);
      }
    }

    public function SaveOpr()
    {
      if (empty($this->input->post('id'))) {
        unset($_POST['id']);
        $_POST['created_by'] = $this->session->employee;
        $this->db->insert('md.md_operation', $_POST);
        $last_id = $this->db->insert_id();
      }else {
        $this->db->where('id', $this->input->post('id'))->update('md.md_operation', $_POST);
        $last_id = $this->input->post('id');
      }

      if ($this->db->affected_rows() == 1) {
        $res['success'] = 1;
        $res['id'] = $last_id;
        echo json_encode($res);
      }else {
        $res['success'] = 0;
        $res['id'] = null;
        echo json_encode($res);
      }
    }

    public function UpdateOperationComp($value='')
    {
      $id_siap_hapus = explode(' ', $this->input->post('fp_id_deteted'));
      if (!empty($id_siap_hapus)) {
        foreach ($id_siap_hapus as $key => $id) {
          if (!empty($id)) {
            $this->db->where('id', $id)->delete('md.md_operation');
          }
        }
      }

      foreach ($this->input->post('fp_id_proses') as $key => $value) {
        if (!empty($value)) {
         $data = [
           'opr_code' => strtoupper($this->input->post('opetation_code')[$key]),
           'opr_desc' => $this->input->post('operation_desc')[$key],
           'inv_item_flag' => $this->input->post('flag')[$key],
           'make_buy' => $this->input->post('make_buy')[$key],
           'operation_process' => $this->input->post('operation_proses')[$key],
           'dtl_process' => $this->input->post('detail_proses')[$key],
           'jenis_proses' => $this->input->post('jenis_proses')[$key],
           'nomor_jenis_proses' => $this->input->post('nomor_jenis_proses')[$key],
           'machine_req' => $this->input->post('machine_req')[$key],
           'destination' => $this->input->post('destination')[$key],
           'resource' => $this->input->post('resource')[$key],
           'machine_num' => $this->input->post('machine_num')[$key],
           'qty_machine' => $this->input->post('qty_machine')[$key],
           'inspectool_id' => $this->input->post('inspectool')[$key],
           'tool_measurement' => $this->input->post('tool_measurement')[$key],
           'tool_id' => $this->input->post('tool')[$key],
           'tool_exiting' => $this->input->post('tool_exiting')[$key],
           'product_id' => $this->input->post('product_id'),
           'sequence' => $key + 1,
           'created_by' => $this->session->employee
         ];
         $this->db->where('id', $value)->update('md.md_operation', $data);
       }else {
         $data = [
           'opr_code' => strtoupper($this->input->post('opetation_code')[$key]),
           'opr_desc' => $this->input->post('operation_desc')[$key],
           'inv_item_flag' => $this->input->post('flag')[$key],
           'make_buy' => $this->input->post('make_buy')[$key],
           'operation_process' => $this->input->post('operation_proses')[$key],
           'dtl_process' => $this->input->post('detail_proses')[$key],
           'jenis_proses' => $this->input->post('jenis_proses')[$key],
           'nomor_jenis_proses' => $this->input->post('nomor_jenis_proses')[$key],
           'machine_req' => $this->input->post('machine_req')[$key],
           'destination' => $this->input->post('destination')[$key],
           'resource' => $this->input->post('resource')[$key],
           'machine_num' => $this->input->post('machine_num')[$key],
           'qty_machine' => $this->input->post('qty_machine')[$key],
           'inspectool_id' => $this->input->post('inspectool')[$key],
           'tool_measurement' => $this->input->post('tool_measurement')[$key],
           'tool_id' => $this->input->post('tool')[$key],
           'tool_exiting' => $this->input->post('tool_exiting')[$key],
           'product_id' => $this->input->post('product_id'),
           'sequence' => $key + 1,
           'product_component_id' => $this->input->post('product_component_id'),
           'status' => 'Y',
           'product_type' => $this->input->post('product_type'),
           'created_by' => $this->session->employee
         ];
         $this->db->insert('md.md_operation', $data);
       }
      }

      if ($this->db->affected_rows()) {
         echo 1;
      }else {
         echo 0;
      }
    }

    public function set_inactive()
    {
      $id = $this->input->post('product_component_id');
      $type = $this->input->post('type');
      $cek = $this->db->where('product_component_id', $id)
                      ->where('product_type', strtolower($type))
                      ->get('md.md_status')->row_array();
      // echo "<pre>";print_r($_POST);
      // echo "<pre>";print_r($cek);die;
      if (!empty($cek)) {
        if ($cek['status'] == 'N') {
          $hasil = 'Y';
        }else {
          $hasil = 'N';
        }
        $this->db->where('id', $cek['id'])->update('md.md_status', ['status' => $hasil]);
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }
      }else {
        $this->db->insert('md.md_status', ['product_component_id' => $id, 'product_type' => strtolower($type), 'status' => 'N']);
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }
      }
    }

    public function set_inactive_proses()
    {
      $id = $this->input->post('id');
      $type = $this->input->post('type');
      $cek = $this->db->where('id', $id)
                      ->get('md.md_operation')->row_array();
      if (!empty($cek)) {
        if ($cek['status'] == 'N') {
          $hasil = 'Y';
        }else {
          $hasil = 'N';
        }
        $this->db->where('id', $cek['id'])->update('md.md_operation', ['status' => $hasil]);
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }
      }else {
        echo json_encode(0);
      }
    }

    public function del_prosess_per_component()
    {
      if ($this->input->is_ajax_request()) {
        foreach ($this->input->post('id') as $key => $val) {
          $this->db->delete('md.md_operation', ['id' => $val]);
          $this->db->delete('md.md_adjuvant', ['id_operation' => $val]);
        }
        echo json_encode(1);
      }
    }

    public function GetProsesByComponent()
    {
      $id = $this->input->post('product_component_id');
      $type = $this->input->post('type');
      $data['get'] = $this->db->select('mo.*, mos.operation_std, mos.operation_desc')
                              ->where('mo.product_component_id', $id)
                              ->where('mo.product_type', strtolower($type))
                              ->join('md.md_operation_std mos', 'mos.id = mo.operation_process')
                              ->order_by('mo.sequence', 'asc')
                              ->get('md.md_operation mo')
                              ->result_array();
      $data['destination'] = $this->M_fp->getDestinasi('1');
      $data['proses'] = $this->db->order_by('operation_std', 'asc')->get('md.md_operation_std')->result_array();
      $data['machine_req'] = $this->M_fp->getFFVT('1');
      $this->load->view('FlowProses/ajax/V_Detail_Proses', $data);

    }

    public function getTool()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_fp->getTool($term));
    }

    public function get_machine_req()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_fp->getFFVT($term));
    }

    public function getDestinasi()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_fp->getDestinasi($term));
    }

    public function getMachineNum()
    {
      $code = $this->input->post('code');
      $dest = $this->input->post('destination');
      if ($dest == 'FDT' || $dest == 'FDY' || $dest == 'PTAS' || $dest == 'SM') {
        $data = $this->M_fp->getResource1();
        foreach ($data as $key => $value) {
          //versi BARU
          if ($value['RESOURCE_CODE'] == $code) {
            $tampung[] = $value;
          }
        }
      }else {
        $data = $this->M_fp->getResource2();
        foreach ($data as $key => $value) {
          //versi BARU
          if ($value['RESOURCE_CODE'] == $code) {
            $tampung[] = $value;
          }
        }
    }
    echo json_encode(!empty($tampung) ? $tampung : NULL);
  }

    public function getResource()
    {
      $term = strtoupper($this->input->post('term'));
      $mq =  $this->input->post('mechine_req');
      $dest = $this->input->post('destination');
      $destinasi_deskripsi = $this->M_fp->getDestinasiForSearch($dest);

      if ($dest == 'FDT' || $dest == 'FDY' || $dest == 'PTAS' || $dest == 'SM') {
        $data = $this->M_fp->getResource1();
        foreach ($data as $key => $value) {
          // $sub = substr($value['ATTRIBUTE1'], 0, 11);
          // if (substr($sub, 2, 3) == $mq) {
            // foreach ($destinasi_deskripsi as $ke2 => $val) {
              // $ex =  explode(' ', $value['DESCRIPTION']);
              // $tampung[] =$ex;
              // if ($ex[0] == $dest) {
              //   $tampung[] = $value;
              // }
            // }
          // }
          //versi BARU
          if ($value['VAR1'] == $dest && $value['VAR2'] == $mq) {
            $tampung[$value['RESOURCE_CODE']] = $value;
          }
        }
      }else {
        $data = $this->M_fp->getResource2();
        foreach ($data as $key => $value) {
          // $sub = substr($value['ATTRIBUTE1'], 0, 11);
          // if (substr($sub, 2, 3) == $mq) {
          //   foreach ($destinasi_deskripsi as $ke2 => $val) {
          //     if ($val['DESCRIPTION'] == $value['DESCRIPTION']) {
          //       $tampung[] = $value;
          //     }
          //   }
          // }

          //versi BARU
          if ($value['VAR1'] == $dest && $value['VAR2'] == $mq) {
            $tampung[$value['RESOURCE_CODE']] = $value;
          }

        }
      }


      echo json_encode(!empty($tampung) ? $tampung : NULL);
      // echo json_encode($destinasi_deskripsi);
    }

    public function SetOracleItem($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      // $data['get'] = $this->db->select('md.md_account.*, er.er_employee_all.employee_name')->join('er.er_employee_all', 'er.er_employee_all.employee_code = md.md_account.no_induk')->get('md.md_account')->result_array();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('FlowProses/V_SetOracleItem');
      $this->load->view('V_Footer', $data);
    }

    public function getOracleItem()
    {
      $term = strtoupper($this->input->post('term'));
      $org = $this->input->post('org');
      echo json_encode($this->M_fp->getOracleItem($term, $org));
    }

    public function getOracleItemPenolong()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_fp->getOracleItemPenolong($term));
    }

    public function del_item_oracle()
    {
      if ($this->input->is_ajax_request()) {
        $this->db->delete('md.md_oracle_item', ['id' => $this->input->post('id')]);
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }
      }else {
        echo json_encode(0);
      }
    }

    public function getDataItemOracle()
    {
      $data['get'] = $this->db->get('md.md_oracle_item')->result_array();
      $this->load->view('FlowProses/ajax/V_OracleItem', $data);
    }

    public function save_oracle_item()
    {
      if ($this->input->is_ajax_request()) {
        $cek = $this->db->select('product_component_id')->where('product_component_id', $this->input->post('product_component_id'))->get('md.md_oracle_item')->row_array();
        if (!empty($cek)) {
          $this->db->where('product_component_id', $this->input->post('product_component_id'))->update('md.md_oracle_item', $this->input->post());
        }else {
          $this->db->insert('md.md_oracle_item', $this->input->post());
        }
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }else {
          echo json_encode(0);
        }
      }else {
        echo json_encode(0);
      }
    }

    public function ManagementAccount($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $acc = $this->db->select('user_access')->where('no_induk', $this->session->user)->get('md.md_account')->row();
      if (!empty($acc)) {
        $access = $acc->user_access;
      }else {
        $access = null;
      }
      if ($access == 'Super User') {
        // code...
      }elseif ($access == 'Admin (Serah Terima)') {
        unset($data['UserMenu'][1]);
        unset($data['UserMenu'][4]);
        unset($data['UserMenu'][5]);
      }elseif ($access == 'Admin (Operation)') {
        unset($data['UserMenu'][2]);
        unset($data['UserMenu'][5]);
      }elseif (empty($access)){
        echo '<center><h1>Anda '.$this->session->user.' Tidak Memiliki Akses Aplikasi Flow Proses.</h1><center>';
        die;
      }

      if ($access == 'Super User') {
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->db->select('md.md_account.*, er.er_employee_all.employee_name')->join('er.er_employee_all', 'er.er_employee_all.employee_code = md.md_account.no_induk')->get('md.md_account')->result_array();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Account');
        $this->load->view('V_Footer', $data);
      }else {
        $data['message'] = 'Anda '.$this->session->user.' Tidak Memiliki Akses Fitur Management Account.';
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('FlowProses/V_Cek', $data);
        $this->load->view('V_Footer', $data);
      }

    }

    public function Add()
    {
      if (!empty($_POST)) {
        unset($_POST['button']);
        if (!empty($this->input->post('id'))) {
          $this->db->where('id', $this->input->post('id'))->update('md.md_account', $_POST);
        }else {
          unset($_POST['id']);
          $this->db->insert('md.md_account', $_POST);
        }
        if ($this->db->affected_rows() == 1) {
          redirect('FlowProses/ManagementAccount');
        }else {
          echo "Something Wrong";
        }
      }else {
        echo "There is No Data Send";
      }
    }

    public function delaccount($id)
    {
      if (!empty($id)) {
        $this->db->delete('md.md_account', ['id' => $id]);
        if ($this->db->affected_rows() == 1) {
          redirect('FlowProses/ManagementAccount');
        }else {
          echo "Something Wrong";
        }
      }else {
        echo "NO Param Send!!";
      }
    }

    public function employee()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_fp->employee($term));
    }

    public function Report($jenis, $product_id)
    {
      $data = $this->M_fp->report($jenis, $product_id);
      // echo "<pre>";print_r($data);die;
      $get_product_name = $this->M_fp->getProductName($product_id);

      include_once APPPATH.'/controllers/FlowProses/xlsxwriter.class.php';
      ini_set('display_errors', 0);
      ini_set('log_errors', 1);
      error_reporting(E_ALL & ~E_NOTICE);

      $filename = $get_product_name['product_name'].'-('.strtoupper($jenis).')-FLOW-PROSES-'.date('d-M-Y').'.xlsx';
      header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');

      for ($i=1; $i < 32; $i++) {
        if ($i == 7 || $i == 8 || $i == 9 || $i == 10) {
          $custom_color[] = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#bbffd8', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
        }elseif ($i == 11 || $i == 12 || $i == 13 || $i == 14 || $i == 15 || $i == 16) {
          $custom_color[] = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#f4f282', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
        }elseif ($i == 17 || $i == 18 || $i == 19 || $i == 20 || $i == 21 || $i == 22) {
          $custom_color[] = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#d9c9ff', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
        }elseif ($i == 23 || $i == 24 || $i == 25 || $i == 26 || $i == 27 || $i == 28 || $i == 29) {
          $custom_color[] = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#78ff79', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
        }elseif ($i == 30 || $i == 31) {
          $custom_color[] = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#ffa842', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
        }else {
          $custom_color[] = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#bbe5ff', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
        }
      }

      // $title_sty = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'valign'=>'center', 'halign'=>'left', 'border'=>'left,right,top,bottom');
      for ($i=0; $i < 4; $i++) {
        for ($j=0; $j < 31; $j++) {
          $title_sty[$i][$j]['font'] = 'Arial';
          $title_sty[$i][$j]['font-size'] = 10;
          $title_sty[$i][$j]['font-style'] = 'bold';
          $title_sty[$i][$j]['valign'] = 'center';
          $title_sty[$i][$j]['border'] ='top,left,right,bottom';
          $title_sty[$i][$j]['border-style'] ='thin';

          if ($j == 4) {
            $title_sty[$i][$j]['halign'] ='center';
            $title_sty[$i][$j]['font-size'] = 19;
          }elseif ($j == 1) {
            $title_sty[$i][$j]['fill'] = '#cb2727';
            $title_sty[$i][$j]['color'] = '#fff';
          }
        }
      }
      $styles = $custom_color;

      $styles1 = array('wrap_text'=>true, 'font'=>'Arial','font-size'=>10, 'fill'=>'#fff', 'valign'=>'center', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-style' => 'thin');
      $writer = new XLSXWriter();

      $writer->setTitle('ICT PRO');
      $writer->setCompany('KHS');
      $writer->setDescription('');
      $writer->setTempDir(sys_get_temp_dir());//set custom tempdir
      //----
      $sheet1 = 'Flow Proses';
      $header = array("string","string","string","string","string","string", "string", "string","string","string","string","string","string", "string","string");
      $fp_title = [
        ['', 'QUICK', 'CV KARYA HIDUP SENTOSA', '', 'MONITORING FLOW PROSES & DESTINATION', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Tembusan', '', 'Approved', '', 'Checked', '', 'Checked', '', 'Prepared', '', 'Doc. No', ''],
        ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Rev. No', ''],
        ['', '', 'YOGYAKARTA', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Rev. Date', ''],
        ['', '', 'PRODUCTION ENGINEERING', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'David SonnY-L', '', 'Artha Sakabuana', '', 'Gloria Christmas S A', '', 'Dian Dwi Utami', '', 'Page', ''],
      ];

      $rows = [
        [],
        ['NO GAMBAR', 'NO', 'NAMA KOMPONEN', 'KODE KOMPONEN', 'GAMBAR LAMA', 'GAMBAR BARU', 'GAMBAR KERJA', '', '', '', 'STANDAR/ALTERNATE', 'STATUS PROSES', 'URUTAN PROSES', '', '', '', 'TARGET', '', '', '', '', '', 'DOKUMEN', '', '', '', '', '', '', 'ORACLE', ''],
        ['', '', '', '', '', '', 'QTY-/UNIT', 'MATERIAL', 'KODE MATERIAL ORACLE', 'DESKRIPSI MATERIAL ORACLE', '', '', 'NO', 'PROSES', 'JENIS MESIN', 'DESTINATION', 'KODE PROSES', 'TARGET (RATA 2)', 'CYCLE TIME', 'USAGE RATE', 'STATUS', 'CATATAN', 'QCPC', 'PS', 'CBO', 'TSKK', '', '', '', 'INPUT', 'REMARK'],
        ['PIC', 'PIC', 'ADMINISTRASI UMUM', '', '', '', 'ADMINISTRASI UMUM', '', '', '', 'STAFF FLOW PROCESS', '', '', '', '', '', 'OPERATOR TMS', '', '', '', '', '', 'OPERATOR DOKUMEN', '', '', '', '', '', '', 'STAFF PIEA', ''],
      ];

      $writer->writeSheetHeader($sheet1, $header, $col_options = ['suppress_row'=>true, 'widths'=>[13,7,20,20,15,15,15,15,25,30,25,20,13,13,13,20,18,18,13,13,15,20,13,13,13,13,13,13,13,13,18], 'wrap_text'=>true]);

      foreach($fp_title as $key => $row)
      $writer->writeSheetRow($sheet1, $row, $title_sty[$key]);

      foreach($rows as $row)
      $writer->writeSheetRow($sheet1, $row, $styles);

      $writer->writeSheetRow($sheet1, ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''], $styles1);
      if (!empty($data)) {
        $baris_ke = 9;
        $nomor = 1;
        foreach($data as $key => $d){
        if (!empty($d['machine_req'])) {
          $writer->writeSheetRow($sheet1, [$d['product_component_code'], $nomor, $d['component_name'], $d['component_code'], '', '', $d['qty'], $d['material_type'], $d['oracle_code'], $d['oracle_desc'], '', '',
          $d['sequence'], $d['operation_std'], $d['machine_req'], $d['destination'], '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''], $styles1);
          if ($d['product_component_id'] == $data[$key+1]['product_component_id']) {
            $akhir_bar = $baris_ke + 1;
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=0, $end_row=$akhir_bar, $end_col=0);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=1, $end_row=$akhir_bar, $end_col=1);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=2, $end_row=$akhir_bar, $end_col=2);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=3, $end_row=$akhir_bar, $end_col=3);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=4, $end_row=$akhir_bar, $end_col=4);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=5, $end_row=$akhir_bar, $end_col=5);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=6, $end_row=$akhir_bar, $end_col=6);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=7, $end_row=$akhir_bar, $end_col=7);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=8, $end_row=$akhir_bar, $end_col=8);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=9, $end_row=$akhir_bar, $end_col=9);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=10, $end_row=$akhir_bar, $end_col=10);
            $writer->markMergedCell($sheet1, $start_row=$baris_ke, $start_col=11, $end_row=$akhir_bar, $end_col=11);
          }
          $nomor = ($nomor-1);
        }else {
          !empty($data[$key-1]['machine_req']) ? $nomor += 1 : $nomor;
          $writer->writeSheetRow($sheet1, [$d['product_component_code'], $nomor, $d['component_name'], $d['component_code'], '', '', $d['qty'], $d['material_type'],  $d['oracle_code'], $d['oracle_desc'], '', '', '',
          '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''], $styles1);
        }
        $baris_ke++;
        $nomor++;
      }

      }
      $writer->markMergedCell($sheet1, $start_row=0, $start_col=0, $end_row=3, $end_col=0);

      $writer->markMergedCell($sheet1, $start_row=0, $start_col=4, $end_row=3, $end_col=18);
      $writer->markMergedCell($sheet1, $start_row=0, $start_col=4, $end_row=3, $end_col=18);

      $writer->markMergedCell($sheet1, $start_row=0, $start_col=1, $end_row=3, $end_col=1);
      $writer->markMergedCell($sheet1, $start_row=0, $start_col=2, $end_row=1, $end_col=3);
      $writer->markMergedCell($sheet1, $start_row=2, $start_col=2, $end_row=2, $end_col=3);
      $writer->markMergedCell($sheet1, $start_row=3, $start_col=2, $end_row=3, $end_col=3);

      $writer->markMergedCell($sheet1, $start_row=0, $start_col=19, $end_row=0, $end_col=20);
      $writer->markMergedCell($sheet1, $start_row=1, $start_col=19, $end_row=3, $end_col=20);
      //Approved Dll
      $writer->markMergedCell($sheet1, $start_row=0, $start_col=21, $end_row=0, $end_col=22);
      $writer->markMergedCell($sheet1, $start_row=1, $start_col=21, $end_row=2, $end_col=22);
      $writer->markMergedCell($sheet1, $start_row=3, $start_col=21, $end_row=3, $end_col=22);

      $writer->markMergedCell($sheet1, $start_row=0, $start_col=23, $end_row=0, $end_col=24);
      $writer->markMergedCell($sheet1, $start_row=1, $start_col=23, $end_row=2, $end_col=24);
      $writer->markMergedCell($sheet1, $start_row=3, $start_col=23, $end_row=3, $end_col=24);

      $writer->markMergedCell($sheet1, $start_row=0, $start_col=25, $end_row=0, $end_col=26);
      $writer->markMergedCell($sheet1, $start_row=1, $start_col=25, $end_row=2, $end_col=26);
      $writer->markMergedCell($sheet1, $start_row=3, $start_col=25, $end_row=3, $end_col=26);

      $writer->markMergedCell($sheet1, $start_row=0, $start_col=27, $end_row=0, $end_col=28);
      $writer->markMergedCell($sheet1, $start_row=1, $start_col=27, $end_row=2, $end_col=28);
      $writer->markMergedCell($sheet1, $start_row=3, $start_col=27, $end_row=3, $end_col=28);

      // $writer->markMergedCell($sheet1, $start_row=0, $start_col=28, $end_row=0, $end_col=29);
      // $writer->markMergedCell($sheet1, $start_row=1, $start_col=28, $end_row=2, $end_col=29);
      // $writer->markMergedCell($sheet1, $start_row=3, $start_col=28, $end_row=3, $end_col=29);

      // $writer->markMergedCell($sheet1, $start_row=4, $start_col=3, $end_row=4, $end_col=4);

      $writer->markMergedCell($sheet1, $start_row=7, $start_col=2, $end_row=7, $end_col=5);

      $writer->markMergedCell($sheet1, $start_row=6, $start_col=0, $end_row=5, $end_col=0);
      $writer->markMergedCell($sheet1, $start_row=6, $start_col=1, $end_row=5, $end_col=1);
      $writer->markMergedCell($sheet1, $start_row=6, $start_col=2, $end_row=5, $end_col=2);
      $writer->markMergedCell($sheet1, $start_row=6, $start_col=3, $end_row=5, $end_col=3);
      $writer->markMergedCell($sheet1, $start_row=6, $start_col=4, $end_row=5, $end_col=4);
      $writer->markMergedCell($sheet1, $start_row=6, $start_col=5, $end_row=5, $end_col=5);

      $writer->markMergedCell($sheet1, $start_row=5, $start_col=6, $end_row=5, $end_col=9);
      $writer->markMergedCell($sheet1, $start_row=7, $start_col=6, $end_row=7, $end_col=9);

      $writer->markMergedCell($sheet1, $start_row=5, $start_col=10, $end_row=6, $end_col=10);
      $writer->markMergedCell($sheet1, $start_row=5, $start_col=11, $end_row=6, $end_col=11);
      $writer->markMergedCell($sheet1, $start_row=5, $start_col=12, $end_row=5, $end_col=15);
      $writer->markMergedCell($sheet1, $start_row=7, $start_col=10, $end_row=7, $end_col=15);

      $writer->markMergedCell($sheet1, $start_row=5, $start_col=16, $end_row=5, $end_col=21);
      $writer->markMergedCell($sheet1, $start_row=7, $start_col=16, $end_row=7, $end_col=21);

      $writer->markMergedCell($sheet1, $start_row=5, $start_col=22, $end_row=5, $end_col=28);
      $writer->markMergedCell($sheet1, $start_row=7, $start_col=22, $end_row=7, $end_col=28);

      $writer->markMergedCell($sheet1, $start_row=5, $start_col=29, $end_row=5, $end_col=30);
      $writer->markMergedCell($sheet1, $start_row=7, $start_col=29, $end_row=7, $end_col=30);

      $writer->writeToStdOut();
    }

    // ============================ CHECK AREA =====================================

    public function cekapi()
    {
      $data = $this->M_fp->agag();
      echo "<pre>";
      print_r($data);
      // echo sizeof($data);
      die;
    }
}
