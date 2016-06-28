<?php
    /**
     * @var $this CI_Loader
     */
    $this->Header(['assets' => ['datatables', 'dialogs']], 'main');

    Component::Table(['columns' => ['Id agencia', 'Id ciudad', 'Nombre agencia', 'Correo agencia',], 'tableTitle' => 'Agencias', 'tableName' => 'agencia',
        'controller' => 'agencias', 'autoNumeric' => true, 'id' => 'ID_AGENCIA', 'dataProvider' => $this->agencias_model->TraeAgencias(), 'actions' => 'duv',
        'fields' => ['ID_AGENCIA', 'ID_CIUDAD', 'NOMBRE_AGENCIA', 'CORREO_AGENCIA',]]);

    echo $this->Footer();
    echo Component::tableScript("agencias/EliminarAgencia");
?>