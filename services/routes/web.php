<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLogOut;
use App\Http\Controllers\Backend\ElectricityController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\BillerCategoryController;
use App\Http\Controllers\Backend\IbadanDiscoController;
use App\Http\Controllers\Backend\AbujaElectricController;
use App\Http\Controllers\Backend\IkejaElectricController;
use App\Http\Controllers\Backend\KedcoController;
use App\Http\Controllers\Backend\KadunaElectricController;
use App\Http\Controllers\Backend\JosController;
use App\Http\Controllers\Backend\EnuguElectricController;
use App\Http\Controllers\Backend\MultichoiceController;
use App\Http\Controllers\Backend\StartimesController;
use App\Http\Controllers\Backend\SmillesController;








/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.index');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('backend.admin_panel');
})->name('dashboard');


Route::get('user/logout',[UserLogout::class, 'UserLogOut'])->name('user.logout');


//Billers category
Route::get('billers/category/view',[BillerCategoryController::class, 'BillerCategory'])->name('billers.category_view');
Route::get('billers/category_two/view',[BillerCategoryController::class, 'BillerCategoryTwo'])->name('billers_cate_two');


//prepaid routes
Route::get('ekoelectricity/view',[ElectricityController::class, 'EkoElectricityPrePaid'])->name('eko_electricity.prepaid');

Route::post('ekoprepaid/buy',[ElectricityController::class, 'BuyElectricity'])->name('prepaid.Electricity');

Route::get('prepaid/make/payment',[PaymentController::class, 'makePrepaidPayment'])->name('make_payment.Electricity');

Route::get('get/ekoprepaid_pdf_details',[PaymentController::class, 'pdfEkoPrepaid'])->name('ekoprepaid_pdf_details');


//postpaid routes
Route::get('ekoepostpaid/view',[ElectricityController::class, 'EkoElectricityPostPaid'])->name('eko_electricity.postpaid');
Route::post('ekopostpaid/buy',[ElectricityController::class, 'BuyElectricityPostPaid'])->name('postpaid.Electricity');
Route::get('postpaid/make/payment',[PaymentController::class, 'makePostpaidPayment'])->name('make_postpaid_payment.Electricity');
Route::get('get/ekopostpaid_pdf_details',[PaymentController::class, 'pdfEkoPostpaid']);



//ibadan disco route
//prepaid
Route::get('ibadan_Disco/view',[IbadanDiscoController::class, 'ibadanDiscoView'])->name('ibadan_disco.prepaid_view');
Route::post('ibadan_Disco/buy',[IbadanDiscoController::class, 'ibadanDiscoBuyToken'])->name('ibadan_disco.buytoken');
Route::get('ibadan_prepaid/make/payment',[IbadanDiscoController::class, 'ibadanPrepaidPayment']);
Route::get('get/ibadanprepaid_pdf_details',[IbadanDiscoController::class, 'ibadan_prepaidpdf']);

//postpaid
Route::get('ibadan_Disco/postaid/view',[IbadanDiscoController::class, 'ibadanDiscoPostpaidView'])->name('ibadan_disco.postpaid_view');
Route::post('ibadan_Disco/postpaid/buy',[IbadanDiscoController::class, 'ibadanDiscoPostpaidBuy'])->name('ibadan_disco.postpaid');
Route::get('ibadan_postpaid/make/payment',[IbadanDiscoController::class, 'ibadanPostpaidPayment']);
Route::get('get/ibadanpostpaid_pdf_details',[IbadanDiscoController::class, 'ibadan_postpaidpdf']);


//Abuja Electric Routes
//prepaid
Route::get('abuja_electric/view',[AbujaElectricController::class, 'abujaElectricView'])->name('abuja_electric.prepaid');
Route::post('abuja_electric/buy',[AbujaElectricController::class, 'abujaElectricBuyToken'])->name('abuja_electric.buytoken');
Route::get('abuja_prepaid/make/payment',[AbujaElectricController::class, 'abujaPrepaidPayment']);
Route::get('get/abujaprepaid_pdf_details',[AbujaElectricController::class, 'abuja_prepaidpdf']);

