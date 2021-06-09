<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

setlocale(LC_ALL, 'id_ID.utf8');
date_default_timezone_set('Asia/Jakarta');

/**
 * 
 */
class C_CivilArea extends CI_Controller
{
	const NON_PRODUKSI = [1, 2, 3];
	const PRODUKSI_FABRIKASI_PUSAT = [4, 5];
	const PRODUKSI_NON_FABRIKASI_PUSAT = [6];
	const PRODUKSI_FABRIKASI_TUKSONO = [7, 8];
	const PRODUKSI_NON_FABRIKASI_TUKSONO = [9];

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->checkSession();

		$this->load->library('form_validation');
		// $this->load->library('session');
		// $this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('KonversiBulan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CivilArea/M_civilarea');
		$this->load->model('CivilArea/M_area');
		$this->load->model('CivilArea/M_lantai');
		$this->load->model('CivilArea/M_oracle');

		$this->user = $this->session->user;
		if ($this->session->is_logged === false) redirect('');
	}

	/**
	 * To check session
	 * if session is not authorized or is empty, it will redirect to login page
	 */
	protected function checkSession()
	{
		if (!$this->session->is_logged) {
			return redirect('/');
		}
	}

	/**
	 * Filter array sesuai kondisi
	 * Kondisi dibawah mengembalikkan array berisi
	 * substr(cost_center, 0, 1) = $group_number
	 * 
	 * @param  Array   $arrayOfCostCenter
	 * @param  Array $group_number
	 * @return Array   $filtered array
	 */
	private function categoryByGroup($arrayOfCostCenter, $group_number)
	{
		$filtered =  array_filter($arrayOfCostCenter, function ($item) use ($group_number) {
			return in_array(substr($item->COST_CENTER, 0, 1), $group_number);
		});

		// rearrange index
		return array_values($filtered);
	}

	/**
	 * Get Cost Center from postgresql(area) and master on oracle
	 * and merge it to related cost center
	 * 
	 * @return Array<Array> Nested array
	 */
	protected function getCostCenter()
	{
		$cost_center = $this->M_oracle->getCostCenter(); // oracle
		$cost_center_area = $this->M_civilarea->getCostCenterArea(); // master
		$cost_center_area_detail = $this->M_civilarea->getCostCenterAreaDetail(); // detail master

		// make array with key of cost center
		$cost_center_key = [];
		foreach ($cost_center as $cc) {
			$cost_center_key[$cc->COST_CENTER . "_" . $cc->BRANCH] = $cc;
			$cost_center_key[$cc->COST_CENTER . "_" . $cc->BRANCH]->ID = $cc->COST_CENTER . "_" . $cc->BRANCH;
		}

		// Merge cost center area with cost center from oracle by cost_center code
		foreach ($cost_center_area as $cc) {
			$cost_center_key[$cc->cost_center . "_" . $cc->branch]->AREA = $cc->luas_area;
		}

		// Merge cost center area detail withh cost center
		foreach ($cost_center_area_detail as $cc) {
			$cost_center_key[$cc->cost_center . "_" . $cc->branch]->DATA[] = $cc;
		}

		return $cost_center_key;
	}

	public function index()
	{
		$area_name = $this->M_area->getArea();
		$floor_name = $this->M_lantai->getFloor();
		$arrayOfCostCenter = $this->getCostCenter();

		$data = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Civil Maintenance Order', 'Luas Area Seksi', '', '');
		/**
		 * Category by group
		 */
		$data['cost_center_category'] = [
			[
				'head_code' => 'PRODUKSI_NON_FABRIKASI_TUKSONO',
				'name' => 'Produksi Non Fabrikasi <br> (Tuksono)',
				'target' => 'tab5',
				'active' => false,
				'table_id' => md5('uniquableinMd5Xixixixi'),
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_NON_FABRIKASI_TUKSONO)
			],
			[
				'head_code' => 'PRODUKSI_FABRIKASI_TUKSONO',
				'name' => 'Produksi Fabrikasi <br> (Tuksono)',
				'target' => 'tab4',
				'active' => false,
				'table_id' => md5('uqueTableinMd5Xixixixi'),
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_FABRIKASI_TUKSONO)
			],
			[
				'head_code' => 'PRODUKSI_NON_FABRIKASI_PUSAT',
				'name' => 'Produksi Non Fabrikasi <br> (Pusat)',
				'target' => 'tab3',
				'active' => false,
				'table_id' => md5('uniqueTabd5Xixixixi'),
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_NON_FABRIKASI_PUSAT)
			],
			[
				'head_code' => 'PRODUKSI_FABRIKASI_PUSAT',
				'name' => 'Produksi Fabrikasi <br> (Pusat)',
				'target' => 'tab2',
				'active' => false,
				'table_id' => md5('uniqueTabMd5Xixixixi'),
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_FABRIKASI_PUSAT)
			],
			[
				'head_code' => 'NON_PRODUKSI',
				'name' => 'Non Produksi',
				'target' => 'tab1',
				'active' => true,
				'table_id' => md5('uniqueTableinMd5Xxi'),
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::NON_PRODUKSI)
			],
		];

		$data['floor'] = $floor_name;
		$data['area'] = $area_name;
		$data['lokasi_option'] = ['KHS Pusat', 'KHS Tuksono', 'KHS Melati'];

		/**
		 * --------- ROLE MANAGEMENT ----------
		 * Seksi civil dapat CRUD
		 * selain itu hanya bisa read & export
		 * ------------------------------------
		 */

		# list of section who can access CRUD
		$role_admin_section = [
			'405010100', // Civil Maintenance kasie
			'405010100', // Civil Maintenance supervisor
		];

		# special role for nomor induk
		$role_admin_user = [
			# example: B0555
		];

		# this to disable/enable button that user can do CRUD
		$data['is_admin'] = in_array($this->session->kodesie, $role_admin_section) || in_array($this->session->user, $role_admin_user); // Boolean
		/**
		 * -------------------------------------
		 */

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('CivilArea/LuasArea/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	/**
	 * To export Excel
	 * All or specific code
	 */
	public function excel()
	{
		// dependencies load
		$this->load->library('Excel');

		$specific_code = $this->input->get('code');

		$allowed_code = [
			'NON_PRODUKSI',
			'PRODUKSI_FABRIKASI_PUSAT',
			'PRODUKSI_NON_FABRIKASI_PUSAT',
			'PRODUKSI_FABRIKASI_TUKSONO',
			'PRODUKSI_NON_FABRIKASI_TUKSONO'
		];

		// if get param is exist and not in allowed array
		if ($specific_code && !in_array($specific_code, $allowed_code)) return response()->html("
			System error, code is not found
		");

		// getAllCostCenter
		$arrayOfCostCenter = $this->getCostCenter();

		/**
		 * -------------------------------------
		 * This is need query optimazion
		 * The programmer too lazy to make it
		 * Thanks
		 * -------------------------------------
		 */

		/**
		 * Category by group
		 */
		$cost_center_category = [
			[
				'head_code' => 'NON_PRODUKSI',
				'name' => 'Non Produksi',
				'target' => 'tab1',
				'active' => true,
				'table_id' => 'table1',
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::NON_PRODUKSI)
			],
			[
				'head_code' => 'PRODUKSI_FABRIKASI_PUSAT',
				'name' => 'Produksi Fabrikasi (Pusat)',
				'target' => 'tab2',
				'active' => false,
				'table_id' => 'table2',
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_FABRIKASI_PUSAT)
			],
			[
				'head_code' => 'PRODUKSI_NON_FABRIKASI_PUSAT',
				'name' => 'Produksi Non Fabrikasi (Pusat)',
				'target' => 'tab3',
				'active' => false,
				'table_id' => 'table3',
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_NON_FABRIKASI_PUSAT)
			],
			[
				'head_code' => 'PRODUKSI_FABRIKASI_TUKSONO',
				'name' => 'Produksi Fabrikasi (Tuksono)',
				'target' => 'tab4',
				'active' => false,
				'table_id' => 'table4',
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_FABRIKASI_TUKSONO)
			],
			[
				'head_code' => 'PRODUKSI_NON_FABRIKASI_TUKSONO',
				'name' => 'Produksi Non Fabrikasi (Tuksono)',
				'target' => 'tab5',
				'active' => false,
				'table_id' => 'table5',
				'data' => $this->categoryByGroup($arrayOfCostCenter, self::PRODUKSI_NON_FABRIKASI_TUKSONO)
			]
		];

		//
		if ($specific_code) {
			$cost_center_category = array_filter($cost_center_category, function ($item) use ($specific_code) {
				return $item['head_code'] == $specific_code;
			});
			$cost_center_category = array_values($cost_center_category);
		}

		// debug($cost_center_category);
		// Lets write excel
		$Obj = new PHPExcel;

		$style = (object)[
			'align' => (object)[
				'center' => array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				),
				'left' => array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				),
				'right' => array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				)
			],
			'border' => (object)[
				'all' => array(
					'borders' => array(
						'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('black'))
					)
				),
				'vertical' => array(
					'borders' => array(
						'vertical' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
					)
				),
				'bottom' => array(
					'borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),
				'horizontal' => array(
					'borders' => array(
						'horizontal' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				)
			],
			'background' => (object)[
				'orange' => array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'ffddcc')
					)
				),
				'lightblue' => [
					'fill' => [
						'type' => 'solid',
						'color' => ['rgb' => '00b0f0']
					]
				]
			],
			'font' => (object)[
				'bold' => [
					'font' => [
						'bold' => true
					]
				]
			],
			'color' => (object)[
				'white' => [
					'font' => [
						'color' => ['rgb' => 'ffffff']
					]
				]
			]
		];

		$Obj->getProperties()->setCreator("Quick-ERP")
			->setLastModifiedBy("Quick-ERP");
		$Obj->getActiveSheet()->getPageSetup()
			->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$Obj->getActiveSheet()->getPageSetup()
			->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

		$Obj->setActiveSheetIndex(0);
		$sheet = $Obj->getActiveSheet();

		/**
		 * Set column width
		 */
		$sheet->getColumnDimension('A')->setWidth(20);
		$sheet->getColumnDimension('B')->setWidth(15);
		$sheet->getColumnDimension('C')->setWidth(60);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(10);
		$sheet->getColumnDimension('I')->setWidth(20);
		$sheet->getColumnDimension('J')->setWidth(20);
		$sheet->getColumnDimension('K')->setWidth(20);

		// Head
		$sheet->setCellValue('A1', 'Grouping');
		$sheet->setCellValue('B1', 'Cost Center');
		$sheet->setCellValue('C1', 'Description');
		$sheet->setCellValue('D1', 'Branch');
		$sheet->setCellValue('E1', 'Area');
		$sheet->setCellValue('F1', 'Lokasi');
		$sheet->setCellValue('G1', 'Gedung');
		$sheet->setCellValue('H1', 'Lantai');
		$sheet->setCellValue('I1', 'Luas Area (m2)');
		$sheet->setCellValue('J1', 'Total Luas Area (m2)');
		$sheet->setCellValue('K1', 'Last Update');

		$sheet->getStyle('A1:K1')->applyFromArray($style->align->center);
		$sheet->getStyle('A1:K1')->applyFromArray($style->font->bold);

		$row = 2;
		foreach ($cost_center_category as $cost_center) {
			// Head Title
			$sheet->mergeCells("A$row:K$row");
			$sheet->getStyle("A$row")->applyFromArray($style->background->orange);
			$sheet->setCellValue("A$row", $cost_center['name']);

			$rowHere = $row + 1;
			foreach ($cost_center['data'] as $item) {
				$row++;
				// cost center
				$sheet->setCellValueExplicit("B$row", $item->COST_CENTER);
				$sheet->getStyle("B$row")->applyFromArray($style->align->center);
				$sheet->setCellValue("C$row", $item->SECTION);
				$sheet->setCellValue("D$row", $item->LOCATION);
				$sheet->getStyle("D$row")->applyFromArray($style->align->center);
				$sheet->mergeCells("E$row:I$row");
				$sheet->setCellValue("J$row", isset($item->AREA) ? $item->AREA . " m²" : '');
				$sheet->getStyle("J$row")->applyFromArray($style->align->center);

				// if (isset($item->AREA)) {
				// 	// Add a checkbox to K column
				// 	$sheet->getStyle("K$row")->applyFromArray($style->background->lightblue);
				// 	$sheet->getStyle("K$row")->applyFromArray($style->align->center);
				// 	$sheet->getStyle("K$row")->applyFromArray($style->color->white);
				// 	$sheet->setCellValue("K$row", "☑");
				// }

				// area
				$rowSecond = $row + 1;
				if (isset($item->DATA)) {
					foreach ($item->DATA as $area) {
						$row++;
						$sheet->setCellValue("E$row", $area->nama_area);
						$sheet->setCellValue("F$row", $area->lokasi);
						$sheet->setCellValue("G$row", $area->nama_gedung);
						$sheet->setCellValue("H$row", $area->lantai);
						$sheet->getStyle("H$row")->applyFromArray($style->align->center);
						$sheet->setCellValue("I$row", isset($area->luas_area) ? $area->luas_area . " m²" : '');
						$sheet->getStyle("I$row")->applyFromArray($style->align->center);
						$sheet->getStyle("J$row")->applyFromArray($style->align->center);
						$sheet->setCellValue("K$row", (date('d-m-Y', strtotime(isset($area->updated_at) ? $area->updated_at : $area->created_at))) . " - " . $area->created_by);
						$sheet->getStyle("K$row")->applyFromArray($style->align->center);
					}

					// space kiri
					$sheet->mergeCells("B$rowSecond:C$row");
					// space kanan
					$sheet->mergeCells("J$rowSecond:J$row");
				}
			}

			// set merge space column
			$sheet->mergeCells("A$rowHere:A$row");
		}

		// set all to bordered
		$sheet->getStyle("A1:K$row")->applyFromArray($style->border->all);

		if ($specific_code) {
			$filename = "Luas_area_cost_center_" . $cost_center_category[0]['name'] . "_" . date('d-m-Y His');
		} else {
			$filename = "Luas_area_cost_center_semua_" . date('d-m-Y His');
		}

		/**
		 * Send to http response
		 */
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment;filename=$filename.xlsx");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($Obj, 'Excel2007');
		$objWriter->save('php://output');
	}
}
