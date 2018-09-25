<?php

/**
 * Helper para formatação e manipulação de datas.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

//------------------------------------------------------------------------------------------------------------------

/**
 * Formata uma data de entrada no formato do MySQL>
 *
 * @param $data Data de entrada.
 * @return bool|string  Caso tenha sido realizado a conversão com sucesso retorna a data
 *                      formatada, senão retorna falso.
 */
function data_normal_para_MySQL($data) {
    if($data != NULL) {
        $formatarData = explode('/', $data);

        return $formatarData[2].'-'.$formatarData[1].'-'.$formatarData[0];
    }

    return FALSE;
}

//------------------------------------------------------------------------------------------------------------------

/**
 * Formata uma data de entrada no formato dd/mm/aaaa.
 *
 * @param $data Data de entrada.
 * @return bool|string  Caso tenha sido realizado a conversão com sucesso retorna a data
 *                      formatada, senão retorna falso.
 */
function data_MySQL_para_normal($data) {
    if($data != NULL) {
        $formatarData = explode('-', $data);

        return $formatarData[2].'/'.$formatarData[1].'/'.$formatarData[0];
    }

    return FALSE;
}

//------------------------------------------------------------------------------------------------------------------

/**
 * Valida uma data.
 *
 * @param null $data Data a ser validada.
 * @param null $formato Formato da data.
 * @return bool Caso a data seja válida retorna verdadeiro, se não retorna falso.
 */
function validar_data($data = NULL, $formato = NULL)
{
    if ($formato != NULL && $data != NULL) {
        $d = DateTime::createFromFormat($formato, $data);
        return $d && $d->format($formato) == $data;
    }

    return FALSE;
}

 