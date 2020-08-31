<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="/camagru/classes/view/constant/style.css">
    <title>Document</title>
</head>
<body>
    <div class="jumbotron" style="margin-bottom: 0px;">
        <img src="/camagru/images/other/main_logo.png" alt="main_logo">
    </div>
    <!--<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">

        <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapse_target">
            <a href="#" class="navbar-brand">Tähän imagelinkki</a>
            <span class="navbar-text">Firman nimi</span>

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/index" class="nav-link">index</a>
                </li>
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/aboutt" class="nav-link">About</a>
                </li>

            </ul>

        </div>
    </nav>-->


<nav class="navbar navbar-dark bg-dark navbar-expand-md sticky-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
  <a href="/camagru/index.php/blog/index" class="navbar-brand"><img src="/camagru/images/other/main_logo.png" alt="main_logo" style="height: 30px;"></a>


    <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/index" class="nav-link">index</a>
                </li>
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/gallery" class="nav-link">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/aboutt" class="nav-link">About</a>
                </li>

            </ul>

            <ul class="navbar-nav ml-auto">
                <?php if(empty($_SESSION['user'])) : ?>
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/loginPage" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/signupPage" class="nav-link">Sign Up</a>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a href="/camagru/index.php/user/userHome" class="nav-link"><?=$_SESSION['user']?></a>
                </li>
                <li class="nav-item">
                    <a href="/camagru/index.php/blog/logout" class="nav-link">Logout</a>
                </li>
                <?php endif; ?>

            </ul>
  </div>
</nav>



<br><br>


<div class="container">
    <h1 style="text-align: center;">Welcome to camagru!</h1><br><br><br>

    <div class="media">
        <img class="d-flex mr-3" src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
        <div class="media-body">
            <h5 class="mt-0">Take pictures</h5>
            
                    Take pictures with your webcam, or upload images!
            <div class="media mt-3">
                <a class="d-flex pr-3" href="#!">
                    <img src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
                </a>
                <div class="media-body">
                    <h5 class="mt-0">Filters</h5>
                    Choose a sticker to decorate your image.
                </div><br>
            </div>
            <div class="media mt-3">
                <a class="d-flex pr-3" href="#!">
                    <img src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
                </a>
                <div class="media-body">
                    <h5 class="mt-0">Save image</h5>
                    When you take a perfect photo, you can upload it to your gallery.
                </div><br>
            </div>
        </div>
    </div><br><br>
    <div class="media">
        <img class="d-flex mr-3" src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
        <div class="media-body">
            <h5 class="mt-0">View images</h5>
            
                    You can view other users images in the grand gallery.
            <div class="media mt-3">
                <a class="d-flex pr-3" href="#!">
                    <img src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
                </a>
                <div class="media-body">
                    <h5 class="mt-0">Comment</h5>
                    Leave a comment to a image you like.
                </div><br>
            </div>
            <div class="media mt-3">
                <a class="d-flex pr-3" href="#!">
                    <img src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
                </a>
                <div class="media-body">
                    <h5 class="mt-0">Like</h5>
                    Like the images you like.
                </div><br>
            </div>
        </div>
    </div><br><br>
    <div class="media">
        <img class="d-flex mr-3" src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
        <div class="media-body">
            <h5 class="mt-0">Upcoming features</h5>
            
                    Soon camagru will get more features
            <div class="media mt-3">
                <a class="d-flex pr-3" href="#!">
                    <img src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
                </a>
                <div class="media-body">
                    <h5 class="mt-0">Messaging</h5>
                    Send private messages to other users.
                </div><br>
            </div>
            <div class="media mt-3">
                <a class="d-flex pr-3" href="#!">
                    <img src="/camagru/images/other/c.png" alt="Generic placeholder image" style="height: 30px;">
                </a>
                <div class="media-body">
                    <h5 class="mt-0">Profiles</h5>
                    View other users profiles directly.
                </div><br>
            </div>
        </div>
    </div>

<br><br><br>
<div class="row">
    <div class="col-sm-6">
        <blockquote class="blockquote blockquote-reverse">
        <p class="mb-0">The most amazing site I have ever seen</p>
        <footer class="blockquote-footer">Barack Obama
        </footer>
        </blockquote>
    </div>
    <div class="col-sm-6">
        <blockquote class="blockquote blockquote-reverse">
        <p class="mb-0">How is it possible to create somethin this beautiful?</p>
        <footer class="blockquote-footer">Michael Jackson
        </footer>
        </blockquote>
    </div>
</div>
</div>


<script>
let collapseElements = document.querySelectorAll('[data-toggle="collapse"]');
const CLASS_SHOW = 'show';
const CLASS_COLLAPSE = 'collapse';
const CLASS_COLLAPSING = 'collapsing';
const CLASS_COLLAPSED = 'collapsed';
const ANIMATION_TIME = 350; // 0.35s

function handleCollapseElementClick(e) {
    let el = e.currentTarget;
    let collapseTargetId = el.dataset.target || el.href || null;
    if (collapseTargetId) {
        let targetEl = document.querySelector(collapseTargetId);
        let isShown = targetEl.classList.contains(CLASS_SHOW) || targetEl.classList.contains(CLASS_COLLAPSING);
        if(!isShown) {
            targetEl.classList.remove(CLASS_COLLAPSE);
            targetEl.classList.add(CLASS_COLLAPSING);
            targetEl.style.height = 0
            targetEl.classList.remove(CLASS_COLLAPSED);
            setTimeout(() => {
                targetEl.classList.remove(CLASS_COLLAPSING);
                targetEl.classList.add(CLASS_COLLAPSE, CLASS_SHOW);
                targetEl.style.height = '';
            }, ANIMATION_TIME)
            targetEl.style.height = targetEl.scrollHeight + 'px';
        } else {
            targetEl.style.height = `${targetEl.getBoundingClientRect().height}px`
            targetEl.offsetHeight; // force reflow
            targetEl.classList.add(CLASS_COLLAPSING);
            targetEl.classList.remove(CLASS_COLLAPSE, CLASS_SHOW);
            targetEl.style.height = '';
            setTimeout(() => {
                targetEl.classList.remove(CLASS_COLLAPSING);
                targetEl.classList.add(CLASS_COLLAPSE);
            }, ANIMATION_TIME)
        }
    }
}

collapseElements.forEach((el) => {
    el.addEventListener('click', handleCollapseElementClick)
})</script>


<?php include "classes/view/constant/footer.php";