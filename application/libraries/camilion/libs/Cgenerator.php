<?php
    /**
     * @property  CI_DB_query_builder $CI
     */
    class Cgenerator
    {
        public $CI;

        public function __construct()
        {
            $this->CI =& get_instance();
        }

        public function ShowPrimaryKey($table)
        {
            $show = $this->CI->db->query("SHOW  KEYS  FROM " . $table);
            return $show->num_rows() ? $show->result()[0]->Column_name : false;
        }

        public function Describe($table, $datatype = 'object')
        {
            return $this->CI->db->query("DESCRIBE " . $table)->result($datatype);
        }

        public function Tables()
        {
            $query = $this->CI->db->query("SHOW TABLES FROM " . $this->CI->db->database)->result('array');

            foreach ($query as $table)
            {
                $tables[] = $table['Tables_in_' . $this->CI->db->database];
            }
            return json_encode($tables);
        }

        public function Beautify($str)
        {
            return str_replace('_', ' ', ucfirst(strtolower($str)));
        }

        public function fieldType($type)
        {
            switch ($type)
            {
                case 'Price':
                    $type = 'dinero';
                    break;
                case 'Email':
                    $type = 'correo';
                    break;
                case 'Date':
                    $type = 'fecha';
                    break;
                case 'Phone':
                    $type = 'numero telefono';
                    break;
                case 'Number':
                    $type = 'numero';
                    break;
                default:
                    $type = '';
                    break;
            }
            return $type;
        }
    }