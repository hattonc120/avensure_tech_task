<?php

include './Models/Category.php';
include './Models/Post.php';

function populateCategoriesSidebar()
{
    $category_data_url = dirname(__DIR__, 1) . '/data/categories.json';
    $storedCategories = json_decode(file_get_contents($category_data_url));
    $categoriesArray = array();
    if (!empty($storedCategories)) {
        foreach ($storedCategories as $storedCategory) {
            $category = new Category($storedCategory->id, $storedCategory->name, $storedCategory->color, $storedCategory->timestamp);
            array_push($categoriesArray, $category);
        }
        echo "<div class='d-flex row'>";
        echo "<div class='btn m-1 text-light bg-secondary' onclick='filterPosts(\"post\")'>show all posts</div>";
        foreach ($categoriesArray as $category) {
            echo $category->getHtml();
        }
        echo "</div>";
    }
}

function populatePostsContainer()
{
    $post_data_url = dirname(__DIR__, 1) . '/data/posts.json';
    $storedPosts = json_decode(file_get_contents($post_data_url));
    $postsArr = array();
    if (!empty($storedPosts)) {
        foreach ($storedPosts as $storedPost) {
            $post = new Post($storedPost->id, $storedPost->title, $storedPost->description, $storedPost->category, $storedPost->timestamp);
            array_push($postsArr, $post);
        }
        //echo "<div class='d-flex row'>";
        echo "<div>";
        foreach ($postsArr as $post) {
            echo $post->getHtml();
        }
        echo "</div>";
    }
}

function importCategories()
{
    $str = file_get_contents($GLOBALS['category_data_url']);
    return json_decode($str);
}

function populateCategorySelect()
{
    $category_data_url = dirname(__DIR__, 1) . '/data/categories.json';
    $str = file_get_contents($category_data_url);
    $categories = json_decode($str);
    $html = "";
    foreach ($categories as $category) {
        $categoryName = $category->name;
        $html .= "<option value='$categoryName'>$categoryName</option>";
    }
    return $html;
}
