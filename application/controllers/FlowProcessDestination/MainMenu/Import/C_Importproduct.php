<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Importproduct extends CI_Controller
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
			$this->load->model('FlowProcessDestination/M_importproduct');
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

	public function product()
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
			$this->load->view('FlowProcessDestination/MainMenu/Import/V_Importproduct',$data);
			$this->load->view('V_Footer',$data);
			// echo '<pre>';
			// print_r($data);
			// exit;

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

        public function importproduk(){
            
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

            for ($i=3; $i < count($sheets); $i++) { 
                $code = $sheets[$i]['B'];
				$name =  $sheets[$i]['C'];
				$id = $sheets[$i]['D'];
                $cekproduk = $this->M_importproduct->checkproduct($code, $name);
                if (count($cekproduk)>0){
                    $this->M_importproduct->updateproduct($code, $name, $id);
                }else{
                    $this->M_importproduct->insertproduct($code, $name, $id);
				}  
			}
			$this->session->set_flashdata('response',"Import Success");
            redirect(base_url('FlowProcess/ImportProduct'));
		}
    }