<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StockGudangAlat extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StockGudangAlat/M_stockgudangalat');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = '';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['lihat_stok'] = $this->M_stockgudangalat->insertTable();
		// echo "<pre>"; print_r($data['lihat_stok']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGudangAlat/V_InputStock',$data);
		$this->load->view('V_Footer',$data);
    }

    public function insertData() {
		// echo "<pre>";
		// print_r($_POST);exit();
		$no_po2 =$this->input->post('txt_nopo[]');
		$nama2 =$this->input->post('txt_nama[]');
		$merk2 =$this->input->post('txt_merk[]');
		$qtypr2 =$this->input->post('txt_qty[]');
		$tag2 =$this->input->post('txt_tag[]');
		$pilihan2 = $this->input->post('txt_jenis[]');
		$subinv2 = $this->input->post('txt_subinv[]');
		$jumlah2 =$this->input->post('qty');
		$qty=1;
		// echo "<pre>";
		// print_r($no_po2);
		// print_r($tag2);
		// print_r($nama2);
		// print_r($merk2);
		// print_r($qtypr2);
		// print_r($pilihan2);
		// print_r($jumlah2);
		// exit();
		for ($i=0; $i < count($nama2); $i++) {
			$no_po= $no_po2[$i];
			$nama= $nama2[$i];
			$merk= $merk2[$i];
			$pilihan= $pilihan2[$i];
			$subinv= $subinv2[$i];
			$tag3= $tag2[$i];
			if ($tag3=='') {
				$tag='-';
			}
			else {
				$tag=$tag3;
			}
			// echo "<pre>";
			// print_r($no_po);
			// print_r($tag);
			// print_r($nama);
			// print_r($merk);
			// print_r($pilihan);
			// print_r($qty);

			$this->M_stockgudangalat->insertData($no_po,$nama,$merk,$pilihan,$qty,$tag,$subinv);
		}
		// exit();
		redirect("StockGudangAlat/");
	}

	public function getDataComp()
	{
		$id = $this->input->post('id');
		echo json_encode($this->M_stockgudangalat->getDataComp($id));
	}

	public function updateData()
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit();
		$no_po =$this->input->post('noPo');
		$tag =$this->input->post('tag');
		$nama =$this->input->post('nama');
    $nama2 =$this->input->post('noMobil');
    $merk =$this->input->post('merk');
    $qty =$this->input->post('qty');
		$pilihan = $this->input->post('pilihan');

		$this->M_stockgudangalat->updateData($tag,$nama,$nama2,$merk,$qty,$pilihan,$no_po);

		redirect("StockGudangAlat/");
	}

	public function deleteData($id)
	{
		// echo "<pre>";
		// print_r($id);
		// exit();
		$this->M_stockgudangalat->deleteData($id);

		redirect("StockGudangAlat/");
	}
	public function search_input() {
		$nama1 = $this->input->post('nama');
		$nopo1 =$this->input->post('no_po');
		$merk1 =$this->input->post('merk');
		$jenis1 =$this->input->post('pilihan');
		$jumlah1 =$this->input->post('qty');
		$subinv1 =$this->input->post('subinv');
		$qty1= 1;
		// echo"<pre>";print_r($nama1);exit;
		$x=0;
		for($i = 0; $i < $jumlah1; $i++) {
				echo
					'<tr>
						<td align="center" style="font-size: 13px;">'.$nopo1.'
							<input type="hidden" name="txt_nopo[]" value="'.$nopo1.'"/>
						</td>
						<td align="center" style="font-size: 13px;">'.$nama1.'
							<input type="hidden" name="txt_nama[]" value="'.$nama1.'"/>
						</td>
						<td align="center" style="font-size: 13px;">'.$merk1.'
							<input type="hidden" name="txt_merk[]" value="'.$merk1.'"/>
						</td>
						<td align="center" style="font-size: 13px;">'.$jenis1.'
							<input type="hidden" name="txt_jenis[]" value="'.$jenis1.'"/>
						</td>
						<td align="center" style="font-size: 13px;">'.$qty1.'
							<input type="hidden" name="txt_qty[]" value="'.$qty1.'"/>
						</td>
						<td align="center" style="font-size: 13px;">'.$jumlah1.'
							<input type="hidden" name="txt_jml[]" value="'.$jumlah1.'"/>
						</td>
						<td align="center" style="font-size: 13px;">'.$subinv1.'
							<input type="hidden" name="txt_subinv[]" value="'.$subinv1.'"/>
						</td>
						<td>
							<center><input type="text" class="form-control" name="txt_tag[]" "/></center>
						</td>
					</tr>';
				// $x++;
			// }
		}
	}
}



?>
