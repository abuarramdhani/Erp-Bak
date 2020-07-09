<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataPekerja extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('Log_Activity');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_upahphl');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$tpri = $this->M_upahphl->ambilPekerjaHL();
		$tdat = $this->M_upahphl->ambilDataPekerjaHL();

		foreach ($tpri as $key) {
			$noind = $key['noind'];
			$nama  = $key['nama'];
			$kdpkj = $key['kdpekerjaan'];
			$loker = $key['lokasi_kerja'];
			$puasa = $key['puasa'];
			if ($puasa == 't' or $puasa == 'true' or$puasa == '1') {
				$puasa = 'true';
			}else{
				$puasa = 'false';
			}

			$cek = $this->M_upahphl->cekdataAda($noind,$nama,$kdpkj,$loker);
			if ($cek=='0') {
				$array = array(
								'noind' => $noind,
								'nama' => $nama,
								'kode_pekerjaan' => $kdpkj,
								'lokasi_kerja' => $loker,
								'puasa'	=> $puasa
							);
				$this->M_upahphl->insertDataPekerja($array);
			}else{
				$array = array(
								'noind' => $noind,
								'nama' => $nama,
								'kode_pekerjaan' => $kdpkj,
								'lokasi_kerja' => $loker,
								'puasa'	=> $puasa
							);
				$this->M_upahphl->updateDataPekerjaHlcm($noind,$nama,$array);
			}
		}

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_DataPekerja',$data);
		$this->load->view('V_Footer',$data);

	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function getDataPekerja()
	{
		$lokasi_kerja = $this->input->post('loker');
		$data = $this->M_upahphl->getDataPekerja($lokasi_kerja);
		$no = 1;
		$tr = "";
		$pekerja ="";
		$puasa = "";

		foreach ($data as $key) {
			$id = $key['id_pekerja'];
			 if($key['kode_pekerjaan'] == '405010110') {
				$pekerja = "KEPALA TUKANG";
			}elseif ($key['kode_pekerjaan'] == '405010111') {
				$pekerja = "TUKANG";
			}elseif ($key['kode_pekerjaan'] == '405010112') {
				$pekerja = "SERABUTAN";
			}elseif ($key['kode_pekerjaan'] == '405010113') {
				$pekerja = "TENAGA";
			}

			if ($key['puasa'] == 't' or $key['puasa'] == '0' or $key['puasa'] == 'true') {
				$puasa = "Ya";
			}else{
				$puasa = "Tidak";
			}
			$tr = $tr."<tr>
			<td>".$no."</td>
			<td>".$key['noind']."</td>
			<td>".$key['nama']."</td>
			<td>".$pekerja."</td>
			<td>".$key['no_rekening']."</td>
			<td>".$key['atas_nama']."</td>
			<td>".$key['nama_bank']."</td>
			<td>".$key['cabang']."</td>
			<td>".$puasa."</td>
			<td style='text-align:center;'><a href='".base_url('HitungHlcm/DataPekerja/editData'.'/'.$id)."'><span class='glyphicon glyphicon-edit'></span></a>
			<a style='margin-left:5px;' href='".base_url('HitungHlcm/DataPekerja/deleteData'.'/'.$id)."'><span class='glyphicon glyphicon-trash'></span></a>
			</td>
			</tr>";

			$no++;
		}
		echo $tr;
	}


	public function editData($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['id'] = $id;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_upahphl->ambilDataPek($id);
		$er = $data['data'];

		$kdpkj = $er[0]['kode_pekerjaan'];
		$data['pekerjaan'] = $this->M_upahphl->pekerjaankode($kdpkj);
		if ($er[0]['bank'] != null or $er[0]['bank'] != "") {
			$kdbank = $er[0]['bank'];
			$bank = $this->M_upahphl->ambilnamaBank($kdbank);
			$data['bank'] = $bank[0]['nama_bank'];
		}else {
			$data['bank'] = "";
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_EditDataPekerja',$data);
		$this->load->view('V_Footer',$data);
	}
	public function simpanEditDataPekerja()
	{
		$id = $this->input->post('noind_pekerja');
		$lokasi_kerja= $this->input->post('pekerja_cbg');
		$noind= $this->input->post('noindpekerja');
		$nama= $this->input->post('namapekerja');
		$pekerjaan= $this->input->post('pekerjaan');
		$norek= $this->input->post('norekening');
		$atas_nama= $this->input->post('atasnama');
		$bank= $this->input->post('bankpekerja');
		$cabang= $this->input->post('cabangbank');

		$p = $this->M_upahphl->pekerjaan($pekerjaan);
		$kdpkj = $p[0]['kdpekerjaan'];

		$array = array(
						'lokasi_kerja' => $lokasi_kerja,
						'noind' => $noind,
						'nama' => $nama,
						'kode_pekerjaan' => $kdpkj,
						'no_rekening' => $norek,
						'atas_nama' => $atas_nama,
						'bank' => $bank,
						'cabang' => $cabang,
						'last_updated' => date('Y-m-d H:i:s'),
					);
		$this->M_upahphl->updateDataPekerja($array,$id);
		//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'UPDATE DATA PEKERJA ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
		//
		redirect ('HitungHlcm/DataPekerja');
	}

	public function deleteData($id)
	{
		$this->M_upahphl->deleteDataPekerja($id);
		//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'DELETE DATA PEKERJA ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('HitungHlcm/DataPekerja');
	}

	public function ambilpekerja()
	{
		$lokasi_kerja = $this->input->get('lokasi_kerja');
		$pekerja = strtoupper($this->input->get('term'));
		$data = $this->M_upahphl->getPekerja($pekerja,$lokasi_kerja);

		echo json_encode($data);
	}

	public function ambilBank()
	{
		$bank = strtoupper($this->input->get('term'));
		$data = $this->M_upahphl->getBank($bank);

		echo json_encode($data);
	}
	public function namaChange()
	{
		$noind = $this->input->post('noind');
		$data = $this->M_upahphl->changeNama($noind);
		$array = array(
					'nama' => $data[0]['nama'],
					'pekerjaan' => $data[0]['pekerjaan']
					);

		echo json_encode($array);

	}

	public function batalkan()
	{
		redirect('HitungHlcm/DataPekerja');
	}
	public function simpanDataPekerja()
	{
		$pekerjaan 	= $this->input->post('pekerjaan');

		$data 	 	= $this->M_upahphl->pekerjaan($pekerjaan);
		$kd_pkj 	= $data[0]['kdpekerjaan'];
		$lokasi_kerja = $this->input->post('pekerja_cbg');
		$noind		= $this->input->post('noindpekerja');
		$nama 		= $this->input->post('namapekerja');
		$norek 		= $this->input->post('norekening');
		$atas_nama	= $this->input->post('atasnama');
		$bank 		= $this->input->post('bankpekerja');
		$cabang 	= $this->input->post('cabangbank');

		$array = array(
						'noind' => $noind,
						'nama' => $nama,
						'kode_pekerjaan' => $kd_pkj,
						'lokasi_kerja' => $lokasi_kerja,
						'no_rekening' => $norek,
						'atas_nama' => $atas_nama,
						'bank' => $bank,
						'cabang' => $cabang,
					);
		$this->M_upahphl->simpanDataPekerja($array);

		//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'SAVE DATA PEKERJA NOIND='.$noind;
			$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('HitungHlcm/DataPekerja');
	}
}