//postpaid
Route::get('abuja_electric/postaid/view',[AbujaElectricController::class, 'abujaElectricPostpaidView'])->name('abuja_electric.postpaid_view');
Route::post('abuja/postpaid/buy',[AbujaElectricController::class, 'AbujaPostpaidBuy'])->name('abuja_electric_postpaid');
Route::get('abuja_postpaid/make/payment',[AbujaElectricController::class, 'abujaPostpaidPayment']);
Route::get('get/abujapostpaid_pdf_details',[AbujaElectricController::class, 'abuja_postpaidpdf']);


// All Ikeja  Electric Routes
//prepaid
Route::get('ikeja_electric/view',[IkejaElectricController::class, 'ikejaElectricView'])->name('ikeja_electric.prepaid');
Route::post('ikeja_electric/buy',[IkejaElectricController::class, 'ikejaElectricBuyToken'])->name('ikeja_electric.buytoken');
Route::get('ikeja_prepaid/make/payment',[IkejaElectricController::class, 'ikejaPrepaidPayment']);
Route::get('get/ikejaprepaid_pdf_details',[IkejaElectricController::class, 'ikejaPrepaidPDF']);


//postpaid
Route::get('ikeja_electric/postaid/view',[IkejaElectricController::class, 'ikejaElectricPostpaidView'])->name('ikeja_electric.postpaid_view');
Route::post('ikeja/postpaid/buy',[IkejaElectricController::class, 'ikejaPostpaidBuy'])->name('ikeja_electric.postpaid_buyToken');
Route::get('ikeja_postpaid/make/payment',[IkejaElectricController::class, 'ikejaPostpaidPayment']);
Route::get('get/ikejpostpaid_pdf_details',[IkejaElectricController::class, 'ikejaPostPaidPDF']);



// All KEDCO Routes
//prepaid
Route::get('kedco_prepaid/view',[KedcoController::class, 'kedcoPrepaidView'])->name('kedco.prepaid_view');
Route::post('kedco_electric/buy',[KedcoController::class, 'kedCoBuyToken'])->name('kedco_prepaid.buytoken');



// All Kaduna  Electric Routes
//prepaid
Route::get('kaduna_electric/view',[KadunaElectricController::class, 'kadunaElectricView'])->name('kaduna.prepaid_view');
Route::post('kaduna_electric/buy',[KadunaElectricController::class, 'kadunaElectricBuyToken'])->name('kaduna_electric.buytoken');
Route::get('kaduna_prepaid/make/payment',[KadunaElectricController::class, 'kadunaPrepaidPayment']);
Route::get('kadunaprepaid_pdf_details',[KadunaElectricController::class, 'kadunaPrePaidPDF']);


// All JOS Routes
//prepaid
Route::get('jos_electric/prepaid/view',[JosController::class, 'josElectricPrepaidView'])->name('jos_electric.prepaid_view');
Route::post('jos_electric/buy',[JosController::class, 'josElectricBuyToken'])->name('jos_electric.buytoken');
Route::get('jos_prepaid/make/payment',[JosController::class, 'josPrepaidPayment']);
Route::post('get/josprepaid_pdf_details',[JosController::class, 'josPrepaidPDF']);


//postpaid
Route::get('jos_electric/postpaid/view',[JosController::class, 'josElectricPostpaidView'])->name('jos_electric.postpaid_view');
Route::post('jos/postpaid/buy',[JosController::class, 'josPostpaidBuy'])->name('jos_electric.postpaid');
Route::get('jos_postpaid/make/payment',[JosController::class, 'josPostpaidPayment']);
Route::post('get/jospostpaid_pdf_details',[JosController::class, 'josPostpaidPDF']);


// All Enugun Routes
//prepaid
Route::get('enugu_electric/prepaid/view',[EnuguElectricController::class, 'enuguElectricPrepaidView'])->name('enugu.prepaid_view');
Route::post('enugu_electric/buy',[EnuguElectricController::class, 'enuguElectricBuyToken'])->name('enugu_electric.buytoken');
Route::get('enugu_prepaid/make/payment',[EnuguElectricController::class, 'enuguPrepaidPayment']);
Route::post('get/enugunprepaid_pdf_details',[PaymentController::class, 'enuguPrepaidPDF']);


