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
            'plugins/iCheck/flat/green.css',
            'plugins/iCheck/square/green.css',
        ],
        #Js files
        'js' => [
            'plugins/iCheck/icheck.js',
        ],
    ];