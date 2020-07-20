<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Order extends CI_Controller
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
		$this->load->library('ciqrcode');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderSiteManagement/MainMenu/M_order');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Create Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_order->RejectbySystem();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSiteManagement/Order/V_create', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function SaveDataOrderSM()
	{
		
		$user_id = $this->session->userid;

		$date = date('Ym');
		$no_order = $this->M_order->cekNoOrder();
		if (is_null($no_order[0]['no_order'])) {
			$noder = $date.'001';
		}else{
			$noder = ((int) $no_order[0]['no_order'])+1; 
		}
		
		
		$data = array(
				'no_order' => (int)$noder,
				'tgl_order' => date('Y-m-d'),
				'jenis_order' => $this->input->post('osm-jenisorder'),
				'seksi_order' => $this->input->post('osm-seksiorder'),
				'due_date' => $this->input->post('osm-duedate'),
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $user_id,
    		);
		$this->M_order->setOrder($data);
		$header_id = $this->db->insert_id();

		$jml_order = $this->input->post('osm-jumlahorder');
		foreach ($jml_order as $jo => $key) {
			$jml_order = $this->input->post('osm-jumlahorder');
			$satuan = $this->input->post('osm-satuanorder');
			$ket_order = $this->input->post('osm-ketorder');
			$lampiran = $this->input->post('osm-lampiran');

			$lines = array(
					 'id_order' => $header_id,
					 'jumlah' => $jml_order[$jo],
					 'satuan' => $satuan[$jo],
					 'keterangan' => $ket_order[$jo],
					 'lampiran' => $lampiran[$jo],
					 'created_date' => date('Y-m-d H:i:s'),
					 'created_by' => $user_id,
			);
			$this->M_order->saveOrderDetail($lines);
		}

		if(!file_exists(FCPATH."assets/upload/qrcodeSM/".$noder.".png")){
				$qr_image=$noder.'.png';
				$params['data'] = $noder;
				$params['level'] = 'H';
				$params['size'] = 8;
				$params['savename'] =FCPATH."assets/upload/qrcodeSM/".$qr_image;
				$this->ciqrcode->generate($params);
			}

		


		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'A5-L',8,15, 15, 16, 16, 9, 9);
		$filename = 'Form-Order.pdf';

		$data['header'] = $this->M_order->Header($header_id);
		$data['lines'] = $this->M_order->Lines($header_id);
		

		$html = $this->load->view('OrderSiteManagement/Order/V_cetakdata', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');

		
	}

    public function CetakData($id)
    {

    	$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'A5-L',8,15, 15, 16, 16, 9, 9);
		$filename = 'Form-Order.pdf';

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['header'] = $this->M_order->Header($plaintext_string);
		$data['lines'] = $this->M_order->Lines($plaintext_string);
		
		$html = $this->load->view('OrderSiteManagement/Order/V_cetakdata', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
    }

    public function ListOrder()
    {
    	$user_id = $this->session->userid;

    	$data['Title'] = 'Order';
		$data['Menu'] = 'List Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_order->RejectbySystem();
		$user = $this->session->user;
		$data['list_order'] = $this->M_order->listOrder($user_id,$user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSiteManagement/Order/V_index', $data);
		$this->load->view('V_Footer',$data);
    }


}

/* End of file C_Order.php */
/* Location: ./application/controllers/OrderSiteManagement/MainMenu/C_Order.php */
/* Generated automatically on 2018-06-26 09:50:15 */