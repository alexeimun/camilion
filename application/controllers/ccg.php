<?php

    class ccg extends CI_Controller
    {
        private $gen;

        function __construct()
        {
            parent::__construct();
            $this->load->library(['camilion/Camilion', 'camilion/libs/Cgenerator']);
            $this->gen = new Cgenerator();
        }

        public function getfields($table)
        {
            echo json_encode($this->gen->Describe($table, 'array'));
        }

        public function getalltablefields()
        {
            $allfields = [];
            $tables = json_decode($this->gen->Tables());
            foreach ($tables as $table)
            {
                $allfields[$table] = $this->gen->Describe($table, 'array');
            }
            echo json_encode($allfields);
        }

        public function gettables()
        {
            echo $this->gen->Tables();
        }

        public function index()
        {
            if(!empty($_POST))
            {
                (new Camilion())->Generate();
            }
            else
            {
                $this->load->view('camilion/camilion');
            }
        }
    }