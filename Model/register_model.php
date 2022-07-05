<?php


$input = [
    "pseudo" => [
        'required' => true,
        'maxlength' => 255
    ],
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
$form = new ClassRegister($_POST, $input);