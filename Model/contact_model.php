<?php

$input = [

    "prenom" => [
            "placeholder" => "Emilie", // facultatif
            "required" => true, // facultatif
            "label" => "Votre prenom", // facultatif
            "maxlength" => 50, // facultatif
    'required' => true,
    ],
    "email" => [
            "type" => "email",
            "placeholder" => "emilie.bld22@gmail.com", // facultatif
            "required" => true, // facultatif
            "maxlength" => 50, // facultatif
            'required' => true,
    ],
    "text" => [
            "type" => "textarea",
            "placeholder" => "Entrer votre message ici...", // facultatif
            "required" => true, // facultatif
            "label" => "Votre message", // facultatif
            "maxlength" => 300, // facultatif
            'required' => true,
    ],
   "button" => [
           "type" => "submit",
            "value" => "Valider",
    ],
];
$test = new FormContact($_POST, $input);