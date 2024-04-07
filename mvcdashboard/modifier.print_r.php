<?php
function smarty_modifier_print_r($value) {
    return print_r($value, true);
}