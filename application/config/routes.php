<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
*/
$route['default_controller'] = "carguard";
$route['contact'] = "statice/contact";
$route['despre_noi'] = "statice/despre_noi";
$route['preview'] = "carguard/preview";
$route['mesaj'] = "carguard/mesaj";
$route['cautare'] = "carguard/cautare";
$route['produs/(:num)'] = "carguard/produs/$1";
$route['categorie/(:num)'] = "carguard/categorie/$1";
$route['categorie_subcategorii/(:num)'] = "carguard/categorie_subcategorii/$1";

$route['departament_managerial.html'] = "statice/departament_managerial";
$route['departament_contabilitate.html'] = "statice/departament_contabilitate";
$route['departament_vanzari.html'] = "statice/departament_vanzari";
$route['garanti.html'] = "statice/garanti";
$route['suport_tehnic.html'] = "statice/suport_tehnic";
$route['informatii_utile.html'] = "statice/index/informatii_utile";

$route['istoric.html'] = "statice/de_ce_noi/5";
$route['beneficii.html'] = "statice/beneficii/plata_12_rate";
$route['plata_12_rate.html'] = "statice/beneficii/plata_12_rate";
$route['livrare_24h.html'] = "statice/beneficii/livrare_24h";
$route['suport_telefonic.html'] = "statice/beneficii/suport_telefonic";
$route['garantii.html'] = "statice/beneficii/garantii";
$route['cumperi_mai_mult_platesti_mai_putin.html'] = "statice/beneficii/cumperi_mai_mult_platesti_mai_putin";
$route['certificate.html'] = "statice/beneficii/certificate";
$route['peste_200_produse.html'] = "statice/beneficii/peste_200_produse";
$route['termen_de_plata.html'] = "statice/beneficii/termen_de_plata";

$route['clientii_nostrii.html'] = "statice/clientii_nostrii";
$route['cariera.html'] = "statice/cariera";
$route['cookie.html'] = "statice/cookie";
$route['evenimente'] = "statice/evenimente";
$route['stiri'] = "statice/stiri";
$route['pareri'] = "statice/pareri";
$route['program_sarbatori.html'] = 'statice/program_sarbatori';

$route['produse_noi'] = "carguard/produse_oferta/nou";
$route['produse_promotie'] = "carguard/produse_oferta/promotii";
$route['produse_lichidari'] = "carguard/produse_oferta/lichidari";

$route['raspuns_tranzactie'] = "utilizator/raspuns_tranzactie";
$route['catalog/(:num)'] = "carguard/catalog/$1";
$route['dezabonare/(:any)'] = "statice/dezabonare/$1";
$route['reabonare/(:any)'] = "statice/reabonare/$1";

$route['gdpr'] = "statice/gdpr";
// $route['gdpr'] = "statice/pagina/6";
$route['acord_gdpr'] = "utilizator/gdpr";
$route['termeni_si_conditii'] = "statice/pagina/1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
