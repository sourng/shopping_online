
	<!--head-->
		<?php $this->load->view('layouts/v_home_head');?>
	<!--End-head-->
  <body>
	
		<?php $this->load->view('inc/v_navbar');?>	
	<!-- main -->
	<section id="main" class="clearfix ad-details-page">
		<div class="container">
		
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="<?echo site_url();?>">Home</a></li>
					<li>Ad Post</li>
				</ol><!-- breadcrumb -->						
				<h2 class="title">Mobile Phones</h2>
			</div><!-- banner -->

			<div class="adpost-details">
				<div class="row">	
					<div class="col-md-8">
						<form action="#">
							<fieldset>
								<div class="section postdetails">
									<h4>Sell an item or service <span class="pull-right">* Mandatory Fields</span></h4>
									<div class="form-group selected-product">
										<ul class="select-category list-inline">
											<li>
												<a href="ad-post.html">
													<span class="select">
														<img src="<?php echo base_url();?>public/images/icon/2.png" alt="Images" class="img-responsive">
													</span>
													Electronics & Gedgets
												</a>
											</li>

											<li class="active">
												<a href="#">Phablet & Tablets</a>
											</li>
										</ul>
										<a class="edit" href="#"><i class="fa fa-pencil"></i>Edit</a>
									</div>
									<div class="row form-group">
										<label class="col-sm-3">Type of ad<span class="required">*</span></label>
										<div class="col-sm-9 user-type">
											<input type="radio" name="sellType" value="newsell" id="newsell"> <label for="newsell">I want to sell </label>
											<input type="radio" name="sellType" value="newbuy" id="newbuy"> <label for="newbuy">want to buy</label>	
											<input type="radio" name="sellType" value="newrent" id="newrent"> <label for="newrent">want to rent</label>	
										</div>
									</div>
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Title for your Ad<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="text" placeholder="ex, Sony Xperia dual sim 100% brand new ">
										</div>
									</div>
									<div class="row form-group add-image">
										<label class="col-sm-3 label-title">Photos for your ad <span>(This will be your cover photo )</span> </label>
										<div class="col-sm-9">
											<h5><i class="fa fa-upload" aria-hidden="true"></i>Select Files to Upload / Drag and Drop Files <span>You can add multiple images.</span></h5>
											<div class="upload-section">
												<label class="upload-image" for="upload-image-one">
													<input type="file" id="upload-image-one">
												</label>										

												<label class="upload-image" for="upload-image-two">
													<input type="file" id="upload-image-two">
												</label>											
												<label class="upload-image" for="upload-image-three">
													<input type="file" id="upload-image-three">
												</label>										

												<label class="upload-image" for="upload-imagefour">
													<input type="file" id="upload-imagefour">
												</label>
											</div>	
										</div>
									</div>
									<div class="row form-group select-condition">
										<label class="col-sm-3">Condition<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="radio" name="itemCon" value="new" id="new"> 
											<label for="new">New</label>
											<input type="radio" name="itemCon" value="used" id="used"> 
											<label for="used">Used</label>
										</div>
									</div>
									<div class="row form-group select-price">
										<label class="col-sm-3 label-title">Price<span class="required">*</span></label>
										<div class="col-sm-9">
											<label>$USD</label>
											<input type="text" class="form-control" id="text1">
											<input type="radio" name="price" value="negotiable" id="negotiable">
											<label for="negotiable">Negotiable </label>
										</div>
									</div>
									<div class="row form-group brand-name">
										<label class="col-sm-3 label-title">Brand Name<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" placeholder="ex, Sony Xperia">
										</div>
									</div>
									<div class="row form-group additional">
										<label class="col-sm-3 label-title">Additional<span class="required">*</span></label>
										<div class="col-sm-9">
											<div class="checkbox">
												<label for="camera"><input type="checkbox" name="camera" id="camera"> Camera</label>
												<label for="dual-sim"><input type="checkbox" name="dual-sim" id="dual-sim"> Dual SIM</label>
												<label for="keyboard"><input type="checkbox" name="keyboard" id="keyboard">  Physical keyboard</label>
												<label for="3g"><input type="checkbox" name="3g" id="3g"> 3G</label>

												<label for="gsm"><input type="checkbox" name="gsm" id="gsm"> GSM</label>

												<label for="screen"><input type="checkbox" name="screen" id="screen"> Touch screen</label>
											</div>
										</div>
									</div>
									
									<div class="row form-group model-name">
										<label class="col-sm-3 label-title">Model</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="model" placeholder="ex, Sony Xperia dual sim 100% brand new ">	
										</div>
									</div>
									
									<div class="row form-group item-description">
										<label class="col-sm-3 label-title">Description<span class="required">*</span></label>
										<div class="col-sm-9">
											<textarea class="form-control" id="textarea" placeholder="Write few lines about your products" rows="8"></textarea>		
										</div>
									</div>
									<div class="row">
										<div class="col-sm-9 col-sm-offset-3">
											<p>5000 characters left</p>
										</div>
									</div>								
								</div><!-- section -->
								
								<div class="section seller-info">
									<h4>Seller Information</h4>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Condition<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="radio" name="sellerType" value="individual" id="individual">
											<label for="individual">Individual</label>
											<input type="radio" name="sellerType" value="dealer" id="dealer"> 
											<label for="dealer">Dealer</label>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Your Name<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="name" class="form-control" placeholder="ex, Jhon Doe">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Your Email ID<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="email" name="email" class="form-control" placeholder="ex, jhondoe@mail.com">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Mobile Number<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="mobileNumber" class="form-control" placeholder="ex, +912457895">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Address</label>
										<div class="col-sm-9">
											<input type="text" name="address" class="form-control" placeholder="ex, alekdera House, coprotec, usa">
										</div>
									</div>
								</div><!-- section -->
								
								<div class="section">
									<h4>Make your Ad Premium </h4>
									<p>More replies means more interested buyers. With lots of interested buyers, you have a better chance of selling for the price that you want. <a href="#">Learn more</a></p>
									<ul class="premium-options">
										<li class="premium">
											<input type="radio" name="premiumOption" value="day-one" id="day-one">
											<label for="day-one">Regular Ad Per Day</label>
											<span>$20.00</span>
										</li>
										<li class="premium">
											<input type="radio" name="premiumOption" value="day-two" id="day-two">
											<label for="day-two">Top Ad for 3 days</label>
											<span>$30.00</span>
										</li>
										<li class="premium">
											<input type="radio" name="premiumOption" value="day-three" id="day-three">
											<label for="day-three">Top Ad for 7 days</label>
											<span>$50.00</span>
										</li>
										<li class="premium">
											<input type="radio" name="premiumOption" value="day-four" id="day-four">
											<label for="day-four">Daily Bump Up for 7 days</label>
											<span>$100.00</span>
										</li>								
									</ul>
								</div><!-- section -->
								
								<div class="checkbox section agreement">
									<label for="send">
										<input type="checkbox" name="send" id="send">
										Send me Trade Email/SMS Alerts for people looking to buy mobile handsets in www By clicking "Post", you agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and acknowledge that you are the rightful owner of this item and using Trade to find a genuine buyer.
									</label>
									<button type="submit" class="btn btn-primary">Post Your Ad</button>
								</div><!-- section -->
								
							</fieldset>
						</form><!-- form -->	
					</div>
				

					<!-- quick-rules -->	
					<div class="col-md-4">
						<div class="section quick-rules">
							<h4>Quick rules</h4>
							<p class="lead">Posting an ad on <a href="#">Trade.com</a> is free! However, all ads must follow our rules:</p>

							<ul>
								<li>Make sure you post in the correct category.</li>
								<li>Do not post the same ad more than once or repost an ad within 48 hours.</li>
								<li>Do not upload pictures with watermarks.</li>
								<li>Do not post ads containing multiple items unless it's a package deal.</li>
								<li>Do not put your email or phone numbers in the title or description.</li>
								<li>Make sure you post in the correct category.</li>
								<li>Do not post the same ad more than once or repost an ad within 48 hours.</li>
								<li>Do not upload pictures with watermarks.</li>
								<li>Do not post ads containing multiple items unless it's a package deal.</li>
							</ul>
						</div>
					</div><!-- quick-rules -->	
				</div><!-- photos-ad -->				
			</div>	
		</div><!-- container -->
	</section><!-- main -->
	
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