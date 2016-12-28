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
$route['SalesMonitoring/salestarget/created'] 				= 'SalesMonitoring/C_salestarget/create';
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
$route['Outstation/realization/print/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/print_realization/$1';
$route['Outstation/realization/new'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/new_Realization';
$route['Outstation/realization/new/process'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/load_process';
$route['Outstation/realization/new/save'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/save_Realization';
$route['Outstation/realization/edit/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/edit_Realization/$1';
$route['Outstation/realization/update'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/update_Realization';
$route['Outstation/realization/delete/(:any)'] = 'general-afair/outstation/OutstationTransaction/C_OutstationRealization/delete_realization/$1';

//-------------------------------------Outstation.end----------------------------------------------------

//------------------------------------Rekap TIMS.begin---------------------------------------------------
$route['RekapTIMSPromosiPekerja'] = 'er/RekapTIMS/C_Rekap/index';
$route['RekapTIMSPromosiPekerja/RekapTIMS'] = 'er/RekapTIMS/C_Rekap/rekapMenu';
$route['RekapTIMSPromosiPekerja/RekapTIMS/select-section'] = 'er/RekapTIMS/C_Rekap/select_section';
$route['RekapTIMSPromosiPekerja/RekapTIMS/show-data'] = 'er/RekapTIMS/C_Rekap/showData';
$route['RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-detail/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_Rekap/ExportRekapDetail/$1/$2/$3/$4/$5';
$route['RekapTIMSPromosiPekerja/RekapTIMS/rekap-bulanan/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_Rekap/searchMonth/$1/$2/$3';
$route['RekapTIMSPromosiPekerja/RekapTIMS/export-rekap-bulanan/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_Rekap/ExportRekapMonthly/$1/$2/$3/';

$route['RekapTIMSPromosiPekerja/RekapPerPekerja'] = 'er/RekapTIMS/C_RekapPerPekerja/index';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/show-data'] = 'er/RekapTIMS/C_RekapPerPekerja/show_data_per_pekerja';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-detail'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportRekapDetail';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/rekap-bulanan'] = 'er/RekapTIMS/C_RekapPerPekerja/searchMonth';
$route['RekapTIMSPromosiPekerja/RekapPerPekerja/export-rekap-bulanan'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportRekapMonthly';
$route['RekapTIMSPromosiPekerja/RekapTIMS/employee/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_RekapPerPekerja/searchEmployee/$1/$2/$3';
$route['RekapTIMSPromosiPekerja/RekapTIMS/export-employee/(:any)/(:any)/(:any)'] = 'er/RekapTIMS/C_RekapPerPekerja/ExportEmployee/$1/$2/$3';

$route['RekapTIMSPromosiPekerja/GetNoInduk'] = 'er/RekapTIMS/C_RekapPerPekerja/GetNoInduk';

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

//------------------------------------Management Presensi---------------------------------------------------
$route['PresenceManagement'] 						= 'PresenceManagement/C_Index/index';

$route['PresenceManagement/Monitoring'] 			= 'PresenceManagement/MainMenu/C_Monitoring/index';
$route['PresenceManagement/Monitoring/(:any)']	= 'PresenceManagement/MainMenu/C_Monitoring/$1';
$route['PresenceManagement/Monitoring/(:any)/(:any)']	= 'PresenceManagement/MainMenu/C_Monitoring/$1/$2';

//---------------------------------Payroll Management----------------------------------
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

$route['PayrollManagement/MasterTarifJkk'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk';
$route['PayrollManagement/MasterTarifJkk/(:any)'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk/$1';
$route['PayrollManagement/MasterTarifJkk/(:any)/(:any)'] = 'PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/C_MasterTarifJkk/$1/$2';

$route['PayrollManagement/MasterParamTarifJamsostek'] = 'PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek';
$route['PayrollManagement/MasterParamTarifJamsostek/(:any)'] = 'PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek/$1';
$route['PayrollManagement/MasterParamTarifJamsostek/(:any)/(:any)'] = 'PayrollManagement/SetTarifJamsostek/C_MasterParamTarifJamsostek/$1/$2';

$route['PayrollManagement/RiwayatTarifJkk'] = 'PayrollManagement/SetTarifJKK/C_RiwayatTarifJkk';
$route['PayrollManagement/RiwayatTarifJkk/(:any)'] = 'PayrollManagement/SetTarifJKK/C_RiwayatTarifJkk/$1';
$route['PayrollManagement/RiwayatTarifJkk/(:any)/(:any)'] = 'PayrollManagement/SetTarifJKK/C_RiwayatTarifJkk/$1/$2';

//------------------------------------Account Payables---------------------------------------------------
$route['AccountPayables'] 				= 'AccountPayables/C_Invoice';
$route['AccountPayables/Invoice'] 			= 'AccountPayables/C_Invoice';
$route['AccountPayables/Invoice/(:any)'] 			= 'AccountPayables/C_Invoice/$1';
$route['AccountPayables/Invoice/(:any)/(:any)'] 			= 'AccountPayables/C_Invoice/$1/$2';

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

$route['PayrollManagement/RiwayatParamKoperasi'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi';
$route['PayrollManagement/RiwayatParamKoperasi/(:any)'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi/$1';
$route['PayrollManagement/RiwayatParamKoperasi/(:any)/(:any)'] = 'PayrollManagement/SetIuranKoperasi/C_RiwayatParamKoperasi/$1/$2';

$route['PayrollManagement/KompTamb'] = 'PayrollManagement/KomponenTambahan/C_KompTamb';
$route['PayrollManagement/KompTamb/(:any)'] = 'PayrollManagement/KomponenTambahan/C_KompTamb/$1';
$route['PayrollManagement/KompTamb/(:any)/(:any)'] = 'PayrollManagement/KomponenTambahan/C_KompTamb/$1/$2';

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

$route['(:any)'] = 'C_Index/$1';
$route['(:any)/(:any)'] = 'C_Index/$1/$2';