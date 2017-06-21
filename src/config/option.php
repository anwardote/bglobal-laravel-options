<?php

return [

    'keys' => [
        'header' => 'Header',
        'footer' => 'Footer',
        'contact_mail' => 'Contact Mail',
        'admin_mail' => 'Admin Mail',
    ],

//    For header and footer
    'layout' => [
        '1' => 'Single Column',
        '2' => 'Two Columns',
        '3' => 'Three Columns',
        '4' => 'Four Columns',
    ],


//    For the First time settings
    'header_footer_option'=>[
        'class'=>'_section_',
        'base_class'=>'col-md',
        'level'=>'Column',
    ],

    'option_level'=>[
        'level' =>'Global Option',
        'title' => 'Admin area'
    ],

    // Change this class if you wish to extend OptionsController
    'option_controller_class' => 'Bglobal\Options\Controllers\OptionsController',
    // Change this class if you wish to extend the Option model
    'option_model_class'=> 'Bglobal\Options\Models\Option',

    'base_layout' => 'laravel-authentication-acl::admin.layouts.base-2cols',

    /*route settings*/
    'route_prefix'=>'admin/options',
    'middleware' => ['web', 'admin_logged'],
];
