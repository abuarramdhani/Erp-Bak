<?php defined('BASEPATH')OR die('No direct script access allowed'); 
class C_SubmitOrder extends CI_Controller {
    function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if(!$this->session->userdata('logged_in')) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('upload');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('OrderSeksiRekayasa/M_submitorder');
    }
    
    public function checkSession(){
		if ($this->session->is_logged) {

        }else{
            redirect();
        }
	}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Submit Order';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['title'] = 'cek';
		$getseksi = $this->M_submitorder->getSeksi($this->session->kodesie);
		$data['seksi'] = $getseksi[0]['section_name'];

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSeksiRekayasa/User/V_SubmitOrder',$data);
		$this->load->view('V_Footer',$data);

	}

	public function create(){
		// echo "<pre>";
        // print_r($_FILES);
        // die;
		$this->checkSession();
		// $user_id = $this->session->userdata;
		// print_r($user_id); exit();
		$benefit = $this->input->post('Benefit');
		$benefit = implode(',', $benefit);
		$tanggal_estimasi_selesai = $this->input->post('TanggalEstimasiSelesai');
		$tanggal_estimasi_selesai = str_replace('/', '-', $tanggal_estimasi_selesai);
		// print_r($tanggal_estimasi_selesai); exit();

		$no_induk = $this->session->userdata('user');
		$nama = $this->input->post('Nama');
		$kodesie = $this->session->userdata('kodesie');
		$seksi = $this->input->post('Seksi');
		$tanggal_order = date("Y-m-d");
		$tanggal_estimasi_selesai = date("Y-m-d", strtotime($tanggal_estimasi_selesai));
		$jenis_order = $this->input->post('JenisOrder');
		$nama_alat_mesin = $this->input->post('NamaAlatMesin');
		$nomor_alat_mesin = $this->input->post('NomorAlatMesin');
		$jumlah_alat_mesin = $this->input->post('JumlahAlatMesin');
		$spesifikasi_alat_mesin = $this->input->post('SpesifikasiAlatMesin');
		$tipe_alat_mesin = $this->input->post('TipeAlatMesin');
		$fungsi_alat_mesin = $this->input->post('FungsiAlatMesin');
		$benefit = $benefit;
		$target = $this->input->post('Target');
		$kondisi_sebelum = $this->input->post('KondisiSebelum');
		$kondisi_sesudah = $this->input->post('KondisiSesudah');
		$ket_pelengkap = $this->input->post('KetPelengkap');
		$status = 0;

		if (!empty($_FILES['LayoutAlatMesin']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/OrderSeksiRekayasa')) {
                mkdir('./assets/upload/OrderSeksiRekayasa/Layout', 0777, true);
                chmod('./assets/upload/OrderSeksiRekayasa/Layout', 0777);
			}
			
			$config['upload_path'] = './assets/upload/OrderSeksiRekayasa/Layout';
            $config['allowed_types'] = '*';
			$config['overwrite'] 	= true;
			$name = str_replace(' ', '_', $nama_alat_mesin);
			$ext = pathinfo($_FILES['LayoutAlatMesin']['name'], PATHINFO_EXTENSION);
			$ext = strtolower($ext);
			// $dname = explode(".", $_FILES['LayoutAlatMesin']['name']);
			// $ext = end($dname);
            $config['file_name'] = 'Layout_'.$name.'.'.$ext;
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('LayoutAlatMesin')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
			}
			$path_layout = $config['upload_path'].'/'.$config['file_name'];
			$ext_layout = $ext;
			$filename_layout = $config['file_name'];
		}
		else {
			$path_layout = null;
			$ext_layout = null;
			$filename_layout = null;
		}

		if (!empty($_FILES['DokumenTarget']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/OrderSeksiRekayasa')) {
                mkdir('./assets/upload/OrderSeksiRekayasa/Target', 0777, true);
                chmod('./assets/upload/OrderSeksiRekayasa/Target', 0777);
			}

			$config['upload_path'] = './assets/upload/OrderSeksiRekayasa/Target';
            $config['allowed_types'] = '*';
			$config['overwrite'] 	= true;
			$name = str_replace(' ', '_', $nama_alat_mesin);
			$ext = pathinfo($_FILES['DokumenTarget']['name'], PATHINFO_EXTENSION);
			$ext = strtolower($ext);
			$config['file_name'] = 'Target_'.$name.'.'.$ext;
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('DokumenTarget')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
			}
			$path_target = $config['upload_path'].'/'.$config['file_name'];
			$ext_target = $ext;
			$filename_target = $config['file_name'];
		}
		else {
			$path_target = null;
			$ext_target = null;
			$filename_target = null;
		}

		if (!empty($_FILES['DokumenKondisiSebelum']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/OrderSeksiRekayasa')) {
                mkdir('./assets/upload/OrderSeksiRekayasa/KondisiSebelum', 0777, true);
                chmod('./assets/upload/OrderSeksiRekayasa/KondisiSebelum', 0777);
            }
			$config['upload_path'] = './assets/upload/OrderSeksiRekayasa/KondisiSebelum';
            $config['allowed_types'] = '*';
			$config['overwrite'] 	= true;
			$name = str_replace(' ', '_', $nama_alat_mesin);
			$ext = pathinfo($_FILES['DokumenKondisiSebelum']['name'], PATHINFO_EXTENSION);
			$ext = strtolower($ext);
            // $dname = explode(".", $_FILES['DokumenKondisiSebelum']['name']);
			// $ext = end($dname);
            $config['file_name'] = 'KondisiSebelum_'.$name.'.'.$ext;
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('DokumenKondisiSebelum')) {
                $error = array('error' => $this->upload->display_errors());
				echo $error;exit();
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			
			$path_kondisi_sebelum = $config['upload_path'].'/'.$config['file_name'];
			$ext_kondisi_sebelum = $ext;
			$filename_kondisi_sebelum = $config['file_name'];
		}
		else {
			$path_kondisi_sebelum = null;
			$ext_kondisi_sebelum = null;
			$filename_kondisi_sebelum = null;
		}

		if (!empty($_FILES['DokumenKondisiSesudah']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/OrderSeksiRekayasa')) {
                mkdir('./assets/upload/OrderSeksiRekayasa/KondisiSesudah', 0777, true);
                chmod('./assets/upload/OrderSeksiRekayasa/KondisiSesudah', 0777);
            }
			$config['upload_path'] = './assets/upload/OrderSeksiRekayasa/KondisiSesudah';
            $config['allowed_types'] = '*';
			$config['overwrite'] 	= true;
			$name = str_replace(' ', '_', $nama_alat_mesin);
			$ext = pathinfo($_FILES['DokumenKondisiSesudah']['name'], PATHINFO_EXTENSION);
			$ext = strtolower($ext);
            // $dname = explode(".", $_FILES['DokumenKondisiSesudah']['name']);
			// $ext = end($dname);
            $config['file_name'] = 'KondisiSesudah_'.$name.'.'.$ext;
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('DokumenKondisiSesudah')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			$path_kondisi_sesudah = $config['upload_path'].'/'.$config['file_name'];
			$ext_kondisi_sesudah = $ext;
			$filename_kondisi_sesudah = $config['file_name'];
		}
		else {
			$path_kondisi_sesudah = null;
			$ext_kondisi_sesudah = null;
			$filename_kondisi_sesudah = null;
		}

		if (!empty($_FILES['DokumenKetPelengkap']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/OrderSeksiRekayasa')) {
                mkdir('./assets/upload/OrderSeksiRekayasa/KetPelengkap', 0777, true);
                chmod('./assets/upload/OrderSeksiRekayasa/KetPelengkap', 0777);
            }
			$config['upload_path'] = './assets/upload/OrderSeksiRekayasa/KetPelengkap';
            $config['allowed_types'] = '*';
			$config['overwrite'] 	= true;
			$name = str_replace(' ', '_', $nama_alat_mesin);
			$ext = pathinfo($_FILES['DokumenKetPelengkap']['name'], PATHINFO_EXTENSION);
			$ext = strtolower($ext);
            // $dname = explode(".", $_FILES['DokumenKetPelengkap']['name']);
			// $ext = end($dname);
            $config['file_name'] = 'KetPelengkap_'.$name.'.'.$ext;
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('DokumenKetPelengkap')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else { 
                $data = array('upload_data' => $this->upload->data());
            }
			$path_ket_pelengkap = $config['upload_path'].'/'.$config['file_name'];
			$ext_ket_pelengkap = $ext;
			$filename_ket_pelengkap = $config['file_name'];
		}
		else {
			$path_ket_pelengkap = null;
			$ext_ket_pelengkap = null;
			$filename_ket_pelengkap = null;
		}

		$save = [
			'no_induk' => $no_induk,
			'nama' => $nama,
			'kodesie' => $kodesie,
			'seksi' => $seksi,
			'tanggal_order' => $tanggal_order,
			'tanggal_estimasi_selesai' => $tanggal_estimasi_selesai,
			'jenis_order' => $jenis_order,
			'nama_alat_mesin' => $nama_alat_mesin,
			'nomor_alat_mesin' => $nomor_alat_mesin,
			'jumlah_alat_mesin' => $jumlah_alat_mesin,
			'spesifikasi_alat_mesin' => $spesifikasi_alat_mesin,
			'tipe_alat_mesin' => $tipe_alat_mesin,
			'fungsi_alat_mesin' => $fungsi_alat_mesin,
			'layout_alat_mesin' => $path_layout,
			'ext_layout' => $ext_layout,
			'filename_layout' => $filename_layout,
			'benefit' => $benefit,
			'target' => $target,
			'dokumen_target' => $path_target,
			'ext_target' => $ext_target,
			'filename_target' => $filename_target,
			'kondisi_sebelum' => $kondisi_sebelum,
			'dokumen_kondisi_sebelum' => $path_kondisi_sebelum,
			'ext_kondisi_sebelum' => $ext_kondisi_sebelum,
			'filename_kondisi_sebelum' => $filename_kondisi_sebelum,
			'kondisi_sesudah' => $kondisi_sesudah,
			'dokumen_kondisi_sesudah' => $path_kondisi_sesudah,
			'ext_kondisi_sesudah' => $ext_kondisi_sesudah,
			'filename_kondisi_sesudah' => $filename_kondisi_sesudah,
			'ket_pelengkap' => $ket_pelengkap,
			'dokumen_ket_pelengkap' => $path_ket_pelengkap,
			'ext_ket_pelengkap' => $ext_ket_pelengkap,
			'filename_ket_pelengkap' => $filename_ket_pelengkap,
			'status' => $status
		];

		$this->M_submitorder->setOrder($save);
		$order_id = $this->db->insert_id();
		
		redirect('OrderSeksiRekayasa/View/'.$order_id);
	}

	public function view($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'View Order';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['order'] = $this->M_submitorder->getOrder($id);
		// print_r($data['order']); exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('OrderSeksiRekayasa/User/V_ViewOrder', $data);
		$this->load->view('V_Footer', $data);
	}

	public function pdf($id){
		$data['order'] = $this->M_submitorder->getOrder($id);
		// // print_r($data['order']); exit();
		$pencetus = preg_replace('/(\s)+/', ' ', $data['order'][0]['nama']);
		$pencetus = strtolower($pencetus);
		$pencetus = ucwords($pencetus);
		$pencetus = str_replace(' ', '_', $pencetus);
		$filename = 'Order Seksi Rekayasa-'.$pencetus.$data['order'][0]['id_order'].'.pdf';
		$today = date('d/m/Y H:i:s');
		$id_order = $data['order'][0]['id_order'];

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		// $pdf->showImageErrors = true;
		
		$stylesheet = file_get_contents(base_url('assets/css/customSI.css'));
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css'));
		$html = $this->load->view('OrderSeksiRekayasa/User/V_ExportPdf', $data, true);
		$html_lampiran = $this->load->view('OrderSeksiRekayasa/User/V_ExportPdfLamp', $data, true);
		$pdf->setHTMLFooter('
			<table width="100%">
				<tr>
					<td style="font-size: 12px; padding: 2px">Halaman ini di cetak melalui QuickERP - Order Seksi Rekayasa, Pada tanggal: '.$today.' No Order : '.$id_order.'</td>
					<td style="text-align: right; font-size: 12px;">Halaman {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		');
		
		$pdf->SetTitle($filename);
		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($stylesheet1, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->AddPage();
		$pdf->WriteHTML($html_lampiran, 2);
		$pdf->Output($filename, 'I');

	}

}
?>