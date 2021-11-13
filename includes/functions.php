<?php

include 'Post.php';

function populateCategoriesSidebar()
{
    $storedCategories = json_decode(file_get_contents('data/categories.json'));
    $html = "";
    if (empty($storedCategories)) {
        return $html;
    }
    foreach ($storedCategories as $category) {
        $html .= "<div class='btn m-1' style='background-color:$category->color' onclick='filterPosts(\"$category->name\")'><i class='fas fa-filter'></i> $category->name</div>";
    }
    return $html;
}

function populatePostsContainer()
{
    $storedPosts = json_decode(file_get_contents('data/posts.json'));
    $postsArr = array();
    if (!empty($storedPosts)) {
        foreach ($storedPosts as $storedPost) {
            $post = new Post($storedPost->id, $storedPost->title, $storedPost->description, $storedPost->category, $storedPost->timestamp);
            array_push($postsArr, $post);
        }
        echo "<div class='d-flex row'>";
        foreach ($postsArr as $post) {
            echo $post->getHtml();
        }
        echo "</div>";
    }
}

function importCategories()
{
    $str = file_get_contents('data/categories.json');
    return json_decode($str);
}



function populateCategorySelect()
{
    $str = file_get_contents('data/categories.json');
    $categories = json_decode($str);
    $html = "";
    foreach ($categories as $category) {
        $categoryName = $category->name;
        $html .= "<option value='$categoryName'>$categoryName</option>";
    }
    return $html;
}
