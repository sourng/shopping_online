		<nav class="navbar navbar-default">
			<div class="container">
				<!-- navbar-header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html"><img class="img-responsive" src="<?php echo base_url(); ?>public/images/logo.png" alt="Logo"></a>
				</div>
				<!-- /navbar-header -->
				
				<div class="navbar-left">
					<div class="collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav navbar-nav">						
							<li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>
							<li><a href="<?php echo site_url(); ?>categories">Category</a></li>
							<li><a href="<?php echo site_url(); ?>categories/details">all ads</a></li>
							<li><a href="<?php echo site_url(); ?>categories/faq">Help/Support</a></li> 
							<li><a href="<?php echo site_url(); ?>categories/about-us">ABout Us</a></li>
												
						
						</ul>
					</div>
				</div>
				
				<!-- nav-right -->
				<div class="nav-right">
					<!-- language-dropdown -->
					<div class="dropdown language-dropdown">
						<i class="fa fa-globe"></i> 						
						<a data-toggle="dropdown" href="#"><span class="change-text">United Kingdom</span> <i class="fa fa-angle-down"></i></a>
						<ul class="dropdown-menu language-change">
							<li><a href="#">United Kingdom</a></li>
							<li><a href="#">United States</a></li>
							<li><a href="#">China</a></li>
							<li><a href="#">Russia</a></li>
						</ul>								
					</div><!-- language-dropdown -->

					<!-- sign-in -->					
					<ul class="sign-in">
						<li><i class="fa fa-user"></i></li>
						<li><a href="signin.html"> Sign In </a></li>
						<li><a href="signup.html">Register</a></li>
					</ul><!-- sign-in -->					

					<a href="ad-post.html" class="btn">Post Your Ad</a>
				</div>
				<!-- nav-right -->
			</div><!-- container -->
		</nav>