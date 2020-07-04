<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_SearchItem extends CI_Controller {

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
		$this->load->library('form_validation');
		  //load the login model
		$this->load->library('session');
		// $this->load->library('Database');
		$this->load->library('Excel');
		$this->load->model('M_Index');
		$this->load->model('ECommerce/M_searchitem');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}	

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['organization'] = $this->M_searchitem->getAllOrganization();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ECommerce/SearchItem/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getSubInventoryByOrganization($org_id)
	{
		$optionGroup='<option></option>';
		$subinv = $this->M_searchitem->getSubInventoryByOrganization($org_id);
		foreach ($subinv as $si) {
			$newOpt='<option value="'.$si['SUBINVENTORY'].'">'.$si['SUBINVENTORY'].'</option>';
			$optionGroup.=$newOpt;
		}
		echo json_encode($optionGroup);
	}

	public function getItemBySubInventory()
	{
		$kriteriarray 	= $this->input->post('kriteria');

		$itemCombine = array();

		$item 		= $this->M_searchitem->getItemBySubInventory($kriteriarray);

		$itemCombine=NULL;
		$itemCodeArray=NULL;
		$key=NULL;
		$numNone=0;
		$numExist=0;
		foreach ($item as $itm) {
			if ($itemCombine) {
				$key = array_search($itm['SEGMENT1'], $itemCodeArray);
			}
			
			// $ItemToko = $this->M_searchitem->getItemFromToko($itm['SEGMENT1']);

			if ($key) {
				$itmOriginalQty = ($itemCombine[$key]['qty'])+$itm['ATT'];
				$qty_available = ceil($itmOriginalQty/5);

				$itemCombine[$key] = array(
					'item' 				=> $itm['SEGMENT1'], 
					'description' 		=> $itm['DESCRIPTION'],
					'qty' 				=> $itmOriginalQty, 
					'qty_available' 	=> $qty_available
				);
			}else{
				$qty_available = ceil(($itm['ATT'])/5);

				$itemCodeArray[$numNone] = $itm['SEGMENT1'];

				$itemCombine[$numNone] = array(
					'item' 				=> $itm['SEGMENT1'], 
					'description' 		=> $itm['DESCRIPTION'],
					'qty' 				=> $itm['ATT'], 
					'qty_available' 	=> $qty_available
				);
				$numNone++;
				$numExist++;
			}
		}
		if ($itemCombine) {
			$data['itemCombine']=$itemCombine;
		}else {
			$data['itemCombine']=NULL;
		}

		$returnTable = $this->load->view('ECommerce/SearchItem/V_tableItem',$data);
	}

    public function exportExcelDataItem()
    {
        $hdnItem = $this->input->post('hdnItem[]');
        $hdnDsc = $this->input->post('hdnDsc[]');
        $hdnQty = $this->input->post('hdnQty[]');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(83);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);

        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

        $objset = $objPHPExcel->getActiveSheet();

        $objset->setCellValue("A1", 'no');
        $objset->setCellValue("B1", 'name');
        $objset->setCellValue("C1", 'reference');
        $objset->setCellValue("D1", 'quantity');

        $row = 2;
        for ($i = 0; $i < count($hdnItem); $i++) {
			$row_num = $i + 1;
            $objset->setCellValue("A" . $row, $row_num);
            $objset->setCellValue("B" . $row, $hdnDsc[$i]);
            $objset->setCellValue("C" . $row, $hdnItem[$i]);
            $objset->setCellValue("D" . $row, $hdnQty[$i]);
            $row++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Admin Digital E-Commerce');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_Produk.xlsx"');
        $objWriter->save("php://output");
    }
}
