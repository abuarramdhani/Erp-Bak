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
//CustomerRelationship
$route['CustomerRelationship'] = 'CustomerRelationship/C_CustomerRelationship/index';
$route['SystemAdministration'] = 'SystemAdministration/C_SystemAdministration/index';
//Setting
//CustomerRelationship/C_AdditionalActivity
$route['CustomerRelationship/Setting/AdditionalActivity'] = 'CustomerRelationship/Setting/C_AdditionalActivity/index';
$route['CustomerRelationship/Setting/AdditionalActivity/(:any)'] = 'CustomerRelationship/Setting/C_AdditionalActivity/$1';
$route['CustomerRelationship/Setting/AdditionalActivity/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_AdditionalActivity/$1/$2';
//CustomerRelationship/C_CustomerCategory/
$route['CustomerRelationship/Setting/CustomerCategory'] = 'CustomerRelationship/Setting/C_CustomerCategory/index';
$route['CustomerRelationship/Setting/CustomerCategory/(:any)'] = 'CustomerRelationship/Setting/C_CustomerCategory/$1';
$route['CustomerRelationship/Setting/CustomerCategory/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_CustomerCategory/$1/$2';
//CustomerRelationship/C_BuyingType/
$route['CustomerRelationship/Setting/BuyingType'] = 'CustomerRelationship/Setting/C_BuyingType/index';
$route['CustomerRelationship/Setting/BuyingType/(:any)'] = 'CustomerRelationship/Setting/C_BuyingType/$1';
$route['CustomerRelationship/Setting/BuyingType/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_BuyingType/$1/$2';
//CustomerRelationship/C_Checklist/
$route['CustomerRelationship/Setting/Checklist'] = 'CustomerRelationship/Setting/C_Checklist/index';
$route['CustomerRelationship/Setting/Checklist/(:any)'] = 'CustomerRelationship/Setting/C_Checklist/$1';
$route['CustomerRelationship/Setting/Checklist/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_Checklist/$1/$2';
//CustomerRelationship/C_CustomerAdditional
$route['CustomerRelationship/Setting/CustomerAdditional'] = 'CustomerRelationship/Setting/C_CustomerAdditional/index';
$route['CustomerRelationship/Setting/CustomerAdditional/(:any)'] = 'CustomerRelationship/Setting/C_CustomerAdditional/$1';
$route['CustomerRelationship/Setting/CustomerAdditional/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_CustomerAdditional/$1/$2';
//CustomerRelationship/C_ServiceProblem
$route['CustomerRelationship/Setting/ServiceProblem'] = 'CustomerRelationship/Setting/C_ServiceProblem/index';
$route['CustomerRelationship/Setting/ServiceProblem/(:any)'] = 'CustomerRelationship/Setting/C_ServiceProblem/$1';
$route['CustomerRelationship/Setting/ServiceProblem/(:any)/(:any)'] = 'CustomerRelationship/Setting/C_ServiceProblem/$1/$2';
//MainMenu
//SystemAdministration/C_User
$route['SystemAdministration/User'] = 'SystemAdministration/MainMenu/C_User/index';
$route['SystemAdministration/User/(:any)'] = 'SystemAdministration/MainMenu/C_User/$1';
$route['SystemAdministration/User/(:any)/(:any)'] = 'SystemAdministration/MainMenu/C_User/$1/$2';
//CustomerRelationship/C_Customer/
$route['CustomerRelationship/Customer'] = 'CustomerRelationship/MainMenu/C_Customer/index';
$route['CustomerRelationship/Customer/(:any)'] = 'CustomerRelationship/MainMenu/C_Customer/$1';
$route['CustomerRelationship/Customer/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_Customer/$1/$2';
$route['CustomerRelationship/Ajax/Customer'] = 'CustomerRelationship/MainMenu/C_Customer/ajaxSearching';
//CustomerRelationship/C_CustomerDriver/
$route['CustomerRelationship/CustomerDriver'] = 'CustomerRelationship/MainMenu/C_CustomerDriver/index';
$route['CustomerRelationship/CustomerDriver/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerDriver/$1';
$route['CustomerRelationship/CustomerDriver/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerDriver/$1/$2';
//CustomerRelationship/C_Ownership
$route['CustomerRelationship/Ownership'] = 'CustomerRelationship/MainMenu/C_Ownership/index';
$route['CustomerRelationship/Ownership/(:any)'] = 'CustomerRelationship/MainMenu/C_Ownership/$1';
$route['CustomerRelationship/Ownership/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_Ownership/$1/$2';
$route['CustomerRelationship/Ownership/ChangeOwnership/ToCustomerSearch'] = 'CustomerRelationship/C_Ownership/searchToCustomer';
//CustomerRelationship/C_CustomerGroup/
$route['CustomerRelationship/CustomerGroup'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/index';
$route['CustomerRelationship/CustomerGroup/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/$1';
$route['CustomerRelationship/CustomerGroup/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/$1/$2';
$route['CustomerRelationship/CustomerGroup/(:any)/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/$1/$2/$3';
$route['CustomerRelationship/Ajax/CustomerGroup'] = 'CustomerRelationship/MainMenu/C_CustomerGroup/ajaxSearching';
//CustomerRelationship/C_ServiceProducts/
$route['CustomerRelationship/ServiceProducts'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/index';
$route['CustomerRelationship/ServiceProducts/(:any)'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/$1';
$route['CustomerRelationship/ServiceProducts/(:any)/(:any)'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/$1/$2';
// $route['CustomerRelationship/Ajax/ServiceProducts'] = 'CustomerRelationship/MainMenu/C_ServiceProducts/ajaxSearching';
//CustomerRelationship/C_Search
$route['CustomerRelationship/Search/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1';
$route['CustomerRelationship/Search/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1/$2';
$route['CustomerRelationship/Search/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1/$2/$3';
$route['CustomerRelationship/Search/(:any)/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Search/$1/$2/$3/$4';

//Other ajax routes
$route['ajax/(:any)'] = 'CustomerRelationship/Additional/C_Ajax/$1';
$route['ajax/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Ajax/$1/$2';
$route['ajax/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Additional/C_Ajax/$1/$2/$3';
//$route['Bac'] = 'C_Index/BackToLogin'
$route['CustomerRelationship/Report/(:any)'] = 'CustomerRelationship/Report/C_Report/$1';
$route['CustomerRelationship/Report/(:any)/(:any)'] = 'CustomerRelationship/Report/C_Report/$1/$2';
$route['CustomerRelationship/Report/(:any)/(:any)/(:any)'] = 'CustomerRelationship/Report/C_Report/$1/$2/$3';

//DASHBOARD
$route['SalesMonitoring'] = 'SalesMonitoring/C_dashboard/index';
$route['SalesMonitoring/dashboard'] = 'SalesMonitoring/C_dashboard/index';

//PRICELIST INDEX
$route['SalesMonitoring/pricelist'] 				= 'SalesMonitoring/C_pricelist/index';
$route['SalesMonitoring/pricelist/create'] 			= 'SalesMonitoring/C_pricelist/createPricelist';
$route['SalesMonitoring/pricelist/created'] 		= 'SalesMonitoring/C_pricelist/create';
$route['SalesMonitoring/pricelist/delete/(:any)'] 	= 'SalesMonitoring/C_pricelist/delete/$1';
$route['SalesMonitoring/pricelist/update/(:any)'] 	= 'SalesMonitoring/C_pricelist/updatePricelist/$1';
$route['SalesMonitoring/pricelist/updated'] 		= 'SalesMonitoring/C_pricelist/update';
$route['SalesMonitoring/pricelist/download/csv'] 	= 'SalesMonitoring/C_pricelist/downloadcsv';
$route['SalesMonitoring/pricelist/download/xml'] 	= 'SalesMonitoring/C_pricelist/downloadxml';
$route['SalesMonitoring/pricelist/download/pdf'] 	= 'SalesMonitoring/C_pricelist/downloadpdf';

//SALES OMSET
$route['SalesMonitoring/salesomset'] 						= 'SalesMonitoring/C_salesomset/index';
$route['SalesMonitoring/salesomset/download/csv'] 			= 'SalesMonitoring/C_salesomset/downloadcsv';
$route['SalesMonitoring/salesomset/download/xml'] 			= 'SalesMonitoring/C_salesomset/downloadxml';
$route['SalesMonitoring/salesomset/download/pdf'] 			= 'SalesMonitoring/C_salesomset/downloadpdf';
$route['SalesMonitoring/salesomset/filter'] 				= 'SalesMonitoring/C_salesomset/profilter';
$route['SalesMonitoring/salesomset/filter/download/pdf'] 	= 'SalesMonitoring/C_salesomset/downloadpdffilter';

//SALES TARGET
$route['SalesMonitoring/salestarget']						= 'SalesMonitoring/C_salestarget/index';
$route['SalesMonitoring/salestarget/create'] 				= 'SalesMonitoring/C_salestarget/createSalestarget';
$route['SalesMonitoring/salestarget/created'] 				= 'SalesMonitoring/C_salestarget/create';
$route['SalesMonitoring/salestarget/delete/(:any)'] 		= 'SalesMonitoring/C_salestarget/delete/$1';
$route['SalesMonitoring/salestarget/update/(:any)'] 		= 'SalesMonitoring/C_salestarget/updateSalestarget/$1';
$route['SalesMonitoring/salestarget/updated'] 				= 'SalesMonitoring/C_salestarget/update';
$route['SalesMonitoring/salestarget/download/csv'] 			= 'SalesMonitoring/C_salestarget/downloadcsv';
$route['SalesMonitoring/salestarget/download/xml'] 			= 'SalesMonitoring/C_salestarget/downloadxml';
$route['SalesMonitoring/salestarget/download/pdf'] 			= 'SalesMonitoring/C_salestarget/downloadpdf';
$route['SalesMonitoring/salestarget/filter'] 				= 'SalesMonitoring/C_salestarget/profilter';
$route['SalesMonitoring/salestarget/filter/download/pdf'] 	= 'SalesMonitoring/C_salestarget/downloadpdffilter';

$route['(:any)'] = 'C_Index/$1';
$route['(:any)/(:any)'] = 'C_Index/$1/$2';

//-------------------------------------Morning Greeting----------------------------------------------------
//DASHBOARD
$route['MorningGreeting'] = 'MorningGreeting/C_MorningGreeting/index';
$route['MorningGreeting/dashboard'] = 'MorningGreeting/C_MorningGreeting/index';

// route pada tabel config
$route['MorningGreeting/configuration'] = 'MorningGreeting/configuration/C_config/index';
$route['MorningGreeting/configuration/edit/(:any)'] = 'MorningGreeting/configuration/C_config/editConfig/$1';
$route['MorningGreeting/configuration/save'] = 'MorningGreeting/configuration/C_config/saveConfig';

//route pada tabel branch
$route['MorningGreeting/extention'] = 'MorningGreeting/extention/C_extention/index';
$route['MorningGreeting/extention/new'] = 'MorningGreeting/extention/C_extention/newBranch';
$route['MorningGreeting/extention/new/save'] = 'MorningGreeting/extention/C_extention/newBranchSave';
$route['MorningGreeting/extention/edit/(:any)'] = 'MorningGreeting/extention/C_extention/editBranch/$1';
$route['MorningGreeting/extention/editsave'] = 'MorningGreeting/extention/C_extention/saveEditBranch';
$route['MorningGreeting/extention/delete/(:any)'] = 'MorningGreeting/extention/C_extention/deleteBranch/$1';

//route pada tabel schedule
$route['MorningGreeting/schedule'] = 'MorningGreeting/schedule/C_schedule/index';
$route['MorningGreeting/schedule/new'] = 'MorningGreeting/schedule/C_schedule/newSchedule';
$route['MorningGreeting/schedule/new/save'] = 'MorningGreeting/schedule/C_schedule/newScheduleSave';
$route['MorningGreeting/schedule/edit/(:any)'] = 'MorningGreeting/schedule/C_schedule/editSchedule/$1';
$route['MorningGreeting/schedule/editsave'] = 'MorningGreeting/schedule/C_schedule/saveEditSchedule/$1';
$route['MorningGreeting/schedule/delete/(:any)'] = 'MorningGreeting/schedule/C_schedule/deleteSchedule/$1';

//route pada tabel relation
$route['MorningGreeting/relation']					= 'MorningGreeting/relation/C_relation/index';
$route['MorningGreeting/relation/showcn']			= 'MorningGreeting/relation/C_relation/showcn';
$route['MorningGreeting/relation/new']				= 'MorningGreeting/relation/C_relation/newRelation';
$route['MorningGreeting/relation/new/save']			= 'MorningGreeting/relation/C_relation/newRelationSave';
$route['MorningGreeting/relation/edit/(:any)']		= 'MorningGreeting/relation/C_relation/editRelation/$1';
$route['MorningGreeting/relation/editsave']			= 'MorningGreeting/relation/C_relation/saveEditRelation/$1';
$route['MorningGreeting/relation/delete/(:any)']	= 'MorningGreeting/relation/C_relation/deleteRelation/$1';

//Route pada tabel cdr
$route['MorningGreeting/cdr']	= 'MorningGreeting/cdr/C_cdr/index';
//-------------------------------------Morning Greeting----------------------------------------------------
