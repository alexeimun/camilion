<?php
    require 'libs/Cgenerator.php';

    class Camilion
    {
        private $CI;

        public function __construct()
        {
            $this->CI =& get_instance();
        }

        public function Generate()
        {
            $table = strtolower($_POST['TABLE']);
            $singular = strtolower($_POST['SINGULAR']);
            ##Controller
            $this->createFile(APPPATH . "/controllers/$table.php", 'controller');
            ##Model
            $this->createFile(APPPATH . "/models/$table" . "_model.php", 'model');
            ##Listview folder
            $viewfolder = APPPATH . '/views/' . ucfirst($table);
            @mkdir($viewfolder);
            chmod($viewfolder, 0777);
            $this->createFile($viewfolder . "/" . ucfirst($table) . ".php", 'view/list');
            ##_form
            $this->createFile($viewfolder . "/Form" . ucfirst($singular) . ".php", 'view/_form');
            ##Create
            $this->createFile($viewfolder . "/Crear" . ucfirst($singular) . ".php", 'view/create');
            ##Update
            $this->createFile($viewfolder . "/Actualizar" . ucfirst($singular) . ".php", 'view/update');
            ##View
            $this->createFile($viewfolder . "/Ver" . ucfirst($singular) . ".php", 'view/view');
            ##CI_phpStorm
            $this->createFile(APPPATH."../CI_phpStorm.php", 'CI_phpStorm');
        }

        private function createFile($filename, $template)
        {
            if(file_exists($filename))
            {
                unlink($filename);
            }
            fwrite(fopen($filename, "w"), $this->renderTemplate($template));
            chmod($filename, 0777);
        }

        private function renderTemplate($template)
        {
            ob_start();
            ob_implicit_flush(false);
            //$ci = $this->CI;
            $gen = new Cgenerator();

            require "crud/templates/$template.php";
            return ob_get_clean();
        }
    }