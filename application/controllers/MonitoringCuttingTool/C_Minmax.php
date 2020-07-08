<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Minmax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('MonitoringCuttingTool/M_minmax');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		// $this->checkSession();
		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Setting Min Max';
		$data['Menu'] = 'Setting Min Max';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$getdata = $this->M_minmax->getdata();
		foreach ($getdata as $key => $value) {
			$desc = $this->M_minmax->getdesc($value['item']);
			$getdata[$key]['desc'] = !empty($desc) ? $desc[0]['DESCRIPTION'] : '';
		}
		$data['data'] = $getdata;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCuttingTool/V_Minmax',$data);
		$this->load->view('V_Footer',$data);
    }

    public function getitem(){
        $term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_minmax->getKode($term);
		echo json_encode($data);
    }

    public function Save(){
        $item 	= $this->input->post('item');
        $min 	= $this->input->post('min_trtks');
		$max 	= $this->input->post('max_trtks');

        $cek = $this->M_minmax->cekdata($item);
        if (empty($cek)) {
            $this->M_minmax->insertdata($item, $min, $max);
        }else{
            $this->M_minmax->updatedata($item, $min, $max);
		}
		redirect(base_url('MonitoringCuttingTool/SettingMin'));
	}
	

	public function EditMinmax(){
        $item = $this->input->post('item');
        $min = $this->input->post('min');
		$max = $this->input->post('max');
		$desc = $this->M_minmax->getdesc($item);
		
		$view = '
					<center><h3 class="modal-title">Edit Data Minmax</h3></center>
					<div class="panel-body">
						<div class="col-md-3" style="text-align:right">
							<label>Kode Barang :</label>
						</div>
						<div class="col-md-7">
							<input name="item" class="form-control" value="'.$item.'" readonly>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-3" style="text-align:right">
							<label>Deskripsi Barang :</label>
						</div>
						<div class="col-md-7">
							<input name="desc" class="form-control" value="'.$desc[0]['DESCRIPTION'].'" readonly>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-3" style="text-align:right">
							<label>Min :</label>
						</div>
						<div class="col-md-3">
							<input type="number" name="min_trtks" class="form-control" value="'.$min.'">
						</div>
						<div class="col-md-1" style="text-align:right">
							<label>Max :</label>
						</div>
						<div class="col-md-3">
							<input type="number" name="max_trtks" class="form-control" value="'.$max.'">
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-12" style="text-align:center">
							<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Save</button>
						</div>
					</div>';

		echo $view;
	}

	public function Tambah(){		
		$view = '
					<center><h3 class="modal-title">Data Minmax Baru</h3></center>
					<div class="panel-body">
						<div class="col-md-3" style="text-align:right">
							<label>Kode Barang :</label>
						</div>
						<div class="col-md-7">
							<select name="item" class="form-control select2 getkodebrg" data-placeholder="pilih kode barang - deskripsi barang" style="width: 100%;">
								<option></option>
							</select>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-3" style="text-align:right">
							<label>Min :</label>
						</div>
						<div class="col-md-3">
							<input type="number" name="min_trtks" class="form-control" placeholder="min tr-tks" autocomplete="off">
						</div>
						<div class="col-md-1" style="text-align:right">
							<label>Max :</label>
						</div>
						<div class="col-md-3">
							<input type="number" name="max_trtks" class="form-control" placeholder="max tr-tks" autocomplete="off">
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-12" style="text-align:center">
							<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
						</div>
					</div>';

		echo $view;
	}
    
}