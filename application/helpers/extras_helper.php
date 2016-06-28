<?php

    function Camelize($string)
    {
        $string = pathinfo($string)['filename'];
        $new = '';
        for ($i = 0; $i < strlen($string); $i++)
        {
            if(ctype_upper($string[$i]))
            {
                $new .= ' ' . $string[$i];
            }
            else
            {
                $new .= $string[$i];
            }
        }
        return $new;
    }

    function br($n = 1)
    {
        for ($i = 0; $i < $n; $i++)
        {
            echo '<br>';
        }
    }

    function Telefono($tel)
    {
        if(strlen($tel) == 7)
        {
            return substr($tel, 0, 3) . ' ' . substr($tel, 3, 2) . ' ' . substr($tel, 5, 5 + strlen($tel) - 5);
        }
        else
        {
            return $tel;
        }
    }

    function Ucspecial($txt)
    {
        $txt = str_replace('á', 'Á', $txt);
        $txt = str_replace('é', 'É', $txt);
        $txt = str_replace('í', 'Í', $txt);
        $txt = str_replace('ó', 'Ó', $txt);
        $txt = str_replace('ú', 'Ú', $txt);
        $txt= str_replace('ñ', 'Ñ', $txt);
        return strtoupper($txt);
    }