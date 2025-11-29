<?php 
use ItForFree\SimpleAsset\SimpleAssetManager;
use application\assets\HomepageCSSAsset;
use application\assets\AjaxJavascriptAsset;


AjaxJavascriptAsset::add();
HomepageCSSAsset::add();

SimpleAssetManager::printJs();
SimpleAssetManager::printCss();
?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    <title>SimpleMVC | Учебный проект</title>  
</head>
