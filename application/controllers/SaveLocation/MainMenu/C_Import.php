<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Import extends CI_Controller {

	public function __construct()
    {
  	  parent::__construct();
      $this->load->library('session');
      $this->load->helper(array('url','download'));
      $this->load->library('form_validation');
      $this->load->model('lokasi-simpan/M_ImportFile');
      $this->load->database('oracle');

    }
  public function upload($message=NULL)
  {
    $data = array (
      'message' => $message,
            );
    $this->load->view('lokasi-simpan/Template/V_header');
    $this->load->view('lokasi-simpan/Template/V_navbar');
    $this->load->view('lokasi-simpan/Template/V_sidebar');
    $this->load->view('lokasi-simpan/lokasi-simpan/V_Upload',$data);
    $this->load->view('lokasi-simpan/Template/V_footer');
    $this->load->view('lokasi-simpan/Template/V_mainfooter');
  }

    public function import(){
        $user = $this->session->userdata('username');
        $sql1 ="select user_id from FND_USER where user_name ='$user'";
        $query1= $this->db->query($sql1);
        $username = $query1->result_array();
        $user_name = $username[0]['USER_ID'];

        $fileName = time().$_FILES['datafile']['name'];
        $config['upload_path'] = 'assets/import/file_temp/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('Excel');
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('datafile') ){
          $message = '<div class="row"> <div class="col-md-6 col-md-offset-3 " style="margin-top: 20px">
                           <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#c53838; text-align:center; color:white; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>You did not select any file Excel to upload.</div>  </div>
                      </div>';
         $this->upload($message);
        }
        else{
          $media = $this->upload->data();
          $inputFileName = 'assets/import/file_temp/'.$media['file_name'];
           
          try {
                  $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                  $objPHPExcel = $objReader->load($inputFileName);
              } catch(Exception $e) {
                  die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
              }
   
              $sheet = $objPHPExcel->getSheet(0);
              $highestRow = $sheet->getHighestRow();
              $highestColumn = $sheet->getHighestColumn();
              /*
              echo $highestRow;
              echo $highestColumn;
              exit();  */
                            
              for ($row = 3; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                  $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                  NULL,
                                                  TRUE,
                                                  FALSE);
                  //Sesuaikan sama nama kolom tabel di database   
                  if ($rowData[0][0] != null) {
                    $data = "1";
                    $org_id         = $rowData[0][1];
                    $sub_inv        = $rowData[0][2];
                    $kode_assy      = $rowData[0][3];
                    $type_assy      = $rowData[0][4];
                    $kode_item      = $rowData[0][5];
                    $locator        = $rowData[0][6];
                    $alamat_simpan  = $rowData[0][7];
                    $lppbmokib      = $rowData[0][8];
                    $picklist       = $rowData[0][9];
                    $username_save  = $user_name;
                    }
                  else {
                    $data = null;
                    }

                  if ($data !=null) {
                      $checkData = $this->M_ImportFile->CekData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator);
                      if ($checkData>0) {
                         $this->M_ImportFile->UpdateData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator,$alamat_simpan,$lppbmokib,$picklist,$username_save);
                      }
                      else{
                        $this->M_ImportFile->InsertData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator,$alamat_simpan,$lppbmokib,$picklist,$username_save);
                      }
                  }
                }
              unlink($inputFileName);
                    $message = '<div class="row">
                                                <div class="col-md-6 col-md-offset-3 " style="margin-top: 20px">
                                                  <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#22ad54; text-align:center; color:white; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Upload Completed</div>
                                                </div>
                                              </div>';
                      $this->upload($message);
              }
        }

        public function downloadtemplate() {
          force_download('assets/import/File_Upload_Lokasi_Simpan.xlsx',NULL);
        }
}


