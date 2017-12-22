<!-- home-one-info -->
	<section id="home-one-info" class="clearfix home-one">
		<!-- world -->
		<div id="banner-two" class="parallax-section">
			<div class="row text-center">
				<!-- banner -->
				<div class="col-sm-12 ">
					<div class="banner">
						<h1 class="title">World’s Largest Classifieds Portal  </h1>
						<h3>Search from over 15,00,000 classifieds & Post unlimited classifieds free!</h3>
						<!-- banner-form -->
						<div class="banner-form">
							<form action="#">
								<!-- category-change -->
								<div class="dropdown category-dropdown">						
									<a data-toggle="dropdown" href="#"><span class="change-text">Select Category</span> <i class="fa fa-angle-down"></i></a>
									<ul class="dropdown-menu category-change">
										<li><a href="#">Fashion & Beauty</a></li>
										<li><a href="#">Cars & Vehicles</a></li>
										<li><a href="#">Electronics & Gedgets</a></li>
										<li><a href="#">Real Estate</a></li>
										<li><a href="#">Sports & Games</a></li>
									</ul>								
								</div><!-- category-change -->
							
								<input type="text" class="form-control" placeholder="Type Your key word">
								<button type="submit" class="form-control" value="Search">Search</button>
							</form>
						</div><!-- banner-form -->
						
						<!-- banner-socail -->
						<ul class="banner-socail">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-youtube"></i></a></li>
						</ul><!-- banner-socail -->
					</div>
				</div><!-- banner -->
			</div><!-- row -->
		</div><!-- world -->

		<div class="container">
			<!-- category-ad -->
			<?php $this->load->view('index_one/v_icon'); ?>	
			<!-- category-ad -->	
		
			<!-- featureds -->
			<?php $this->load->view('index_one/v_featureda_ads'); ?>
			<!-- featureds -->

			<!-- ad-section -->						
			<div class="ad-section text-center">
				<a href="#"><img src="images/ads/3.jpg" alt="Image" class="img-responsive"></a>
			</div><!-- ad-section -->

			<!-- trending-ads -->
			<?php $this->load->view('index_one/v_trending_ads'); ?>
			<!-- trending-ads -->			

			<!-- cta -->
			<?php $this->load->view('index_one/v_cta'); ?>
			<!-- cta -->											
		</div><!-- container -->
	</section><!-- home-one-info -->