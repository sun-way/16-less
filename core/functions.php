<?php
/**
 * Проверяет установлен ли параметр $name в запросе
 * @param $name
 * @return null
 */
function getParam($name)
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
}