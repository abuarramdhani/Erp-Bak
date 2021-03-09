<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Import extends CI_Controller
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
		$this->load->model('MonitoringJobProduksi/M_import');

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

		$data['Title'] = 'Import';
		$data['Menu'] = 'Import';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['kategori'] = $this->M_import->getCategory('');
        
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Import', $data);
		$this->load->view('V_Footer',$data);
    }

    public function SaveImport(){
        require_once APPPATH.'third_party/Excel/PHPExcel.php';
		require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
		 
        $file_data  = array();
        // load excel
        $file = $_FILES['file_import']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
        $kategori = $this->input->post('kategori');
        $bulan  = $this->input->post('periode_bulan');
        $bln    = explode("/", $bulan);
		$bulan  = $bln[1].$bln[0];
		$subcategory = $this->M_import->getSubcategory($kategori);
        // echo "<pre>";print_r($sheets);exit();
        $i = 1; $subctgr = ''; $idsub = '';
        foreach ($sheets as $key => $row) {
			foreach ($subcategory as $key2 => $sub) {
				if ($row['A'] == $sub['SUBCATEGORY_NAME']) {
					$subctgr = $sub['ID_SUBCATEGORY'];
					$idsub = "and id_subcategory = ".$subctgr."";
				// }else if ($row['A'] == '') {
				// 	$subctgr = "null";
				// 	$idsub = 'and id_subcategory is null';
				}else {
					$subctgr = $subctgr;
					$idsub = $idsub;
				}
			}
			
			if ($row['A'] != '' && $row['B'] != '') {
				$cari_inv = $this->M_import->cekInvItem($row['A']);
				$inv    = $cari_inv[0]['INVENTORY_ITEM_ID'];
				$org_id = $cari_inv[0]['ORGANIZATION_ID'];
				$plan   = $row['B'];
				$cek_item = $this->M_import->cekItem($inv, $kategori, $subctgr);
				if (empty($cek_item)) {
					$this->M_import->saveitem($kategori, $inv, $org_id, $subctgr);
				}
				$cek_plan = $this->M_import->cekplan("where inventory_item_id = $inv and month = '$bulan' and id_category = $kategori $idsub");
				// echo "<pre>";print_r($cek_plan);exit();
				if (empty($cek_plan)) {
					$cek_id = $this->M_import->cekplan('');
					$id_plan = $cek_id[0]['PLAN_ID'] + 1;
					$this->M_import->savePlan($id_plan, $inv, $bulan, $kategori, $subctgr);
					$this->M_import->savePlanDate($id_plan, $plan);
				}
			}
            $i++;
        }
        redirect(base_url('MonitoringJobProduksi/Import'));
    }
    
    public function downloadlayout(){
        include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Monitoring Job Produksi")
					->setSubject("CV. KHS")
					->setDescription("Monitoring Job Produksi")
                    ->setKeywords("MJP");
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "SUBCATEGORY (isi disini, kosongi jika tidak membutuhkan subcategory)");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "ITEM (isi item mulai dari baris 2)");
        $excel->setActiveSheetIndex(0)->setCellValue('B2', "PLAN (isi item mulai dari baris 2)");
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); 
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Import");
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Layout-Import-Monitoring-Job-Produksi.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
    }

    
}