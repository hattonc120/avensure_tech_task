<?php

$data_url = dirname(__DIR__, 2) . '/data/posts.json';

switch ($_POST['action']) {
    case 'create':
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $newPost = array("id" => getNextPostId(), "title" => "$title", "description" => "$description", "timestamp" => time(), "category" => "$category");
        $storedJsonData = file_get_contents($GLOBALS['data_url']);
        $storedDataArray = json_decode($storedJsonData, true);
        if ($storedDataArray == null) {
            $storedDataArray = array();
        }
        array_unshift($storedDataArray, $newPost);
        $jsonData = json_encode($storedDataArray);
        file_put_contents($GLOBALS['data_url'], $jsonData);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;
    case 'delete':
        //echo "qwerty4335463546453645"; return;
        $id = $_POST['id'];
        $storedJsonData = file_get_contents($GLOBALS['data_url']);
        $storedDataArray = json_decode($storedJsonData, true);
        if ($storedDataArray == null) {
            $storedDataArray = array();
        }
        $c = count($storedDataArray);
        for ($i = 0; $i < $c; $i++) {
            if ($storedDataArray[$i]['id'] == $id) {
                array_splice($storedDataArray, $i, 1);
                break;
            }
        }
        $jsonData = json_encode($storedDataArray);
        file_put_contents($GLOBALS['data_url'], $jsonData);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;
    case 'edit':
    case 'show':
        $id = $_POST['id'];
        $storedJsonData = file_get_contents($GLOBALS['data_url']);
        $storedDataArray = json_decode($storedJsonData, true);
        if ($storedDataArray == null) {
            $storedDataArray = array();
        }
        $c = count($storedDataArray);
        $tempArr = array();
        for ($i = 0; $i < $c; $i++) {
            if ($storedDataArray[$i]['id'] == $id) {
                $tempArr[] = $storedDataArray[$i];
                echo json_encode($tempArr);
                break;
            }
        }
        break;
    case 'update':
        $id = intval($_POST['id']);
        //var_dump($id);
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $storedJsonData = file_get_contents($GLOBALS['data_url']);
        $storedDataArray = json_decode($storedJsonData, true);
        if ($storedDataArray == null) {
            $storedDataArray = array();
        }
        $c = count($storedDataArray);
        $tempArr = array();
        for ($i = 0; $i < $c; $i++) {
            if ($storedDataArray[$i]['id'] == $id) {
                $storedDataArray[$i]['title'] = $title;
                $storedDataArray[$i]['description'] = $description;
                $storedDataArray[$i]['category'] = $category;
                //$tempArr[] = $storedDataArray[$i];
                //echo json_encode($storedDataArray[$i]);
                $jsonData = json_encode($storedDataArray);
                file_put_contents($GLOBALS['data_url'], $jsonData);
                break;
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;
}



function getNextPostId()
{
    $storedJsonData = file_get_contents($GLOBALS['data_url']);
    $storedDataArray = json_decode($storedJsonData, true);
    $maxId = 0;
    if ($storedDataArray != null) {
        foreach ($storedDataArray as $post) {
            if ($post['id'] >= $maxId) {
                $maxId = $post['id'] + 1;
            }
        }
    }
    return $maxId;
}

//function get
