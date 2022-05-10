<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminSubsystemController;
use App\Http\Controllers\AuctionsSubsystemController;
use App\Http\Controllers\AwardsSubsystemController;
use App\Http\Controllers\CollectionsSubsystemController;
use App\Http\Controllers\ImagesManagementSubsystemController;
use App\Http\Controllers\ImagesSubsystemController;
use App\Http\Controllers\PaymentsSubsystemController;
use App\Http\Controllers\testRolkaController;
use App\Http\Controllers\UserManagementSubsystemController;
use App\View\Components\ActionConfirmationForm;
use Barryvdh\Debugbar\Facades\Debugbar;

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

// Route::resource('students', StudentController::class);

// --------------------------------------------------------------------------
// controller methods
// --------------------------------------------------------------------------

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// action confirmation form
Route::get('cancelAction/{action}',[ActionConfirmationForm::class,'cancelAction'])->name('cancelAction');
Route::get('confirmAction/{action}/{id}',[ActionConfirmationForm::class,'confirmAction'])->name('confirmAction');

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ImagesManagementSubsystem
Route::post('submitNewImageCreation',[ImagesManagementSubsystemController::class,'submitNewImageCreation'])->name('submitNewImageCreation');
Route::get('submitCreatedImageDelete/{id}',[ImagesManagementSubsystemController::class,'submitImageDelete'])->name('submitCreatedImageDelete');
Route::get('deleteCreatedImage/{id}',[ImagesManagementSubsystemController::class,'deleteImage'])->name('deleteCreatedImage');
Route::get('editImageInformation/{id}',[ImagesManagementSubsystemController::class,'editImageInformation'])->name('editImageInformation');
Route::post('submitNewImageData',[ImagesManagementSubsystemController::class,'submitNewImageData'])->name('submitNewImageData');
Route::get('ImageCreationView', [ImagesManagementSubsystemController::class,'openImageCreationView']);
Route::get('CreatedImagesListView', [ImagesManagementSubsystemController::class,'displayCreatedImageList']);

Route::get('/OwnedImageInformationView/{id}', [ImagesManagementSubsystemController::class, 'openOwnedImageInformationView'])->name('OwnedImageInformationView');
Route::post('/OwnedImageInformationView/{id}', [ImagesManagementSubsystemController::class, 'changeVisibility'])->name('OwnedImageInformationView');
Route::get('/ownedimages/{id}', [ImagesManagementSubsystemController::class, 'openOwnedImages'])->name('ownedImg');
Route::get('/ownedimages/movetocollection/{userId}/', [ImagesManagementSubsystemController::class, 'movePictureToCollection'])->name('moveToCollection');
Route::get('/images/sellwindow/{userId}/{imageId}',[ImagesManagementSubsystemController::class, 'openSellPictureWindow'])->name('openWindow');
Route::get('/images/putforsale/{userId}/{imageId}',[ImagesManagementSubsystemController::class, 'putForSale'])->name('openWindow');

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ImagesSubsystem
Route::get('ImagesListView', [ImagesSubsystemController::class,'getImagesForSale']);
Route::get('submitImageSearch', [ImagesSubsystemController::class,'submitImageSearch'])->name('submitImageSearch');
Route::get('sortImageListDesc',[ImagesSubsystemController::class,'sortImageListDesc'])->name('sortImageListDesc');
Route::get('sortImageListAsc',[ImagesSubsystemController::class,'sortImageListAsc'])->name('sortImageListAsc');

Route::get('imagePriceHistoryView/{id}',[ImagesSubsystemController::class,'openImagePriceHistoryView'])->name('imagePriceHistoryView');
Route::get('rateImage/{id}/{rating}',[ImagesSubsystemController::class,'rateImage'])->name('rateImage');
Route::post('getImageRecommendations',[ImagesSubsystemController::class,'getImageRecommendations'])->name('getImageRecommendations');
Route::post('getImageInformation',[ImagesSubsystemController::class,'getImageInformation'])->name('getImageInformation');

Route::get('imageInformationView/{id}', function () {
    return view('ImageInformationView');
})->name('imageInformationView');


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// AdminSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// AuctionsSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// AwardsSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// CollectionsSubsystem

