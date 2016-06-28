<?php

    Class agencias_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function attributes()
        {
            return [
                'ID_AGENCIA' => [
                    'label' => 'Id agencia',
                    'placeholder' => 'Ingrese id agencia',
                    'class' => 'obligatorio',
                ],
                'ID_CIUDAD' => [
                    'label' => 'Id ciudad',
                    'placeholder' => 'Ingrese id ciudad',
                    'class' => '',
                ],
                'NOMBRE_AGENCIA' => [
                    'label' => 'Nombre agencia',
                    'placeholder' => 'Ingrese nombre agencia',
                    'class' => '',
                ],
                'CORREO_AGENCIA' => [
                    'label' => 'Correo agencia',
                    'placeholder' => 'Ingrese correo agencia',
                    'class' => '',
                ],
                'DIRECCION' => [
                    'label' => 'Direccion',
                    'placeholder' => 'Ingrese direccion',
                    'class' => '',
                ],
                'TELEFONO1' => [
                    'label' => 'Telefono1',
                    'placeholder' => 'Ingrese telefono1',
                    'class' => 'dinero',
                ],
                'TELEFONO2' => [
                    'label' => 'Telefono2',
                    'placeholder' => 'Ingrese telefono2',
                    'class' => 'dinero',
                ],
                'FAX' => [
                    'label' => 'Fax',
                    'placeholder' => 'Ingrese fax',
                    'class' => '',
                ],
                'PAGINA_WEB' => [
                    'label' => 'Pagina web',
                    'placeholder' => 'Ingrese pagina web',
                    'class' => '',
                ],
            ];
        }

        public function TraeAgencia($IdAgencia)
        {
            $Agencia = $this->db->query("SELECT
            			t_agencias.ID_AGENCIA,
			t_agencias.ID_ASESOR,
			t_agencias.ID_CIUDAD,
			t_agencias.NOMBRE_AGENCIA,
			t_agencias.CORREO_AGENCIA,
			t_agencias.DIRECCION,
			t_agencias.TELEFONO1,
			t_agencias.TELEFONO2,
			t_agencias.FAX,
			t_agencias.PAGINA_WEB,
			t_agencias.FECHA_REGISTRO

			FROM t_agencias

			WHERE ID_AGENCIA = '$IdAgencia'");
            return $Agencia->num_rows() > 0 ? $Agencia->result()[0] : null;
        }

        public function ContarAgencias()
        {
            return $this->db->count_all_results('t_agencias');
        }

        public function ActualizarAgencia()
        {
            $IdAgencia = array_shift($_POST);
            $this->db->update('t_agencias', $this->input->post(null, true), ['ID_AGENCIA' => $IdAgencia]);
        }

        public function InsertarAgencia()
        {
            $this->db->set('FECHA_REGISTRO', 'NOW()', false);
            $this->db->insert('t_agencias', $this->input->post(null, true));
        }

        public function TraeAgencias()
        {
            return $this->db->query("SELECT
           			t_agencias.ID_AGENCIA,
			t_agencias.ID_ASESOR,
			t_agencias.ID_CIUDAD,
			t_agencias.NOMBRE_AGENCIA,
			t_agencias.CORREO_AGENCIA,
			t_agencias.DIRECCION,
			t_agencias.TELEFONO1,
			t_agencias.TELEFONO2,
			t_agencias.FAX,
			t_agencias.PAGINA_WEB,
			t_agencias.FECHA_REGISTRO

			FROM t_agencias")->result('array');
        }

        public function EliminarAgencia()
        {
            $this->db->delete('t_agencias', ['ID_AGENCIA' => $this->input->post('Id')]);
        }
    }