<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Peminjaman extends CI_Controller
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
		$this->load->model('MonitoringGdSparepart/M_peminjaman');

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

		$data['Title'] = 'Monitoring Peminjaman Barang Tanpa Surat';
		$data['Menu'] = 'Monitoring Peminjaman Barang';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringGdSparepart/V_Peminjaman', $data);
		$this->load->view('V_Footer',$data);
    }
    
	
	public function getPeminjam(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_peminjaman->getPeminjam($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getSeksi(){
		$noind = $this->input->post('noind');
		$data = $this->M_peminjaman->getSeksi($noind);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data[0]['seksi']);
	}
	
	public function tambah_peminjam(){
		$x = $this->input->post('x');
		echo '<tr class="tr_peminjam">
				<td><select id="nama_peminjam'.$x.'" name="nama_peminjam[]" class="form-control select2 getpeminjam" style="width:200px" data-placeholder="nama peminjam" onchange="getSeksi('.$x.')" required></select></td>
				<td><input id="seksi_peminjam'.$x.'" name="seksi_peminjam[]" class="form-control" style="width:300px" placeholder="seksi peminjam" readonly></td>
				<td><select id="kode_barang'.$x.'" name="kode_barang[]" class="form-control select2 getkodebrgpeminjaman" style="width:200px" data-placeholder="kode barang" onchange="getDescBarang('.$x.')" required></select></td>
				<td><input id="nama_barang'.$x.'" name="nama_barang[]" class="form-control" style="width:300px" placeholder="nama barang" readonly></td>
				<td><input type="number" id="qty'.$x.'" name="qty[]" class="form-control" style="width:100px" placeholder="quantity" autocomplete="off" required></td>
				<td><textarea id="alasan'.$x.'" name="alasan[]" placeholder="alasan" style="width:300px" ></textarea></td>
				<td><select id="pic'.$x.'" name="pic[]" class="form-control select2 picGDSP" style="width:200px" data-placeholder="pic" required></select></td>
				<td><button type="button" id="btn_tambah" class="btn tombolhapus'.$x.'"><i class="fa fa-minus"></i></button>
					<input type="hidden" class="nomor" value="'.$x.'">
				</td>
			</tr>';
	}

	public function tbl_peminjaman(){
		$data['user'] = $this->session->user;
		$getdata = $this->M_peminjaman->getdatapeminjaman();
		foreach ($getdata as $key => $value) {
			$nama = $this->M_peminjaman->getPeminjam($value['NAMA_PEMINJAM']);
			$getdata[$key]['NAMANYA'] = $nama[0]['nama'];
		}
		$data['data'] = $getdata;
		$this->load->view('MonitoringGdSparepart/V_TblPeminjaman', $data);
	}

	public function savePeminjaman(){
		$nama_peminjam 	= $this->input->post('nama_peminjam[]');
		$seksi_peminjam = $this->input->post('seksi_peminjam[]');
		$kode_barang 		= $this->input->post('kode_barang[]');
		$nama_barang 		= $this->input->post('nama_barang[]');
		$qty 						= $this->input->post('qty[]');
		$alasan 				= $this->input->post('alasan[]');
		$pic 						= $this->input->post('pic[]');

		for ($i=0; $i < count($kode_barang) ; $i++) { 
			$cekid 	= $this->M_peminjaman->getdatapeminjaman();
			$id 		= $cekid ? $cekid[0]['ID_PEMINJAMAN'] + 1 : 1;
			$save 	= $this->M_peminjaman->savePeminjaman($id, $nama_peminjam[$i], $seksi_peminjam[$i], $kode_barang[$i], $nama_barang[$i], $qty[$i], $alasan[$i], $pic[$i]);
		}
		
		redirect(base_url('MonitoringGdSparepart/PeminjamanBarang'));
	}

	public function updatePeminjaman(){
		$id = $this->input->post('id');
		$update = $this->M_peminjaman->updatePeminjaman($id);
	}

}