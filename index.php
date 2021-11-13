<?php
include 'includes/functions.php';
include 'includes/variables.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Favorite Blog</title>
    <script>
        function cleanTextForJsonFile(el) {
            str = el.value;
            str = str.replace(/"/g, "'");
            str = str.replace('[', '(');
            str = str.replace(']', ')');
            str = JSON.stringify(str)
            el.value = str;
        }

        function clearValidationStyles() {
            var elements = document.getElementsByClassName('postFormField');
            var c = elements.length;
            for (var i = 0; i < c; i++) {
                elements[i].classList.remove("errorFieldStyle");
            }
            document.getElementById('postFormValidationMessage').innerHTML = "";
        }

        function displayPost(postId) {
            //console.log(postId);
            formatPostForm('update')
            //console.log(document.getElementById('postFormContext').value);
            var data = new FormData();
            data.append('action', "show");
            data.append('id', postId);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'PostController.php', true);
            xhr.onload = function() {
                if (xhr.status !== 200) {
                    console.log("error");
                    // Server does not return HTTP 200 (OK) response.
                    // Whatever you wanted to do when server responded with another code than 200 (OK)
                    return; // return is important because the code below is NOT executed if the response is other than HTTP 200 (OK)
                }
                //console.log(this.responseText);
                postData = JSON.parse(this.responseText);
                //var id = postData[0].id;
                console.log(postData[0].title)
                document.getElementById('displayPostTitle').innerHTML = postData[0].title;
                document.getElementById('displayPostDescription').innerHTML = postData[0].description;
                document.getElementById('displayPostCategory').innerHTML = "category : " + postData[0].category;
                document.getElementById('displayPostCreatedComment').innerHTML = "created at : " + timeConverter(postData[0].timestamp);
            };
            xhr.send(data);
        }

        function timeConverter(UNIX_timestamp) {
            var a = new Date(UNIX_timestamp * 1000);
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var year = a.getFullYear();
            var month = months[a.getMonth()];
            var day = days[a.getDay()];
            var date = a.getDate();
            var hour = a.getHours();
            var ampm = hour <= 11 ? "am" : "pm";
            hour = hour >= 12 ? hour - 12 : hour;
            var min = a.getMinutes();
            var sec = a.getSeconds();
            return hour + ':' + min + ampm + " on " + day + " " + date + " " + month + " " + year;
        }

        function filterPosts($category) {
            var elements = document.getElementsByClassName('post');
            var c = elements.length;
            for (var i = 0; i < c; i++) {
                elements[i].style.display = 'none';
            }
            var elements = document.getElementsByClassName($category);
            var c = elements.length;
            for (var i = 0; i < c; i++) {
                elements[i].style.display = 'inline-block';
            }
            //console.log(c + " posts found")
            document.getElementById('postCount').innerHTML = c + " post(s) found";
            console.log($category);
        }

        function formatPostForm(context) {
            console.log(context);
            if (context == "create") {
                document.getElementById('exampleModalLongTitle').innerHTML = "Create a new post...";
                document.getElementById('postFormSubmitButton').value = "create post";
                document.getElementById('postFormContext').value = "create";
            } else {
                document.getElementById('exampleModalLongTitle').innerHTML = "Update post...";
                document.getElementById('postFormSubmitButton').value = "update post";
                document.getElementById('postFormContext').value = "update";
                console.log(document.getElementById('postFormContext').value);
            }
        }

        function validatePostFormData() {
            console.log("enter function : validateNewPostFormData");
            title = document.forms['postForm']["title"].value;
            description = document.forms['postForm']["description"].value;
            category = document.forms['postForm']["category"].value;
            var submitFlag = true;
            if (title == "") {
                highlightValidationErrorField('title');
                submitFlag = false;
            }
            if (description == "") {
                highlightValidationErrorField('description');
                submitFlag = false;
            }
            if (category == "") {
                highlightValidationErrorField('category');
                submitFlag = false;
            }
            //----------------------------------------------
            if (!submitFlag) {
                document.getElementById('postFormValidationMessage').innerHTML = 'Please enter values highlighted in red.';
            } else {
                document.getElementById('postFormValidationMessage').innerHTML = "";
                //console.log(document.getElementById('title').value);
                //cleanTextForJsonFile(document.getElementById('title'));
                //console.log(document.getElementById('title').value);
                //cleanTextForJsonFile(document.getElementById('description'));
            }
            return submitFlag;
        }

        function validateCategoryFormData() {
            console.log("enter function : validateNewCategoryFormData");
            name = document.forms['categoryForm']["name"].value;
            color = document.forms['categoryForm']["color"].value;
            var submitFlag = true;
            if (name == "") {
                highlightValidationErrorField('categoryName');
                submitFlag = false;
            }
            /*             if (color == "") {
                            highlightValidationErrorField('description');
                            submitFlag = false;
                        } */
            //----------------------------------------------
            if (!submitFlag) {
                document.getElementById('categoryFormValidationMessage').innerHTML = 'Please enter a category name.';
            } else {
                document.getElementById('categoryFormValidationMessage').innerHTML = "";
            }
            return submitFlag;
        }

        function highlightValidationErrorField(el) {
            var element = document.getElementById(el);
            element.classList.add("errorFieldStyle");
        }

        function populateAndDisplayPostForm(postId) {
            console.log(postId);
            formatPostForm('update')
            console.log(document.getElementById('postFormContext').value);
            var data = new FormData();
            data.append('action', "edit");
            data.append('id', postId);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'PostController.php', true);
            xhr.onload = function() {
                if (xhr.status !== 200) {
                    console.log("error");
                    // Server does not return HTTP 200 (OK) response.
                    // Whatever you wanted to do when server responded with another code than 200 (OK)
                    return; // return is important because the code below is NOT executed if the response is other than HTTP 200 (OK)
                }
                console.log(this.responseText);
                postData = JSON.parse(this.responseText);
                var id = postData[0].id;
                console.log(postData[0].title)
                document.getElementById('id').value = postData[0].id;
                document.getElementById('title').value = postData[0].title;
                document.getElementById('description').value = postData[0].description;
                document.getElementById('category').value = postData[0].category;
                //console.log(postData[0].id)
            };
            xhr.send(data);
        }
    </script>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://kit.fontawesome.com/4507ad3809.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="./css/blog_styles.css">

<body>
    <div class="container my-5">
        <div class="blog_header_wrapper d-flex justify-content-between">
            <h1>The Blog Zone : Chris Hatton</h1>
            <img class="blog_header_image" src="./images/banana_splits.jpg">
        </div>

        <!-- <div class="d-flex row justify-content-around mt-5">
        </div> -->
        <div class="d-flex my-5">
            <div class="col-3 mr-3 category_sidebar">
                <button type="button" class="btn text-light bg-dark" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-plus"></i> new category
                </button>
                <div class='btn m-1 text-light bg-dark' onclick='filterPosts("post")'>show all posts</div>
                <hr>
                <?php
                echo populateCategoriesSidebar();
                ?>
            </div>
            <div class="col-9 post_container">
                <div class="d-flex justify-content-between">
                    <span id="postCount"></span>
                    <button type="button" class="btn text-light bg-dark" data-bs-toggle="modal" data-bs-target="#postModal" onclick="formatPostForm('create')">
                        <i class="fas fa-plus"></i> new post
                    </button>
                </div>
                <hr>
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
                    <form name="postForm" action="PostController.php" onsubmit="return validatePostFormData()" method="post">
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
                    <form name="categoryForm" action="CategoryController.php" onsubmit="return validateCategoryFormData()" method="post">
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