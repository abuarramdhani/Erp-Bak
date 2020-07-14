<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_DataAssets extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		$this->load->model('FixedAsset/MainMenu/M_dataassets');
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
		
		$data['DataAsset'] = $this->M_dataassets->GetDataAssets();
		
		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('FixedAsset/MainMenu/DataAssets/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function LoadDataAsset()
	{	$user_id = $this->session->userid;
				
		/*
		 * DataTables example server-side processing script.
		 *
		 * Please note that this script is intentionally extremely simply to show how
		 * server-side processing can be implemented, and probably shouldn't be used as
		 * the basis for a large complex system. It is suitable for simple use cases as
		 * for learning.
		 *
		 * See http://datatables.net/usage/server-side for full details on the server-
		 * side processing requirements of DataTables.
		 *
		 * @license MIT - http://datatables.net/license_mit
		 */
		 
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Easy set variables
		 */
		 
		// DB table to use
		$table = 'fa.fa_data_assets';
		 
		// Table's primary key
		$primaryKey = 'asset_data_id';
		 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		if ($this->session->user == 'B0269' || $this->session->user == 'P0255') {
			$columns = array(
			
			array( 
            'db' => 'asset_data_id', 
            'dt' => 0,
            'formatter' => function( $d, $row ) {
                	return '<p style="text-align:center;">-</p>';
            	},
			),
			array( 'db' => 'asset_data_id', 	'dt' => 1 ),
			array( 'db' => 'tag_number', 		'dt' => 2 ),
			array( 'db' => 'location',  		'dt' => 3 ),
			array( 'db' => 'asset_category',   	'dt' => 4 ),
			array( 'db' => 'item_code',     	'dt' => 5 ),
			array( 'db' => 'specification',     'dt' => 6 ),
			array( 'db' => 'serial_number',     'dt' => 7 ),
			array( 'db' => 'power',     		'dt' => 8 ),
			array( 'db' => 'old_number',     	'dt' => 9 ),
			array(
				'db'        => 'ownership_date',
				'dt'        => 10,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'person_in_charge',  'dt' => 11 ),
			array( 'db' => 'bppba_number',     	'dt' => 12 ),
			array(
				'db'        => 'bppba_date',
				'dt'        => 13,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
					
				}
			),
			array( 'db' => 'lpa_number',     	'dt' => 14),
			array(
				'db'        => 'lpa_date',
				'dt'        => 15,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'transfer_number',    'dt' => 16 ),
			array(
				'db'        => 'transfer_date',
				'dt'        => 17,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'retirement_number', 'dt' => 18 ),
			array(
				'db'        => 'retirement_date',
				'dt'        => 19,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'pp_number',     	'dt' => 20 ),
			array( 'db' => 'po_number',     	'dt' => 21 ),
			array( 'db' => 'pr_number',     	'dt' => 22 ),
			array( 'db' => 'add_by',     		'dt' => 23 ),
			array(
				'db'        => 'add_by_date',
				'dt'        => 24,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return strtoupper(date( 'd-M-Y', strtotime($d)));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'upload_oracle',     'dt' => 25),
			array(
				'db'        => 'upload_oracle_date',
				'dt'        => 26,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'description',     	'dt' => 27 ),
			array( 'db' => 'insurance',     	'dt' => 28 ),
			array( 'db' => 'appraisal',     	'dt' => 29 ),
			array( 'db' => 'stock_opname',      'dt' => 30 ),
			array( 'db' => 'sticker',     		'dt' => 31 ),
			array(
				'db'        => 'asset_value',
				'dt'        => 32,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return number_format($d);
					}else{
						return '';
					}
					
				}
			),
			array(
				'db'        => 'asset_age',
				'dt'        => 33,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return number_format($d);
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'asset_group',     	'dt' => 34 ),
			
		);
		} else {
			$columns = array(
			
			array( 
            'db' => 'asset_data_id', 
            'dt' => 0,
            'formatter' => function( $d, $row ) {
	        		$buttons='<a style="margin-right:8px;margin-left:4px;" name="btnDelConf" href="'.site_url("FixedAsset/DataAssets/DeleteData/".$row['asset_data_id']).'"alt="Delete" title="Delete" data-confirm="Are you sure to delete this item?">
						<i class="fa fa-trash fa-2x"></i>
					</a>
					<a style="margin-right:8px;" href="'.site_url("FixedAsset/DataAssets/Update/".$row['asset_data_id']).'"  alt="Update" title="Update" >
						<i class="fa fa-pencil-square-o fa-2x"></i>
					</a>
					<a style="margin-right:8px;" href="'.site_url("FixedAsset/DataAssets/Copy/".$row['asset_data_id']).'"  alt="Copy" title="Copy">
						<i class="fa fa-files-o fa-2x"></i>
					</a>
					<input type="hidden" id="txtAssetid" name="txtAssetid[]" value="'.$row['asset_data_id'].'"  form="frmDeleteAsset"/>
					<input type="hidden" id="txtAssetid" name="txtAssetid[]" value="'.$row['asset_data_id'].'"  form="frmUpdateAsset"/>';
	        		return $buttons;
	        	},
			),
			array( 'db' => 'asset_data_id', 	'dt' => 1 ),
			array( 'db' => 'tag_number', 		'dt' => 2 ),
			array( 'db' => 'location',  		'dt' => 3 ),
			array( 'db' => 'asset_category',   	'dt' => 4 ),
			array( 'db' => 'item_code',     	'dt' => 5 ),
			array( 'db' => 'specification',     'dt' => 6 ),
			array( 'db' => 'serial_number',     'dt' => 7 ),
			array( 'db' => 'power',     		'dt' => 8 ),
			array( 'db' => 'old_number',     	'dt' => 9 ),
			array(
				'db'        => 'ownership_date',
				'dt'        => 10,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'person_in_charge',  'dt' => 11 ),
			array( 'db' => 'bppba_number',     	'dt' => 12 ),
			array(
				'db'        => 'bppba_date',
				'dt'        => 13,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
					
				}
			),
			array( 'db' => 'lpa_number',     	'dt' => 14),
			array(
				'db'        => 'lpa_date',
				'dt'        => 15,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'transfer_number',    'dt' => 16 ),
			array(
				'db'        => 'transfer_date',
				'dt'        => 17,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'retirement_number', 'dt' => 18 ),
			array(
				'db'        => 'retirement_date',
				'dt'        => 19,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'pp_number',     	'dt' => 20 ),
			array( 'db' => 'po_number',     	'dt' => 21 ),
			array( 'db' => 'pr_number',     	'dt' => 22 ),
			array( 'db' => 'add_by',     		'dt' => 23 ),
			array(
				'db'        => 'add_by_date',
				'dt'        => 24,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return strtoupper(date( 'd-M-Y', strtotime($d)));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'upload_oracle',     'dt' => 25),
			array(
				'db'        => 'upload_oracle_date',
				'dt'        => 26,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return date( 'd-M-Y', strtotime($d));
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'description',     	'dt' => 27 ),
			array( 'db' => 'insurance',     	'dt' => 28 ),
			array( 'db' => 'appraisal',     	'dt' => 29 ),
			array( 'db' => 'stock_opname',      'dt' => 30 ),
			array( 'db' => 'sticker',     		'dt' => 31 ),
			array(
				'db'        => 'asset_value',
				'dt'        => 32,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return number_format($d);
					}else{
						return '';
					}
					
				}
			),
			array(
				'db'        => 'asset_age',
				'dt'        => 33,
				'formatter' => function( $d, $row ) {
					if(isset($d)){
						return number_format($d);
					}else{
						return '';
					}
				}
			),
			array( 'db' => 'asset_group',     	'dt' => 34 ),
			
		);
		}
		 
		// SQL server connection information
		$sql_details = array(
			'user' => 'postgres',
			'pass' => 'password',
			'db'   => 'erp',
			'host' => 'database.quick.com'
		);
		 
		 
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP
		 * server-side, there is no need to edit below this line.
		 */
		 
		$conditions = '1=1'; 
		 
		$this->load->library('Ssp');
		
		$SSP = new SSP;
		 
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$conditions )
		);
	}
	
	public function Create()
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
		
		$data['Location'] = $this->M_dataassets->getLocation();
		$data['ItemCode'] = $this->M_dataassets->getItemCode();
		
		$this->form_validation->set_rules('slcItemCode', 'TagNumber', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FixedAsset/MainMenu/DataAssets/V_create',$data);
			$this->load->view('V_Footer',$data);

		}
		else
		{
			$tag_number				= $this->input->post('txtTagNumber');
			$location 				= $this->input->post('slcLocation');
			// $location_description 	= $this->input->post('txtLocationDescription');
			$asset_category 		= $this->input->post('slcAssetCategory');
			$item_code				= $this->input->post('slcItemCode');
			// $item_name 				= $this->input->post('txtItemName');
			$specification 			= $this->input->post('slcSpecification');
			$serial_number 			= $this->input->post('txtSerialNumber');
			$power 					= $this->input->post('txtPower');
			$old_number 			= $this->input->post('txtOldNumber');
			$person_in_charge 		= $this->input->post('txtPic');
			$bppba_number 			= $this->input->post('slcBppbaNumber');
			$bppba_date 			= $this->input->post('txtBppbaDate');
			$lpa_number 			= $this->input->post('slcLpaNumber');
			$lpa_date 				= $this->input->post('txtLpaDate');
			$transfer_number 		= $this->input->post('slcTransferNumber');
			$transfer_date 			= $this->input->post('txtTransferDate');
			$retirement_number 		= $this->input->post('slcRetirementNumber');
			$retirement_date 		= $this->input->post('txtRetirementDate');
			$pp_number 				= $this->input->post('slcPpNumber');
			$po_number 				= $this->input->post('slcPoNumber');
			$pr_number 				= $this->input->post('slcPrNumber');
			// $add_by 				= $this->input->post('slcAddBy');
			// $add_by_date 			= $this->input->post('txtAddByDate');
			$upload_oracle 			= $this->input->post('slcUploadOracle');
			$upload_oracle_date 	= $this->input->post('txtUploadOracleDate');
			$description 			= $this->input->post('txtDescription');
			$insurance 				= $this->input->post('txtInsurance');
			$appraisal				= $this->input->post('txtAppraisal');
			$stock_opname 			= $this->input->post('txtSo');
			$asset_value 			= $this->input->post('txtAssetValue');
			$sticker 				= $this->input->post('slcSticker');
			$ownership_date 		= $this->input->post('txtOwnershipDate');
			$asset_age 				= $this->input->post('txtAssetAge');
			$asset_group 			= $this->input->post('txtAssetGroup');
			$data = array (
				'tag_number'		 	=> (!empty($tag_number))?$tag_number:NULL,
				'location'	 			=> (!empty($location))?$location:NULL,
				// 'location_description'	=> $location_description,
				'asset_category'	 	=> (!empty($asset_category))?$asset_category:NULL,
				'item_code'	 			=> (!empty($item_code))?$item_code:NULL,
				// 'item_name'	 			=> $item_name,
				'specification'	 		=> (!empty($specification))?$specification:NULL,
				'serial_number'	 		=> (!empty($serial_number))?$serial_number:NULL,
				'power'	 				=> (!empty($power))?$power:NULL,
				'old_number'	 		=> (!empty($old_number))?$old_number:NULL,
				'person_in_charge'		=> (!empty($person_in_charge))?$person_in_charge:NULL,
				'bppba_number'	 		=> (!empty($bppba_number))?$bppba_number:NULL,
				'bppba_date'			=> (!empty($bppba_date))?$bppba_date:NULL,
				'lpa_number'	 		=> (!empty($lpa_number))?$lpa_number:NULL,
				'lpa_date'	 			=> (!empty($lpa_date))?$lpa_date:NULL,
				'transfer_number'	 	=> (!empty($transfer_number))?$transfer_number:NULL,
				'transfer_date'	 		=> (!empty($transfer_date))?$transfer_date:NULL,
				'retirement_number'	 	=> (!empty($retirement_number))?$retirement_number:NULL,
				'retirement_date'	 	=> (!empty($retirement_date))?$retirement_date:NULL,
				'pp_number'	 			=> (!empty($pp_number))?$pp_number:NULL,
				'po_number'	 			=> (!empty($po_number))?$po_number:NULL,
				'pr_number'	 			=> (!empty($pr_number))?$pr_number:NULL,
				'add_by'	 			=> $user,
				'add_by_date'	 		=> date("d-M-Y"),
				'upload_oracle'	 		=> (!empty($upload_oracle))?$upload_oracle:NULL,
				'upload_oracle_date'	=> (!empty($upload_oracle_date))?$upload_oracle_date:NULL,
				'description'	 		=> (!empty($description))?$description:NULL,
				'insurance'	 			=> (!empty($insurance))?$insurance:NULL,
				'appraisal'	 			=> (!empty($appraisal))?$appraisal:NULL,
				'stock_opname'	 		=> (!empty($stock_opname))?$stock_opname:NULL,
				'asset_value'	 		=> (!empty($asset_value))?str_replace(",","",$asset_value):NULL,
				'sticker'	 			=> (!empty($sticker))?$sticker:NULL,
				'ownership_date'	 	=> (!empty($ownership_date))?$ownership_date:NULL,
				'asset_age'	 			=> (!empty($asset_age))?$asset_age:NULL,
				'asset_group'	 		=> (!empty($asset_group))?$asset_group:NULL,
			);
			$this->M_dataassets->TambahDataAssets($data);
			redirect('FixedAsset/DataAssets/Create');
		}
		
		
	}
	
	public function DeleteData($asset_data_id)
	{
		$this->db->delete('fa.fa_data_assets', array('asset_data_id' => $asset_data_id));
		$this->db->delete('fa.fa_data_asset_histories', array('asset_data_id' => $asset_data_id));
		redirect('FixedAsset/DataAssets');
	}
	
	public function Update($asset_data_id)
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
	
		$data['DataAsset'] = $this->M_dataassets->GetDataAssets($asset_data_id);
		$data['AssetHistories'] = $this->M_dataassets->GetDataAssetHistories($asset_data_id);
		
		$this->form_validation->set_rules('slcItemCode', 'TagNumber', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FixedAsset/MainMenu/DataAssets/V_update',$data);
			$this->load->view('V_Footer',$data);

		}
		else
		{	
			$tag_number				= $this->input->post('txtTagNumber');
			$location 				= $this->input->post('slcLocation');
			// $location_description 	= $this->input->post('txtLocationDescription');
			$asset_category 		= $this->input->post('slcAssetCategory');
			$item_code				= $this->input->post('slcItemCode');
			// $item_name 				= $this->input->post('txtItemName');
			$specification 			= $this->input->post('slcSpecification');
			$serial_number 			= $this->input->post('txtSerialNumber');
			$power 					= $this->input->post('txtPower');
			$old_number 			= $this->input->post('txtOldNumber');
			$person_in_charge 		= $this->input->post('txtPic');
			$bppba_number 			= $this->input->post('slcBppbaNumber');
			$bppba_date 			= $this->input->post('txtBppbaDate');
			$lpa_number 			= $this->input->post('slcLpaNumber');
			$lpa_date 				= $this->input->post('txtLpaDate');
			$transfer_number 		= $this->input->post('slcTransferNumber');
			$transfer_date 			= $this->input->post('txtTransferDate');
			$retirement_number 		= $this->input->post('slcRetirementNumber');
			$retirement_date 		= $this->input->post('txtRetirementDate');
			$pp_number 				= $this->input->post('slcPpNumber');
			$po_number 				= $this->input->post('slcPoNumber');
			$pr_number 				= $this->input->post('slcPrNumber');
			// $add_by 				= intval($this->input->post('slcAddBy'));
			// $add_by_date 			= $this->input->post('txtAddByDate');
			$upload_oracle 			= $this->input->post('slcUploadOracle');
			$upload_oracle_date 	= $this->input->post('txtUploadOracleDate');
			$description 			= $this->input->post('txtDescription');
			$insurance 				= $this->input->post('txtInsurance');
			$appraisal				= $this->input->post('txtAppraisal');
			$stock_opname 			= $this->input->post('txtSo');
			$asset_value 			= $this->input->post('txtAssetValue');
			$sticker 				= $this->input->post('slcSticker');
			$ownership_date 		= $this->input->post('txtOwnershipDate');
			$asset_age 				= $this->input->post('txtAssetAge');
			$asset_group 			= $this->input->post('txtAssetGroup');
			$data = array (
				'tag_number'		 	=> (!empty($tag_number))?$tag_number:NULL,
				'location'	 			=> (!empty($location))?$location:NULL,
				// 'location_description'	=> $location_description,
				'asset_category'	 	=> (!empty($asset_category))?$asset_category:NULL,
				'item_code'	 			=> (!empty($item_code))?$item_code:NULL,
				// 'item_name'	 			=> $item_name,
				'specification'	 		=> (!empty($specification))?$specification:NULL,
				'serial_number'	 		=> (!empty($serial_number))?$serial_number:NULL,
				'power'	 				=> (!empty($power))?$power:NULL,
				'old_number'	 		=> (!empty($old_number))?$old_number:NULL,
				'person_in_charge'		=> (!empty($person_in_charge))?$person_in_charge:NULL,
				'bppba_number'	 		=> (!empty($bppba_number))?$bppba_number:NULL,
				'bppba_date'			=> (!empty($bppba_date))?$bppba_date:NULL,
				'lpa_number'	 		=> (!empty($lpa_number))?$lpa_number:NULL,
				'lpa_date'	 			=> (!empty($lpa_date))?$lpa_date:NULL,
				'transfer_number'	 	=> (!empty($transfer_number))?$transfer_number:NULL,
				'transfer_date'	 		=> (!empty($transfer_date))?$transfer_date:NULL,
				'retirement_number'	 	=> (!empty($retirement_number))?$retirement_number:NULL,
				'retirement_date'	 	=> (!empty($retirement_date))?$retirement_date:NULL,
				'pp_number'	 			=> (!empty($pp_number))?$pp_number:NULL,
				'po_number'	 			=> (!empty($po_number))?$po_number:NULL,
				'pr_number'	 			=> (!empty($pr_number))?$pr_number:NULL,
				// 'add_by'	 			=> (!empty($add_by))?$add_by:NULL,
				// 'add_by_date'	 		=> (!empty($add_by_date))?$add_by_date:NULL,
				'upload_oracle'	 		=> (!empty($upload_oracle))?$upload_oracle:NULL,
				'upload_oracle_date'	=> (!empty($upload_oracle_date))?$upload_oracle_date:NULL,
				'description'	 		=> (!empty($description))?$description:NULL,
				'insurance'	 			=> (!empty($insurance))?$insurance:NULL,
				'appraisal'	 			=> (!empty($appraisal))?$appraisal:NULL,
				'stock_opname'	 		=> (!empty($stock_opname))?$stock_opname:NULL,
				'asset_value'	 		=> (!empty($asset_value))?str_replace(",","",$asset_value):NULL,
				'sticker'	 			=> (!empty($sticker))?$sticker:NULL,
				'ownership_date'	 	=> (!empty($ownership_date))?$ownership_date:NULL,
				'asset_age'	 			=> (!empty($asset_age))?$asset_age:NULL,
				'asset_group'	 		=> (!empty($asset_group))?$asset_group:NULL,
			);
			
			if($location !== $data['DataAsset'][0]['location']){
				$data_location = array(
					'asset_data_id'		 	=> $asset_data_id,
					'location'	 			=> $location,
					'created_by'	 		=> $user,
					'creation_date'	 		=> date("d-M-Y H:i:s")
				);
				
				$this->M_dataassets->TambahDataAssetHistories($data_location);
			}
			
			$this->M_dataassets->UpdateDataAssets($asset_data_id, $data);
			redirect('FixedAsset/DataAssets');
		}
		
	}
	
	public function Copy($asset_data_id)
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
	
		$data['data_assets_update'] = $this->M_dataassets->GetDataAssets($asset_data_id);
		
		$this->form_validation->set_rules('slcItemCode', 'TagNumber', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FixedAsset/MainMenu/DataAssets/V_copy',$data);
			$this->load->view('V_Footer',$data);

		}
		else
		{	
			$tag_number				= $this->input->post('txtTagNumber');
			$location 				= $this->input->post('slcLocation');
			// $location_description 	= $this->input->post('txtLocationDescription');
			$asset_category 		= $this->input->post('slcAssetCategory');
			$item_code				= $this->input->post('slcItemCode');
			// $item_name 				= $this->input->post('txtItemName');
			$specification 			= $this->input->post('slcSpecification');
			$serial_number 			= $this->input->post('txtSerialNumber');
			$power 					= $this->input->post('txtPower');
			$old_number 			= $this->input->post('txtOldNumber');
			$person_in_charge 		= $this->input->post('txtPic');
			$bppba_number 			= $this->input->post('slcBppbaNumber');
			$bppba_date 			= $this->input->post('txtBppbaDate');
			$lpa_number 			= $this->input->post('slcLpaNumber');
			$lpa_date 				= $this->input->post('txtLpaDate');
			$transfer_number 		= $this->input->post('slcTransferNumber');
			$transfer_date 			= $this->input->post('txtTransferDate');
			$retirement_number 		= $this->input->post('slcRetirementNumber');
			$retirement_date 		= $this->input->post('txtRetirementDate');
			$pp_number 				= $this->input->post('slcPpNumber');
			$po_number 				= $this->input->post('slcPoNumber');
			$pr_number 				= $this->input->post('slcPrNumber');
			// $add_by 				= intval($this->input->post('slcAddBy'));
			// $add_by_date 			= $this->input->post('txtAddByDate');
			$upload_oracle 			= $this->input->post('slcUploadOracle');
			$upload_oracle_date 	= $this->input->post('txtUploadOracleDate');
			$description 			= $this->input->post('txtDescription');
			$insurance 				= $this->input->post('txtInsurance');
			$appraisal				= $this->input->post('txtAppraisal');
			$stock_opname 			= $this->input->post('txtSo');
			$asset_value 			= $this->input->post('txtAssetValue');
			$sticker 				= $this->input->post('slcSticker');
			$ownership_date 		= $this->input->post('txtOwnershipDate');
			$asset_age 				= $this->input->post('txtAssetAge');
			$asset_group 			= $this->input->post('txtAssetGroup');
			$data = array (
				'tag_number'		 	=> (!empty($tag_number))?$tag_number:NULL,
				'location'	 			=> (!empty($location))?$location:NULL,
				// 'location_description'	=> $location_description,
				'asset_category'	 	=> (!empty($asset_category))?$asset_category:NULL,
				'item_code'	 			=> (!empty($item_code))?$item_code:NULL,
				// 'item_name'	 			=> $item_name,
				'specification'	 		=> (!empty($specification))?$specification:NULL,
				'serial_number'	 		=> (!empty($serial_number))?$serial_number:NULL,
				'power'	 				=> (!empty($power))?$power:NULL,
				'old_number'	 		=> (!empty($old_number))?$old_number:NULL,
				'person_in_charge'		=> (!empty($person_in_charge))?$person_in_charge:NULL,
				'bppba_number'	 		=> (!empty($bppba_number))?$bppba_number:NULL,
				'bppba_date'			=> (!empty($bppba_date))?$bppba_date:NULL,
				'lpa_number'	 		=> (!empty($lpa_number))?$lpa_number:NULL,
				'lpa_date'	 			=> (!empty($lpa_date))?$lpa_date:NULL,
				'transfer_number'	 	=> (!empty($transfer_number))?$transfer_number:NULL,
				'transfer_date'	 		=> (!empty($transfer_date))?$transfer_date:NULL,
				'retirement_number'	 	=> (!empty($retirement_number))?$retirement_number:NULL,
				'retirement_date'	 	=> (!empty($retirement_date))?$retirement_date:NULL,
				'pp_number'	 			=> (!empty($pp_number))?$pp_number:NULL,
				'po_number'	 			=> (!empty($po_number))?$po_number:NULL,
				'pr_number'	 			=> (!empty($pr_number))?$pr_number:NULL,
				'add_by'	 			=> $user,
				'add_by_date'	 		=> date("d-M-Y"),
				'upload_oracle'	 		=> (!empty($upload_oracle))?$upload_oracle:NULL,
				'upload_oracle_date'	=> (!empty($upload_oracle_date))?$upload_oracle_date:NULL,
				'description'	 		=> (!empty($description))?$description:NULL,
				'insurance'	 			=> (!empty($insurance))?$insurance:NULL,
				'appraisal'	 			=> (!empty($appraisal))?$appraisal:NULL,
				'stock_opname'	 		=> (!empty($stock_opname))?$stock_opname:NULL,
				'asset_value'	 		=> (!empty($asset_value))?str_replace(",","",$asset_value):NULL,
				'sticker'	 			=> (!empty($sticker))?$sticker:NULL,
				'ownership_date'	 	=> (!empty($ownership_date))?$ownership_date:NULL,
				'asset_age'	 			=> (!empty($asset_age))?$asset_age:NULL,
				'asset_group'	 		=> (!empty($asset_group))?$asset_group:NULL,
			);
			$this->M_dataassets->TambahDataAssets($data);
			redirect('FixedAsset/DataAssets');
		}
		
	}
	
	public function ExportImport()
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		if($this->input->post('btnUpload')){
			$config['upload_path']          = 'assets/upload/';
			$config['allowed_types']        = 'xls|xlsx|ods';
			$file_name = trim(addslashes($_FILES['fileSheet']['name']));
			$file_name = str_replace(' ', '_', $file_name);
			
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('fileSheet'))
			{
				$error = array('error' => $this->upload->display_errors());
				$error = $error['error'];

				echo $error;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$file = 'assets/upload/'.$file_name;
				// echo $file_name;
				try {
					$file_type = PHPExcel_IOFactory::identify($file);
					$reader = PHPExcel_IOFactory::createReader($file_type);
					$reader->setReadDataOnly(true);
					$php_excel = $reader->load($file);
					// echo $file_type;
				}
				catch(Exception $e) {
					die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
				}
				
				$sheet = $php_excel->getSheet();
				// $highest_row = $php_excel->setActiveSheetIndex(0)->getHighestRow();
				// $highest_column = $php_excel->setActiveSheetIndex(0)->getHighestColumn();
				// $highest_row = $sheet->getHighestRow();
				// $highest_column = $sheet->getHighestColumn();
				$highest_row = $sheet->getHighestDataRow();
				$highest_column = $sheet->getHighestDataColumn();
				
				//  Loop through each row of the worksheet in turn
				for ($row = 2; $row <= intval($highest_row); $row++){
					//  Read a row of data into an array
					$row_data = $sheet->rangeToArray('A' . $row . ':' . $highest_column . $row,
													NULL,
													TRUE,
													FALSE);
					// $import[$row] = $row_data;
					
					date_default_timezone_set('Asia/Jakarta');
					
					$tag_number				= (empty($row_data[0][0]))?NULL:$row_data[0][0];
					$location 				= (empty($row_data[0][1]))?NULL:$row_data[0][1];
					$asset_category 		= (empty($row_data[0][2]))?NULL:$row_data[0][2];
					$item_code				= (empty($row_data[0][3]))?NULL:$row_data[0][3];
					$specification 			= (empty($row_data[0][4]))?NULL:$row_data[0][4];
					$serial_number 			= (empty($row_data[0][5]))?NULL:$row_data[0][5];
					$power 					= (empty($row_data[0][6]))?NULL:$row_data[0][6];
					$old_number 			= (empty($row_data[0][7]))?NULL:$row_data[0][7];
					$ownership_date 		= (empty($row_data[0][8]))?'':date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row_data[0][8]));
					$person_in_charge 		= (empty($row_data[0][9]))?NULL:$row_data[0][9];
					$bppba_number 			= (empty($row_data[0][10]))?NULL:$row_data[0][10];
					$bppba_date 			= (empty($row_data[0][11]))?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row_data[0][11]));
					$lpa_number 			= (empty($row_data[0][12]))?NULL:$row_data[0][12];
					$lpa_date 				= (empty($row_data[0][13]))?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row_data[0][13]));
					$transfer_number 		= (empty($row_data[0][14]))?NULL:$row_data[0][14];
					$transfer_date 			= (empty($row_data[0][15]))?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row_data[0][15]));
					$retirement_number 		= (empty($row_data[0][16]))?NULL:$row_data[0][16];
					$retirement_date 		= (empty($row_data[0][17]))?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row_data[0][17]));
					$pp_number 				= (empty($row_data[0][18]))?NULL:$row_data[0][18];
					$po_number 				= (empty($row_data[0][19]))?NULL:$row_data[0][19];
					$pr_number 				= (empty($row_data[0][20]))?NULL:$row_data[0][20];
					$add_by 				= $user;//(empty($row_data[0][21]))?NULL:$row_data[0][21];
					$add_by_date 			= date('Y-m-d');
					$upload_oracle 			= (empty($row_data[0][23]))?NULL:$row_data[0][23];
					$upload_oracle_date 	= (empty($row_data[0][24]))?NULL:date('Y-m-d H:i:s', PHPExcel_Shared_Date::ExcelToPHP($row_data[0][24])- date('Z', $row_data[0][24]));//-7 jam untuk menjadikan sesuai timezone sekarang
					$description 			= (empty($row_data[0][25]))?NULL:$row_data[0][25];
					$insurance 				= (empty($row_data[0][26]))?NULL:$row_data[0][26];
					$appraisal				= (empty($row_data[0][27]))?NULL:$row_data[0][27];
					$stock_opname 			= (empty($row_data[0][28]))?NULL:$row_data[0][28];
					$sticker 				= (empty($row_data[0][29]))?NULL:$row_data[0][29];
					$asset_value 			= (empty($row_data[0][30]))?NULL:$row_data[0][30];
					$asset_age 				= (empty($row_data[0][31]))?NULL:$row_data[0][31];
					$asset_group 			= (empty($row_data[0][32]))?NULL:$row_data[0][32];
										
					$data_import = array (
						'tag_number'		 	=> (!empty($tag_number))?$tag_number:NULL,
						'location'	 			=> (!empty($location))?$location:NULL,
						'asset_category'	 	=> (!empty($asset_category))?$asset_category:NULL,
						'item_code'	 			=> (!empty($item_code))?$item_code:NULL,
						'specification'	 		=> (!empty($specification))?$specification:NULL,
						'serial_number'	 		=> (!empty($serial_number))?$serial_number:NULL,
						'power'	 				=> (!empty($power))?$power:NULL,
						'old_number'	 		=> (!empty($old_number))?$old_number:NULL,
						'person_in_charge'		=> (!empty($person_in_charge))?$person_in_charge:NULL,
						'bppba_number'	 		=> (!empty($bppba_number))?$bppba_number:NULL,
						'bppba_date'			=> (!empty($bppba_date))?$bppba_date:NULL,
						'lpa_number'	 		=> (!empty($lpa_number))?$lpa_number:NULL,
						'lpa_date'	 			=> (!empty($lpa_date))?$lpa_date:NULL,
						'transfer_number'	 	=> (!empty($transfer_number))?$transfer_number:NULL,
						'transfer_date'	 		=> (!empty($transfer_date))?$transfer_date:NULL,
						'retirement_number'	 	=> (!empty($retirement_number))?$retirement_number:NULL,
						'retirement_date'	 	=> (!empty($retirement_date))?$retirement_date:NULL,
						'pp_number'	 			=> (!empty($pp_number))?$pp_number:NULL,
						'po_number'	 			=> (!empty($po_number))?$po_number:NULL,
						'pr_number'	 			=> (!empty($pr_number))?$pr_number:NULL,
						'add_by'	 			=> (!empty($add_by))?$add_by:NULL,
						'add_by_date'	 		=> (!empty($add_by_date))?$add_by_date:NULL,
						'upload_oracle'	 		=> (!empty($upload_oracle))?$upload_oracle:NULL,
						'upload_oracle_date'	=> (!empty($upload_oracle_date))?$upload_oracle_date:NULL,
						'description'	 		=> (!empty($description))?$description:NULL,
						'insurance'	 			=> (!empty($insurance))?$insurance:NULL,
						'appraisal'	 			=> (!empty($appraisal))?$appraisal:NULL,
						'stock_opname'	 		=> (!empty($stock_opname))?$stock_opname:NULL,
						'sticker'	 			=> (!empty($sticker))?$sticker:NULL,
						'asset_value'	 		=> (!empty($asset_value))?$asset_value:NULL,
						'ownership_date'	 	=> (!empty($ownership_date))?$ownership_date:NULL,
						'asset_age'	 			=> (!empty($asset_age))?$asset_age:NULL,
						'asset_group'	 		=> (!empty($asset_group))?$asset_group:NULL,
					);
					/* try {
						$this->M_dataassets->TambahDataAssets($data_import);
					}
					catch(Exception $e) {
						unlink($file);
						die($e->getMessage());
					} */
					$this->M_dataassets->TambahDataAssets($data_import);
					//  Insert row data array into your database of choice here
					
				}
				unlink($file);
				redirect('FixedAsset/DataAssets');
				// print_r($data_import);
			}
			// echo $highest_row." & ".$highest_column;
			// print_r($import);
			// echo $tag_number;
			// redirect('FixedAsset/DataAssets');
		}else{
			// $data['DataAsset'] = $this->M_dataassets->GetDataAssets();
			$DataAsset = $this->M_dataassets->GetDataAssets();
			$name = "DataAsset".date("Ymd");
			
			$objPHPExcel = new PHPExcel();
			// writer already created the first sheet for us, let's get it
			$objSheet = $objPHPExcel->getActiveSheet();
			// rename the sheet
			$objSheet->setTitle('Task Results');
			// $this->load->view('FixedAsset/MainMenu/DataAssets/V_export',$data);
			$rowCount = 1;
			 $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, 'Tag Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, 'Location');
			 $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, 'Asset Category');
			 $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, 'Item');
			 $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, 'Specification');
			 $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, 'Serial Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, 'Power');
			 $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, 'Old Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, 'Person In Charge');
			 $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, 'BPPBA Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, 'BPPBA Date');
			 $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, 'LPA Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, 'LPA Date');
			 $objPHPExcel->getActiveSheet()->setCellValue('N'.$rowCount, 'Transfer Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, 'Transfer Date');
			 $objPHPExcel->getActiveSheet()->setCellValue('P'.$rowCount, 'Retirement Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('Q'.$rowCount, 'Retirement Date');
			 $objPHPExcel->getActiveSheet()->setCellValue('R'.$rowCount, 'PP Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('S'.$rowCount, 'PO Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('T'.$rowCount, 'PR Number');
			 $objPHPExcel->getActiveSheet()->setCellValue('U'.$rowCount, 'Add By');
			 $objPHPExcel->getActiveSheet()->setCellValue('V'.$rowCount, 'Added Date');
			 $objPHPExcel->getActiveSheet()->setCellValue('W'.$rowCount, 'Upload to Oracle By');
			 $objPHPExcel->getActiveSheet()->setCellValue('X'.$rowCount, 'Upload to Oracle Date');
			 $objPHPExcel->getActiveSheet()->setCellValue('Y'.$rowCount, 'Description');
			 $objPHPExcel->getActiveSheet()->setCellValue('Z'.$rowCount, 'Insurance');
			 $objPHPExcel->getActiveSheet()->setCellValue('AA'.$rowCount, 'Appraisal');
			 $objPHPExcel->getActiveSheet()->setCellValue('AB'.$rowCount, 'Stock Opname');
			
			$rowCount = 2;
			foreach ($DataAsset as $row):
				 $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $row['tag_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $row['location']);
				 $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $row['asset_category']);
				 $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $row['item_code']);
				 $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $row['specification']);
				 $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $row['serial_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $row['power']);
				 $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $row['old_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $row['person_in_charge']);
				 $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $row['bppba_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $row['bppba_date']);
				 $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, $row['lpa_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $row['lpa_date']);
				 $objPHPExcel->getActiveSheet()->setCellValue('N'.$rowCount, $row['transfer_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, $row['transfer_date']);
				 $objPHPExcel->getActiveSheet()->setCellValue('P'.$rowCount, $row['retirement_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('Q'.$rowCount, $row['retirement_date']);
				 $objPHPExcel->getActiveSheet()->setCellValue('R'.$rowCount, $row['pp_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('S'.$rowCount, $row['po_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('T'.$rowCount, $row['pr_number']);
				 $objPHPExcel->getActiveSheet()->setCellValue('U'.$rowCount, $row['add_by']);
				 $objPHPExcel->getActiveSheet()->setCellValue('V'.$rowCount, $row['add_by_date']);
				 $objPHPExcel->getActiveSheet()->setCellValue('W'.$rowCount, $row['upload_oracle']);
				 $objPHPExcel->getActiveSheet()->setCellValue('X'.$rowCount, $row['upload_oracle_date']);
				 $objPHPExcel->getActiveSheet()->setCellValue('Y'.$rowCount, $row['description']);
				 $objPHPExcel->getActiveSheet()->setCellValue('Z'.$rowCount, $row['insurance']);
				 $objPHPExcel->getActiveSheet()->setCellValue('AA'.$rowCount, $row['appraisal']);
				 $objPHPExcel->getActiveSheet()->setCellValue('AB'.$rowCount, $row['stock_opname']);
				$rowCount++;
			endforeach;
			
			header("Content-Type: application/vnd.ms-excel");   
			header("Content-Disposition: attachment; filename=$name.xls");
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');
		}
		
			
	}
	
	public function DeleteShown(){
		$asset_data_id = $this->input->post('txtAssetid');
		
		foreach($asset_data_id as $row=>$id){
			$this->db->delete('fa.fa_data_assets', array('asset_data_id' => $id));
			$this->db->delete('fa.fa_data_asset_histories', array('asset_data_id' => $id));
			// print_r($row." = ".$id);
		}
		
		redirect('FixedAsset/DataAssets');
	}
	
	public function UpdateShown(){
		$asset_data_id 	= $this->input->post('txtAssetid');
		$column 		= $this->input->post('slcColumn');
		$value 			= $this->input->post('txtColumnValue');
		$data = array (
			$column		 	=> (!empty($value))?$value:NULL,
		);
		foreach($asset_data_id as $row=>$id){
			$this->M_dataassets->UpdateDataAssets($id, $data);
		}
		// print_r($asset_data_id);
		redirect('FixedAsset/DataAssets');
	}
	
	public function ToExcel(){
		$data['DataAsset'] = $this->M_dataassets->GetDataAssets();
		
		$name = "DataAsset".date("Ymd");
		header("Content-Type: application/xls");   
        header("Content-Disposition: attachment; filename=$name.xls");
		
		$this->load->view('FixedAsset/MainMenu/DataAssets/V_export',$data);
		
	}
	
	public function GetTagNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getTagNumberJson($term);
		// echo json_encode($data);
	}
	
	public function GetLocation() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getLocationSelect2($term);
		// echo json_encode($data);
	}
	
	public function GetAssetCategory() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getAssetCategory($term);
		// echo json_encode($data);
	}
	
	public function GetItemCode() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getItemCodeSelect2($term);
		// echo json_encode($data);
	}
	
	public function GetSpecification() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getSpecificationSelect2($term);
		// echo json_encode($data);
	}
	
	public function GetBppbaNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getBppbaNumber($term);
		// echo json_encode($data);
	}
	
	public function GetLpaNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getLpaNumber($term);
		// echo json_encode($data);
	}
		
	public function GetTransferNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getTransferNumber($term);
		// echo json_encode($data);
	}
		
	public function GetRetirementNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getRetirementNumber($term);
		// echo json_encode($data);
	}
		
	public function GetPpNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getPpNumber($term);
		// echo json_encode($data);
	}
		
	public function GetPoNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getPoNumber($term);
		// echo json_encode($data);
	}
		
	public function GetPrNumber() 
	{
		$term = strtoupper($this->input->get('term'));
		$data = $this->M_dataassets->getPrNumber($term);
		// echo json_encode($data);
	}
		
	public function GetUploadOracle() 
	{
		// $term = strtoupper($this->input->get('term'));
		$term = strtoupper($_GET['term']);
		$data = $this->M_dataassets->getUploadOracle($term);
		echo json_encode($data);
		// echo $term;
	}
		
	public function getDateBppba() 
	{
		$bppba_number = $this->input->post('id');
		$data = $this->M_dataassets->getBppbaDate($bppba_number);
		if(!empty($data)){
			echo "";
		}else{
		foreach($data as $asset_data_id_item){
			$date_asset_data=$asset_data_id_item['bppba_date'];
		}
		$rename_date_asset_id=date("d-M-Y",strtotime($date_asset_data));
		echo $rename_date_asset_id;
		}
	}
	
	public function getDateLpa() 
	{
		$lpa_number = $this->input->post('id');
		$data = $this->M_dataassets->getLpaDate($lpa_number);
		if(!empty($data)){
			echo "";
		}else{
		foreach($data as $asset_data_id_item){
			$date_asset_data=$asset_data_id_item['lpa_date'];
		}
		$rename_date_asset_id=date("d-M-Y",strtotime($date_asset_data));
		echo $rename_date_asset_id;
		}
	}
	
	public function getDateTransfer() 
	{ 
		$transfer_number = $this->input->post('id');
		$data = $this->M_dataassets->getTransferDate($transfer_number);
		if(!empty($data)){
			echo "";
		}else{
		foreach($data as $asset_data_id_item){
			$date_asset_data=$asset_data_id_item['transfer_date'];
		}
		$rename_date_asset_id=date("d-M-Y",strtotime($date_asset_data));
		echo $rename_date_asset_id;
		}
	}
	
	public function getDateRetirement() 
	{
		$retirement_number = $this->input->post('id');
		$data = $this->M_dataassets->getRetirementDate($retirement_number);
		if(!empty($data)){
			echo "";
		}else{
		foreach($data as $asset_data_id_item){
			$date_asset_data=$asset_data_id_item['retirement_date'];
		}
		$rename_date_asset_id=date("d-M-Y",strtotime($date_asset_data));
		echo $rename_date_asset_id;
		}
	}
	
	public function getAddByDate() {
		$add_by = $this->input->post('id');
		$data = $this->M_dataassets->getAddByDate($add_by);
		if(!empty($data)){
			echo "";
		}else{
		foreach($data as $asset_data_id_item){
			$date_asset_data=$asset_data_id_item['add_by_date'];
		}
		$rename_date_asset_id=date("d-M-Y",strtotime($date_asset_data));
		echo $rename_date_asset_id;
		}
	}
	
	public function GetTagNumberInfo() {
		if (isset($_POST['term'])){
			$tag = $_POST['term'];//term = karakter yang kita ketikkan
		}else{
			$tag = "";
		}
		if ($_POST['id'] !== "0"){
			$id = $_POST['id'];//id = id dari data
		}else{
			$id = "";
		}
		if($id === ""){
			$data = $this->M_dataassets->getTagNumber($tag);
		}else{
			$asset = $this->M_dataassets->getTagNumber($tag);
			if(count($asset) === 0){
				$data = "";
			}
			elseif(count($asset) === 1 and $asset[0]['asset_data_id'] == $id){
				$data = "";
			}
			else{
				$data = "NotEmpty";
			}
		}
		
		if(empty($data)){
			$result = "OK";
		}else{
			$result = "DANGER";
		}
		echo $result;
	}
	
	public function GetOldNumberInfo() {
		if (isset($_POST['term'])){
			$tag = $_POST['term'];//term = karakter yang kita ketikkan
		}else{
			$tag = "";
		}
		if ($_POST['id'] !== "0"){
			$id = $_POST['id'];//id = id dari data
		}else{
			$id = "";
		}
		if($id === ""){
			$data = $this->M_dataassets->getOldNumber($tag);
		}else{
			$asset = $this->M_dataassets->getOldNumber($tag);
			if(count($asset) === 0){
				$data = "";
			}
			elseif(count($asset) === 1 and $asset[0]['asset_data_id'] == $id){
				$data = "";
			}
			else{
				$data = "NotEmpty";
			}
		}
		
		if(empty($data)){
			$result = "OK";
		}else{
			$result = "DANGER";
		}
		echo $result;
	}
	
	public function CheckDuplicateAll() {
		if (isset($_POST['tag'])){
			$tag = $_POST['tag'];//term = karakter yang kita ketikkan
		}else{
			$tag = "";
		}
		if ($_POST['id'] !== "0"){
			$id = $_POST['id'];//id = id dari data
		}else{
			$id = "";
		}
		if (isset($_POST['old'])){
			$old = $_POST['old'];//term = karakter yang kita ketikkan
		}else{
			$old = "";
		}
		if($id === ""){
			$data = $this->M_dataassets->getDuplicate($tag,$old);
		}else{
			$asset = $this->M_dataassets->getDuplicate($tag,$old);
			if(count($asset) === 0){
				$data = "";
			}
			elseif(count($asset) === 1 and $asset[0]['asset_data_id'] == $id){
				$data = "";
			}
			else{
				$data = "NotEmpty";
			}
		}
		
		if(empty($data)){
			$result = "OK";
		}else{
			$result = "DANGER";
		}
		echo $result;
	}

	public function assetBon ()
	{	$user_id = $this->session->userid;
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['assets'] = $this->M_dataassets->getassetBon();

		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('FixedAsset/MainMenu/DataAssets/V_assetBon',$data);
		$this->load->view('V_Footer',$data);
	}

	public function addtag ()
	{	$user_id = $this->session->userid;
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$id = $this->input->post('asset_id');
		$data['assets'] = $this->M_dataassets->getassetId($id);

		$data['Menu'] = 'Data Asset';
		$data['SubMenuOne'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('FixedAsset/MainMenu/DataAssets/V_addtag',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function inputTagNumber ()
	{
		$user_id = $this->session->userid;

		$id_assets = $this->input->post('asset_id');
		$tag_num = $this->input->post('txtTag');
		$cost_cen = $this->input->post('txtCost');
		$umur_tek = $this->input->post('txtUmur');
		$location = $this->input->post('txtSeksi');

		$kode = $this->input->post('txtKode');
		$item = $this->input->post('txtNama');
		$item_code = $kode.' : '.$item;

		$specification = $this->input->post('txaSpek');
		$description = $this->input->post('txaInfo');
		$pp_num = $this->input->post('txtPpBppbg');
		$add_by = $this->session->user;
		$add_by_date = date("Y-m-d");
		$own_date = $this->input->post('dpDigunakan');

		$query = $this->M_dataassets->checkTagNum($tag_num);
		if ($query[0]['count'] > 0) {
			echo"
				<script>
				alert('Tag Number Sudah Dipakai');
				window.location.assign('".base_url()."FixedAsset/DataAssets/assetBon');
				</script>
			";
			// redirect('FixedAsset/DataAssets/assetBon');
		} else {
			$sql=$this->M_dataassets->setTagNumber($tag_num, $cost_cen, $umur_tek, $location, $item_code, $specification, $description, $pp_num, $add_by, $add_by_date, $own_date);
			if($sql){
				$this->M_dataassets->deleteWithoutTag($id_assets);
				echo"
					<script>
					alert('Input Berhasil');
					window.location.assign('".base_url()."FixedAsset/DataAssets');
					</script>
				";
				// redirect('FixedAsset/DataAssets');
			}else{
				echo"
					<script>
					alert('Input Gagal');
					window.location.assign('".base_url()."FixedAsset/DataAssets/assetBon');
					</script>
				";
				// redirect('FixedAsset/DataAssets/assetBon');
			}
		}

		echo $tag_num.'<br>'.$location.'<br>'.$item_code.'<br>'.$specification.'<br>'.$description.'<br>'.$pp_num.'<br>'.$add_by.'<br>'.$add_by_date.'<br>'.$own_date;

	}

	public function DeleteANT($astId){
		$khueri = $this->M_dataassets->deleteWithoutTag($astId);
		return $khueri;
	}

	// public function testChamber(){

	// 	$tag_num = $this->input->post('txtTag');
	// 	$query = $this->M_dataassets->checkTagNum($tag_num);
	// 	echo $query[0]['count'];

	// }

}