<?php include "classes/view/constant/header.php";

if ($error == "error")
    echo "<br /><q style='color:red'>Invalid username/password</q>"; 

if ($error == "confError")
    echo "<br /><q style='color:red'>First confirm your account. Check your Email!</q>"; 
?>
<br>


<div class="container">
<h1>Forgot password?</h1>
<h5>Enter your email, and we will send you a new one</h5>
    <div class="row">
        <div class="co-xl-12">
            <br>
                <div class="form-group">
                    <label for="inputUserName">Email</label>
                    <input name="uname" type="text" class="form-control" id="email">
                </div>

                <button type="submit" class="btn btn-outline-dark" onclick="password()">Get new password</button>

        </div>
    </div>
    <br><br><br>
   
</div>



<script>



    function password()
    {
        var email = document.getElementById('email').value;

        
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.response == true)
                {
                    alert("New password sent to your email.");
                    window.location.replace('camagru/index.php/blog/loginPage');
                }
                else
                {
                    alert("Email not found");
                }
            }
        }
        request.open('post', '/camagru/index.php/ajax/forgot', true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //console.log(email);
        request.send("email=" + email);
        
        //alert("asd");
        //window.location.replace('camagru/index.php');
        //return false;
        
    }
</script>