<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_KompensasiLembur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/KompensasiLembur/M_kompensasilembur');
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
        
        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Kompensasi Lembur';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompensasiLembur/V_index', $data);
        $this->load->view('V_Footer',$data);
		
		$this->session->unset_userdata('empty');
    }

    public function checkSession(){
        if($this->session->is_logged){
            
        }else{
            redirect(site_url());
        }
    }
	
	public function check_kompensasi(){
		$this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Kompensasi Lembur';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$varYear	= $this->input->post('txtPeriodeCheck',TRUE);
		$varYear 	= substr($varYear,0,4);
		// echo $varYear;
		$getKomLembur	= $this->M_kompensasilembur->getKomLembur($varYear);
		
		$data['konpensasi_lembur'] = $getKomLembur;
		
		$this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompensasiLembur/V_index', $data);
        $this->load->view('V_Footer',$data);
	}
	
	public function hitung_kompensasi(){
		$this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Kompensasi Lembur';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$varYear	= $this->input->post('txtPeriodeTahun',TRUE);
		$getMasterPekerja	= $this->M_kompensasilembur->getMasterPekerja($varYear);
		foreach($getMasterPekerja as $row){
			$noind = $row->noind;
			$count	= $this->M_kompensasilembur->hitungKompLembur($noind,$varYear);
			foreach($count as $row){
				$jmlKomp	= $row->konpensasi_lembur;
			}
			if(!empty($jmlKomp)){
				$checkKompLembur	= $this->M_kompensasilembur->checkKompLembur($noind,$varYear);
				if($checkKompLembur->num_rows()< 1){
					$data = array(
						'tanggal'	=> str_replace(' ','',$varYear."-12-31"),
						'noind'		=> $noind,
						'jumlah_konpensasi' => $jmlKomp,
						'kode_petugas'	=> $user_id,
						'tgl_jam_record' => date('Y-m-d H:i:s'),
					);
					$this->M_kompensasilembur->insert($data);
				}else{
					$data_update = array(
						'jumlah_konpensasi' => $jmlKomp,
						'kode_petugas'	=> $user_id,
						'tgl_jam_record' => date('Y-m-d H:i:s'),
					);
					$this->M_kompensasilembur->update($varYear,$noind,$data_update);
				}
			}else{
				 $this->session->set_flashdata('flashSuccess', 'This is a success message.');
					$ses=array(
						 "empty" => 1
					);
			}
		}
		$getKomLembur	= $this->M_kompensasilembur->getKomLembur($varYear);
		$data['kompensasi_lembur'] = $getKomLembur;
		$data['count_periode'] = $varYear;
		
		$this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/KompensasiLembur/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata('empty');
	}

    public function formValidation()
    {
	}

}

/* End of file C_TransaksiHutang.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiHutang/C_TransaksiHutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */