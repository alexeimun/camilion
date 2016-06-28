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
            'js/DropDown/docsupport/prism.css',
            'js/DropDown/chosen.css',
        ],
        #Js files
        'js' => [
            'js/DropDown/chosen.jquery.js',
            'js/DropDown/docsupport/prism.js',
            'js/DropDown/docsupport/combo.js',
        ],
    ];