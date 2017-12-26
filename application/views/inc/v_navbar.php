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
					<a class="navbar-brand" href="<?php echo site_url(); ?>"><img class="img-responsive" src="<?php echo base_url(); ?>public/images/logo.png" alt="Logo"></a>
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
							<li class="active dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Pages <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="active"><a href="about-us.html">ABout Us</a></li>
									<li><a href="contact-us.html">Contact Us</a></li>
									<li><a href="ad-post.html">Ad post</a></li>
									<li><a href="ad-post-details.html">Ad post Details</a></li>
									<li><a href="categories-main.html">Category Ads</a></li>
									<li><a href="details.html">Ad Details</a></li>
									<li><a href="my-ads.html">My Ads</a></li>
									<li><a href="my-profile.html">My Profile</a></li>
									<li><a href="favourite-ads.html">Favourite Ads</a></li>
									<li><a href="archived-ads.html">Archived Ads</a></li>
									<li><a href="pending-ads.html">Pending Ads</a></li>
									<li><a href="delete-account.html">Close Account</a></li>
									<li><a href="published.html">Ad Publised</a></li>
									<li><a href="signup.html">Sign Up</a></li>
									<li><a href="signin.html">Sign In</a></li>
									<li><a href="faq.html">FAQ</a></li>	
									<li><a href="coming-soon.html">Coming Soon <span class="badge">New</span></a></li>
									<li><a href="pricing.html">Pricing<span class="badge">New</span></a></li>
									<li><a href="500-page.html">500 Opsss<span class="badge">New</span></a></li>
									<li><a href="404-page.html">404 Error<span class="badge">New</span></a></li>
								</ul>
							</li>
												
						
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
						
						<li><a href="<?php echo site_url(); ?>Register">Register</a></li>

						<li><a href="<?php echo site_url(); ?>login"> Sign In </a></li>
						

					</ul><!-- sign-in -->					

					<a href="<?php echo site_url(); ?>ad" class="btn">Post Your Ad</a>
				</div>
				<!-- nav-right -->
			</div><!-- container -->
		</nav>