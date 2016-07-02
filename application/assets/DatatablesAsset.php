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
            'datatables.net-bs/css/dataTables.bootstrap.min.css',

        ],
        #Js files
        'js' => [
            'datatables.net/js/jquery.dataTables.min.js',
            'datatables.net-bs/js/dataTables.bootstrap.min.js',
        ],
    ];