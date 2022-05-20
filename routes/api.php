<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Admin controllers
use App\Http\Controllers\API\Admin\ACCRequestController;
use App\Http\Controllers\API\Admin\BreedController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\EventController;
use App\Http\Controllers\API\Admin\EventCategoryController;
use App\Http\Controllers\API\Admin\EventLocationController;
use App\Http\Controllers\API\Admin\PetController;
use App\Http\Controllers\API\Admin\PetTypeController;
use App\Http\Controllers\API\Admin\StateController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Admin\ViolationController;
use App\Http\Controllers\API\Admin\ViolationTypeController;
use App\Http\Controllers\API\Admin\LostFoundItemController;
use App\Http\Controllers\API\Admin\TicketController;
use App\Http\Controllers\API\Admin\VehicleController;
use App\Http\Controllers\API\Admin\AmmenityController;
use App\Http\Controllers\API\Admin\CommitteeController;
use App\Http\Controllers\API\Admin\ReservationController;
use App\Http\Controllers\API\Admin\DocumentController;
use App\Http\Controllers\API\Admin\FaqController;
use App\Http\Controllers\API\Admin\ImpLinkController;
use App\Http\Controllers\API\Admin\ClassifiedController;
use App\Http\Controllers\API\Admin\ClassifiedConditionController;
use App\Http\Controllers\API\Admin\ClassifiedCategoryController;
use App\Http\Controllers\API\Admin\DocumentCategoryController;
use App\Http\Controllers\API\Admin\VotingController;
use App\Http\Controllers\API\Admin\VotingCategoryController;
use App\Http\Controllers\API\Admin\TicketCategoryController;
use App\Http\Controllers\API\Admin\PermissionHeadingController;
use App\Http\Controllers\API\Admin\PermissionController;

//User controllers
use App\Http\Controllers\API\User\RegisterController;
use App\Http\Controllers\API\User\TicketController as UserTicketController;
use App\Http\Controllers\API\User\AccRequestController as UserAccRequestController;
use App\Http\Controllers\API\User\PetController as UserPetController;
use App\Http\Controllers\API\User\LostFoundItemController as UserLostFoundItemController;
use App\Http\Controllers\API\User\EventController as UserEventController;
use App\Http\Controllers\API\User\VehicleController as UserVehicleController;
use App\Http\Controllers\API\User\AmmenityController as UserAmmenityController;
use App\Http\Controllers\API\User\CommitteeController as UserCommitteeController;
use App\Http\Controllers\API\User\ReservationController as UserReservationController;
use App\Http\Controllers\API\User\DocumentController as UserDocumentController;
use App\Http\Controllers\API\User\FaqController as UserFaqController;
use App\Http\Controllers\API\User\ImpLinkController as UserImpLinkController;
use App\Http\Controllers\API\User\ClassifiedController as UserClassifiedController;
use App\Http\Controllers\API\User\VotingController as UserVotingController;
use App\Http\Controllers\API\User\DashboardController as UserDashboardController;
use App\Http\Controllers\API\User\ViolationController as UserViolationController;
use App\Http\Controllers\API\User\UserController as MemberController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('logout', [RegisterController::class, 'logout']);

//To access user routes
Route::middleware('auth:api')->group( function () {
    // ACC Requests API Routes
    Route::resource('user-acc-requests', UserAccRequestController::class);
    Route::post('/received-request', [UserAccRequestController::class, 'receivedApprovalRequest']);
    Route::post('/my-acc-request', [UserAccRequestController::class, 'myAccRequest']);
    Route::put('/my-approval/{id}', [UserAccRequestController::class, 'myApproval']);
    // Pet API Routes 
    Route::resource('user-pets', UserPetController::class);
    // Event API Routes
    Route::resource('user-events', UserEventController::class);
    Route::get('/archived-event', [UserEventController::class, 'archivedEvent']);
    Route::get('/upcoming-event', [UserEventController::class, 'upcomingEvent']);
    Route::put('/cancel-event/{id}', [UserEventController::class, 'cancelEvent']);
    // LostFoundItem API Routes
    Route::resource('user-lost-found-items', UserLostFoundItemController::class);
    // Ticket API Routes
    Route::resource('user-tickets', UserTicketController::class);
    // Vehicle API Routes
    Route::resource('user-vehicles', UserVehicleController::class);
    // Ammenity API Routes
    Route::resource('user-ammenities', UserAmmenityController::class);
    // Committee API Routes
    Route::resource('user-committees', UserCommitteeController::class);
    Route::get('/view-committee-member/{id}', [UserCommitteeController::class, 'viewMember']);
    // Reservation API Routes
    Route::resource('user-reservations', UserReservationController::class);
    // Document API Routes
    Route::resource('user-documents', UserDocumentController::class);
    // Faq API Routes
    Route::resource('user-faqs', UserFaqController::class);
    // ImpLink API Routes
    Route::resource('user-imp-links', UserImpLinkController::class);
    // Classified API Routes
    Route::resource('user-classifieds', UserClassifiedController::class);
    // Voting API Routes
    Route::resource('user-votings', UserVotingController::class);
    Route::post('/vote', [UserVotingController::class, 'voteNominee']);
    Route::get('/view-result/{id}', [UserVotingController::class, 'viewResult']);
    // Dashboard API Routes
    Route::resource('user-dashboard', UserDashboardController::class);
    // Violation API Routes
    Route::resource('user-violations', UserViolationController::class);
    // Violation API Routes
    Route::resource('members', MemberController::class);
});

