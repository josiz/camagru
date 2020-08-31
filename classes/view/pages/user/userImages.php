<?php include "classes/view/constant/header.php";


    $page = $_GET['page'] ? $_GET['page'] : 1;

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
<div class="row" id="imageContainer">

    <?php
    foreach($data as $image)
    {
    ?>
        <div class="col-md-4" style="min-width: 250px; max-width: 250px; height: 220px; margin: 20px; border: 2px solid black;" id="<?=$image['post_id']?>">
            <img src="<?=$image['picture']?>" style="width: 100%; height: 170px;">
            <?php if ($_SESSION['userid'] == $image['user_id']) : ?>
                <button onclick="removeImage(<?=$image['post_id']?>)" class="btn btn-danger" style="margin: auto; text-align: middle;">Remove</button>
            <?php endif; ?>    
            
        </div>

<?php } ?>


</div>

<?php if ((empty($data))) : ?>

<h3>No images yet!</h3>
<h5>Click <a href="/camagru/index.php/blog/newPicture">here</a> to create one!</h5>
<div class="row" style="margin: auto; text-align: middle; display: none;">
    <form action="/camagru/index.php/user/images" method="GET" style="margin: auto; text-align: middle;">
            <input type="hidden" name="page" value="<?=$page-1?>">
            <button type="submit" class="btn btn-success" id="prevPage">Previous Page</button>
    </form>
    Page <div id="page" style="display: inline;"></div> / <?=$pages?><br>
    <form action="/camagru/index.php/user/images" method="GET" style="margin: auto; text-align: middle;">
            <input type="hidden" name="page" value="<?=$page+1?>">
            <button type="submit" class="btn btn-success" id="nextPage">Next Page</button>
    </form>
</div>

<?php else :  ?>

<div class="row" style="margin: auto; text-align: middle;">
    <form action="/camagru/index.php/user/images" method="GET" style="margin: auto; text-align: middle;">
            <input type="hidden" name="page" value="<?=$page-1?>">
            <button type="submit" class="btn btn-success" id="prevPage">Previous Page</button>
    </form>
    Page <div id="page" style="display: inline;"></div> / <?=$pages?><br>
    <form action="/camagru/index.php/user/images" method="GET" style="margin: auto; text-align: middle;">
            <input type="hidden" name="page" value="<?=$page+1?>">
            <button type="submit" class="btn btn-success" id="nextPage">Next Page</button>
    </form>
</div>

<?php endif ; ?>


<script>


var currentPage = <?=$page?>+" ";
var totalPages = <?=$pages?>;

document.getElementById('page').innerHTML = currentPage;
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

function removeImage(id)
{
    if (!(confirm("Remove image?")))
        return;
    document.getElementById(id).remove();

    const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                
            }
        }
        request.open('post', '/camagru/index.php/ajax/removeImage', true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("postId=" + id)

}

function showImage(id)
{

}



buttonDisabler();
</script>

<?php include "classes/view/constant/footer.php";