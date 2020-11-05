<?php require ('inc/header.php') ?>



<link rel="stylesheet" type="text/css" href="css/inner.css">



<section class="log-res-page">
    <div class="container">
        <div class="log-res-wrapper all-sec-padding">
            <form action="" class="login-side" method="post" autocomplete="off">
                <h3>Log In</h3>
                <p>Enter Email & Password</p>
                <input type="email" placeholder="email" autocomplete="false" >
                <input type="password" placeholder="password" autocomplete="false"> 
                <a href="#">Forgot your password?</a>
                <button class="btn log-res-btn">Login</button>
            </form>
            <form class=" register-side" action=""  method="post" autocomplete="off">
                <h3>Not Registered?</h3>
                <p>Fill the below form to process (all fields are mandatory)</p>
                <input type="email" placeholder="Email Address">
                <input type="password" placeholder="Password">
                <input type="password" placeholder="Re-Type Password">
                <input type="text" placeholder="Full Name">
                <input type="text" placeholder="Address">
                <input type="text" placeholder="Mobile No">
                <select name="" id="" class="selectpicker">
                    <option value="1">Academic Qualification</option>
                </select>
                <div class="input-select-wrapper">
                    <input type="text" placeholder="Percentage/GPA">
                    <select name="Passed Year" id="" class="selectpicker">
                        <option value="1">Passed Year</option>
                    </select>
                </div>
                <div class="input-select-wrapper">
                    <input type="text" placeholder="Interested Country">
                    <input type="text" placeholder="Interested Course">
                </div>
                <select name="" id="" class="selectpicker">
                    <option value="1">Attended any of the following English Proficiency Tests?</option>
                </select>
                <button class="btn log-res-btn">register</button>
            </form>
        </div>
    </div>
</section>





<?php require ('inc/footer.php') ?>