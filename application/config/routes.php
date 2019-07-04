<?php
defined('BASEPATH') OR exit('No direct script aCustomerRelationshipess allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method

Link	[Modul]/[Action]/[Variable]
	- Modul : Singkatan Resmi jika tidak ada ditulis lengkap, cth : ASCP, MRP, MPS, Purchasing
	- Setiap Kata Diawali Dengan Huruf Besar dan disambung tanpa spasi, cth: OrderManagement,
	-Variable di enkripsi

*/
$route['default_controller'] = 'C_Index';
//$route['(:any)'] = 'pages/view/$1';
//$route['default_controller'] = 'pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//-------------------------------------CustomerRelationship----------------------------------------------------
$route['CustomerRelationship'] = 'CustomerRelationship/C_CustomerRelationship/index';
//CustomerRelationship/MainMenu/
$route['CustomerRelationship/Customer'] = 'CustomerRelationship/MainMenu/C_Customer/index';
$route['CustomerRelationship/Customer/(:any)'] = 'CustomerRelationship/MainMenu/C_Customer/$1';
$route['CustomerRelationship/Customer/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_Customer/$1/$2';
$route['CustomerRelationship/Ajax/Customer'] = 'CustomerRelationship/MainMenu/C_Customer/ajaxSearching';
$route['CustomerRelationship/CustomerDriver'] = 'CustomerRelationship/MainMenu/C_CustomerDriver/index';
$route['CustomerRelationship/CustomerDriver/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerDriver/$1';
$route['CustomerRelationship/CustomerDriver/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerDriver/$1/$2';
$route['CustomerRelationship/Ownership'] = 'CustomerRelationship/MainMenu/C_Ownership/index';
$route['CustomerRelationship/Ownership/(:any)'] = 'CustomerRelationship/MainMenu/C_Ownership/$1';
$route['CustomerRelationship/Ownership/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_Ownership/$1/$2';
$route['CustomerRelationship/Ownership/ChangeOwnership/ToCustomerSearch'] = 'CustomerRelationship/C_Ownership/searchToCustomer';
$route['CustomerRelationship/CustomerGroup'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/index';
$route['CustomerRelationship/CustomerGroup/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/$1';
$route['CustomerRelationship/CustomerGroup/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/$1/$2';
$route['CustomerRelationship/CustomerGroup/(:any)/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/$1/$2/$3';
$route['CustomerRelationship/Ajax/CustomerGroup'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/ajaxSearching';
$route['CustomerRelationship/ServiceProducts'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/index';
$route['CustomerRelationship/ServiceProducts/(:any)'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/$1';
$route['CustomerRelationship/ServiceProducts/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/$1/$2';
//CustomerRelationship/Setting/
$route['CustomerRelationship/Setting/ApprovalClaim'] = 'CustomerRelationship/Setting/C_ApprovalClaim/index';
$route['CustomerRelationship/Setting/ApprovalClaim/(:any)'] = 'CustomerRelationship/Setting/C_ApprovalClaim/$1';
$route['CustomerRelationship/Setting/ApprovalClaim/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_ApprovalClaim/$1/$2';
$route['CustomerRelationship/Setting/AdditionalActivity'] = 'CustomerRelationship/Setting/C_AdditionalActivity/index';
$route['CustomerRelationship/Setting/AdditionalActivity/(:any)'] = 'CustomerRelationship/Setting/C_AdditionalActivity/$1';
$route['CustomerRelationship/Setting/AdditionalActivity/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_AdditionalActivity/$1/$2';
$route['CustomerRelationship/Setting/CustomerCategory'] = 'CustomerRelationship/Setting/C_CustomerCategory/index';
$route['CustomerRelationship/Setting/CustomerCategory/(:any)'] = 'CustomerRelationship/Setting/C_CustomerCategory/$1';
$route['CustomerRelationship/Setting/CustomerCategory/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_CustomerCategory/$1/$2';
$route['CustomerRelationship/Setting/BuyingType'] = 'CustomerRelationship/Setting/C_BuyingType/index';
$route['CustomerRelationship/Setting/BuyingType/(:any)'] = 'CustomerRelationship/Setting/C_BuyingType/$1';
$route['CustomerRelationship/Setting/BuyingType/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_BuyingType/$1/$2';
$route['CustomerRelationship/Setting/Checklist'] = 'CustomerRelationship/Setting/C_Checklist/index';
$route['CustomerRelationship/Setting/Checklist/(:any)'] = 'CustomerRelationship/Setting/C_Checklist/$1';
$route['CustomerRelationship/Setting/Checklist/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_Checklist/$1/$2';
$route['CustomerRelationship/Setting/CustomerAdditional'] = 'CustomerRelationship/Setting/C_CustomerAdditional/index';
$route['CustomerRelationship/Setting/CustomerAdditional/(:any)'] = 'CustomerRelationship/Setting/C_CustomerAdditional/$1';
$route['CustomerRelationship/Setting/CustomerAdditional/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_CustomerAdditional/$1/$2';
$route['CustomerRelationship/Setting/ServiceProblem'] = 'CustomerRelationship/Setting/C_ServiceProblem/index';
$route['CustomerRelationship/Setting/ServiceProblem/(:any)'] = 'CustomerRelationship/Setting/C_ServiceProblem/$1';
$route['CustomerRelationship/Setting/ServiceProblem/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_ServiceProblem/$1/$2';
//CustomerRelationship/Report/
$route['CustomerRelationship/Report/(:any)'] = 'CustomerRelationship/Report/C_Report/$1';
$route['CustomerRelationship/Report/(:any)/(:any)'] = 'CustomerRelationship/Report/C_Report/$1/$2';
$route['CustomerRelationship/Report/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Report/C_Report/$1/$2/$3';
//CustomerRelationship/Additional
$route['CustomerRelationship/Search/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1';
$route['CustomerRelationship/Search/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1/$2';
$route['CustomerRelationship/Search/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1/$2/$3';
$route['CustomerRelationship/Search/(:any)/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1/$2/$3/$4';
$route['ajax/(:any)'] = 'CustomerRelationship/Additional/C_Ajax/$1';
$route['ajax/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Ajax/$1/$2';
$route['ajax/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Ajax/$1/$2/$3';
//-------------------------------------FixedAsset----------------------------------------------------
$route['FixedAsset'] = 'FixedAsset/C_FixedAsset/index';
//FixedAsset/MainMenu
$route['FixedAsset/DataAssets'] = 'FixedAsset/MainMenu/C_DataAssets/index';
$route['FixedAsset/DataAssets/(:any)'] = 'FixedAsset/MainMenu/C_DataAssets/$1';
$route['FixedAsset/DataAssets/(:any)/(:any)'] = 'FixedAsset/MainMenu/C_DataAssets/$1/$2';
$route['FixedAsset/DataAssets/(:any)/(:any)/(:any)'] = 'FixedAsset/MainMenu/C_DataAssets/$1/$2/$3';
$route['FixedAsset/BonAssets'] = 'FixedAsset/MainMenu/C_BonAssets/index';
$route['FixedAsset/BonAssets/(:any)'] = 'FixedAsset/MainMenu/C_BonAssets/$1';
//-------------------------------------InventoryManagement----------------------------------------------------
$route['InventoryManagement'] = 'InventoryManagement/C_InventoryManagement/index';
//InventoryManagement/MainMenu
$route['InventoryManagement/DeliveryRequest'] = 'InventoryManagement/MainMenu/C_DeliveryRequest/index';
$route['InventoryManagement/DeliveryRequest/(:any)'] = 'InventoryManagement/MainMenu/C_DeliveryRequest/$1';
$route['InventoryManagement/DeliveryRequest/(:any)/(:any)'] = 'InventoryManagement/MainMenu/C_DeliveryRequest/$1/$2';
$route['InventoryManagement/DeliveryRequest/(:any)/(:any)/(:any)'] = 'InventoryManagement/MainMenu/C_DeliveryRequest/$1/$2/$3';
$route['InventoryManagement/DeliveryProcess'] = 'InventoryManagement/MainMenu/C_DeliveryProcess/index';
$route['InventoryManagement/DeliveryProcess/(:any)'] = 'InventoryManagement/MainMenu/C_DeliveryProcess/$1';
$route['InventoryManagement/DeliveryProcess/(:any)/(:any)'] = 'InventoryManagement/MainMenu/C_DeliveryProcess/$1/$2';
$route['InventoryManagement/DeliveryProcess/(:any)/(:any)/(:any)'] = 'InventoryManagement/MainMenu/C_DeliveryProcess/$1/$2/$3';
$route['InventoryManagement/DeliveryRequestApproval'] = 'InventoryManagement/Setting/C_DeliveryRequestApproval/index';
$route['InventoryManagement/DeliveryRequestApproval/(:any)'] = 'InventoryManagement/Setting/C_DeliveryRequestApproval/$1';
$route['InventoryManagement/DeliveryRequestApproval/(:any)/(:any)'] = 'InventoryManagement/Setting/C_DeliveryRequestApproval/$1/$2';
$route['InventoryManagement/DeliveryRequestApproval/(:any)/(:any)/(:any)'] = 'InventoryManagement/Setting/C_DeliveryRequestApproval/$1/$2/$3';
//CustomerRelationship/Report/
$route['InventoryManagement/Report/(:any)'] = 'InventoryManagement/Report/C_Report/$1';
$route['InventoryManagement/Report/(:any)/(:any)'] = 'InventoryManagement/Report/C_Report/$1/$2';
$route['InventoryManagement/Report/(:any)/(:any)/(:any)'] = 'InventoryManagement/Report/C_Report/$1/$2/$3';
//InventoryManagement/Additional
$route['InventoryManagement/Search/(:any)'] = 'InventoryManagement/Additional/C_Search/$1';
$route['InventoryManagement/Search/(:any)/(:any)'] = 'InventoryManagement/Additional/C_Search/$1/$2';
$route['InventoryManagement/Search/(:any)/(:any)/(:any)'] = 'InventoryManagement/Additional/C_Search/$1/$2/$3';
$route['InventoryManagement/Search/(:any)/(:any)/(:any)/(:any)'] = 'InventoryManagement/Additional/C_Search/$1/$2/$3/$4';
$route['InventoryManagement/ajax/(:any)'] = 'InventoryManagement/Additional/C_Ajax/$1';
$route['InventoryManagement/ajax/(:any)/(:any)'] = 'InventoryManagement/Additional/C_Ajax/$1/$2';
$route['InventoryManagement/ajax/(:any)/(:any)/(:any)'] = 'InventoryManagement/Additional/C_Ajax/$1/$2/$3';
//-------------------------------------SystemAdministration----------------------------------------------------
$route['SystemAdministration'] = 'SystemAdministration/C_SystemAdministration/index';
//SystemAdministration/MainMenu
$route['SystemAdministration/User'] = 'SystemAdministration/MainMenu/C_User/index';
$route['SystemAdministration/User/(:any)'] = 'SystemAdministration/MainMenu/C_User/$1';
$route['SystemAdministration/User/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_User/$1/$2';
$route['SystemAdministration/Menu'] = 'SystemAdministration/MainMenu/C_Menu/index';
$route['SystemAdministration/Menu/(:any)'] = 'SystemAdministration/MainMenu/C_Menu/$1';
$route['SystemAdministration/Menu/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_Menu/$1/$2';
$route['SystemAdministration/MenuGroup'] = 'SystemAdministration/MainMenu/C_MenuGroup/index';
$route['SystemAdministration/MenuGroup/(:any)'] = 'SystemAdministration/MainMenu/C_MenuGroup/$1';
$route['SystemAdministration/MenuGroup/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_MenuGroup/$1/$2';
$route['SystemAdministration/MenuGroup/(:any)/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_MenuGroup/$1/$2/$3';
$route['SystemAdministration/Report'] = 'SystemAdministration/MainMenu/C_Report/index';
$route['SystemAdministration/Report/(:any)'] = 'SystemAdministration/MainMenu/C_Report/$1';
$route['SystemAdministration/Report/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_Report/$1/$2';
$route['SystemAdministration/ReportGroup'] = 'SystemAdministration/MainMenu/C_ReportGroup/index';
$route['SystemAdministration/ReportGroup/(:any)'] = 'SystemAdministration/MainMenu/C_ReportGroup/$1';
$route['SystemAdministration/ReportGroup/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_ReportGroup/$1/$2';
$route['SystemAdministration/Responsibility'] = 'SystemAdministration/MainMenu/C_Responsibility/index';
$route['SystemAdministration/Responsibility/(:any)'] = 'SystemAdministration/MainMenu/C_Responsibility/$1';
$route['SystemAdministration/Responsibility/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_Responsibility/$1/$2';
$route['SystemAdministration/Module'] = 'SystemAdministration/MainMenu/C_Module/index';
$route['SystemAdministration/Module/(:any)'] = 'SystemAdministration/MainMenu/C_Module/$1';
$route['SystemAdministration/Module/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_Module/$1/$2';

//sales monitoring routes
$route['SalesMonitoring'] = 'SalesMonitoring/C_SalesMonitoring/index';

//sales monitoring pricelist index
$route['SalesMonitoring/pricelist'] 						= 'SalesMonitoring/C_pricelist/index';
$route['SalesMonitoring/pricelist/Create'] 					= 'SalesMonitoring/C_pricelist/createPricelist';
$route['SalesMonitoring/pricelist/Created'] 				= 'SalesMonitoring/C_pricelist/create';
$route['SalesMonitoring/pricelist/Update/(:any)'] 			= 'SalesMonitoring/C_pricelist/updatePricelist/$1';
$route['SalesMonitoring/pricelist/updated'] 				= 'SalesMonitoring/C_pricelist/update';
$route['SalesMonitoring/pricelist/Delete/(:any)'] 			= 'SalesMonitoring/C_pricelist/delete/$1';
$route['SalesMonitoring/pricelist/Download/csv'] 			= 'SalesMonitoring/C_pricelist/downloadcsv';
$route['SalesMonitoring/pricelist/Download/xml'] 			= 'SalesMonitoring/C_pricelist/downloadxml';
$route['SalesMonitoring/pricelist/Download/pdf'] 			= 'SalesMonitoring/C_pricelist/downloadpdf';
$route['SalesMonitoring/pricelist/Filter'] 					= 'SalesMonitoring/C_pricelist/profilter';

//SALES OMSET
$route['SalesMonitoring/salesomset'] 						= 'SalesMonitoring/C_salesomset/index';
$route['SalesMonitoring/salesomset/Download/csv'] 			= 'SalesMonitoring/C_salesomset/downloadcsv';
$route['SalesMonitoring/salesomset/Download/xml'] 			= 'SalesMonitoring/C_salesomset/downloadxml';
$route['SalesMonitoring/salesomset/Download/pdf'] 			= 'SalesMonitoring/C_salesomset/downloadpdf';
$route['SalesMonitoring/salesomset/Filter'] 				= 'SalesMonitoring/C_salesomset/profilter';
$route['SalesMonitoring/salesomset/Filter/Download/pdf'] 	= 'SalesMonitoring/C_salesomset/downloadpdffilter';

//SALES TARGET
$route['SalesMonitoring/salestarget']						= 'SalesMonitoring/C_salestarget/index';
$route['SalesMonitoring/salestarget/Create'] 				= 'SalesMonitoring/C_salestarget/createSalestarget';
$route['SalesMonitoring/salestarget/Created'] 				= 'SalesMonitoring/C_salestarget/create';
$route['SalesMonitoring/salestarget/delete/(:any)'] 		= 'SalesMonitoring/C_salestarget/delete/$1';
$route['SalesMonitoring/salestarget/update/(:any)'] 		= 'SalesMonitoring/C_salestarget/updateSalestarget/$1';
$route['SalesMonitoring/salestarget/updated'] 				= 'SalesMonitoring/C_salestarget/update';
$route['SalesMonitoring/salestarget/Download/csv'] 			= 'SalesMonitoring/C_salestarget/downloadcsv';
$route['SalesMonitoring/salestarget/Download/xml'] 			= 'SalesMonitoring/C_salestarget/downloadxml';
$route['SalesMonitoring/salestarget/Download/pdf'] 			= 'SalesMonitoring/C_salestarget/downloadpdf';
$route['SalesMonitoring/salestarget/Filter'] 				= 'SalesMonitoring/C_salestarget/profilter';
$route['SalesMonitoring/salestarget/Filter/Download/pdf'] 	= 'SalesMonitoring/C_salestarget/downloadpdffilter';

//-------------------------------------Morning Greeting----------------------------------------------------
//DASHBOARD
$route['MorningGreeting'] 									= 'MorningGreeting/C_MorningGreeting/index';
$route['MorningGreeting/dashboard'] 						= 'MorningGreeting/C_MorningGreeting/index';

// route pada tabel config
$route['MorningGreeting/configuration'] 					= 'MorningGreeting/configuration/C_config/index';
$route['MorningGreeting/configuration/edit/(:any)'] 		= 'MorningGreeting/configuration/C_config/editConfig/$1';
$route['MorningGreeting/configuration/save'] 				= 'MorningGreeting/configuration/C_config/saveConfig';

//route pada tabel branch
$route['MorningGreeting/extention'] 						= 'MorningGreeting/extention/C_extention/index';
$route['MorningGreeting/extention/new'] 					= 'MorningGreeting/extention/C_extention/newBranch';
$route['MorningGreeting/extention/new/save'] 				= 'MorningGreeting/extention/C_extention/newBranchSave';
$route['MorningGreeting/extention/edit/(:any)'] 			= 'MorningGreeting/extention/C_extention/editBranch/$1';
$route['MorningGreeting/extention/editsave'] 				= 'MorningGreeting/extention/C_extention/saveEditBranch';
$route['MorningGreeting/extention/delete/(:any)'] 			= 'MorningGreeting/extention/C_extention/deleteBranch/$1';

//route pada tabel schedule
$route['MorningGreeting/schedule'] 							= 'MorningGreeting/schedule/C_schedule/index';
$route['MorningGreeting/schedule/new'] 						= 'MorningGreeting/schedule/C_schedule/newSchedule';
$route['MorningGreeting/schedule/new/save'] 				= 'MorningGreeting/schedule/C_schedule/newScheduleSave';
$route['MorningGreeting/schedule/edit/(:any)'] 				= 'MorningGreeting/schedule/C_schedule/editSchedule/$1';
$route['MorningGreeting/schedule/editsave'] 				= 'MorningGreeting/schedule/C_schedule/saveEditSchedule/$1';
$route['MorningGreeting/schedule/delete/(:any)'] 			= 'MorningGreeting/schedule/C_schedule/deleteSchedule/$1';

//route pada tabel relation
$route['MorningGreeting/relation']							= 'MorningGreeting/relation/C_relation/index';
$route['MorningGreeting/relation/showcn']					= 'MorningGreeting/relation/C_relation/showcn';
$route['MorningGreeting/relation/new']						= 'MorningGreeting/relation/C_relation/newRelation';
$route['MorningGreeting/relation/new/save']					= 'MorningGreeting/relation/C_relation/newRelationSave';
$route['MorningGreeting/relation/edit/(:any)']				= 'MorningGreeting/relation/C_relation/editRelation/$1';
$route['MorningGreeting/relation/editsave']					= 'MorningGreeting/relation/C_relation/saveEditRelation/$1';
$route['MorningGreeting/relation/delete/(:any)']			= 'MorningGreeting/relation/C_relation/deleteRelation/$1';

//Route pada tabel cdr
$route['MorningGreeting/cdr']								= 'MorningGreeting/cdr/C_cdr/index';
//-------------------------------------Morning Greeting----------------------------------------------------

//-------------------------------------Outstation.begin----------------------------------------------------

$route['Outstation'] = 'general-afair/outstation/C_Outstation/index';
$route['Outstation/select-employee'] = 'general-afair/outstation/C_Outstation/select_employee';

//--------Outstation Time------------
$route['Outstation/time'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/index';
$route['Outstation/time/deleted-time'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/deleted_time';
$route['Outstation/time/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/new_time';
$route['Outstation/time/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/save_time';
$route['Outstation/time/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/edit_time/$1';
$route['Outstation/time/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/update_time';
$route['Outstation/time/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/check_data_time';
$route['Outstation/time/delete-temporary/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/delete_temporary/$1';
$route['Outstation/time/delete-permanently/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationTime/delete_permanently/$1';

//--------Outstation USH Group------------
$route['Outstation/group-ush'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/index';
$route['Outstation/group-ush/deleted-group-ush'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/deleted_group_ush';
$route['Outstation/group-ush/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/new_group_ush';
$route['Outstation/group-ush/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/save_group_ush';
$route['Outstation/group-ush/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/edit_group_ush/$1';
$route['Outstation/group-ush/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/update_group_ush';
$route['Outstation/group-ush/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/check_data_group_ush';
$route['Outstation/group-ush/delete-temporary/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/delete_temporary/$1';
$route['Outstation/group-ush/delete-permanently/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationGroupUSH/delete_permanently/$1';

//--------Outstation Area------------
$route['Outstation/area'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/index';
$route['Outstation/area/deleted-area'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/deleted_area';
$route['Outstation/area/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/new_area';
$route['Outstation/area/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/save_area';
$route['Outstation/area/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/edit_area/$1';
$route['Outstation/area/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/update_area';
$route['Outstation/area/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/check_data_area';
$route['Outstation/area/delete-temporary/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/delete_temporary/$1';
$route['Outstation/area/delete-permanently/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationArea/delete_permanently/$1';

//--------Outstation City Type------------
$route['Outstation/city-type'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/index';
$route['Outstation/city-type/deleted-city-type'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/deleted_city_type';
$route['Outstation/city-type/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/new_city_type';
$route['Outstation/city-type/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/save_city_type';
$route['Outstation/city-type/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/edit_city_type/$1';
$route['Outstation/city-type/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/update_city_type';
$route['Outstation/city-type/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/check_data_city_type';
$route['Outstation/city-type/delete-temporary/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/delete_temporary/$1';
$route['Outstation/city-type/delete-permanently/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationCityType/delete_permanently/$1';

//--------Outstation Position------------
$route['Outstation/position'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/index';
$route['Outstation/position/deleted-position'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/deleted_position';
$route['Outstation/position/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/new_position';
$route['Outstation/position/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/save_position';
$route['Outstation/position/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/edit_position/$1';
$route['Outstation/position/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/update_position';
$route['Outstation/position/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/check_data_position';
$route['Outstation/position/delete-temporary/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/delete_temporary/$1';
$route['Outstation/position/delete-permanently/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationPosition/delete_permanently/$1';

//--------Outstation Employee Position------------
$route['Outstation/employee-position'] = 'general-afair/outstation/OutstationSetting/C_OutstationEmployeePosition/index';
$route['Outstation/employee-position/show-employee-position'] = 'general-afair/outstation/OutstationSetting/C_OutstationEmployeePosition/show_employee_server_side';
$route['Outstation/employee-position/get-employee-data'] = 'general-afair/outstation/OutstationSetting/C_OutstationEmployeePosition/get_employee_ajax';
$route['Outstation/employee-position/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationEmployeePosition/edit_employee_position/$1';
$route['Outstation/employee-position/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationEmployeePosition/update_employee_position';
//--------Outstation Component------------
$route['Outstation/component'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/index';
$route['Outstation/component/deleted-component'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/deleted_component';
$route['Outstation/component/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/new_component';
$route['Outstation/component/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/save_component';
$route['Outstation/component/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/edit_component/$1';
$route['Outstation/component/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/update_component';
$route['Outstation/component/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/check_data_component';
$route['Outstation/component/delete-temporary/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/delete_temporary/$1';
$route['Outstation/component/delete-permanently/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationComponent/delete_permanently/$1';

//--------Outstation Accomodation Allowance------------
$route['Outstation/accomodation-allowance'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/index';
$route['Outstation/accomodation-allowance/show-accomodation-allowance'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/show_accomodation_allowance';
$route['Outstation/accomodation-allowance/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/new_AccomodationAllowance';
$route['Outstation/accomodation-allowance/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/save_AccomodationAllowance';
$route['Outstation/accomodation-allowance/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/edit_AccomodationAllowance/$1';
$route['Outstation/accomodation-allowance/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/update_AccomodationAllowance';
$route['Outstation/accomodation-allowance/delete/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationAccomodationAllowance/delete_permanently/$1';

//--------Outstation Meal Allowance------------
$route['Outstation/meal-allowance'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/index';
$route['Outstation/meal-allowance/show-meal-allowance'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/show_meal_allowance';
$route['Outstation/meal-allowance/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/new_MealAllowance';
$route['Outstation/meal-allowance/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/save_MealAllowance';
$route['Outstation/meal-allowance/edit/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/edit_MealAllowance/$1';
$route['Outstation/meal-allowance/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/update_MealAllowance';
$route['Outstation/meal-allowance/delete/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationMealAllowance/delete_permanently/$1';

//--------Outstation USH------------
$route['Outstation/ush'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/index';
$route['Outstation/ush/show-ush'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/show_ush';
$route['Outstation/ush/deleted-ush'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/deleted_ush';
$route['Outstation/ush/new'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/new_ush';
$route['Outstation/ush/new/save'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/save_ush';
$route['Outstation/ush/edit/(:any)/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/edit_ush/$1/$2';
$route['Outstation/ush/update'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/update_ush';
$route['Outstation/ush/delete'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/check_data_ush';
$route['Outstation/ush/delete-temporary/(:any)/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/delete_temporary/$1/$2';
$route['Outstation/ush/delete-permanently/(:any)/(:any)'] = 'general-afair/outstation/OutstationSetting/C_OutstationUSH/delete_permanently/$1/$2';

//--------Outstation Simulation------------
$route['Outstation/simulation'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/index';
$route['Outstation/simulation/print/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/print_simulation/$1';
$route['Outstation/simulation/new'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/new_Simulation';
$route['Outstation/simulation/new/process'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/load_process';
$route['Outstation/simulation/new/save'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/save_Simulation';
$route['Outstation/simulation/edit/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/edit_Simulation/$1';
$route['Outstation/simulation/update'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/update_Simulation';
$route['Outstation/simulation/delete/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationSimulation/delete_simulation/$1';

//--------Outstation Realization------------
$route['Outstation/realization'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/index';
$route['Outstation/realization/download/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/DownloadFile/$1';
$route['Outstation/realization/upload'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/UploadFile';
$route['Outstation/realization/print/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/print_realization/$1';
$route['Outstation/realization/new'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/new_Realization';
$route['Outstation/realization/new/process'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/load_process';
$route['Outstation/realization/new/save'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/save_Realization';
$route['Outstation/realization/edit/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/edit_Realization/$1';
$route['Outstation/realization/update'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/update_Realization';
$route['Outstation/realization/delete/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/delete_realization/$1';
$route['Outstation/realization/mail/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/new_realization_mail/$1';
$route['Outstation/realization/mail/send'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/send_realization_mail';

//-------------------------------------Outstation.end----------------------------------------------------

//------------------------------------Rekap TIMS.begin---------------------------------------------------
$route['RekapTIMSPromosiPekerja'] = 'er/RekapTIMS/C_Rekap/index';
$route['RekapTIMSPromosiPekerja/RekapTIMS'] = 'er/RekapTIMS/C_Rekap/rekapMenu';
$route['RekapTIMSPromosiPekerja/RekapTIMS/select-section'] = 'er/RekapTIMS/C_Rekap/select_section';
$route['RekapTIMSPromosiPekerja/RekapTIMS/show-data'] = 'er/RekapTIMS/C_Rekap/showData';
$route['RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-detail'] = 'er/RekapTIMS/C_Rekap/ExportRekapDetail';
$route['RekapTIMSPromosiPekerja/RekapTIMS/rekap-bulanan'] = 'er/RekapTIMS/C_Rekap/searchMonth';
$route['RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-bulanan'] = 'er/RekapTIMS/C_Rekap/ExportRekapMonthly';

$route['RekapTIMSPromosiPekerja/RekapPerPekerja'] = 'er/RekapTIMS/C_RekapPerPekerja/index';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/show-data'] = 'er/RekapTIMS/C_RekapPerPekerja/show_data_per_pekerja';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-detail'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportRekapDetail';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-detail-pdf'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportRekapDetailPDF';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/rekap-bulanan'] = 'er/RekapTIMS/C_RekapPerPekerja/searchMonth';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-bulanan'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportRekapMonthly';
$route['RekapTIMSPromosiPekerja/RekapTIMS/employee/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_RekapPerPekerja/searchEmployee/$1/$2/$3';
$route['RekapTIMSPromosiPekerja/RekapTIMS/export-employee/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportEmployee/$1/$2/$3';

$route['RekapTIMSPromosiPekerja/GetNoInduk'] = 'er/RekapTIMS/C_RekapPerPekerja/GetNoInduk';

	//	Sinkronisasi Konversi Presensi
	//	{
			$route['RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi']					=	'er/RekapTIMS/C_SinkronisasiKonversiPresensi';
			$route['RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/(:any)']			=	'er/RekapTIMS/C_SinkronisasiKonversiPresensi/$1';
			$route['RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/(:any)/(:any)']	=	'er/RekapTIMS/C_SinkronisasiKonversiPresensi/$1/$2';

	//	}

	// 	Rekap Absensi Pekerja
	//	{
			$route['RekapTIMSPromosiPekerja/RekapAbsensiPekerja']			=	'er/RekapTIMS/C_RekapAbsensi';
			$route['RekapTIMSPromosiPekerja/RekapAbsensiPekerja/(:any)']	=	'er/RekapTIMS/C_RekapAbsensi/$1';
	//	}

	// 	Rekap Jam Kerja
	// 	{
			$route['RekapTIMSPromosiPekerja/RekapJamKerja']			=	'er/RekapTIMS/C_RekapJamKerja';
			$route['RekapTIMSPromosiPekerja/RekapJamKerja/(:any)']	=	'er/RekapTIMS/C_RekapJamKerja/$1';
	//	}

	//	Rekap Riwayat Mutasi
	//	{
			$route['RekapTIMSPromosiPekerja/RiwayatMutasi']			=	'er/RekapTIMS/C_RekapRiwayatMutasi';
			$route['RekapTIMSPromosiPekerja/RiwayatMutasi/(:any)']	=	'er/RekapTIMS/C_RekapRiwayatMutasi/$1';
	//	}

	// 	Rekap Absensi Manual
	//	{
			$route['RekapTIMSPromosiPekerja/RekapAbsensiManual']		=	'er/RekapTIMS/C_RekapAbsensiManual';
			$route['RekapTIMSPromosiPekerja/RekapAbsensiManual/(:any)']	=	'er/RekapTIMS/C_RekapAbsensiManual/$1';

	//	}

	// 	Rekap Data Presensi - TIM
	// 	{
			$route['RekapTIMSPromosiPekerja/RekapDataPresensiTim'] 			=	'er/RekapTIMS/C_RekapDataPresensiTIM';
			$route['RekapTIMSPromosiPekerja/RekapDataPresensiTim/(:any)'] 	=	'er/RekapTIMS/C_RekapDataPresensiTIM/$1';
	//	}
	// Rekap Bobot TIM
			$route['RekapTIMSPromosiPekerja/RekapBobot']  =  'er/RekapTIMS/C_RekapBobot';
			$route['RekapTIMSPromosiPekerja/RekapBobot/(:any)']  =  'er/RekapTIMS/C_RekapBobot/$1';

	//Tims 2 tahun
			$route['RekapTIMSPromosiPekerja/Tims2tahun'] = 'er/RekapTIMS/C_Tims2tahun';

	//OverTime
			$route['RekapTIMSPromosiPekerja/Overtime'] = 'er/RekapTIMS/C_Overtime';
			$route['RekapTIMSPromosiPekerja/Overtime/(:any)'] = 'er/RekapTIMS/C_Overtime/$1';
			$route['RekapTIMSPromosiPekerja/Overtime/(:any)/(:any)'] = 'er/RekapTIMS/C_Overtime/$1/$2';
//------------------------------------Rekap TIMS.end---------------------------------------------------
$route['StockControl'] = 'StockControl/C_StockControl/index';

$route['StockControl/item'] = 'StockControl/C_Item/index';
$route['StockControl/item/(:any)'] = 'StockControl/C_Item/$1';
$route['StockControl/item/(:any)/(:any)'] = 'StockControl/C_Item/$1/$2';

$route['StockControl/plan-production'] = 'StockControl/C_PlanProduction/index';
$route['StockControl/plan-production/(:any)'] = 'StockControl/C_PlanProduction/$1';
$route['StockControl/plan-production/(:any)/(:any)'] = 'StockControl/C_PlanProduction/$1/$2';
$route['StockControl/plan-production/(:any)/(:any)/(:any)'] = 'StockControl/C_PlanProduction/$1/$2/$3';

$route['StockControl/product'] = 'StockControl/C_Product/index';
$route['StockControl/product/(:any)'] = 'StockControl/C_Product/$1';
$route['StockControl/product/(:any)/(:any)'] = 'StockControl/C_Product/$1/$2';

$route['StockControl/submit-stock'] = 'StockControl/C_SubmitStock/index';
$route['StockControl/submit-stock/(:any)'] = 'StockControl/C_SubmitStock/$1';
$route['StockControl/submit-stock/(:any)/(:any)'] = 'StockControl/C_SubmitStock/$1/$2';
$route['StockControl/submit-stock/(:any)/(:any)/(:any)'] = 'StockControl/C_SubmitStock/$1/$2/$3';

$route['StockControl/stock-transaction'] = 'StockControl/C_StockTransaction/index';
$route['StockControl/stock-transaction/(:any)'] = 'StockControl/C_StockTransaction/$1';
$route['StockControl/stock-transaction/(:any)/(:any)'] = 'StockControl/C_StockTransaction/$1/$2';
$route['StockControl/stock-transaction/(:any)/(:any)/(:any)'] = 'StockControl/C_StockTransaction/$1/$2/$3';

$route['StockControl/lapor-kekurangan'] = 'StockControl/C_Lapor/index';
$route['StockControl/lapor-kekurangan/(:any)'] = 'StockControl/C_Lapor/$1';
$route['StockControl/lapor-kekurangan/(:any)/(:any)'] = 'StockControl/C_Lapor/$1/$2';
$route['StockControl/lapor-kekurangan/(:any)/(:any)/(:any)'] = 'StockControl/C_Lapor/$1/$2/$3';

$route['StockControl/stock-control-new'] = 'StockControl/C_StockControlNew/index';
$route['StockControl/stock-control-new/(:any)'] = 'StockControl/C_StockControlNew/$1';

$route['StockControl/stock-opname-pusat'] = 'StockControl/C_StockOpnamePusat/index';
$route['StockControl/stock-opname-pusat/(:any)'] = 'StockControl/C_StockOpnamePusat/$1';
$route['StockControl/stock-opname-pusat/(:any)/(:any)'] = 'StockControl/C_StockOpnamePusat/$1/$2';
$route['StockControl/stock-opname-pusat/autocomplete/(:any)'] = 'StockControl/C_StockOpnamePusat/autocomplete/$1';
$route['StockControl/stock-opname-pusat/autocomplete/(:any)/(:any)'] = 'StockControl/C_StockOpnamePusat/autocomplete/$1/$2';

//----------------------- Keluar Masuk Kendaraan -----------------------------------------------
$route['KeluarMasukKendaraan'] = 'KeluarMasukKendaraan/C_Index';
$route['KeluarMasukKendaraan/(:any)'] = 'KeluarMasukKendaraan/C_Index/$1';
$route['KeluarMasukKendaraan/(:any)/(:any)'] = 'KeluarMasukKendaraan/C_Index/$1/$2';


//------------------------------------Catering Management---------------------------------------------------
$route['CateringManagement'] 						= 'CateringManagement/C_CateringManagement/index';

$route['CateringManagement/Receipt'] 				= 'CateringManagement/C_Receipt/index';
$route['CateringManagement/Receipt/Create'] 		= 'CateringManagement/C_Receipt/create';
$route['CateringManagement/Receipt/Update'] 		= 'CateringManagement/C_Receipt/update';
$route['CateringManagement/Receipt/Add'] 			= 'CateringManagement/C_Receipt/add';
$route['CateringManagement/Receipt/Details/(:any)']	= 'CateringManagement/C_Receipt/details/$1';
$route['CateringManagement/Receipt/Edit/(:any)']	= 'CateringManagement/C_Receipt/edit/$1';
$route['CateringManagement/Receipt/Print/(:any)']	= 'CateringManagement/C_Receipt/printreceipt/$1';
$route['CateringManagement/Receipt/Delete/(:any)']	= 'CateringManagement/C_Receipt/delete/$1';
$route['CateringManagement/Receipt/Checkpph']		= 'CateringManagement/C_Receipt/checkpph';
$route['CateringManagement/Receipt/Checkfine']		= 'CateringManagement/C_Receipt/checkfine';

$route['CateringManagement/List'] 					= 'CateringManagement/C_List/index';
$route['CateringManagement/List/Create'] 			= 'CateringManagement/C_List/create';
$route['CateringManagement/List/Update'] 			= 'CateringManagement/C_List/update';
$route['CateringManagement/List/Add'] 				= 'CateringManagement/C_List/add';
$route['CateringManagement/List/Edit/(:any)']		= 'CateringManagement/C_List/edit/$1';
$route['CateringManagement/List/Delete/(:any)']		= 'CateringManagement/C_List/delete/$1';

$route['CateringManagement/PrintPP'] 				= 'CateringManagement/C_Printpp';
$route['CateringManagement/PrintPP/(:any)'] 		= 'CateringManagement/C_Printpp/$1';
$route['CateringManagement/PrintPP/(:any)/(:any)'] 	= 'CateringManagement/C_Printpp/$1/$2';

//-----------------------------------Catering Management -Setup-----------------------------------------------//
$route['CateringManagement/catering'] 			= 'CateringManagement/Setup/C_Catering/index';
$route['CateringManagement/catering/Create'] 			= 'CateringManagement/Setup/C_Catering/Create';
$route['CateringManagement/catering/Edit/(:any)'] 			= 'CateringManagement/Setup/C_Catering/Edit/$1';
$route['CateringManagement/catering/Delete/(:any)'] 			= 'CateringManagement/Setup/C_Catering/Delete/$1';

$route['CateringManagement/JamDatangShift'] 	= 'CateringManagement/Setup/C_JamDatangShift';
$route['CateringManagement/JamDatangShift/Create'] 	= 'CateringManagement/Setup/C_JamDatangShift/Create';
$route['CateringManagement/JamDatangShift/Edit/(:any)/(:any)'] 	= 'CateringManagement/Setup/C_JamDatangShift/Edit/$1/$2';
$route['CateringManagement/JamDatangShift/Delete/(:any)/(:any)'] 	= 'CateringManagement/Setup/C_JamDatangShift/Delete/$1/$2';

$route['CateringManagement/JamPesananDatang'] 	= 'CateringManagement/Setup/C_JamPesananDatang';
$route['CateringManagement/JamPesananDatang/Create'] 	= 'CateringManagement/Setup/C_JamPesananDatang/Create';
$route['CateringManagement/JamPesananDatang/Edit/(:any)/(:any)'] 	= 'CateringManagement/Setup/C_JamPesananDatang/Edit/$1/$2';
$route['CateringManagement/JamPesananDatang/Delete/(:any)/(:any)'] 	= 'CateringManagement/Setup/C_JamPesananDatang/Delete/$1/$2';

$route['CateringManagement/TmpMakan'] 			= 'CateringManagement/Setup/C_TmpMakan';
$route['CateringManagement/TmpMakan/Create'] 			= 'CateringManagement/Setup/C_TmpMakan/Create';
$route['CateringManagement/TmpMakan/Edit/(:any)/(:any)/(:any)'] 			= 'CateringManagement/Setup/C_TmpMakan/Edit/$1/$2/$3';
$route['CateringManagement/TmpMakan/Delete/(:any)/(:any)'] 			= 'CateringManagement/Setup/C_TmpMakan/Delete/$1/$2';

$route['CateringManagement/LetakTmpMakan'] 		= 'CateringManagement/Setup/C_LetakTmpMakan';
$route['CateringManagement/LetakTmpMakan/Create'] 		= 'CateringManagement/Setup/C_LetakTmpMakan/Create';
$route['CateringManagement/LetakTmpMakan/Edit/(:any)'] 		= 'CateringManagement/Setup/C_LetakTmpMakan/Edit/$1';
$route['CateringManagement/LetakTmpMakan/Delete/(:any)'] 		= 'CateringManagement/Setup/C_LetakTmpMakan/Delete/$1';

$route['CateringManagement/DetailUrutanJdwl'] 	= 'CateringManagement/Setup/C_DetailUrutanJdwl';
$route['CateringManagement/DetailUrutanJdwl/Create'] 	= 'CateringManagement/Setup/C_DetailUrutanJdwl/Create';
$route['CateringManagement/DetailUrutanJdwl/Edit/(:any)/(:any)'] 	= 'CateringManagement/Setup/C_DetailUrutanJdwl/Edit/$1/$2';
$route['CateringManagement/DetailUrutanJdwl/Delete/(:any)/(:any)'] 	= 'CateringManagement/Setup/C_DetailUrutanJdwl/Delete/$1/$2';

//-----------------------------------Catering Management -Penjadwalan-----------------------------------------------//
$route['CateringManagement/PenjadwalanCatering'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering';
$route['CateringManagement/PenjadwalanCatering/Create/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Create/$1/$2';
$route['CateringManagement/PenjadwalanCatering/Edit/(:any)/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Edit/$1/$2/$3';
$route['CateringManagement/PenjadwalanCatering/Delete/(:any)/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Delete/$1/$2/$3';
$route['CateringManagement/PenjadwalanCatering/Read/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Read/$1/$2';
$route['CateringManagement/PenjadwalanCatering/Distribusi/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Distribusi/$1';
$route['CateringManagement/PenjadwalanCatering/Distribusi/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Distribusi/$1/$2';

$route['CateringManagement/PenjadwalanOtomatis'] = 'CateringManagement/Penjadwalan/C_PenjadwalanOtomatis';
$route['CateringManagement/PenjadwalanOtomatis/Proses'] = 'CateringManagement/Penjadwalan/C_PenjadwalanOtomatis/Proses';
$route['CateringManagement/PenjadwalanOtomatis/Finish/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanOtomatis/Finish/$1';

$route['CateringManagement/PengajuanLibur'] = 'CateringManagement/Penjadwalan/C_PengajuanLibur';
$route['CateringManagement/PengajuanLibur/Create/(:any)'] = 'CateringManagement/Penjadwalan/C_PengajuanLibur/Create/$1';
$route['CateringManagement/PengajuanLibur/Create/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PengajuanLibur/Create/$1/$2';
$route['CateringManagement/PengajuanLibur/Read/(:any)'] = 'CateringManagement/Penjadwalan/C_PengajuanLibur/Read/$1';
$route['CateringManagement/PengajuanLibur/Edit/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PengajuanLibur/Edit/$1/$2';
$route['CateringManagement/PengajuanLibur/Delete/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PengajuanLibur/Delete/$1/$2';

$route['CateringManagement/PenjadwalanCatering'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering';
$route['CateringManagement/PenjadwalanCatering/Create/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Create/$1/$2';
$route['CateringManagement/PenjadwalanCatering/Edit/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Edit/$1/$2';
$route['CateringManagement/PenjadwalanCatering/Delete/(:any)/(:any)'] = 'CateringManagement/Penjadwalan/C_PenjadwalanCatering/Delete/$1/$2';
//------------------------------------CateringManagement - Puasa------------------------------------------------------------//
$route['CateringManagement/Puasa/Transfer'] = 'CateringManagement/Puasa/C_TransferPuasa';
$route['CateringManagement/Puasa/Transfer/Transfer'] = 'CateringManagement/Puasa/C_TransferPuasa/Transfer';
$route['CateringManagement/Puasa/Transfer/Batal'] = 'CateringManagement/Puasa/C_TransferPuasa/Batal';

$route['CateringManagement/Puasa/Pengurangan'] = 'CateringManagement/Puasa/C_PenguranganPuasa';
$route['CateringManagement/Puasa/Pengurangan/Read'] = 'CateringManagement/Puasa/C_PenguranganPuasa/Read';
$route['CateringManagement/Puasa/Pengurangan/Read/(:any)'] = 'CateringManagement/Puasa/C_PenguranganPuasa/Read/$1';

//------------------------------------CateringManagement - Cetak------------------------------------------------------------//
$route['CateringManagement/Cetak/JadwalLayanan'] = 'CateringManagement/Cetak/C_JadwalLayanan';
$route['CateringManagement/Cetak/JadwalLayanan/Read'] = 'CateringManagement/Cetak/C_JadwalLayanan/Read';
$route['CateringManagement/Cetak/JadwalLayanan/Cetak'] = 'CateringManagement/Cetak/C_JadwalLayanan/Cetak';

$route['CateringManagement/Cetak/JadwalPengiriman'] = 'CateringManagement/Cetak/C_JadwalPengiriman';
$route['CateringManagement/Cetak/JadwalPengiriman/Read'] = 'CateringManagement/Cetak/C_JadwalPengiriman/Read';
$route['CateringManagement/Cetak/JadwalPengiriman/Cetak'] = 'CateringManagement/Cetak/C_JadwalPengiriman/Cetak';
$route['CateringManagement/Cetak/JadwalPengiriman/Save'] = 'CateringManagement/Cetak/C_JadwalPengiriman/Save';

//------------------------------------CateringManagement - Extra----------------------------------------------------------//
$route['CateringManagement/Extra/LihatAbsen'] = 'CateringManagement/Extra/C_RekapAbsen';
$route['CateringManagement/Extra/LihatAbsen/(:any)'] = 'CateringManagement/Extra/C_RekapAbsen/$1';
$route['CateringManagement/Extra/LihatAbsen/(:any)/(:any)'] = 'CateringManagement/Extra/C_RekapAbsen/$1/$2';

$route['CateringManagement/Extra/EditTempatMakan'] = 'CateringManagement/Extra/C_EditTempatMakan';
$route['CateringManagement/Extra/EditTempatMakan/(:any)'] = 'CateringManagement/Extra/C_EditTempatMakan/$1';
$route['CateringManagement/Extra/EditTempatMakan/(:any)/(:any)'] = 'CateringManagement/Extra/C_EditTempatMakan/$1/$2';

$route['CateringManagement/Extra/PesananManual'] = 'CateringManagement/Extra/C_PesananManual';
$route['CateringManagement/Extra/PesananManual/(:any)'] = 'CateringManagement/Extra/C_PesananManual/$1';
$route['CateringManagement/Extra/PesananManual/(:any)/(:any)'] = 'CateringManagement/Extra/C_PesananManual/$1/$2';

//------------------------------------CateringManagement - Pesanan----------------------------------------------------------//
$route['CateringManagement/DataPesanan'] = 'CateringManagement/Pesanan/C_Pesanan';
$route['CateringManagement/DataPesanan/(:any)'] = 'CateringManagement/Pesanan/C_Pesanan/$1';
$route['CateringManagement/DataPesanan/(:any)/(:any)'] = 'CateringManagement/Pesanan/C_Pesanan/$1/$2';

$route['CateringManagement/PesananTambahan'] = 'CateringManagement/Pesanan/C_Tambahan';
$route['CateringManagement/PesananTambahan/(:any)'] = 'CateringManagement/Pesanan/C_Tambahan/$1';
$route['CateringManagement/PesananTambahan/(:any)/(:any)'] = 'CateringManagement/Pesanan/C_Tambahan/$1/$2';

$route['CateringManagement/Plotting'] = 'CateringManagement/Pesanan/C_Plotting';
$route['CateringManagement/Plotting/(:any)'] = 'CateringManagement/Pesanan/C_Plotting/$1';
$route['CateringManagement/Plotting/(:any)/(:any)'] = 'CateringManagement/Pesanan/C_Plotting/$1/$2';

//------------------------------------Management Presensi---------------------------------------------------
$route['PresenceManagement'] 						= 'PresenceManagement/C_Index/index';

$route['PresenceManagement/Monitoring'] 			= 'PresenceManagement/MainMenu/C_Monitoring/index';
$route['PresenceManagement/Monitoring/(:any)']		= 'PresenceManagement/MainMenu/C_Monitoring/$1';
$route['PresenceManagement/Monitoring/(:any)/(:any)']	= 'PresenceManagement/MainMenu/C_Monitoring/$1/$2';
$route['PresenceManagement/Monitoring/(:any)/(:any)/(:any)']	= 'PresenceManagement/MainMenu/C_Monitoring/$1/$2/$3';

// 	Monitoring Presensi (fingerprint scanner baru)
//	{
		$route['PresenceManagement/MonitoringPresensi'] 				=	'PresenceManagement/C_MonitoringPresensi';
		$route['PresenceManagement/MonitoringPresensi/(:any)'] 			=	'PresenceManagement/C_MonitoringPresensi/$1';
		$route['PresenceManagement/MonitoringPresensi/(:any)/(:any)'] 	=	'PresenceManagement/C_MonitoringPresensi/$1/$2';

		$route['PresenceManagement/MonitoringPresensiPengaturan'] 				=	'PresenceManagement/C_MonitoringPresensiPengaturan';
		$route['PresenceManagement/MonitoringPresensiPengaturan/(:any)'] 		=	'PresenceManagement/C_MonitoringPresensiPengaturan/$1';
		$route['PresenceManagement/MonitoringPresensiPengaturan/(:any)/(:any)'] =	'PresenceManagement/C_MonitoringPresensiPengaturan/$1/$2';
		$route['PresenceManagement/CekData'] 					= 'PresenceManagement/MainMenu/C_CekData';
		$route['PresenceManagement/CekData/Detail/(:any)'] 			= 'PresenceManagement/MainMenu/C_CekData/Detail/$1';
		$route['PresenceManagement/MonFingerspot'] = 'PresenceManagement/C_MonFingerspot';
		$route['PresenceManagement/MonFingerspot/(:any)'] = 'PresenceManagement/C_MonFingerspot/$1';
//	}

//---------------------------------Payroll Management----------------------------------

$route['PayrollManagement/RiwayatPotDanaPensiun'] = 'PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun';
$route['PayrollManagement/RiwayatPotDanaPensiun/(:any)'] = 'PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun/$1';
$route['PayrollManagement/RiwayatPotDanaPensiun/(:any)/(:any)'] = 'PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun/$1/$2';

$route['PayrollManagement/RiwayatInsentifKemahalan'] = 'PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan';
$route['PayrollManagement/RiwayatInsentifKemahalan/(:any)'] = 'PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan/$1';
$route['PayrollManagement/RiwayatInsentifKemahalan/(:any)/(:any)'] = 'PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan/$1/$2';

$route['PayrollManagement/RiwayatUpamk'] = 'PayrollManagement/UPAMK/C_RiwayatUpamk';
$route['PayrollManagement/RiwayatUpamk/(:any)'] = 'PayrollManagement/UPAMK/C_RiwayatUpamk/$1';
$route['PayrollManagement/RiwayatUpamk/(:any)/(:any)'] = 'PayrollManagement/UPAMK/C_RiwayatUpamk/$1/$2';

$route['PayrollManagement/RiwayatGaji'] = 'PayrollManagement/MasterGaji/C_RiwayatGaji';
$route['PayrollManagement/RiwayatGaji/(:any)'] = 'PayrollManagement/MasterGaji/C_RiwayatGaji/$1';
$route['PayrollManagement/RiwayatGaji/(:any)/(:any)'] = 'PayrollManagement/MasterGaji/C_RiwayatGaji/$1/$2';

$route['PayrollManagement/RiwayatSetAsuransi'] = 'PayrollManagement/SetTarifAsuransi/C_RiwayatSetAsuransi';
$route['PayrollManagement/RiwayatSetAsuransi/(:any)'] = 'PayrollManagement/SetTarifAsuransi/C_RiwayatSetAsuransi/$1';
$route['PayrollManagement/RiwayatSetAsuransi/(:any)/(:any)'] = 'PayrollManagement/SetTarifAsuransi/C_RiwayatSetAsuransi/$1/$2';

$route['PayrollManagement/MasterTarifJkk'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk';
$route['PayrollManagement/MasterTarifJkk/(:any)'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk/$1';
$route['PayrollManagement/MasterTarifJkk/(:any)/(:any)'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk/$1/$2';

$route['PayrollManagement/MasterParamTarifJamsostek'] = 'PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek';
$route['PayrollManagement/MasterParamTarifJamsostek/(:any)'] = 'PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek/$1';
$route['PayrollManagement/MasterParamTarifJamsostek/(:any)/(:any)'] = 'PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek/$1/$2';

$route['PayrollManagement/RiwayatTarifJkk'] = 'PayrollManagement/SetTarifJKK/C_RiwayatTarifJkk';
$route['PayrollManagement/RiwayatTarifJkk/(:any)'] = 'PayrollManagement/SetTarifJKK/C_RiwayatTarifJkk/$1';
$route['PayrollManagement/RiwayatTarifJkk/(:any)/(:any)'] = 'PayrollManagement/SetTarifJKK/C_RiwayatTarifJkk/$1/$2';

$route['PresenceManagement/Cronjob'] 			= 'PresenceManagement/MainMenu/C_Cronjob/index';
$route['PresenceManagement/Cronjob/(:any)']	= 'PresenceManagement/MainMenu/C_Cronjob/$1';
$route['PresenceManagement/Cronjob/(:any)/(:any)']	= 'PresenceManagement/MainMenu/C_Cronjob/$1/$2';


//------------------------------------Account Payables---------------------------------------------------
$route['AccountPayables'] 				= 'AccountPayables/C_KlikBCAChecking_Index';
$route['AccountPayables/Invoice'] 			= 'AccountPayables/C_Invoice';
$route['AccountPayables/Invoice/(:any)'] 			= 'AccountPayables/C_Invoice/$1';
$route['AccountPayables/Invoice/(:any)/(:any)'] 			= 'AccountPayables/C_Invoice/$1/$2';
$route['AccountPayables/Invoice/(:any)/(:any)/(:any)'] 			= 'AccountPayables/C_Invoice/$1/$2/$3';
$route['AccountPayables/Lppb'] 				= 'AccountPayables/C_Lppb';
$route['AccountPayables/Lppb/(:any)'] 				= 'AccountPayables/C_Lppb/$1';
$route['AccountPayables/Prepayment'] 				= 'AccountPayables/C_Prepayment';
$route['AccountPayables/Prepayment/(:any)'] 				= 'AccountPayables/C_Prepayment/$1';


//------------------------------------Payroll Management---------------------------------------------------
$route['PayrollManagement'] = 'PayrollManagement/C_Index';

$route['PayrollManagement/RiwayatRekeningPekerja'] = 'PayrollManagement/DataNoRecPekerja/C_RiwayatRekeningPekerja';
$route['PayrollManagement/RiwayatRekeningPekerja/(:any)'] = 'PayrollManagement/DataNoRecPekerja/C_RiwayatRekeningPekerja/$1';
$route['PayrollManagement/RiwayatRekeningPekerja/(:any)/(:any)'] = 'PayrollManagement/DataNoRecPekerja/C_RiwayatRekeningPekerja/$1/$2';

$route['PayrollManagement/RiwayatPotDanaPensiun'] = 'PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun';
$route['PayrollManagement/RiwayatPotDanaPensiun/(:any)'] = 'PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun/$1';
$route['PayrollManagement/RiwayatPotDanaPensiun/(:any)/(:any)'] = 'PayrollManagement/IuranPensiun/C_RiwayatPotDanaPensiun/$1/$2';

$route['PayrollManagement/RiwayatInsentifKemahalan'] = 'PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan';
$route['PayrollManagement/RiwayatInsentifKemahalan/(:any)'] = 'PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan/$1';
$route['PayrollManagement/RiwayatInsentifKemahalan/(:any)/(:any)'] = 'PayrollManagement/MasterInsKemahalan/C_RiwayatInsentifKemahalan/$1/$2';

$route['PayrollManagement/RiwayatUpamk'] = 'PayrollManagement/UPAMK/C_RiwayatUpamk';
$route['PayrollManagement/RiwayatUpamk/(:any)'] = 'PayrollManagement/UPAMK/C_RiwayatUpamk/$1';
$route['PayrollManagement/RiwayatUpamk/(:any)/(:any)'] = 'PayrollManagement/UPAMK/C_RiwayatUpamk/$1/$2';

$route['PayrollManagement/RiwayatGaji'] = 'PayrollManagement/MasterGaji/C_RiwayatGaji';
$route['PayrollManagement/RiwayatGaji/(:any)'] = 'PayrollManagement/MasterGaji/C_RiwayatGaji/$1';
$route['PayrollManagement/RiwayatGaji/(:any)/(:any)'] = 'PayrollManagement/MasterGaji/C_RiwayatGaji/$1/$2';

$route['PayrollManagement/RiwayatSetAsuransi'] = 'PayrollManagement/SetTarifAsuransi/C_RiwayatSetAsuransi';
$route['PayrollManagement/RiwayatSetAsuransi/(:any)'] = 'PayrollManagement/SetTarifAsuransi/C_RiwayatSetAsuransi/$1';
$route['PayrollManagement/RiwayatSetAsuransi/(:any)/(:any)'] = 'PayrollManagement/SetTarifAsuransi/C_RiwayatSetAsuransi/$1/$2';

$route['PayrollManagement/RiwayatSetTarifAsuransi'] = 'PayrollManagement/SetPenerimaAsuransi/C_RiwayatSetAsuransi';
$route['PayrollManagement/RiwayatSetTarifAsuransi/(:any)'] = 'PayrollManagement/SetPenerimaAsuransi/C_RiwayatSetAsuransi/$1';
$route['PayrollManagement/RiwayatSetTarifAsuransi/(:any)/(:any)'] = 'PayrollManagement/SetPenerimaAsuransi/C_RiwayatSetAsuransi/$1/$2';

$route['PayrollManagement/MasterTarifJkk'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk';
$route['PayrollManagement/MasterTarifJkk/(:any)'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk/$1';
$route['PayrollManagement/MasterTarifJkk/(:any)/(:any)'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk/$1/$2';

$route['PayrollManagement/MasterStatusKerja'] = 'PayrollManagement/MasterStatusKerja/C_MasterStatusKerja';
$route['PayrollManagement/MasterStatusKerja/(:any)'] = 'PayrollManagement/MasterStatusKerja/C_MasterStatusKerja/$1';
$route['PayrollManagement/MasterStatusKerja/(:any)/(:any)'] = 'PayrollManagement/MasterStatusKerja/C_MasterStatusKerja/$1/$2';

$route['PayrollManagement/MasterJabatan'] = 'PayrollManagement/MasterJabatan/C_MasterJabatan';
$route['PayrollManagement/MasterJabatan/(:any)'] = 'PayrollManagement/MasterJabatan/C_MasterJabatan/$1';
$route['PayrollManagement/MasterJabatan/(:any)/(:any)'] = 'PayrollManagement/MasterJabatan/C_MasterJabatan/$1/$2';

$route['PayrollManagement/MasterSeksi'] = 'PayrollManagement/MasterSeksi/C_MasterSeksi';
$route['PayrollManagement/MasterSeksi/(:any)'] = 'PayrollManagement/MasterSeksi/C_MasterSeksi/$1';
$route['PayrollManagement/MasterSeksi/(:any)/(:any)'] = 'PayrollManagement/MasterSeksi/C_MasterSeksi/$1/$2';

$route['PayrollManagement/KantorAsal'] = 'PayrollManagement/MasterKantorAsal/C_KantorAsal';
$route['PayrollManagement/KantorAsal/(:any)'] = 'PayrollManagement/MasterKantorAsal/C_KantorAsal/$1';
$route['PayrollManagement/KantorAsal/(:any)/(:any)'] = 'PayrollManagement/MasterKantorAsal/C_KantorAsal/$1/$2';

$route['PayrollManagement/LokasiKerja'] = 'PayrollManagement/MasterLokasiKerja/C_LokasiKerja';
$route['PayrollManagement/LokasiKerja/(:any)'] = 'PayrollManagement/MasterLokasiKerja/C_LokasiKerja/$1';
$route['PayrollManagement/LokasiKerja/(:any)/(:any)'] = 'PayrollManagement/MasterLokasiKerja/C_LokasiKerja/$1/$2';

$route['PayrollManagement/MasterBankInduk'] = 'PayrollManagement/MasterBankInduk/C_MasterBankInduk';
$route['PayrollManagement/MasterBankInduk/(:any)'] = 'PayrollManagement/MasterBankInduk/C_MasterBankInduk/$1';
$route['PayrollManagement/MasterBankInduk/(:any)/(:any)'] = 'PayrollManagement/MasterBankInduk/C_MasterBankInduk/$1/$2';

$route['PayrollManagement/MasterBank'] = 'PayrollManagement/MasterBank/C_MasterBank';
$route['PayrollManagement/MasterBank/(:any)'] = 'PayrollManagement/MasterBank/C_MasterBank/$1';
$route['PayrollManagement/MasterBank/(:any)/(:any)'] = 'PayrollManagement/MasterBank/C_MasterBank/$1/$2';

$route['PayrollManagement/MasterSekolahAsal'] = 'PayrollManagement/MasterSekolahAsal/C_MasterSekolahAsal';
$route['PayrollManagement/MasterSekolahAsal/(:any)'] = 'PayrollManagement/MasterSekolahAsal/C_MasterSekolahAsal/$1';
$route['PayrollManagement/MasterSekolahAsal/(:any)/(:any)'] = 'PayrollManagement/MasterSekolahAsal/C_MasterSekolahAsal/$1/$2';

$route['PayrollManagement/SetGajiUMP'] = 'PayrollManagement/SetGajiUMP/C_SetGajiUMP';
$route['PayrollManagement/SetGajiUMP/(:any)'] = 'PayrollManagement/SetGajiUMP/C_SetGajiUMP/$1';
$route['PayrollManagement/SetGajiUMP/(:any)/(:any)'] = 'PayrollManagement/SetGajiUMP/C_SetGajiUMP/$1/$2';

$route['PayrollManagement/SetTarifPekerjaSakit'] = 'PayrollManagement/SetTarifPekerjaSakit/C_SetTarifPekerjaSakit';
$route['PayrollManagement/SetTarifPekerjaSakit/(:any)'] = 'PayrollManagement/SetTarifPekerjaSakit/C_SetTarifPekerjaSakit/$1';
$route['PayrollManagement/SetTarifPekerjaSakit/(:any)/(:any)'] = 'PayrollManagement/SetTarifPekerjaSakit/C_SetTarifPekerjaSakit/$1/$2';

$route['PayrollManagement/SetPenerimaUBTHR'] = 'PayrollManagement/SetPenerimaUBTHR/C_SetPenerimaUBTHR';
$route['PayrollManagement/SetPenerimaUBTHR/(:any)'] = 'PayrollManagement/SetPenerimaUBTHR/C_SetPenerimaUBTHR/$1';
$route['PayrollManagement/SetPenerimaUBTHR/(:any)/(:any)'] = 'PayrollManagement/SetPenerimaUBTHR/C_SetPenerimaUBTHR/$1/$2';

$route['PayrollManagement/StandartJamTkpw'] = 'PayrollManagement/SetStandartJamTKPW/C_StandartJamTkpw';
$route['PayrollManagement/StandartJamTkpw/(:any)'] = 'PayrollManagement/SetStandartJamTKPW/C_StandartJamTkpw/$1';
$route['PayrollManagement/StandartJamTkpw/(:any)/(:any)'] = 'PayrollManagement/SetStandartJamTKPW/C_StandartJamTkpw/$1/$2';

$route['PayrollManagement/StandartJamUmum'] = 'PayrollManagement/SetStandartJamUmum/C_StandartJamUmum';
$route['PayrollManagement/StandartJamUmum/(:any)'] = 'PayrollManagement/SetStandartJamUmum/C_StandartJamUmum/$1';
$route['PayrollManagement/StandartJamUmum/(:any)/(:any)'] = 'PayrollManagement/SetStandartJamUmum/C_StandartJamUmum/$1/$2';

$route['PayrollManagement/MasterParamBpjs'] = 'PayrollManagement/SetTarifBPJS/C_MasterParamBpjs';
$route['PayrollManagement/MasterParamBpjs/(:any)'] = 'PayrollManagement/SetTarifBPJS/C_MasterParamBpjs/$1';
$route['PayrollManagement/MasterParamBpjs/(:any)/(:any)'] = 'PayrollManagement/SetTarifBPJS/C_MasterParamBpjs/$1/$2';

$route['PayrollManagement/MasterParamPtkp'] = 'PayrollManagement/SetTarifPTKP/C_MasterParamPtkp';
$route['PayrollManagement/MasterParamPtkp/(:any)'] = 'PayrollManagement/SetTarifPTKP/C_MasterParamPtkp/$1';
$route['PayrollManagement/MasterParamPtkp/(:any)/(:any)'] = 'PayrollManagement/SetTarifPTKP/C_MasterParamPtkp/$1/$2';

$route['PayrollManagement/MasterParameterTarifPph'] = 'PayrollManagement/SetTarifPPH/C_MasterParameterTarifPph';
$route['PayrollManagement/MasterParameterTarifPph/(:any)'] = 'PayrollManagement/SetTarifPPH/C_MasterParameterTarifPph/$1';
$route['PayrollManagement/MasterParameterTarifPph/(:any)/(:any)'] = 'PayrollManagement/SetTarifPPH/C_MasterParameterTarifPph/$1/$2';

$route['PayrollManagement/RiwayatPenerimaKonpensasiLembur'] = 'PayrollManagement/SetPenerimaKonpensasiLembur/C_RiwayatPenerimaKonpensasiLembur';
$route['PayrollManagement/RiwayatPenerimaKonpensasiLembur/(:any)'] = 'PayrollManagement/SetPenerimaKonpensasiLembur/C_RiwayatPenerimaKonpensasiLembur/$1';
$route['PayrollManagement/RiwayatPenerimaKonpensasiLembur/(:any)/(:any)'] = 'PayrollManagement/SetPenerimaKonpensasiLembur/C_RiwayatPenerimaKonpensasiLembur/$1/$2';

$route['PayrollManagement/MasterParamKompJab'] = 'PayrollManagement/SetKomponenGajiJabatan/C_MasterParamKompJab';
$route['PayrollManagement/MasterParamKompJab/(:any)'] = 'PayrollManagement/SetKomponenGajiJabatan/C_MasterParamKompJab/$1';
$route['PayrollManagement/MasterParamKompJab/(:any)/(:any)'] = 'PayrollManagement/SetKomponenGajiJabatan/C_MasterParamKompJab/$1/$2';

$route['PayrollManagement/MasterParamKompUmum'] = 'PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum';
$route['PayrollManagement/MasterParamKompUmum/(:any)'] = 'PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum/$1';
$route['PayrollManagement/MasterParamKompUmum/(:any)/(:any)'] = 'PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum/$1/$2';

$route['PayrollManagement/MasterParamPengurangPajak'] = 'PayrollManagement/SetPengurangPajak/C_MasterParamPengurangPajak';
$route['PayrollManagement/MasterParamPengurangPajak/(:any)'] = 'PayrollManagement/SetPengurangPajak/C_MasterParamPengurangPajak/$1';
$route['PayrollManagement/MasterParamPengurangPajak/(:any)/(:any)'] = 'PayrollManagement/SetPengurangPajak/C_MasterParamPengurangPajak/$1/$2';

$route['PayrollManagement/MasterPekerja'] = 'PayrollManagement/MasterPekerja/C_MasterPekerja';
$route['PayrollManagement/MasterPekerja/(:any)'] = 'PayrollManagement/MasterPekerja/C_MasterPekerja/$1';
$route['PayrollManagement/MasterPekerja/(:any)/(:any)'] = 'PayrollManagement/MasterPekerja/C_MasterPekerja/$1/$2';

$route['PayrollManagement/TransaksiRapel'] = 'PayrollManagement/TransaksiRapel/C_TransaksiRapel';
$route['PayrollManagement/TransaksiRapel/(:any)'] = 'PayrollManagement/TransaksiRapel/C_TransaksiRapel/$1';
$route['PayrollManagement/TransaksiRapel/(:any)/(:any)'] = 'PayrollManagement/TransaksiRapel/C_TransaksiRapel/$1/$2';

$route['PayrollManagement/RiwayatParamKoperasi'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi';
$route['PayrollManagement/RiwayatParamKoperasi/(:any)'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi/$1';
$route['PayrollManagement/RiwayatParamKoperasi/(:any)/(:any)'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi/$1/$2';

$route['PayrollManagement/KompTamb'] = 'PayrollManagement/KomponenTambahan/C_KompTamb';
$route['PayrollManagement/KompTamb/(:any)'] = 'PayrollManagement/KomponenTambahan/C_KompTamb/$1';
$route['PayrollManagement/KompTamb/(:any)/(:any)'] = 'PayrollManagement/KomponenTambahan/C_KompTamb/$1/$2';

$route['PayrollManagement/KompTambLain'] = 'PayrollManagement/KomponenTambahanLain/C_KompTambLain';
$route['PayrollManagement/KompTambLain/(:any)'] = 'PayrollManagement/KomponenTambahanLain/C_KompTambLain/$1';
$route['PayrollManagement/KompTambLain/(:any)/(:any)'] = 'PayrollManagement/KomponenTambahanLain/C_KompTambLain/$1/$2';

$route['PayrollManagement/TransaksiKlaimSisaCuti'] = 'PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti';
$route['PayrollManagement/TransaksiKlaimSisaCuti/(:any)'] = 'PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti/$1';
$route['PayrollManagement/TransaksiKlaimSisaCuti/(:any)/(:any)'] = 'PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti/$1/$2';

$route['PayrollManagement/TransaksiHitungThr'] = 'PayrollManagement/TransaksiTHR/C_TransaksiHitungThr';
$route['PayrollManagement/TransaksiHitungThr/(:any)'] = 'PayrollManagement/TransaksiTHR/C_TransaksiHitungThr/$1';
$route['PayrollManagement/TransaksiHitungThr/(:any)/(:any)'] = 'PayrollManagement/TransaksiTHR/C_TransaksiHitungThr/$1/$2';

$route['PayrollManagement/TransaksiHutang'] = 'PayrollManagement/TransaksiHutang/C_TransaksiHutang';
$route['PayrollManagement/TransaksiHutang/(:any)'] = 'PayrollManagement/TransaksiHutang/C_TransaksiHutang/$1';
$route['PayrollManagement/TransaksiHutang/(:any)/(:any)'] = 'PayrollManagement/TransaksiHutang/C_TransaksiHutang/$1/$2';

$route['PayrollManagement/MasterParamKompUmum'] = 'PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum';
$route['PayrollManagement/MasterParamKompUmum/(:any)'] = 'PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum/$1';
$route['PayrollManagement/MasterParamKompUmum/(:any)/(:any)'] = 'PayrollManagement/SetKomponenGajiUmum/C_MasterParamKompUmum/$1/$2';

$route['PayrollManagement/RiwayatParamKoperasi'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi';
$route['PayrollManagement/RiwayatParamKoperasi/(:any)'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi/$1';
$route['PayrollManagement/RiwayatParamKoperasi/(:any)/(:any)'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi/$1/$2';

$route['PayrollManagement/TransaksiKlaimSisaCuti'] = 'PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti';
$route['PayrollManagement/TransaksiKlaimSisaCuti/(:any)'] = 'PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti/$1';
$route['PayrollManagement/TransaksiKlaimSisaCuti/(:any)/(:any)'] = 'PayrollManagement/TransaksiKlaimSisaCuti/C_TransaksiKlaimSisaCuti/$1/$2';

$route['PayrollManagement/TransaksiHitungThr'] = 'PayrollManagement/TransaksiTHR/C_TransaksiHitungThr';
$route['PayrollManagement/TransaksiHitungThr/(:any)'] = 'PayrollManagement/TransaksiTHR/C_TransaksiHitungThr/$1';
$route['PayrollManagement/TransaksiHitungThr/(:any)/(:any)'] = 'PayrollManagement/TransaksiTHR/C_TransaksiHitungThr/$1/$2';

$route['PayrollManagement/TransaksiHutang'] = 'PayrollManagement/TransaksiHutang/C_TransaksiHutang';
$route['PayrollManagement/TransaksiHutang/(:any)'] = 'PayrollManagement/TransaksiHutang/C_TransaksiHutang/$1';
$route['PayrollManagement/TransaksiHutang/(:any)/(:any)'] = 'PayrollManagement/TransaksiHutang/C_TransaksiHutang/$1/$2';

$route['PayrollManagement/HutangKaryawan'] = 'PayrollManagement/TransaksiHutangKaryawan/C_HutangKaryawan';
$route['PayrollManagement/HutangKaryawan/(:any)'] = 'PayrollManagement/TransaksiHutangKaryawan/C_HutangKaryawan/$1';
$route['PayrollManagement/HutangKaryawan/(:any)/(:any)'] = 'PayrollManagement/TransaksiHutangKaryawan/C_HutangKaryawan/$1/$2';

$route['PayrollManagement/DaftarPekerjaSakit'] = 'PayrollManagement/TransaksiPekerjaSakitBerkepanjangan/C_DaftarPekerjaSakit';
$route['PayrollManagement/DaftarPekerjaSakit/(:any)'] = 'PayrollManagement/TransaksiPekerjaSakitBerkepanjangan/C_DaftarPekerjaSakit/$1';
$route['PayrollManagement/DaftarPekerjaSakit/(:any)/(:any)'] = 'PayrollManagement/TransaksiPekerjaSakitBerkepanjangan/C_DaftarPekerjaSakit/$1/$2';

$route['PayrollManagement/DataGajianPersonalia'] = 'PayrollManagement/DataHariMasuk/C_DataGajianPersonalia';
$route['PayrollManagement/DataGajianPersonalia/(:any)'] = 'PayrollManagement/DataHariMasuk/C_DataGajianPersonalia/$1';
$route['PayrollManagement/DataGajianPersonalia/(:any)/(:any)'] = 'PayrollManagement/DataHariMasuk/C_DataGajianPersonalia/$1/$2';

$route['PayrollManagement/TransaksiKlaimDl'] = 'PayrollManagement/TransaksiKlaimDinas/C_TransaksiKlaimDl';
$route['PayrollManagement/TransaksiKlaimDl/(:any)'] = 'PayrollManagement/TransaksiKlaimDinas/C_TransaksiKlaimDl/$1';
$route['PayrollManagement/TransaksiKlaimDl/(:any)/(:any)'] = 'PayrollManagement/TransaksiKlaimDinas/C_TransaksiKlaimDl/$1/$2';

$route['PayrollManagement/MasterJabatanUpah'] = 'PayrollManagement/MasterJabatanUpah/C_MasterJabatanUpah';
$route['PayrollManagement/MasterJabatanUpah/(:any)'] = 'PayrollManagement/MasterJabatanUpah/C_MasterJabatanUpah/$1';
$route['PayrollManagement/MasterJabatanUpah/(:any)/(:any)'] = 'PayrollManagement/MasterJabatanUpah/C_MasterJabatanUpah/$1/$2';

$route['PayrollManagement/BrowseTransaksiPenggajian'] = 'PayrollManagement/BrowseTransaksiPenggajian/C_TransaksiPenggajian';
$route['PayrollManagement/BrowseTransaksiPenggajian/(:any)'] = 'PayrollManagement/BrowseTransaksiPenggajian/C_TransaksiPenggajian/$1';
$route['PayrollManagement/BrowseTransaksiPenggajian/(:any)/(:any)'] = 'PayrollManagement/BrowseTransaksiPenggajian/C_TransaksiPenggajian/$1/$2';

$route['PayrollManagement/KlaimGajiIndividual'] = 'PayrollManagement/KlaimGajiIndividual/C_KlaimGajiIndividual';
$route['PayrollManagement/KlaimGajiIndividual/(:any)'] = 'PayrollManagement/KlaimGajiIndividual/C_KlaimGajiIndividual/$1';
$route['PayrollManagement/KlaimGajiIndividual/(:any)/(:any)'] = 'PayrollManagement/KlaimGajiIndividual/C_KlaimGajiIndividual/$1/$2';

$route['PayrollManagement/DataKlaimPekerjaKeluar'] = 'PayrollManagement/DataKlaimPekerjaKeluar/C_DataKlaimPekerjaKeluar';
$route['PayrollManagement/DataKlaimPekerjaKeluar/(:any)'] = 'PayrollManagement/DataKlaimPekerjaKeluar/C_DataKlaimPekerjaKeluar/$1';
$route['PayrollManagement/DataKlaimPekerjaKeluar/(:any)/(:any)'] = 'PayrollManagement/DataKlaimPekerjaKeluar/C_DataKlaimPekerjaKeluar/$1/$2';

$route['PayrollManagement/KompensasiLembur'] = 'PayrollManagement/KompensasiLembur/C_KompensasiLembur';
$route['PayrollManagement/KompensasiLembur/(:any)'] = 'PayrollManagement/KompensasiLembur/C_KompensasiLembur/$1';
$route['PayrollManagement/KompensasiLembur/(:any)/(:any)'] = 'PayrollManagement/KompensasiLembur/C_KompensasiLembur/$1/$2';

$route['PayrollManagement/Database/Backup'] = 'PayrollManagement/Setting/C_Setting/BackUp';
$route['PayrollManagement/Database/Restore'] = 'PayrollManagement/Setting/C_Setting/Restore';
$route['PayrollManagement/Database/ClearDatabase'] = 'PayrollManagement/Setting/C_Setting/ClearData';
//Report Penggajian Staff

$route['PayrollManagement/Report/RapelPremiAsuransi'] = 'PayrollManagement/Report/RapelPremiAsuransi/C_RapelPremiAsuransi';
$route['PayrollManagement/Report/RapelPremiAsuransi/(:any)'] = 'PayrollManagement/Report/RapelPremiAsuransi/C_RapelPremiAsuransi/$1';
$route['PayrollManagement/Report/RapelPremiAsuransi/(:any)/(:any)'] = 'PayrollManagement/Report/RapelPremiAsuransi/C_RapelPremiAsuransi/$1/$2';

$route['PayrollManagement/Report/SummaryGajiStaff'] = 'PayrollManagement/Report/SummaryGajiStaff/C_SummaryGajiStaff';
$route['PayrollManagement/Report/SummaryGajiStaff/(:any)'] = 'PayrollManagement/Report/SummaryGajiStaff/C_SummaryGajiStaff/$1';
$route['PayrollManagement/Report/SummaryGajiStaff/(:any)/(:any)'] = 'PayrollManagement/Report/SummaryGajiStaff/C_SummaryGajiStaff/$1/$2';

$route['PayrollManagement/Report/PenghasilanBawahPTKP'] = 'PayrollManagement/Report/PenghasilanBawahPTKP/C_PenghasilanBawahPTKP';
$route['PayrollManagement/Report/PenghasilanBawahPTKP/(:any)'] = 'PayrollManagement/Report/PenghasilanBawahPTKP/C_PenghasilanBawahPTKP/$1';
$route['PayrollManagement/Report/PenghasilanBawahPTKP/(:any)/(:any)'] = 'PayrollManagement/Report/PenghasilanBawahPTKP/C_PenghasilanBawahPTKP/$1/$2';

$route['PayrollManagement/Report/RincianRapelGaji'] = 'PayrollManagement/Report/RincianRapelGaji/C_RincianRapelGaji';
$route['PayrollManagement/Report/RincianRapelGaji/(:any)'] = 'PayrollManagement/Report/RincianRapelGaji/C_RincianRapelGaji/$1';
$route['PayrollManagement/Report/RincianRapelGaji/(:any)/(:any)'] = 'PayrollManagement/Report/RincianRapelGaji/C_RincianRapelGaji/$1/$2';

$route['PayrollManagement/Report/DataRiwayatPekerja'] = 'PayrollManagement/Report/DataRiwayatPekerja/C_DataRiwayatPekerja';
$route['PayrollManagement/Report/DataRiwayatPekerja/(:any)'] = 'PayrollManagement/Report/DataRiwayatPekerja/C_DataRiwayatPekerja/$1';
$route['PayrollManagement/Report/DataRiwayatPekerja/(:any)/(:any)'] = 'PayrollManagement/Report/DataRiwayatPekerja/C_DataRiwayatPekerja/$1/$2';

$route['PayrollManagement/Report/PotonganSPSI'] = 'PayrollManagement/Report/PotonganSPSI/C_PotonganSPSI';
$route['PayrollManagement/Report/PotonganSPSI/(:any)'] = 'PayrollManagement/Report/PotonganSPSI/C_PotonganSPSI/$1';
$route['PayrollManagement/Report/PotonganSPSI/(:any)/(:any)'] = 'PayrollManagement/Report/PotonganSPSI/C_PotonganSPSI/$1/$2';

$route['PayrollManagement/Report/PotonganDanaPensiun'] = 'PayrollManagement/Report/PotonganDanaPensiun/C_PotonganDanaPensiun';
$route['PayrollManagement/Report/PotonganDanaPensiun/(:any)'] = 'PayrollManagement/Report/PotonganDanaPensiun/C_PotonganDanaPensiun/$1';
$route['PayrollManagement/Report/PotonganDanaPensiun/(:any)/(:any)'] = 'PayrollManagement/Report/PotonganDanaPensiun/C_PotonganDanaPensiun/$1/$2';

$route['PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan'] = 'PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/C_PerhitunganIuranJKNBPJSKesehatan';
$route['PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/(:any)'] = 'PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/C_PerhitunganIuranJKNBPJSKesehatan/$1';
$route['PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/(:any)/(:any)'] = 'PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/C_PerhitunganIuranJKNBPJSKesehatan/$1/$2';

$route['PayrollManagement/Report/RiwayatKenaikanGaji'] = 'PayrollManagement/Report/RiwayatKenaikanGaji/C_RiwayatKenaikanGaji';
$route['PayrollManagement/Report/RiwayatKenaikanGaji/(:any)'] = 'PayrollManagement/Report/RiwayatKenaikanGaji/C_RiwayatKenaikanGaji/$1';
$route['PayrollManagement/Report/RiwayatKenaikanGaji/(:any)/(:any)'] = 'PayrollManagement/Report/RiwayatKenaikanGaji/C_RiwayatKenaikanGaji/$1/$2';

$route['PayrollManagement/Report/RincianPembayaranPajakPekerja'] = 'PayrollManagement/Report/RincianPembayaranPajakPekerja/C_RincianPembayaranPajakPekerja';
$route['PayrollManagement/Report/RincianPembayaranPajakPekerja/(:any)'] = 'PayrollManagement/Report/RincianPembayaranPajakPekerja/C_RincianPembayaranPajakPekerja/$1';
$route['PayrollManagement/Report/RincianPembayaranPajakPekerja/(:any)/(:any)'] = 'PayrollManagement/Report/RincianPembayaranPajakPekerja/C_RincianPembayaranPajakPekerja/$1/$2';

$route['PayrollManagement/Report/PotonganKoperasi'] = 'PayrollManagement/Report/PotonganKoperasi/C_PotonganKoperasi';
$route['PayrollManagement/Report/PotonganKoperasi/(:any)'] = 'PayrollManagement/Report/PotonganKoperasi/C_PotonganKoperasi/$1';
$route['PayrollManagement/Report/PotonganKoperasi/(:any)/(:any)'] = 'PayrollManagement/Report/PotonganKoperasi/C_PotonganKoperasi/$1/$2';

$route['PayrollManagement/Report/JamsostekPerubahanDataPekerja'] = 'PayrollManagement/Report/JamsostekPerubahanDataPekerja/C_JamsostekPerubahanDataPekerja';
$route['PayrollManagement/Report/JamsostekPerubahanDataPekerja/(:any)'] = 'PayrollManagement/Report/JamsostekPerubahanDataPekerja/C_JamsostekPerubahanDataPekerja/$1';
$route['PayrollManagement/Report/JamsostekPerubahanDataPekerja/(:any)/(:any)'] = 'PayrollManagement/Report/JamsostekPerubahanDataPekerja/C_JamsostekPerubahanDataPekerja/$1/$2';

$route['PayrollManagement/Report/RekapPembayaranJHT'] = 'PayrollManagement/Report/RekapPembayaranJHT/C_RekapPembayaranJHT';
$route['PayrollManagement/Report/RekapPembayaranJHT/(:any)'] = 'PayrollManagement/Report/RekapPembayaranJHT/C_RekapPembayaranJHT/$1';
$route['PayrollManagement/Report/RekapPembayaranJHT/(:any)/(:any)'] = 'PayrollManagement/Report/RekapPembayaranJHT/C_RekapPembayaranJHT/$1/$2';

$route['PayrollManagement/Report/RekapPenerimaanGajiStaff'] = 'PayrollManagement/Report/RekapPenerimaanGajiStaff/C_RekapPenerimaanGajiStaff';
$route['PayrollManagement/Report/RekapPenerimaanGajiStaff/(:any)'] = 'PayrollManagement/Report/RekapPenerimaanGajiStaff/C_RekapPenerimaanGajiStaff/$1';
$route['PayrollManagement/Report/RekapPenerimaanGajiStaff/(:any)/(:any)'] = 'PayrollManagement/Report/RekapPenerimaanGajiStaff/C_RekapPenerimaanGajiStaff/$1/$2';

$route['PayrollManagement/Report/MasterGajiKaryawan'] = 'PayrollManagement/Report/MasterGajiKaryawan/C_MasterGajiKaryawan';
$route['PayrollManagement/Report/MasterGajiKaryawan/(:any)'] = 'PayrollManagement/Report/MasterGajiKaryawan/C_MasterGajiKaryawan/$1';
$route['PayrollManagement/Report/MasterGajiKaryawan/(:any)/(:any)'] = 'PayrollManagement/Report/MasterGajiKaryawan/C_MasterGajiKaryawan/$1/$2';

$route['PayrollManagement/Report/DataMutasiPekerja'] = 'PayrollManagement/Report/DataMutasiPekerja/C_DataMutasiPekerja';
$route['PayrollManagement/Report/DataMutasiPekerja/(:any)'] = 'PayrollManagement/Report/DataMutasiPekerja/C_DataMutasiPekerja/$1';
$route['PayrollManagement/Report/DataMutasiPekerja/(:any)/(:any)'] = 'PayrollManagement/Report/DataMutasiPekerja/C_DataMutasiPekerja/$1/$2';

$route['PayrollManagement/Report/BuktiPotonganPajakPekerja'] = 'PayrollManagement/Report/BuktiPotonganPajakPekerja/C_BuktiPotonganPajakPekerja';
$route['PayrollManagement/Report/BuktiPotonganPajakPekerja/(:any)'] = 'PayrollManagement/Report/BuktiPotonganPajakPekerja/C_BuktiPotonganPajakPekerja/$1';
$route['PayrollManagement/Report/BuktiPotonganPajakPekerja/(:any)/(:any)'] = 'PayrollManagement/Report/BuktiPotonganPajakPekerja/C_BuktiPotonganPajakPekerja/$1/$2';

$route['PayrollManagement/Report/RekapPembayaranJKN'] = 'PayrollManagement/Report/RekapPembayaranJKN/C_RekapPembayaranJKN';
$route['PayrollManagement/Report/RekapPembayaranJKN/(:any)'] = 'PayrollManagement/Report/RekapPembayaranJKN/C_RekapPembayaranJKN/$1';
$route['PayrollManagement/Report/RekapPembayaranJKN/(:any)/(:any)'] = 'PayrollManagement/Report/RekapPembayaranJKN/C_RekapPembayaranJKN/$1/$2';

$route['PayrollManagement/Report/SummaryKlaimGajiDept'] = 'PayrollManagement/Report/SummaryKlaimGajiDept/C_SummaryKlaimGajiDept';
$route['PayrollManagement/Report/SummaryKlaimGajiDept/(:any)'] = 'PayrollManagement/Report/SummaryKlaimGajiDept/C_SummaryKlaimGajiDept/$1';
$route['PayrollManagement/Report/SummaryKlaimGajiDept/(:any)/(:any)'] = 'PayrollManagement/Report/SummaryKlaimGajiDept/C_SummaryKlaimGajiDept/$1/$2';

$route['PayrollManagement/Report/RincianHutang'] = 'PayrollManagement/Report/RincianHutang/C_RincianHutang';
$route['PayrollManagement/Report/RincianHutang/(:any)'] = 'PayrollManagement/Report/RincianHutang/C_RincianHutang/$1';
$route['PayrollManagement/Report/RincianHutang/(:any)/(:any)'] = 'PayrollManagement/Report/RincianHutang/C_RincianHutang/$1/$2';

$route['PayrollManagement/Report'] = 'PayrollManagement/Report/C_Report';
$route['PayrollManagement/Report/(:any)'] = 'PayrollManagement/Report/C_Report/$1';
$route['PayrollManagement/Report/(:any)/(:any)'] = 'PayrollManagement/Report/C_Report/$1/$2';

$route['AccountPayables/KlikBCAChecking/Index'] 				= 'AccountPayables/C_KlikBCAChecking_Index';
$route['AccountPayables/KlikBCAChecking/Index/(:any)'] 			= 'AccountPayables/C_KlikBCAChecking_Index/$1';
$route['AccountPayables/KlikBCAChecking/Index/(:any)/(:any)'] 	= 'AccountPayables/C_KlikBCAChecking_Index/$1/$2';

$route['AccountPayables/KlikBCAChecking/Insert'] 				= 'AccountPayables/C_KlikBCAChecking_Insert';
$route['AccountPayables/KlikBCAChecking/Insert/(:any)'] 		= 'AccountPayables/C_KlikBCAChecking_Insert/$1';
$route['AccountPayables/KlikBCAChecking/Insert/(:any)/(:any)'] 	= 'AccountPayables/C_KlikBCAChecking_Insert/$1/$2';
$route['AccountPayables/KlikBCAChecking/Insert/(:any)/(:any)/(:any)'] 	= 'AccountPayables/C_KlikBCAChecking_Insert/$1/$2/$3';

$route['AccountPayables/KlikBCAChecking/Check'] 				= 'AccountPayables/C_KlikBCAChecking_Check';
$route['AccountPayables/KlikBCAChecking/Check/(:any)'] 			= 'AccountPayables/C_KlikBCAChecking_Check/$1';
$route['AccountPayables/KlikBCAChecking/Check/(:any)/(:any)'] 	= 'AccountPayables/C_KlikBCAChecking_Check/$1/$2';

$route['AccountPayables/PermintaanDana'] 				= 'AccountPayables/C_PermintaanDana';
$route['AccountPayables/PermintaanDana/(:any)'] 		= 'AccountPayables/C_PermintaanDana/$1';
$route['AccountPayables/PermintaanDana/(:any)/(:any)'] 	= 'AccountPayables/C_PermintaanDana/$1/$2';

$route['AccountPayables/Report/(:any)'] 						= 'AccountPayables/Report/C_Report/$1';
$route['AccountPayables/Report/(:any)/(:any)'] 					= 'AccountPayables/Report/C_Report/$1/$2';
$route['AccountPayables/Report/(:any)/(:any)/(:any)'] 			= 'AccountPayables/Report/C_Report/$1/$2/$3';

//---------------------------------------- ADM PELATIHAN ----------------------------------------
$route['ADMPelatihan'] 									= 'ADMPelatihan/C_ADMPelatihan';

$route['ADMPelatihan/MasterPackage'] 					= 'ADMPelatihan/C_MasterPackage';
$route['ADMPelatihan/MasterPackage/(:any)'] 			= 'ADMPelatihan/C_MasterPackage/$1';
$route['ADMPelatihan/MasterPackage/(:any)/(:any)'] 		= 'ADMPelatihan/C_MasterPackage/$1/$2';

$route['ADMPelatihan/MasterTraining'] 					= 'ADMPelatihan/C_MasterTraining';
$route['ADMPelatihan/MasterTraining/(:any)'] 			= 'ADMPelatihan/C_MasterTraining/$1';
$route['ADMPelatihan/MasterTraining/(:any)/(:any)'] 	= 'ADMPelatihan/C_MasterTraining/$1/$2';

$route['ADMPelatihan/MasterQuestionnaire'] 				= 'ADMPelatihan/C_MasterQuestionnaire';
$route['ADMPelatihan/MasterQuestionnaire/(:any)'] 		= 'ADMPelatihan/C_MasterQuestionnaire/$1';
$route['ADMPelatihan/MasterQuestionnaire/(:any)/(:any)']= 'ADMPelatihan/C_MasterQuestionnaire/$1/$2';
$route['ADMPelatihan/MasterQuestionnaire/(:any)/(:any)/(:any)']= 'ADMPelatihan/C_MasterQuestionnaire/$1/$2/$3';

$route['ADMPelatihan/InputQuestionnaire'] 				= 'ADMPelatihan/C_InputQuestionnaire';
$route['ADMPelatihan/InputQuestionnaire/(:any)'] 		= 'ADMPelatihan/C_InputQuestionnaire/$1';
$route['ADMPelatihan/InputQuestionnaire/(:any)/(:any)']	= 'ADMPelatihan/C_InputQuestionnaire/$1/$2';
$route['ADMPelatihan/InputQuestionnaire/(:any)/(:any)/(:any)']	= 'ADMPelatihan/C_InputQuestionnaire/$1/$2/$3';
$route['ADMPelatihan/InputQuestionnaire/(:any)/(:any)/(:any)/(:any)']	= 'ADMPelatihan/C_InputQuestionnaire/$1/$2/$3/$4';


$route['ADMPelatihan/MasterTrainer'] 					= 'ADMPelatihan/C_MasterTrainer';
$route['ADMPelatihan/MasterTrainer/(:any)'] 			= 'ADMPelatihan/C_MasterTrainer/$1';
$route['ADMPelatihan/MasterTrainer/(:any)/(:any)'] 		= 'ADMPelatihan/C_MasterTrainer/$1/$2';
$route['ADMPelatihan/MasterTrainer/(:any)/(:any)/(:any)'] 		= 'ADMPelatihan/C_MasterTrainer/$1/$2/$3';
$route['ADMPelatihan/MasterTrainer/(:any)/(:any)/(:any)/(:any)'] 		= 'ADMPelatihan/C_MasterTrainer/$1/$2/$3/$4';

$route['ADMPelatihan/MasterRoom'] 						= 'ADMPelatihan/C_MasterRoom';
$route['ADMPelatihan/MasterRoom/(:any)'] 				= 'ADMPelatihan/C_MasterRoom/$1';
$route['ADMPelatihan/MasterRoom/(:any)/(:any)']			= 'ADMPelatihan/C_MasterRoom/$1/$2';

$route['ADMPelatihan/MasterTrainingMaterial'] 						= 'ADMPelatihan/C_MasterMateri';
$route['ADMPelatihan/MasterTrainingMaterial/(:any)'] 				= 'ADMPelatihan/C_MasterMateri/$1';
$route['ADMPelatihan/MasterTrainingMaterial/(:any)/(:any)']			= 'ADMPelatihan/C_MasterMateri/$1/$2';

$route['ADMPelatihan/Penjadwalan'] 						= 'ADMPelatihan/C_Penjadwalan';
$route['ADMPelatihan/Penjadwalan/(:any)'] 				= 'ADMPelatihan/C_Penjadwalan/$1';
$route['ADMPelatihan/Penjadwalan/(:any)/(:any)'] 		= 'ADMPelatihan/C_Penjadwalan/$1/$2';
$route['ADMPelatihan/Penjadwalan/(:any)/(:any)/(:any)'] = 'ADMPelatihan/C_Penjadwalan/$1/$2/$3';

$route['ADMPelatihan/PenjadwalanPackage']				= 'ADMPelatihan/C_PenjadwalanPackage';
$route['ADMPelatihan/PenjadwalanPackage/(:any)']		= 'ADMPelatihan/C_PenjadwalanPackage/$1';
$route['ADMPelatihan/PenjadwalanPackage/(:any)/(:any)']	= 'ADMPelatihan/C_PenjadwalanPackage/$1/$2';

$route['ADMPelatihan/Record'] 							= 'ADMPelatihan/C_Record';
$route['ADMPelatihan/Record/(:any)'] 					= 'ADMPelatihan/C_Record/$1';
$route['ADMPelatihan/Record/(:any)/(:any)']				= 'ADMPelatihan/C_Record/$1/$2';
$route['ADMPelatihan/Record/(:any)/(:any)/(:any)']		= 'ADMPelatihan/C_Record/$1/$2/$3';

$route['ADMPelatihan/Report']							= 'ADMPelatihan/C_Report';
$route['ADMPelatihan/Report/Rekap']						= 'ADMPelatihan/C_Report/Rekap';
$route['ADMPelatihan/Report/Rekap/RekapTraining']		= 'ADMPelatihan/C_Report/RekapTraining';
$route['ADMPelatihan/Report/Rekap/PresentaseKehadiran']	= 'ADMPelatihan/C_Report/PresentaseKehadiran';
$route['ADMPelatihan/Report/Rekap/EfektivitasTraining']	= 'ADMPelatihan/C_Report/EfektivitasTraining';
$route['ADMPelatihan/Report/Rekap/GetDetailParticipant/(:any)']	= 'ADMPelatihan/C_Report/GetDetailParticipant/$1';
$route['ADMPelatihan/Report/(:any)']					= 'ADMPelatihan/C_Report/$1';
$route['ADMPelatihan/Report/(:any)/(:any)']				= 'ADMPelatihan/C_Report/$1/$2';
$route['ADMPelatihan/Report/(:any)/(:any)/(:any)']		= 'ADMPelatihan/C_Report/$1/$2/$3';

$route['ADMPelatihan/Cetak/Undangan']					= 'ADMPelatihan/C_Undangan';
$route['ADMPelatihan/Cetak/Undangan/(:any)']			= 'ADMPelatihan/C_Undangan/$1';
$route['ADMPelatihan/Cetak/Undangan/(:any)/(:any)']		= 'ADMPelatihan/C_Undangan/$1/$2';

$route['ADMPelatihan/Cetak/Daftarhadir'] 				= 'ADMPelatihan/C_DaftarHadir';
$route['ADMPelatihan/Cetak/Daftarhadir/(:any)'] 		= 'ADMPelatihan/C_DaftarHadir/$1';
$route['ADMPelatihan/Cetak/Daftarhadir/(:any)/(:any)'] 	= 'ADMPelatihan/C_DaftarHadir/$1/$2';

//---------------------------------------- JURNAL PELATIHAN ----------------------------------------
// dashboard
$route['JurnalPenilaian'] 								= 'JurnalPenilaian/C_JurnalPenilaian';

// master unit group detail
$route['PenilaianKinerja/MasterUnitGroupDetail']						= 'JurnalPenilaian/C_MasterUnitGroupDetail';
$route['PenilaianKinerja/MasterUnitGroupDetail/(:any)']					= 'JurnalPenilaian/C_MasterUnitGroupDetail/$1';
$route['PenilaianKinerja/MasterUnitGroupDetail/(:any)/(:any)']			= 'JurnalPenilaian/C_MasterUnitGroupDetail/$1/$2';
$route['PenilaianKinerja/MasterUnitGroupDetail/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterUnitGroupDetail/$1/$2/$3';

// master unit group
$route['PenilaianKinerja/MasterUnitGroup']						= 'JurnalPenilaian/C_MasterUnitGroup';
$route['PenilaianKinerja/MasterUnitGroup/(:any)']				= 'JurnalPenilaian/C_MasterUnitGroup/$1';
$route['PenilaianKinerja/MasterUnitGroup/(:any)/(:any)']		= 'JurnalPenilaian/C_MasterUnitGroup/$1/$2';
$route['PenilaianKinerja/MasterUnitGroup/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterUnitGroup/$1/$2/$3';

// master range nilai
$route['PenilaianKinerja/MasterRangeNilai']							= 'JurnalPenilaian/C_MasterRangeNilai';
$route['PenilaianKinerja/MasterRangeNilai/(:any)']					= 'JurnalPenilaian/C_MasterRangeNilai/$1';
$route['PenilaianKinerja/MasterRangeNilai/(:any)/(:any)']			= 'JurnalPenilaian/C_MasterRangeNilai/$1/$2';
$route['PenilaianKinerja/MasterRangeNilai/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterRangeNilai/$1/$2/$3';

// master tim
$route['PenilaianKinerja/MasterTIM']							= 'JurnalPenilaian/C_MasterTIM';
$route['PenilaianKinerja/MasterTIM/(:any)']						= 'JurnalPenilaian/C_MasterTIM/$1';
$route['PenilaianKinerja/MasterTIM/(:any)/(:any)']				= 'JurnalPenilaian/C_MasterTIM/$1/$2';
$route['PenilaianKinerja/MasterTIM/(:any)/(:any)/(:any)']		= 'JurnalPenilaian/C_MasterTIM/$1/$2/$3';

// master kategori penilaian
$route['PenilaianKinerja/MasterKategoriPenilaian']						= 'JurnalPenilaian/C_MasterKategoriPenilaian';
$route['PenilaianKinerja/MasterKategoriPenilaian/(:any)']				= 'JurnalPenilaian/C_MasterKategoriPenilaian/$1';
$route['PenilaianKinerja/MasterKategoriPenilaian/(:any)/(:any)']		= 'JurnalPenilaian/C_MasterKategoriPenilaian/$1/$2';
$route['PenilaianKinerja/MasterKategoriPenilaian/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterKategoriPenilaian/$1/$2/$3';

// master surat peringatan
$route['PenilaianKinerja/MasterSuratPeringatan']					= 'JurnalPenilaian/C_MasterSuratPeringatan';
$route['PenilaianKinerja/MasterSuratPeringatan/(:any)']				= 'JurnalPenilaian/C_MasterSuratPeringatan/$1';
$route['PenilaianKinerja/MasterSuratPeringatan/(:any)/(:any)']		= 'JurnalPenilaian/C_MasterSuratPeringatan/$1/$2';
$route['PenilaianKinerja/MasterSuratPeringatan/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterSuratPeringatan/$1/$2/$3';

// master bobot
$route['PenilaianKinerja/MasterBobot']						= 'JurnalPenilaian/C_MasterBobot';
$route['PenilaianKinerja/MasterBobot/(:any)']				= 'JurnalPenilaian/C_MasterBobot/$1';
$route['PenilaianKinerja/MasterBobot/(:any)/(:any)']		= 'JurnalPenilaian/C_MasterBobot/$1/$2';
$route['PenilaianKinerja/MasterBobot/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterBobot/$1/$2/$3';

// master golongan
$route['PenilaianKinerja/MasterGolongan']						= 'JurnalPenilaian/C_MasterGolongan';
$route['PenilaianKinerja/MasterGolongan/(:any)']				= 'JurnalPenilaian/C_MasterGolongan/$1';
$route['PenilaianKinerja/MasterGolongan/(:any)/(:any)']			= 'JurnalPenilaian/C_MasterGolongan/$1/$2';
$route['PenilaianKinerja/MasterGolongan/(:any)/(:any)/(:any)']	= 'JurnalPenilaian/C_MasterGolongan/$1/$2/$3';

// Jurnal Penilaian Report Seksi
$route['PenilaianKinerja/ReportSeksiPersonalia']		= 'JurnalPenilaian/C_ReportSeksiPersonalia';

// Jurnal Penilaian Personalia
$route['PenilaianKinerja/JurnalPenilaianPersonalia']		= 'JurnalPenilaian/C_JurnalPenilaianPersonalia';
$route['PenilaianKinerja/JurnalPenilaianPersonalia/(:any)']	= 'JurnalPenilaian/C_JurnalPenilaianPersonalia/$1';
$route['PenilaianKinerja/JurnalPenilaianPersonalia/(:any)/(:any)']	= 'JurnalPenilaian/C_JurnalPenilaianPersonalia/$1/$2';

// Jurnal Penilaian Evaluator
$route['PenilaianKinerja/JurnalPenilaianEvaluator']		= 'JurnalPenilaian/C_JurnalPenilaianEvaluator';

//------------------------------------External Claim.begin---------------------------------------------------
$route['SalesOrder/BranchApproval'] 						= 'CustomerRelationship/MainMenu/C_BranchApproval/index';
$route['SalesOrder/BranchApproval/NewClaims'] 				= 'CustomerRelationship/MainMenu/C_BranchApproval/newClaim';
$route['SalesOrder/BranchApproval/NewClaims/Action/(:any)'] = 'CustomerRelationship/MainMenu/C_BranchApproval/action/$1';
$route['SalesOrder/BranchApproval/NewClaims/Edit/(:any)'] 	= 'CustomerRelationship/MainMenu/C_CentralApproval/editNewClaim/$1';
$route['SalesOrder/BranchApproval/NewClaims/Save'] 			= 'CustomerRelationship/MainMenu/C_CentralApproval/saveEdit';
$route['SalesOrder/BranchApproval/ClaimApproved'] 			= 'CustomerRelationship/MainMenu/C_BranchApproval/ClaimApproved';
$route['SalesOrder/BranchApproval/Over24Hour'] 				= 'CustomerRelationship/MainMenu/C_BranchApproval/Over24Hour';
$route['SalesOrder/BranchApproval/ClaimClosed'] 			= 'CustomerRelationship/MainMenu/C_BranchApproval/ClaimClosed';

$route['SalesOrder/CentralApproval'] 					= 'CustomerRelationship/MainMenu/C_CentralApproval/index';
$route['SalesOrder/CentralApproval/ShowPict/(:any)'] 	= 'CustomerRelationship/MainMenu/C_CentralApproval/ShowPict/$1';
$route['SalesOrder/CentralApproval/ClaimApproved'] 		= 'CustomerRelationship/MainMenu/C_CentralApproval/ClaimApproved';
$route['SalesOrder/CentralApproval/Print/(:any)'] 		= 'CustomerRelationship/MainMenu/C_CentralApproval/claimToQA/$1';
$route['SalesOrder/CentralApproval/Close/(:any)'] 		= 'CustomerRelationship/MainMenu/C_CentralApproval/claimAnswer/$1';
//------------------------------------External Claim.end-----------------------------------------------------

//----------------------------------Account Receivables.begin----------------------------------------------
$route['AccountReceivables'] = 'AccountReceivables/C_AccountReceivables/index';
$route['AccountReceivables/CreditLimit'] = 'AccountReceivables/C_AccountReceivables/creditLimit';
$route['AccountReceivables/CreditLimit/New'] = 'AccountReceivables/CreditLimit/C_CreditLimit/newData';
$route['AccountReceivables/CreditLimit/New/Branch'] = 'AccountReceivables/CreditLimit/C_CreditLimit/Branch';
$route['AccountReceivables/CreditLimit/New/Cust'] = 'AccountReceivables/CreditLimit/C_CreditLimit/Cust';
$route['AccountReceivables/CreditLimit/New/Account'] = 'AccountReceivables/CreditLimit/C_CreditLimit/Account';
$route['AccountReceivables/CreditLimit/New/PartyID'] = 'AccountReceivables/CreditLimit/C_CreditLimit/PartyID';
$route['AccountReceivables/CreditLimit/New/PartyNumber'] = 'AccountReceivables/CreditLimit/C_CreditLimit/PartyNumber';
$route['AccountReceivables/CreditLimit/Save'] = 'AccountReceivables/CreditLimit/C_CreditLimit/saveData';
$route['AccountReceivables/CreditLimit/Edit/(:any)/(:any)'] = 'AccountReceivables/CreditLimit/C_CreditLimit/Edit/$1/$2';
$route['AccountReceivables/CreditLimit/Edit/Save'] = 'AccountReceivables/CreditLimit/C_CreditLimit/EditSave';
$route['AccountReceivables/CreditLimit/Delete/(:any)'] = 'AccountReceivables/CreditLimit/C_CreditLimit/Delete/$1';
//----------------------------------Account Receivables.end------------------------------------------------


//-----------------------Payroll Management Non Staff --------------------------------------------
$route['PayrollManagementNonStaff'] = 'PayrollManagementNonStaff/C_PayrollManagementNonStaff';
$route['PayrollManagementNonStaff/(:any)'] = 'PayrollManagementNonStaff/C_PayrollManagementNonStaff/$1';
$route['PayrollManagementNonStaff/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_PayrollManagementNonStaff/$1/$2';

//Data Absensi
$route['PayrollManagementNonStaff/ProsesGaji/DataAbsensi'] = 'PayrollManagementNonStaff/C_DataAbsensi';
$route['PayrollManagementNonStaff/ProsesGaji/DataAbsensi/(:any)'] = 'PayrollManagementNonStaff/C_DataAbsensi/$1';
$route['PayrollManagementNonStaff/ProsesGaji/DataAbsensi/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_DataAbsensi/$1/$2';
$route['PayrollManagementNonStaff/ProsesGaji/DataAbsensi/(:any)/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_DataAbsensi/$1/$2/$3';

//Data LKH Seksi
$route['PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi'] = 'PayrollManagementNonStaff/C_DataLKHSeksi';
$route['PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/(:any)'] = 'PayrollManagementNonStaff/C_DataLKHSeksi/$1';
$route['PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_DataLKHSeksi/$1/$2';
$route['PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/(:any)/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_DataLKHSeksi/$1/$2/$3';

//Insentif Kondite
$route['PayrollManagementNonStaff/ProsesGaji/Kondite'] = 'PayrollManagementNonStaff/C_Kondite';
$route['PayrollManagementNonStaff/ProsesGaji/Kondite/(:any)'] = 'PayrollManagementNonStaff/C_Kondite/$1';
$route['PayrollManagementNonStaff/ProsesGaji/Kondite/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_Kondite/$1/$2';

//Input Tambahan
$route['PayrollManagementNonStaff/ProsesGaji/Tambahan'] = 'PayrollManagementNonStaff/C_Tambahan';
$route['PayrollManagementNonStaff/ProsesGaji/Tambahan/(:any)'] = 'PayrollManagementNonStaff/C_Tambahan/$1';
$route['PayrollManagementNonStaff/ProsesGaji/Tambahan/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_Tambahan/$1/$2';

//Input Potongan
$route['PayrollManagementNonStaff/ProsesGaji/Potongan'] = 'PayrollManagementNonStaff/C_Potongan';
$route['PayrollManagementNonStaff/ProsesGaji/Potongan/(:any)'] = 'PayrollManagementNonStaff/C_Potongan/$1';
$route['PayrollManagementNonStaff/ProsesGaji/Potongan/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_Potongan/$1/$2';

//Hitung Gaji
$route['PayrollManagementNonStaff/ProsesGaji/HitungGaji'] = 'PayrollManagementNonStaff/C_HitungGaji';
$route['PayrollManagementNonStaff/ProsesGaji/HitungGaji/(:any)'] = 'PayrollManagementNonStaff/C_HitungGaji/$1';
$route['PayrollManagementNonStaff/ProsesGaji/HitungGaji/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_HitungGaji/$1/$2';
$route['PayrollManagementNonStaff/ProsesGaji/HitungGaji/(:any)/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_HitungGaji/$1/$2/$3';
$route['PayrollManagementNonStaff/ProsesGaji/HitungGaji/(:any)/(:any)/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_HitungGaji/$1/$2/$3/$4';

//Data Absensi
$route['PayrollManagementNonStaff/ImportDBF'] = 'PayrollManagementNonStaff/C_ImportDBF';
$route['PayrollManagementNonStaff/ImportDBF/(:any)'] = 'PayrollManagementNonStaff/C_ImportDBF/$1';
$route['PayrollManagementNonStaff/ImportDBF/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_ImportDBF/$1/$2';

//Master Data Gaji
$route['PayrollManagementNonStaff/MasterData/DataGaji'] = 'PayrollManagementNonStaff/C_MasterGaji';
$route['PayrollManagementNonStaff/MasterData/DataGaji/(:any)'] = 'PayrollManagementNonStaff/C_MasterGaji/$1';
$route['PayrollManagementNonStaff/MasterData/DataGaji/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_MasterGaji/$1/$2';

//Master Data Target
$route['PayrollManagementNonStaff/MasterData/TargetBenda'] = 'PayrollManagementNonStaff/C_TargetBenda';
$route['PayrollManagementNonStaff/MasterData/TargetBenda/(:any)'] = 'PayrollManagementNonStaff/C_TargetBenda/$1';
$route['PayrollManagementNonStaff/MasterData/TargetBenda/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_TargetBenda/$1/$2';

//Master Pekerja
$route['PayrollManagementNonStaff/MasterData/MasterPekerja'] = 'PayrollManagementNonStaff/C_MasterPekerja';
$route['PayrollManagementNonStaff/MasterData/MasterPekerja/(:any)'] = 'PayrollManagementNonStaff/C_MasterPekerja/$1';
$route['PayrollManagementNonStaff/MasterData/MasterPekerja/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_MasterPekerja/$1/$2';

//Setelan
$route['PayrollManagementNonStaff/Setelan'] = 'PayrollManagementNonStaff/C_Setelan';
$route['PayrollManagementNonStaff/Setelan/(:any)'] = 'PayrollManagementNonStaff/C_Setelan/$1';
$route['PayrollManagementNonStaff/Setelan/(:any)/(:any)'] = 'PayrollManagementNonStaff/C_Setelan/$1/$2';



//-----------------------Payroll Management Non Staff --------------------------------------------


$route['(:any)'] = 'C_Index/$1';
$route['(:any)/(:any)'] = 'C_Index/$1/$2';

//------------------------------------ Quick Data Cat -----------------------------------------------------
$route['QuickDataCat'] = 'QuickDataCat/C_QuickDataCat';
$route['QuickDataCat/DataCatMasuk'] = 'QuickDataCat/MainMenu/C_DataCatMasuk';
$route['QuickDataCat/DataCatMasuk/(:any)'] = 'QuickDataCat/MainMenu/C_DataCatMasuk/$1';

$route['QuickDataCat/DataCatKeluar'] = 'QuickDataCat/MainMenu/C_DataCatKeluar';
$route['QuickDataCat/DataCatKeluar/(:any)'] = 'QuickDataCat/MainMenu/C_DataCatKeluar/$1';

$route['QuickDataCat/LihatStokCat'] = 'QuickDataCat/MainMenu/C_StokCat';
$route['QuickDataCat/LihatStokCat/(:any)'] = 'QuickDataCat/MainMenu/C_StokCat/$1';

$route['QuickDataCat/LihatStokOnHand'] = 'QuickDataCat/MainMenu/C_StokOnHand';
$route['QuickDataCat/LihatStokOnHand/(:any)'] = 'QuickDataCat/MainMenu/C_StokOnHand/$1';

//------------------------------------ Monitoring Komponen Simpan Barang Gudang ----------------------------
$route['MonitoringKomponen'] = 'MonitoringKomponen/C_MonitoringKomponen';
$route['MonitoringKomponen/Monitoring'] = 'MonitoringKomponen/MainMenu/C_Monitoring';
$route['MonitoringKomponen/Monitoring/(:any)'] = 'MonitoringKomponen/MainMenu/C_Monitoring/$1';
$route['MonitoringKomponen/Monitoring/(:any)/(:any)'] = 'MonitoringKomponen/MainMenu/C_Monitoring/$1/$2';

$route['MonitoringKomponen/MonitoringSeksi'] = 'MonitoringKomponen/MainMenu/C_Monitoring_Seksi';
$route['MonitoringKomponen/MonitoringSeksi/(:any)'] = 'MonitoringKomponen/MainMenu/C_Monitoring_Seksi/$1';
$route['MonitoringKomponen/MonitoringSeksi/(:any)/(:any)'] = 'MonitoringKomponen/MainMenu/C_Monitoring_Seksi/$1/$2';
//------------------------------------ Grapic ----------------------------------------
$route['SDM/(:any)'] = 'Grapic/C_Index/$1';
$route['SDM/(:any)/(:any)'] = 'Grapic/C_Index/$1/$2';
$route['SDM/Grapic'] = 'Grapic/C_Index';
$route['SDM/grapicTabs'] = 'Grapic/C_Index/grapicTabs';
$route['SDM/getData'] = 'Grapic/C_Index/getData';
$route['SDM/getDatav2'] = 'Grapic/C_Index/getDatav2';
$route['SDM/input'] = 'Grapic/C_Index/input';
$route['SDM/inputv2'] = 'Grapic/C_Index/inputv2';
$route['SDM/openPDF'] = 'Grapic/C_Index/openPDF';


//------------------------------------ Management Kebutuhan Pekerja ----------------------------------------
$route['ItemManagement'] = 'ItemManagement/C_Index/index';
$route['ItemManagement/MasterItem']  = 'ItemManagement/Admin/C_MasterItem/index';
$route['ItemManagement/MasterItem/(:any)']  = 'ItemManagement/Admin/C_MasterItem/$1';
$route['ItemManagement/MasterItem/(:any)/(:any)']  = 'ItemManagement/Admin/C_MasterItem/$1/$2';
$route['ItemManagement/SetupKebutuhan']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhan/index';
$route['ItemManagement/SetupKebutuhan/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhan/$1';
$route['ItemManagement/SetupKebutuhan/Kodesie']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanKodesie/index';
$route['ItemManagement/SetupKebutuhan/Kodesie/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanKodesie/$1';
$route['ItemManagement/SetupKebutuhan/Kodesie/(:any)/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanKodesie/$1/$2';
$route['ItemManagement/SetupKebutuhan/Kodesie/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanKodesie/$1/$2/$3';
$route['ItemManagement/SetupKebutuhan/Kodesie/(:any)/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanKodesie/$1/$2/$3/$4';
$route['ItemManagement/SetupKebutuhan/Individu']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanIndv/index';
$route['ItemManagement/SetupKebutuhan/Individu/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanIndv/$1';
$route['ItemManagement/SetupKebutuhan/Individu/(:any)/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanIndv/$1/$2';
$route['ItemManagement/SetupKebutuhan/Individu/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanIndv/$1/$2/$3';
$route['ItemManagement/SetupKebutuhan/Individu/(:any)/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/SetupKebutuhan/C_SetupKebutuhanIndv/$1/$2/$3/$4';
$route['ItemManagement/Hitung/HitungKebutuhan']  = 'ItemManagement/Admin/Hitung/C_HitungKebutuhan/index';
$route['ItemManagement/Hitung/HitungKebutuhan/(:any)']  = 'ItemManagement/Admin/Hitung/C_HitungKebutuhan/$1';
$route['ItemManagement/Hitung/HitungKebutuhan/(:any)/(:any)']  = 'ItemManagement/Admin/Hitung/C_HitungKebutuhan/$1/$2';
$route['ItemManagement/Hitung/HitungKebutuhan/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/Hitung/C_HitungKebutuhan/$1/$2/$3';
$route['ItemManagement/Hitung/HitungKebutuhan/(:any)/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/Hitung/C_HitungKebutuhan/$1/$2/$3/$4';
$route['ItemManagement/Hitung/MonitoringKebutuhan']  = 'ItemManagement/Admin/Hitung/C_MonitoringKebutuhan/index';
$route['ItemManagement/Hitung/MonitoringKebutuhan/(:any)']  = 'ItemManagement/Admin/Hitung/C_MonitoringKebutuhan/$1';
$route['ItemManagement/Hitung/MonitoringKebutuhan/(:any)/(:any)']  = 'ItemManagement/Admin/Hitung/C_MonitoringKebutuhan/$1/$2';
$route['ItemManagement/Hitung/MonitoringKebutuhan/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/Hitung/C_MonitoringKebutuhan/$1/$2/$3';
$route['ItemManagement/Hitung/MonitoringKebutuhan/(:any)/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/Hitung/C_MonitoringKebutuhan/$1/$2/$3/$4';
$route['ItemManagement/MonitoringBon']  = 'ItemManagement/Admin/C_MonitoringBon/index';
$route['ItemManagement/MonitoringBon/(:any)']  = 'ItemManagement/Admin/C_MonitoringBon/$1';
$route['ItemManagement/MonitoringBon/(:any)/(:any)']  = 'ItemManagement/Admin/C_MonitoringBon/$1/$2';
$route['ItemManagement/MonitoringBon/(:any)/(:any)/(:any)']  = 'ItemManagement/Admin/C_MonitoringBon/$1/$2/$3';
$route['ItemManagement/User/MonitoringBon']  = 'ItemManagement/User/C_MonitoringBon/index';
$route['ItemManagement/User/MonitoringBon/(:any)']  = 'ItemManagement/User/C_MonitoringBon/$1';
$route['ItemManagement/User/MonitoringBon/(:any)/(:any)']  = 'ItemManagement/User/C_MonitoringBon/$1/$2';
$route['ItemManagement/User/MonitoringBon/(:any)/(:any)/(:any)']  = 'ItemManagement/User/C_MonitoringBon/$1/$2/$3';
$route['ItemManagement/User/InputPekerja']  = 'ItemManagement/User/C_InputPekerja/index';
$route['ItemManagement/User/InputPekerja/(:any)']  = 'ItemManagement/User/C_InputPekerja/$1';
$route['ItemManagement/User/InputPekerja/(:any)/(:any)']  = 'ItemManagement/User/C_InputPekerja/$1/$2';
$route['ItemManagement/User/InputPekerja/(:any)/(:any)/(:any)']  = 'ItemManagement/User/C_InputPekerja/$1/$2/$3';
$route['ItemManagement/User/InputPekerja/(:any)/(:any)/(:any)/(:any)']  = 'ItemManagement/User/C_InputPekerja/$1/$2/$3/$4';

//------------------------------------ MANAGEMENT ORDER --------------------------------------------
$route['ManagementOrder'] = 'ManagementOrder/C_ManagementOrder';
$route['ManagementOrder/Order_In'] = 'ManagementOrder/MainMenu/C_Order_In/index';
$route['ManagementOrder/Order_In/(:any)'] = 'ManagementOrder/MainMenu/C_Order_In/$1';
$route['ManagementOrder/Order_In/(:any)/(:any)'] = 'ManagementOrder/MainMenu/C_Order_In/$1/$2';
$route['ManagementOrder/Member'] = 'ManagementOrder/MainMenu/C_Member/index';
$route['ManagementOrder/Member/(:any)'] = 'ManagementOrder/MainMenu/C_Member/$1';
$route['ManagementOrder/Member/(:any)/(:any)'] = 'ManagementOrder/MainMenu/C_Member/$1/$2';
$route['ManagementOrder/Setting'] = 'ManagementOrder/MainMenu/C_Setting/index';
$route['ManagementOrder/Setting/(:any)'] = 'ManagementOrder/MainMenu/C_Setting/$1';
$route['ManagementOrder/Setting/(:any)/(:any)'] = 'ManagementOrder/MainMenu/C_Setting/$1/$2';
$route['ManagementOrder/Kaizen'] = 'ManagementOrder/MainMenu/C_Kaizen/index';
$route['ManagementOrder/Kaizen/(:any)'] = 'ManagementOrder/MainMenu/C_Kaizen/$1';
$route['ManagementOrder/Kaizen/(:any)/(:any)'] = 'ManagementOrder/MainMenu/C_Kaizen/$1/$2';
$route['ManagementOrder/Scheduler'] = 'ManagementOrder/MainMenu/C_Scheduler/index';
$route['ManagementOrder/Scheduler/(:any)'] = 'ManagementOrder/MainMenu/C_Scheduler/$1';
$route['ManagementOrder/Scheduler/(:any)/(:any)'] = 'ManagementOrder/MainMenu/C_Scheduler/$1/$2';

//-------------------------WasteManagement-Limbah------------------------------------------------//
$route['WasteManagement/Limbah'] = 'WasteManagement/MainMenu/C_Limbah';
$route['WasteManagement/Limbah/(:any)'] = 'WasteManagement/MainMenu/C_Limbah/$1';
$route['WasteManagement/Limbah/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_Limbah/$1/$2';
$route['WasteManagement/Limbah/Report'] =  'WasteManagement/MainMenu/C_Limbah/Report';
$route['WasteManagement/Limbah/Record'] = 'WasteManagement/MainMenu/C_Limbah/Record';

//-----------------------WasteManagement-TransaksiLimbah-----------------------------------------//
$route['WasteManagement/LimbahTransaksi'] = 'WasteManagement/MainMenu/C_LimbahTransaksi';
$route['WasteManagement/LimbahTransaksi/(:any)'] = 'WasteManagement/MainMenu/C_LimbahTransaksi/$1';
$route['WasteManagement/LimbahTransaksi/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahTransaksi/$1/$2';
$route['WasteManagement/LimbahTransaksi/(:any)/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahTransaksi/$1/$2/$3';
$route['WasteManagement/LimbahTransaksi/ReportHarian'] = 'WasteManagement/MainMenu/C_LimbahTransaksi/ReportHarian';
$route['WasteManagement/LimbahTransaksi/ReportBulanan'] = 'WasteManagement/MainMenu/C_LimbahTransaksi/ReportBulanan';
$route['WasteManagement/LimbahTransaksi/Record'] = 'WasteManagement/MainMenu/C_LimbahTransaksi/Record';

//----------------------------WasteManagement-TransaksiLimbahKeluar---------------------------------//
$route['WasteManagement/LimbahKeluar'] = 'WasteManagement/MainMenu/C_LimbahKeluar';
$route['WasteManagement/LimbahKeluar/(:any)'] = 'WasteManagement/MainMenu/C_LimbahKeluar/$1';
$route['WasteManagement/LimbahKeluar/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahKeluar/$1/$2';
$route['WasteManagement/LimbahKeluar/(:any)/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahKeluar/$1/$2/$3';
$route['WasteManagement/LimbahKeluar/Report'] = 'WasteManagement/MainMenu/C_LimbahKeluar/Report';
$route['WasteManagement/LimbahKeluar/Record'] = 'WasteManagement/MainMenu/C_LimbahKeluar/Record';

//-------------------------------Waste Management-----------------------------------------//
$route['WasteManagement'] = 'WasteManagement/C_WasteManagement';

//--------------------------------Waste Management - Master-----------------------------------//
$route['WasteManagement/MasterData'] 				= 'WasteManagement/MainMenu/C_LimbahMaster';
$route['WasteManagement/MasterData/(:any)'] 		= 'WasteManagement/MainMenu/C_LimbahMaster/$1';
$route['WasteManagement/MasterData/(:any)/(:any)'] 	= 'WasteManagement/MainMenu/C_LimbahMaster/$1/$2';

$route['WasteManagement/LimbahJenis'] 				= 'WasteManagement/MainMenu/C_LimbahJenis';
$route['WasteManagement/LimbahJenis/(:any)'] 		= 'WasteManagement/MainMenu/C_LimbahJenis/$1';
$route['WasteManagement/LimbahJenis/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahJenis/$1/$2';

$route['WasteManagement/LimbahPerlakuan'] 				= 'WasteManagement/MainMenu/C_LimbahPerlakuan';
$route['WasteManagement/LimbahPerlakuan/(:any)'] 		= 'WasteManagement/MainMenu/C_LimbahPerlakuan/$1';
$route['WasteManagement/LimbahPerlakuan/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahPerlakuan/$1/$2';

$route['WasteManagement/LimbahSatuan'] 				 = 'WasteManagement/MainMenu/C_LimbahSatuan';
$route['WasteManagement/LimbahSatuan/(:any)'] 		 = 'WasteManagement/MainMenu/C_LimbahSatuan/$1';
$route['WasteManagement/LimbahSatuan/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahSatuan/$1/$2';

//--------------------------------------Waste Management - Kelola limbah-------------------------------------//
$route['WasteManagement/KirimanMasuk'] = 'WasteManagement/MainMenu/C_LimbahKelola';
$route['WasteManagement/KirimanMasuk/(:any)'] = 'WasteManagement/MainMenu/C_LimbahKelola/$1';
$route['WasteManagement/KirimanMasuk/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahKelola/$1/$2';
$route['WasteManagement/KirimanMasuk/(:any)/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahKelola/$1/$2/$3';
$route['WasteManagement/Simple'] = 'WasteManagement/MainMenu/C_Simple';
$route['WasteManagement/Simple/(:any)'] = 'WasteManagement/MainMenu/C_Simple/$1';
$route['WasteManagement/Simple/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_Simple/$1/$2';
$route['WasteManagement/Simple/(:any)/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_Simple/$1/$2/$3';

//-----------------------------------------Waste Management - Rekap Limbah ---------------------------------//

$route['WasteManagement/RekapLimbah'] = 'WasteManagement/MainMenu/C_LimbahRekap';
$route['WasteManagement/RekapLimbah/(:any)'] = 'WasteManagement/MainMenu/C_LimbahRekap/$1';
$route['WasteManagement/RekapLimbah/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahRekap/$1/$2';
$route['WasteManagement/RekapLimbah/(:any)/(:any)/(:any)'] = 'WasteManagement/MainMenu/C_LimbahRekap/$1/$2/$3';

//------------------------------------ Calibration Report ----------------------------
$route['CalibrationReport'] = 'CalibrationReport/C_Index';
$route['CalibrationReport/Calibration'] = 'CalibrationReport/MainMenu/C_Component';
$route['CalibrationReport/Calibration/(:any)'] = 'CalibrationReport/MainMenu/C_Component/$1';
$route['CalibrationReport/Calibration/(:any)/(:any)'] = 'CalibrationReport/MainMenu/C_Component/$1/$2';

//------------------------------------ General Affair Kendaraan ------------------------------------------//
$route['GeneralAffair/FleetJenisKendaraan'] = 'GeneralAffair/MainMenu/C_FleetJenisKendaraan';
$route['GeneralAffair/FleetJenisKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetJenisKendaraan/$1';
$route['GeneralAffair/FleetJenisKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetJenisKendaraan/$1/$2';
$route['GeneralAffair/FleetMerkKendaraan'] = 'GeneralAffair/MainMenu/C_FleetMerkKendaraan';
$route['GeneralAffair/FleetMerkKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMerkKendaraan/$1';
$route['GeneralAffair/FleetMerkKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMerkKendaraan/$1/$2';
$route['GeneralAffair/FleetWarnaKendaraan'] = 'GeneralAffair/MainMenu/C_FleetWarnaKendaraan';
$route['GeneralAffair/FleetWarnaKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetWarnaKendaraan/$1';
$route['GeneralAffair/FleetWarnaKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetWarnaKendaraan/$1/$2';
$route['GeneralAffair/FleetKendaraan'] = 'GeneralAffair/MainMenu/C_FleetKendaraan';
$route['GeneralAffair/FleetKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKendaraan/$1';
$route['GeneralAffair/FleetKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKendaraan/$1/$2';
$route['GeneralAffair/FleetPajak'] = 'GeneralAffair/MainMenu/C_FleetPajak';
$route['GeneralAffair/FleetPajak/(:any)'] = 'GeneralAffair/MainMenu/C_FleetPajak/$1';
$route['GeneralAffair/FleetPajak/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetPajak/$1/$2';
$route['GeneralAffair/FleetKir'] = 'GeneralAffair/MainMenu/C_FleetKir';
$route['GeneralAffair/FleetKir/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKir/$1';
$route['GeneralAffair/FleetKir/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKir/$1/$2';
$route['GeneralAffair/FleetPicKendaraan'] = 'GeneralAffair/MainMenu/C_FleetPicKendaraan';
$route['GeneralAffair/FleetPicKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetPicKendaraan/$1';
$route['GeneralAffair/FleetPicKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetPicKendaraan/$1/$2';
$route['GeneralAffair/FleetMaintenanceKategori'] = 'GeneralAffair/MainMenu/C_FleetMaintenanceKategori';
$route['GeneralAffair/FleetMaintenanceKategori/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMaintenanceKategori/$1';
$route['GeneralAffair/FleetMaintenanceKategori/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMaintenanceKategori/$1/$2';
$route['GeneralAffair/FleetMaintenanceKendaraan'] = 'GeneralAffair/MainMenu/C_FleetMaintenanceKendaraan';
$route['GeneralAffair/FleetMaintenanceKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMaintenanceKendaraan/$1';
$route['GeneralAffair/FleetMaintenanceKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMaintenanceKendaraan/$1/$2';
$route['GeneralAffair/FleetKecelakaanDetail'] = 'GeneralAffair/MainMenu/C_FleetKecelakaanDetail';
$route['GeneralAffair/FleetKecelakaanDetail/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKecelakaanDetail/$1';
$route['GeneralAffair/FleetKecelakaanDetail/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKecelakaanDetail/$1/$2';
$route['GeneralAffair/FleetKecelakaan'] = 'GeneralAffair/MainMenu/C_FleetKecelakaan';
$route['GeneralAffair/FleetKecelakaan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKecelakaan/$1';
$route['GeneralAffair/FleetKecelakaan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetKecelakaan/$1/$2';

$route['GeneralAffair/FleetMonitoring'] 			= 'GeneralAffair/MainMenu/C_FleetMonitoring';
$route['GeneralAffair/FleetMonitoring/(:any)']		= 'GeneralAffair/MainMenu/C_FleetMonitoring/$1';

$route['GeneralAffair/FleetMonitoringLast'] 			= 'GeneralAffair/MainMenu/C_FleetMonitoringLast';
$route['GeneralAffair/FleetMonitoringLast/(:any)']		= 'GeneralAffair/MainMenu/C_FleetMonitoringLast/$1';

$route['GeneralAffair/FleetRekapPajak'] 			= 'GeneralAffair/MainMenu/C_FleetRekapPajak';
$route['GeneralAffair/FleetRekapPajak/(:any)']		= 'GeneralAffair/MainMenu/C_FleetRekapPajak/$1';

$route['GeneralAffair/FleetRekapKIR'] 				= 'GeneralAffair/MainMenu/C_FleetRekapKIR';
$route['GeneralAffair/FleetRekapKIR/(:any)']		= 'GeneralAffair/MainMenu/C_FleetRekapKIR/$1';

$route['GeneralAffair/FleetRekapMaintenance'] 				= 'GeneralAffair/MainMenu/C_FleetRekapMaintenance';
$route['GeneralAffair/FleetRekapMaintenance/(:any)']		= 'GeneralAffair/MainMenu/C_FleetRekapMaintenance/$1';

$route['GeneralAffair/FleetRekapKecelakaan'] 				= 'GeneralAffair/MainMenu/C_FleetRekapKecelakaan';
$route['GeneralAffair/FleetRekapKecelakaan/(:any)']			= 'GeneralAffair/MainMenu/C_FleetRekapKecelakaan/$1';

$route['GeneralAffair/FleetRekapTotal'] 				= 'GeneralAffair/MainMenu/C_FleetRekapTotal';
$route['GeneralAffair/FleetRekapTotal/(:any)']			= 'GeneralAffair/MainMenu/C_FleetRekapTotal/$1';

$route['GeneralAffair/FleetBengkel']		= 'GeneralAffair/MainMenu/C_FleetBengkel';
$route['GeneralAffair/FleetBengkel/(:any)']		= 'GeneralAffair/MainMenu/C_FleetBengkel/$1';
$route['GeneralAffair/FleetBengkel/(:any)/(:any)']		= 'GeneralAffair/MainMenu/C_FleetBengkel/$1/$2';

$route['GeneralAffair/FleetCetakSpk'] = 'GeneralAffair/MainMenu/C_FleetCetakSpk';
$route['GeneralAffair/FleetCetakSpk/(:any)'] = 'GeneralAffair/MainMenu/C_FleetCetakSpk/$1';
$route['GeneralAffair/FleetCetakSpk/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetCetakSpk/$1/$2';

$route['GeneralAffair/FleetJenisService'] = 'GeneralAffair/MainMenu/C_FleetJenisService';
$route['GeneralAffair/FleetJenisService/(:any)'] = 'GeneralAffair/MainMenu/C_FleetJenisService/$1';
$route['GeneralAffair/FleetJenisService/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetJenisService/$1/$2';

$route['GeneralAffair/FleetServiceKendaraan'] = 'GeneralAffair/MainMenu/C_FleetServiceKendaraan';
$route['GeneralAffair/FleetServiceKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetServiceKendaraan/$1';
$route['GeneralAffair/FleetServiceKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetServiceKendaraan/$1/$2';

$route['GeneralAffair/FleetMonitoringServiceKendaraan'] = 'GeneralAffair/MainMenu/C_FleetMonitoringServiceKendaraan';
$route['GeneralAffair/FleetMonitoringServiceKendaraan/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMonitoringServiceKendaraan/$1';
$route['GeneralAffair/FleetMonitoringServiceKendaraan/(:any)/(:any)'] = 'GeneralAffair/MainMenu/C_FleetMonitoringServiceKendaraan/$1/$2';
//------------------------------------ Aplikasi Toolroom ----------------------------
$route['Toolroom'] = 'Toolroom/C_Index';
$route['Toolroom/MasterItem'] = 'Toolroom/MainMenu/C_MasterItem';
$route['Toolroom/MasterItem/(:any)'] = 'Toolroom/MainMenu/C_MasterItem/$1';
$route['Toolroom/MasterItem/(:any)/(:any)'] = 'Toolroom/MainMenu/C_MasterItem/$1/$2';
$route['Toolroom/Transaksi'] = 'Toolroom/MainMenu/C_Transaksi';
$route['Toolroom/Transaksi/(:any)'] = 'Toolroom/MainMenu/C_Transaksi/$1';
$route['Toolroom/Transaksi/(:any)/(:any)'] = 'Toolroom/MainMenu/C_Transaksi/$1/$2';
$route['Toolroom/Transaksi/(:any)/(:any)/(:any)'] = 'Toolroom/MainMenu/C_Transaksi/$1/$2/$3';
$route['Toolroom/Report'] = 'Toolroom/Report/C_Report';
$route['Toolroom/Report/(:any)'] = 'Toolroom/Report/C_Report/$1';
$route['Toolroom/Report/(:any)/(:any)'] = 'Toolroom/Report/C_Report/$1/$2';
$route['Toolroom/Report/(:any)/(:any)/(:any)'] = 'Toolroom/Report/C_Report/$1/$2/$3';
$route['Toolroom/Dashboard'] = 'Toolroom/MainMenu/C_Dashboard';

//------------------------------------ KHS Save Location ----------------------------------------
$route['StorageLocation'] 									= 'StorageLocation/C_StorageLocation/index';
$route['StorageLocation/InputComponent'] 					= 'StorageLocation/MainMenu/C_InputComponent/index';
$route['StorageLocation/InputComponent/(:any)'] 			= 'StorageLocation/MainMenu/C_InputComponent/$1';
$route['StorageLocation/InputSubAssy'] 						= 'StorageLocation/MainMenu/C_InputAssy/index';
$route['StorageLocation/InputSubAssy/(:any)'] 				= 'StorageLocation/MainMenu/C_InputAssy/$1';
$route['StorageLocation/FileUpload'] 						= 'StorageLocation/MainMenu/C_InputFileUpload/index';
$route['StorageLocation/FileUpload/(:any)'] 				= 'StorageLocation/MainMenu/C_InputFileUpload/$1';
$route['StorageLocation/FileUpload/(:any)/(:any)'] 			= 'StorageLocation/MainMenu/C_InputFileUpload/$1/$2';
$route['StorageLocation/Correction'] 						= 'StorageLocation/MainMenu/C_Correction/index';
$route['StorageLocation/Correction/(:any)'] 				= 'StorageLocation/MainMenu/C_Correction/$1';
$route['StorageLocation/AddressMonitoring'] 				= 'StorageLocation/MainMenu/C_Monitoring/index';
$route['StorageLocation/AddressMonitoring/(:any)'] 			= 'StorageLocation/MainMenu/C_Monitoring/$1';
$route['StorageLocation/AddressMonitoring/(:any)/(:any)'] 	= 'StorageLocation/MainMenu/C_Monitoring/$1/$2';
$route['StorageLocation/Ajax/(:any)'] 						= 'StorageLocation/Additional/C_Ajax/$1';
$route['StorageLocation/Ajax/(:any)/(:any)'] 				= 'StorageLocation/Additional/C_Ajax/$1/$2';
$route['StorageLocation/Report'] 							= 'StorageLocation/Report/C_Report/index';
$route['StorageLocation/Report/(:any)'] 					= 'StorageLocation/Report/C_Report/$1';

//------------------------------------ KHS Cost Order --------------------------------------------
//CastingCost
$route['CastingCost']					 	= 'CastingCost/C_CastingCost/index';
$route['CastingCost/InputCasting']		 	= 'CastingCost/MainMenu/C_Casting/index';
$route['CastingCost/simpan'] 			 	= 'CastingCost/MainMenu/C_Casting/simpan';
$route['CastingCost/cek']				 	= 'CastingCost/MainMenu/C_Casting/cek';
$route['CastingCost/edit/submit'] 		 	= 'CastingCost/MainMenu/C_Casting/submit';
$route['CastingCost/view_casting'] 		 	= 'CastingCost/MainMenu/C_Casting/view_casting';
$route['CastingCost/EditRequest/(:any)']	= 'CastingCost/MainMenu/C_Casting/edit_request/$1';
$route['CastingCost/edit/savecostmachine']  = 'CastingCost/MainMenu/C_Casting/save_cost_machine';
$route['CastingCost/edit/savecostelectric'] = 'CastingCost/MainMenu/C_Casting/save_cost_electric';
$route['CastingCost/edit/export_excel'] 	= 'CastingCost/MainMenu/C_ExportExcel/excel';

//---start---------------------------- Document Controller --------------------------------------------

$route['DocumentStandarization'] 								= 'DocumentStandarization/MainMenu/C_AllDoc';

$route['DocumentStandarization/AllDoc'] 								= 'DocumentStandarization/MainMenu/C_AllDoc';
$route['DocumentStandarization/AllDoc/(:any)'] 							= 'DocumentStandarization/MainMenu/C_AllDoc/$1';
$route['DocumentStandarization/AllDoc/(:any)/(:any)'] 					= 'DocumentStandarization/MainMenu/C_AllDoc/$1/$2';
$route['DocumentStandarization/AllDoc/(:any)/(:any)/(:any)'] 			= 'DocumentStandarization/MainMenu/C_AllDoc/$1/$2/$3';
$route['DocumentStandarization/AllDoc/(:any)/(:any)/(:any)/(:any)'] 	= 'DocumentStandarization/MainMenu/C_AllDoc/$1/$2/$3/$4';

$route['DocumentStandarization/BP'] 							= 'DocumentStandarization/MainMenu/C_BusinessProcess';
$route['DocumentStandarization/BP/(:any)'] 						= 'DocumentStandarization/MainMenu/C_BusinessProcess/$1';
$route['DocumentStandarization/BP/(:any)/(:any)'] 				= 'DocumentStandarization/MainMenu/C_BusinessProcess/$1/$2';

$route['DocumentStandarization/CD'] 							= 'DocumentStandarization/MainMenu/C_ContextDiagram';
$route['DocumentStandarization/CD/(:any)'] 						= 'DocumentStandarization/MainMenu/C_ContextDiagram/$1';
$route['DocumentStandarization/CD/(:any)/(:any)'] 				= 'DocumentStandarization/MainMenu/C_ContextDiagram/$1/$2';

$route['DocumentStandarization/SOP'] 							= 'DocumentStandarization/MainMenu/C_StandardOperatingProcedure';
$route['DocumentStandarization/SOP/(:any)'] 					= 'DocumentStandarization/MainMenu/C_StandardOperatingProcedure/$1';
$route['DocumentStandarization/SOP/(:any)/(:any)'] 				= 'DocumentStandarization/MainMenu/C_StandardOperatingProcedure/$1/$2';

$route['DocumentStandarization/WI'] 							= 'DocumentStandarization/MainMenu/C_WorkInstruction';
$route['DocumentStandarization/WI/(:any)'] 						= 'DocumentStandarization/MainMenu/C_WorkInstruction/$1';
$route['DocumentStandarization/WI/(:any)/(:any)'] 				= 'DocumentStandarization/MainMenu/C_WorkInstruction/$1/$2';

$route['DocumentStandarization/COP'] 							= 'DocumentStandarization/MainMenu/C_CodeOfPractice';
$route['DocumentStandarization/COP/(:any)'] 					= 'DocumentStandarization/MainMenu/C_CodeOfPractice/$1';
$route['DocumentStandarization/COP/(:any)/(:any)'] 				= 'DocumentStandarization/MainMenu/C_CodeOfPractice/$1/$2';

$route['DocumentStandarization/DocumentHistory']				= 'DocumentStandarization/MainMenu/C_DocumentHistory';
$route['DocumentStandarization/DocumentHistory/(:any)']			= 'DocumentStandarization/MainMenu/C_DocumentHistory/$1';
$route['DocumentStandarization/DocumentHistory/(:any)/(:any)'] 	= 'DocumentStandarization/MainMenu/C_DocumentHistory/$1/$2';

// $route['DocumentStandarization/FlowProcess'] 								= 'DocumentStandarization/MainMenu/C_FlowProcess';
// $route['DocumentStandarization/FlowProcess/(:any)'] 						= 'DocumentStandarization/MainMenu/C_FlowProcess/$1';
// $route['DocumentStandarization/FlowProcess/(:any)/(:any)'] 					= 'DocumentStandarization/MainMenu/C_FlowProcess/$1/$2';

$route['DocumentStandarization/MasterJobDescription'] 					= 'DocumentStandarization/MainMenu/C_MasterJobDescription';
$route['DocumentStandarization/MasterJobDescription/(:any)'] 			= 'DocumentStandarization/MainMenu/C_MasterJobDescription/$1';
$route['DocumentStandarization/MasterJobDescription/(:any)/(:any)'] 	= 'DocumentStandarization/MainMenu/C_MasterJobDescription/$1/$2';

$route['DocumentStandarization/DocumentJobDescription'] 				= 'DocumentStandarization/MainMenu/C_DocumentJobDescription';
$route['DocumentStandarization/DocumentJobDescription/(:any)'] 			= 'DocumentStandarization/MainMenu/C_DocumentJobDescription/$1';
$route['DocumentStandarization/DocumentJobDescription/(:any)/(:any)'] 	= 'DocumentStandarization/MainMenu/C_DocumentJobDescription/$1/$2';

$route['DocumentStandarization/JobDescriptionPekerja'] 					= 'DocumentStandarization/MainMenu/C_JobDescriptionPekerja';
$route['DocumentStandarization/JobDescriptionPekerja/(:any)'] 			= 'DocumentStandarization/MainMenu/C_JobDescriptionPekerja/$1';
$route['DocumentStandarization/JobDescriptionPekerja/(:any)/(:any)'] 	= 'DocumentStandarization/MainMenu/C_JobDescriptionPekerja/$1/$2';

$route['DocumentStandarization/General'] 						= 'DocumentStandarization/MainMenu/C_General';
$route['DocumentStandarization/General/(:any)'] 				= 'DocumentStandarization/MainMenu/C_General/$1';
$route['DocumentStandarization/General/(:any)/(:any)'] 			= 'DocumentStandarization/MainMenu/C_General/$1/$2';


//---end------------------------------ Document Controller --------------------------------------------

//---start---------------------------- Document Controller Pekerja ------------------------------------
$route['DokumenPekerja'] 						=	'DokumenPekerja/C_DokumenCari';
$route['DokumenPekerja/DokumenCari']			=	'DokumenPekerja/C_DokumenCari';
$route['DokumenPekerja/DokumenCari/(:any)']		= 	'DokumenPekerja/C_DokumenCari/$1';
$route['DokumenPekerja/DokumenAll']				=	'DokumenPekerja/C_DokumenAll';
//---end------------------------------ Document Controller Pekerja ------------------------------------


//------------------------------------ Production Planning ----------------------------------------
$route['ProductionPlanning']  									= 'ProductionPlanning/C_Index/index';
$route['ProductionPlanning/Monitoring']  						= 'ProductionPlanning/MainMenu/C_Monitoring/index';
$route['ProductionPlanning/Monitoring/(:any)']  				= 'ProductionPlanning/MainMenu/C_Monitoring/$1';
$route['ProductionPlanning/StorageMonitoring']  				= 'ProductionPlanning/MainMenu/C_StorageMonitoring/index';
$route['ProductionPlanning/StorageMonitoring/(:any)']  			= 'ProductionPlanning/MainMenu/C_StorageMonitoring/$1';
$route['ProductionPlanning/DataPlanMonthly']  					= 'ProductionPlanning/MainMenu/C_DataPlanMonthly/index';
$route['ProductionPlanning/DataPlanMonthly/(:any)']  			= 'ProductionPlanning/MainMenu/C_DataPlanMonthly/$1';
$route['ProductionPlanning/DataPlanMonthly/(:any)/(:any)']		= 'ProductionPlanning/MainMenu/C_DataPlanMonthly/$1/$2';
$route['ProductionPlanning/DataPlanDaily']  					= 'ProductionPlanning/MainMenu/C_DataPlanDaily/index';
$route['ProductionPlanning/DataPlanDaily/(:any)']  				= 'ProductionPlanning/MainMenu/C_DataPlanDaily/$1';
$route['ProductionPlanning/DataPlanDaily/(:any)/(:any)']		= 'ProductionPlanning/MainMenu/C_DataPlanDaily/$1/$2';
$route['ProductionPlanning/ItemPlan']  							= 'ProductionPlanning/MainMenu/C_ItemPlan/index';
$route['ProductionPlanning/ItemPlan/(:any)']  					= 'ProductionPlanning/MainMenu/C_ItemPlan/$1';
$route['ProductionPlanning/ItemPlan/(:any)/(:any)']				= 'ProductionPlanning/MainMenu/C_ItemPlan/$1/$2';
$route['ProductionPlanning/Setting/GroupSection']  				= 'ProductionPlanning/Settings/C_GroupSection/index';
$route['ProductionPlanning/Setting/GroupSection/(:any)']		= 'ProductionPlanning/Settings/C_GroupSection/$1';
$route['ProductionPlanning/Setting/GroupSection/(:any)/(:any)']	= 'ProductionPlanning/Settings/C_GroupSection/$1/$2';
$route['ProductionPlanning/Setting/Section']					= 'ProductionPlanning/Settings/C_Section';
$route['ProductionPlanning/Setting/Section/(:any)']				= 'ProductionPlanning/Settings/C_Section/$1';
$route['ProductionPlanning/Setting/Section/(:any)/(:any)']		= 'ProductionPlanning/Settings/C_Section/$1/$2';


//------------------------------------MONITORING ICT --------------------------------------------

/*MONITORING LOG SERVER */
$route['MonitoringICT']								= 'MonitoringICT/C_Index/index';
$route['MonitoringServer/Monitoring']				= 'MonitoringICT/MainMenu/MonitoringLogServer/C_MonitoringServer/index';
$route['MonitoringServer/Monitoring/Detail/(:any)']	= 'MonitoringICT/MainMenu/MonitoringLogServer/C_MonitoringServer/detail/$1';
$route['MonitoringServer/InputMonitoring']			= 'MonitoringICT/MainMenu/MonitoringLogServer/C_InputMonitoring/index';
$route['MonitoringServer/InputMonitoring/save']		= 'MonitoringICT/MainMenu/MonitoringLogServer/C_InputMonitoring/save';
$route['MonitoringServer/InputMonitoring/upload']	= 'MonitoringICT/MainMenu/MonitoringLogServer/C_InputMonitoring/upload';

/*MONITORING FILE SERVER */
$route['MonitoringFileServer/Monitoring']			= 'MonitoringICT/MainMenu/MonitoringFileServer/C_MonitoringFIleServer/index';
$route['MonitoringFileServer/InputMonitoring']		= 'MonitoringICT/MainMenu/MonitoringFileServer/C_InputFIleServer/index';
$route['MonitoringFileServer/InputMonitoring/save']		= 'MonitoringICT/MainMenu/MonitoringFileServer/C_InputFIleServer/save';

$route['MonitoringICT/JobListMonitoring'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/index';
$route['MonitoringICT/JobListMonitoring/create'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/create';
$route['MonitoringICT/JobListMonitoring/Detail/(:any)/(:any)'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/detail/$1/$2';
$route['MonitoringICT/JobListMonitoring/Detail/(:any)'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/detail/$1/$2';
$route['MonitoringICT/JobListMonitoring/Edit/(:any)'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/edit/$1';
$route['MonitoringICT/JobListMonitoring/Delete'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/delete';
$route['MonitoringICT/JobListMonitoring/saveEdit'] 		= 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/saveEdit';
$route['MonitoringICT/JobListMonitoring/searchHasil'] = 'MonitoringICT/MainMenu/JobListMonitoring/C_JobListMonitoring/searchHasil';

$route['MonitoringICT/PlotingJoblist']	= 'MonitoringICT/MainMenu/PlotingJobList/C_PlotingJobList/index';
$route['MonitoringICT/PlotingJoblist/Edit/(:any)']	= 'MonitoringICT/MainMenu/PlotingJobList/C_PlotingJobList/indexEdit/$1';
$route['MonitoringICT/PlotingJoblist/saveEdit']	= 'MonitoringICT/MainMenu/PlotingJobList/C_PlotingJobList/saveEdit';

$route['MonitoringICT/MonitoringAll']	= 'MonitoringICT/MainMenu/MonitoringAll/C_MonitoringAll/index';
//DataKomputer Server
$route['MonitoringICT/DataServer']	=	'MonitoringICT/MainMenu/DataKomputerServer/C_DataKomputerServer';
$route['MonitoringICT/DataServer/(:any)']	=	'MonitoringICT/MainMenu/DataKomputerServer/C_DataKomputerServer/$1';
$route['MonitoringICT/DataServer/(:any)/(:any)']	=	'MonitoringICT/MainMenu/DataKomputerServer/C_DataKomputerServer/$1/$2';
$route['MonitoringICT/DataServer/(:any)/(:any)/(:any)']	=	'MonitoringICT/MainMenu/DataKomputerServer/C_DataKomputerServer/$1/$2/$3';
// -------start--------------------------- Monitoring OJT ----------------------------

$route['OnJobTraining']		=	'MonitoringOJT/C_Index';

	//	Master Orientasi
	//	{
			$route['OnJobTraining/MasterOrientasi']					=	'MonitoringOJT/C_MasterOrientasi';
			$route['OnJobTraining/MasterOrientasi/(:any)']			=	'MonitoringOJT/C_MasterOrientasi/$1';
			$route['OnJobTraining/MasterOrientasi/(:any)/(:any)']	=	'MonitoringOJT/C_MasterOrientasi/$1/$2';
	//	}

	//	Master Memo
	//	{
			$route['OnJobTraining/MasterMemo']						=	'MonitoringOJT/C_MasterMemo';
			$route['OnJobTraining/MasterMemo/(:any)']				=	'MonitoringOJT/C_MasterMemo/$1';
			$route['OnJobTraining/MasterMemo/(:any)/(:any)']		=	'MonitoringOJT/C_MasterMemo/$1/$2';
	//	}

	// 	Master Undangan
	// 	{
			$route['OnJobTraining/MasterUndangan']				=	'MonitoringOJT/C_MasterUndangan';
			$route['OnJobTraining/MasterUndangan/(:any)']		=	'MonitoringOJT/C_MasterUndangan/$1';
			$route['OnJobTraining/MasterUndangan/(:any)/(:any)']=	'MonitoringOJT/C_MasterUndangan/$1/$2';
	//	}

	//	Cetak Undangan
	//	{
			$route['OnJobTraining/CetakUndangan']						=	'MonitoringOJT/C_CetakUndangan';
			$route['OnJobTraining/CetakUndangan/(:any)']				=	'MonitoringOJT/C_CetakUndangan/$1';
			$route['OnJobTraining/CetakUndangan/(:any)/(:any)']			=	'MonitoringOJT/C_CetakUndangan/$1/$2';
	//	}

	//	Cetak Memo Jadwal Training
	//	{
			$route['OnJobTraining/CetakMemoJadwalTraining']					=	'MonitoringOJT/C_CetakMemoJadwalTraining';
			$route['OnJobTraining/CetakMemoJadwalTraining/(:any)']			=	'MonitoringOJT/C_CetakMemoJadwalTraining/$1';
			$route['OnJobTraining/CetakMemoJadwalTraining/(:any)/(:any)']	=	'MonitoringOJT/C_CetakMemoJadwalTraining/$1/$2';
	//	}

	//	Cetak Memo Pelaksanaan PDCA
	//	{
			$route['OnJobTraining/CetakMemoPDCA']					=	'MonitoringOJT/C_CetakMemoPDCA';
			$route['OnJobTraining/CetakMemoPDCA/(:any)']			=	'MonitoringOJT/C_CetakMemoPDCA/$1';
			$route['OnJobTraining/CetakMemoPDCA/(:any)/(:any)']		=	'MonitoringOJT/C_CetakMemoPDCA/$1/$2';
	//	}

	//	Monitoring
	//	{
			$route['OnJobTraining/Monitoring']					=	'MonitoringOJT/C_Monitoring';
			$route['OnJobTraining/Monitoring/(:any)']			=	'MonitoringOJT/C_Monitoring/$1';
			$route['OnJobTraining/Monitoring/(:any)/(:any)']	=	'MonitoringOJT/C_Monitoring/$1/$2';
	//	}

	//	E-mail
	//	{

			$route['OnJobTraining/Email']						=	'MonitoringOJT/C_Email';
			$route['OnJobTraining/Email/(:any)']				=	'MonitoringOJT/C_Email/$1';
	//	}

// -------end----------------------------- Monitoring OJT ----------------------------

//------------------------- Work Relationship (Hubker) ------------------------------------------------//
$route['WorkRelationship'] = 'WorkRelationship/C_WorkRelationship';
/* Bon Pekerja */
$route['WorkRelationship/RekapBon'] = 'WorkRelationship/MainMenu/C_RekapBon';
$route['WorkRelationship/RekapBon/(:any)'] = 'WorkRelationship/MainMenu/C_RekapBon/$1';
$route['WorkRelationship/RekapBon/(:any)/(:any)'] = 'WorkRelationship/MainMenu/C_RekapBon/$1/$2';


//------------------------------------ Production Planning ----------------------------------------
$route['ProductionEngineering'] = 'MonitoringPEIA/C_AccountReceivables';
$route['ProductionEngineering/Seksi'] = 'MonitoringPEIA/C_AccountReceivables/seksi';
$route['ProductionEngineering/Seksi/New'] = 'MonitoringPEIA/C_AccountReceivables/NewSeksi';
$route['ProductionEngineering/Seksi/add'] = 'MonitoringPEIA/C_AccountReceivables/insertSeksi';
$route['ProductionEngineering/Seksi/update'] = 'MonitoringPEIA/C_AccountReceivables/UpdateSeksi';
$route['ProductionEngineering/Seksi/edit/(:any)'] = 'MonitoringPEIA/C_AccountReceivables/EditSeksi/$1';
$route['ProductionEngineering/Seksi/Delete/(:any)'] = 'MonitoringPEIA/C_AccountReceivables/deleteSeksi/$1';
$route['ProductionEngineering/Order'] = 'MonitoringPEIA/C_AccountReceivables/order';
$route['ProductionEngineering/Order/New'] = 'MonitoringPEIA/C_AccountReceivables/NewOrder';
$route['ProductionEngineering/Order/add'] = 'MonitoringPEIA/C_AccountReceivables/insertOrder';
$route['ProductionEngineering/Order/update'] = 'MonitoringPEIA/C_AccountReceivables/UpdateOrder';
$route['ProductionEngineering/Order/edit/(:any)'] = 'MonitoringPEIA/C_AccountReceivables/EditOrder/$1';
$route['ProductionEngineering/JenisOrder'] = 'MonitoringPEIA/C_AccountReceivables/JenisOrder';
$route['ProductionEngineering/JenisOrder/New'] = 'MonitoringPEIA/C_AccountReceivables/NewJenisOrder';
$route['ProductionEngineering/JenisOrder/add'] = 'MonitoringPEIA/C_AccountReceivables/InsertJenisOrder';
$route['ProductionEngineering/JenisOrder/update'] = 'MonitoringPEIA/C_AccountReceivables/UpdateJenisOrder';
$route['ProductionEngineering/JenisOrder/edit/(:any)'] = 'MonitoringPEIA/C_AccountReceivables/EditJenisOrder/$1';
$route['ProductionEngineering/Laporan'] = 'MonitoringPEIA/C_AccountReceivables/Laporan';
$route['ProductionEngineering/Input'] = 'MonitoringPEIA/C_AccountReceivables/NewLaporan';
$route['ProductionEngineering/Laporan/add'] = 'MonitoringPEIA/C_AccountReceivables/insertSemua';
$route['ProductionEngineering/Laporan/edit/(:any)'] = 'MonitoringPEIA/C_AccountReceivables/EditLaporan/$1';
$route['ProductionEngineering/Laporan/update'] = 'MonitoringPEIA/C_AccountReceivables/UpdateLaporan';

$route['ProductionEngineering/JobHarianPIEA'] = 'MonitoringPEIA/JobHarian/C_JobHarian/Laporan';
$route['ProductionEngineering/JobHarian/Input'] = 'MonitoringPEIA/JobHarian/C_JobHarian/NewLaporan';
$route['ProductionEngineering/JobHarian/add'] = 'MonitoringPEIA/JobHarian/C_JobHarian/insertSemua';
$route['ProductionEngineering/JobHarian/edit/(:any)'] = 'MonitoringPEIA/JobHarian/C_JobHarian/EditLaporan/$1';
$route['ProductionEngineering/JobHarian/update'] = 'MonitoringPEIA/JobHarian/C_JobHarian/UpdateLaporan/';
$route['ProductionEngineering/JobHarian/deleteLaporan/(:any)'] = 'MonitoringPEIA/JobHarian/C_JobHarian/deleteLaporan/$1';

//------------------------------------ Manufacturing Operation ----------------------------------------
$route['ManufacturingOperation']								= 'ManufacturingOperation/C_Index/index';
$route['ManufacturingOperation/Core']							= 'ManufacturingOperation/MainMenu/C_Core';
$route['ManufacturingOperation/Core/(:any)']					= 'ManufacturingOperation/MainMenu/C_Core/$1';
$route['ManufacturingOperation/Core/(:any)/(:any)'] 			= 'ManufacturingOperation/MainMenu/C_Core/$1/$2';
$route['ManufacturingOperation/Mixing']							= 'ManufacturingOperation/MainMenu/C_Mixing';
$route['ManufacturingOperation/Mixing/(:any)']					= 'ManufacturingOperation/MainMenu/C_Mixing/$1';
$route['ManufacturingOperation/Mixing/(:any)/(:any)']			= 'ManufacturingOperation/MainMenu/C_Mixing/$1/$2';
$route['ManufacturingOperation/Moulding']						= 'ManufacturingOperation/MainMenu/C_Moulding';
$route['ManufacturingOperation/Moulding/(:any)']				= 'ManufacturingOperation/MainMenu/C_Moulding/$1';
$route['ManufacturingOperation/Moulding/(:any)/(:any)']			= 'ManufacturingOperation/MainMenu/C_Moulding/$1/$2';
$route['ManufacturingOperation/QualityControl']					= 'ManufacturingOperation/MainMenu/C_QualityControl';
$route['ManufacturingOperation/QualityControl/(:any)']			= 'ManufacturingOperation/MainMenu/C_QualityControl/$1';
$route['ManufacturingOperation/QualityControl/(:any)/(:any)']	= 'ManufacturingOperation/MainMenu/C_QualityControl/$1/$2';
$route['ManufacturingOperation/Selep']							= 'ManufacturingOperation/MainMenu/C_Selep';
$route['ManufacturingOperation/Selep/(:any)']					= 'ManufacturingOperation/MainMenu/C_Selep/$1';
$route['ManufacturingOperation/Selep/(:any)/(:any)']			= 'ManufacturingOperation/MainMenu/C_Selep/$1/$2';
$route['ManufacturingOperation/Ajax/(:any)']					= 'ManufacturingOperation/Ajax/C_Ajax/$1';
$route['ManufacturingOperation/Ajax/(:any)/(:any)']				= 'ManufacturingOperation/Ajax/C_Ajax/$1/$2';
$route['ManufacturingOperation/Job/ReplaceComp']				= 'ManufacturingOperation/MainMenu/C_ReplaceComp';
$route['ManufacturingOperation/Job/ReplaceComp/(:any)']			= 'ManufacturingOperation/MainMenu/C_ReplaceComp/$1';
$route['ManufacturingOperation/Job/ReplaceComp/(:any)/(:any)']	= 'ManufacturingOperation/MainMenu/C_ReplaceComp/$1/$2';
$route['ManufacturingOperation/Job/ReplaceComp/(:any)/(:any)/(:any)']	= 'ManufacturingOperation/MainMenu/C_ReplaceComp/$1/$2/$3';

//------------------------------------------------Master Pekerja-------------------------------------------------------//
$route['MasterPekerja'] = 'MasterPekerja/C_MasterPekerja';

$route['MasterPekerja/Other'] = 'MasterPekerja/Other/C_CetakCard';
$route['MasterPekerja/Other/(:any)'] = 'MasterPekerja/Other/C_CetakCard/$1';
$route['MasterPekerja/Other/(:any)/(:any)'] = 'MasterPekerja/Other/C_CetakCard/$1/$2';
$route['MasterPekerja'] 					=	'MasterPekerja/C_Index';

$route['MasterPekerja/Surat'] 				=	'MasterPekerja/Surat/C_Surat';
$route['MasterPekerja/Surat/(:any)'] 		=	'MasterPekerja/Surat/C_Surat/$1';

$route['MasterPekerja/SetupLokasi'] 				=	'MasterPekerja/SetupMaster/C_Index';
$route['MasterPekerja/SetupLokasi/(:any)'] 		=	'MasterPekerja/SetupMaster/C_Index/$1';
$route['MasterPekerja/SetupLokasi/(:any)/(:any)'] 		=	'MasterPekerja/SetupMaster/C_Index/$1/$2';

$route['MasterPekerja/SetupKantorAsal'] 				=	'MasterPekerja/SetupMaster/C_KantorAsal';
$route['MasterPekerja/SetupKantorAsal/(:any)'] 		=	'MasterPekerja/SetupMaster/C_KantorAsal/$1';
$route['MasterPekerja/SetupKantorAsal/(:any)/(:any)'] 		=	'MasterPekerja/SetupMaster/C_KantorAsal/$1/$2';


$route['MasterPekerja/Surat/SuratLayout']				=	'MasterPekerja/Surat/LayoutSurat/C_Index';
$route['MasterPekerja/Surat/SuratLayout/(:any)']		=	'MasterPekerja/Surat/LayoutSurat/C_Index/$1';
$route['MasterPekerja/Surat/SuratLayout/(:any)/(:any)']	=	'MasterPekerja/Surat/LayoutSurat/C_Index/$1/$2';

$route['MasterPekerja/Surat/SuratMutasi']								=	'MasterPekerja/Surat/C_Mutasi';
$route['MasterPekerja/Surat/SuratMutasi/(:any)']						=	'MasterPekerja/Surat/C_Mutasi/$1';
$route['MasterPekerja/Surat/SuratMutasi/(:any)/(:any)']					=	'MasterPekerja/Surat/C_Mutasi/$1/$2';
$route['MasterPekerja/Surat/SuratMutasi/(:any)/(:any)/(:any)']			=	'MasterPekerja/Surat/C_Mutasi/$1/$2/$3';
$route['MasterPekerja/Surat/SuratMutasi/(:any)/(:any)/(:any)/(:any)']	=	'MasterPekerja/Surat/C_Mutasi/$1/$2/$3/$4';

$route['MasterPekerja/Surat/SuratDemosi']               =   'MasterPekerja/Surat/Demosi/C_Index';
$route['MasterPekerja/Surat/SuratDemosi/(:any)']        =   'MasterPekerja/Surat/Demosi/C_Index/$1';
$route['MasterPekerja/Surat/SuratDemosi/(:any)/(:any)'] =   'MasterPekerja/Surat/Demosi/C_Index/$1/$2/$3';
$route['MasterPekerja/Surat/SuratPerbantuan']           =   'MasterPekerja/Surat/Perbantuan/C_Index';
$route['MasterPekerja/Surat/SuratPerbantuan/(:any)']    =   'MasterPekerja/Surat/Perbantuan/C_Index/$1';
$route['MasterPekerja/Surat/SuratPerbantuan/(:any)/(:any)'] ='MasterPekerja/Surat/Perbantuan/C_Index/$1/$2';
$route['MasterPekerja/Surat/SuratPerbantuan/(:any)/(:any)/(:any)'] ='MasterPekerja/Surat/Perbantuan/C_Index/$1/$2/$3';
$route['MasterPekerja/Surat/SuratPromosi']              =   'MasterPekerja/Surat/Promosi/C_Index';
$route['MasterPekerja/Surat/SuratPromosi/(:any)']       =   'MasterPekerja/Surat/Promosi/C_Index/$1';
$route['MasterPekerja/Surat/SuratPromosi/(:any)/(:any)']=   'MasterPekerja/Surat/Promosi/C_Index/$1/$2';
$route['MasterPekerja/Surat/SuratPromosi/(:any)/(:any)/(:any)']=   'MasterPekerja/Surat/Promosi/C_Index/$1/$2/$3';
$route['MasterPekerja/Surat/SuratRotasi']               =   'MasterPekerja/Surat/Rotasi/C_Index';
$route['MasterPekerja/Surat/SuratRotasi/(:any)']        =   'MasterPekerja/Surat/Rotasi/C_Index/$1';
$route['MasterPekerja/Surat/SuratRotasi/(:any)/(:any)'] =   'MasterPekerja/Surat/Rotasi/C_Index/$1/$2/$3';
$route['MasterPekerja/Surat/SuratPengangkatanStaff']               =   'MasterPekerja/Surat/Pengangkatan/C_Index';
$route['MasterPekerja/Surat/SuratPengangkatanStaff/(:any)']        =   'MasterPekerja/Surat/Pengangkatan/C_Index/$1';
$route['MasterPekerja/Surat/SuratPengangkatanStaff/(:any)/(:any)'] =   'MasterPekerja/Surat/Pengangkatan/C_Index/$1/$2/$3';
$route['MasterPekerja/Surat/SuratPengangkatanNonStaff']               =   'MasterPekerja/Surat/Pengangkatan/C_Index/index2';
$route['MasterPekerja/Surat/SuratPengangkatanNonStaff/(:any)']        =   'MasterPekerja/Surat/Pengangkatan/C_Index/$1';
$route['MasterPekerja/Surat/SuratPengangkatanNonStaff/(:any)/(:any)'] =   'MasterPekerja/Surat/Pengangkatan/C_Index/$1/$2/$3';

//------------------------------------ Penerimaan PO ----------------------------------------
$route['PenerimaanPO']						   = 'PenerimaanPO/C_Penerimaan';

$route['PenerimaanPO/awal']					   = 'PenerimaanPO/C_PenerimaanAwal';
$route['PenerimaanPO/awal/(:any)']   		   = 'PenerimaanPO/C_PenerimaanAwal/$1';
$route['PenerimaanPO/awal/loadVendor/(:any)']  = 'PenerimaanPO/C_PenerimaanAwal/loadVendor/$1';
$route['PenerimaanPO/awal/loadPoLine/(:any)']  = 'PenerimaanPO/C_PenerimaanAwal/loadPoLine/$1';
$route['PenerimaanPO/awal/loadSubinv/(:any)']  = 'PenerimaanPO/C_PenerimaanAwal/loadSubinv/$1';


$route['PenerimaanPO/cek'] 					   = 'PenerimaanPO/C_Pengecekan';
$route['PenerimaanPO/cek/loadDataCek']         = 'PenerimaanPO/C_Pengecekan/loadDataCek';

//------------------------------------------------Product Cost-------------------------------------------------------//
$route['ProductCost']										= 'ProductCost/C_Index';
$route['ProductCost/BppbgAccount']							= 'ProductCost/MainMenu/C_BppbgAccount';
$route['ProductCost/BppbgAccount/(:any)']					= 'ProductCost/MainMenu/C_BppbgAccount/$1';
$route['ProductCost/BppbgAccount/(:any)/(:any)']			= 'ProductCost/MainMenu/C_BppbgAccount/$1/$2';
$route['ProductCost/BppbgAccount/(:any)/(:any)/(:any)']		= 'ProductCost/MainMenu/C_BppbgAccount/$1/$2/$3';
$route['ProductCost/BppbgCategory']							= 'ProductCost/MainMenu/C_BppbgCategory';
$route['ProductCost/BppbgCategory/(:any)']					= 'ProductCost/MainMenu/C_BppbgCategory/$1';
$route['ProductCost/BppbgCategory/(:any)/(:any)']			= 'ProductCost/MainMenu/C_BppbgCategory/$1/$2';
$route['ProductCost/BppbgCategory/(:any)/(:any)/(:any)']	= 'ProductCost/MainMenu/C_BppbgCategory/$1/$2/$3';

$route['ProductCost/Ajax/(:any)']						= 'ProductCost/Ajax/C_Ajax/$1';
$route['ProductCost/Ajax/(:any)/(:any)']				= 'ProductCost/Ajax/C_Ajax/$1/$2';

//------------------------------------Master Presensi---------------------------------------------------
$route['Presensi'] 						= 'Presensi/C_Presensi';

$route['Presensi/PresensiDL'] 			= 'Presensi/MenuUtama/C_Presensi_DL/index';
$route['Presensi/PresensiDL/(:any)']		= 'Presensi/MenuUtama/C_Presensi_DL/$1';
$route['Presensi/PresensiDL/(:any)/(:any)']	= 'Presensi/MenuUtama/C_Presensi_DL/$1/$2';
$route['Presensi/PresensiDL/(:any)/(:any)/(:any)']	= 'Presensi/MenuUtama/C_Presensi_DL/$1/$2/$3';


//-------------------------------------Hambatan Produksi-------------------------------------------------
$route['ManufacturingOperation/ProductionObstacles/master'] = 'ManufacturingOperation/ProductionObstacles/MainMenu/C_Master';
$route['ManufacturingOperation/ProductionObstacles/master/(:any)'] = 'ManufacturingOperation/ProductionObstacles/MainMenu/C_Master/$1';
$route['ManufacturingOperation/ProductionObstacles/ajax'] = 'ManufacturingOperation/ProductionObstacles/Ajax/C_Ajax';
$route['ManufacturingOperation/ProductionObstacles/ajax/(:any)'] = 'ManufacturingOperation/ProductionObstacles/Ajax/C_Ajax/$1';
$route['ManufacturingOperation/ProductionObstacles/Hambatan/mesin'] = 'ManufacturingOperation/ProductionObstacles/MainMenu/C_HambatanMesin';
$route['ManufacturingOperation/ProductionObstacles/Hambatan/mesin/(:any)'] = 'ManufacturingOperation/ProductionObstacles/MainMenu/C_HambatanMesin/$1';
$route['ManufacturingOperation/ProductionObstacles/Hambatan/non-mesin'] = 'ManufacturingOperation/ProductionObstacles/MainMenu/C_HambatanNonMesin/index';
$route['ManufacturingOperation/ProductionObstacles/Hambatan/non-mesin/(:any)'] = 'ManufacturingOperation/ProductionObstacles/MainMenu/C_HambatanNonMesin/$1';


$route['Presensi/PresensiCatering']				=	'Presensi/MenuUtama/C_Presensi_Catering';
$route['Presensi/PresensiCatering/(:any)']		=	'Presensi/MenuUtama/C_Presensi_Catering/$1';

//------------------------------------ Monitoring CBO ----------------------------------------
$route['PaintingCbo'] = 'MonitoringCBO/C_MonitoringCBO';

$route['CBOPainting/Setup/Komponen'] = 'MonitoringCBO/C_MonitoringCBO/Komponen';
$route['CBOPainting/Setup/Komponen/New'] = 'MonitoringCBO/C_MonitoringCBO/NewKomponen';
$route['CBOPainting/Setup/Komponen/Add'] = 'MonitoringCBO/C_MonitoringCBO/insertKomponen';
$route['CBOPainting/Setup/Komponen/Edit/(:any)'] = 'MonitoringCBO/C_MonitoringCBO/EditKomponen/$1';
$route['CBOPainting/Setup/Komponen/update'] = 'MonitoringCBO/C_MonitoringCBO/UpdateKomponen';
$route['CBOPainting/Setup/Komponen/Delete/(:any)'] = 'MonitoringCBO/C_MonitoringCBO/deleteKomponen/$1';

$route['CBOPainting/Setup/Tipe'] = 'MonitoringCBO/C_MonitoringCBO/Tipe';
$route['CBOPainting/Setup/Tipe/New'] = 'MonitoringCBO/C_MonitoringCBO/NewTipe';
$route['CBOPainting/Setup/Tipe/Add'] = 'MonitoringCBO/C_MonitoringCBO/insertTipe';
$route['CBOPainting/Setup/Tipe/Edit/(:any)'] = 'MonitoringCBO/C_MonitoringCBO/EditTipe/$1';
$route['CBOPainting/Setup/Tipe/update'] = 'MonitoringCBO/C_MonitoringCBO/UpdateTipe';
$route['CBOPainting/Setup/Tipe/Delete/(:any)'] = 'MonitoringCBO/C_MonitoringCBO/deleteTipe/$1';

$route['CBOPainting/CBO/Input'] = 'MonitoringCBO/C_MonitoringCBO/CBO_Input';
$route['CBOPainting/CBO/Regen'] = 'MonitoringCBO/C_MonitoringCBO/regen';

$route['CBOPainting/CBO/Grafik'] = 'MonitoringCBO/C_MonitoringCBO/CBO_Grafik';
$route['CBOPainting/CBO/Report'] = 'MonitoringCBO/C_MonitoringCBO/CBO_Report';
$route['CBOPainting/CBO/cek_cbo'] = 'MonitoringCBO/C_MonitoringCBO/cek_cbo';
$route['CBOPainting/CBO/Edit'] = 'MonitoringCBO/C_MonitoringCBO/cbo_edit';

$route['CBOPainting/CBO/SearchReport'] = 'MonitoringCBO/C_MonitoringCBO/searchReport';
$route['CBOPainting/CBO/ReportExcel'] = 'MonitoringCBO/C_MonitoringCBO/exportReport';
$route['CBOPainting/CBO/getGrafik'] = 'MonitoringCBO/C_MonitoringCBO/grafik';

//--------------------------------------------------- Site Management ---------------------------------------------------------//
$route['SiteManagement'] = 'SiteManagement/C_SiteManagement';
$route['SiteManagement/Monitoring'] = 'SiteManagement/MainMenu/C_Monitoring';
$route['SiteManagement/Monitoring/(:any)'] = 'SiteManagement/MainMenu/C_Monitoring/$1';

$route['SiteManagement/RecordData/(:any)'] = 'SiteManagement/MainMenu/C_RecordData/$1';
$route['SiteManagement/RecordData/(:any)/(:any)'] = 'SiteManagement/MainMenu/C_RecordData/$1/$2';

$route['SiteManagement/Order'] = 'SiteManagement/MainMenu/C_Order';
$route['SiteManagement/Order/(:any)'] = 'SiteManagement/MainMenu/C_Order/$1';
$route['SiteManagement/Order/(:any)/(:any)'] = 'SiteManagement/MainMenu/C_Order/$1/$2';

$route['SiteManagement/InputAsset'] = 'SiteManagement/MainMenu/C_Inputasset';
$route['SiteManagement/InputAsset/(:any)'] = 'SiteManagement/MainMenu/C_Inputasset/$1';
$route['SiteManagement/InputAsset/(:any)/(:any)'] = 'SiteManagement/MainMenu/C_Inputasset/$1/$2';

$route['SiteManagement/PembelianAsset'] = 'SiteManagement/MainMenu/C_Pembelianasset';
$route['SiteManagement/PembelianAsset/(:any)'] = 'SiteManagement/MainMenu/C_Pembelianasset/$1';
$route['SiteManagement/PembelianAsset/(:any)/(:any)'] = 'SiteManagement/MainMenu/C_Pembelianasset/$1/$2';

$route['SiteManagement/RetirementAsset'] = 'SiteManagement/MainMenu/C_Retirementasset';
$route['SiteManagement/RetirementAsset/(:any)'] = 'SiteManagement/MainMenu/C_Retirementasset/$1';
$route['SiteManagement/RetirementAsset/(:any)/(:any)'] = 'SiteManagement/MainMenu/C_Retirementasset/$1/$2';

$route['SiteManagement/TransferAsset'] = 'SiteManagement/MainMenu/C_Transferasset';
$route['SiteManagement/TransferAsset/(:any)'] = 'SiteManagement/MainMenu/C_Transferasset/$1';
$route['SiteManagement/TransferAsset/(:any)/(:any)'] = 'SiteManagement/MainMenu/C_Transferasset/$1/$2';

$route['SiteManagement/DaftarAsset'] = 'SiteManagement/MainMenu/C_DaftarAsset';
$route['SiteManagement/DaftarAsset/(:any)'] = 'SiteManagement/MainMenu/C_DaftarAsset/$1';

//--------------------------------------------------- Order Site Management --------------------------------------------------//
$route['OrderSiteManagement'] = 'OrderSiteManagement/C_OrderSiteManagement';
$route['OrderSiteManagement/Order'] = 'OrderSiteManagement/MainMenu/C_Order';
$route['OrderSiteManagement/Order/(:any)'] = 'OrderSiteManagement/MainMenu/C_Order/$1';
$route['OrderSiteManagement/Order/(:any)/(:any)'] = 'OrderSiteManagement/MainMenu/C_Order/$1/$2';

$route['SiteManagement/MobileOrder/login'] = 'SiteManagement/C_index/login';
$route['SiteManagement/MobileOrder/getlist'] = 'SiteManagement/C_index/getlist';
$route['SiteManagement/MobileOrder/scan'] = 'SiteManagement/C_index/scan';
$route['SiteManagement/MobileOrder/(:any)'] = 'SiteManagement/C_index/$1';
$route['SiteManagement/MobileOrder/(:any)/(:any)'] = 'SiteManagement/C_index/$1/$2';

$route['MasterPekerja/DataPekerjaKeluar'] = 'MasterPekerja/Pekerja/PekerjaKeluar/C_Index';
$route['MasterPekerja/DataPekerjaKeluar/(:any)'] = 'MasterPekerja/Pekerja/PekerjaKeluar/C_Index/$1';
$route['MasterPekerja/DataPekerjaKeluar/(:any)/(:any)'] = 'MasterPekerja/Pekerja/PekerjaKeluar/C_Index/$1/$2';

//--------------------------------------------------- E-COMMERCE --------------------------------------------------//
$route['ECommerce'] 							= 'ECommerce/C_index';
$route['ECommerce/SearchItem'] 					= 'ECommerce/C_SearchItem';
$route['ECommerce/SearchItem/(:any)'] 			= 'ECommerce/C_SearchItem/$1';
$route['ECommerce/SearchItem/(:any)/(:any)'] 	= 'ECommerce/C_SearchItem/$1/$2';

$route['ECommerce/WaktuPenangananOrder']		= 'ECommerce/C_WaktuPenangananOrder';
$route['ECommerce/WaktuPenangananOrder/(:any)']		= 'ECommerce/C_WaktuPenangananOrder/$1';

//-------------------------------------------------- Kecelakaan Kerja -----------------------------------------------//
$route['MasterPekerja/KecelakaanKerja']	= 'MasterPekerja/Laporan/C_Index';
$route['MasterPekerja/KecelakaanKerja/(:any)']			=	'MasterPekerja/Laporan/C_Index/$1';
$route['MasterPekerja/KecelakaanKerja/(:any)/(:any)']	=	'MasterPekerja/Laporan/C_Index/$1/$2';
$route['MasterPekerja/SettingKecelakaanKerja'] = 'MasterPekerja/Laporan/C_Index/dataPerusahaan';
$route['MasterPekerja/SettingKecelakaanKerja/(:any)'] = 'MasterPekerja/Laporan/C_Index/$1';
$route['MasterPekerja/SettingKecelakaanKerja/(:any)/(:any)'] = 'MasterPekerja/Laporan/C_Index/$1/$2';

$route['MasterPekerja/DataPekerjaKeluar'] = 'MasterPekerja/Pekerja/PekerjaKeluar/C_Index';
$route['MasterPekerja/DataPekerjaKeluar/(:any)'] = 'MasterPekerja/Pekerja/PekerjaKeluar/C_Index/$1';
$route['MasterPekerja/DataPekerjaKeluar/(:any)/(:any)'] = 'MasterPekerja/Pekerja/PekerjaKeluar/C_Index/$1/$2';

//--------------------------------------------------- Warehouse --------------------------------------------------//

$route['WarehouseSPB'] 								= 'WarehouseSPB/C_Index';
$route['WarehouseSPB/Transaction/(:any)'] 				= 'WarehouseSPB/MainMenu/C_Transaction/$1';
$route['WarehouseSPB/Transaction/(:any)/(:any)']		= 'WarehouseSPB/MainMenu/C_Transaction/$1/$2';
$route['WarehouseSPB/Ajax/(:any)']		 				= 'WarehouseSPB/Ajax/C_Ajax/$1';
 //---------------------------------------------------------- P2K3 -----------------------------------------------------------//
 $route['P2K3'] = 'P2K3/C_P2K3';
 $route['P2K3/Order'] = 'P2K3/MainMenu/C_Order';
 $route['P2K3/Order/(:any)'] = 'P2K3/MainMenu/C_Order/$1';
 $route['P2K3/Order/(:any)/(:any)'] = 'P2K3/MainMenu/C_Order/$1/$2';
 $route['P2K3/Order/(:any)/(:any)/(:any)'] = 'P2K3/MainMenu/C_Order/$1/$2/$3';
 // $route['P2K3/Order/list_all'] = 'P2K3/MainMenu/C_Order/listAll';
   //---------------------------------------------------------- P2K3 V2 -----------------------------------------------------------//
 $route['P2K3_V2'] = 'P2K3V2/C_P2K3';
 $route['P2K3_V2/Order'] = 'P2K3V2/MainMenu/C_Order';
 $route['P2K3_V2/Order/(:any)'] = 'P2K3V2/MainMenu/C_Order/$1';
 $route['P2K3_V2/Order/(:any)/(:any)'] = 'P2K3V2/MainMenu/C_Order/$1/$2';
 $route['P2K3_V2/Order/(:any)/(:any)/(:any)'] = 'P2K3V2/MainMenu/C_Order/$1/$2/$3';

//------------------------------------------------Waste Management Seksi------------------------------------------------//
$route['WasteManagementSeksi'] 	= 'WasteManagementSeksi/C_WasteManagementSeksi';
$route['WasteManagementSeksi/InputKirimLimbah'] = 'WasteManagementSeksi/MainMenu/C_inputkirim';
$route['WasteManagementSeksi/InputKirimLimbah/(:any)'] = 'WasteManagementSeksi/MainMenu/C_inputkirim/$1';
$route['WasteManagementSeksi/InputKirimLimbah/(:any)/(:any)'] = 'WasteManagementSeksi/MainMenu/C_inputkirim/$1/$2';
$route['WasteManagementSeksi/InputKirimLimbah/(:any)/(:any)/(:any)'] = 'WasteManagementSeksi/MainMenu/C_inputkirim/$1/$2/$3';

$route['WasteManagementSeksi/InfoKirimLimbah'] = 'WasteManagementSeksi/MainMenu/C_infokirim';
$route['WasteManagementSeksi/InfoKirimLimbah/(:any)'] = 'WasteManagementSeksi/MainMenu/C_infokirim/$1';
$route['WasteManagementSeksi/InfoKirimLimbah/(:any)/(:any)'] = 'WasteManagementSeksi/MainMenu/C_infokirim/$1/$2';

//------------------------------------ System Integration ----------------------------------------//
$route['SystemIntegration'] = 'SystemIntegration/C_Index/index';
$route['SystemIntegrationKaizenGenerator/Submit/getItem'] = 'SystemIntegration/MainMenu/Submit/C_Submit/getItem';


//--------------------------------------------------- Ceatak Tanda Terima BPJS -----------------------------------//
$route['MasterPekerja/TanTerBPJS'] 		= 'MasterPekerja/CetakBPJS/C_Index';
$route['MasterPekerja/TanTerBPJS/(:any)'] = 'MasterPekerja/CetakBPJS/C_Index/$1';
$route['MasterPekerja/TanTerBPJS/(:any)/(:any)'] = 'MasterPekerja/CetakBPJS/C_Index/$1/$2';


//--------------------------------------------------- Ceatak Tanda Terima BPJS -----------------------------------//
$route['MasterPekerja/TanTerBPJSKes'] 		= 'MasterPekerja/CetakBPJSKes/C_Index';
$route['MasterPekerja/TanTerBPJSKes/(:any)'] = 'MasterPekerja/CetakBPJSKes/C_Index/$1';
$route['MasterPekerja/TanTerBPJSKes/(:any)/(:any)'] = 'MasterPekerja/CetakBPJSKes/C_Index/$1/$2';
//---------------------------------------------------------- P2K3adm -----------------------------------------------------------//
$route['p2k3adm'] = 'P2K3/P2K3Admin/C_P2K3Admin';
$route['p2k3adm/datamasuk'] = 'P2K3/P2K3Admin/MainMenu/C_DataMasuk';
$route['p2k3adm/datamasuk/(:any)'] = 'P2K3/P2K3Admin/MainMenu/C_DataMasuk/$1';
$route['p2k3adm/datamasuk/(:any)/(:any)'] = 'P2K3/P2K3Admin/MainMenu/C_DataMasuk/$1/$2';
$route['p2k3adm/datamasuk/(:any)/(:any)/(:any)'] = 'P2K3/P2K3Admin/MainMenu/C_DataMasuk/$1/$2/$3';
$route['p2k3adm/Admin/(:any)'] = 'P2K3/P2K3Admin/MainMenu/C_Index/$1';
$route['p2k3adm/Admin/(:any)/(:any)'] = 'P2K3/P2K3Admin/MainMenu/C_Index/$1/$2';

//---------------------------------------------------------- P2K3adm V2 -----------------------------------------------------------//
$route['p2k3adm_V2'] = 'P2K3V2/P2K3Admin/C_P2K3Admin';
$route['p2k3adm_V2/datamasuk'] = 'P2K3V2/P2K3Admin/MainMenu/C_DataMasuk';
$route['p2k3adm_V2/datamasuk/(:any)'] = 'P2K3V2/P2K3Admin/MainMenu/C_DataMasuk/$1';
$route['p2k3adm_V2/datamasuk/(:any)/(:any)'] = 'P2K3V2/P2K3Admin/MainMenu/C_DataMasuk/$1/$2';
$route['p2k3adm_V2/datamasuk/(:any)/(:any)/(:any)'] = 'P2K3V2/P2K3Admin/MainMenu/C_DataMasuk/$1/$2/$3';
$route['p2k3adm_V2/Admin/(:any)'] = 'P2K3V2/P2K3Admin/MainMenu/C_Index/$1';
$route['p2k3adm_V2/Admin/(:any)/(:any)'] = 'P2K3V2/P2K3Admin/MainMenu/C_Index/$1/$2';
$route['p2k3adm_V2/Admin/(:any)/(:any)/(:any)'] = 'P2K3V2/P2K3Admin/MainMenu/C_Index/$1/$2/$3';


//--------------------------------------------------- Monitoring Invoice Admin Pembelian --------------------------------------------------//
$route['AccountPayables/MonitoringInvoice/Invoice'] = 'MonitoringInvoice/C_monitoringinvoice';
$route['AccountPayables/MonitoringInvoice/Invoice/(:any)'] = 'MonitoringInvoice/C_monitoringinvoice/$1';
$route['AccountPayables/MonitoringInvoice/Invoice/(:any)/(:any)'] = 'MonitoringInvoice/C_monitoringinvoice/$1/$2';
$route['AccountPayables/MonitoringInvoice/Invoice/Rejected'] = 'MonitoringInvoice/C_monitoringinvoice/viewreject';
$route['AccountPayables/MonitoringInvoice/Invoice/Rejected/(:any)'] = 'MonitoringInvoice/C_monitoringinvoice/viewreject/$1';
$route['AccountPayables/MonitoringInvoice/Invoice/Rejected/(:any)/(:any)'] = 'MonitoringInvoice/C_monitoringinvoice/$1/$2';
$route['AccountPayables/MonitoringInvoice/ListSubmitedChecking'] = 'MonitoringInvoice/C_monitoringinvoice/listSubmited';
$route['AccountPayables/MonitoringInvoice/ListSubmitedChecking/(:any)/(:any)'] = 'MonitoringInvoice/C_monitoringinvoice/$1/$2';
$route['AccountPayables/MonitoringInvoice/ListSubmitedChecking/(:any)/(:any)/(:any)'] = 'MonitoringInvoice/C_monitoringinvoice/$1/$2/$3';

//--------------------------------------------------- Monitoring Invoice Kasie Pembelian --------------------------------------------------//
$route['AccountPayables/MonitoringInvoice/InvoiceKasie'] = 'MonitoringInvKasiePembelian/C_kasiepembelian';
$route['AccountPayables/MonitoringInvoice/InvoiceKasie/(:any)'] = 'MonitoringInvKasiePembelian/C_kasiepembelian/$1';
$route['AccountPayables/MonitoringInvoice/InvoiceKasie/(:any)/(:any)'] = 'MonitoringInvKasiePembelian/C_kasiepembelian/$1/$2';
$route['AccountPayables/MonitoringInvoice/InvoiceKasie/(:any)/(:any)/(:any)'] = 'MonitoringInvKasiePembelian/C_kasiepembelian/$1/$2/$3';
$route['AccountPayables/MonitoringInvoice/FinishBatch'] = 'MonitoringInvKasiePembelian/C_kasiepembelian/finishBatch';

//--------------------------------------------------- Monitoring Invoice Akuntansi --------------------------------------------------//
$route['AccountPayables/MonitoringInvoice/Unprocess'] = 'MonitoringInvoiceAkuntansi/C_monitoringakuntansi';
$route['AccountPayables/MonitoringInvoice/Unprocess/(:any)'] = 'MonitoringInvoiceAkuntansi/C_monitoringakuntansi/$1';
$route['AccountPayables/MonitoringInvoice/Unprocess/(:any)/(:any)'] = 'MonitoringInvoiceAkuntansi/C_monitoringakuntansi/$1/$2';
$route['AccountPayables/MonitoringInvoice/Unprocess/(:any)/(:any)/(:any)'] = 'MonitoringInvoiceAkuntansi/C_monitoringakuntansi/$1/$2/$3';
$route['AccountPayables/MonitoringInvoice/Finish'] = 'MonitoringInvoiceAkuntansi/C_monitoringakuntansi/finishBatchInvoice';
$route['AccountPayables/MonitoringInvoice/Finish/(:any)/(:any)'] = 'MonitoringInvoiceAkuntansi/C_monitoringakuntansi/$1/$2';

//------------------------------------ System Integration ----------------------------------------//
$route['SystemIntegration'] = 'SystemIntegration/C_Index/index';
$route['SystemIntegrationKaizenGenerator/Submit/getItem'] = 'SystemIntegration/MainMenu/Submit/C_Submit/getItem';


//Submit
$route['SystemIntegration/KaizenGenerator/Submit/index'] = 'SystemIntegration/MainMenu/Submit/C_Submit/index';
$route['SystemIntegration/KaizenGenerator/Submit/upload'] = 'SystemIntegration/MainMenu/Submit/C_Submit/upload';
$route['SystemIntegration/KaizenGenerator/Submit/create'] = 'SystemIntegration/MainMenu/Submit/C_Submit/create';
// $route['SystemIntegration/KaizenGenerator/Submit/saveUpdate/(:any)'] = 'SystemIntegration/MainMenu/Submit/C_Submit/saveUpdate/$1';

//View
$route['SystemIntegration/KaizenGenerator/View/(:any)'] = 'SystemIntegration/MainMenu/Submit/C_Submit/view/$1';
$route['SystemIntegration/KaizenGenerator/Edit/(:any)'] = 'SystemIntegration/MainMenu/Submit/C_Submit/edit/$1';
$route['SystemIntegration/KaizenGenerator/Delete/(:any)'] = 'SystemIntegration/MainMenu/Submit/C_Submit/delete/$1';
$route['SystemIntegration/KaizenGenerator/Pdf/(:any)'] = 'SystemIntegration/MainMenu/Submit/C_Submit/pdf/$1';
$route['SystemIntegration/KaizenGenerator/SubmitRealisasi/(:any)'] = 'SystemIntegration/MainMenu/Submit/C_Submit/realisasi/$1';

//My Kaizen
$route['SystemIntegration/KaizenGenerator/MyKaizen/index'] = 'SystemIntegration/MainMenu/MyKaizen/C_MyKaizen/index';
$route['SystemIntegration/KaizenGenerator/MyKaizen/view/(:any)'] = 'SystemIntegration/MainMenu/MyKaizen/C_MyKaizen/view/$1';
$route['SystemIntegration/KaizenGenerator/MyKaizen/SaveApprover'] = 'SystemIntegration/MainMenu/MyKaizen/C_MyKaizen/SaveApprover';
$route['SystemIntegration/KaizenGenerator/MyKaizen/report'] = 'SystemIntegration/MainMenu/MyKaizen/C_MyKaizen/report';

//My Team Kaizen
$route['SystemIntegration/KaizenGenerator/MyTeamKaizen/index'] = 'SystemIntegration/MainMenu/MyTeamKaizen/C_MyTeamKaizen/index';

//Report
$route['SystemIntegration/KaizenGenerator/Report/index'] = 'SystemIntegration/MainMenu/Report/C_Report/index';
$route['SystemIntegration/KaizenGenerator/Report/findexport'] = 'SystemIntegration/MainMenu/Report/C_Report/findexport';
$route['SystemIntegration/KaizenGenerator/Report/export'] = 'SystemIntegration/MainMenu/Report/C_Report/export';
$route['SystemIntegration/KaizenGenerator/Report/exportKaizen'] = 'SystemIntegration/MainMenu/Report/C_Report/exportKaizen';

//Approval Kaizen
$route['SystemIntegration/KaizenGenerator/ApprovalKaizen/index'] = 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/index';
$route['SystemIntegration/KaizenGenerator/ApprovalKaizen/result/(:any)'] = 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/$1';
$route['SystemIntegration/KaizenGenerator/ApprovalKaizen/View/(:any)'] = 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/view/$1';

//All Kaizen
$route['SystemIntegration/KaizenGenerator/AllKaizen/index'] = 'SystemIntegration/MainMenu/AllKaizen/C_AllKaizen/index';
$route['SystemIntegration/KaizenGenerator/Validate/Index'] = 'SystemIntegration/MainMenu/AllKaizen/C_AllKaizen/Validate';
$route['SystemIntegration/KaizenGenerator/Validate/findKaizen'] = 'SystemIntegration/MainMenu/AllKaizen/C_AllKaizen/findKaizen';

//---------------------------------------------------- Upah Pekerja Harian Lepas----------------------------------//
$route['UpahHlCm'] 		= 'UpahHlCm/C_UpahPHL';
$route['HitungHlcm/DataGaji'] 	= 'UpahHlCm/MasterData/C_DataGaji';
$route['HitungHlcm/DataGaji/(:any)'] 	= 'UpahHlCm/MasterData/C_DataGaji/$1';
$route['HitungHlcm/DataGaji/(:any)/(:any)'] 	= 'UpahHlCm/MasterData/C_DataGaji/$1/$2';
$route['HitungHlcm/DataPekerja'] 	= 'UpahHlCm/MasterData/C_DataPekerja';
$route['HitungHlcm/DataPekerja/(:any)'] 	= 'UpahHlCm/MasterData/C_DataPekerja/$1';
$route['HitungHlcm/DataPekerja/(:any)/(:any)'] 	= 'UpahHlCm/MasterData/C_DataPekerja/$1/$2';
$route['HitungHlcm/Approval'] 	= 'UpahHlCm/MasterData/C_Approval';
$route['HitungHlcm/Approval/(:any)'] 	= 'UpahHlCm/MasterData/C_Approval/$1';
$route['HitungHlcm/Approval/(:any)/(:any)'] 	= 'UpahHlCm/MasterData/C_Approval/$1/$2';
$route['HitungHlcm/UbahPekerjaan'] = 'UpahHlCm/MasterData/C_UbahPekerjaan';
$route['HitungHlcm/UbahPekerjaan/(:any)'] = 'UpahHlCm/MasterData/C_UbahPekerjaan/$1';
$route['HitungHlcm/UbahPekerjaan/(:any)/(:any)'] = 'UpahHlCm/MasterData/C_UbahPekerjaan/$1/$2';
$route['HitungHlcm/DataOvertimePHL'] = 'UpahHlCm/MasterData/C_Overtime';
$route['HitungHlcm/DataOvertimePHL/(:any)'] = 'UpahHlCm/MasterData/C_Overtime/$1';
$route['HitungHlcm/DataOvertimePHL/(:any)/(:any)'] = 'UpahHlCm/MasterData/C_Overtime/$1/$2';

$route['HitungHlcm/HitungGaji'] 	= 'UpahHlCm/ProsesGaji/C_ProsesGaji';
$route['HitungHlcm/HitungGaji/(:any)'] 	= 'UpahHlCm/ProsesGaji/C_ProsesGaji/$1';
$route['HitungHlcm/HitungGaji/(:any)/(:any)'] 	= 'UpahHlCm/ProsesGaji/C_ProsesGaji/$1/$2';
$route['HitungHlcm/HitungGaji/(:any)/(:any)/(:any)'] 	= 'UpahHlCm/ProsesGaji/C_ProsesGaji/$1/$2/$3';
$route['HitungHlcm/HitungGaji/(:any)/(:any)/(:any)/(:any)'] 	= 'UpahHlCm/ProsesGaji/C_ProsesGaji/$1/$2/$3/$4';

$route['HitungHlcm/SlipGaji'] 	= 'UpahHlCm/MenuCetak/C_SlipGaji';
$route['HitungHlcm/SlipGaji/(:any)'] 	= 'UpahHlCm/MenuCetak/C_SlipGaji/$1';
$route['HitungHlcm/SlipGaji/(:any)/(:any)'] 	= 'UpahHlCm/MenuCetak/C_SlipGaji/$1/$2';
$route['HitungHlcm/TandaTerima'] 	= 'UpahHlCm/MenuCetak/C_TandaTerima';
$route['HitungHlcm/TandaTerima/(:any)'] 	= 'UpahHlCm/MenuCetak/C_TandaTerima/$1';
$route['HitungHlcm/TandaTerima/(:any)/(:any)'] 	= 'UpahHlCm/MenuCetak/C_TandaTerima/$1/$2';
$route['HitungHlcm/Rekap'] 	= 'UpahHlCm/MenuCetak/C_Rekap';
$route['HitungHlcm/Rekap/(:any)'] 	= 'UpahHlCm/MenuCetak/C_Rekap/$1';
$route['HitungHlcm/Rekap/(:any)/(:any)'] 	= 'UpahHlCm/MenuCetak/C_Rekap/$1/$2';
$route['HitungHlcm/Memo'] 	= 'UpahHlCm/MenuCetak/C_Memo';
$route['HitungHlcm/Memo/(:any)'] 	= 'UpahHlCm/MenuCetak/C_Memo/$1';
$route['HitungHlcm/Memo/(:any)/(:any)'] 	= 'UpahHlCm/MenuCetak/C_Memo/$1/$2';
$route['HitungHlcm/Arsip'] 	= 'UpahHlCm/MenuCetak/C_Arsip';
$route['HitungHlcm/Arsip/(:any)'] 	= 'UpahHlCm/MenuCetak/C_Arsip/$1';
$route['HitungHlcm/Arsip/(:any)/(:any)'] 	= 'UpahHlCm/MenuCetak/C_Arsip/$1/$2';

//------------------------------------------------Inventory------------------------------------------------//
//Move Order
$route['InventoryManagement/CreateMoveOrder'] = 'Inventory/MainMenu/MoveOrder/C_MoveOrder';
$route['InventoryManagement/CreateMoveOrder/search/(:any)'] = 'Inventory/MainMenu/MoveOrder/C_MoveOrder/search/$1';
$route['InventoryManagement/CreateMoveOrder/(:any)'] = 'Inventory/MainMenu/MoveOrder/C_MoveOrder/$1';

//KIB
$route['InventoryManagement/CreateKIB'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB';
$route['InventoryManagement/CreateKIB/(:any)'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB/$1';
$route['InventoryManagement/CreateKIB/search/(:any)'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB/search/$1';
$route['InventoryManagement/CreateKIB/getSubInv'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB/getSubInv';
$route['InventoryManagement/CreateKIB/submitpdf'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB/submitpdf';
$route['InventoryManagement/CreateKIB/pdf/(:any)/(:any)/(:any)'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB/pdf/$1/$2/$3';
$route['InventoryManagement/CreateKIB/pdf2/(:any)/(:any)/(:any)'] = 'InventoryKIB/MainMenu/CreateKIB/C_CreateKIB/pdf2/$1/$2/$3';



//------------------------------------ Manufacturing Operation ----------------------------------------
$route['ManufacturingOperationUP2L']								= 'ManufacturingOperationUP2L/C_Index/index';
$route['ManufacturingOperationUP2L/Core']							= 'ManufacturingOperationUP2L/MainMenu/C_Core';
$route['ManufacturingOperationUP2L/Core/(:any)']					= 'ManufacturingOperationUP2L/MainMenu/C_Core/$1';
$route['ManufacturingOperationUP2L/Core/(:any)/(:any)'] 			= 'ManufacturingOperationUP2L/MainMenu/C_Core/$1/$2';

$route['ManufacturingOperationUP2L/Mixing']							= 'ManufacturingOperationUP2L/MainMenu/C_Mixing';
$route['ManufacturingOperationUP2L/Mixing/(:any)']					= 'ManufacturingOperationUP2L/MainMenu/C_Mixing/$1';
$route['ManufacturingOperationUP2L/Mixing/(:any)/(:any)']			= 'ManufacturingOperationUP2L/MainMenu/C_Mixing/$1/$2';
$route['ManufacturingOperationUP2L/Moulding']						= 'ManufacturingOperationUP2L/MainMenu/C_Moulding';
$route['ManufacturingOperationUP2L/Moulding/(:any)']				= 'ManufacturingOperationUP2L/MainMenu/C_Moulding/$1';
$route['ManufacturingOperationUP2L/Moulding/(:any)/(:any)']			= 'ManufacturingOperationUP2L/MainMenu/C_Moulding/$1/$2';
$route['ManufacturingOperationUP2L/MasterItem']						= 'ManufacturingOperationUP2L/MainMenu/C_MasterItem';
$route['ManufacturingOperationUP2L/MasterItem/(:any)']				= 'ManufacturingOperationUP2L/MainMenu/C_MasterItem/$1';
$route['ManufacturingOperationUP2L/MasterItem/(:any)/(:any)'] 		= 'ManufacturingOperationUP2L/MainMenu/C_MasterItem/$1/$2';
$route['ManufacturingOperationUP2L/MasterScrap']					= 'ManufacturingOperationUP2L/MainMenu/C_MasterScrap';
$route['ManufacturingOperationUP2L/MasterScrap/(:any)']				= 'ManufacturingOperationUP2L/MainMenu/C_MasterScrap/$1';
$route['ManufacturingOperationUP2L/MasterScrap/(:any)/(:any)'] 		= 'ManufacturingOperationUP2L/MainMenu/C_MasterScrap/$1/$2';
$route['ManufacturingOperationUP2L/MasterPersonal']					= 'ManufacturingOperationUP2L/MainMenu/C_MasterPersonal';
$route['ManufacturingOperationUP2L/MasterPersonal/(:any)']			= 'ManufacturingOperationUP2L/MainMenu/C_MasterPersonal/$1';
$route['ManufacturingOperationUP2L/MasterPersonal/(:any)/(:any)']	= 'ManufacturingOperationUP2L/MainMenu/C_MasterPersonal/$1/$2';
$route['ManufacturingOperationUP2L/QualityControl']					= 'ManufacturingOperationUP2L/MainMenu/C_QualityControl';
$route['ManufacturingOperationUP2L/QualityControl/(:any)']			= 'ManufacturingOperationUP2L/MainMenu/C_QualityControl/$1';
$route['ManufacturingOperationUP2L/QualityControl/(:any)/(:any)']	= 'ManufacturingOperationUP2L/MainMenu/C_QualityControl/$1/$2';
$route['ManufacturingOperationUP2L/XFIN']							= 'ManufacturingOperationUP2L/MainMenu/C_XFIN';
$route['ManufacturingOperationUP2L/XFIN/(:any)']					= 'ManufacturingOperationUP2L/MainMenu/C_XFIN/$1';
$route['ManufacturingOperationUP2L/XFIN/(:any)/(:any)']				= 'ManufacturingOperationUP2L/MainMenu/C_XFIN/$1/$2';

$route['ManufacturingOperationUP2L/Report']							= 'ManufacturingOperationUP2L/MainMenu/C_Report';
$route['ManufacturingOperationUP2L/Report/(:any)']					= 'ManufacturingOperationUP2L/MainMenu/C_Report/$1';
$route['ManufacturingOperationUP2L/Report/(:any)/(:any)']	        = 'ManufacturingOperationUP2L/MainMenu/C_Report/$1/$2';

$route['ManufacturingOperationUP2L/Selep']							= 'ManufacturingOperationUP2L/MainMenu/C_Selep';
$route['ManufacturingOperationUP2L/Selep/(:any)']					= 'ManufacturingOperationUP2L/MainMenu/C_Selep/$1';
$route['ManufacturingOperationUP2L/Selep/(:any)/(:any)']			= 'ManufacturingOperationUP2L/MainMenu/C_Selep/$1/$2';

$route['ManufacturingOperationUP2L/Ajax/(:any)']					= 'ManufacturingOperationUP2L/Ajax/C_Ajax/$1';
$route['ManufacturingOperationUP2L/Ajax/(:any)/(:any)']				= 'ManufacturingOperationUP2L/Ajax/C_Ajax/$1/$2';
$route['ManufacturingOperationUP2L/Job/ReplaceComp']				= 'ManufacturingOperationUP2L/MainMenu/C_ReplaceComp';
$route['ManufacturingOperationUP2L/Job/ReplaceComp/(:any)']			= 'ManufacturingOperationUP2L/MainMenu/C_ReplaceComp/$1';
$route['ManufacturingOperationUP2L/Job/ReplaceComp/(:any)/(:any)']	= 'ManufacturingOperationUP2L/MainMenu/C_ReplaceComp/$1/$2';
$route['ManufacturingOperationUP2L/Job/ReplaceComp/(:any)/(:any)/(:any)']	= 'ManufacturingOperationUP2L/MainMenu/C_ReplaceComp/$1/$2/$3';


//------------------------------------Employee Recruitment---------------------------------------------//

$route['EmployeeRecruitment']		= 'EmployeeRecruitment/C_TestCorrection/index';
$route['EmployeeRecruitment/Upload/index']		= 'EmployeeRecruitment/C_UploadData/index';
$route['EmployeeRecruitment/Upload/inputfile']		= 'EmployeeRecruitment/C_UploadData/inputfile';
$route['EmployeeRecruitment/Upload/process']		= 'EmployeeRecruitment/C_UploadData/process';
$route['EmployeeRecruitment/Upload/export']		= 'EmployeeRecruitment/C_UploadData/export';

//result
$route['EmployeeRecruitment/Result/index']		= 'EmployeeRecruitment/C_Result/index';

//setting
$route['EmployeeRecruitment/Setting/index']		= 'EmployeeRecruitment/C_Setting/index';
$route['EmployeeRecruitment/Setting/edit/(:any)']	= 'EmployeeRecruitment/C_Setting/edit/$1';
$route['EmployeeRecruitment/Setting/saveedit']		= 'EmployeeRecruitment/C_Setting/saveedit';
$route['EmployeeRecruitment/Setting/addnew']		= 'EmployeeRecruitment/C_Setting/addnew';
$route['EmployeeRecruitment/Setting/saveadd']		= 'EmployeeRecruitment/C_Setting/saveadd';
$route['EmployeeRecruitment/Setting/delete']		= 'EmployeeRecruitment/C_Setting/delete';

//delete
$route['EmployeeRecruitment/Delete/index']		= 'EmployeeRecruitment/C_Delete/index';
$route['EmployeeRecruitment/Delete/delete']		= 'EmployeeRecruitment/C_Delete/delete';
//--------------------------------------------------- User Manual --------------------------------------------------//
$route['usermanual'] = 'UserManual/C_Index';
$route['usermanual/upload'] = 'UserManual/C_Index/upload';
$route['usermanual/upload/(:any)'] = 'UserManual/C_Index/$1';
$route['usermanual/upload/(:any)/(:any)'] = 'UserManual/C_Index/$1/$2';
$route['usermanual/upload/(:any)/(:any)/(:any)'] = 'UserManual/C_Index/$1/$2/$3';

//-----------------------------------------------------ADM Cabang------------------------------------------------------//
$route['AdmCabang'] = 'ADMCabang/C_Index';

$route['AdmCabang/PresensiHarian'] = 'ADMCabang/C_PresensiHarian';
$route['AdmCabang/PresensiHarian/(:any)'] = 'ADMCabang/C_PresensiHarian/$1';

$route['AdmCabang/PresensiBulanan'] = 'ADMCabang/C_PresensiBulanan';
$route['AdmCabang/PresensiBulanan/(:any)'] = 'ADMCabang/C_PresensiBulanan/$1';

//--------------------------------------------- Branch Item --------------------------------------------
$route['BranchItem'] = 'BarangCabang/C_branchitem';
$route['BranchItem/PemindahanBarang/Input'] = 'BarangCabang/C_branchitem/InputBarang';
$route['BranchItem/PemindahanBarang/Input/(:any)'] = 'BarangCabang/C_branchitem/InputBarang/$1';
$route['BranchItem/PemindahanBarang/Input/AddMasalah'] = 'BarangCabang/C_branchitem/Addpemindahan';
$route['BranchItem/PemindahanBarang/Input/AddMasalah/insert'] = 'BarangCabang/C_branchitem/insertPemindahanHeader';
$route['BranchItem/PemindahanBarang/Input/AddMasalah/insert/line'] = 'BarangCabang/C_branchitem/insertPemindahanLine';
$route['BranchItem/PemindahanBarang/Input/AddMasalah/flagging'] = 'BarangCabang/C_branchitem/FlaggingPemindahanHeader';
$route['BranchItem/PemindahanBarang/Input/edit/(:any)'] = 'BarangCabang/C_branchitem/EditPemindahan/$1';
$route['BranchItem/PemindahanBarang/Input/edit/update'] = 'BarangCabang/C_branchitem/UpdatePemindahanLine/';
$route['BranchItem/PemindahanBarang/Input/edit/update/(:any)'] = 'BarangCabang/C_branchitem/UpdatePemindahanLine/$1';
$route['BranchItem/PemindahanBarang/View'] = 'BarangCabang/C_branchitem/Viewpemindahan';
$route['BranchItem/PemindahanBarang/View/Data'] = 'BarangCabang/C_branchitem/SearchTanggalPemindahan';
$route['BranchItem/PemindahanBarang/View/Detail/(:any)'] = 'BarangCabang/C_branchitem/Viewdetailpemindahan/$1';

$route['BranchItem/PenangananBarang/Input'] = 'BarangCabang/C_branchitem/InputPenanganan';
$route['BranchItem/PenangananBarang/Input/(:any)'] = 'BarangCabang/C_branchitem/InputPenanganan/$1';
$route['BranchItem/PenangananBarang/Input/AddMasalah'] = 'BarangCabang/C_branchitem/AddPenanganan';
$route['BranchItem/PenangananBarang/Input/AddMasalah/insert'] = 'BarangCabang/C_branchitem/insertPenangananHeader';
$route['BranchItem/PenangananBarang/Input/AddMasalah/insert/insertLine'] = 'BarangCabang/C_branchitem/insertPenangananLine';
$route['BranchItem/PenangananBarang/Input/AddMasalah/flagging'] = 'BarangCabang/C_branchitem/FlaggingPenangananHeader';
$route['BranchItem/PenangananBarang/Input/edit/(:any)'] = 'BarangCabang/C_branchitem/EditPenanganan/$1';
$route['BranchItem/PenangananBarang/Input/edit/update'] = 'BarangCabang/C_branchitem/UpdatePenangananLine/';
$route['BranchItem/PenangananBarang/Input/edit/update/(:any)'] = 'BarangCabang/C_branchitem/UpdatePenangananLine/$1';
$route['BranchItem/PenangananBarang/View'] = 'BarangCabang/C_branchitem/Viewpenanganan';
$route['BranchItem/PenangananBarang/View/Data'] = 'BarangCabang/C_branchitem/SearchPenanganan';
$route['BranchItem/PenangananBarang/View/Detail/(:any)'] = 'BarangCabang/C_branchitem/ViewDetailPenanganan/$1';

$route['BranchItem/getOrg'] = 'BarangCabang/C_branchitem/getOrg';
$route['BranchItem/getBarang'] = 'BarangCabang/C_branchitem/getBarang';

//--------------------------------------------------Management Admin----------------------------------------------------//
$route['ManagementAdmin'] = 'ManagementAdmin/C_Index';

$route['ManagementAdmin/Target'] = 'ManagementAdmin/MainMenu/C_Target';
$route['ManagementAdmin/Target/(:any)'] = 'ManagementAdmin/MainMenu/C_Target/$1';
$route['ManagementAdmin/Target/(:any)/(:any)'] = 'ManagementAdmin/MainMenu/C_Target/$1/$2';

$route['ManagementAdmin/Pekerja'] = 'ManagementAdmin/MainMenu/C_Pekerja';
$route['ManagementAdmin/Pekerja/(:any)'] = 'ManagementAdmin/MainMenu/C_Pekerja/$1';
$route['ManagementAdmin/Pekerja/(:any)/(:any)'] = 'ManagementAdmin/MainMenu/C_Pekerja/$1/$2';

$route['ManagementAdmin/Proses'] = 'ManagementAdmin/MainMenu/C_Proses';
$route['ManagementAdmin/Proses/(:any)'] = 'ManagementAdmin/MainMenu/C_Proses/$1';
$route['ManagementAdmin/Proses/(:any)/(:any)'] = 'ManagementAdmin/MainMenu/C_Proses/$1/$2';

$route['ManagementAdmin/Pending'] = 'ManagementAdmin/MainMenu/C_Pending';
$route['ManagementAdmin/Pending/(:any)'] = 'ManagementAdmin/MainMenu/C_Pending/$1';
$route['ManagementAdmin/Pending/(:any)/(:any)'] = 'ManagementAdmin/MainMenu/C_Pending/$1/$2';

$route['ManagementAdmin/Monitoring'] = 'ManagementAdmin/MainMenu/C_Monitoring';

$route['ManagementAdmin/Input'] = 'ManagementAdmin/MainMenu/C_Input';
$route['ManagementAdmin/Input/(:any)'] = 'ManagementAdmin/MainMenu/C_Input/$1';

$route['ManagementAdmin/cetak'] = 'ManagementAdmin/MainMenu/C_Cetak';
$route['ManagementAdmin/Cetak/(:any)'] = 'ManagementAdmin/MainMenu/C_Cetak/$1';


$route['ManagementAdminUser'] = 'ManagementAdmin/MainMenu/C_Proses';

//------------------------------------ Aplikasi Warehouse ----------------------------
$route['Warehouse']									= 'Warehouse/C_Index';
$route['Warehouse/MasterItem']						= 'Warehouse/MainMenu/C_MasterItem';
$route['Warehouse/MasterItem/(:any)']				= 'Warehouse/MainMenu/C_MasterItem/$1';
$route['Warehouse/MasterItem/(:any)/(:any)']		= 'Warehouse/MainMenu/C_MasterItem/$1/$2';
$route['Warehouse/Transaksi']						= 'Warehouse/MainMenu/C_Transaksi';
$route['Warehouse/Transaksi/(:any)']				= 'Warehouse/MainMenu/C_Transaksi/$1';
$route['Warehouse/Transaksi/(:any)/(:any)']			= 'Warehouse/MainMenu/C_Transaksi/$1/$2';
$route['Warehouse/Transaksi/(:any)/(:any)/(:any)']	= 'Warehouse/MainMenu/C_Transaksi/$1/$2/$3';
$route['Warehouse/Transaksi/(:any)/(:any)/(:any)']	= 'Warehouse/MainMenu/C_Transaksi/$1/$2/$3';
$route['Warehouse/Transaksi/Keluar/Consumable']		= 'Warehouse/MainMenu/C_Transaksi/KeluarConsumable';
$route['Warehouse/Transaksi/CreatePeminjamanConsumable']	= 'Warehouse/MainMenu/C_Transaksi/CreatePeminjamanConsumable';
$route['Warehouse/Transaksi/addNewItemConsumable']	= 'Warehouse/MainMenu/C_Transaksi/addNewItemConsumable';
$route['Warehouse/Transaksi/UpdateItemConsumable']	= 'Warehouse/MainMenu/C_Transaksi/UpdateItemConsumable';
$route['Warehouse/Transaksi/removeNewItemConsumable']	= 'Warehouse/MainMenu/C_Transaksi/removeNewItemConsumable';

//------------------------------------ TRACKING INVOICE ----------------------------
$route['TrackingInvoice'] = 'TrackingInvoice/C_trackingInvoice';
$route['Monitoring/TrackingInvoice'] = 'TrackingInvoice/C_trackingInvoice/TrackingInvoice';
$route['Monitoring/TrackingInvoice/(:any)'] = 'TrackingInvoice/C_trackingInvoice/$1';
$route['Monitoring/TrackingInvoice/(:any)/(:any)'] = 'TrackingInvoice/C_trackingInvoice/$1/$2';

//-----------------------------------Tarik FingerSpot----------------------------------//
$route['TarikFingerspot'] = 'TarikFingerspot/C_TarikFingerspot';
$route['TarikFingerspot/TarikData'] = 'TarikFingerspot/C_TarikFingerspot/TarikData';
$route['TarikFingerspot/TarikData/(:any)'] = 'TarikFingerspot/C_TarikFingerspot/TarikData/$1';
$route['TarikFingerspot/TransferPresensi'] = 'TarikFingerspot/C_TarikFingerspot/TransferPresensi';
$route['TarikFingerspot/TransferPresensi/(:any)'] = 'TarikFingerspot/C_TarikFingerspot/TransferPresensi/$1';

//--------------------------------------------------- Check PPh --------------------------------------------------//
$route['AccountPayables/CheckPPh/Upload'] = 'CheckPPH/MainMenu/C_Upload';
$route['AccountPayables/CheckPPh/Upload/(:any)'] = 'CheckPPH/MainMenu/C_Upload/$1';
$route['AccountPayables/CheckPPh/List'] = 'CheckPPH/MainMenu/C_List';
$route['AccountPayables/CheckPPh/List/(:any)'] = 'CheckPPH/MainMenu/C_List/$1';

//---------------------------------------------- Surat Perintah Lembur -------------------------------------------//
$route['SPL'] = 'SPLSeksi/C_splseksi';
$route['SPL/InputLembur'] = 'SPLSeksi/C_splseksi/new_spl';
$route['SPL/ListLembur'] = 'SPLSeksi/C_splseksi/data_spl';
$route['SPL/RekapLembur'] = 'SPLSeksi/C_splseksi/rekap_spl';
$route['SPL/EditLembur/(:any)'] = 'SPLSeksi/C_splseksi/edit_spl/$1';
$route['SPL/HapusLembur/(:any)'] = 'SPLSeksi/C_splseksi/hapus_spl/$1';

$route['ALK/ListLembur'] = 'SPLSeksi/C_splkasie/data_spl';
$route['ALK/Approve/(:any)'] = 'SPLSeksi/C_splkasie/$1';
$route['ALA/ListLembur'] = 'SPLSeksi/C_splasska/data_spl';
$route['ALA/Approve/(:any)'] = 'SPLSeksi/C_splasska/$1';

//---------------------------------------------------- Booking Kendaraan --------------------------------------//
// hati hati kadang any any gak bisa kepanggil
$route['AdminBookingKendaraan/DataKendaraan'] = 'BookingKendaraan/C_AdminData';
$route['AdminBookingKendaraan/DataKendaraan/(:any)'] = 'BookingKendaraan/C_AdminData/$1';
$route['AdminBookingKendaraan/DataKendaraan/(:any)/(:any)'] = 'BookingKendaraan/C_AdminData/$1/$2';

$route['BookingKendaraan/LogPeminjaman'] = 'BookingKendaraan/C_logpeminjaman';
$route['BookingKendaraan/LogPeminjaman/(:any)'] = 'BookingKendaraan/C_logpeminjaman/$1';
$route['BookingKendaraan/LogPeminjaman/(:any)/(:any)'] = 'BookingKendaraan/C_logpeminjaman/$1/$2';

$route['BookingKendaraan/CariMobil'] = 'BookingKendaraan/C_Carimobil';
$route['BookingKendaraan/CariMobil/(:any)'] = 'BookingKendaraan/C_Carimobil/$1';
$route['BookingKendaraan/CariMobil/(:any)/(:any)'] = 'BookingKendaraan/C_Carimobil/$1/$2';

$route['AdminBookingKendaraan'] = 'BookingKendaraan/C_Admin';
$route['AdminBookingKendaraan/(:any)'] = 'BookingKendaraan/C_Admin/$1';
$route['AdminBookingKendaraan/(:any)/(:any)'] = 'BookingKendaraan/C_Admin/$1/$2';

$route['AdminBookingKendaraan/RequestKendaraan'] = 'BookingKendaraan/C_AdminView';
$route['AdminBookingKendaraan/RequestKendaraan/(:any)'] = 'BookingKendaraan/C_AdminView/$1';
$route['AdminBookingKendaraan/RequestKendaraan/(:any)/(:any)'] = 'BookingKendaraan/C_AdminView/$1/$2';

$route['BookingKendaraan'] = 'BookingKendaraan/C_Index';
$route['BookingKendaraan/(:any)'] = 'BookingKendaraan/C_Index/$1';
$route['BookingKendaraan/(:any)/(:any)'] = 'BookingKendaraan/C_Index/$1/$2';

//-------------------------------------------------------PNBP Administrator--------------------------------------//
$route['PNBP'] = 'PNBPAdministrator/C_PNBPAdministrator';

$route['PNBP/SetupAdmin'] = 'PNBPAdministrator/C_SetupAdmin';
$route['PNBP/SetupAdmin/(:any)'] = 'PNBPAdministrator/C_SetupAdmin/$1';
$route['PNBP/SetupAdmin/(:any)/(:any)'] = 'PNBPAdministrator/C_SetupAdmin/$1/$2';

$route['PNBP/SetupKelompok'] = 'PNBPAdministrator/C_SetupKelompok';
$route['PNBP/SetupKelompok/(:any)'] = 'PNBPAdministrator/C_SetupKelompok/$1';
$route['PNBP/SetupKelompok/(:any)/(:any)'] = 'PNBPAdministrator/C_SetupKelompok/$1/$2';

$route['PNBP/SetupIndikator'] = 'PNBPAdministrator/C_SetupIndikator';
$route['PNBP/SetupIndikator/(:any)'] = 'PNBPAdministrator/C_SetupIndikator/$1';
$route['PNBP/SetupIndikator/(:any)/(:any)'] = 'PNBPAdministrator/C_SetupIndikator/$1/$2';

$route['PNBP/SetupPernyataan'] = 'PNBPAdministrator/C_SetupPernyataan';
$route['PNBP/SetupPernyataan/(:any)'] = 'PNBPAdministrator/C_SetupPernyataan/$1';
$route['PNBP/SetupPernyataan/(:any)/(:any)'] = 'PNBPAdministrator/C_SetupPernyataan/$1/$2';

$route['PNBP/SetupQuestioner'] = 'PNBPAdministrator/C_SetupQuestioner';
$route['PNBP/SetupQuestioner/(:any)'] = 'PNBPAdministrator/C_SetupQuestioner/$1';
$route['PNBP/SetupQuestioner/(:any)/(:any)'] = 'PNBPAdministrator/C_SetupQuestioner/$1/$2';

$route['PNBP/Questioner'] = 'PNBPAdministrator/C_Questioner';
$route['PNBP/Questioner/(:any)'] = 'PNBPAdministrator/C_Questioner/$1';
$route['PNBP/Questioner/(:any)/(:any)'] = 'PNBPAdministrator/C_Questioner/$1/$2';

$route['PNBP/QuestionerAdmin'] = 'PNBPAdministrator/C_QuestionerAdministrator';
$route['PNBP/QuestionerAdmin/(:any)'] = 'PNBPAdministrator/C_QuestionerAdministrator/$1';
$route['PNBP/QuestionerAdmin/(:any)/(:any)'] = 'PNBPAdministrator/C_QuestionerAdministrator/$1/$2';

$route['PNBP/Report'] = 'PNBPAdministrator/C_Report';
$route['PNBP/Report/(:any)'] = 'PNBPAdministrator/C_Report/$1';
$route['PNBP/Report/(:any)'] = 'PNBPAdministrator/C_Report/$1/$2';


 //----------------------------------- Monitoring Barang Gudang ------------------------------------------------//

 $route['MonitoringBarangGudang'] = 'WarehouseMPO/C_Index';

 $route['MonitoringBarangGudang/Pengeluaran'] = 'WarehouseMPO/Spbs/C_Spbs';
 $route['MonitoringBarangGudang/Pengeluaran/Search'] = 'WarehouseMPO/Spbs/C_Spbs/search';
 
 $route['MonitoringBarangGudang/Pengeluaran/Filter'] = 'WarehouseMPO/C_OutPart/filterOut';
 $route['MonitoringBarangGudang/Pengeluaran/Filter/(:any)'] = 'WarehouseMPO/C_OutPart/filterOut/$1';
 $route['MonitoringBarangGudang/Pengeluaran/(:any)'] = 'WarehouseMPO/C_OutPart/filterByGudang/$1';
 $route['MonitoringBarangGudang/Pengeluaran/(:any)/(:any)'] = 'WarehouseMPO/C_OutPart/filterByGudang/$1/$2';
 //$route['MonitoringBarangGudang/Pengeluaran/(:any)/(:any)/(:any)'] = 'WarehouseMPO/C_OutPart/filterByGudang/$1/$2/$3';
 $route['MonitoringBarangGudang/Pengeluaran/Update'] = 'WarehouseMPO/C_OutPart/Update';
 $route['MonitoringBarangGudang/Pengeluaran/Car'] = 'WarehouseMPO/C_OutPart/getNomorCar';
 
 $route['MonitoringBarangGudang/SparePart'] = 'WarehouseMPO/C_SparePart';
 $route['MonitoringBarangGudang/SparePart/(:any)'] = 'WarehouseMPO/C_SparePart/$1';
 $route['MonitoringBarangGudang/SparePart/(:any)/(:any)'] = 'WarehouseMPO/C_SparePart/$1/$2';
 $route['MonitoringBarangGudang/SparePart/Filter'] = 'WarehouseMPO/C_SparePart/filterSpare';
 
 $route['MonitoringBarangGudang/Pengeluaran/insertData'] = 'WarehouseMPO/Spbs/C_Spbs/insertData';
 $route['MonitoringBarangGudang/Pengeluaran/updateData'] = 'WarehouseMPO/Spbs/C_Spbs/updateData';

//--------------------------------------------------- Cetak Perhitungan Pesangon -----------------------------------//
$route['MasterPekerja/PerhitunganPesangon'] 		= 'MasterPekerja/PerhitunganPesangon/C_Index';
$route['MasterPekerja/PerhitunganPesangon/(:any)'] = 'MasterPekerja/PerhitunganPesangon/C_Index/$1';
$route['MasterPekerja/PerhitunganPesangon/(:any)/(:any)'] = 'MasterPekerja/PerhitunganPesangon/C_Index/$1/$2';

//----------------MonitoringPembelian------------------
 $route['MonitoringPembelian'] = 'MonitoringPembelian/C_Index/index';
 $route['MonitoringPembelian/EditData'] = 'MonitoringPembelian/EditData/C_Monitoring/index';
 $route['MonitoringPembelian/EditData/(:any)'] = 'MonitoringPembelian/EditData/C_Monitoring/$1';
 $route['MonitoringPembelian/EditData/(:any)/(:any)'] = 'MonitoringPembelian/EditData/C_Monitoring/$1/$2';

 $route['MonitoringPembelian/Monitoring'] = 'MonitoringPembelian/Input/C_Input/index';
 $route['MonitoringPembelian/Monitoring/(:any)'] = 'MonitoringPembelian/Input/C_Input/$1';

 $route['MonitoringPembelian/MonitoringPE'] = 'MonitoringPembelian/EditData/C_MonitoringPE/index';
 $route['MonitoringPembelian/MonitoringPE/(:any)'] = 'MonitoringPembelian/EditData/C_MonitoringPE/$1';
 $route['MonitoringPembelian/MonitoringPE/(:any)/(:any)'] = 'MonitoringPembelian/EditData/C_MonitoringPE/$1/$2';

 $route['MonitoringPembelian/HistoryRequest'] = 'MonitoringPembelian/Input/C_History/index';

 //----------------Resource Opname------------------
 $route['OpnameResource']			= 'OpnameResource/MainMenu/C_TarikData';
 $route['OpnameResource/TarikData']  = 'OpnameResource/MainMenu/C_TarikData/TarikData';
 $route['OpnameResource/Export']  = 'OpnameResource/MainMenu/C_TarikData/Export';




 //---------------------------Setting Min Max OPM-------------------------------//
 $route['SettingMinMax'] = 'SettingMinMaxOPM/C_settingMinMaxOPM/index';
 $route['SettingMinMax/Edit'] = 'SettingMinMaxOPM/C_settingMinMaxOPM/Edit';
 $route['SettingMinMax/EditbyRoute'] = 'SettingMinMaxOPM/C_settingMinMaxOPM/EditbyRoute';
 $route['SettingMinMax/EditbyRoute/EditItem/(:any)/(:any)'] = 'SettingMinMaxOPM/C_settingMinMaxOPM/EditItem/$1/$2';
 $route['SettingMinMax/EditbyRoute/EditItem/(:any)/(:any)/(:any)'] = 'SettingMinMaxOPM/C_settingMinMaxOPM/EditItem/$1/$2/$3';
 $route['SettingMinMax/SaveMinMax'] = 'SettingMinMaxOPM/C_settingMinMaxOPM/SaveMinMax';

  //----------------------------------- Internal Audit ------------------------------------------------//

 $route['InternalAudit'] = 'InternalAudit/C_Index';
 $route['InternalAudit/CreateImprovement'] = 'InternalAudit/MainMenu/CreateImprovement/C_CreateImprovement';
 $route['InternalAudit/CreateImprovement/(:any)'] = 'InternalAudit/MainMenu/CreateImprovement/C_CreateImprovement/$1';

 $route['InternalAudit/SettingAccount/AuditObject'] = 'InternalAudit/MainMenu/SettingAccount/C_AuditObject';
 $route['InternalAudit/SettingAccount/AuditObject/(:any)'] = 'InternalAudit/MainMenu/SettingAccount/C_AuditObject/$1';
 $route['InternalAudit/SettingAccount/AuditObject/(:any)/(:any)'] = 'InternalAudit/MainMenu/SettingAccount/C_AuditObject/$1/$2';
 $route['InternalAudit/SettingAccount/User'] = 'InternalAudit/MainMenu/SettingAccount/C_SettingUser';
 $route['InternalAudit/SettingAccount/User/(:any)'] = 'InternalAudit/MainMenu/SettingAccount/C_SettingUser/$1';
 $route['InternalAudit/SettingAccount/User/(:any)/(:any)'] = 'InternalAudit/MainMenu/SettingAccount/C_SettingUser/$1/$2';

 $route['InternalAudit/MonitoringImprovement'] = 'InternalAudit/MainMenu/MonitoringImprovement/C_MonitoringImprovement';
 $route['InternalAudit/MonitoringImprovement/(:any)'] = 'InternalAudit/MainMenu/MonitoringImprovement/C_MonitoringImprovement/$1';
 $route['InternalAudit/MonitoringImprovement/(:any)/(:any)'] = 'InternalAudit/MainMenu/MonitoringImprovement/C_MonitoringImprovement/$1/$2';

 $route['InternalAudit/MonitoringImprovementAuditee'] = 'InternalAudit/MainMenu/Auditee/MonitoringImprovement/C_MonitoringImprovement';
 $route['InternalAudit/MonitoringImprovementAuditee/(:any)'] = 'InternalAudit/MainMenu/Auditee/MonitoringImprovement/C_MonitoringImprovement/$1';
 $route['InternalAudit/MonitoringImprovementAuditee/(:any)/(:any)'] = 'InternalAudit/MainMenu/Auditee/MonitoringImprovement/C_MonitoringImprovement/$1/$2';

 //------------------------------------ MONITORING LPPB ----------------------------
 $route['MonitoringLppb'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin';
 $route['MonitoringLPPB/SubmitLppb'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/newLppbNumber';
 $route['MonitoringLPPB/NewDrafLppb'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/showLppbBatchAdmin';
 $route['MonitoringLPPB/RejectLppb'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/showRejectLppb';
 $route['MonitoringLPPB/RejectLppb/(:any)'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/$1';
 $route['MonitoringLPPB/RejectLppb/(:any)/(:any)'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/$1/$2';
 $route['MonitoringLPPB/ListBatch/(:any)'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/$1';
 $route['MonitoringLPPB/ListBatch/(:any)/(:any)'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/$1/$2';
 $route['MonitoringLPPB/Finish'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/Finish';
 $route['MonitoringLPPB/Finish/(:any)/(:any)'] = 'MonitoringLppbAdmin/C_monitoringlppbadmin/$1/$2';

 //------------------------------------ MONITORING LPPB Kasie Gudang ----------------------------
 $route['MonitoringLppbKasiesGudang'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang';
 $route['MonitoringLppbKasieGudang/Unprocess'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/index';
 $route['MonitoringLppbKasieGudang/Unprocess/(:any)'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/$1';
 $route['MonitoringLppbKasieGudang/Unprocess/(:any)/(:any)'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/$1/$2';
 $route['MonitoringLppbKasieGudang/Reject'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/Reject';
 $route['MonitoringLppbKasieGudang/Reject/(:any)/(:any)'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/$1/$2';

 $route['MonitoringLppbKasieGudang/Finish'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/Finish';
 $route['MonitoringLppbKasieGudang/Finish/(:any)/(:any)'] = 'MonitoringLppbKasieGudang/C_monitoringlppbkasiegudang/$1/$2';

 //------------------------------------ MONITORING LPPB KASIE AKUNTANSI ----------------------------
 $route['MonitoringLppbAkuntansi'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi';
 $route['MonitoringLppbAkuntansi/Unprocess'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/index';
 $route['MonitoringLppbAkuntansi/Unprocess/(:any)'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/$1';
 $route['MonitoringLppbAkuntansi/Unprocess/(:any)/(:any)'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/$1/$2';

 $route['MonitoringLppbAkuntansi/Reject'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/Reject';
 $route['MonitoringLppbAkuntansi/Reject/(:any)/(:any)'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/$1/$2';

 $route['MonitoringLppbAkuntansi/Finish'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/Finish';
 $route['MonitoringLppbAkuntansi/Finish/(:any)/(:any)'] = 'MonitoringLppbAkuntansi/C_monitoringlppbakuntansi/$1/$2';

 //------------------------------------ TRACKING LPPB ----------------------------
 $route['TrackingLppb'] = 'TrackingLppb/C_trackinglppb';
 $route['TrackingLppb/Tracking/(:any)'] = 'TrackingLppb/C_trackinglppb/$1';
 $route['TrackingLppb/Tracking/(:any)/(:any)'] = 'TrackingLppb/C_trackinglppb/$1/$2';


// ------------------------------------------------- Order Sharpening ---------------------------------------------//
$route['OrderSharpening'] 		= 'OrderSharpening/C_Index';
$route['OrderSharpening/Order'] 		= 'OrderSharpening/C_Order';
$route['OrderSharpening/Order/(:any)'] 		= 'OrderSharpening/C_Order/$1';
$route['OrderSharpening/Order/(:any)/(:any)'] 		= 'OrderSharpening/C_Order/$1/$2';
$route['OrderSharpening/Order/Insert'] 		= 'OrderSharpening/C_Order/Insert';
$route['OrderSharpening/Order/getDeskripsi'] 		= 'OrderSharpening/C_Order/getDeskripsi';
$route['OrderSharpening/Report/(:any)'] 		= 'OrderSharpening/C_Order/Report/$1';
// ------------------------------------------------- Order Sharpening Android---------------------------------------------//
$route['OrderSharpening/Order/getAllData'] 		= 'OrderSharpening/C_Order/getAllData';
$route['OrderSharpening/Order/getDetailData/(:any)'] 		= 'OrderSharpening/C_Order/getDetailData/$1';
$route['OrderSharpening/transactMo/(:any)'] 		= 'OrderSharpening/C_Order/transactMo/$1';
$route['OrderSharpening/Order/hapusData/(:any)'] 		= 'OrderSharpening/C_Order/hapusData/$1';

// ------------------------------------------------- Aplikasi Hiwing Monitoring ---------------------------------------------//
$route['HiwingMonitoring'] 		= 'HiwingMonitoring/C_Index';
$route['HiwingMonitoring/Pengiriman'] 		= 'HiwingMonitoring/C_Pengiriman';
$route['HiwingMonitoring/Monitoring'] 		= 'HiwingMonitoring/C_Monitoring';
$route['HiwingMonitoring/Pengiriman/Insert'] 		= 'HiwingMonitoring/C_Pengiriman/Insert';
$route['HiwingMonitoring/Pengiriman/Report'] 		= 'HiwingMonitoring/C_Pengiriman/Report';
$route['HiwingMonitoring/Report/(:any)'] 		= 'HiwingMonitoring/C_Pengiriman/Report/$1';
$route['HiwingMonitoring/Pengiriman/getAva']	= 'HiwingMonitoring/C_Pengiriman/getAva';

$route['HiwingMonitoring/Pengiriman/getPengirim'] = 'HiwingMonitoring/C_Pengiriman/getPengirim';
$route['HiwingMonitoring/Pengiriman/getPenerima'] = 'HiwingMonitoring/C_Pengiriman/getPenerima';

$route['HiwingMonitoring/Monitoring/getDetail'] = 'HiwingMonitoring/C_Monitoring/getDetail';
$route['HiwingMonitoring/Monitoring/getDetail/(:any)'] = 'HiwingMonitoring/C_Monitoring/getDetail/$1';
$route['HiwingMonitoring/Monitoring/showDetail'] ='HiwingMonitoring/C_Monitoring/showDetail';

// ------------------------------------------------- Monitoring Omset Akuntansi ---------------------------------------------//
$route['MonitoringOmsetAkuntansi'] = 'MonitoringOmsetAkuntansi/C_MonitoringOmsetAkuntansi';
$route['MonitoringOmsetAkuntansi/Monitoring/(:any)'] = 'MonitoringOmsetAkuntansi/C_MonitoringOmsetAkuntansi/$1';
$route['MonitoringOmsetAkuntansi/Monitoring/(:any)/(:any)'] = 'MonitoringOmsetAkuntansi/C_MonitoringOmsetAkuntansi/$1/$2';
//-------------------------Evaluasi TIMS------------------------------------------------------//
$route['EvaluasiTIMS'] = 'EvaluasiTIMS/C_Index/index';
$route['EvaluasiTIMS/Harian'] = 'EvaluasiTIMS/C_Index/Harian';
$route['EvaluasiTIMS/Harian/(:any)'] = 'EvaluasiTIMS/C_Index/$1';
$route['EvaluasiTIMS/Harian/(:any)/(:any)'] = 'EvaluasiTIMS/C_Index/$1/$2';
$route['EvaluasiTIMS/Harian/(:any)/(:any)/(:any)'] = 'EvaluasiTIMS/C_Index/$1/$2/$3';
$route['EvaluasiTIMS/Bulanan'] = 'EvaluasiTIMS/C_Index/Bulanan';
$route['EvaluasiTIMS/Bulanan/(:any)'] = 'EvaluasiTIMS/C_Index/$1';
$route['EvaluasiTIMS'] = 'EvaluasiTIMS/C_Index/index';
$route['EvaluasiTIMS/Setup/(:any)'] = 'EvaluasiTIMS/C_Index/$1';
$route['EvaluasiTIMS/Setup/(:any)/(:any)'] = 'EvaluasiTIMS/C_Index/$1/$2';

//-------------------------------------------------Stok Gudang Alat-----------------------------------------------------//
$route['StockGudangAlat'] = 'StockGudangAlat/C_StockGudangAlat';
$route['StockGudangAlat/Stock/(:any)'] = 'StockGudangAlat/C_StockGudangAlat/$1';
$route['StockGudangAlat/Stock/(:any)/(:any)'] = 'StockGudangAlat/C_StockGudangAlat/$1/$2';
$route['StockGudangAlat/Stock/(:any)/(:any)/(:any)'] = 'StockGudangAlat/C_StockGudangAlat/$1/$2/$3';

//-----------------------------------------------------Transact Bon------------------------------------------------------------//
$route['TransactBon'] = 'TransactBon/C_Transact';
$route['TransactBon/Transact/(:any)'] = 'TransactBon/C_Transact/$1';
$route['TransactBon/Transact/(:any)/(:any)'] = 'TransactBon/C_Transact/$1/$2';
$route['TransactBon/Transact/(:any)/(:any)/(:any)'] = 'TransactBon/C_Transact/$1/$2/$3';
$route['TransactBon/Transact/(:any)/(:any)/(:any)/(:any)'] = 'TransactBon/C_Transact/$1/$2/$3/$4';

