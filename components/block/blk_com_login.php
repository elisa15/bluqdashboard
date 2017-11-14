<style>
body {
	    background: #fff url(images/plant-background.jpg) no-repeat center center;
    background-size: cover;
	font-family: "Lucida Grande", Verdana, sans-serif;
	font-size: 12px;
	color: #323232;
	line-height: 20px;
	-webkit-text-size-adjust: none;
	}
</style>
<div id="hld">
	
		<div class="wrapper">
		

			<div class="block small center login">
			
				
					<div class=" block_login">
                    <div class="animated bounceIn" id="login-logo"></div>
                    <?php
					if($err_msg != '')
					{
					?>
					<div class="message errormsg"><p><?=$err_msg?></p></div>
                    <?php
					}
					?>
					
					<form action="" method="post">
						<p>
							<label>Username:</label> <br />
							<input type="text" class="text" style=" width:310px" name="username" id="username" value="" />
						</p>
						
						<p>
							<label>Password:</label> <br />
							<input type="password" class="text" style=" width:310px" name="password" id="password" value="" />
						</p>
						
						<p>
                        	<input name="action" type="hidden" id="action" value="login" />
                            <input name="token" type="hidden" id="token" value="" />
							
							<input type="checkbox" class="checkbox" checked="checked" id="rememberme" /> <label for="rememberme">Remember me</label>
                            <input type="submit" class="submit login_button" value="Log In" /> &nbsp; 
						</p>
					</form>
					
                   </div>
					
			
								
			</div>
			

		</div>	
		
	</div>
   
<div class="autowide">
	<div class="module">
    <p><img alt="" src="images/ateneo.png"></p>
	</div>
	<div class="module">
		<p><img alt="" src="images/usaid.png"></p>
	</div>
	<div class="module">
		<p class="companylogo"><img alt="" src="images/rti.png"></p>
	</div>
	<div class="module">
    <p class="companylogo"><img alt="" src="images/PPC.png"></p>
	</div>
    <hr>
    <div class="columnsContainer">

	  	<div class="leftColumn">
            <p>Email:info@bluq.tech</br>
            Telephone No.: 426-60011 local 5620</br>
            Mobile No.: 09273152645/09177982379</p>
	  	</div>

	  	<div class="rightColumn">
	  		<h2></h2>

  	</div>
</div>


