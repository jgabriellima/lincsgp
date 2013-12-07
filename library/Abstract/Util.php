<?php

Class Abstract_Util extends Zend_Controller_Plugin_Abstract {

    public static function formata_data_extenso($strDate) {
// Array com os dia da semana em português;
        $arrDaysOfWeek = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
// Array com os meses do ano em português;
        $arrMonthsOfYear = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
// Descobre o dia da semana
        $intDayOfWeek = date('w', strtotime($strDate));
// Descobre o dia do mês
        $intDayOfMonth = date('d', strtotime($strDate));
// Descobre o mês
        $intMonthOfYear = date('n', strtotime($strDate));
// Descobre o ano
        $intYear = date('Y', strtotime($strDate));
//Retorna também a hora (Adicionado por Rafael (ebalaio.com)
        $intHour = substr($strDate, 10, 20);
// Formato a ser retornado
        return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear . ' às ' . $intHour;
    }

    public static function startsWith($haystack, $needle) {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }

    /**
     * Ends the $haystack string with the suffix $needle?
     * @param  string
     * @param  string
     * @return bool
     */
    public static function endsWith($haystack, $needle) {
        return strlen($needle) === 0 || substr($haystack, -strlen($needle)) === $needle;
    }

}