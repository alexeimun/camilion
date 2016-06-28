<?php
    $prfix = strtolower($_POST['PREFIX']);
    $table_name = strtolower($_POST['TABLE']);
    $singular = strtolower($_POST['SINGULAR']);
    $table = $prfix . $table_name;

    $primary_key = $gen->Show($table);
    $Fields = $_POST['FIELDS'];
    $field_names = array_map(function ($field)
    {
        return $field['Field'];
    }, $Fields);

    echo "<?php\n";
?>

    Class <?= $table_name ?>_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function attributes()
        {
                return [
                <?php
                    $f = '';
                    foreach ($Fields as $field)
                    {
                        if($field['typeselect'] != 'Skip')
                        {
                        if($field['typeselect'] == 'Select')
                            $placeholder = '--- Selecione ' . substr($field['linkTable'], strlen($prfix), strlen($field['linkTable'])-strlen($prfix)) . ' ---';
                            else $placeholder = "Ingrese " . strtolower($gen->Beautify($field['Field']));

                            $f .= "\t\t\t\t\t'" . $field['Field'] . "' => [\n" .
                                "\t\t\t\t\t'label' => '" . $gen->Beautify($field['Field']) . "',\n" .
                                "\t\t\t\t\t'placeholder' => '$placeholder',\n" .
                                "\t\t\t\t\t'class' => '" . trim(($field['Null'] == 'NO' ? 'obligatorio' : '') . ' ' . $gen->fieldType($field['typeselect'])) . "',\n" .
                                "\t\t\t\t],\n";
                        }
                    }
                    echo ltrim($f, "\t");
                ?>
                 ];
        }
<?php if($primary_key !== false): ?>
        public function Trae<?= ucfirst($singular) ?>($Id<?= ucfirst($singular) ?>)
        {
            $<?= ucfirst($singular) ?> = $this->db->query("SELECT
            <?php
            $f = '';
            foreach ($field_names as $field)
            {
                $f.= "\t\t\t$table"."."."$field,\n";
            }
            echo rtrim($f,",\n");
            ?><?= "\n\n\t\t\t"?>FROM <?= $table?><?= "\n\n\t\t\t" ?>WHERE <?=$primary_key ?> = '$Id<?= ucfirst($singular) ?>'");
            return $<?= ucfirst($singular) ?>->num_rows() > 0 ? $<?= ucfirst($singular) ?>->result()[0] : null;
        }
<?php endif;  ?>

        public function Contar<?= ucfirst($table_name) ?>()
        {
            return $this->db->count_all_results('<?= $table ?>');
        }
<?php if($primary_key !== false): ?>

        public function Actualizar<?= ucfirst($singular) ?>()
        {
            $Id<?= ucfirst($singular) ?> = array_shift($_POST);
            $this->db->update('<?= $table ?>', $this->input->post(null, true), ['<?= $primary_key ?>' =>$Id<?= ucfirst($singular) ?>]);
        }
<?php endif;  ?>

        public function Insertar<?= ucfirst($singular) ?>()
        {
        <?php if(in_array('FECHA_REGISTRO', $field_names)): ?>
            $this->db->set('FECHA_REGISTRO', 'NOW()', false);
        <?php endif;  ?>
            $this->db->insert('<?= $table ?>', $this->input->post(null, true));
        }

        public function Trae<?= ucfirst($table_name) ?>()
        {
            return $this->db->query("SELECT
           <?php
               $f = '';
               foreach ($field_names as $field)
               {
                   $f .= "\t\t\t$table" . "." . "$field,\n";
               }
               echo rtrim($f, ",\n");
           ?><?= "\n\n\t\t\t"?>FROM <?= $table?>")->result('array');
        }
<?php foreach ($Fields as $field): ?>
    <?php if($field['typeselect'] == 'Select'): ?>
     <?php if($field['actionSelect'] == 'simple'): ?>

            public function Trae<?= ucfirst(substr($field['linkTable'], strlen($prfix), strlen($field['linkTable'])-strlen($prfix))) ?>DD()
            {
                return $this->db->query("SELECT
                <?php
                echo "\t\t\t" . $field['linkTable'] . "." . $field['textSelect'] . ",\n";
                echo "\t\t\t" . $field['linkTable'] . "." . $field['valueSelect'];

                ?><?= "\n\n\t\t\t"?>FROM <?= $field['linkTable'] ?>")->result('array');
            }

    <?php elseif($field['actionSelect'] == 'inner'): ?>
            
        public function Trae<?= ucfirst(substr($field['linkTable'], strlen($prfix), strlen($field['linkTable'])-strlen($prfix))) ?>DD()
        {
            return $this->db->query("SELECT
        <?php
        $f = '';
        foreach ($Fields as $fld)
        {
            $f .= "\t\t\t" . $table . "." . $fld['Field'] . ",\n";
        }
        $f .= "\t\t\t" . $field['linkTable'] . "." . $field['textSelect'];

        echo $f;
           ?><?= "\n\n\t\t\t"?>FROM <?= $table."\n"?>
            INNER JOIN <?= $field['linkTable'] . " ON " . $field['linkTable'] . "." . $field['valueSelect'] . " = " . $table . "." . $field['Field'] ?>")->result('array');
        }

    <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php if($primary_key !== false): ?>
    public function Eliminar<?= ucfirst($singular) ?>()
    {
    <?php if(in_array('ESTADO', $field_names)): ?>
        $this->db->update('<?= $table ?>', ['ESTADO' => 0], ['<?= $primary_key ?>' => $this->input->post('Id')]);
    <?php else:  ?>
        $this->db->delete('<?= $table ?>', ['<?= $primary_key ?>' => $this->input->post('Id')]);
    <?php endif; ?>
    }
<?php endif; ?>
    }