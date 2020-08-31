<?php include "classes/view/constant/header.php";

if ($error == "error")
    echo "<br /><q style='color:red'>Username or email already taken</q>"; 
if ($error == "email")
    echo "<br /><q style='color:red'>Invalid email address</q>"; 
if ($error == "fields")
    echo "<br /><q style='color:red'>fill all fields</q>"; 
?>
<br>


<div class="container">
<h1>Signup!</h1>
    <div class="row">
        <div class="co-xl-12">
            <br>
            <form id="myForm" action="/camagru/index.php/blog/signup" method="POST">
                <div class="form-group">
                    <label for="inputUserName">Username</label>
                    <input name="uname" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputUserPassword">Password</label>
                    <input name="pass" type="text" class="form-control">
                    <div style="background-color: red;" id="error"></div>
                </div>
                <div class="form-group">
                    <label for="inputUserPassword">Email address</label>
                    <input name="email" type="text" class="form-control">
                </div>
                <button type="submit" class="btn btn-outline-dark">Sign up!</button>
            </form>
        </div>
    </div>
</div>

<script>
window.onload = function(){

    var form = document.getElementById("myForm");

    document.getElementById("myForm").onsubmit = function fun(){
        if (form.pass.value.length < 8)
        {
            document.getElementById("error").innerHTML = "Password sould be atleast 8 characters long";

            return false;
        }

    }
}
</script>