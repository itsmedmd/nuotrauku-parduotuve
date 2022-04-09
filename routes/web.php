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

// ImagesSubsystem
Route::post('TESTdoSomething',[ImagesSubsystemController::class,'TESTdoSomething'])->name('TESTdoSomething');

// --------------------------------------------------------------------------
// ImagesManagementSubsystem
Route::post('submitNewImageCreation',[ImagesManagementSubsystemController::class,'submitNewImageCreation'])->name('submitNewImageCreation');

// when going to the route automatically execute "displayCreatedImageList" function in order to
// already have a list of images to render when the page opens
Route::get('CreatedImagesListView', [ImagesManagementSubsystemController::class,'displayCreatedImageList']);


// --------------------------------------------------------------------------
// AdminSubsystem

// --------------------------------------------------------------------------
// AuctionsSubsystem

// --------------------------------------------------------------------------
// AwardsSubsystem

// --------------------------------------------------------------------------
// CollectionsSubsystem

// --------------------------------------------------------------------------
// PaymentsSubsystem

// --------------------------------------------------------------------------
// UserManagementSubsystem


// --------------------------------------------------------------------------
// routes
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

Route::get('AuctionRegistrationView', function () {
    return view('AuctionRegistrationView');
});

Route::get('AuctionsListView', function () {
    return view('AuctionsListView');
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

Route::get('ImageCreationView', function () {
    return view('ImageCreationView');
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

Route::get('ImagesListView', function () {
    return view('ImagesListView');
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
