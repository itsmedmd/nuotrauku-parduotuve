<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminSubsystemController;
use App\Http\Controllers\AuctionsSubsystemController;
use App\Http\Controllers\AwardsSubsystemController;
use App\Http\Controllers\CollectionsSubsystemController;
use App\Http\Controllers\ImagesManagementSubsystemController;
use App\Http\Controllers\ImagesSubsystemController;
use App\Http\Controllers\PaymentsSubsystemController;
use App\Http\Controllers\UserManagementSubsystemController;
use App\View\Components\ActionConfirmationForm;
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


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ImagesSubsystem
Route::get('ImagesListView', [ImagesSubsystemController::class,'getImagesForSale']);
Route::get('submitImageSearch', [ImagesSubsystemController::class,'submitImageSearch'])->name('submitImageSearch');
Route::get('sortImageListDesc',[ImagesSubsystemController::class,'sortImageListDesc'])->name('sortImageListDesc');
Route::get('sortImageListAsc',[ImagesSubsystemController::class,'sortImageListAsc'])->name('sortImageListAsc');

Route::get('imageInformationView/{id}',[ImagesSubsystemController::class,'openImageInformationView'])->name('imageInformationView');
Route::get('imagePriceHistoryView/{id}',[ImagesSubsystemController::class,'openImagePriceHistoryView'])->name('imagePriceHistoryView');
Route::get('rateImage/{id}/{rating}',[ImagesSubsystemController::class,'rateImage'])->name('rateImage');
Route::post('getImageRecommendations',[ImagesSubsystemController::class,'getImageRecommendations'])->name('getImageRecommendations');


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// AdminSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// AuctionsSubsystem

Route::get('AuctionsListView', [AuctionsSubsystemController::class,'getAuctionsList'])->name('AuctionsListView');
Route::get('AuctionRegistrationView',[AuctionsSubsystemController::class,'openImageCreationView'])->name('AuctionRegistrationView');
Route::post('createNewAuction',[AuctionsSubsystemController::class,'createNewAuction'])->name('createNewAuction');
Route::get('openAuctionInformationView/{id}',[AuctionsSubsystemController::class,'openAuctionInformationView'])->name('openAuctionInformationView');
Route::post('submitAuctionBid',[AuctionsSubsystemController::class,'submitAuctionBid'])->name('submitAuctionBid');
//Route::get('AuctionInformationView',[AuctionsSubsystemController::class,'hideAbilityToPlaceABid'])->name('AuctionInformationView');
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// AwardsSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// CollectionsSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// PaymentsSubsystem

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// UserManagementSubsystem


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ungrouped routes
Route::get('/', function () {
    return view('HomePage');
});

Route::get('AccountEditingView', function () {
    return view('AccountEditingView');
});

Route::get('ActionConfirmationForm', function () {
    return view('ActionConfirmationForm');
});

Route::get('AuctionInformationView', function () {
    return view('AuctionInformationView');
});


Route::get('AwardsListView', function () {
    return view('AwardsListView');
});

Route::get('BankAPICommunicator', function () {
    return view('BankAPICommunicator');
});

Route::get('BillsListView', function () {
    return view('BillsListView');
});

Route::get('BillsReportView', function () {
    return view('BillsReportView');
});

Route::get('CollectionCreationView', function () {
    return view('CollectionCreationView');
});

Route::get('CollectionsListView', function () {
    return view('CollectionsListView');
});

Route::get('CollectionView', function () {
    return view('CollectionView');
});

Route::get('CreatedCollectionsListView', function () {
    return view('CreatedCollectionsListView');
});

Route::get('ImageForSaleCreationView', function () {
    return view('ImageForSaleCreationView');
});

Route::get('ImageInformationView', function () {
    return view('ImageInformationView');
});

Route::get('ImageInformationEditView', function () {
    return view('ImageInformationEditView');
});

Route::get('ImagePriceHistoryView', function () {
    return view('ImagePriceHistoryView');
});

Route::get('ImagePurchaseInformationView', function () {
    return view('ImagePurchaseInformationView');
});

Route::get('ImageRightsTransferView', function () {
    return view('ImageRightsTransferView');
});

Route::get('LoginView', function () {
    return view('LoginView');
});

Route::get('OwnedImageInformationView', function () {
    return view('OwnedImageInformationView');
});

Route::get('OwnedImagesListView', function () {
    return view('OwnedImagesListView');
});

Route::get('RegistrationView', function () {
    return view('RegistrationView');
});

Route::get('UserProfileInformationView', function () {
    return view('UserProfileInformationView');
});

Route::get('WalletBalanceTopUpView', function () {
    return view('WalletBalanceTopUpView');
});

Route::get('WalletView', function () {
    return view('WalletView');
});
