<?php
    /**
     *The Assets must have this format to be recognized by the framework
     *js key means javascript files
     *css key means cascading style sheets
     * the routes will be apply from public directory
     */
    return [
        #Js files
        'css' => [
            'camilion/app/css/style.css',
        ],
        'js' => [
            //---------Library load--------------
            'camilion/app/scripts/libs/angular.min.js',
            //----------Modules-----------------
            'camilion/app/scripts/libs/angular-route.min.js',
            //----------Services----------------
            'camilion/app/scripts/services/TableService.js',
            //----------Controllers--------------
            'camilion/app/scripts/controllers/main.js',
            'camilion/app/scripts/controllers/navigation.js',
            //-------------------App--------------
            'camilion/app/scripts/app.js',
        ],
    ];