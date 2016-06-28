<?php
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

                                Component::Field($this->agencias_model, 'ID_CIUDAD', $info);
                            Component::Field($this->agencias_model, 'NOMBRE_AGENCIA', $info);
                            Component::Field($this->agencias_model, 'CORREO_AGENCIA', $info);
                            Component::Field($this->agencias_model, 'DIRECCION', $info);
                            Component::Field($this->agencias_model, 'TELEFONO1', $info);
                            Component::Field($this->agencias_model, 'TELEFONO2', $info);
                            Component::Field($this->agencias_model, 'FAX', $info);
                            Component::Field($this->agencias_model, 'PAGINA_WEB', $info, 'textarea');
        
if($view != "view"){
     echo input_submit(["class" => "col-lg-offset-5 col-lg-10", "text" => is_null($info) ? "Guardar" : "Actualizar"]); 
     echo call_spin_div();
}
echo br(2);
?>