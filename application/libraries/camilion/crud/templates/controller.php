<?php
    /**
     * @var CI_Controller $this
     */
    $table_name = strtolower($_POST['TABLE']);
    $table_name_singular = strtolower($_POST['SINGULAR']);
    echo "<?php\n";
?>
    class <?= ucfirst($table_name) ?> extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();

            $this->rbca->is_authorized('*');
            $this->load->model(['<?= $table_name ?>_model',]);
        }

        public function index()
        {
            $this->load->view('<?= ucfirst($table_name) ?>/<?= ucfirst($table_name) ?>');
        }

        public function crear<?= $table_name_singular ?>()
        {
            if($this->input->is_ajax_request())
            {
                $this-><?= $table_name ?>_model->Insertar<?= ucfirst($table_name_singular) ?>();
            }
            else
            {
                $this->load->view('<?= ucfirst($table_name) ?>/Crear<?= ucfirst($table_name_singular) ?>');
            }
        }

        public function actualizar<?= $table_name_singular ?>($Id<?= ucfirst($table_name_singular) ?> = null)
        {
            if($this->input->is_ajax_request())
            {
                $this-><?= $table_name ?>_model->Actualizar<?= ucfirst($table_name_singular) ?>();
            }
            else if(is_numeric($Id<?= ucfirst($table_name_singular) ?>))
            {
                $Data = $this-><?= $table_name ?>_model->Trae<?= $table_name_singular ?>($Id<?= ucfirst($table_name_singular) ?>);

                if($Data != null)
                {
                    $this->load->view('<?= ucfirst($table_name) ?>/<?= 'Actualizar'.ucfirst($table_name_singular) ?>', ['info' => $Data]);
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

        public function ver<?= $table_name_singular ?>($Id<?= ucfirst($table_name_singular) ?>)
        {
             if(is_numeric($Id<?= ucfirst($table_name_singular) ?>))
            {
                $Data = $this-><?= $table_name ?>_model->Trae<?= $table_name_singular ?>($Id<?= ucfirst($table_name_singular) ?>);

                if($Data != null)
                {
                    $this->load->view('<?= ucfirst($table_name) ?>/<?= 'Ver'.ucfirst($table_name_singular) ?>', ['info' => $Data]);
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


        public function eliminar<?= $table_name_singular ?>()
        {
            if($this->input->is_ajax_request())
            {
                $this-><?= $table_name ?>_model->Eliminar<?= ucfirst($table_name_singular) ?>();
            }
            else
            {
                redirect(site_url(), 'refresh');
            }
        }
    }