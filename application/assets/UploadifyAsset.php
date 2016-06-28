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
            'plugins/uploadify/uploadify.css',
        ],
        #Js files
        'js' => [
            'plugins/uploadify/jquery.uploadify.min.js',
        ],
    ];