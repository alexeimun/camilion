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
            'plugins/datatables/dataTables.bootstrap.css',

        ],
        #Js files
        'js' => [
            'plugins/datatables/jquery.dataTables.js',
            'plugins/datatables/dataTables.bootstrap.js',
        ],
    ];