<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RiwayatInsentifKemahalan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
		$this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/MasterInsKemahalan/M_riwayatinsentifkemahalan');
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

        $data['Menu'] = 'Master Pekerja';
        $data['SubMenuOne'] = 'Master Ins Kemahalan';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $riwayatInsentifKemahalan = $this->M_riwayatinsentifkemahalan->get_all(date('Y-m-d'));

        $data['riwayatInsentifKemahalan_data'] = $riwayatInsentifKemahalan;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatInsentifKemahalan/V_index', $data);
        $this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_import');
		$this->session->unset_userdata('success_delete');
		$this->session->unset_userdata('success_update');
		$this->session->unset_userdata('success_insert');
		$this->session->unset_userdata('not_found');
    }

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatinsentifkemahalan->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Master Pekerja',
            	'SubMenuOne' => 'Master Ins Kemahalan',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_insentif_kemahalan' => $row->id_insentif_kemahalan,
				'tgl_berlaku' => $row->tgl_berlaku,
				'tgl_tberlaku' => $row->tgl_tberlaku,
				'noind' => $row->noind,
				'insentif_kemahalan' => $row->insentif_kemahalan,
				'kode_petugas' => $row->kode_petugas,
				'tgl_record' => $row->tgl_record,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatInsentifKemahalan/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Master Pekerja',
            'SubMenuOne' => 'Master Ins Kemahalan',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
            'action' => site_url('PayrollManagement/RiwayatInsentifKemahalan/save'),
				'id_insentif_kemahalan' => set_value(''),
			'tgl_berlaku' => set_value('tgl_berlaku'),
			'tgl_tberlaku' => set_value('tgl_tberlaku'),
			'noind' => set_value('noind'),
			'insentif_kemahalan' => set_value('insentif_kemahalan'),
			'kode_petugas' => set_value('kode_petugas'),
			'tgl_record' => set_value('tgl_record'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/RiwayatInsentifKemahalan/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save()
    {
        $this->formValidation();


            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'insentif_kemahalan' => str_replace(",","",$this->input->post('txtInsentifKemahalan',TRUE)),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);

			$data_riwayat	= array(
				'tgl_tberlaku'	=>	$this->input->post('txtTglBerlaku',TRUE),
			);
            $this->M_riwayatinsentifkemahalan->update_riwayat($this->input->post('txtNoind',TRUE),'9999-12-31',$data_riwayat);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Create Master Ins Kemahalan noind=".$this->input->post('txtNoind');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_riwayatinsentifkemahalan->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
					 "success_insert" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));

    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_riwayatinsentifkemahalan->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Master Pekerja',
                'SubMenuOne' => 'Master Ins Kemahalan',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
                'action' => site_url('PayrollManagement/RiwayatInsentifKemahalan/saveUpdate'),
				'id_insentif_kemahalan' => set_value('txtIdInsentifKemahalan', $row->id_insentif_kemahalan),
				'tgl_berlaku' => set_value('txtTglBerlaku', $row->tgl_berlaku),
				'tgl_tberlaku' => set_value('txtTglTberlaku', $row->tgl_tberlaku),
				'noind' => set_value('txtNoind', $row->noind),
				'insentif_kemahalan' => set_value('txtInsentifKemahalan', $row->insentif_kemahalan),
				'kode_petugas' => set_value('txtKodePetugas', $row->kode_petugas),
				'tgl_record' => set_value('txtTglRecord', $row->tgl_record),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/RiwayatInsentifKemahalan/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));
        }
    }

    public function saveUpdate()
    {
        $this->formValidation();


            $data = array(
				'tgl_berlaku' => $this->input->post('txtTglBerlaku',TRUE),
				'tgl_tberlaku' => '9999-12-31',
				'noind' => $this->input->post('txtNoind',TRUE),
				'insentif_kemahalan' => str_replace(",","",$this->input->post('txtInsentifKemahalan',TRUE)),
				'kode_petugas' => $this->session->userdata('userid'),
				'tgl_record' => date('Y-m-d H:i:s'),
			);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Update Master Ins Kemahalan ID=".$this->input->post('txtIdInsentifKemahalan');
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_riwayatinsentifkemahalan->update($this->input->post('txtIdInsentifKemahalan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
			$ses=array(
					 "success_update" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));

    }

    public function delete($id)
    {
        $row = $this->M_riwayatinsentifkemahalan->get_by_id($id);

        if ($row) {
            $this->M_riwayatinsentifkemahalan->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Master Ins Kemahalan ID=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->session->set_flashdata('message', 'Delete Record Success');
			$ses=array(
					 "success_delete" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
			$ses=array(
					 "not_found" => 1
				);
			$this->session->set_userdata($ses);
            redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));
        }
    }

	 public function import(){
		$config['upload_path'] = 'assets/upload/importPR/masterinskemahalan/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '6000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) { echo $this->upload->display_errors();}
        else {  $file_data  = $this->upload->data();
                $filename   = $file_data['file_name'];
                $file_path  = 'assets/upload/importPR/masterinskemahalan/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {

                $csv_array  = $this->csvimport->get_array($file_path);
                $data_exist = array();
                $i = 0;
                foreach ($csv_array as $row) {
                    if(array_key_exists('NOIND', $row)){

 						//ROW DATA
	                    $data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'insentif_kemahalan' => $row['INS_KEMAHALAN'],
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_record' => date('Y-m-d H:i:s'),
	                    );

                    	//CHECK IF EXIST
                    	$noind = $row['NOIND'];
	                   	$check = $this->M_riwayatinsentifkemahalan->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
							$this->M_riwayatinsentifkemahalan->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
							$this->M_riwayatinsentifkemahalan->insert($data);
	                    }else{
	                    	$this->M_riwayatinsentifkemahalan->insert($data);
	                    }

                	}else{
                		//ROW DATA
                		$data = array(
	                    	'tgl_berlaku' => date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							'tgl_tberlaku' => '9999-12-31',
							'noind' => $row['NOIND'],
							'insentif_kemahalan' => $row['INS_KEMAHALAN'],
							'kode_petugas' => $this->session->userdata('userid'),
							'tgl_record' => date('Y-m-d H:i:s'),
	                    );

	                    //CHECK IF EXIST
                    	$noind = $row['NOIND'];
	                   	$check = $this->M_riwayatinsentifkemahalan->check($noind);

	                    if($check){
	                    	$data_exist[$i] = $data;
	                    	$i++;
							$data_update = array(
								'tgl_tberlaku'	=> date("Y-m-d",strtotime($row['TGL_BERLAKU'])),
							);
							$this->M_riwayatinsentifkemahalan->update_riwayat($row['NOIND'],'9999-12-31',$data_update);
							$this->M_riwayatinsentifkemahalan->insert($data);
	                    }else{
	                    	$this->M_riwayatinsentifkemahalan->insert($data);
	                    }

                	}
                }

                //LOAD EXIST DATA VERIFICATION PAGE
                $this->checkSession();
        		$user_id = $this->session->userid;

        		$data['Menu'] = 'Master Pekerja';
        		$data['SubMenuOne'] = '';
        		$data['SubMenuTwo'] = '';

		        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		        $data['data_exist'] = $data_exist;
				$this->session->set_flashdata('message', 'Create Record Success');
				$ses=array(
						 "success_import" => 1
					);
				$this->session->set_userdata($ses);
				unlink($file_path);
				redirect(site_url('PayrollManagement/RiwayatInsentifKemahalan'));
            } else {
                $this->load->view('csvindex');
            }
        }
    }

    public function upload() {

        $config['upload_path'] = 'assets/upload/importPR/masterinskemahalan/';
        $config['file_name'] = 'MasterInsKemahalan-'.time();
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('importfile')) {
            echo $this->upload->display_errors();
        }
        else {
            $file_data  = $this->upload->data();
            $filename   = $file_data['file_name'];
            $file_path  = 'assets/upload/importPR/masterinskemahalan/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)){
                $data = $this->csvimport->get_array($file_path);
                $this->import($data, $filename);
            }
            else {
                $this->import($data = array(), $filename = '');
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

/* End of file C_RiwayatInsentifKemahalan.php */
/* Location: ./application/controllers/PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan.php */
/* Generated automatically on 2016-11-26 10:46:12 */
