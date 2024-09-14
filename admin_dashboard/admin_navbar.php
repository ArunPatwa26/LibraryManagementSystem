
<nav>
    <div class="logo">
            <div class="logo-text font-family">
                <h2>
                    <a href="admin_dashboard.php" class="text-decoration">Library Management System(LMS)</a>
                </h2>
            </div>
    </div>
    <div class="mid-text font-family">

            <span style="color:white;"><strong>Welcome : <?php echo $admin_name;?></strong></span>
            <span style="color:white;"><strong>Emaill : <?php echo $admin_email;?></strong></span>
    </div>

    <div class="navbar font-family">
            <ul>
                <li  class="list font-family" ><div class="dropdown"><button class="dropbtn font-family ">My Profile 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content ">
        <a href="view_admin_profile.php">View Profile</a>
        <a href="edit_admin_profile.php">Edit Profile</a>
        <a href="change_admin_password.php">Change Password</a>
    </div></li>
    <li class="list"><a href="logout.php" class="text-decoration">Logout</a></li>
            </ul>
        </div>
</nav>