//postpaid
Route::get('enugu_electric/postpaid/view',[EnuguElectricController::class, 'enuguPostpaidView'])->name('enugu.postpaid_view');
Route::post('enugu/postpaid/buy',[EnuguElectricController::class, 'enuguPostpaidBuy'])->name('enugu_electric.postpaid');
Route::get('enugu_postpaid/make/payment',[EnuguElectricController::class, 'EnuguPostpaidPayment']);
Route::post('get/enuguPostpaid_pdf_details',[PaymentController::class, 'enuguPostpaidPDF']);


//gotv subscription routes
Route::get('gotv/details/view',[MultichoiceController::class, 'gotvdetailsView'])->name('gotv_details_view');

Route::get('gotv/product/get_amount',[MultichoiceController::class, 'gotvGetProductAmount'])->name('get_gotv_amount');
Route::post('gotv/subscription/purchase',[MultichoiceController::class, 'gotvSubPurchase'])->name('gotvSubscription_purchase');
Route::get('gotv/purchase/pdf_details',[MultichoiceController::class, 'gotvSubPurchase_pdf_Details']);
Route::post('get/gotv_pdf_details',[MultichoiceController::class, 'gotv_getpdfdetaails']);



//DSTV subscription ROUTES
Route::get('dstv/details/view',[MultichoiceController::class, 'dstvdetailsView'])->name('dstv_details_view');
Route::get('dstv/product/get_amount',[MultichoiceController::class, 'dstvGetProductAmount'])->name('get_dstv_amount');
Route::post('dstv/subscription/purchase',[MultichoiceController::class, 'dstvSubPurchase'])->name('dstvSubscription_purchase');
Route::get('dstv/purchase/pdf_details',[MultichoiceController::class, 'dstvSubPurchase_pdf_Details']);
Route::post('get/dstv_pdf_details',[MultichoiceController::class, 'dstvSubgetpdf']);
Route::get('dstv/package/get_amount',[MultichoiceController::class, 'dstvGetPackageAmount'])->name('get_dstv_packageamount');




//Startimes All Routes
Route::get('startimes/details/view',[StartimesController::class, 'startimesdetailsView'])->name('startimes_details_view');
Route::post('startimes/subscription/purchase',[StartimesController::class, 'startimesSubPurchase'])->name('startimes_purchase');
Route::get('startimes/purchase/pdf_details',[StartimesController::class, 'startimesSubPurchase_pdf_Details']);
Route::get('get/startimes_pdfdetails',[StartimesController::class, 'startimespdfDetails'])->name('get_startimespdf_details');



//SMILES All Routes
//SMILES Recharge
Route::get('smiles/details/view',[SmillesController::class, 'smilesDetailsView'])->name('smiles_recharge.purchase');
Route::post('smiles_recharge/subscription/purchase',[SmillesController::class, 'smilesSubPurchase'])->name('smiles.rechardge');
Route::get('smiles_recharge/purchase',[SmillesController::class, 'smilesRechargePayment']);
Route::get('get/smiles_pdf_details',[SmillesController::class, 'smilesRechargepdfDetails'])->name('smiles.rechardgepdf');



//Smiles Bundle
Route::get('smiles_bundle/details/view',[SmillesController::class, 'smilesBundleDetailsView'])->name('smiles_bundle_purchase');
Route::post('smiles_bundle/subscription/purchase',[SmillesController::class, 'smilesBundleSubPurchase'])->name('smiles.bundle');
Route::get('smiles_bundle/get/package',[SmillesController::class, 'smilesBundlegetPackage'])->name('get_bundle_package');
Route::get('smiles_bundle/purchase',[SmillesController::class, 'smilesBundlePayment']);
Route::get('get/bundle_pdf_details',[SmillesController::class, 'smilesBundlepdfDetails'])->name('bundle.rechardgepdf');












//get add one package route for DSTV
Route::get('dstv/get_addon_package/view',[MultichoiceController::class, 'dstv_getaddOnPackage'])->name('get_dstv_ProductaddonPackage');





//get final response controller
Route::get('get/biller/final_response',[PaymentController::class, 'getFinalResponseForBiller'])->name('get_prepaid_final_response');
Route::get('get/automatic/final_response',[PaymentController::class, 'getAutomaticForBiller'])->name('get_automatic_transaction');
















