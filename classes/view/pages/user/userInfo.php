<?php include "classes/view/constant/header.php";

if (!isset($data['userProfileImage']))
    $image = '/camagru/images/profile/default.jpg';
else
    $image = '/camagru/images/profile/'. $data['userProfileImage'];

$_SESSION['csrf'] = rand(4000, 80000);

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


<div id="ajaxResponse" ></div>
<br>
<button class="btn btn-primary" onclick="askAdmin('<?=$_SESSION['user']?>')">Are you admin?</button>
<br><br>

<div id="changeMessage" class="bg-success text-white"></div>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <p class="text-monospace" style="text-align: center; height: 10%; margin: 0;">change user info</p><br>
            <form id="changeInfo">
                <input type="hidden" value="<?=$_SESSION['csrf']?>" name="csrf">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">First Name</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="inputFirst" value="<?=$data['userFirstName']?>" required>
                        <div class="bg-danger" id="firstNameError"></div>
                    </div>
                    
                </div>
                
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Last Name</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="inputLast" value="<?=$data['userLastName']?>">
                        <div class="bg-danger" id="lastNameError"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="inputEmail" value="<?=$data['userEmail']?>">
                        <div class="bg-danger" id="emailError"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-4">
                        <button class="btn btn-primary" onclick="changeInfo()" type="button">Change!</button>
                    </div>
                </div>

            </form>
                        
            <p class="text-monospace" style="text-align: center; height: 10%; margin: 0;">change password</p><br>
            <form id="changePassword">
                <input type="hidden" value="<?=$_SESSION['csrf']?>" name="csrf">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Old password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="oldPW" required>
                        <div class="bg-danger" id="firstNameError"></div>
                    </div>
                    
                </div>
                
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">New password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="newPW">
                        <div class="bg-danger" id="lastNameError"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">New password again</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="newPW2">
                        <div class="bg-danger" id="emailError"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-4">
                        <button class="btn btn-primary" onclick="changePassword()" type="button">Change password</button>
                    </div>
                </div>

            </form>
                
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" onchange="notifications()" <?=$data['userGetNotif'] == 1 ? 'checked' : ''?>>
                    <label class="custom-control-label" for="customSwitch1">Get email notifications from comments</label>
                </div><br><br><br><br><br><br><br>
         

        </div>
        <div class="col-sm-6">
                <br><br><br><br><br>
                <img src="<?=$image?>" alt="profileImage" class="img-fluid">
                <form id="myForm" action="/camagru/index.php/user/uploadProfilePicture" method="POST" enctype="multipart/form-data">
                
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Upload new profile picture</label>
                        <input type="file" class="form-control-file" name="picture">
                    </div>
                    <input type="submit" value="submit" name="submit" class="btn btn-primary">
                </form>
            
        </div>
    </div>
</div>

<script>

let box = document.getElementById('changeMessage');

var test = "ASD";

    function changeInfo()
    {
        var form = document.forms.changeInfo;
        var firstName = form.inputFirst.value;
        var lastName = form.inputLast.value;
        var email = form.inputEmail.value;
        var csrf = form.csrf.value;
        var error = 0;

     
        if (!firstName || !(/^[a-zA-Z-]+$/.test(firstName)))
        {
            document.getElementById('firstNameError').innerHTML = "Check first name! Only letters..";
            error = 1;
        }
        else
            document.getElementById('firstNameError').innerHTML = "";
        if (!lastName || !(/^[a-zA-Z-]+$/.test(lastName)))
        {
            document.getElementById('lastNameError').innerHTML = "Check last name! Only letters..";
            error = 1;
        }
        else
            document.getElementById('lastNameError').innerHTML = "";
        if (!email || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
        {
            document.getElementById('emailError').innerHTML = "Check email address!";
            error = 1;
        }
        else
            document.getElementById('emailError').innerHTML = "";

        if (error == 1)
            return;


        let box = document.getElementById('changeMessage');

        let fd = new FormData();
        fd.append("firstName", firstName);
        fd.append("lastName", lastName);
        fd.append("email", email);
        fd.append("csrf", csrf);

        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.response == true)
                {
                    box.setAttribute('class', "bg-success text-white");
                    box.innerHTML = "User info changed succesfully";
                }
                else if (this.response == "CSRFerror")
                {
                    box.setAttribute('class', "bg-danger text-white");
                    box.innerHTML = "CSRF error!";
                }
                else
                {
                    box.setAttribute('class', "bg-danger text-white");
                    box.innerHTML = "Check boxes!";
                }

            }
        }
        request.open('POST', '/camagru/index.php/ajax/changeInfo', true);
        request.send(fd)
    }

    function changePassword()
    {
        var pwForm = document.forms.changePassword;
        var oldPW = pwForm.oldPW.value;
        var newPW = pwForm.newPW.value;
        var newPW2 = pwForm.newPW2.value;
        var csrf = pwForm.csrf.value;
        var error = 0;
        

        let pwfd = new FormData();
        pwfd.append("oldPW", oldPW);
        pwfd.append("newPW", newPW);
        pwfd.append("newPW2", newPW2);
        pwfd.append("csrf", csrf);

        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.response == true)
                {
                    box.setAttribute('class', "bg-success text-white");
                    box.innerHTML = "Password changed succesfully!";
                }
                else
                {
                    box.setAttribute('class', "bg-danger text-white");
                    box.innerHTML = this.response;
                }
            }
        }
        request.open('POST', '/camagru/index.php/ajax/changePassword', true);
        request.send(pwfd);
    }

    function notifications()
    {
        var value = document.getElementById('customSwitch1').value;
        if (document.getElementById('customSwitch1').checked == true)
            document.getElementById('customSwitch1').value = "on";
        if (document.getElementById('customSwitch1').checked == false)
            document.getElementById('customSwitch1').value = "off";
        value = document.getElementById('customSwitch1').value;

        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.response != true)
                    alert(this.response);
            }
        }
        request.open('POST', '/camagru/index.php/ajax/changeNotif', true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // MIKSI TAMA ON TASSA PAKOLLINEN????
        request.send("conf=" + value);
        
    }






    function askAdmin(userName)
    {
        let box = document.getElementById('ajaxResponse');
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                box.innerHTML = this.response;
            }
        }
        request.open('get', '/camagru/index.php/ajax/isAdmin', true);
        request.send(userName)
    }
</script>

<?php include "classes/view/constant/footer.php";