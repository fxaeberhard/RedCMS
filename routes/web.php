<?php

use App\Page;
use Illuminate\Http\Request;
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

/*
 * Authentication
 */
// Auth::routes();
Route::get('loginpopup', 'Auth\LoginController@login');
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// // Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// // Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

/**
 * Admin
 */

Route::resource('Page', 'PageController');
Route::model('Page', 'App\Page');
Route::resource('User', 'UserController');
Route::post('User/signin', 'UserController@signin');
Route::model('User', 'App\User');
Route::resource('Group', 'GroupController');
Route::model('Group', 'App\Group');

Route::resource('PageBlock', 'PageBlockController');
Route::model('PageBlock', 'App\PageBlock');
Route::get('edit', 'BlockController@edit');
Route::get('add', 'BlockController@add');
Route::get('create', 'BlockController@create');

Route::resource('Text', 'TextController');
Route::model('Text', 'App\Text');
Route::resource('Menu', 'MenuController');
Route::model('Menu', 'App\Menu');
Route::resource('MenuItem', 'MenuItemController');
Route::post('MenuItem/Sort', 'MenuItemController@sort');
Route::model('MenuItem', 'App\MenuItem');
Route::resource('Form', 'FormController');
Route::model('Form', 'App\Form');
Route::post('mailinglist', 'FormController@sendMail');
Route::resource('Gallery', 'GalleryController');
Route::model('Gallery', 'App\Gallery');
Route::resource('GalleryItem', 'GalleryItemController');
Route::post('GalleryItem/Sort', 'GalleryItemController@sort');
Route::model('GalleryItem', 'App\GalleryItem');
Route::resource('FileList', 'BlockController');
Route::model('FileList', 'App\FileList');
Route::resource('SimpleBlock', 'BlockController');
Route::model('SimpleBlock', 'App\SimpleBlock');
Route::resource('Calendar', 'CalendarController');
Route::model('Calendar', 'App\Calendar');
Route::resource('CalendarEvent', 'CalendarEventController');
Route::model('CalendarEvent', 'App\CalendarEvent');
Route::resource('Blog', 'BlogController');
Route::model('Blog', 'App\Blog');
Route::resource('BlogPost', 'BlogPostController');
Route::model('BlogPost', 'App\BlogPost');
Route::resource('BlogComment', 'BlogCommentController');
Route::model('BlogComment', 'App\BlogComment');

Route::resource('FileManager', 'FileController');

/*
 * File manager
 */
$middleware = array_merge(\Config::get('lfm.middlewares'), [
	'\Unisharp\Laravelfilemanager\middlewares\MultiUser',
	'\Unisharp\Laravelfilemanager\middlewares\CreateDefaultFolder',
]);
$prefix = \Config::get('lfm.prefix', 'laravel-filemanager');
$as = 'unisharp.lfm.';
$namespace = '\Unisharp\Laravelfilemanager\controllers';

// make sure authenticated
Route::group(compact('middleware', 'prefix', 'as', 'namespace'), function () {

	// Show LFM
	Route::get('/', [
		'uses' => 'LfmController@show',
		'as' => 'show',
	]);

	// Show integration error messages
	Route::get('/errors', [
		'uses' => 'LfmController@getErrors',
		'as' => 'getErrors',
	]);

	// upload
	Route::any('/upload', [
		'uses' => 'UploadController@upload',
		'as' => 'upload',
	]);

	// list images & files
	Route::get('/jsonitems', [
		'uses' => 'ItemsController@getItems',
		'as' => 'getItems',
	]);

	// folders
	Route::get('/newfolder', [
		'uses' => 'FolderController@getAddfolder',
		'as' => 'getAddfolder',
	]);
	Route::get('/deletefolder', [
		'uses' => 'FolderController@getDeletefolder',
		'as' => 'getDeletefolder',
	]);
	Route::get('/folders', [
		'uses' => 'FolderController@getFolders',
		'as' => 'getFolders',
	]);

	// crop
	Route::get('/crop', [
		'uses' => 'CropController@getCrop',
		'as' => 'getCrop',
	]);
	Route::get('/cropimage', [
		'uses' => 'CropController@getCropimage',
		'as' => 'getCropimage',
	]);

	// rename
	Route::get('/rename', [
		'uses' => 'RenameController@getRename',
		'as' => 'getRename',
	]);

	// scale/resize
	Route::get('/resize', [
		'uses' => 'ResizeController@getResize',
		'as' => 'getResize',
	]);
	Route::get('/doresize', [
		'uses' => 'ResizeController@performResize',
		'as' => 'performResize',
	]);

	// download
	Route::get('/download', [
		'uses' => 'DownloadController@getDownload',
		'as' => 'getDownload',
	]);

	// delete
	Route::get('/delete', [
		'uses' => 'DeleteController@getDelete',
		'as' => 'getDelete',
	]);

	Route::get('/demo', 'DemoController@index');

	// Get file when base_directory isn't public
	$images_url = '/' . \Config::get('lfm.images_folder_name') . '/{base_path}/{image_name}';
	$files_url = '/' . \Config::get('lfm.files_folder_name') . '/{base_path}/{file_name}';
	Route::get($images_url, 'RedirectController@getImage')
		->where('image_name', '.*');
	Route::get($files_url, 'RedirectController@getFIle')
		->where('file_name', '.*');
});

/**
 * Pages
 */
Route::get('/', function (Request $request) {
	//App::setLocale('en');

	// Try language detection if it's first time
	/*if (!$request->session()->has('lang') && isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) {
		$langs = prefered_language(locales(), $_SERVER["HTTP_ACCEPT_LANGUAGE"]);

		// print_r($langs);

		reset($langs);
		$lang = key($langs);
		session(['lang' => $lang]);
		if ($lang != 'en') {
			return redirect($lang);
		}
	}*/

	$page = Page::find(1);

	if (!isset($page)) {
		abort(404);
	}

	return view('page', ['page' => $page]);
});

Route::get('/{page}', function ($page) {
	$page = Page::where('name_en', redurldecode($page))->first();

	if (!isset($page)) {
		abort(404);
	}

	return view('page', ['page' => $page]);
});

Route::get('/{lang}/{page}', function ($lang, $page) {
	$page = Page::where('name_en', $page)->first();

	if (!isset($page)) {
		abort(404);
	}

	return view('page', ['page' => $page]);
});

// Route::get('/{lang}', function ($lang) {
// 	App::setLocale($lang);
// 	session(['lang' => $lang]);
// 	$page = Page::find(1);
// 	return view('page', ['page' => $page]);
// });

// Route::get('/{lang}/{page}', function ($lang, $page) {
// 	App::setLocale($lang);
// 	session(['lang' => $lang]);
// 	$page = Page::where('name_' . $lang, $page)->first();

// 	if (!isset($page)) {
// 		return view('pagenotfound');
// 	}
// 	return view('page', ['page' => $page]);
// });
