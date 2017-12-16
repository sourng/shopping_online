
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title>Trade | <?php echo $getItem[0]['pro_name']; ?></title>

   <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/icofont.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/owl.carousel.css">  
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/slidr.css">     
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/main.css">  
	<link id="preset" rel="stylesheet" href="<?php echo base_url(); ?>public/css/presets/preset1.css">	
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/responsive.css">
	
	<!-- font -->
	<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet' type='text/css'>

	<!-- icons -->
	<link rel="icon" href="<?php echo base_url(); ?>public/images/ico/favicon.ico">	
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>public/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>public/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>public/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url(); ?>public/images/ico/apple-touch-icon-57-precomposed.png">
    <!-- icons -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Template Developed By ThemeRegion -->
  </head>
  <body>
	<!-- header -->
	<header id="header" class="clearfix">
		<!-- navbar -->
		<?php  $this->load->view('inc/v_navbar'); ?>
		<!-- navbar -->
	</header><!-- header -->

	<!-- main -->
	<section id="main" class="clearfix details-page">
		<div class="container">
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li><a href="#">Electronics & Gedget</a></li>
					<li>Mobile Phone</li>
				</ol><!-- breadcrumb -->						
				<h2 class="title">Mobile Phones</h2>
			</div>
						
			<div class="section banner">				
				<!-- banner-form -->
				<div class="banner-form banner-form-full">
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

						<!-- language-dropdown -->
						<div class="dropdown category-dropdown language-dropdown ">						
							<a data-toggle="dropdown" href="#"><span class="change-text">United Kingdom</span> <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu  language-change">
								<li><a href="#">United Kingdom</a></li>
								<li><a href="#">United States</a></li>
								<li><a href="#">China</a></li>
								<li><a href="#">Russia</a></li>
							</ul>								
						</div><!-- language-dropdown -->
					
						<input type="text" class="form-control" placeholder="Type Your key word">
						<button type="submit" class="form-control" value="Search">Search</button>
					</form>
				</div><!-- banner-form -->
			</div><!-- banner -->
	

			<div class="section slider">					
				<div class="row">
					<!-- carousel -->
					<div class="col-md-7">
						<div id="product-carousel" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<li data-target="#product-carousel" data-slide-to="0" class="active">
									<img src="<?php echo base_url(); ?>public/images/slider/list-1.jpg" alt="Carousel Thumb" class="img-responsive">
								</li>
								<li data-target="#product-carousel" data-slide-to="1">
									<img src="<?php echo base_url(); ?>public/images/slider/list-2.jpg" alt="Carousel Thumb" class="img-responsive">
								</li>
								<li data-target="#product-carousel" data-slide-to="2">
									<img src="<?php echo base_url(); ?>public/images/slider/list-3.jpg" alt="Carousel Thumb" class="img-responsive">
								</li>
								<li data-target="#product-carousel" data-slide-to="3">
									<img src="<?php echo base_url(); ?>public/images/slider/list-4.jpg" alt="Carousel Thumb" class="img-responsive">
								</li>
								<li data-target="#product-carousel" data-slide-to="4">
									<img src="<?php echo base_url(); ?>public/images/slider/list-5.jpg" alt="Carousel Thumb" class="img-responsive">
								</li>
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
								<!-- item -->
								<div class="item active">
									<div class="carousel-image">
										<!-- image-wrapper -->
										<img src="<?php echo base_url(); ?>public/images/slider/1.jpg" alt="Featured Image" class="img-responsive">
									</div>
								</div><!-- item -->

								<!-- item -->
								<div class="item">
									<div class="carousel-image">
										<!-- image-wrapper -->
										<img src="<?php echo base_url(); ?>public/images/slider/2.jpg" alt="Featured Image" class="img-responsive">
									</div>
								</div><!-- item -->

								<!-- item -->
								<div class="item">
									<div class="carousel-image">
										<!-- image-wrapper -->
										<img src="<?php echo base_url(); ?>public/images/slider/3.jpg" alt="Featured Image" class="img-responsive">
									</div>
								</div><!-- item -->

								<!-- item -->
								<div class="item">
									<div class="carousel-image">
										<!-- image-wrapper -->
										<img src="<?php echo base_url(); ?>public/images/slider/4.jpg" alt="Featured Image" class="img-responsive">
									</div>
								</div><!-- item -->

								<!-- item -->
								<div class="item">
									<div class="carousel-image">
										<!-- image-wrapper -->
										<img src="<?php echo base_url(); ?>public/images/slider/5.jpg" alt="Featured Image" class="img-responsive">
									</div>
								</div><!-- item -->
							</div><!-- carousel-inner -->

							<!-- Controls -->
							<a class="left carousel-control" href="#product-carousel" role="button" data-slide="prev">
								<i class="fa fa-chevron-left"></i>
							</a>
							<a class="right carousel-control" href="#product-carousel" role="button" data-slide="next">
								<i class="fa fa-chevron-right"></i>
							</a><!-- Controls -->
						</div>
					</div><!-- Controls -->	

					<!-- slider-text -->
					<div class="col-md-5">
						<div class="slider-text">
							<h2>$<?php echo $getItem[0]['pro_sell_price']; ?></h2>
							<h3 class="title"><?php echo $getItem[0]['pro_name']; ?></h3>
							<p><span>Offered by: <a href="<?php echo site_url(); ?>categories/details">Yury Corporation</a></span>
							<span> Ad ID:<a href="#" class="time"> <?php echo $getItem[0]['ads_id']; ?></a></span></p>
							<span class="icon"><i class="fa fa-clock-o"></i><a href="#"><?php echo $getItem[0]['post_date']; ?></a></span>
							<span class="icon"><i class="fa fa-map-marker"></i><a href="#">Los Angeles, USA</a></span>
							<span class="icon"><i class="fa fa-suitcase online"></i><a href="#">Dealer <strong>(online)</strong></a></span>
							
							<!-- short-info -->
							<div class="short-info">
								<h4>Short Info</h4>
								<p><strong>Condition: </strong><a href="#">New</a> </p>
								<p><strong>Brand: </strong><a href="#">Apple</a> </p>
								<p><strong>Features: </strong><a href="#">Camera,</a> <a href="#">Dual SIM,</a> <a href="#">GSM,</a> <a href="#">Touch screen</a> </p>
								<p><strong>Model: </strong><a href="#">iPhone 6</a></p>
							</div><!-- short-info -->
							
							<!-- contact-with -->
							<div class="contact-with">
								<h4>Contact with </h4>
								<span class="btn btn-red show-number">
									<i class="fa fa-phone-square"></i>
									<span class="hide-text">Click to show phone number </span> 
									<span class="hide-number">012-1234567890</span>
								</span>
								<a href="#" class="btn"><i class="fa fa-envelope-square"></i>Reply by email</a>
							</div><!-- contact-with -->
							
							<!-- social-links -->
							<div class="social-links">
								<h4>Share this ad</h4>
								<ul class="list-inline">
									<li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
									<li><a href="#"><i class="fa fa-pinterest-square"></i></a></li>
									<li><a href="#"><i class="fa fa-tumblr-square"></i></a></li>
								</ul>
							</div><!-- social-links -->						
						</div>
					</div><!-- slider-text -->				
				</div>				
			</div><!-- slider -->

			<div class="description-info">
				<div class="row">
					<!-- description -->
					<div class="col-md-8">
						<div class="description">
							<h4>Description</h4>
							<?php 
								echo $getItem[0]['pro_description']; 
							?>
						</div>
					</div><!-- description -->

					<!-- description-short-info -->
					<div class="col-md-4">					
						<div class="short-info">
							<h4>Short Info</h4>
							<!-- social-icon -->
							<ul>
								<li><i class="fa fa-shopping-cart"></i><a href="#">Delivery: Meet in person</a></li>
								<li><i class="fa fa-user-plus"></i><a href="#">More ads by <span>Yury Corporation</span></a></li>
								<li><i class="fa fa-print"></i><a href="#">Print this ad</a></li>
								<li><i class="fa fa-reply"></i><a href="#">Send to a friend</a></li>
								<li><i class="fa fa-heart-o"></i><a href="#">Save ad as Favorite</a></li>
								<li><i class="fa fa-exclamation-triangle"></i><a href="#">Report this ad</a></li>
							</ul><!-- social-icon -->
						</div>
					</div>
				</div><!-- row -->
			</div><!-- description-info -->	
			
			<div class="recommended-info">
				<div class="row">
					<div class="col-sm-8">				
						<div class="section recommended-ads">
							<div class="featured-top">
								<h4>Recommended Ads for You</h4>
							</div>
							<!-- ad-item -->
							<div class="ad-item row">
								<!-- item-image -->
								<div class="item-image-box col-sm-4">
									<div class="item-image">
										<a href="details.html"><img src="<?php echo base_url(); ?>public/images/trending/1.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div>								
								
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$800.00</h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>categories/details">Apple TV - Everything you need to know!</a></h4>
										<div class="item-cat">
											<span><a href="#">Electronics & Gedgets</a></span> /
											<span><a href="#">Tv & Video</a></span>
										</div>										
									</div><!-- ad-info -->
									
									<!-- ad-meta -->
									<div class="ad-meta">
										<div class="meta-content">
											<span class="dated"><a href="#">7 Jan, 16  10:10 pm </a></span>
											<a href="#" class="tag"><i class="fa fa-tags"></i> New</a>
										</div>										
										<!-- item-info-right -->
										<div class="user-option pull-right">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Los Angeles, USA"><i class="fa fa-map-marker"></i> </a>
											<a class="online" href="#" data-toggle="tooltip" data-placement="top" title="Individual"><i class="fa fa-user"></i> </a>
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->

							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>categories/details"><img src="<?php echo base_url(); ?>public/images/trending/2.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$250.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>categories/details">Bark Furniture, Handmade Bespoke Furniture</a></h4>
										<div class="item-cat">
											<span><a href="#">Home Appliances</a></span> /
											<span><a href="#">Sofa</a></span>
										</div>										
									</div><!-- ad-info -->
									
									<!-- ad-meta -->
									<div class="ad-meta">
										<div class="meta-content">
											<span class="dated"><a href="#">7 Jan, 16  10:10 pm </a></span>
											<a href="#" class="tag"><i class="fa fa-tags"></i> Used</a>
										</div>									
										<!-- item-info-right -->
										<div class="user-option pull-right">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Los Angeles, USA"><i class="fa fa-map-marker"></i> </a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Individual"><i class="fa fa-user"></i> </a>
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->
							
							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>categories/details"><img src="<?php echo base_url(); ?>public/images/trending/3.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>categories/details">Samsung Galaxy S6 Edge</a></h4>
										<div class="item-cat">
											<span><a href="#">Electronics & Gedgets</a></span> /
											<span><a href="#">Mobile Phone</a></span>
										</div>										
									</div><!-- ad-info -->									
																	
									<!-- ad-meta -->
									<div class="ad-meta">
										<div class="meta-content">
											<span class="dated"><a href="#">7 Jan, 16  10:10 pm </a></span>
											<a href="#" class="tag"><i class="fa fa-tags"></i> Used</a>
										</div>									
										<!-- item-info-right -->
										<div class="user-option pull-right">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Los Angeles, USA"><i class="fa fa-map-marker"></i> </a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Dealer"><i class="fa fa-suitcase"></i> </a>
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->	
							
							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>categories/details"><img src="<?php echo base_url(); ?>public/images/trending/4.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$800.00</h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>categories/details">Rick Morton- Magicius Chase</a></h4>
										<div class="item-cat">
											<span><a href="#">Books & Magazines</a></span> /
											<span><a href="#">Story book</a></span>
										</div>										
									</div><!-- ad-info -->
																		
									<!-- ad-meta -->
									<div class="ad-meta">
										<div class="meta-content">
											<span class="dated"><a href="#">7 Jan, 16  10:10 pm </a></span>
											<a href="#" class="tag"><i class="fa fa-tags"></i> Used</a>
										</div>									
										<!-- item-info-right -->
										<div class="user-option pull-right">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Los Angeles, USA"><i class="fa fa-map-marker"></i> </a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Individual"><i class="fa fa-user"></i> </a>
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->
						</div>
					</div><!-- recommended-ads -->

					<div class="col-sm-4 text-center">
						<div class="recommended-cta">					
							<div class="cta">
								<!-- single-cta -->						
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-secure">
										<img src="<?php echo base_url(); ?>public/images/icon/13.png" alt="Icon" class="img-responsive">
									</div><!-- cta-icon -->

									<h4>Secure Trading</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
								</div><!-- single-cta -->
								
								<!-- single-cta -->
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-support">
										<img src="<?php echo base_url(); ?>public/images/icon/14.png" alt="Icon" class="img-responsive">
									</div><!-- cta-icon -->

									<h4>24/7 Support</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
								</div><!-- single-cta -->
							

								<!-- single-cta -->
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-trading" >
										<img src="<?php echo base_url(); ?>public/images/icon/15.png" alt="Icon" class="img-responsive">
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
			</div><!-- recommended-info -->
		</div><!-- container -->
	</section><!-- main -->
	
	<!-- download -->
	<?php $this->load->view('inc/v_download'); ?>
	
	<!-- download -->
	
	<!-- footer -->
	<?php $this->load->view('inc/v_footer'); ?>
	<!-- footer -->

   	<!--/Preset Style Chooser--> 
	<div class="style-chooser">
		<div class="style-chooser-inner">
			<a href="#" class="toggler"><i class="fa fa-life-ring fa-spin"></i></a>
			<h4>Presets</h4>
			<ul class="preset-list clearfix">
				<li class="preset1 active" data-preset="1"><a href="#" data-color="preset1"></a></li>
				<li class="preset2" data-preset="2"><a href="#" data-color="preset2"></a></li>
				<li class="preset3" data-preset="3"><a href="#" data-color="preset3"></a></li>        
				<li class="preset4" data-preset="4"><a href="#" data-color="preset4"></a></li>
			</ul>
		</div>
	</div>
	<!--/End:Preset Style Chooser-->
	
     <!-- JS -->
    <script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/modernizr.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="<?php echo base_url(); ?>public/js/gmaps.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/smoothscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/scrollup.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/price-range.js"></script>
    <script src="<?php echo base_url(); ?>public/js/jquery.countdown.js"></script>    
    <script src="<?php echo base_url(); ?>public/js/custom.js"></script>
	<script src="<?php echo base_url(); ?>public/js/switcher.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-73239902-1', 'auto');
	  ga('send', 'pageview');

	</script>
  </body>
</html>