<!-- ad-profile-page -->
	<section id="main" class="clearfix  ad-profile-page">
		<div class="container">
		
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li>Ad Post</li>
				</ol><!-- breadcrumb -->						
				<h2 class="title">My Profile</h2>
			</div><!-- banner -->
			
			<div class="ad-profile section">	
				<div class="user-profile">
					<div class="user-images">
						<img src="images/user.jpg" alt="User Images" class="img-responsive">
					</div>
					<div class="user">
						<h2>Hello, <a href="#">Jhon Doe</a></h2>
						<h5>You last logged in at: 14-01-2016 6:40 AM [ USA time (GMT + 6:00hrs)]</h5>
					</div>

					<div class="favorites-user">
						<div class="my-ads">
							<a href="my-ads.html">23<small>My ADS</small></a>
						</div>
						<div class="favorites">
							<a href="#">18<small>Favorites</small></a>
						</div>
					</div>								
				</div><!-- user-profile -->
						
				<ul class="user-menu">
					<li class="active"><a href="my-profile.html">Profile</a></li>
					<li><a href="<?php echo base_url() ?>fronts/ads_post/v_my_ads">My ads</a></li>
					<li><a href="<?php echo base_url() ?>fronts/ads_post/v_favourite_ads">Favourite ads</a></li>
					<li><a href="<?php echo base_url() ?>fronts/ads_post/v_archived_ads">Archived ads </a></li>
					<li><a href="<?php echo base_url() ?>fronts/ads_post/v_pending_ads">Pending approval</a></li>
					<li><a href="<?php echo base_url() ?>fronts/ads_post/v_delete_account">Close account</a></li>
				</ul>
			</div><!-- ad-profile -->

			<div class="profile">
				<div class="row">
					<div class="col-sm-8">
						<div class="user-pro-section">
							<!-- profile-details -->
							<div class="profile-details section">
								<h2>Profile Details</h2>
								<!-- form -->
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" placeholder="Jhon Doe">
								</div>

								<div class="form-group">
									<label>Email ID</label>
									<input type="email" class="form-control" placeholder="jhondoe@mail.com">
								</div>

								<div class="form-group">
									<label for="name-three">Mobile</label>
									<input type="text" class="form-control" placeholder="+213 1234 56789">
								</div>

								<div class="form-group">
									<label>Your City</label>
									<select class="form-control">
										<option value="#">Los Angeles, USA</option>
										<option value="#">Dhaka, BD</option>
										<option value="#">Shanghai</option>
										<option value="#">Karachi</option>
										<option value="#">Beijing</option>
										<option value="#">Lagos</option>
										<option value="#">Delhi</option>
										<option value="#">Tianjin</option>
										<option value="#">Rio de Janeiro</option>
									</select>
								</div>	

								<div class="form-group">
									<label>You are a</label>
									<select class="form-control">
										<option value="#">Dealer</option>
										<option value="#">Individual Seller</option>
									</select>
								</div>					
							</div><!-- profile-details -->

							<!-- change-password -->
							<div class="change-password section">
								<h2>Change password</h2>
								<!-- form -->
								<div class="form-group">
									<label>Old Password</label>
									<input type="password" class="form-control" >
								</div>
								
								<div class="form-group">
									<label>New password</label>
									<input type="password" class="form-control">	
								</div>
								
								<div class="form-group">
									<label>Confirm password</label>
									<input type="password" class="form-control">
								</div>															
							</div><!-- change-password -->
							
							<!-- preferences-settings -->
							<div class="preferences-settings section">
								<h2>Preferences Settings</h2>
								<!-- checkbox -->
								<div class="checkbox">
									<label><input type="checkbox" name="logged"> Comments are enabled on my ads </label>
									<label><input type="checkbox" name="receive"> I want to receive newsletter.</label>
									<label><input type="checkbox" name="want">I want to receive advice on buying and selling. </label>
								</div><!-- checkbox -->						
							</div><!-- preferences-settings -->
							
							<a href="#" class="btn">Update Profile</a>
							<a href="#" class="btn cancle">Cancle</a>
						</div><!-- user-pro-edit -->
					</div><!-- profile -->

					<div class="col-sm-4 text-center">
						<div class="recommended-cta">					
							<div class="cta">
								<!-- single-cta -->						
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-secure">
										<img src="images/icon/13.png" alt="Icon" class="img-responsive">
									</div><!-- cta-icon -->

									<h4>Secure Trading</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
								</div><!-- single-cta -->

								<!-- single-cta -->
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-support">
										<img src="images/icon/14.png" alt="Icon" class="img-responsive">
									</div><!-- cta-icon -->

									<h4>24/7 Support</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
								</div><!-- single-cta -->
							

								<!-- single-cta -->
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-trading">
										<img src="images/icon/15.png" alt="Icon" class="img-responsive">
									</div><!-- cta-icon -->

									<h4>Easy Trading</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
								</div><!-- single-cta -->

								<!-- single-cta -->
								<div class="single-cta">
									<h5>Need Help?</h5>
									<p><span>Give a call on</span><a href="tellto:08048100000"> 08048100000</a></p>
								</div><!-- single-cta -->
							</div>
						</div><!-- cta -->
					</div><!-- recommended-cta-->
				</div><!-- row -->	
			</div>				
		</div><!-- container -->
	</section>
	<!-- ad-profile-page -->