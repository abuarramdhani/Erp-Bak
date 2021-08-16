<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterData extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderToolMaking/M_monitoringorder');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Data Proses';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderToolMaking/V_MasterData', $data);
		$this->load->view('V_Footer',$data);
	}
	
    public function data_seksi(){
        $data['data'] = $this->db->select('mp.*')->order_by('mp.nama_seksi')->get('otm.otm_master_seksi mp')->result_array();
		$this->load->view('OrderToolMaking/V_Tblseksi', $data);
	}

    public function data_proses(){
        $data['data'] = $this->db->select('mp.*')->order_by('mp.nama_proses')->get('otm.otm_master_proses mp')->result_array();
		$this->load->view('OrderToolMaking/V_TblProses', $data);
	}
	
    public function data_mesin(){
        $data['data'] = $this->db->select('mp.*')->order_by('mp.nama_mesin')->get('otm.otm_master_mesin mp')->result_array();
		$this->load->view('OrderToolMaking/V_TblMesin', $data);
	}
	
	public function tambah_seksi(){
		$view = '
				<div class="modal-header" style="font-size:25px;">
					<i class="fa fa-list-alt"></i> Tambah Seksi
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="box-body">
						<div class="panel-body">
							<div class="col-md-4 text-right">
								<label>Nama Seksi:</label>
							</div>
							<div class="col-md-6">
								<select id="nama_seksi" class="form-control select2 userorder" data-placeholder="Pilih Nama Seksi" style="width:100%"></select>
							</div>
						</div>
						<div class="panel-body">
							<div class="col-md-4 text-right">
								<label>Kode Seksi:</label>
							</div>
							<div class="col-md-6">
							<select id="kode_seksi" class="form-control select2 seksiorder" data-placeholder="Pilih Kode Seksi" style="width:100%"></select>
							</div>
						</div>
						<div class="panel-body">
							<div class="col-md-12 text-center">
								<button type="button" class="btn bg-orange" style="margin-left:15px" onclick="saveseksiOTM(this)"><i class="fa fa-plus"></i> Tambah</button>
							</div>
						</div>
					</div>
				</div>';
		echo $view;
	}

		
	public function edit_seksi(){
        $data = $this->db->select('mp.*')->where("mp.id_seksi = ".$this->input->post('id')."")->get('otm.otm_master_seksi mp')->result_array();
		$view = '
				<div class="modal-header" style="font-size:25px;">
					<i class="fa fa-list-alt"></i> Edit Seksi
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="box-body">
						<div class="panel-body">
							<div class="col-md-4 text-right">
								<label>Nama Seksi:</label>
							</div>
							<div class="col-md-6">
								<select id="nama_seksi" class="form-control select2 userorder" data-placeholder="Pilih Nama Seksi" style="width:100%">
									<option value="'.$data[0]['nama_seksi'].'">'.$data[0]['nama_seksi'].'</option>
								</select>
								<input type="hidden" id="id_seksi" value="'.$data[0]['id_seksi'].'">
							</div>
						</div>
						<div class="panel-body">
							<div class="col-md-4 text-right">
								<label>Kode Seksi:</label>
							</div>
							<div class="col-md-6">
							<select id="kode_seksi" class="form-control select2 seksiorder" data-placeholder="Pilih Kode Seksi" style="width:100%">
								<option value="'.$data[0]['kode_seksi'].'">'.$data[0]['kode_seksi'].'</option>
							</select>
							</div>
						</div>
						<div class="panel-body">
							<div class="col-md-12 text-center">
								<button type="button" class="btn bg-orange" style="margin-left:15px" onclick="updateseksiOTM(this)"><i class="fa fa-check"></i> Update</button>
							</div>
						</div>
					</div>
				</div>';
		echo $view;
	}

    public function submit_seksi(){
        $nama = $this->input->post('nama');
        $kode = $this->input->post('kode');
        $cek = $this->db->select('mp.*')->where("mp.nama_seksi = '$nama'")->get('otm.otm_master_seksi mp')->result_array();
        if (empty($cek)) {
            $this->M_monitoringorder->save_seksi(array('nama_seksi' => $nama, 'kode_seksi' => $kode));
            echo json_encode('oke');
        }else {
            echo json_encode('not');
        }
	}
	
    public function update_seksi(){
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $kode = $this->input->post('kode');
		$this->M_monitoringorder->update_seksi($id,  $nama, $kode);
	}

    public function submit_proses(){
        $proses = $this->input->post('val');
        $cek = $this->db->select('mp.*')->where("mp.nama_proses = '$proses'")->get('otm.otm_master_proses mp')->result_array();
        if (empty($cek)) {
            $this->M_monitoringorder->save_proses(array('nama_proses' => $proses));
            echo json_encode('oke');
        }else {
            echo json_encode('not');
        }
	}
	
    public function submit_mesin(){
        $mesin = $this->input->post('val');
        $cek = $this->db->select('mp.*')->where("mp.nama_mesin = '$mesin'")->get('otm.otm_master_mesin mp')->result_array();
        if (empty($cek)) {
            $this->M_monitoringorder->save_mesin(array('nama_mesin' => $mesin));
            echo json_encode('oke');
        }else {
            echo json_encode('not');
        }
	}
	
    public function update_proses(){
        $id_proses = $this->input->post('id_proses');
        $nama_proses = $this->input->post('nama_proses');
        $this->M_monitoringorder->update_proses($id_proses,$nama_proses);
	}
	
    public function update_mesin(){
        $id_mesin = $this->input->post('id_mesin');
        $nama_mesin = $this->input->post('nama_mesin');
        $this->M_monitoringorder->update_mesin($id_mesin, $nama_mesin);
    }
    
    public function delete_proses(){
        $id_proses = $this->input->post('id_proses');
        $this->M_monitoringorder->delete_proses($id_proses);
	}
	
    public function delete_mesin(){
        $id_mesin = $this->input->post('id_mesin');
        $this->M_monitoringorder->delete_mesin($id_mesin);
	}
	
    public function delete_seksi(){
        $id_seksi = $this->input->post('id_seksi');
        $this->M_monitoringorder->delete_seksi($id_seksi);
    }

}