<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Importcomponent extends CI_Controller
{
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
            $this->load->library('session');
            $this->load->library('excel');
			$this->load->model('M_Index');
			$this->load->model('FlowProcessDestination/M_importcomponent');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('FlowProcessDestination/M_componentsetup');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

		public function component()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProcessDestination/MainMenu/Import/V_Importcomponent',$data);
			$this->load->view('V_Footer',$data);
			// echo '<pre>';
			// print_r($data);
			// exit;

        }
        public function importcomponent(){
            
			$this->checkSession();
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['data_input']  = array();
			$file_data = $_FILES['excel_file']['tmp_name'];
            $load = PHPExcel_IOFactory::load($file_data);
            $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
            // echo"<pre>";print_r($sheets);exit;
            // echo"<pre>";print_r(count($sheets));exit;
            // foreach ($sheets as $key) {
            //     $code = $key['B'];
            // //     $name =  $key['C'];
            //     echo"<pre>";print_r($code);print_r($name);
            // }exit;

            for ($i=3; $i < count($sheets); $i++) { 
                $product = $sheets[$i]['B'];
				// $getid = $this->M_importcomponent->getid($product);
				    // echo"<pre>";print_r($getid);exit;
                // $product_id = $getid[0]['product_id'];
                $drw_group =  $sheets[$i]['C'];
                $drw_code =  $sheets[$i]['D'];
                $drw_description =  $sheets[$i]['E'];
                $rev =  $sheets[$i]['F'];
                $drw_date =  $sheets[$i]['G'];
                $drw_material =  $sheets[$i]['H'];
                $weight =  $sheets[$i]['I'];
                $status =  $sheets[$i]['J'];
                $changing_ref_doc =  $sheets[$i]['K'];
                $changing_ref_explanation =  $sheets[$i]['L'];
                $qty =  $sheets[$i]['M'];
                $id =  $sheets[$i]['N'];
                $cekkomponen = $this->M_importcomponent->checkcomponent($drw_code, $rev);
                if (count($cekkomponen)>0){
                    $update = $this->M_importcomponent->updateproduct($id, $product,$drw_group,$drw_code,$drw_description,$drw_date,$drw_material,$rev,$weight, $status,$changing_ref_doc,$changing_ref_explanation);
                }else{
					$insert = $this->M_importcomponent->insertproduct($id, $product,$drw_group,$drw_code,$drw_description,$drw_date,$drw_material,$rev,$weight, $status,$changing_ref_doc,$changing_ref_explanation);
				}  
                // echo"<pre>";
                // print_r($apa);
                // exit;
                // print_r($product);
                // print_r($drw_group);
                // print_r($drw_code);
                // print_r($drw_description);
                // print_r($rev);
                // print_r($drw_date);
                // print_r($drw_material);
                // print_r($weight);
                // print_r($status);
                // print_r($changing_ref_doc);
                // print_r($changing_ref_explanation);
			}
			// exit;
			$this->session->set_flashdata('response',"Import Success!");
            redirect(base_url('FlowProcess/ImportComponent'));
		}
    }