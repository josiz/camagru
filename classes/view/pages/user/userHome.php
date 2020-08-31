<?php include "classes/view/constant/header.php";


if (!isset($data['userProfileImage']))
    $image = '/camagru/images/profile/default.jpg';
else
    $image = '/camagru/images/profile/'. $data['userProfileImage'];

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
    <div class="row">
        <div class="col-sm-4">
            <h1 style="text-align: center;">Profile picture</h1>
            <img src="<?=$image?>" alt="profileImage" class="img-fluid">

        </div>
        <div class="col-sm-8">
            <h1>User info</h1>
            <div class="row">
                <span class="align-middle"><b>username:   </b> <?=$data['userName']?></span>
            </div>
            <div class="row">
                <span class="align-middle"><b>Email address:   </b> <?=$data['userEmail']?></span>
            </div>
            <div class="row">
                <span class="align-middle"><b>First name:   </b> <?=$data['userFirstName']?></span>
            </div>
            <div class="row">
                <span class="align-middle"><b>Last name:   </b> <?=$data['userLastName']?></span>
            </div>
            <div class="row">
                <span class="align-middle"><b>Register time:   </b> <?=$data['userRegisterTime']?></span>
            </div>
            <?php if ($data['userAdmin'] == 1) : ?>
                <h4>ADMIN</h4>
            <?php endif; ?>
        </div>

    </div>
    <br><br><br>
    <div class="row">
                <button class="btn btn-primary btn-lg" onclick="deleteAccount()">DELETE MY ACCOUNT</button>
    </div>
</div>

<script>
    function deleteAccount()
    {
        if (!(confirm("Do you really want to delete your account?")))
        return;
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                if(this.response == true)
                {
                    window.location.replace('/camagru/index.php');
                }
            }
        }
        request.open('post', '/camagru/index.php/ajax/removeAccount', true);
        request.send();

    }
</script>



<!--<script>

    document.getElementById("menu-toggle").addEventListener("click", function(){
        if (document.querySelector("#sidebar").style.display == "none")
        {
            document.getElementById("menu-toggle").innerHTML = "close";
            document.querySelector("#sidebar").style.display = "flex";
        }
        else
        {
            document.querySelector("#sidebar").style.display = "none";
            document.querySelector("#sidebar").style.textAlign = "center";
            document.getElementById("menu-toggle").innerHTML = "open";
        }
    })

</script>-->

<?php include "classes/view/constant/footer.php";