//404 nzn ko truksta, tai kol kas be confirmation
Route::get('/submitCreatedCollectionDelete/{userId}/{collectionId}',[testRolkaController::class,'submitCollectionDelete'])->name('submitCreatedCollectionDelete');
Route::get('/collections/open/{id}', [CollectionsSubsystemController::class, 'openCreatedCollectionsListView'])->name('CreatedCollectionsListView');
Route::get('/collections/create/{id}', [CollectionsSubsystemController::class, 'openCollectionCreationView'])->name('CollectionCreationView');
Route::get('/collections/create/new/{id}',[CollectionsSubsystemController::class, 'createCollection'])->name('whateverName');
Route::get('/collections/delete/{userId}/{collectionId}',[CollectionsSubsystemController::class, 'deleteCollection'])->name('CreatedCollectionsListView');
Route::get('/collections/openEdit/{userId}/{collectionId}/{text1}/{text2}',[CollectionsSubsystemController::class, 'openEditCollectionView'])->name('edittoadsyyug');
Route::get('/collections/edit/{userId}/{collectionId}',[CollectionsSubsystemController::class, 'editCollection'])->name('asdffdsa');

//-----tik iki controller'io prieina, neapsiziurejau, kad ne savo darau, bet trint visai visko nesinori
Route::get('/collections/{userId}/{collectionId}',[CollectionsSubsystemController::class, 'showCollectionInfo'])->name('CollectionInfo');

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// PaymentsSubsystem
Route::get('/purchaseinformation/{id:int}',[PaymentsSubsystemController::class, 'showPurchaseInformation'])->name('purchaseInfoWindowOpen');

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// UserManagementSubsystem


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-rolka controllers@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@





Route::get('/testas',[testRolkaController::class, 'test'])->name('bet kas');





// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ungrouped routes

//actually naudojami-----------------------------
Route::get('/', function () {
    return view('HomePage');
});

Route::get('/CollectionsListView', function () {
    return view('CollectionsListView');
});
//-----------------------------------------------



//patariu neatkomentuot
//jei savo nauja route kuriat, vis tiek reikes su controlleriu(kitaip paskaitai netiks)
//o jei pavadinimai dubliuosis, paims paskutini route is zemiau ir bus neaisku ko paciu kurtas route neveikia

// Route::get('bandymas', function () {
//     return view('imageInformationView');
// });

// Route::get('AccountEditingView', function () {
//     return view('AccountEditingView');
// });

// Route::get('ActionConfirmationForm', function () {
//     return view('ActionConfirmationForm');
// });

// Route::get('AuctionInformationView', function () {
//     return view('AuctionInformationView');
// });

// Route::get('AuctionRegistrationView', function () {
//     return view('AuctionRegistrationView');
// });

// Route::get('AuctionsListView', function () {
//     return view('AuctionsListView');
// });

// Route::get('AwardsListView', function () {
//     return view('AwardsListView');
// });

// Route::get('BankAPICommunicator', function () {
//     return view('BankAPICommunicator');
// });

// Route::get('BillsListView', function () {
//     return view('BillsListView');
// });

// Route::get('BillsReportView', function () {
//     return view('BillsReportView');
// });

// // Route::get('CollectionCreationView', function () {
// //     return view('CollectionCreationView');
// // });

// // Route::get('CollectionView', function () {
// //     return view('CollectionView');
// // });

// // Route::get('CreatedCollectionsListView', function () {
// //     return view('CreatedCollectionsListView');
// // });

// Route::get('ImageForSaleCreationView', function () {
//     return view('ImageForSaleCreationView');
// });

// Route::get('ImageInformationView', function () {
//     return view('ImageInformationView');
// });

// Route::get('ImageInformationEditView', function () {
//     return view('ImageInformationEditView');
// });

// Route::get('ImagePriceHistoryView', function () {
//     return view('ImagePriceHistoryView');
// });

// Route::get('ImagePurchaseInformationView', function () {
//     return view('ImagePurchaseInformationView');
// });

// Route::get('ImageRightsTransferView', function () {
//     return view('ImageRightsTransferView');
// });

// Route::get('LoginView', function () {
//     return view('LoginView');
// });

// Route::get('OwnedImageInformationView', function () {
//     return view('OwnedImageInformationView');
// });



// Route::get('RegistrationView', function () {
//     return view('RegistrationView');
// });

// Route::get('UserProfileInformationView', function () {
//     return view('UserProfileInformationView');
// });

// Route::get('WalletBalanceTopUpView', function () {
//     return view('WalletBalanceTopUpView');
// });

// Route::get('WalletView', function () {
//     return view('WalletView');
// });