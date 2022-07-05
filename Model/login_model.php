<?php

$input = [
    "email" => [
        'type' => 'email',
        'required' => true,
        'maxlength' => 255
    ],
    "password" => [
        'type' => 'password',
        'required' => true,
        'maxlength' => 255
    ],
    "button" => [
            "type" => "submit",
            "value" => "Valider",
    ],
];
$form = new ClassLogin($_POST, $input);