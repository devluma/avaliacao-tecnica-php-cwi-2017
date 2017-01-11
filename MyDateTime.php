<?php

/**
 * @author Luiz Marcelo Schmitt <luizmarceloschmitt@gmail.com>
 * @since 2017-01-11
 * @package PHP 5.6+
 * @category Teste CWI
 * @version Teste 1.0
 * @copyright Copyright (c) 2017, Luiz Marcelo Schmitt
 */
class MyDateTime {

    private static $date;
    private static $op;
    private static $value;

    protected static $day;
    protected static $month;
    protected static $year;
    protected static $hour;
    protected static $minute;

    private static $result;

    public function __construct($date, $op, $value) {

        // Verifica se foi informado uma data
        if (empty($date)) {
            throw new Exception('Informe uma data');
        }

        // Verifica se foi informado uma operação e se foi informado + ou -
        if (empty($op) || !in_array($op, ['+', '-'])) {
            throw new Exception('Informe uma Operação(+/-)');
        }

        // Verifica se foi informado um valor de intervalo em minutos
        if (empty($value)) {
            throw new Exception('Informe o valor do intervalo em minutos');
        }

        self::$date = $date;
        self::$op = $op;
        self::$value = $value;
    }

    /**
     * Retorna a string com a data
     * @return string
     */
    public function getDate() {
        return self::$date;
    }

    /**
     * Retona a operação
     * @return string
     */
    public function getOp() {
        return self::$op;
    }

    /**
     * Retorna o valor em minutos
     * @return integer
     */
    public function getValue() {
        return self::$value;
    }

    /**
     * Retorna a string com o período calculado conforme a operação
     * @return string
     */
    public static function parserDate() {

        $stringDate = explode(' ', self::getDate());

        // Valida formato da string de data
        if (count($stringDate) != 2) {
            throw new Exception('Informe uma data no formato(d/m/Y H:i)');
        }

        $stringDateFormat = explode('/', $stringDate[0]);
        $stringTimeFormat = explode(':', $stringDate[1]);

        // Valida os dados passados no formato d/m/Y
        if (count($stringDateFormat) != 3) {
            throw new Exception('Informe a data no formato(d/m/Y)');
        }

        // Valida os dados passados no formato H:i
        if (count($stringTimeFormat) != 2) {
            throw new Exception('Informe a data no formato(H:i)');
        }

        self::$day = $stringDateFormat[0];
        self::$month = $stringDateFormat[1];
        self::$year = $stringDateFormat[2];

        self::$hour = $stringTimeFormat[0];
        self::$minute = $stringTimeFormat[1];

        return MyDateTime::calculate();
    }

    /**
     * Calcula as datas conforme a operação
     * @return string
     */
    private static function calculate() {

        $value = self::$value;
        $op = self::$op;

        $day = self::$day;
        $month = self::$month;
        $year = self::$year;

        $hour = self::$hour;
        $minute = self::$minute;

        // Valida os dias do mês
        if ($day > 31 || $day < 1) {
            throw new Exception('Informe o dia corretamente');
        }

        // Valida os meses do ano
        if ($month > 12 || $month < 1) {
            throw new Exception('Informe o mês corretamente');
        }

        // Valida o ano
        if (strlen($year) != 4) {
            throw new Exception('Informe o ano corretamente');
        }

        for ($i = 1; $i <= $value; $i++) {

            // Soma os minutos
            if ($op == '+') {
                
                $minute = ++$minute;

                // Verifica os sessenta minutos
                if ($minute == 60) {

                    $minute = 0;

                    $hour = ++$hour;
                    $hour = ($hour <= 23) ? $hour : 0;

                    // Verifica se passou 24 horas
                    if ($hour == 0) {

                        $day = ++$day;

                        // Ajusta os mese que tem 31 dias
                        if ($day > 31) {
                            $day = 0;
                        }

                        // Ajusta o mês de fevereiro
                        if ($month == 2) {
                            
                            if ($day > 28) {
                                $day = 0;
                            }
                        }

                        // Ajusta os meses de trinta dias (Novembro, Setembro, Junho, Abril)
                        if (in_array($month, [11, 9, 6, 4])) {

                            if ($day > 30) {
                                $day = 0;
                            }
                        }

                        // Verifica se é o primeiro dia para incrementar/decrementar os meses
                        if ($day == 0) {

                            $month = ++$month;
                            $month = ($month <= 12) ? $month : 0;

                            // Ajusta o ano
                            if ($month == 0) {
                                $year = ++$year;
                            }
                        }
                    }
                }
            }

            // Soma os minutos
            if ($op == '-') {

                if ($minute == 0) {

                    $minute = 60;

                    $hour = --$hour;
                    $hour = ($hour <= 23) ? $hour : 0;

                    // Ajusta as 24 horas
                    if ($hour == 0) {

                        $hour = 24;
                        $day = --$day;

                        if ($day == 0) {

                            $month = --$month;
                            $month = ($month <= 12) ? $month : 0;

                            // Ajusta o mês de fevereiro
                            if ($month == 2) {
                                $day = 28;
                            }

                            // Ajusta os meses de trinta dias (Novembro, Setembro, Junho, Abril)
                            if (in_array($month, [11, 9, 6, 4])) {
                                $day = 30;
                            }

                            // Ajusta o ano
                            if ($month == 0) {
                                $year = --$year;
                            }
                        }
                    }
                }

                $minute = --$minute;
            }
        }

        $minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
        $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        MyDateTime::$result = "{$day}/{$month}/{$year} {$hour}:{$minute}";

        return MyDateTime::$result;
    }
}