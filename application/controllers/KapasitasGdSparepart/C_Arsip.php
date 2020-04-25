<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Arsip extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_arsip');
		$this->load->model('KapasitasGdSparepart/M_packing');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Arsip SPB/DO';
		$data['Menu'] = 'Arsip SPB/DO';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getdata = $this->M_arsip->getDataSPB();
		$data['data'] = array();
		foreach ($getdata as $val) {
			$coly = $this->M_packing->cekPacking($val['NO_DOKUMEN']);
			$val['COLY'] = count($coly);
			$tgl 	= $this->M_arsip->dataSPB($val['NO_DOKUMEN']);
			$val['MTRL'] = $tgl[0]['MTRL'];
			array_push($data['data'], $val);
		}
        // echo "<pre>";print_r($data['data']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Arsip', $data);
		$this->load->view('V_Footer',$data);
	}

	public function editColy(){
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$nomor 	= $this->input->post('no');

		$cek = $this->M_packing->cekPacking($nospb);
		// echo "<pre>";print_r($cek);exit();
		$tr = '';
		
		if (!empty($cek)) {
			$no = 1;
			foreach ($cek as $val) {
				if ($val['kode_packing'] == 1) {
					$kemasan = 'KARDUS KECIL';
				}elseif ($val['kode_packing'] == 2) {
					$kemasan = 'KARDUS SEDANG';
				}elseif ($val['kode_packing'] == 3) {
					$kemasan = 'KARDUS PANJANG';
				}elseif ($val['kode_packing'] == 4) {
					$kemasan = 'KARUNG';
				}elseif ($val['kode_packing'] == 5) {
					$kemasan = 'PETI';
				}
				$tr .= '<tr>
							<td>'.$no.'</td>
							<td><select class="form-control select2" id="jenis_kemasan'.$no.'" name="jenis_kemasan" style="width:100%" data-placeholder="pilih kemasan" onchange="gantikemasan('.$no.')">
								<option value="'.$val['kode_packing'].'">'.$kemasan.'</option>
								<option value="1">KARDUS KECIL</option>
								<option value="2">KARDUS SEDANG</option>
								<option value="3">KARDUS PANJANG</option>
								<option value="4">KARUNG</option>
								<option value="5">PETI</option>
								</select>
							</td>
							<td><input type="text" class="form-control" id="berat'.$no.'" name="berat" value="'.$val['berat'].'" onchange="gantikemasan('.$no.')">
							<input type="hidden" id="no_spb'.$no.'" value="'.$nospb.'"></td>
						</tr>';
						$no++;
			}
				$no++;
		}
		$tbl = '<div class="table-responsive">
			<table class="table table-stripped table-hovered text-center" style="width:100%">
				<thead>
					<tr>
						<td>No</td>
						<td>Jenis Kemasan</td>
						<td>Berat (KG)</td>
					</tr>
				</thead>
				<tbody id="tambahbrt">
					'.$tr.'
				</tbody>
			</table>
		</div>
		<input type="hidden" id="jenis" value="'.$jenis.'">
		<input type="hidden" id="no_spb" value="'.$nospb.'">
		<input type="hidden" id="no" value="'.$nomor.'">';

		echo $tbl;
	}

}
