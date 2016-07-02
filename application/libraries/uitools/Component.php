<?php

    class Component
    {
        public static function Sidebar($params)
        {
            extract($params['options']);
            /**
             * @var string $header
             * @var string $img
             */
            ##Header######################################################################
            $sidebar = "<aside class='main-sidebar'>
                <!-- sidebar: style can be found in sidebar.less -->
                <section class='sidebar'>
                    <!-- Sidebar user panel -->
                    <div class='user-panel'>
                        <div class='pull-left'>";
            if(isset($img))
            {
                $img['url'] = isset($img['url']) ? "onclick=" . "\"" . "location.href='" . site_url($img['url']) . "'" . "\"" : '';
                $sidebar .= "<img  src='" . base_url() . '/' . $img['path'] . "' " . $img['url'] . " draggable='false' style='cursor: pointer' class='img-responsive'/>";
            }
            $sidebar .= "</div>
                                    </div>
                                    <!-- sidebar menu: : style can be found in sidebar.less -->
                                    <ul class='sidebar-menu'>
                                        <li class='header'><span style='color:#6b6b6b;'>$header</span></li>";
            ##Items##################Items################################################################################################################################
            $sidebar .= self::renderItems($params['items'], false);
            return $sidebar . "</ul></section></aside>";
        }

        private static function renderItems($items, $auto)
        {
            $sidebar = '';
            foreach ($items as $item)
            {
                if(isset($item['visible']) && !$item['visible'])
                {
                    continue;
                }
                $item['options']['target'] = isset($item['options']['target']) ? 'target="' . $item['options']['target'] . '"' : '';
                $item['options']['icon'] = isset($item['options']['icon']) ? $item['options']['icon'] : '';

                if(isset($item['items']))
                {
                    $sidebar .= "<li class='treeview'>
                                    <a href='" . (isset($item['url']) ? site_url($item['url']) : '#') . "'>
                                    <i class='" . $item['options']['icon'] . "'></i> <span>&nbsp;&nbsp;" . $item['label'] . "</span>
                                        <i class='fa fa-angle-left pull-right'></i>
                                    </a>
                                    <ul class='treeview-menu'><li>" . static::renderItems($item['items'], true) . "</li></ul></li>";
                }
                else
                {
                    if($auto)
                    {
                        $sidebar .= "<li><a href='" . (isset($item['url']) ? site_url($item['url']) : '#') . "' " . $item['options']['target'] . "'>
                        <i class='fa " . $item['options']['icon'] . "'></i> " . $item['label'] . "</a></li>";
                    }
                    else
                    {
                        $sidebar .= "<li class='treeview'>
                        <a href='" . (isset($item['url']) ? site_url($item['url']) : '#') . "' " . $item['options']['target'] . ">
                        <i class='" . $item['options']['icon'] . "'></i> <span>&nbsp;&nbsp;" . $item['label'] . "</span>
                        </a></li>";
                    }
                }
            }
            return $sidebar;
        }

        public static function Breadcrumb($params)
        {
            $breadcrum = "<ol class='breadcrumb'>";
            foreach ($params as $key => $item)
            {
                if($key + 1 == count($params))
                {
                    $breadcrum .= '<li class="active">' . $item['text'] . '</li>';
                }
                else
                {
                    $breadcrum .= "<li><a href=" . site_url($item['url']) . "><i class='" . ($key == 0 ? 'fa fa-dashboard' : '') . "'></i>" . $item['text'] . "</a></li>";
                }
            }
            return $breadcrum . '</ol>';
        }

        public static function Field($model, $name, $info = null, $type = 'input')
        {
            $attr = $model->attributes();

            if(array_key_exists($name, $attr))
            {
                $attr = $attr[$name];

                switch ($type)
                {
                    case 'input':
                        echo form_input(['placeholder' => isset($info->visible) ? '' : $attr['placeholder'], 'class' => $attr['class'], 'readonly' => isset($info->visible), 'name' => $name, 'label' => ['text' => $attr['label']]],
                            !is_null($info) ? $info->$name : '');
                        break;
                    case 'textarea':
                        echo form_textarea(['placeholder' => isset($info->visible) ? '' : $attr['placeholder'], 'class' => $attr['class'], 'readonly' => isset($info->visible), 'name' => $name, 'label' => ['text' => $attr['label']]],
                            !is_null($info) ? $info->$name : '');
                        break;
                }
            }
            else
            {
                echo "<h3 style='color: lightcoral'>(!) Invalid input name $name</h3>";
            }
        }

        public static function Dropdown(array $params)
        {
            $attr = $params['model']->attributes()[$params['Field']];
            unset($params['model']);
            $params['placeholder'] = $attr['placeholder'];

            echo select_input(['select' => self::_dropdown($params), 'text' => $attr['label']]);
        }

        /**
         * @param array $params
         * @param bool $buffer echoes buffer output if it is true
         * @return string
         */
        public static function Table(array $params, $buffer = true)
        {
            extract($params);
            /**
             * @var array $columns
             * @var array $fields
             * @var array $dataProvider
             * @var string $actions
             * @var string $align
             * @var string $tableName
             * @var bool $autoNumeric
             * @var string $id
             * @var string $controller
             * @var string $tableTitle
             * @var integer $limitCell
             */

            $limitCell = isset($limitCell) ? $limitCell : 40;
            $align = isset($align) ? $align : 'left';
            $actions = isset($actions) ? $actions : '';
            $controller = isset($controller) ? $controller : '';
            $autoNumeric = isset($autoNumeric) ? $autoNumeric : false;

            $view = strrchr($actions, 'v');
            $update = strrchr($actions, 'u');
            $delete = strrchr($actions, 'd');
            $print = strrchr($actions, 'p');
            $check = strrchr($actions, 'c');
            $radio = strrchr($actions, 'r');

            $action = $delete || $update || $view || $print || $check || $radio;
            $table = "<section class='content'>
                <div class='row'>
                    <div class='col-xs-12'>
                        <div class='box'>
                            <div class='box-header'>
                                <h3 style='text-align: center;color: #3D8EBC;'><span style='font-size: 25pt;'
                                                        class='fa fa-table'></span>&nbsp;$tableTitle</h3></div><div class='box-body'>
             <table id='tabla' style='text-align:$align' data-name= '$tableName' class='table table-bordered table-striped'><thead><tr>";
            if($autoNumeric)
            {
                $c = 0;
                $table .= '<th style="width: 20px;">#</th>';
            }
            foreach ($columns as $columnName => $value)
            {
                if(!is_numeric($columnName))
                {
                    $table .= '<th style="' . (isset($value['style']) ? $value['style'] : '') . ';text-align:' . $align . '">' . $columnName . '</th>';
                }
                else
                {
                    $table .= '<th style="text-align:' . $align . '">' . $value . '</th>';
                }
            }
            if($action)
            {
                $table .= '<th>Acciones</th>';
            }
            $table .= '</tr></thead><tbody>';

            foreach ($dataProvider as $data)
            {
                $table .= '<tr>';
                if($autoNumeric)
                {
                    $table .= '<td>' . (++$c) . '</td>';
                }
                foreach ($fields as $key => $value)
                {
                    if(!is_numeric($key))
                    {
                        if(is_array($value))
                        {
                            switch ($value['type'])
                            {
                                case 'img':
                                    #Represents an image
                                    $table .= '<td><img class="img-circle" style="height: 25px;width: 25px;" src="' . $value['path'] . '/' . $data[$key] . '"></td>';
                                    break;
                            }
                        }
                        else
                        {
                            switch ($value)
                            {
                                #Represents a moment helper
                                case 'moment':
                                    $table .= '<td>' . Momento($data[$key]) . '</td>';
                                    break;
                                #Represents a date with the helper
                                case 'date':
                                    $table .= '<td>' . date_format(new DateTime($data[$key]), 'd/m/Y') . '</td>';
                                    break;
                                #Represents a number format
                                case 'numeric':
                                    $table .= '<td>' . number_format($data[$key], 0, '', ',') . '</td>';
                                    break;
                            }
                        }
                    }
                    else
                    {
                        $table .= '<td>' . ($data[$value] = strlen($data[$value]) > $limitCell ? substr($data[$value], 0, $limitCell) . '...' : $data[$value]) . '</td>';
                    }
                }

                if($action)
                {
                    $table .= '<td>';

                    $kview = $controller . '/ver' . $tableName;
                    $kupdate = $controller . '/actualizar' . $tableName;
                    $kprint = $controller . '/imprimir' . $tableName;
                    $keys = '';

                    if(is_array($id))
                    {
                        foreach ($id as $ikey => $ids)
                        {
                            if(!is_numeric($ids))
                            {
                                $keys .= '/' . $data[$ids];
                            }
                            else
                            {
                                $keys .= '/' . $ids;
                            }
                        }
                    }
                    else
                    {
                        $keys .= '/' . $data[$id];
                    }
                    //var_dump($keys);exit;

                    if($view)
                    {
                        $table .= '<a href="' . site_url($kview . $keys) . '" style="font-size:20pt;color: #29a84b" id="viewid" class="fa fa-eye" target="_blank" data-toggle="tooltip" title="Ver m&aacute;s..."></a>&nbsp;&nbsp;';
                    }
                    if($print)
                    {
                        $table .= '<a href="' . site_url($kprint . $keys) . '" style="font-size:20pt;color: black" target="_blank" class="fa fa-print" data-toggle="tooltip" title="Imprimir"></a>&nbsp;&nbsp;';
                    }
                    if($update)
                    {
                        $table .= '<a href="' . site_url($kupdate . $keys) . '"  target="_blank" style="font-size:20pt;color:  #0065c3" class="fa fa-pencil" data-toggle="tooltip" title="Editar"></a>&nbsp;&nbsp;';
                    }
                    if($delete)
                    {
                        $table .= " <a data-id='$data[$id]' style='color:#e54040;font-size:20pt;' class='fa fa-trash-o' data-toggle='tooltip' title='Eliminar'></a>";
                    }
                    ###Check###
                    if($check)
                    {
                        $table .= "<input type='checkbox' value='" . $data[$id] . "' checked>";
                    }
                    ###Radio###
                    if($radio)
                    {
                        $table .= "<input type='radio' name='RADIO' value='" . $data[$id] . "' checked>";
                    }
                    $table .= '</td>';
                }
                $table .= '</tr>';
            }
            $table .= "</tbody></table></div></div></div></div></section>";

            if(!$buffer)
            {
                return $table;
            }
            echo $table;
        }

        private static function _dropdown(array $params)
        {
            extract($params);
            /**
             * @var array $dataProvider
             * @var string $name
             * @var string $placeholder
             * @var string $width
             * @var string $fields
             * @var string $index
             * @var bool $readonly
             * @var bool $simple
             */

            $disable = '';
            $size = isset($width) ? $width : '100%';
            if(isset($readonly))
            {
                $disable = "disabled";
                $size = '100%';
            }
            $dropdown = "<select  name='$name' class='form-control' $disable style='width:" . $size . ";'>";
            $dropdown .= "<option style='text-align: center;' value='0'>$placeholder</option>";
            $name = preg_replace('/\[|\]/', '', $name);
            foreach ($dataProvider as $data)
            {
                if(isset($index) && $index == $data[$name])
                {
                    $dropdown .= "<option value='$data[$name]' selected>";
                }
                else
                {
                    $dropdown .= "<option value='$data[$name]'>";
                }

                foreach ($fields as $key => $value)
                {
                    if(!is_numeric($key))
                    {
                        $dropdown .= $value;
                    }
                    else
                    {
                        $dropdown .= $data[$value];
                    }
                }
                $dropdown .= '</option>';
            }
            $dropdown .= '</select>';
            return $dropdown;
        }

        public static function Question($params = [])
        {
            /**
             * @var string $question
             * @var array $options
             * @var array $num
             * @var array $name
             * @var bool $opcional
             * @var bool $checked
             * @var bool $slider
             */
            extract($params);
            $opcional = isset($opcional) && $opcional ? 'opcional' : '';
            $checked = isset($checked) ? $checked = 'checked' : '';
            $num = isset($num) ? $num . '.' : '';

            $template = "<div id='st" . $name . "'><table class='statement'>
            <div class='font1' style='text-align: left;'>$num <span >$question</span>";

            $template .= '</div>';
            $opt = 0;
            $literals = ['a', 'b', 'c', 'd', 'e', 'f'];
            foreach ($options as $option)
            {
                $template .= "<tr>
                <td><input type='radio' class='$opcional' value='$literals[$opt]' name='R$name' $checked> </td>
                <td class='option font2' style='text-align: justify;'>" . $literals[$opt] . ")  $option </td>
            </tr>";
                $opt++;
            }
            $template .= "</table></div><br>";
            if(isset($slider) && $slider)
            {
                $template .= '<div class="row margin">
                <div class="col-sm-6">
            <input id="range' . $name . '" type="text" name="range[]" >
        </div></div>';
            }
            return $template;
        }

        public static function Alert($params)
        {
            extract($params);

            /**
             * @var $title
             * @var $text
             * @var $icon
             * @var $type
             */

            $type = isset($type) ? $type : 'success';
            $text = isset($text) ? $text : '';
            $icon = isset($icon) ? $icon : 'ion-checkmark';
            return "<div class='alert alert-$type'>
              	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              	<span class='$icon' style='font-size: 20pt'> </span><strong>$title</strong> $text
              </div>";
        }

        public static function Beginbox($params)
        {
            extract($params);

            /**
             * @var $title
             * @var $text
             * @var $type
             */
            return "<div class='row'>
                        <div class='col-lg-9'>
                            <div class='box box-solid bg-green-gradient'>
                                <div class='box-header'>
                                    <i class='fa fa-th'></i>
                                    <h3 class='box-title'>$title</h3>
                                    <div class='box-tools pull-right'>
                                        <button class='btn bg-green btn-sm' data-widget='collapse'><i class='fa fa-minus'></i></button>
                                        <button class='btn bg-green btn-sm' data-widget='remove'><i class='fa fa-times'></i></button>
                                    </div>
                                </div>
                                <div class='box-body border-radius-none'>";
        }

        public static function Endbox()
        {
            return " </div><!-- /.box-body -->
                                <div class='box-footer no-border'>
                                </div><!-- /.box-footer -->
                            </div><!-- /.box -->
                        </div>
                    </div>";
        }

        public static function tableScript($url)
        {
            return "<script type='text/javascript'>
            $(function () {
                $('#tabla').dataTable({
                    'language': 
                        {
                            'sProcessing':     'Procesando...',
                            'sLengthMenu':     'Mostrar _MENU_ registros',
                            'sZeroRecords':    'No se encontraron resultados',
                            'sEmptyTable':     'Ningún dato disponible en esta tabla',
                            'sInfo':           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                            'sInfoEmpty':      'Mostrando registros del 0 al 0 de un total de 0 registros',
                            'sInfoFiltered':   '(filtrado de un total de _MAX_ registros)',
                            'sInfoPostFix':    '',
                            'sSearch':         'Buscar:',
                            'sUrl':            '',
                            'sInfoThousands':  ',',
                            'sLoadingRecords': 'Cargando...',
                            'oPaginate': {
                            'sFirst':    'Primero',
                            'sLast':     'Útimo',
                            'sNext':     'Siguiente',
                            'sPrevious': 'Anterior'
                            },
                            'oAria': {
                            'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                            'sSortDescending': ': Activar para ordenar la columna de manera descendente'
                            }
                            }
                });

                $('body').on('click', 'a[data-id]', function () {
                    Alert($(this + '[data-id]').data('id'), '" . site_url($url) . "');
                });

        function Alert(id, url) {
            BootstrapDialog.show({
                title: '<span class=\"ion ion-android-delete\" style=\"font-size: 20pt;font-weight: bold; color: white;\"></span>&nbsp;&nbsp;&nbsp; <span  style=\"font-size: 18pt;\">Atención!</span>',
                type: BootstrapDialog.TYPE_DANGER,
                draggable: true,
                message: '¿Está seguro que desea eliminar este registro?',
                buttons: [{
                label: 'Aceptar',
                    cssClass: 'btn-danger',
                    action: function () {
                    $.post(url, {Id: id}, function () {
                        location.href = '';
                    });
                    }
                },
                    {
                        label: 'Cancelar',
                        action: function (dialogItself) {
                        dialogItself.close();
                    }
                    }]
            });
        }
    });
    </script>";
        }
    }