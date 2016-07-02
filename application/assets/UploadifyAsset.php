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
            'uploadify/uploadify.css',
        ],
        #Js files
        'js' => [
            'uploadify/jquery.uploadify.min.js',
        ],
    ];