<?php

$file = file_get_contents(__DIR__."/languages.json");
$languages = json_decode($file, true);

$str = "";
foreach ($languages as $theme) {
    $str .= '[ "language_id" => '.$theme["id"].', "name" => "'.$theme["name"].'", "locale" => "'.$theme["locale"].'", "native_name" => "'.$theme["native_name"].'" ],'."\n";
}

echo $str;