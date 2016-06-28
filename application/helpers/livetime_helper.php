<?php if(!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}
    function Momento($date)
    {
        if(is_null($date) || empty($date))
        {
            return 'N/A';
        }
        #########Ajuste de horas según la zona horaria
        $ajustehora = 0;
        #########
        $fecha = strtotime($date) + $ajustehora * 3600;
        $ahora = strtotime(date('Y-m-d H:i:s')) + $ajustehora * 3600;
        $diff = $ahora - $fecha;
        $DIA = 86400 + 15000;

        if($diff < 6)
        {
            $momento = 'hace un segundo';
        }
        else if($diff < 30)
        {
            $momento = 'hace 5 segundos';
        }
        else if($diff < 60)
        {
            $momento = 'hace 30 segundos';
        }
        else if($diff < 180)
        {
            $momento = 'hace un minuto';
        }
        else if($diff < 300)
        {
            $momento = 'hace 3 minutos';
        }
        else if($diff < 420)
        {
            $momento = 'hace 5 minutos';
        }
        else if($diff < 600)
        {
            $momento = 'hace 7 minutos';
        }
        else if($diff < 1200)
        {
            $momento = 'hace 10 minutos';
        }
        else if($diff < 1800)
        {
            $momento = 'hace 20 minutos';
        }
        else if($diff < 2400)
        {
            $momento = 'hace 30 minutos';
        }
        else if($diff < 3000)
        {
            $momento = 'hace 40 minutos';
        }
        else if($diff < 3600)
        {
            $momento = 'hace 50 minutos';
        }
        else if($diff < 7200)
        {
            $momento = 'hace una hora';
        }
        else if($diff < 10800)
        {
            $momento = 'hace 2 horas';
        }
        else if($diff < 14400)
        {
            $momento = 'hace 3 horas';
        }
        else if($diff < 18000)
        {
            $momento = 'hace 4 horas';
        }
        else if($diff < 21600)
        {
            $momento = 'hace 5 horas';
        }
        else if($diff < 25200)
        {
            $momento = 'hace 6 horas';
        }
        else if(date('d') == date_format(new DateTime($date), 'd') && date('m') == date_format(new DateTime($date), 'm') && date('Y') == date_format(new DateTime($date), 'Y'))
        {
            $momento = 'Hoy, ' . round(date('h', $fecha)) . date(':i a', $fecha);
        }
        else if($diff < $DIA)
        {
            $momento = 'Ayer, ' . round(date('h', $fecha)) . date(':i a', $fecha);
        }
        else if($diff < $DIA * 2)
        {
            $momento = 'hace 2 días';
        }
        else if($diff < $DIA * 3)
        {
            $momento = 'hace 3 días';
        }
        else if($diff < $DIA * 4)
        {
            $momento = 'hace 4 días';
        }
        else if($diff < $DIA * 5)
        {
            $momento = 'hace 5 días';
        }
        else if($diff < $DIA * 6)
        {
            $momento = 'hace 6 días';
        }
        else if($diff < $DIA * 14)
        {
            $momento = 'hace una semana';
        }
        else if($diff < $DIA * 22)
        {
            $momento = 'hace 2 semanas';
        }
        else if($diff < $DIA * 28)
        {
            $momento = 'hace 3 semanas';
        }
        else if($diff >= $DIA * 28 && $diff <= $DIA * 40)
        {
            $momento = 'hace un mes';
        }
        else if($diff >= $DIA * 28 && date('Y') == date_format(new DateTime($date), 'Y'))
        {
            $momento = date_format(new DateTime($date), 'd') . ' de ' . MesNombre(round(date_format(new DateTime($date), 'm')));
        }
        else
        {
            $momento = date_format(new DateTime($date), 'd/m/Y');
        }
        return $momento;
    }

    function MesNombre($Mes)
    {
        if(!is_numeric($Mes))
        {
            $Mes = date('m', strtotime($Mes));
        }
        $Meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
        return $Meses[round($Mes)];
    }

    function FechaFormal($Fecha, $abr = true)
    {
        $Fecha = $Fecha == 'now' ? date('Y-m-d') : $Fecha;
        $abr = $abr === true ? MesNombreAbr($Fecha) : MesNombre($Fecha);
        return round(date('d', strtotime($Fecha))) . ' de ' . $abr . '/' . date('Y', strtotime($Fecha));
    }

    function Fecha($Fecha = 'now')
    {
        return $Fecha == 'now' ? round(date('d')) . date('/m/Y') : date('d/m/Y', strtotime($Fecha));
    }

    function MesNombreAbr($Mes)
    {
        if(!is_numeric($Mes))
        {
            $Mes = date('m', strtotime($Mes));
        }
        $Meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        return $Meses[round($Mes)];
    }

    function MomentoFuturo($date, $time = '')
    {
        if(is_null($date) || empty($date))
        {
            return 'N/A';
        }
        $fecha = new DateTime($date);
        $actual = new DateTime(date('Y-m-d'));
        $diff = $actual->diff($fecha);
        $diff = $diff->invert == 1 ? 7 - $diff->d : $diff->d;
        $momento = '';

        if($diff == 0)
        {
            $momento = 'hoy, ' . $time;
        }
        else if($diff == 1)
        {
            $momento = 'mañana, ' . $time;
        }
        else if($diff == 2)
        {
            $momento = 'dos días';
        }
        else if($diff == 3)
        {
            $momento = 'tres días';
        }
        else if($diff == 4)
        {
            $momento = 'cuatro días';
        }
        else if($diff == 5)
        {
            $momento = 'cinco días';
        }
        else if($diff == 6)
        {
            $momento = 'seis días';
        }
        else if($diff == 7)
        {
            $momento = 'siete días';
        }
        return $momento;
    }
