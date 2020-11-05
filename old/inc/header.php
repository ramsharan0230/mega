<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.svg" type="image/gif">
    <title>Mega Abroad Study Fair</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <link rel="stylesheet" type="text/css" href="css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">

</head>
<body>
    
    <header id="header">
   
        <div class="container">
            <div class="main-header">
                <a href="index.php" class="logo"><img src="images/logo.svg" alt="logo-image"></a>
                <nav class="navigation">
                    <ul>
                        <li><a href="stall.php">Exhibition Hall</a></li>
                        <li><a href="exhibitors.php">Exhibitors</a></li>
                        <li><a href="scholarship.php">Scholarships</a></li>
                        <li><a type="button" data-toggle="modal" data-target="#myModal">Guide Me</a></li>
                        <li><a href="log-res.php">Log In</a></li>
                        <li><a href="log-res.php">Register</a></li>
                    </ul>
                </nav>
                <div class="top-menu-bar">
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                </div>
            </div>
        </div>
    </header>

    <!-- header section ends -->


    <div class="modal-wrapper">

            <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <div class="modal-body">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    