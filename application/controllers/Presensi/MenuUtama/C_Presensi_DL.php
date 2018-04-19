<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Presensi_DL extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
		$this->load->helper('url');
        $this->load->helper('html');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('Presensi/MainMenu/M_presensi_dl');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
public function Index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Presensi';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['SubMenuTwo'] = 'Presensi DL';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['Title'] = 'Monitoring Presensi Dinas Luar';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiDL/V_index', $data);
		$this->load->view('V_Footer',$data);
		
	}

public function get_js_pekerja()
	{
		$this->checkSession();

		$employee = $_GET['p'];
		$employee = strtoupper($employee);
		$data = $this->M_presensi_dl->getPekerja($employee);
		echo json_encode($data);
	}

public function get_js_seksi()
	{
		$this->checkSession();

		$seksi = $_GET['p'];
		$seksi = strtoupper($seksi);
		$data = $this->M_presensi_dl->getSeksi($seksi);
		echo json_encode($data);
	}

// public function seksi_disabled(){
// 		$noind = $this->input->post('noind');
// 		$get_seksi = $this->M_presensi_dl->getSeksi_byID($noind);
// 	}

public function CariDataDinasLuar(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$v_pencarian	= $this->input->post('Pencarian');
		$v_noind		= $this->input->post('NamaPekerja');
		$v_tanggal 	= $this->input->post('txtTglBerangkat_prs');
		$v_dept		= $this->input->post('cmbDepartemen');
		$v_bidang		= $this->input->post('cmbBidang');
		$v_unit		= $this->input->post('cmbUnit');
		$v_seksi		= $this->input->post('cmbSeksi');

		$split_tanggal = explode(' - ',$v_tanggal);
		$klausa_where = $this->klausa_where($v_noind,$split_tanggal[0],$split_tanggal[1],$v_dept,$v_bidang,$v_unit,$v_seksi);
		$data['Presensi'] = $this->M_presensi_dl->pencarian_pekerja_dl($klausa_where);
		$data['Monitoring'] = $this->M_presensi_dl->monitoring_pekerja_dl($klausa_where);
		$data['ConvertPresensi'] = $this->M_presensi_dl->convert_pekerja_dl($klausa_where,$split_tanggal[1]);
		$data['Menu'] = 'Presensi';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['SubMenuTwo'] = 'Presensi DL';
		$data['SubMenuOne'] = 'Presensi DL';
		$data['Title'] = 'Monitoring Presensi Dinas Luar';
		$data['Pencarian'] = $v_pencarian;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiDL/V_data', $data);
		$this->load->view('V_Footer',$data);

	}

public function fileDinasLuar($spdl){
		$data['SuratTugas'] 		= $this->M_presensi_dl->getSuratTugas($spdl);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 5, 5, 0, 0, 'P');
		$filename = 'SuratTugas.pdf';
		$html = $this->load->view('Presensi/MainMenu/PresensiDL/V_export',$data, true);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
}

private function klausa_where($noind,$tanggal1,$tanggal2,$dept,$bidang,$unit,$seksi){
	if($noind!=null || $tanggal1!=null || $dept!=null){
            $where = "where";
        }else{
            $where = "";
        }
        if($seksi==null){
            if($unit==null){
                if($bidang==null){
                    if($dept==null || $dept=='0'){
                        $dept = "";
                    }else{
                        if($dept!=null && ($tanggal1!=null || $noind!=null)){
                            $dept = "and left(kodesie,1)='$dept'";
                        }else{
                            $dept = "left(kodesie,1)='$dept'";
                        }
                    }
                }else{
                    $dept = "";
                    $bidang = "and left(kodesie,3)='$bidang'";
                }
            }else{
                $dept = "";
                $bidang = "";
                $unit = "and left(kodesie,5)='$unit'";
            }
        }else{
            $dept = "";
            $bidang = "";
            $unit = "";
            $seksi = "and left(kodesie,7)='$seksi'";
        }
        if($tanggal1!=null){
            if($noind!=null){
                $tanggal = "and tanggal between '$tanggal1' and '$tanggal2'";
            }else{
                $tanggal = "tanggal between '$tanggal1' and '$tanggal2'";
            }
        }
        if($noind!=null){
            $noind = "noind='$noind'";
        }

        $klausa_where = $where." ".$noind." ".$tanggal." ".$dept." ".$bidang." ".$unit." ".$seksi;
        return $klausa_where;
}

}