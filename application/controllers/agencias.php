<?php
    class Agencias extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();

            $this->rbca->is_authorized('*');
            $this->load->model(['agencias_model',]);
        }

        public function index()
        {
            $this->load->view('Agencias/Agencias');
        }

        public function crearagencia()
        {
            if($this->input->is_ajax_request())
            {
                $this->agencias_model->InsertarAgencia();
            }
            else
            {
                $this->load->view('Agencias/CrearAgencia');
            }
        }

        public function actualizaragencia($IdAgencia = null)
        {
            if($this->input->is_ajax_request())
            {
                $this->agencias_model->ActualizarAgencia();
            }
            else if(is_numeric($IdAgencia))
            {
                $Data = $this->agencias_model->Traeagencia($IdAgencia);

                if($Data != null)
                {
                    $this->load->view('Agencias/ActualizarAgencia', ['info' => $Data]);
                }
                else
                {
                    redirect(site_url(), 'refresh');
                }
            }
            else
            {
                redirect(site_url(), 'refresh');
            }
        }

        public function veragencia($IdAgencia)
        {
             if(is_numeric($IdAgencia))
            {
                $Data = $this->agencias_model->Traeagencia($IdAgencia);

                if($Data != null)
                {
                    $this->load->view('Agencias/VerAgencia', ['info' => $Data]);
                }
                else
                {
                    redirect(site_url(), 'refresh');
                }
            }
            else
            {
                redirect(site_url(), 'refresh');
            }
        }


        public function eliminaragencia()
        {
            if($this->input->is_ajax_request())
            {
                $this->agencias_model->EliminarAgencia();
            }
            else
            {
                redirect(site_url(), 'refresh');
            }
        }
    }