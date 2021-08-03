<?php

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php")) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
}

use App\Service\OfficeFileParser;
use App\Service\JsonFileCreator;
use App\Service\XmlFileCreator;

$filename = $_REQUEST['filename'];

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/' . $filename) && !empty($_REQUEST['submit'])) {
    $fileParser = new OfficeFileParser($filename);
    $offices = $fileParser->getOffices();
    $jsonFile = (new JsonFileCreator)->create($offices);
    $xmlFile = (new XmlFileCreator)->create($offices);
    echo sprintf('jsonFile: <a target="_blank" href="%s">%s</a><br>', $jsonFile, $jsonFile);
    echo sprintf('xmlFile: <a target="_blank" href="%s">%s</a><br>', $xmlFile, $xmlFile);
} else {
    echo 'File not found';
}
?>