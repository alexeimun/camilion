<?php
    $prfix = strtolower($_POST['PREFIX']);
    $table_name = strtolower($_POST['TABLE']);
    $table_name_singular = strtolower($_POST['SINGULAR']);
    $table = $prfix . $table_name;
    $Fields = $_POST['FIELDS'];

    function WhatType($type)
    {
        $length = preg_replace('/[a-z]+|\(|\)/', '', $type);
        $type = preg_replace('/[0-9]+|\(|\)/', '', $type);

        if($length >= 150 && $type == 'varchar')
        {
            return ", '" . 'textarea' . "'";
        }
        else
        {
            return '';
        }
    }

?>
<?= "<?php\n" ?>
    /**
    * @var $this CI_Loader
    */
    if(isset($info))
    {
        if($view == 'view') $info->visible =  false;
    }
    else
    {
        $info = null;
    }

<?php foreach ($Fields as $field) : ?>
    <?php if(!in_array($field['typeselect'], ['Skip'])): ?>
    <?php $model = '$this->' . $table_name . '_model' ?>
    <?php if($field['typeselect'] == 'Select'): ?>
        <?php $provider = '$this->' .  $table_name . '_model->Trae' . ucfirst(substr($field['linkTable'], strlen($prfix), strlen($field['linkTable']) - strlen($prfix))) . 'DD()' ?>
            Component::Dropdown(['Field' => '<?= $field['Field'] ?>', 'dataProvider' => <?= $provider ?>, 'model' => <?= $model ?>, 'name' => '<?= $field['Field'] ?>', 'fields' => ['<?= $field['textSelect'] ?>']]);<?= "\n" ?>
        <?php else: ?>
            Component::Field(<?= $model ?>, '<?= $field['Field'] ?>', $info<?= $field['typeselect'] == 'Textarea'? ", 'textarea'":'' ?>);<?= "\n" ?>
    <?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>

<?= 'if($view != "view"){'."\n" ?>
     echo input_submit(["class" => "col-lg-offset-5 col-lg-10", "text" => is_null($info) ? "Guardar" : "Actualizar"]); <?= "\n"?>
     echo call_spin_div();<?= "\n" ?>
<?= "}\n" ?>
echo br(2);
<?= "?>" ?>
