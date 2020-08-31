<?php include "classes/view/constant/header.php";



?>
<nav class="navbar navbar-expand navbar-light bg-light sticky-top">

<div class="collapse navbar-collapse" id="collapse_target">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a href="/camagru/index.php/user/userHome" class="nav-link">User page</a>
        </li>
        <li class="nav-item">
            <a href="/camagru/index.php/user/images" class="nav-link">My images</a>
        </li>
        <li class="nav-item">
            <a href="/camagru/index.php/user/userInfo" class="nav-link">Change info</a>
        </li>
        <?php if($_SESSION['admin'] == 1) :?>
        <li class="nav-item">
            <a href="/camagru/index.php/blog/adminUsers" class="nav-link">User management</a>
        </li>
        <?php endif;?>

    </ul>
</div>
</nav>
<div class="container">
<?php 
foreach($data as $user)
{
    if (!isset($user['userProfileImage']))
    $image = '/camagru/images/profile/default.jpg';
    else
    $image = '/camagru/images/profile/'. $user['userProfileImage'];
    ?>

    <div class="row" style="border: 1px solid black; margin-top: 15px;">
        <div class="col-sm-1">
            <img src="<?=$image?>" alt="profileImage" class="img-fluid" style="margin-top: 8px;">
        </div>
        <div class="col-sm-3">
            <h1><?=$user['userName']?></h1>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-primary" style="margin-top: 8px;" disabled>Send message</button>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-primary" style="margin-top: 8px;" disabled>Show user info</button>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-danger" style="margin-top: 8px;" disabled>Delete user</button>
        </div>
    </div>
    
    <?php
}
?>
</div>

<!-- BUTTONS DO NOT DO ANYTHING YET -->
<?php include "classes/view/constant/footer.php";