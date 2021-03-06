<?php

$data_url = dirname(__DIR__, 2) . '/data/categories.json';

switch ($_POST['action']) {
    case 'create':
        $name = $_POST['name'];
        $color = $_POST['color'];
        var_dump($color);
        $newCategory = array("id" => getNextCategoryId(), "name" => "$name", "color" => "$color", "timestamp" => time());
        $storedJsonData = file_get_contents($GLOBALS['data_url']);
        $storedDataArray = json_decode($storedJsonData, true);
        if ($storedDataArray == null) {
            $storedDataArray = array();
        }
        array_unshift($storedDataArray, $newCategory);
        $jsonData = json_encode($storedDataArray);
        file_put_contents($GLOBALS['data_url'], $jsonData);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;
    case 'delete':
        break;
    case 'edit':
        break;
    case 'update':
        break;
}

function getNextCategoryId()
{
    $storedJsonData = file_get_contents($GLOBALS['data_url']);
    $storedDataArray = json_decode($storedJsonData, true);
    $maxId = 0;
    if ($storedDataArray != null) {
        foreach ($storedDataArray as $category) {
            if ($category['id'] >= $maxId) {
                $maxId = $category['id'] + 1;
            }
        }
    }
    return $maxId;
}

//function get
