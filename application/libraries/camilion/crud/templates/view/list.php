<?php
    $prfix = strtolower($_POST['PREFIX']);
    $table_name = strtolower($_POST['TABLE']);
    $table_name_singular = strtolower($_POST['SINGULAR']);
    $table = $prfix . $table_name;
    $model = $table_name . "_model";
    $method = "Trae" . ucfirst(ucfirst($table_name));

    $primary_key = $gen->Show($table);
    $Fields = $_POST['FIELDS'];

    $fields = '';
    $columns = '';

    $c = 0;
    foreach ($Fields as $key => $field)
    {
        if($c == 4)
        {
            break;
        }
        if(!in_array($field['typeselect'], ['Skip', 'Select']))
        {
            $columns .= "'" . $gen->Beautify($field['Field']) . "',";
            $fields .= "'" . $field['Field'] . "',";
            $c++;
        }
    }

?>
<?= "<?php\n" ?>
    /**
    * @var $this CI_Loader
    */
    $this->Header(['assets' => ['datatables', 'dialogs']], '<?= $_POST['LAYOUT'] ?>');

        Component::Table(['columns' => [<?= $columns ?>],'tableTitle' => '<?= $gen->Beautify($table_name) ?>','tableName' => '<?= $table_name_singular ?>',
        'controller' => '<?= $table_name ?>','autoNumeric' => true, 'id' => '<?= $primary_key ?>','dataProvider' => $this-><?= $model ?>-><?= $method ?>(), 'actions' => 'duv',
        'fields' => [<?= $fields ?>]]);

     echo $this->Footer();
     echo Component::tableScript("<?= $table_name."/Eliminar".ucfirst($table_name_singular) ?>");
<?= '?>' ?>