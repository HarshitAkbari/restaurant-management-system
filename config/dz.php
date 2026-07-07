<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'GetSkills Laravel'),


    'public' => [
        'favicon' => 'media/img/logo/favicon.ico',
        'fonts' => [
            'google' => [
                'families' => [
                    'Poppins:300,400,500,600,700',
                ]
            ]
        ],
		'global' => [
			'css' => [
				'vendor/jquery-nice-select/css/nice-select.css',
				'css/style.css',
			],
			'js' => [
				'top'=>[
					'vendor/global/global.min.js',
					'vendor/jquery-nice-select/js/jquery.nice-select.min.js',	
				],
				'bottom'=>[
					'js/custom.min.js',
					'js/dlabnav-init.js',
				],
			],
		],
		'pagelevel' => [
			'css' => [
				'GetSkillsadminController_dashboard_1' => [
							'vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
				],
				'GetSkillsadminController_dashboard_2' => [
							'vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
				],
				'GetSkillsadminController_schedule' => [
							'vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
							'vendor/fullcalendar/css/main.min.css',
				],
				'GetSkillsadminController_instructor' => [
				],
				'GetSkillsadminController_message' => [
				],
				'GetSkillsadminController_activity' => [
				],
				'GetSkillsadminController_profile' => [
				],
				'GetSkillsadminController_courses' => [
					'vendor/swiper/css/swiper-bundle.min.css',
				],
				'GetSkillsadminController_course_details_1' => [
					'vendor/magnific-popup/magnific-popup.min.css',
				],
				'GetSkillsadminController_course_details_2' => [
					'vendor/magnific-popup/magnific-popup.min.css',
				],
				'GetSkillsadminController_instructor_dashboard' => [
					'vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
				],
				'GetSkillsadminController_instructor_courses' => [
					'vendor/owl-carousel/owl.carousel.css',
				],
				'GetSkillsadminController_instructor_schedule' => [
					'vendor/fullcalendar/css/main.min.css',
				],
				'GetSkillsadminController_instructor_students' => [
					'vendor/datatables/css/jquery.dataTables.min.css',
				],
				'GetSkillsadminController_instructor_resources' => [
				],
				'GetSkillsadminController_instructor_transactions' => [
					'vendor/datatables/css/jquery.dataTables.min.css',
				],
				'GetSkillsadminController_instructor_liveclass' => [
				],
				'GetSkillsadminController_app_profile' => [
							'vendor/lightgallery/css/lightgallery.min.css',
				],
				'GetSkillsadminController_post_details' => [
							'vendor/lightgallery/css/lightgallery.min.css',
				],
				'GetSkillsadminController_app_calender' => [
							'vendor/fullcalendar/css/main.min.css',
				],
				'GetSkillsadminController_chart_chartist' => [
							'vendor/chartist/css/chartist.min.css',
				],
				'GetSkillsadminController_chart_chartjs' => [
				],
				'GetSkillsadminController_chart_flot' => [
				],
				'GetSkillsadminController_chart_morris' => [
				],
				'GetSkillsadminController_chart_peity' => [
				],
				'GetSkillsadminController_chart_sparkline' => [
				],
				'GetSkillsadminController_ecom_checkout' => [
				],
				'GetSkillsadminController_ecom_customers' => [

				],
				'GetSkillsadminController_ecom_invoice' => [
					'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
				],
				'GetSkillsadminController_ecom_product_detail' => [
							'vendor/star-rating/star-rating-svg.css',
				],
				'GetSkillsadminController_ecom_product_grid' => [
				],
				'GetSkillsadminController_ecom_product_list' => [
							'vendor/star-rating/star-rating-svg.css',
				],
				'GetSkillsadminController_ecom_product_order' => [
				],
				'GetSkillsadminController_email_compose' => [
							'vendor/dropzone/dist/dropzone.css',
				],
				'GetSkillsadminController_email_inbox' => [
				],
				'GetSkillsadminController_email_read' => [
				],
				'GetSkillsadminController_form_ckeditor' => [
				],
				'GetSkillsadminController_form_element' => [
				],
				'GetSkillsadminController_form_pickers' => [
							'vendor/bootstrap-daterangepicker/daterangepicker.css',
							'vendor/clockpicker/css/bootstrap-clockpicker.min.css',
							'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
							'vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
							'vendor/pickadate/themes/default.css',
							'vendor/pickadate/themes/default.date.css',
							'https://fonts.googleapis.com/icon?family=Material+Icons',
				],
				'GetSkillsadminController_form_validation' => [
				],
				'GetSkillsadminController_form_wizard' => [
							'vendor/jquery-smartwizard/dist/css/smart_wizard.min.css',
				],
				'GetSkillsadminController_map_jqvmap' => [
							'vendor/jqvmap/css/jqvmap.min.css',
				],
				'GetSkillsadminController_login' => [
							'vendor/sweetalert2/dist/sweetalert2.min.css',
				],
				'GetSkillsadminController_table_bootstrap_basic' => [
				],
				'GetSkillsadminController_table_datatable_basic' => [
							'vendor/datatables/css/jquery.dataTables.min.css',
				],
				'GetSkillsadminController_uc_lightgallery' => [
							'vendor/lightgallery/css/lightgallery.min.css',
				],
				'GetSkillsadminController_uc_nestable' => [
							'vendor/nestable2/css/jquery.nestable.min.css',
				],
				'GetSkillsadminController_uc_noui_slider' => [
							'vendor/nouislider/nouislider.min.css',
				],
				'GetSkillsadminController_uc_select2' => [
							'vendor/select2/css/select2.min.css',
				],
				'GetSkillsadminController_uc_sweetalert' => [
							'vendor/sweetalert2/dist/sweetalert2.min.css',
				],
				'GetSkillsadminController_uc_toastr' => [
							'vendor/toastr/css/toastr.min.css',
				],
				'GetSkillsadminController_ui_accordion' => [
				],
				'GetSkillsadminController_ui_alert' => [
				],
				'GetSkillsadminController_ui_badge' => [
				],
				'GetSkillsadminController_ui_button' => [
				],
				'GetSkillsadminController_ui_button_group' => [
				],
				'GetSkillsadminController_ui_card' => [
				],
				'GetSkillsadminController_ui_carousel' => [
				],
				'GetSkillsadminController_ui_dropdown' => [
				],
				'GetSkillsadminController_ui_grid' => [
				],
				'GetSkillsadminController_ui_list_group' => [
				],
				'GetSkillsadminController_ui_modal' => [
				],
				'GetSkillsadminController_ui_pagination' => [
				],
				'GetSkillsadminController_ui_popover' => [
				],
				'GetSkillsadminController_ui_progressbar' => [
				],
				'GetSkillsadminController_ui_tab' => [
				],
				'GetSkillsadminController_ui_typography' => [
				],
				'GetSkillsadminController_widget_basic' => [
							'vendor/chartist/css/chartist.min.css',
							'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
				],
				'GetSkillsadminController_page_error_400' => [
					'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
				],
				'GetSkillsadminController_demo_modules_index' => [
				],
				'GetSkillsadminController_demo_modules_add' => [
				],
			],
			'js' => [
				'GetSkillsadminController_dashboard_1' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/bootstrap-datetimepicker/js/moment.js',
							'vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
							'js/dashboard/dashboard-1.js',
				],
				'GetSkillsadminController_dashboard_2' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/bootstrap-datetimepicker/js/moment.js',
							'vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
							'js/dashboard/dashboard-1.js',
				],
				 'GetSkillsadminController_schedule' => [
							'vendor/bootstrap-datetimepicker/js/moment.js',
							'vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/moment/moment.min.js',
							'vendor/fullcalendar/js/main.min.js',
							'js/plugins-init/fullcalendar-init.js',
							'js/dashboard/schedule.js',
				],
				'GetSkillsadminController_instructor' => [
				],
				'GetSkillsadminController_message' => [
				],
				'GetSkillsadminController_activity' => [
				],
				'GetSkillsadminController_profile' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/peity/jquery.peity.min.js',
							'js/dashboard/my-profile.js',
				],
				'GetSkillsadminController_courses' => [
					'vendor/swiper/js/swiper-bundle.min.js',
					'js/dlab.carousel.js',
				],
				'GetSkillsadminController_course_details_1' => [
					'vendor/magnific-popup/magnific-popup.js',
				],
				'GetSkillsadminController_course_details_2' => [
					'vendor/magnific-popup/magnific-popup.js',
				],
				'GetSkillsadminController_instructor_dashboard' => [
					'vendor/chart.js/Chart.bundle.min.js',
					'vendor/apexchart/apexchart.js',
					'vendor/bootstrap-datetimepicker/js/moment.js',
					'vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
					'vendor/day-fullcalendar/main.min.js',
					'vendor/peity/jquery.peity.min.js',
					'js/dashboard/instructor-dashboard.js',
				],
				'GetSkillsadminController_instructor_courses' => [
					'vendor/chart.js/Chart.bundle.min.js',
					'vendor/apexchart/apexchart.js',
					'vendor/peity/jquery.peity.min.js',
					'vendor/owl-carousel/owl.carousel.js',
					'js/dashboard/instructor-courses.js',
					'js/dlab.carousel.js',
				],
				'GetSkillsadminController_instructor_schedule' => [
					'vendor/moment/moment.min.js',
					'vendor/fullcalendar/js/main.min.js',
					'js/plugins-init/fullcalendar-init.js',
				],
				'GetSkillsadminController_instructor_students' => [
					'vendor/chart.js/Chart.bundle.min.js',
					'vendor/apexchart/apexchart.js',
					'vendor/datatables/js/jquery.dataTables.min.js',
					'js/plugins-init/datatables.init.js',
					'vendor/owl-carousel/owl.carousel.js',
					'js/dashboard/instructor-student.js',
				],
				'GetSkillsadminController_instructor_resources' => [
					'vendor/chart.js/Chart.bundle.min.js',
				],
				'GetSkillsadminController_instructor_transactions' => [
					'vendor/chart.js/Chart.bundle.min.js',
					'vendor/apexchart/apexchart.js',
					'vendor/datatables/js/jquery.dataTables.min.js',
					'js/plugins-init/datatables.init.js',
					'js/dashboard/instructor-transactions.js',
				],
				'GetSkillsadminController_instructor_liveclass' => [
					'vendor/chart.js/Chart.bundle.min.js',
				],
				'GetSkillsadminController_app_calender' => [
							'vendor/moment/moment.min.js',
							'vendor/fullcalendar/js/main.min.js',
							'js/plugins-init/fullcalendar-init.js',
				],
				'GetSkillsadminController_app_profile' => [
							'vendor/lightgallery/js/lightgallery-all.min.js',
				],
				'GetSkillsadminController_post_details' => [
							'vendor/lightgallery/js/lightgallery-all.min.js',
				],
				'GetSkillsadminController_chart_chartist' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/chartist/js/chartist.min.js',
							'vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js',
							'js/plugins-init/chartist-init.js',
				],
				'GetSkillsadminController_chart_chartjs' => [
						    'vendor/chart.js/Chart.bundle.min.js',
							'js/plugins-init/chartjs-init.js',
				],
				'GetSkillsadminController_chart_flot' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/flot/jquery.flot.js',
							'vendor/flot/jquery.flot.pie.js',
							'vendor/flot/jquery.flot.resize.js',
							'vendor/flot-spline/jquery.flot.spline.min.js',
							'js/plugins-init/flot-init.js',
				],
				'GetSkillsadminController_chart_morris' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/raphael/raphael.min.js',
							'vendor/morris/morris.min.js',
							'js/plugins-init/morris-init.js',
				],
				'GetSkillsadminController_chart_peity' => [
						    'vendor/chart.js/Chart.bundle.min.js',
							'vendor/peity/jquery.peity.min.js',
							'js/plugins-init/piety-init.js',
				],
				'GetSkillsadminController_chart_sparkline' => [
						    'vendor/chart.js/Chart.bundle.min.js',
						    'vendor/apexchart/apexchart.js',
							'vendor/jquery-sparkline/jquery.sparkline.min.js',
							'js/plugins-init/sparkline-init.js',
							'vendor/svganimation/vivus.min.js',
							'vendor/svganimation/svg.animation.js',
				],
				'GetSkillsadminController_ecom_checkout' => [
				],
				'GetSkillsadminController_ecom_customers' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/highlightjs/highlight.pack.min.js',
				],
				'GetSkillsadminController_ecom_invoice' => [
				],
				'GetSkillsadminController_ecom_product_detail' => [
							'vendor/star-rating/jquery.star-rating-svg.js',
                ],
				'GetSkillsadminController_ecom_product_grid' => [
				],
				'GetSkillsadminController_ecom_product_list' => [
							'vendor/star-rating/jquery.star-rating-svg.js',
				],
				'GetSkillsadminController_ecom_product_order' => [
				],
				'GetSkillsadminController_email_compose' => [
							'vendor/dropzone/dist/dropzone.js',
				],
				'GetSkillsadminController_email_inbox' => [
				],
				'GetSkillsadminController_email_read' => [
				],
				'GetSkillsadminController_form_ckeditor' => [
							'vendor/ckeditor/ckeditor.js',
				],
				'GetSkillsadminController_form_element' => [
				],
				'GetSkillsadminController_form_pickers' => [
							'vendor/bootstrap-select/dist/js/bootstrap-select.min.js',
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/moment/moment.min.js',
							'vendor/bootstrap-daterangepicker/daterangepicker.js',
							'vendor/clockpicker/js/bootstrap-clockpicker.min.js',
							'vendor/jquery-asColor/jquery-asColor.min.js',
							'vendor/jquery-asGradient/jquery-asGradient.min.js',
							'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
							'vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js',
							'vendor/pickadate/picker.js',
							'vendor/pickadate/picker.time.js',
							'vendor/pickadate/picker.date.js',
							'js/plugins-init/bs-daterange-picker-init.js',
							'js/plugins-init/clock-picker-init.js',
							'js/plugins-init/jquery-asColorPicker.init.js',
							'js/plugins-init/material-date-picker-init.js',
							'js/plugins-init/pickadate-init.js',
				],
				'GetSkillsadminController_form_validation' => [
				],
				'GetSkillsadminController_form_wizard' => [
							'vendor/jquery-steps/build/jquery.steps.min.js',
							'vendor/jquery-validation/jquery.validate.min.js',
							'js/plugins-init/jquery.validate-init.js',
							'vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js',
				],
				'GetSkillsadminController_map_jqvmap' => [
							'vendor/jqvmap/js/jquery.vmap.min.js',
							'vendor/jqvmap/js/jquery.vmap.world.js',
							'vendor/jqvmap/js/jquery.vmap.usa.js',
							'js/plugins-init/jqvmap-init.js',
				],
				'GetSkillsadminController_page_error_400' => [
				],
				'GetSkillsadminController_page_error_403' => [
				],
				'GetSkillsadminController_page_error_404' => [
				],
				'GetSkillsadminController_page_error_500' => [
				],
				'GetSkillsadminController_page_error_503' => [
				],
				'GetSkillsadminController_page_forgot_password' => [
				],
				'GetSkillsadminController_page_lock_screen' => [
							'vendor/deznav/deznav.min.js',
				],
				'GetSkillsadminController_page_login' => [

				],
				'GetSkillsadminController_page_register' => [
				],
				'GetSkillsadminController_table_bootstrap_basic' => [
				],
				'GetSkillsadminController_table_datatable_basic' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/datatables/js/jquery.dataTables.min.js',
							'js/plugins-init/datatables.init.js',
				],
				'GetSkillsadminController_uc_lightgallery' => [
							'vendor/lightgallery/js/lightgallery-all.min.js',
				],
				'GetSkillsadminController_uc_nestable' => [
							'vendor/nestable2/js/jquery.nestable.min.js',
							'js/plugins-init/nestable-init.js',
				],
				'GetSkillsadminController_uc_noui_slider' => [
							'vendor/nouislider/nouislider.min.js',
							'vendor/wnumb/wNumb.js',
							'js/plugins-init/nouislider-init.js',
				],
				'GetSkillsadminController_uc_select2' => [
							'vendor/select2/js/select2.full.min.js',
							'js/plugins-init/select2-init.js',
				],
				'GetSkillsadminController_uc_sweetalert' => [
							'vendor/sweetalert2/dist/sweetalert2.min.js',
							'js/plugins-init/sweetalert.init.js',
				],
				'GetSkillsadminController_uc_toastr' => [
							'vendor/toastr/js/toastr.min.js',
							'js/plugins-init/toastr-init.js',
				],
				'GetSkillsadminController_ui_accordion' => [
				],
				'GetSkillsadminController_ui_alert' => [
				],
				'GetSkillsadminController_ui_badge' => [
				],
				'GetSkillsadminController_ui_button' => [
				],
				'GetSkillsadminController_ui_button_group' => [
				],
				'GetSkillsadminController_ui_card' => [
				],
				'GetSkillsadminController_ui_carousel' => [
				],
				'GetSkillsadminController_ui_dropdown' => [
				],
				'GetSkillsadminController_ui_grid' => [
				],
				'GetSkillsadminController_ui_list_group' => [
				],
				'GetSkillsadminController_ui_modal' => [
				],
				'GetSkillsadminController_ui_pagination' => [
				],
				'GetSkillsadminController_ui_popover' => [
				],
				'GetSkillsadminController_ui_progressbar' => [
				],
				'GetSkillsadminController_ui_tab' => [
				],
				'GetSkillsadminController_ui_typography' => [
				],
				'GetSkillsadminController_widget_basic' => [
							'vendor/chart.js/Chart.bundle.min.js',
							'vendor/apexchart/apexchart.js',
							'vendor/chartist/js/chartist.min.js',
							'vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js',
							'vendor/flot/jquery.flot.js',
							'vendor/flot/jquery.flot.pie.js',
							'vendor/flot/jquery.flot.resize.js',
							'vendor/flot-spline/jquery.flot.spline.min.js',
							'vendor/jquery-sparkline/jquery.sparkline.min.js',
							'js/plugins-init/sparkline-init.js',
							'vendor/peity/jquery.peity.min.js',
							'js/plugins-init/piety-init.js',
							'js/plugins-init/widgets-script-init.js',
				],
				
				'GetSkillsadminController_demo_modules_add' => [
				],
					
			]
		],
	]
];
