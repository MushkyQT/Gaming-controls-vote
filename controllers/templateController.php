<?php

function templateGen($template, $data)
{
    if (!file_exists($template)) {
        return "ERROR: Template not found.";
    }
    if (is_array($data)) {
        extract($data);
    } else {
        return "ERROR: Data given to templateController is not an array.";
    }
    ob_start();
    include($template);
    return ob_get_clean();
}
