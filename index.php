<?php
include 'includes/functions.php';
$category_data_url = dirname(__DIR__, 1) . '/data/categories.json';
$post_data_url = dirname(__DIR__, 1) . '/data/posts.json';
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Favorite Blog</title>

</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://kit.fontawesome.com/4507ad3809.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="css/blog_styles.css">
<script src="js/script.js"></script>

<body>
    <div class="m-5">
        <div class="blog_header_wrapper d-flex justify-content-between">
            <h1>The Blog Zone : Chris Hatton</h1>
            <img class="blog_header_image" src="images/banana_splits.jpg">
        </div>

        <!-- <div class="d-flex row justify-content-around mt-5">
        </div> -->
        <div class="flex-container my-5">
            <div class="mr-3 category_sidebar">
                <div class="d-flex justify-content-end">
                    <!-- <div class='btn m-1 text-light bg-dark' onclick='filterPosts("post")'>show all posts</div> -->
                    <button type="button" class="btn text-light bg-dark" data-bs-toggle="modal" data-bs-target="#categoryModal">
                        <i class="fas fa-plus"></i> new category
                    </button>
                </div>
                <hr>
                <?php
                echo populateCategoriesSidebar();
                ?>
            </div>
            <div class="post_container">
                <div class="d-flex justify-content-between">
                    <span id="postCount"></span>
                    <button type="button" class="btn text-light bg-dark" data-bs-toggle="modal" data-bs-target="#postModal" onclick="formatPostForm('create')">
                        <i class="fas fa-plus"></i> new post
                    </button>
                </div>
                <?php
                populatePostsContainer();
                ?>
            </div>
        </div>

    </div>

    <!-- post modal -->
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" name="postModalHeading">Create a new post...</h5>
                </div>
                <div class="modal-body">
                    <form name="postForm" action="Http/Controllers/PostController.php" onsubmit="return validatePostFormData()" method="post">
                        <input type="text" id="postFormContext" name="action" value="" hidden>
                        <input type="text" id="id" name="id" value="" hidden>
                        <input type="text" id="title" name="title" class="postFormField w-100 mb-3" placeholder="type a title for your post..." onkeydown="clearValidationStyles()"><br>
                        <textarea id="description" name="description" class="postFormField w-100" rows=10 placeholder="What's on your mind..." onkeydown="clearValidationStyles()"></textarea>
                        <div class="d-flex">
                            <select id="category" class="postFormField w-50 mb-3" name="category" onchange="clearValidationStyles()">
                                <option value="" selected disabled></option>
                                <?php echo populateCategorySelect(); ?>
                            </select>
                            <label for="category" class="mx-3 mb-3">choose a category</label>
                        </div>
                        <input id="postFormSubmitButton" type="submit" class="btn text-light bg-dark" value="">
                        <span id="postFormValidationMessage" class="validationText"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create new category...</h5>
                </div>
                <div class="modal-body">
                    <form name="categoryForm" action="./Http/Controllers/CategoryController.php" onsubmit="return validateCategoryFormData()" method="post">
                        <input type="text" name="action" value="create" hidden>
                        <input type="text" id="categoryName" name="name" class="postFormField w-100 mb-3" placeholder="type a name for the category..." onkeydown="clearValidationStyles()"><br>
                        <input type="color" id="categoryColor" name="color" value="#dddddd" />
                        <label for="category" class="mx-3 mb-3">choose a category color</label>
                        <br>
                        <div class="d-flex justify-content-end">
                            <input type="submit" name="create" value="create new category">
                            <span id="categoryFormValidationMessage" class="validationText"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="postDisplayModal" class="postDisplayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create new category...</h5>
                </div> -->
                <div class="modal-body">
                    <div type="text" id="displayPostTitle"></div>
                    <div type="text" id="displayPostDescription"> </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div type="text" id="displayPostCategory"></div>
                        <div type="text" id="displayPostCreatedComment"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>