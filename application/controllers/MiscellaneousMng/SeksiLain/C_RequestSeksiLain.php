<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestSeksiLain extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MiscellaneousMng/M_request');
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

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['view'] = 'seksi_lain';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function modalTambahReq(){
		$data['ket'] = 'seksi_lain';
		$data['data'] = $this->M_request->getOrgAssign();
		$this->load->view('MiscellaneousMng/V_ModalTambahReq', $data);
	}
    
    public function tambahrequest(){
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $getdata 		= $this->M_request->cekrequesttemp("where pic = '$user' order by nomor desc"); //data temporary item yang direquest tp belum di submit
		$iio 			= $this->input->post('io');
		$data['ioo'] 	= !empty($iio) ? $iio : $getdata[0]['io'];
		$data['alasan'] = $this->M_request->getAlasan();
		$data['subinvv'] = $this->M_request->getSubinv($data['ioo']);
		$data['data']	= array();
		foreach ($getdata as $key => $value) {
			if ($value['io'] == $data['ioo']) {
				array_push($data['data'], $value);
			}
		}
		$data['ket'] = 'seksi_lain';
		// $data['dataioo'] = $this->M_request->getOrgAssign();
		
		// echo "<pre>";print_r($data['data']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_NewRequest', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function addRequest(){
        $user       = $this->session->user;
        $item       = $this->input->post('item');
        $qty       	= $this->input->post('qty');
		$onhand     = $this->input->post('onhand');
		$no_serial  = $this->input->post('no_serial[]');
		$noserial	= '';
		for ($i=0; $i < count($no_serial) ; $i++) { 
			$noserial .= $i == 0 ? $no_serial[$i] : '; '.$no_serial[$i];
		}
		// echo "<pre>";print_r($noserial);exit();
        $attach     = $user.'-'.strtotime(date('Y-m-d H:i:s')).'.pdf';

        $cekid = $this->M_request->cekrequesttemp("where pic = '$user' order by nomor desc");
        $id = !empty($cekid) ? $cekid[0]['nomor'] + 1 : 1;
        $datanya = array(
            'jenis'      	=> $this->input->post('order'),
            'ket_cost'   	=> $this->input->post('ket_cost'),
            'cost_center'	=> $this->input->post('cost_center'),
            'item'       	=> $item,
            'description'	=> $this->input->post('deskripsi'),
            'qty'        	=> $this->input->post('qty'),
            'onhand'     	=> $this->input->post('onhand'),
            'ket_uom'    	=> $this->input->post('uom'),
            'first_uom'  	=> $this->input->post('first_uom'),
            'secondary_uom' => $this->input->post('second_uom'),
            'inventory'  	=> $this->input->post('inventory'),
            'locator'    	=> $this->input->post('locator'),
            'no_serial'  	=> $noserial,
            'alasan'     	=> $this->input->post('alasan'),
            'desc_alasan'	=> $this->input->post('desc_alasan'),
            'attachment' 	=> $attach,
            'pic'        	=> $user,
            'nomor' 	 	=> $id,
            'inv_item_id' 	=> $this->input->post('inv_item'),
            'io' 			=> $this->input->post('ini_io'),
        );

        if (!empty($item)) {
			$cek = $this->M_request->cekrequesttemp("where item = '$item' and pic = '$user' order by nomor asc");
			if (empty($cek)) {
				$save = $this->M_request->saveTemp($datanya); // save data temporary
		
				if(!is_dir('./assets/upload/Miscellaneous/Temp'))
				{
					mkdir('./assets/upload/Miscellaneous/Temp', 0777, true);
					chmod('./assets/upload/Miscellaneous/Temp', 0777);
				}
				$filename = './assets/upload/Miscellaneous/Temp/'.$attach.'';
				move_uploaded_file($_FILES['file_pdf']['tmp_name'],$filename); // save file di folder temporary
			}
		}
        $this->tambahrequest();
        // echo "<pre>";print_r($_FILES);exit();
    }
    
	public function SaveRequest(){
		$jenis 			= $this->input->post('jenis2[]');
		$ket_cost 		= $this->input->post('ket_cost2[]');
		$cost_center 	= $this->input->post('cost_center2[]');
		$inv_item 		= $this->input->post('inv_item2[]');
		$item 			= $this->input->post('item2[]');
		$desc 			= $this->input->post('desc2[]');
		$qty 			= $this->input->post('qty2[]');
		$onhand 		= $this->input->post('onhand2[]');
		$ket_uom 		= $this->input->post('ket_uom2[]');
		$first_uom 		= $this->input->post('first_uom2[]');
		$secondary_uom 	= $this->input->post('secondary_uom2[]');
		$inventory 		= $this->input->post('inventory2[]');
		$locator 		= $this->input->post('locator2[]');
		$no_serial 		= $this->input->post('no_serial2[]');
		$alasan 		= $this->input->post('alasan2[]');
		$desc_alasan 	= $this->input->post('desc_alasan2[]');
		$attachment 	= $this->input->post('attachment2[]');
		$io 			= $this->input->post('io2');
		$pic 			= $this->input->post('pic2[]');
		$assign_order 	= $this->input->post('assign_order');
		$assign_ppc 	= $this->input->post('assign_ppc');
		$assign_cabang 	= $this->input->post('assign_cabang');
		$assign_kasie 	= $this->input->post('assign_kasie');
		$seksi			= $this->M_request->getseksi($pic[0]);

		$ionya = substr($io[0], 0,1);
		if ($ionya == 'A' || $ionya == 'B' || $ionya == 'G' || $ionya == 'H' || $ionya == 'J' || $ionya == 'K' || $ionya == 'M' || $ionya == 'S' || $ionya == 'U') {
			$status = 'Proses Approve Ka. Cabang / Showroom';
		}else {
			$status = 'Proses Approve Ka. Seksi Gudang';
		}

		if (!empty($item)) {
			// $cekheader = $this->M_request->cekheader("where no_dokumen like '%".date('mY')."%'");
			$cekheader = $this->M_request->cekheader("");
			$idheader = !empty($cekheader) ? $cekheader[0]['id'] + 1 : 1;
			if (!empty($cekheader)) {
				$no = explode("/", $cekheader[0]['no_dokumen']);
				$no = sprintf("%03d", ($no[0] + 1));
				$nodoc = $no.'/MISC/'.date('mY');  
			}else {
				$nodoc = '001/MISC/'.date('mY').'';
			}

			$dataheader = array(
						'id' 			=> $idheader,
						'no_dokumen' 	=> $nodoc,
						'io' 			=> $io[0],
						'tgl_request' 	=> date("Y-m-d H:i:s"),
						'pic' 			=> $pic[0],
						'seksi' 		=> $seksi[0]['seksi'],
						'assign_approve'=> $assign_order,
						'assign_ppc'	=> $assign_ppc,
						'status'		=> $status,
						'assign_cabang' => $assign_cabang,
						'assign_kasie' 	=> $assign_kasie
			);
			$saveheader = $this->M_request->saveHeader($dataheader);

			for ($i=0; $i < count($item) ; $i++) { 
				$cekitem = $this->M_request->cekitemrequest('order by id_item desc');
				$iditem = !empty($cekitem) ? $cekitem[0]['id_item'] + 1 : 1;
				$saveitem = $this->M_request->saveItem($idheader, $iditem, $jenis[$i], strtoupper($ket_cost[$i]), $cost_center[$i], $inv_item[$i], $item[$i], $desc[$i],
							$qty[$i], $onhand[$i], $ket_uom[$i], $first_uom[$i], $secondary_uom[$i], $inventory[$i], $locator[$i], strtoupper($no_serial[$i]), $alasan[$i],
							$desc_alasan[$i], $attachment[$i]);
			}
			
			if(!is_dir('./assets/upload/Miscellaneous/Attachment'))
			{
				mkdir('./assets/upload/Miscellaneous/Attachment', 0777, true);
				chmod('./assets/upload/Miscellaneous/Attachment', 0777);
			}

			// hapus data temporary
			$this->M_request->deleteTemp("where pic = '".$pic[0]."'");
			$dir    = './assets/upload/Miscellaneous/Temp';
			$files1 = scandir($dir);
			for($i = 0;$i < count($files1);$i++){ 
				$filename = './assets/upload/Miscellaneous/Temp/'.$files1[$i].'';
				if(stripos($files1[$i], $pic[0]) !== FALSE && file_exists($filename)){ // cari file yg mau dipindah, (nama file seperti nama pic)
					$tujuan = './assets/upload/Miscellaneous/Attachment/'.$files1[$i].'';
					if (copy($filename, $tujuan)) { // pindah file ke directory /attachment
						unlink($filename); // hapus file di directory /temp
					}
				}
			}
		}
		redirect(base_url("MiscellaneousSeksiLain/Request"));
	}
	

}