<nav>
        <div class="logo">
            <div class="logo-text font-family">
                <h2>
                    <a href="user_dashboard.php" class="text-decoration">Library Management System(LMS)</a>
                </h2>
            </div>
        </div>
        <div class="mid-text font-family">

            <span style="color:white;"><strong>Welcome : <?php echo $user_name;?></strong></span>
            <span style="color:white;"><strong>Emaill : <?php echo $user_email;?></strong></span>
        </div>
        <div class="navbar font-family">
            <ul>
            
                <li  class="list font-family" ><div class="dropdown"><button class="dropbtn font-family ">My Profile 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content ">
        <a href="view_profile.php">View Profile</a>
        <a href="edit_profile.php">Edit Profile</a>
        <a href="change_password.php">Change Password</a>
    </div></li>
    <li class="list"><a href="logout.php" class="text-decoration">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="navbar1 row">
        <ul class="row">
            <li><a href="User_dashboard.php">Home</a></li>
            <li><a href="All_books.php">Books</a></li>
            <li><a href="service.php">Service</a></li>
            <li><a href="library_event.php">Message Box</a></li>
        </ul>

    </div>
    <br>
    <span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
    </span>
    <br><br>