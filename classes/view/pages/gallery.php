<?php include "classes/view/constant/header.php";

$page = $_GET['page'] ? $_GET['page'] : 1;

$_SESSION['csrf'] = rand(4000, 80000);

?>

<nav class="navbar navbar-expand navbar-light bg-light sticky-top">

    <div class="collapse navbar-collapse" id="collapse_target">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="/camagru/index.php/blog/newPicture" class="nav-link"><button class="btn btn-success my-2 my-sm-0" type="button">Add new post!</button></a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
<?php
foreach($data as $post)
{ ?>
<div class="row">
        <h3><?=$post['userName']?></h3>
    </div>
<div class="row">
    <div class="row">
    
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button id="btn<?=$post['post_id']?>" onclick="openImage(<?=$post['post_id']?>)"><img id="img<?=$post['post_id']?>" src="<?=$post['picture']?>" alt="postid<?=$post['post_id']?>" style="width: 100%;"></button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <?php if($post['liked'] == false) : ?>
                <button id="likeButton<?=$post['post_id']?>" type="button" class="btn btn-primary btn-lg" onclick="like(<?=$post['post_id']?>)">LIKE!</button>
            <?php else : ?>
                <button id="likeButton<?=$post['post_id']?>" type="button" class="btn btn-primary btn-lg" onclick="like(<?=$post['post_id']?>)" disabled="true">LIKED</button>
            <?php endif; ?>
        </div>
        <div class="col-lg-3">
            Likes: <div id="likes<?=$post['post_id']?>"><?=$post['likes']?></div>
        </div>
    </div>

</div>
<br><br>

<?php } ?>

</div>

<?php if ((empty($data))) : ?>

    <div class="row" style="margin: auto; text-align: middle; display: none;">
        <form action="/camagru/index.php/blog/gallery" method="GET" style="margin: auto; text-align: middle;">
                <input type="hidden" name="page" value="<?=$page-1?>">
                <button type="submit" class="btn btn-success" id="prevPage">Previous Page</button>
        </form>
        Page <div id="page" style="display: inline;"></div> / <?=$pages?><br>
        <form action="/camagru/index.php/blog/gallery" method="GET" style="margin: auto; text-align: middle;">
                <input type="hidden" name="page" value="<?=$page+1?>">
                <button type="submit" class="btn btn-success" id="nextPage">Next Page</button>
        </form>
    </div>
    <h2>No images yet!</h2>
<?php else :  ?>

    <div class="row" style="margin: auto; text-align: middle;">
        <form action="/camagru/index.php/blog/gallery" method="GET" style="margin: auto; text-align: middle;">
                <input type="hidden" name="page" value="<?=$page-1?>">
                <button type="submit" class="btn btn-success" id="prevPage">Previous Page</button>
        </form>
        Page <div id="page" style="display: inline;"></div> / <?=$pages?><br>
        <form action="/camagru/index.php/blog/gallery" method="GET" style="margin: auto; text-align: middle;">
                <input type="hidden" name="page" value="<?=$page+1?>">
                <button type="submit" class="btn btn-success" id="nextPage">Next Page</button>
        </form>
    </div>

<?php endif ; ?>



    <div id="galleryPreviewBack">
        <div class="container">
            <div class="row" style="margin-top: 100px;">
                <div id="galleryPreviewBox" class="col-xl-5">
                
                    <img src="" width="100%" style="display: none;" id="galleryPreviewImage" postId="">
                    
                </div>
                <div class="col-xl-5" style="width: 100%; background-color: white; opacity: 0.9; margin-bottom: 20px;">
                    <p class="text-monospace" style="text-align: center; height: 10%; margin: 0;">comments</p>
                    <div id="commentSection" style="height: 70%; max-height: 200px; overflow-y: scroll; overflow-wrap: break-word;">

                    </div>
                    <div id="writeComment" style="height: 20%;">
                        <div class="input-group input-group-sm">
                            <input type="hidden" name="csrf" id="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="text" class="form-control" id="commentField" placeholder="Write a comment here" aria-label="" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button" onclick="comment()">Comment!</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2" style="width: 100%; background-color: white; opacity: 0.8;">
                    <p class="text-monospace" style="text-align: center;">likes</p>
                    <div id="likedSection" style="height: 70%; max-height: 200px; overflow-y: scroll; overflow-wrap: break-word;">

                    </div>
                </div>
                <button id="galleryClosePreview" onclick="galleryClosePreview()">X</button>
            </div>

            
        </div>  
    </div>
</div>


