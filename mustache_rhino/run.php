<?php
require_once './render.php';
$data = array(
    'content' => 'Foo'
);
$html = renderMustacheJS($data);
echo "Returned from renderMustacheJS() -----\n", $html, "\n-----------\n";

