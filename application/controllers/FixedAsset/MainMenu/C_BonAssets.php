<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_BonAssets extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		$this->load->model('FixedAsset/MainMenu/M_bonassets');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->load->library('Excel');
		$this->checkSession();
	}
	
	public function checkSession(){
			if($this->session->is_logged){
				
			}else{
				redirect('');
			}
		}
	
	public function Index ()
	{	$user_id = $this->session->userid;
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('FixedAsset/MainMenu/BonAsset/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function search ()
	{	$user_id = $this->session->userid;
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$receiptnum = $this->input->post('txtReceipt');
		$ponum = $this->input->post('txtPonum');
		$data['assets'] = $this->M_bonassets->search($receiptnum, $ponum);

		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('FixedAsset/MainMenu/BonAsset/V_search',$data);
		$this->load->view('V_Footer',$data);
	}

	public function input ()
	{	$user_id = $this->session->userid;
		$usercode = $this->session->user;
		
		$data['seksi'] = $this->M_bonassets->getSeksi($usercode);	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';

		$data['Kode'] = $this->input->post('hdnKode');
		$data['Deskripsi'] = $this->input->post('hdnDeskripsi');
		$data['Pp'] = $this->input->post('hdnPp');
		$data['Quantity'] = $this->input->post('hdnQuantity');
		$numberArr = $this->M_bonassets->getDocNum();
		$numberNorm = $numberArr[0]['num'];
		$data['docNum'] = str_pad($numberNorm + 1, 6, 0, STR_PAD_LEFT);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('FixedAsset/MainMenu/BonAsset/V_input',$data);
		$this->load->view('V_Footer',$data);
	}

	public function output ()
	{	
		$user_id = $this->session->userid;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$data = array(
			'no_pp'				=> $this->input->post('txtPpBppbg'),
			'kode_barang'		=> $this->input->post('txtKode'),
			'nama_barang' 		=> $this->input->post('txtNama'),
			'spesifikasi' 		=> $this->input->post('txaSpek'),
			'negara_pembuat' 	=> $this->input->post('txtNgr'),
			'quantity' 			=> $this->input->post('txtQty'),
			'kva' 				=> $this->input->post('txtKva'),
			'plat' 				=> $this->input->post('txtPlat'),
			'tgl_digunakan' 	=> $this->input->post('dpDigunakan'),
			'info_lain' 		=> $this->input->post('txaInfo'),
			// 'tag_number' 		=> $this->input->post('txtTag'),
			// 'cost_center' 		=> $this->input->post('txtCost'),
			// 'umur_teknis' 		=> $this->input->post('txtUmur'),
			'seksi_pemakai'		=> $this->input->post('txtSeksi'),
			'kota'				=> $this->input->post('txtKota'),
			'gedung' 			=> $this->input->post('txtGedung'),
			'lantai' 			=> $this->input->post('txtLantai'),
			'ruang' 			=> $this->input->post('txtRuang'),
			'no_dokumen'		=> $this->input->post('hdnNum')
		);

		if ($data['kva'] == '' OR $data['kva'] == NULL) {
			$data['kva'] = '-';
		};
		if ($data['plat'] == '' OR $data['plat'] == NULL) {
			$data['plat'] = '-';
		};
		if ($data['negara_pembuat'] == '' OR $data['negara_pembuat'] == NULL) {
			$data['negara_pembuat'] = '-';
		};
		$this->M_bonassets->setDataAsset($data);
		$data['DocNum'] = $this->input->post('txtDocNum');
		$lastusednum = preg_replace('/\D/', '', $data['DocNum']);
		$this->M_bonassets->updateDocNum($lastusednum);

		$pdf = new mPDF('utf-8', 'A5-L', 0, '', 20, 15, 10, 15, 0, 0, 'L');
		$filename =' FORM_PENDAFTARAN_ASSET.pdf';
		
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html 		= $this->load->view('FixedAsset/MainMenu/BonAsset/V_output.php', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}
	
}