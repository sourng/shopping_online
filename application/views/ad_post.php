
	<!--head-->
		<?php $this->load->view('layouts/v_home_head');?>
	<!--End-head-->
  <body>
	<!-- header -->
	<!-- header -->
		<?php $this->load->view('layouts/v_home_header');?>
	<!-- header -->

	<!-- post-page -->
	<section id="main" class="clearfix ad-post-page">
		<div class="container">

			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li>Ad Post</li>
				</ol><!-- breadcrumb -->						
				<h2 class="title">Post Free Ad</h2>
			</div><!-- banner -->

				
				
			<div id="ad-post">
				<div class="row category-tab">	
					<div class="col-md-4 col-sm-6">
						<div class="section cat-option select-category post-option">
							<h4>Select a subcategory</h4>
							<ul role="tablist">
								
								<?php 
									for($i=1;$i<=4;$i++){
										?>
									<li class="active link-active"><a href="#cat<?php echo $i ;?>" aria-controls="cat<?php echo $i ;?>" role="tab" data-toggle="tab">
									<span class="select">
										<img src="<?php echo base_url(); ?>public/images/icon/1.png" alt="Images" class="img-">
									</span>
									Cars & Vehicles
								</a></li>


								
										<?php
									}
								?>

							
								
								
							</ul>
						</div>
					</div>
					
					<!-- Tab panes -->
					<div class="col-md-4 col-sm-6">
						<div class="section tab-content subcategory post-option">
							<h4>Select a subcategory</h4>
							<div role="tabpanel" class="tab-pane" id="cat1">
								<ul>
									<li><a href="javascript:void(0)">Cars & Buses</a></li>
									<li><a href="javascript:void(0)">Motorbikes & Scooters</a></li>
									<li><a href="javascript:void(0)">Bicycles and Three Wheelers</a></li>
									<li><a href="javascript:void(0)">Three Wheelers</a></li>
									<li><a href="javascript:void(0)">Trucks, Vans & Buses</a></li>
									<li><a href="javascript:void(0)">Tractors & Heavy-Duty</a></li>
									<li><a href="javascript:void(0)">Auto Parts & Accessories</a></li>
								</ul>	
							</div>
							<div role="tabpanel" class="tab-pane active" id="cat2">
								<ul>
									<li><a href="javascript:void(0)">Laptop & Computer</a></li>
									<li><a href="javascript:void(0)">Mobile Phones</a></li>
									<li><a href="javascript:void(0)">Phablet & Tablets</a></li>
									<li><a href="javascript:void(0)">Audio & MP</a></li>
									<li><a href="javascript:void(0)">Accessories</a></li>
									<li><a href="javascript:void(0)">Cameras</a></li>
									<li><a href="javascript:void(0)">Mobile Accessories</a></li>
									<li><a href="javascript:void(0)">TV & Video</a></li>
									<li><a href="javascript:void(0)">Other Electronics</a></li>
									<li><a href="javascript:void(0)">TV & Video Accessories</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat3">
								<ul>
									<li><a href="javascript:void(0)">Houses & Plots</a></li>
									<li><a href="javascript:void(0)">Lands & property</a></li>
									<li><a href="javascript:void(0)">Plots & Lands</a></li>
									<li><a href="javascript:void(0)">Apartment</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat4">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat5">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat6">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat7">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat8">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat9">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat10">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
							<div role="tabpanel" class="tab-pane" id="cat11">
								<ul>
									<li><a href="javascript:void(0)">Sub Category Item</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="section next-stap post-option">
							<h2>Post an Ad in just <span>30 seconds</span></h2>
							<p>Please DO NOT post multiple ads for the same items or service. All duplicate, spam and wrongly categorized ads will be deleted.</p>
							<div class="btn-section">
								<a href="<?php echo site_url();?>ad/ad_details" class="btn">Next</a>
								<a href="#" class="btn-info">or Cancle</a>
							</div>
						</div>
					</div><!-- next-stap -->
				</div>

				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<div class="ad-section">
							<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/3.jpg" alt="Image" class="img-responsive"></a>
						</div>
					</div>
				</div><!-- row -->
			</div>				
		</div><!-- container -->
	</section><!-- post-page -->
	
	<!-- footer -->
	<?php $this->load->view('layouts/v_home_footer');?>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/modernizr.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="js/gmaps.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/smoothscroll.min.js"></script>
    <script src="js/scrollup.min.js"></script>
    <script src="js/price-range.js"></script>
    <script src="js/jquery.countdown.js"></script>    
    <script src="js/custom.js"></script>
	<script src="js/switcher.js"></script>
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