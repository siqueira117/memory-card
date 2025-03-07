<?php

$file = file_get_contents(__DIR__."/themes.json");
$themes = json_decode($file, true);

$str = "";
foreach ($themes as $theme) {
    $str .= '[ "theme_id" => '.$theme["theme_id"].', "name" => "'.$theme["name"].'", "slug" => "'.$theme["slug"].'"],'."\n";
}

echo $str;