//To access admin routes
Route::group(['prefix' => 'admin',  'middleware' => 'admin'], function() {
    // ACC Requests API Routes
    Route::resource('acc-requests', ACCRequestController::class);
    Route::delete('delete-all-acc-requests', [ACCRequestController::class, 'deleteAll']);
    // Listing of received request
    Route::post('/received-request', [ACCRequestController::class, 'receivedApprovalRequest']);
    // Listing of my request
    Route::post('/my-acc-request', [ACCRequestController::class, 'myAccRequest']);
    // Approve or reject received request 
    Route::put('/my-approval/{id}', [ACCRequestController::class, 'myApproval']);
    // Breed API Routes
    Route::get('/acc-report-export',[ACCRequestController::class, 'export'])->name('acc.export');
    Route::resource('breeds', BreedController::class);
    // Category API Routes
    Route::resource('categories', CategoryController::class);
    // Pet API Routes
    Route::resource('pets', PetController::class);
    // Pet Type API Routes
    Route::resource('pet-types', PetTypeController::class);
    // State API Routes
    Route::resource('states', StateController::class);
    // Role API Routes
    Route::resource('roles', RoleController::class);
    // Violation API Routes
    Route::resource('violations', ViolationController::class);
    Route::delete('delete-all-violations', [ViolationController::class, 'deleteAll']);
    Route::put('/post-response/{id}', [ViolationController::class, 'postResponse']);
    Route::post('/mark-as-read', [ViolationController::class, 'markNotification'])->name('markNotification');
    // Violation Type API Routes
    Route::resource('violation-types', ViolationTypeController::class);
    // LostFoundItem API Routes
    Route::resource('lost-found-items', LostFoundItemController::class);
    // Members API Routes
    Route::resource('users', UserController::class);
    // To Get City List
    Route::get('/city-list/{id}', [UserController::class, 'getCityList']);
    // Permission API Routes
    Route::resource('permissions', PermissionController::class);
    // PermissionHeading API Routes
    Route::resource('permission-headings', PermissionHeadingController::class);
    // Ticket API Routes
    Route::resource('tickets', TicketController::class);
    Route::put('/close-ticket/{id}', [TicketController::class, 'closeTicket']);
    // TicketCategory API Routes
    Route::resource('ticket-categories', TicketCategoryController::class);
    // Event API Routes
    Route::resource('events', EventController::class);
    Route::get('/archived-event', [EventController::class, 'archivedEvent']);
    Route::get('/upcoming-event', [EventController::class, 'upcomingEvent']);
    Route::put('/cancel-event/{id}', [EventController::class, 'cancelEvent']);
    // EventCategory API Routes
    Route::resource('event-categories', EventCategoryController::class);
    // EventLocation API Routes
    Route::resource('event-locations', EventLocationController::class);
    // Vehicle API Routes
    Route::resource('vehicles', VehicleController::class);
    // This should be under 'auth' middleware group
    Route::post('/mark-as-read', [VehicleController::class, 'markNotification'])->name('markNotification');
    // Ammenity API Routes
    Route::resource('ammenities', AmmenityController::class);
    // Committee API Routes
    Route::resource('committees', CommitteeController::class);
    // Reservation API Routes
    Route::resource('reservations', ReservationController::class);
    Route::get('/notification', [ReservationController::class, 'notification']);
    Route::post('/mark-as-read', [ReservationController::class, 'markNotification'])->name('markNotification');
    // Document API Routes
    Route::resource('documents', DocumentController::class);
    // Faq API Routes
    Route::resource('faqs', FaqController::class);
    // ImpLink API Routes
    Route::resource('imp-links', ImpLinkController::class);
    // Classified API Routes
    Route::resource('classifieds', ClassifiedController::class);
    // ClassifiedCondition API Routes
    Route::resource('classified-conditions', ClassifiedConditionController::class);
    // ClassifiedCategory API Routes
    Route::resource('classified-categories', ClassifiedCategoryController::class);
    // DocumentCategory API Routes
    Route::resource('document-categories', DocumentCategoryController::class);
    // VotingCategory API Routes
    Route::resource('voting-categories', VotingCategoryController::class);
    // Voting API Routes
    Route::resource('votings', VotingController::class);
    Route::delete('delete-all-votings', [VotingController::class, 'deleteAll']);
    Route::put('archived-votings/{id}', [VotingController::class, 'archivedVotings']);
});
