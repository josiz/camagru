<?php include "classes/view/constant/header.php";

if ($error == "error")
    echo "<br /><q style='color:red'>Invalid username/password</q>"; 

if ($error == "confError")
    echo "<br /><q style='color:red'>First confirm your account. Check your Email!</q>"; 
?>
<br>


<div class="container">
<h1>Login!</h1>
    <div class="row">
        <div class="co-xl-12">
            <br>
            <form id="myForm" action="/camagru/index.php/blog/login" method="POST">
                <div class="form-group">
                    <label for="inputUserName">Username</label>
                    <input name="uname" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputUserPassword">Password</label>
                    <input name="pass" type="text" class="form-control">
                    <div style="background-color: red;" id="error"></div>
                </div>
                <button type="submit" class="btn btn-outline-dark">Login!</button>
            </form>
        </div>
    </div>
    <br><br><br>
    <a href="/camagru/index.php/user/forgot"><div class="row"><button class="btn btn-success" onclick="box()">Forgot password?</button></a></div>
</div>