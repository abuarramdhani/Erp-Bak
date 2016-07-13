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
$route['default_controller'] = 'welcome';
//$route['(:any)'] = 'pages/view/$1';
//$route['default_controller'] = 'pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//CustomerRelationship
//CustomerRelationship/C_CustomerStatus/
$route['CustomerRelationship/CustomerStatus/Delete/(:any)'] = 'CustomerRelationship/C_CustomerStatus/delete/$1';
$route['CustomerRelationship/CustomerStatus/Update/(:any)'] = 'CustomerRelationship/C_CustomerStatus/update/$1';
$route['CustomerRelationship/CustomerStatus/Update'] = 'CustomerRelationship/C_CustomerStatus/postUpdateToDb';
$route['CustomerRelationship/CustomerStatus/New'] = 'CustomerRelationship/C_CustomerStatus/create';
$route['CustomerRelationship/CustomerStatus'] = 'CustomerRelationship/C_CustomerStatus/index';
//CustomerRelationship/C_CustomerDriver/
$route['CustomerRelationship/CustomerDriver/Delete/(:any)'] = 'CustomerRelationship/C_CustomerDriver/delete/$1';
$route['CustomerRelationship/CustomerDriver/Update/(:any)'] = 'CustomerRelationship/C_CustomerDriver/update/$1';
$route['CustomerRelationship/CustomerDriver/Update'] = 'CustomerRelationship/C_CustomerDriver/postUpdateToDb';
$route['CustomerRelationship/CustomerDriver/New'] = 'CustomerRelationship/C_CustomerDriver/create';
$route['CustomerRelationship/CustomerDriver'] = 'CustomerRelationship/C_CustomerDriver/index';
$route['CustomerRelationship/CustomerDriver/CustomerSearch'] = 'CustomerRelationship/C_CustomerDriver/searchCustomer';
$route['CustomerRelationship/CustomerDriver/CustomerSearch/(:any)'] = 'CustomerRelationship/C_CustomerDriver/searchCustomer/$1';
//CustomerRelationship/C_CustomerGroup/
$route['CustomerRelationship/CustomerGroup/Delete/(:any)'] = 'CustomerRelationship/C_CustomerGroup/delete/$1';
$route['CustomerRelationship/CustomerGroup/Update/(:any)'] = 'CustomerRelationship/C_CustomerGroup/update/$1';
$route['CustomerRelationship/CustomerGroup/Update'] = 'CustomerRelationship/C_CustomerGroup/postUpdateToDb';
$route['CustomerRelationship/CustomerGroup/New'] = 'CustomerRelationship/C_CustomerGroup/create';
$route['CustomerRelationship/CustomerGroup'] = 'CustomerRelationship/C_CustomerGroup/index';
//CustomerRelationship/C_Customer/
$route['CustomerRelationship/Customer/Delete/(:any)'] = 'CustomerRelationship/C_Customer/delete/$1';
$route['CustomerRelationship/Customer/Update/(:any)'] = 'CustomerRelationship/C_Customer/update/$1';
$route['CustomerRelationship/Customer/Update'] = 'CustomerRelationship/C_Customer/postUpdateToDb';
$route['CustomerRelationship/Customer/New'] = 'CustomerRelationship/C_Customer/create';
$route['CustomerRelationship/Customer'] = 'CustomerRelationship/C_Customer/index';
$route['CustomerRelationship/Customer/(:any)'] = 'CustomerRelationship/C_Customer/details/$1';
$route['CustomerRelationship/Customer/NewSite/(:any)'] = 'CustomerRelationship/C_Customer/createSite/$1';
$route['CustomerRelationship/Customer/NewSite/'] = 'CustomerRelationship/C_Customer/createSite/';
$route['CustomerRelationship/Customer/UpdateSite/(:any)'] = 'CustomerRelationship/C_Customer/updateSite/$1';
$route['CustomerRelationship/Customer/UpdateSite'] = 'CustomerRelationship/C_Customer/updateSite';
//CustomerRelationship/C_ServiceProducts/
$route['CustomerRelationship/ServiceProducts/Delete/(:any)'] = 'CustomerRelationship/C_ServiceProducts/delete/$1';
$route['CustomerRelationship/ServiceProducts/Update/(:any)'] = 'CustomerRelationship/C_ServiceProducts/update/$1';
$route['CustomerRelationship/ServiceProducts/Update'] = 'CustomerRelationship/C_ServiceProducts/postUpdateToDb';
$route['CustomerRelationship/ServiceProducts/New'] = 'CustomerRelationship/C_ServiceProducts/create';
$route['CustomerRelationship/ServiceProducts'] = 'CustomerRelationship/C_ServiceProducts/index';
$route['CustomerRelationship/ServiceProducts/(:any)'] = 'CustomerRelationship/C_ServiceProducts/details/$1';
$route['CustomerRelationship/ServiceProducts/NewSite/(:any)'] = 'CustomerRelationship/C_ServiceProducts/createSite/$1';
$route['CustomerRelationship/ServiceProducts/NewSite/'] = 'CustomerRelationship/C_ServiceProducts/createSite/';
$route['CustomerRelationship/ServiceProducts/UpdateSite/(:any)'] = 'CustomerRelationship/C_ServiceProducts/updateSite/$1';
$route['CustomerRelationship/ServiceProducts/UpdateSite'] = 'CustomerRelationship/C_ServiceProducts/updateSite';
$route['CustomerRelationship/ServiceProducts/CustomerSearch'] = 'CustomerRelationship/C_ServiceProducts/searchCustomer';
$route['CustomerRelationship/ServiceProducts/CustomerSearch/(:any)'] = 'CustomerRelationship/C_ServiceProducts/searchCustomer/$1';
$route['CustomerRelationship/ServiceProducts/EmployeeSearch'] = 'CustomerRelationship/C_ServiceProducts/searchEmployee';
$route['CustomerRelationship/ServiceProducts/EmployeeSearch/(:any)'] = 'CustomerRelationship/C_ServiceProducts/searchEmployee/$1';