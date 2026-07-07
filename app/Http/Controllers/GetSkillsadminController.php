<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetSkillsadminController extends Controller
{
    // Dashboard light
    public function dashboard_1()
    {

        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.index', compact('page_title', 'page_description'));
    }
     // Dashboard dark
    public function dashboard_2()
    {

        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.index_2', compact('page_title', 'page_description'));
    }
    
    // schedule
    public function schedule()
    {

        $page_title = 'Schedule';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.schedule', compact('page_title', 'page_description'));
    }

    // instructors
    public function instructors()
    {

        $page_title = 'Instructors';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.instructors', compact('page_title', 'page_description'));
    }

    // message
    public function message()
    {

        $page_title = 'Message';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.message', compact('page_title', 'page_description'));
    }

     // activity
    public function activity()
    {

        $page_title = 'Activity';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.activity', compact('page_title', 'page_description'));
    }

    // profile
    public function profile()
    {

        $page_title = 'Profile';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.dashboard.profile', compact('page_title', 'page_description'));
    }
    //   courses ---------------------------------->

    // courses
    public function courses()
    {

        $page_title = 'Courses';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.courses.courses', compact('page_title', 'page_description'));
    }

    // course details 1
    public function course_details_1()
    {

        $page_title = 'Courses';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.courses.course_details_1', compact('page_title', 'page_description'));
    }

    // course details 2
    public function course_details_2()
    {

        $page_title = 'Courses';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.courses.course_details_2', compact('page_title', 'page_description'));
    }

    //    instructor ----------------------------->

    // instructor dashboard
    public function instructor_dashboard()
    {

        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.dashboard', compact('page_title', 'page_description'));
    }

    // instructor courses
    public function instructor_courses()
    {

        $page_title = 'Courses';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.courses', compact('page_title', 'page_description'));
    }

    // instructor schedule
    public function instructor_schedule()
    {

        $page_title = 'Instructor Schedule';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.schedule', compact('page_title', 'page_description'));
    }

    // instructor students
    public function instructor_students()
    {

        $page_title = 'Instructor Students';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.students', compact('page_title', 'page_description'));
    }

    // instructor resources
    public function instructor_resources()
    {

        $page_title = 'Instructor Resources';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.resources', compact('page_title', 'page_description'));
    }

    // instructor transactions
    public function instructor_transactions()
    {

        $page_title = 'Instructor Transactions';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.transactions', compact('page_title', 'page_description'));
    }

    // instructor liveclass
    public function instructor_liveclass()
    {

        $page_title = 'Live Class';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.instructor.liveclass', compact('page_title', 'page_description'));
    }


    // profile
    public function app_profile()
    {
        
        $page_title = 'Profile';
        $page_description = 'Some description for the page';
        

        return view('getskills.app.profile', compact('page_title', 'page_description'));   
    }

    // Post Details
    public function post_details()
    {
        
        $page_title = 'Post Details';
        $page_description = 'Some description for the page';
        

        return view('getskills.app.post_details', compact('page_title', 'page_description'));     
    }

    // Email Compose
    public function email_compose()
    {
        $page_title = 'Compose';
        $page_description = 'Some description for the page';
        
        return view('getskills.message.compose', compact('page_title', 'page_description'));
    }
    
    // Email Inbox
    public function email_inbox()
    {
        $page_title = 'Inbox';
        $page_description = 'Some description for the page';
        
        return view('getskills.message.inbox', compact('page_title', 'page_description'));
    }
    
    // Email Read
    public function email_read()
    {
        $page_title = 'Read';
        $page_description = 'Some description for the page';
        
        return view('getskills.message.read', compact('page_title', 'page_description'));
    }

    // Calender
    public function app_calender()
    {
        $page_title = 'Calendar';
        $page_description = 'Some description for the page';
        
        return view('getskills.app.calender', compact('page_title', 'page_description'));
    }

    // Ecommerce Checkout
    public function ecom_checkout()
    {
        $page_title = 'Checkout';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.checkout', compact('page_title', 'page_description'));
    }

    // Ecommerce Customers
    public function ecom_customers()
    {
        $page_title = 'Customers';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.customers', compact('page_title', 'page_description'));
    }
    
    // Ecommerce Invoice
    public function ecom_invoice()
    {
        $page_title = 'Invoice';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.invoice', compact('page_title', 'page_description'));
    }
    
    // Ecommerce Product Detail
    public function ecom_product_detail()
    {
        $page_title = 'Product-Detail';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.product_detail', compact('page_title', 'page_description'));
    }
    
    // Ecommerce Product Grid
    public function ecom_product_grid()
    {
        $page_title = 'Product-Grid';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.product_grid', compact('page_title', 'page_description'));
    }
    
    // Ecommerce Product List
    public function ecom_product_list()
    {
        $page_title = 'Product-List';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.product_list', compact('page_title', 'page_description'));
    }
    
    // Ecommerce Product Order
    public function ecom_product_order()
    {
        $page_title = 'Product-Order';
        $page_description = 'Some description for the page';
        
        return view('getskills.ecommerce.product_order', compact('page_title', 'page_description'));
    }

    // Chart Chartist
    public function chart_chartist()
    {
        $page_title = 'Chart-Chartist';
        $page_description = 'Some description for the page';
        
        return view('getskills.chart.chartist', compact('page_title', 'page_description'));
    }
    
    // Chart Chartjs
    public function chart_chartjs()
    {
        $page_title = 'Chart-ChartJS';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.chart.chartjs', compact('page_title', 'page_description'));
    }
    
    // Chart Flot
    public function chart_flot()
    {
        $page_title = 'Chart-Flot';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.chart.flot', compact('page_title', 'page_description'));
    }
    
    // Chart Morris
    public function chart_morris()
    {
        $page_title = 'Chart-Morris';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.chart.morris', compact('page_title', 'page_description'));
    }
    
    // Chart Peity
    public function chart_peity()
    {
        $page_title = 'Chart-Peity';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.chart.peity', compact('page_title', 'page_description'));
    }
    
    // Chart Sparkline
    public function chart_sparkline()
    {
        $page_title = 'Chart-Sparkline';
        $page_description = 'Some description for the page';
        
        
        return view('getskills.chart.sparkline', compact('page_title', 'page_description'));
    }

        // Ui Accordion
    public function ui_accordion()
    {
        $page_title = 'Accordion';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.accordion', compact('page_title', 'page_description'));
    }
    
    // Ui Alert
    public function ui_alert()
    {
        $page_title = 'Alert';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.alert', compact('page_title', 'page_description'));
    }
    
    // Ui Badge
    public function ui_badge()
    {
        $page_title = 'Badge';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.badge', compact('page_title', 'page_description'));
    }
    
    // Ui Button
    public function ui_button()
    {
        $page_title = 'Button';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.button', compact('page_title', 'page_description'));
    }
    
    // Ui Button Group
    public function ui_button_group()
    {
        $page_title = 'Button Group';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.button_group', compact('page_title', 'page_description'));
    }
    
    // Ui Card
    public function ui_card()
    {
        $page_title = 'Card';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.card', compact('page_title', 'page_description'));
    }
    
    // Ui Carousel
    public function ui_carousel()
    {
        $page_title = 'Carousel';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.carousel', compact('page_title', 'page_description'));
    }
    
    // Ui Dropdown
    public function ui_dropdown()
    {
        $page_title = 'Dropdown';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.dropdown', compact('page_title', 'page_description'));
    }
    
    // Ui Grid
    public function ui_grid()
    {
        $page_title = 'Grid';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.grid', compact('page_title', 'page_description'));
    }
    
    // Ui List Group
    public function ui_list_group()
    {
        $page_title = 'List Group';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.list_group', compact('page_title', 'page_description'));
    }
    
    // Ui Modal
    public function ui_modal()
    {
        $page_title = 'Modal';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.modal', compact('page_title', 'page_description'));
    }
    
    // Ui Pagination
    public function ui_pagination()
    {
        $page_title = 'Pagination';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.pagination', compact('page_title', 'page_description'));
    }
    
    // Ui Popover
    public function ui_popover()
    {
        $page_title = 'Popover';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.popover', compact('page_title', 'page_description'));
    }
    
    // Ui Progressbar
    public function ui_progressbar()
    {
        $page_title = 'Progressbar';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.progressbar', compact('page_title', 'page_description'));
    }
    
    // Ui Tab
    public function ui_tab()
    {
        $page_title = 'Tab';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.tab', compact('page_title', 'page_description'));
    }
    

    // Ui Typography
    public function ui_typography()
    {
        $page_title = 'Typography';
        $page_description = 'Some description for the page';
        
        return view('getskills.ui.typography', compact('page_title', 'page_description'));
    }

    // UC Nestedable.
    public function uc_nestable()
    {
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        
        return view('getskills.uc.nestable', compact('page_title', 'page_description'));
    }
    // UC Lightgallery.
    public function uc_lightgallery()
    {
        $page_title = 'LightGallery';
        $page_description = 'Some description for the page';
        
        return view('getskills.uc.lightgallery', compact('page_title', 'page_description'));
    }
    
    // UC NoUi Slider
    public function uc_noui_slider()
    {
        $page_title = 'UI Slider';
        $page_description = 'Some description for the page';
        
        return view('getskills.uc.noui_slider', compact('page_title', 'page_description'));
    }
    
    // UC Select2
    public function uc_select2()
    {
        $page_title = 'Select';
        $page_description = 'Some description for the page';
        
        return view('getskills.uc.select2', compact('page_title', 'page_description'));
    }
    
    // UC Sweetalert
    public function uc_sweetalert()
    {
        $page_title = 'Sweet Alert';
        $page_description = 'Some description for the page';
        
        return view('getskills.uc.sweetalert', compact('page_title', 'page_description'));
    }
    
    // UC Toastr
    public function uc_toastr()
    {
        $page_title = 'Toastr';
        $page_description = 'Some description for the page';
        
        return view('getskills.uc.toastr', compact('page_title', 'page_description'));
    }

    // Map Jqvmap
    public function map_jqvmap()
    {
        $page_title = 'Jqvmap';
        $page_description = 'Some description for the page';
        
        return view('getskills.map.jqvmap', compact('page_title', 'page_description'));
    }

    // Widget Basic
    public function widget_basic()
    {
        $page_title = 'Widget';
        $page_description = 'Some description for the page';
        
        return view('getskills.widget.widget_basic', compact('page_title', 'page_description'));
    }

    // Form Editor Summernote
    public function form_ckeditor()
    {
        $page_title = 'Ckeditor';
        $page_description = 'Some description for the page';
        
        return view('getskills.form.ckeditor', compact('page_title', 'page_description'));
    }
    
    // Form Element
    public function form_element()
    {
        $page_title = 'Form-Element';
        $page_description = 'Some description for the page';
        
        return view('getskills.form.element', compact('page_title', 'page_description'));
    }
    
    // Form Pickers
    public function form_pickers()
    {
        $page_title = 'Pickers';
        $page_description = 'Some description for the page';
        
        return view('getskills.form.pickers', compact('page_title', 'page_description'));
    }
    
    // Form Validation Jquery
    public function form_validation()
    {
        $page_title = 'Form-Validation';
        $page_description = 'Some description for the page';
        
        return view('getskills.form.validation', compact('page_title', 'page_description'));
    }
    
    // Form Wizard
    public function form_wizard()
    {
        $page_title = 'Form-Wizard';
        $page_description = 'Some description for the page';
        
        return view('getskills.form.wizard', compact('page_title', 'page_description'));
    }

    // Table Bootstrap Basic
    public function table_bootstrap_basic()
    {
        $page_title = 'Table-Bootstrap';
        $page_description = 'Some description for the page';
        
        return view('getskills.table.bootstrap_basic', compact('page_title', 'page_description'));
    }
    
    // Table Datatable Basic
    public function table_datatable_basic()
    {
        $page_title = 'Table-Datatable';
        $page_description = 'Some description for the page';
        
        return view('getskills.table.datatable_basic', compact('page_title', 'page_description'));
    }

        // Page Error 400
    public function page_error_400()
    {
        $page_title = 'Page Error 400';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.error_400', compact('page_title', 'page_description'));
    }
    
    // Page Error 403
    public function page_error_403()
    {
        $page_title = 'Page Error 403';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.error_403', compact('page_title', 'page_description'));
    }
    
    // Page Error 404
    public function page_error_404()
    {
        $page_title = 'Page Error 404';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.error_404', compact('page_title', 'page_description'));
    }
    
    // Page Error 500
    public function page_error_500()
    {
        $page_title = 'Page Error 500';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.error_500', compact('page_title', 'page_description'));
    }
    
    // Page Error 503
    public function page_error_503()
    {
        $page_title = 'Page Error 503';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.error_503', compact('page_title', 'page_description'));
    }
    
    // Page Forgot Password
    public function page_forgot_password()
    {
        $page_title = 'Page Forgot Password';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.forgot_password', compact('page_title', 'page_description'));
    }
    
    // Page Lock Screen
    public function page_lock_screen()
    {
        $page_title = 'Page Lock Screen';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.lock_screen', compact('page_title', 'page_description'));
    }
    
    //  Login
    public function login()
    {
        $page_title = 'Login 1';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.login', compact('page_title', 'page_description'));
    }

    // Page Login
    public function page_login()
    {
        $page_title = 'Login 2';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.page_login', compact('page_title', 'page_description'));
    }
    
    // Page Register
    public function page_register()
    {
        $page_title = 'Page Register';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.register', compact('page_title', 'page_description'));
    }
     // Page Register
    public function page_empty()
    {
        $page_title = 'Empty Page';
        $page_description = 'Some description for the page';
        
        return view('getskills.page.empty', compact('page_title', 'page_description'));
    }


}
