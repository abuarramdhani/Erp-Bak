<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiHutang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Log_Activity');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/TransaksiHutang/M_transaksihutang');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
		$this->load->library('Encrypt');
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Hutang Karyawan';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$id = $this->input->get('id');
        $transaksiHutang = $this->M_transaksihutang->get_all($id);

        $data['transaksiHutang_data'] = $transaksiHutang;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHutang/V_index', $data);
        $this->load->view('V_Footer',$data);
    }

	public function list_($id){
		$this->checkSession();
        $user_id = $this->session->userid;

		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $data['Menu'] = 'Komponen Penggajian';
        $data['SubMenuOne'] = 'Hutang Karyawan';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$id = $this->input->get('id');
        $transaksiHutang = $this->M_transaksihutang->get_transaction_by_id($id);
		// echo $transaksiHutang;
		// exit();
        $data['transaksiHutang_data'] = $transaksiHutang;
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHutang/V_list', $data);
        $this->load->view('V_Footer',$data);
	}

	public function read($id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $row = $this->M_transaksihutang->get_by_id($id);
        if ($row) {
            $data = array(
            	'Menu' => 'Komponen Penggajian',
            	'SubMenuOne' => 'Hutang Karyawan',
            	'SubMenuTwo' => '',
            	'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            	'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            	'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),

				'id_transaksi_hutang' => $row->id_transaksi_hutang,
				'no_hutang' => $row->no_hutang,
				'tgl_transaksi' => $row->tgl_transaksi,
				'jenis_transaksi' => $row->jenis_transaksi,
				'jumlah_transaksi' => $row->jumlah_transaksi,
				'lunas' => $row->lunas,
			);

            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiHutang/V_read', $data);
            $this->load->view('V_Footer',$data);
        }
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
        }
    }

    public function create()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data = array(
            'Menu' => 'Komponen Penggajian',
            'SubMenuOne' => 'Hutang Karyawan',
            'SubMenuTwo' => '',
            'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
            'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
            'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
			'pr_jns_transaksi_data' => $this->M_transaksihutang->get_pr_jns_transaksi_data(),
            'action' => site_url('PayrollManagement/TransaksiHutang/save'),

			'noind' => set_value('noind'),
			'no_hutang' => set_value('no_hutang'),
			'tgl_transaksi' => set_value('tgl_transaksi'),
			'jenis_transaksi' => set_value('jenis_transaksi'),
			'jumlah_transaksi' => set_value('jumlah_transaksi'),
			'jumlah_angsuran' => set_value('jumlah_angsuran'),
			'lunas' => set_value('lunas'),
		);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/TransaksiHutang/V_form', $data);
        $this->load->view('V_Footer',$data);
    }

    public function save(){
        $this->formValidation();
		$idtransaksi = $this->input->post('txtIdTransaksiHutangNew',TRUE);
		$nohutang = $this->input->post('txtNoHutang',TRUE);
		$noind = $this->input->post('txtNoind',TRUE);
		$dt = explode("/",$this->input->post('txtTglTransaksi',TRUE));
		$tgl_transaksi = $dt[2]."-".$dt[1]."-".$dt[0];
		$jumlah_transaksi = str_replace(".","",$this->input->post('txtJumlahTransaksi',TRUE));
		$jumlah_angsuran = $this->input->post('txtJumlahAngsuran',TRUE);
		$lunas = $this->input->post('cmbLunas',TRUE);
		$jenis = $this->input->post('cmbJenisTransaksi',TRUE);
		$nohutang = str_replace(" ","",$noind.date("Ymd",strtotime($tgl_transaksi)));
		$angsuran = round($jumlah_transaksi/$jumlah_angsuran);
		$data = array(
			'no_hutang' => $nohutang,
			'noind' => $noind,
			'tgl_pengajuan' => $tgl_transaksi,
			'total_hutang' => $jumlah_transaksi,
			'jml_cicilan' => $jumlah_angsuran,
			'status_lunas' => $lunas,
			'kode_petugas' => $this->session->userid,
			'tgl_record' => date("Y-m-d H:i:s"),
		);
		for($i=1;$i<=$jumlah_angsuran;$i++){
			if($i<10){
				$id_transaksi = str_replace(" ","",$nohutang."0".$i);
			}else{
				$id_transaksi = str_replace(" ","",$nohutang.$i);
			}
			$tgl_angsuran = date('Y-m-d', strtotime("+".$i." months", strtotime($tgl_transaksi)));;
			$data2 = array(
				'id_transaksi_hutang' => $id_transaksi,
				'no_hutang' => $nohutang,
				'tgl_transaksi' => $tgl_angsuran,
				'jenis_transaksi' => $jenis,
				'jumlah_transaksi' => $angsuran,
				'lunas' => $lunas
			);

        $this->M_transaksihutang->insert($data2);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Insert Komponen Penggajian angsuran transaksi Hutang id_transaksi=".$id_transaksi;
        $this->log_activity->activity_log($aksi, $detail);
        //
		}

        $this->M_transaksihutang->insert_data($data);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create Komponen Penggajian transaksi Hutang id_transaksi=".$id_transaksi;
        $this->log_activity->activity_log($aksi, $detail);
        //
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('PayrollManagement/TransaksiHutang'));
    }

    public function update($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;

		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_transaksihutang->get_by_id($id);

        if ($row) {
            $data = array(
                'Menu' => 'Komponen Penggajian',
                'SubMenuOne' => 'Hutang Karyawan',
                'SubMenuTwo' => '',
                'UserMenu' => $this->M_user->getUserMenu($user_id,$this->session->responsibility_id),
                'UserSubMenuOne' => $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id),
                'UserSubMenuTwo' => $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id),
				'pr_jns_transaksi_data' => $this->M_transaksihutang->get_pr_jns_transaksi_data(),
                'action' => site_url('PayrollManagement/TransaksiHutang/saveUpdate'),

				'noind' => set_value('cmbNoHutang', $row->noind),
				'no_hutang' => set_value('cmbNoHutang', $row->no_hutang),
				'tgl_transaksi' => set_value('cmbTglTransaksi', date("d/m/Y",strtotime($row->tgl_pengajuan))),
				'jumlah_transaksi' => set_value('cmbJumlahTransaksi', number_format((int)$row->total_hutang,0,",",".")),
				'jumlah_angsuran' => set_value('cmbJumlahTransaksi', $row->jml_cicilan),
				'lunas' => set_value('cmbLunas', $row->status_lunas),
				);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PayrollManagement/TransaksiHutang/V_form', $data);
            $this->load->view('V_Footer',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
        }
    }

    public function saveUpdate(){
        $this->formValidation();
		$nohutang = $this->input->post('txtNoHutang',TRUE);
		$noind = $this->input->post('txtNoind',TRUE);
		$dt = explode("/",$this->input->post('txtTglTransaksi',TRUE));
		$tgl_transaksi = $dt[2]."-".$dt[1]."-".$dt[0];
		$jumlah_transaksi = str_replace(".","",$this->input->post('txtJumlahTransaksi',TRUE));
		$jumlah_angsuran = $this->input->post('txtJumlahAngsuran',TRUE);
		$lunas = $this->input->post('cmbLunas',TRUE);
		$jenis = $this->input->post('cmbJenisTransaksi',TRUE);
		$nohutang = str_replace(" ","",$noind.date("Ymd",strtotime($tgl_transaksi)));
		$angsuran = round($jumlah_transaksi/$jumlah_angsuran);
        $data = array(
			'noind' => $noind,
			'tgl_pengajuan' => $tgl_transaksi,
			'total_hutang' => $jumlah_transaksi,
			'jml_cicilan' => $jumlah_angsuran,
			'status_lunas' => $lunas,
			'kode_petugas' => $this->session->userid,
			'tgl_record' => date("Y-m-d H:i:s"),
		);
		$this->M_transaksihutang->delete($nohutang);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Delete Komponen Penggajian transaksi Hutang noind=".$noind;
        $this->log_activity->activity_log($aksi, $detail);
        //
		for($i=1;$i<=$jumlah_angsuran;$i++){
			if($i<10){
				$id_transaksi = str_replace(" ","",$nohutang."0".$i);
			}else{
				$id_transaksi = str_replace(" ","",$nohutang.$i);
			}
			$tgl_angsuran = date('Y-m-d', strtotime("+".$i." months", strtotime($tgl_transaksi)));;
			$data2 = array(
				'id_transaksi_hutang' => $id_transaksi,
				'no_hutang' => $nohutang,
				'tgl_transaksi' => $tgl_angsuran,
				'jenis_transaksi' => $jenis,
				'jumlah_transaksi' => $angsuran,
				'lunas' => $lunas
			);

        $this->M_transaksihutang->insert($data2);
        //insert to sys.log_activity
        $aksi = 'Payroll Management';
        $detail = "Create Komponen Penggajian angsuran transaksi Hutang id_transaksi=".$id_transaksi;
        $this->log_activity->activity_log($aksi, $detail);
        //
		}

        $this->M_transaksihutang->update($this->input->post('txtIdTransaksiHutang', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
		redirect(site_url('PayrollManagement/TransaksiHutang'));
    }

    public function delete($id)
    {
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
        $row = $this->M_transaksihutang->get_by_id($id);
        if ($row) {
            $this->M_transaksihutang->delete($id);
            //insert to sys.log_activity
            $aksi = 'Payroll Management';
            $detail = "Delete Komponen Penggajian transaksi Hutang id_transaksi=$id";
            $this->log_activity->activity_log($aksi, $detail);
            //
            $this->M_transaksihutang->delete_transaction($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('PayrollManagement/TransaksiHutang'));
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
