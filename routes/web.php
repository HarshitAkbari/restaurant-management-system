<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetSkillsadminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::controller(GetSkillsadminController::class)->group(function () {

    Route::get('/',                 'dashboard_1');
    Route::get('/index',            'dashboard_1');
    Route::get('/index-2',          'dashboard_2');
    Route::get('/schedule',         'schedule');
    Route::get('/instructors',      'instructors');
    Route::get('/message',          'message');
    Route::get('/activity',         'activity');
    Route::get('/profile',          'profile');
    Route::get('/courses',          'courses');
    Route::get('/course-details-1', 'course_details_1');
    Route::get('/course-details-2', 'course_details_2');
    Route::get('/instructor-dashboard','instructor_dashboard');
    Route::get('/instructor-courses','instructor_courses');
    Route::get('/instructor-schedule','instructor_schedule');
    Route::get('/instructor-students','instructor_students');
    Route::get('/instructor-resources','instructor_resources');
    Route::get('/instructor-transactions','instructor_transactions');
    Route::get('/instructor-liveclass','instructor_liveclass');
    Route::get('/app-profile',      'app_profile');
    Route::match(['get','post'],'/post-details',     'post_details');
    Route::get('/email-compose',    'email_compose');
    Route::get('/email-inbox',      'email_inbox');
    Route::get('/email-read',       'email_read');
    Route::get('/app-calender',     'app_calender');
    Route::get('/ecom-product-grid','ecom_product_grid');
    Route::get('/ecom-product-list','ecom_product_list');
    Route::get('/ecom-product-detail','ecom_product_detail');
    Route::get('/ecom-product-order','ecom_product_order');
    Route::get('/ecom-checkout',    'ecom_checkout');
    Route::get('/ecom-invoice',     'ecom_invoice');
    Route::get('/ecom-customers',   'ecom_customers');
    Route::get('/chart-flot',       'chart_flot');
    Route::get('/chart-morris',     'chart_morris');
    Route::get('/chart-chartjs',    'chart_chartjs');
    Route::get('/chart-chartist',   'chart_chartist');
    Route::get('/chart-sparkline',  'chart_sparkline');
    Route::get('/chart-peity',      'chart_peity');
    Route::get('/ui-accordion',     'ui_accordion');
    Route::get('/ui-alert',         'ui_alert');
    Route::get('/ui-badge',         'ui_badge');
    Route::get('/ui-button',        'ui_button');
    Route::get('/ui-modal',         'ui_modal');
    Route::get('/ui-button-group',  'ui_button_group');
    Route::get('/ui-list-group',    'ui_list_group');
    Route::get('/ui-card',          'ui_card');
    Route::get('/ui-carousel',      'ui_carousel');
    Route::get('/ui-dropdown',      'ui_dropdown');
    Route::get('/ui-popover',       'ui_popover');
    Route::get('/ui-progressbar',   'ui_progressbar');
    Route::get('/ui-tab',           'ui_tab');
    Route::get('/ui-typography',    'ui_typography');
    Route::get('/ui-pagination',    'ui_pagination');
    Route::get('/ui-grid',          'ui_grid');
    Route::get('/uc-select2',       'uc_select2');
    Route::get('/uc-nestable',      'uc_nestable');
    Route::get('/uc-noui-slider',   'uc_noui_slider');
    Route::get('/uc-sweetalert',    'uc_sweetalert');
    Route::get('/uc-toastr',        'uc_toastr');
    Route::get('/map-jqvmap',       'map_jqvmap');
    Route::get('/uc-lightgallery',  'uc_lightgallery');
    Route::get('/widget-basic',     'widget_basic');
    Route::get('/form-element',     'form_element');
    Route::get('/form-wizard',      'form_wizard');
    Route::get('/form-ckeditor',    'form_ckeditor');
    Route::get('/form-pickers',     'form_pickers');
    Route::get('/form-validation',  'form_validation');
    Route::get('/table-bootstrap-basic', 'table_bootstrap_basic');
    Route::get('/table-datatable-basic', 'table_datatable_basic');
    Route::get('/page-login',       'page_login');
    Route::get('/page-register',    'page_register');
    Route::get('/page-error-400',   'page_error_400');
    Route::get('/page-error-403',   'page_error_403');
    Route::get('/page-error-404',   'page_error_404');
    Route::get('/page-error-500',   'page_error_500');
    Route::get('/page-error-503',   'page_error_503');
    Route::get('/page-forgot-password', 'page_forgot_password');
    Route::get('/page-lock-screen', 'page_lock_screen');
    Route::get('/empty-page',       'page_empty');

});