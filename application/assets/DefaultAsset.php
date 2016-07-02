<?php
    /**
     *The Assets must have this format to be recognized by the framework
     *js key means javascript files
     *css key means cascading style sheets
     * the routes will be apply from public directory
     */
    return [
        #Css styles
        'css' => [
            'bootstrap/dist/css/bootstrap.min.css',
            'font-awesome/css/font-awesome.min.css',
            'AdminLTE/css/AdminLTE.min.css',
            'AdminLTE/css/skins/_all-skins.min.css',
            'css/styler.css',
        ],
        #Js files
        'js' => [
            'jquery/dist/jquery.min.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'AdminLTE/js/app.min.js',
            'AdminLTE/js/demo.js',
        ],
    ];