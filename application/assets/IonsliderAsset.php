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
            'plugins/ion.rangeSlider-2/css/ion.rangeSlider.css',
            'plugins/ion.rangeSlider-2/css/ion.rangeSlider.skinHTML5.css',
        ],
        #Js files
        'js' => [
            'plugins/ion.rangeSlider-2/js/ion.rangeSlider.min.js',
        ],
    ];