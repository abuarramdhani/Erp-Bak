<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->library('csvimport');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	public function BackUp()
    {
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Backup Data";
        $this->log_activity->activity_log($aksi, $detail);
        //
		// Load the DB utility class

		$this->load->dbutil();

		// Backup database dan dijadikan variable
		$backup = $this->dbutil->backup();

		// Load file helper dan menulis ke server untuk keperluan restore
		$this->load->helper('file');
		write_file('assets/upload/importPR/database/mybackup.zip', $backup);

		// Load the download helper dan melalukan download ke komputer
		$this->load->helper('download');
		force_download('mybackup.zip', $backup);

    }

	public function Restore()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';


        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['action'] = site_url('PayrollManagement/TransaksiHitungThr/hitung');

    }

	public function ClearData()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';


        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['action'] = site_url('PayrollManagement/TransaksiHitungThr/hitung');

    }

	 public function checkSession(){
        if($this->session->is_logged){

        }else{
            redirect(site_url());
        }
    }

}

/* End of file C_TransaksiHitungThr.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiTHR/C_TransaksiHitungThr.php */
/* Generated automatically on 2016-11-28 15:07:51 */
