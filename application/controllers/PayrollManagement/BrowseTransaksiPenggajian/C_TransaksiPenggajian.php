<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiPenggajian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/BrowseTransaksiPenggajian/M_transaksipenggajian');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/BrowseTransaksiPenggajian/V_index', $data);
        $this->load->view('V_Footer',$data);
    }
	
	public function Hitung(){
		$this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
	//Variable yang di gunakan
		$varPeriode	= $this->input->post('txtPeriodeHitung',TRUE);
		$varYear		= substr($varPeriode,0,4);
		$varMonth		= substr($varPeriode,5,2);
	
	//Check Periode penggajian sudah di lakukan atau belum
		$checkPeriode	= $this->M_transaksipenggajian->checkPeriode($varYear,$varMonth);
		if($checkPeriode){
			$getDataPenggajian	= $this->M_transaksipenggajian->getDataPenggajian($varYear,$varMonth);
		}else{
			$getMasterPekerja	= $this->M_transaksipenggajian->getMasterPekerja();
			foreach($getMasterPekerja as $row1){
					// hitung nomor induk "B"
					if(substr($row1->noind,0,1)=="B"){
							echo $row1->noind."<br>";
					}
			}
		}
	}

    public function checkSession(){
        if($this->session->is_logged){
            
        }else{
            redirect(site_url());
        }
    }

    public function formValidation()
    {
	}

}

/* End of file C_TransaksiHutang.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiHutang/C_TransaksiHutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */