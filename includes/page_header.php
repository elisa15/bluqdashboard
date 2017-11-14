<div id="logo">
<img src="images/plainbluQ.png">
</div>
<div id="welcome_box">
	<div class="user">Welcome, <a href="index.php?comp=com_account"><?=USER_FIRST_NAME?></a> 
    <!--dropdown-->
    <div class="dropdown">
      <button onclick="myFunction()" class="dropbtn"><i class="fa fa-user-circle" aria-hidden="true"></i></button>
      <div id="myDropdown" class="dropdown-content show">
        <a href="index.php?comp=com_account">Profile</a>
        <a href="index.php?comp=com_dashboard">Dashboard</a>
        <a href="index.php?comp=com_logout">Logout</a>
      </div>
    </div>
    <!--dropdown end-->

    
    </div>
</div>
