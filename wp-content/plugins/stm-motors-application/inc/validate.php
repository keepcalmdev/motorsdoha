<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 3/12/19
 * Time: 14:37
 */

function stmMRAValidateNumber($param, $request, $key) {
    return is_numeric( $param );
}