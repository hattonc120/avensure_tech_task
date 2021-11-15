document.addEventListener(
  "DOMContentLoaded",
  function () {
    filterPosts("post");
  },
  false
);

/* function cleanTextForJsonFile(el) {
            str = el.value;
            str = str.replace(/"/g, "'");
            str = str.replace('[', '(');
            str = str.replace(']', ')');
            str = JSON.stringify(str)
            el.value = str;
        } */

function clearValidationStyles() {
  var elements = document.getElementsByClassName("postFormField");
  var c = elements.length;
  for (var i = 0; i < c; i++) {
    elements[i].classList.remove("errorFieldStyle");
  }
  document.getElementById("postFormValidationMessage").innerHTML = "";
}

function displayPost(postId) {
  //console.log(postId);
  formatPostForm("update");
  //console.log(document.getElementById('postFormContext').value);
  var data = new FormData();
  data.append("action", "show");
  data.append("id", postId);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "./Http/Controllers/PostController.php", true);
  xhr.onload = function () {
    if (xhr.status !== 200) {
      alert("Something has gone wrong!");
      console.log("error : status code : " + xhr.status);
      return;
    }
    //console.log(this.responseText);
    postData = JSON.parse(this.responseText);
    //var id = postData[0].id;
    console.log(postData[0].title);
    document.getElementById("displayPostTitle").innerHTML = postData[0].title;
    document.getElementById("displayPostDescription").innerHTML =
      postData[0].description;
    document.getElementById("displayPostCategory").innerHTML =
      "category : " + postData[0].category;
    document.getElementById("displayPostCreatedComment").innerHTML =
      "created at : " + timeConverter(postData[0].timestamp);
  };
  xhr.send(data);
}

function timeConverter(UNIX_timestamp) {
  var a = new Date(UNIX_timestamp * 1000);
  var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  var months = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var day = days[a.getDay()];
  var date = a.getDate();
  var hour = a.getHours();
  var ampm = hour <= 11 ? "am" : "pm";
  hour = hour >= 12 ? hour - 12 : hour;
  var min = a.getMinutes();
  var sec = a.getSeconds();
  return (
    hour +
    ":" +
    min +
    ampm +
    " on " +
    day +
    " " +
    date +
    " " +
    month +
    " " +
    year
  );
}

function filterPosts(category) {
  var elements = document.getElementsByClassName("post");
  var c = elements.length;
  for (var i = 0; i < c; i++) {
    elements[i].style.display = "none";
  }
  var elements = document.getElementsByClassName(category);
  var c = elements.length;
  for (var i = 0; i < c; i++) {
    elements[i].style.display = "inline-block";
  }
  if (category == "post") {
    document.getElementById("postCount").innerHTML = "total posts : " + c;
  } else {
    document.getElementById("postCount").innerHTML =
      c + " post(s) found for " + category;
  }
  //console.log(category);
}

function formatPostForm(context) {
  console.log(context);
  if (context == "create") {
    document.getElementById("exampleModalLongTitle").innerHTML =
      "Create a new post...";
    document.getElementById("postFormSubmitButton").value = "create post";
    document.getElementById("postFormContext").value = "create";
    document.getElementById("title").value = "";
    document.getElementById("description").value = "";
    document.getElementById("category").value = "";
  } else {
    document.getElementById("exampleModalLongTitle").innerHTML =
      "Update post...";
    document.getElementById("postFormSubmitButton").value = "update post";
    document.getElementById("postFormContext").value = "update";
    console.log(document.getElementById("postFormContext").value);
  }
}

function validatePostFormData() {
  console.log("enter function : validateNewPostFormData");
  title = document.forms["postForm"]["title"].value;
  description = document.forms["postForm"]["description"].value;
  category = document.forms["postForm"]["category"].value;
  var submitFlag = true;
  if (title == "") {
    highlightValidationErrorField("title");
    submitFlag = false;
  }
  if (description == "") {
    highlightValidationErrorField("description");
    submitFlag = false;
  }
  if (category == "") {
    highlightValidationErrorField("category");
    submitFlag = false;
  }
  //----------------------------------------------
  if (!submitFlag) {
    document.getElementById("postFormValidationMessage").innerHTML =
      "Please enter values highlighted in red.";
  } else {
    document.getElementById("postFormValidationMessage").innerHTML = "";
    //console.log(document.getElementById('title').value);
    //cleanTextForJsonFile(document.getElementById('title'));
    //console.log(document.getElementById('title').value);
    //cleanTextForJsonFile(document.getElementById('description'));
  }
  return submitFlag;
}

function validateCategoryFormData() {
  console.log("enter function : validateNewCategoryFormData");
  name = document.forms["categoryForm"]["name"].value;
  color = document.forms["categoryForm"]["color"].value;
  var submitFlag = true;
  if (name == "") {
    highlightValidationErrorField("categoryName");
    submitFlag = false;
  }
  /*             if (color == "") {
                            highlightValidationErrorField('description');
                            submitFlag = false;
                        } */
  //----------------------------------------------
  if (!submitFlag) {
    document.getElementById("categoryFormValidationMessage").innerHTML =
      "Please enter a category name.";
  } else {
    document.getElementById("categoryFormValidationMessage").innerHTML = "";
  }
  return submitFlag;
}

function highlightValidationErrorField(el) {
  var element = document.getElementById(el);
  element.classList.add("errorFieldStyle");
}

function populateAndDisplayPostForm(postId) {
  console.log(postId);
  formatPostForm("update");
  console.log(document.getElementById("postFormContext").value);
  var data = new FormData();
  data.append("action", "edit");
  data.append("id", postId);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "./Http/Controllers/PostController.php", true);
  xhr.onload = function () {
    if (xhr.status !== 200) {
      console.log("error");
      // Server does not return HTTP 200 (OK) response.
      // Whatever you wanted to do when server responded with another code than 200 (OK)
      return; // return is important because the code below is NOT executed if the response is other than HTTP 200 (OK)
    }
    console.log(this.responseText);
    postData = JSON.parse(this.responseText);
    var id = postData[0].id;
    console.log(postData[0].title);
    document.getElementById("id").value = postData[0].id;
    document.getElementById("title").value = postData[0].title;
    document.getElementById("description").value = postData[0].description;
    document.getElementById("category").value = postData[0].category;
    //console.log(postData[0].id)
  };
  xhr.send(data);
}
