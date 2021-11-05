<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => '',
    'title_prefix' => '',
    'title_postfix' => ' - '.env('APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    // 'logo' => '<b>EPCFMS</b> '.env('APP_NAME').'</b>',
    'logo' => '<b>'.env('APP_NAME').'</b>',
     'logo_img' => 'vendor/adminlte/dist/img/logo.png',
    //'logo_img' => null,
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    // 'logo_img_alt' => 'AdminLTE',
    'logo_img_alt' => null,

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => 'container-fluid',
    'classes_content' => 'container-fluid',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'admin/dashboard',

    'logout_url' => 'admin/logout',

    'login_url' => 'admin/login',

    'register_url' => 'admin/register',

    'password_reset_url' => 'admin/password/reset',

    'password_email_url' => 'admin/password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text' => 'Dashboard',
            'url'  => 'admin/dashboard',
            'module' => 'Menu',
            'rbac' => true,
            'icon' => 'icon-bar-chart',
            'permission-slug' => 'admin/dashboard',
            "organization"=>0,
            "other"=>1
        ],
        [
            'text' => 'Organizations',
            'url'  => 'admin/organization',
            'module' => 'Menu',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'icon-users',
            'permission-slug' => 'admin/organization',
            "organization"=>0,
            "other"=>1
        ],
        [
            'text' => 'Reporting',
            'url'  => '#',
            'module' => 'AccountGroup',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'far fa-chart-bar',
            "organization"=>0,
            "other"=>1
        ],
        [
            'text' => 'Event List',
            'url'  => '#',
            'module' => 'AccountGroup',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'far fa-calendar-alt',
            "organization"=>0,
            "other"=>1
        ],
        [
            'text' => 'Event Manager',
            'url'  => 'admin/eventManager',
            'module' => 'Menu',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'far fa-calendar-alt',
            'permission-slug' => 'admin/eventManager',
            "organization"=>1,
            "other"=>0
        ],
        [
            'text' => 'Global Settings',
            'url'  => 'admin/globalSetting',
            'module' => 'Menu',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'far fa-sliders-h',
            'style' => 'font-weight:900',
            'permission-slug' => 'admin/globalSetting',
            "organization"=>1,
            "other"=>0
        ],
        [
            'text' => 'Users',
            'url'  => 'admin/users',
            'module' => 'Menu',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'fas fa-fw fa-user',
            'permission-slug' => 'admin/users',
            "organization"=>0,
            "other"=>1
        ],
        [
            'text' => 'Roles',
            'url'  => 'admin/roles',
            'module' => 'Menu',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'fas fa-user-tag',
            'style' => 'font-weight:900',
            'permission-slug' => 'admin/roles',
            "organization"=>0,
            "other"=>1
        ],
        /*[
            'text' => 'Global Settings',
            'url'  => 'admin/accountGroups',
            'module' => 'AccountGroup',
            'permission-slug' => 'read',
            'rbac' => true,
            'icon' => 'far fa-sliders-h',
            'style' => 'font-weight:900',
        ],*/

        /*[
            'text' => 'Master Data Entry',
            'icon' => 'fas fa-fw fa-bars',
            'module' => 'Menu',
            'permission-slug' => 'masterEntry',
            'rbac' => true,
            'submenu' => [
                [
                    'text' => 'Services',
                    'url'  => 'admin/services',
                    'module' => 'Service',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-network-wired'
                ],
                [
                    'text' => 'Addresses',
                    'url'  => 'admin/addresses',
                    'module' => 'Address',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-map-marker'
                ],
                [
                    'text' => 'Account Groups',
                    'url'  => 'admin/accountGroups',
                    'module' => 'AccountGroup',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-users'
                ],
                [
                    'text' => 'Account Types',
                    'url'  => 'admin/accountTypes',
                    'module' => 'AccountType',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-user-plus'
                ],
                [
                    'text' => 'Users',
                    'url'  => 'admin/users',
                    'module' => 'User',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-user',
                ],
                [
                    'text' => 'Roles',
                    'url'  => 'admin/roles',
                    'module' => 'Role',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-user-secret',
                ],
                [
                    'text' => 'Flag',
                    'url'  => 'admin/flag',
                    'module' => 'Flag',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-cog',
                ],
                [
                    'text' => 'Flag Types',
                    'url'  => 'admin/flagtype',
                    'module' => 'FlagType',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-cog',
                ],
            ],
        ],*/

        /*[
            'text' => 'Setup',
            'icon' => 'fas fa-fw fa-bars',
            'module' => 'Menu',
            'permission-slug' => 'setup',
            'rbac' => true,
            'submenu' => [

                [
                    'text' => 'Custom Fields',
                    'url'  => 'customfield',
                    'module' => 'CustomField',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-cog',
                ],
                [
                    'text' => 'Menus',
                    'url'  => 'menu',
                    'module' => 'Menu',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-bars',
                ],
                [
                    'text' => 'Cron Jobs',
                    'url'  => 'cronJob',
                    'module' => 'CronJob',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-clock',
                ],
                [
                    'text' => 'Configurations',
                    'url'  => 'admin/configuration',
                    'module' => 'Configuration',
                    'permission-slug' => 'read',
                    'rbac' => true,
                    'icon' => 'fas fa-fw fa-cog',
                ],
            ],
        ],*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        // JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    //'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                    'location' => '/js/datatables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    //'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                    'location' => '/js/datatables.bootstrap.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/css/datatables.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                    //'location' => '/css/datatables.bootstrap.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-corner-indicator.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        [
            'name' => 'sweetAlert',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/sweetalert.min.js',
                ],
            ],
        ],
        [
            'name' => 'customJs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/custom.js',
                ],
            ],
        ],
        [
            'name' => 'tableToExcel',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/tableToExcel.js',
                ],
            ],
        ],
        [
            'name' => 'SummerNote',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js',
                ],
            ],
        ],
    ],
];