<script>
    var currentPage = <?=$page?>+" ";
    var totalPages = <?=$pages?>;
    document.getElementById('page').innerHTML = currentPage;

    previewBack = document.getElementById('galleryPreviewBack');
    previewBox = document.getElementById('galleryPreviewBox');
    previewImage = document.getElementById('galleryPreviewImage');
    commentSection = document.getElementById('commentSection');
    likeSection = document.getElementById('likedSection');

    var comments;
    var imageId;


function openImage(image)
{
    imageId = image;
    //console.log(image);
    previewImage.src = document.getElementById('img' + image).src;

    previewBack.style.display = "flex";
    previewImage.style.display = "block";
    previewImage.setAttribute("postId", image);

    // GET COMMENTS FOR INDIVIDUAL POST

    var ajax = new XMLHttpRequest();
    ajax.open("POST", '/camagru/index.php/ajax/getComments', true);
    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200)
        {
            if (ajax.responseText == "false")
                console.log("failed");
            else
            {
                comments = JSON.parse(ajax.responseText);

                comments.forEach(function(event) {

                    commentSection.innerHTML += "["+event['date_time']+"]";
                    commentSection.innerHTML += "<b>"+event['userName']+"</b> : ";
                    commentSection.innerHTML += event['comment']+"<br>";
                })
                getLikes(image);
            }
                    //console.log(ajax.responseText);

        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("postId=" + image);
/*
    // GET LIKES FOR INDIVIDUAL POST


*/
}

function getLikes(image)
{
    
    var ajax = new XMLHttpRequest();
    ajax.open("POST", '/camagru/index.php/ajax/getLikes', true);
    
    ajax.onreadystatechange = function(){
        
        if (this.readyState == 4 && this.status == 200)
        {
            if (ajax.responseText == "false")
                console.log("failed");
            else
            {
                likes = JSON.parse(ajax.responseText);

                 likes.forEach(function(event) {

                     likeSection.innerHTML += event['userName']+"<br>";
                })

            }
                    //console.log(ajax.responseText);

        }
    
    
}
ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("postId=" + image);
}


function galleryClosePreview()
{
    previewBack.style.display = "none";
    commentSection.innerHTML = "";
    likeSection.innerHTML = "";
    document.getElementById('commentField').value = "";
}

function readComments(comments)
{
    var jes = JSON.parse(comments);
}

function comment()
{
    var comment = document.getElementById('commentField').value;
    var csrf = document.getElementById('csrf').value;
    
    var ajax = new XMLHttpRequest();
    ajax.open("POST", '/camagru/index.php/ajax/comment', true);
    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200)
        {

            if (ajax.responseText == "notLogged")
                alert("you need to log in before commenting or liking images");
            else if (ajax.responseText == "csrf")
                alert("commenting failed: CSRF problem");
            else if (ajax.responseText == "false")
                console.log("failed");
            else
            {
                comment = JSON.parse(ajax.responseText);

                commentSection.innerHTML = comment['comment']+"<br>" + commentSection.innerHTML;
                commentSection.innerHTML = "<b>"+comment['userName']+"</b> : " + commentSection.innerHTML;
                commentSection.innerHTML = "["+comment['date_time']+"]" + commentSection.innerHTML;
                
                
                
            }
        }
    }
    
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("postId=" + imageId + "&comment=" + comment + "&csrf=" + csrf);

        document.getElementById('commentField').value = "";
}

function like(postId)
{
    var likes = document.getElementById('likes'+postId);

    var ajax = new XMLHttpRequest();
    ajax.open("POST", '/camagru/index.php/ajax/like', true);
    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200)
        {
            if (ajax.responseText == "notLogged")
                alert("you need to log in before commenting or liking images");
            else if (ajax.responseText == "alreadyLiked")
                alert("You can only like a post once!");
            else if (ajax.responseText == "success")
            {
                likes.innerHTML = +likes.innerHTML + 1;
                document.getElementById('likeButton' + postId).disabled = true;
                document.getElementById('likeButton' + postId).innerHTML = "LIKED";
            }
            else
                alert(ajax.responseText);
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("postId=" + postId);
}

var buttonPrev = document.getElementById('prevPage');
var buttonNext = document.getElementById('nextPage');


function buttonDisabler()
{
    if (currentPage == 1)
            buttonPrev.disabled = true;
    if (currentPage > 1)
            buttonPrev.disabled = false;
    if (currentPage == totalPages)
            buttonNext.disabled = true;
    if (currentPage < totalPages)
            buttonNext.disabled = false;
}

buttonDisabler();
</script>

<?php include "classes/view/constant/footer.php";