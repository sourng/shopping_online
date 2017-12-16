<!--head-->
	<?php $this->load->view('layouts/v_home_head'); ?>
<!--End-Head-->
  <body>
	<!-- header -->
		<?php $this->load->view('layouts/v_home_header'); ?>
	<!-- header -->

	<!-- main -->
	<section id="main" class="clearfix category-page main-categories">
		<div class="container">
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li>Electronics & Gedget</li>
				</ol><!-- breadcrumb -->						
				<h2 class="title">Mobile Phones</h2>
			</div>
			<div class="banner">
			
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
			</div>
	
			<div class="category-info">	
				<div class="row">
					<!-- accordion-->
					<div class="col-md-3 col-sm-4">
						<div class="accordion">
							<!-- panel-group -->
							<div class="panel-group" id="accordion">
							 	
								<!-- panel -->
								<div class="panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-one">
											<h4 class="panel-title">All Categories<span class="pull-right"><i class="fa fa-minus"></i></span></h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-one" class="panel-collapse collapse in">
										<!-- panel-body -->
										<div class="panel-body">
											<ul>
												<li><a href="categories.html"><i class="icofont icofont-laptop-alt"></i>Electronics & Gedget<span>(1029)</span></a></li>
												<li><a href="#"><i class="icofont icofont-police-car-alt-2"></i>Cars & Vehicles<span>(1228)</span></a></li>
												<li><a href="#"><i class="icofont icofont-building-alt"></i>Property<span>(178)</span></a></li>
												<li><a href="#"><i class="icofont icofont-ui-home"></i>Home & Garden<span>(7163)</span></a></li>
												<li><a href="#"><i class="icofont icofont-animal-dog"></i>Pets & Animals<span>(8709)</span></a></li>
												<li><a href="#"><i class="icofont icofont-nurse"></i>Health & Beauty<span>(3129)</span></a></li>
												<li><a href="#"><i class="icofont icofont-hockey"></i>Hobby, Sport & Kids<span>(2019)</span></a></li>
												<li><a href="#"><i class="icofont icofont-burger"></i>Food & Agriculture<span>(323)</span></a></li>
												<li><a href="#"><i class="icofont icofont-girl-alt"></i>Women & Children<span>(425)</span></a></li>
												<li><a href="#"><i class="icofont icofont-gift"></i>Gift & Presentation<span>(3223)</span></a></li>
												<li><a href="#"><i class="icofont icofont-architecture-alt"></i>Office Product<span>(3283)</span></a></li>
												<li><a href="#"><i class="icofont icofont-animal-cat-alt-1"></i>Arts, Crafts & Sewing<span>(3221)</span></a></li>
												<li><a href="#"><i class="icofont icofont-abc"></i>Others<span>(3129)</span></a></li>
											</ul>
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-two">
											<h4 class="panel-title">Condition<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-two" class="panel-collapse collapse">
										<!-- panel-body -->
										<div class="panel-body">
											<label for="new"><input type="checkbox" name="new" id="new"> New</label>
											<label for="used"><input type="checkbox" name="used" id="used"> Used</label>
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-three">
											<h4 class="panel-title">
											Price
											<span class="pull-right"><i class="fa fa-plus"></i></span>
											</h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-three" class="panel-collapse collapse">
										<!-- panel-body -->
										<div class="panel-body">
											<div class="price-range"><!--price-range-->
												<div class="price">
													<span>$100 - <strong>$700</strong></span>
													<div class="dropdown category-dropdown pull-right">	
														<a data-toggle="dropdown" href="#"><span class="change-text">USD</span><i class="fa fa-caret-square-o-down"></i></a>
														<ul class="dropdown-menu category-change">
															<li><a href="#">$05</a></li>
															<li><a href="#">$10</a></li>
															<li><a href="#">$15</a></li>
															<li><a href="#">$20</a></li>
															<li><a href="#">$25</a></li>
														</ul>								
													</div><!-- category-change -->													
													 <input type="text"value="" data-slider-min="0" data-slider-max="700" data-slider-step="5" data-slider-value="[250,450]" id="price" ><br />
												</div>
											</div><!--/price-range-->
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-four">
											<h4 class="panel-title">
											Posted By
											<span class="pull-right"><i class="fa fa-plus"></i></span>
											</h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-four" class="panel-collapse collapse">
										<!-- panel-body -->
										<div class="panel-body">
											<label for="individual"><input type="checkbox" name="individual" id="individual"> Individual</label>
											<label for="dealer"><input type="checkbox" name="dealer" id="dealer"> Dealer</label>
											<label for="reseller"><input type="checkbox" name="reseller" id="reseller"> Reseller</label>
											<label for="manufacturer"><input type="checkbox" name="manufacturer" id="manufacturer"> Manufacturer</label>
										</div><!-- panel-body -->
									</div>
								</div><!-- panel -->

								<!-- panel -->
								<div class="panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-five">
											<h4 class="panel-title">
											Brand
											<span class="pull-right"><i class="fa fa-plus"></i></span>
											</h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-five" class="panel-collapse collapse">
										<!-- panel-body -->
										<div class="panel-body">
											<input type="text" placeholder="Search Brand" class="form-control">
											<label for="apple"><input type="checkbox" name="apple" id="apple"> Apple</label>
											<label for="htc"><input type="checkbox" name="htc" id="htc"> HTC</label>
											<label for="micromax"><input type="checkbox" name="micromax" id="micromax"> Micromax</label>
											<label for="nokia"><input type="checkbox" name="nokia" id="nokia"> Nokia</label>
											<label for="others"><input type="checkbox" name="others" id="others"> Others</label>
											<label for="samsung"><input type="checkbox" name="samsung" id="samsung"> Samsung</label>
												<span class="border"></span>
											<label for="acer"><input type="checkbox" name="acer" id="acer"> Acer</label>
											<label for="bird"><input type="checkbox" name="bird" id="bird"> Bird</label>
											<label for="blackberry"><input type="checkbox" name="blackberry" id="blackberry"> Blackberry</label>
											<label for="celkon"><input type="checkbox" name="celkon" id="celkon"> Celkon</label>
											<label for="ericsson"><input type="checkbox" name="ericsson" id="ericsson"> Ericsson</label>
											<label for="fly"><input type="checkbox" name="fly" id="fly"> Fly</label>
											<label for="g-fone"><input type="checkbox" name="g-fone" id="g-fone"> g-Fone</label>
											<label for="gionee"><input type="checkbox" name="gionee" id="gionee"> Gionee</label>
											<label for="haier"><input type="checkbox" name="haier" id="haier"> Haier</label>
											<label for="hp"><input type="checkbox" name="hp" id="hp"> HP</label>

										</div><!-- panel-body -->
									</div>
								</div> <!-- panel -->   
							 </div><!-- panel-group -->
						</div>
					</div><!-- accordion-->

					<!-- recommended-ads -->
					<div class="col-sm-8 col-md-7">				
						<div class="section recommended-ads">
							<!-- featured-top -->
							<div class="featured-top">
								<h4>Recommended Ads for You</h4>
								<div class="dropdown pull-right">
								
								<!-- category-change -->
								<div class="dropdown category-dropdown">
									<h5>Sort by:</h5>						
									<a data-toggle="dropdown" href="#"><span class="change-text">Popular</span><i class="fa fa-caret-square-o-down"></i></a>
									<ul class="dropdown-menu category-change">
										<li><a href="#">Featured</a></li>
										<li><a href="#">Newest</a></li>
										<li><a href="#">All</a></li>
										<li><a href="#">Bestselling</a></li>
									</ul>								
								</div><!-- category-change -->														
								</div>							
							</div><!-- featured-top -->	

							<!-- ad-item -->
							<div class="ad-item row">
								<!-- item-image -->
								<div class="item-image-box col-sm-4">
									<div class="item-image">
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/1.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div>
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$800.00</h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Apple TV - Everything you need to know!</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/trending/2.jpg" alt="Image" class="img-responsive"></a>
										<span class="featured-ad">Featured</span>
										<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$250.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Bark Furniture, Handmade Bespoke Furniture</a></h4>
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
											<a class="online" href="#" data-toggle="tooltip" data-placement="top" title="Dealer"><i class="fa fa-suitcase"></i> </a>											
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->
							
							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/trending/3.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Samsung Galaxy S6 Edge</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/trending/4.jpg" alt="Image" class="img-responsive"></a>
										<span class="featured-ad">Featured</span>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$800.00</h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Rick Morton- Magicius Chase</a></h4>
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
							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/5.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Samsung Slim NoteBook</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/6.jpg" alt="Image" class="img-responsive"></a>
										<span class="featured-ad">Featured</span>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Samsung Galaxy S6 Edge</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/7.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Philips Streo Headphone</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/8.jpg" alt="Image" class="img-responsive"></a>
										<span class="featured-ad">Featured</span>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$800.00</h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Rick Morton- Magicius Chase</a></h4>
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

							<!-- ad-section -->						
							<div class="ad-section text-center">
								<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/3.jpg" alt="Image" class="img-responsive"></a>
							</div><!-- ad-section -->
							
							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/9.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Nikon Disital Camera</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/10.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Samsung Galaxy S6 Edge</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/11.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Samsung Mega Monitor</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/12.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$800.00</h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Cannon Disital Camera</a></h4>
										<div class="item-cat">
											<span><a href="#">Camera & Magazines</a></span> /
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
							<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/13.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Samsung Smart Watch</a></h4>
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
										<a href="<?php echo site_url(); ?>welcome/details"><img src="<?php echo base_url(); ?>public/images/listing/14.jpg" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								<!-- rending-text -->
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>welcome/details">Accer Thinest Laptop</a></h4>
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
											<a href="#" data-toggle="tooltip" data-placement="top" title="Individual"><i class="fa fa-user"></i> </a>											
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->	
							
							<!-- pagination  -->
							<div class="text-center">
								<ul class="pagination ">
									<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
									<li><a href="#">1</a></li>
									<li class="active"><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">5</a></li>
									<li><a>...</a></li>
									<li><a href="#">10</a></li>
									<li><a href="#">20</a></li>
									<li><a href="#">30</a></li>
									<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>			
								</ul>
							</div><!-- pagination  -->					
						</div>
					</div><!-- recommended-ads -->

					<div class="col-md-2 hidden-xs hidden-sm">
						<div class="advertisement text-center">
							<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/2.jpg" alt="" class="img-responsive"></a>
						</div>
					</div>
				</div>	
			</div>
		</div><!-- container -->
	</section>
	<!-- main -->
	
	
	<section id="something-sell" class="clearfix parallax-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="title">Do you have something-sell?</h2>
					<h4>Post your ad for free on Trade.com</h4>
					<a href="ad-post.html" class="btn btn-primary">Post Your Ad</a>
				</div>
			</div><!-- row -->
		</div><!-- contaioner -->
	</section><!-- something-sell -->
	
	<!-- footer -->
		<?php $this->load->view('layouts/v_home_footer'); ?>
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