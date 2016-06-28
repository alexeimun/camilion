<?php
/**
* @var $this CI_Loader
*/
$this->Header(['assets' => ['jvalidator', 'dialogs', 'spin']], 'main');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <?= page_title([ "class" => "ios ion-person", "text" => Camelize(__FILE__)]) ?>
    <?= Component::Breadcrumb([['url' => '', 'text' => 'Inicio'], ['url' => 'agencias', 'text' => 'Lista agencias'], ['text' => 'Actualizar ']]) ?>
</section>
<!-- Main content -->
<div class="container">
    <?=form_open('', ['class' => 'form-horizontal col-md-8', 'style' => 'margin-left: 15%']) ?>
    <hr style="border: 1px solid #3D8EBC;"/>
    <?= $this->view("Agencias/Form", ["view" => "update", "info" => $info], true) ?>
<?=  form_close() ?>
</div>
<?= $this->Footer() ?>

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
            url: '<?= site_url('agencias/actualizar') ?>',
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