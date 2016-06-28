<?php
    $table_name = strtolower($_POST['TABLE']);
    $table_name_singular = strtolower($_POST['SINGULAR']);
?>
<?= "<?php\n" ?>
/**
* @var $this CI_Loader
*/
$this->Header(['assets' => ['jvalidator', 'dialogs', 'spin']], '<?= $_POST['LAYOUT'] ?>');
<?= "?>\n" ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <?= '<?= page_title([ "class" => "ios ion-person", "text" => Camelize(__FILE__)]) ?>' . "\n" ?>
    <?= "<?= Component::Breadcrumb([['url' => '', 'text' => 'Inicio'], ['url' => '$table_name', 'text' => 'Lista $table_name'], ['text' => 'Actualizar $table_name_singular']]) ?>\n" ?>
</section>
<!-- Main content -->
<div class="container">
    <?= "<?=form_open('', ['class' => 'form-horizontal col-md-8', 'style' => 'margin-left: 15%']) ?>\n" ?>
    <hr style="border: 1px solid #3D8EBC;"/>
    <?= '<?= $this->view("' . ucfirst($table_name) . '/Form' . ucfirst($table_name_singular) . '", ["view" => "update", "info" => $info], true) ?>' . "\n" ?>
<?= '<?=  form_close() ?>' . "\n" ?>
</div>
<?= '<?= $this->Footer() ?>' . "\n" ?>

<script>

    $('form').jValidate();

    (new Spinner({
        lines: 10, width: 4,
        radius: 6, color: '#000', speed: 1, length: 15, top: '10%'
    })).spin(document.getElementById("spin"));

    function Save()
    {
        $.ajax({
            type: 'post',
            url: '<?="<?= site_url('" . $table_name . "/actualizar" . ucfirst($table_name_singular) . "') ?>" ?>',
            data: $('form').serialize(),
            beforeSend: function ()
            {
                $('body').addClass('Wait');
                $('body,html').animate({scrollTop: 0}, 200);
                $('#spin').show();
            },
            success: function ()
            {
                $('body').removeClass('Wait');
                Alerta('Registro actualizado correctamente.');
                $('#spin').hide();
            }
        });
    }
</script>