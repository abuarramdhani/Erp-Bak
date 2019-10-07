<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Monitoring extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		//load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('BarangDatang/M_monitoring');
			
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['io'] = $this->M_monitoring->getIO();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangDatang/V_Monitoring',$data);
		$this->load->view('V_Footer',$data);
		}
		
		public function search() {
			$no_sj	= $this->input->post('no_sj');
			$no_po	= $this->input->post('no_po');
			$inputio = $this->input->post('io');
			$tgl_mulai		= date('Y-m-d', strtotime($this->input->post('tgl_mulai')));
			$tgl_akhir		= date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
			// echo"<pre>";print_r($_POST);exit;
			if ($inputio== '') {
				$io = null;
			} else {
				$io = "and mp.ORGANIZATION_CODE = '$inputio'";
			}
			
			if ($no_sj == '' ) {
				// $atr='';
				if ($no_po == '') {
					$nopo ='';
					$atr="";
					$atr2= "SELECT distinct 
								null PO
								,null buyer
								,null ORGANIZATION_CODE
								,msib.SEGMENT1
								,msib.INVENTORY_ITEM_ID
								,msib.DESCRIPTION
								,null PESANAN
								,tbl.QTY DITERIMA
								,null lokasi
								,('confirmity') STATUS
							from khs_tampung_barang_line tbl
								,khs_tampung_barang_header tbh
								,mtl_system_items_b msib
							where tbl.NO_SJ = tbh.NO_SJ
							and msib.SEGMENT1 =  tbl.ITEM
							and msib.INVENTORY_ITEM_ID = tbl.ITEM_ID
							and tbh.tanggal_datang  BETWEEN TO_DATE('$tgl_mulai','YYYY-MM-DD') 
											AND TO_DATE('$tgl_akhir','YYYY-MM-DD') --2019-09-21
							and tbl.NO_PO is null  
							UNION ALL";
				} else {
					$nopo="and ktbl.NO_PO = '$no_po' and pha.segment1 = '$no_po'";
					$atr2='';
					$atr='';
				}
				$header= $this->M_monitoring->getHeader($tgl_mulai, $tgl_akhir , $atr, $nopo, $atr2,$io);
			} else {
				if ($no_po == '') {
					$nopo ='';
					$atr="and ktbh.NO_SJ = '$no_sj'";
					$atr2="";
				} else {
					$nopo="and ktbl.NO_PO = '$no_po' and pha.segment1 = '$no_po'";
					$atr2='';
					$atr="and ktbh.NO_SJ = '$no_sj'";
				}
				// $atr="and ktbh.NO_SJ = '$no_sj'";
				$header= $this->M_monitoring->getHeader($tgl_mulai, $tgl_akhir, $atr, $nopo, $atr2, $io);
			}
			// echo "<pre>";
			// print_r($header);
			// exit;
			if ($header=='' or $header==null) {
				$message = "Not Found!";
				echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
						<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
						<script type="text/javascript">
							Swal.fire({
								type: \'error\',
								title: \''.$message.'\',
								width: 600,
								showConfirmButton: true,
							})
						</script>';
				// echo "<script type='text/javascript'>alert('$message');</script>";
				exit;
			} else {
				for ($i=0; $i <count($header) ; $i++) { 
					// $nosjtabel = $header[$i]['NO_SJ'];
					// $nopotabel = $header[$i]['NO_PO'];
					$po = $header[$i]['PO'];
					$invitemid = $header[$i]['INVENTORY_ITEM_ID'];
					if (empty($po)){
						$po=null;
					}
					// echo "<pre>";
					// print_r($po);
					// print_r($invitemid);
					// exit;
					$body1 = $this->M_monitoring->getBodyHeader($po,$invitemid);
					
					if (empty($body1)) {
						$body = null;
					} else {
						$body = $body1;
						$hitung = count($body);
						// for ($j=0; $j <$hitung ; $j++) { 
							// if (empty($body[$j]['RECEIPT'])) {
							// 	$body[$j]['proses'] = null;
							// } else {
							// 	$recnum = $body[$j]['RECEIPT'];
							// 	$itemid = $body[$j]['ITEM_ID'];
							// 	$numpo = $body[$j]['NO_PO'];
							// 	$loc = $body[$j]['LOKASI'];
								// $body[$j]['proses'] = $this->M_monitoring->getBody($recnum, $itemid, $numpo, $loc);
							// }
						// }
					}
					$data['value'][$i] = array(
						'header' => $header[$i],
						'body' =>$body
					);
				}
			}
			// echo "<pre>"; print_r($data);exit;
			$this->load->view('BarangDatang/V_Resultmonitor', $data);
		}
}