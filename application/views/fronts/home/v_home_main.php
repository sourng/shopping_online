<section id="main" class="clearfix home-default">
		<div class="container">
			<!-- banner -->
			<div class="banner-section text-center">
				<h1 class="title">World's Largest Classifieds Portal </h1>
				<h3>Search from over 15,00,000 classifieds & Post unlimited classifieds free!</h3>
				<!-- banner-form -->
				<div class="banner-form">
					<form action="#">
						<!-- category-change -->
						<div class="dropdown category-dropdown">						
							<a data-toggle="dropdown" href="#"><span class="change-text">Select Category</span> <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu category-change">
								<?php
								foreach($categories as $cat){
									?>
								<li><a href="<?php echo site_url(); ?>categories/find.html/<?php echo $cat['cat_id']; ?>">
								<?php echo $cat['cat_name']; ?>( <span style="color:red;"><?php echo $cat['number']; ?></span>)</a></li>
								<?php
								}  
								?>
							</ul>								
						</div><!-- category-change -->
					
						<input type="text" class="form-control" placeholder="Type Your key word">
						<button type="submit" class="form-control" value="Search">Search</button>
					</form>
				</div><!-- banner-form -->
				
				<!-- banner-socail -->
				<ul class="banner-socail list-inline">
					<li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
					<li><a href="#" title="Youtube"><i class="fa fa-youtube"></i></a></li>
				</ul><!-- banner-socail -->
			</div>
			<!-- banner -->
			
			<!-- main-content -->
			<div class="main-content">
				<!-- row -->
				<div class="row">
					<div class="hidden-xs hidden-sm col-md-2 text-center">
						<div class="advertisement">
							<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/2.jpg" alt="Images" class="img-responsive"></a>
						</div>
					</div>
					
					<!-- product-list -->
					<div class="col-md-8">
						<!-- categorys -->
						<div class="section category-ad text-center">
							<ul class="category-list">

								<?php 
									foreach($categories as $cat){												
									?>
									
									<li class="category-item">
											<a href="<?php echo base_url();?>categories/find.html/<?php echo $cat['cat_id']; ?>">
												<div class="category-icon"><img src="<?php echo base_url(); ?>uploads/category/icons/<?php echo $cat['cat_ico_image']; ?>" alt="images" class="img-responsive"></div>
												<span class="category-title"><?php echo $cat['cat_name']; ?></span>
												<span class="category-quantity">(<?php echo $cat['number']; ?>)</span>
											</a>
										</li><!-- category-item -->

									<?php	
									}											
								?>

				
							</ul>				
						</div><!-- category-ad -->	
						
						<!-- featureds -->
						<div class="section featureds">
							<div class="row">
								<div class="col-sm-12">
									<div class="section-title featured-top">
										<h4>Featured Ads</h4>
									</div>
								</div>
							</div>
							
							<!-- featured-slider -->
							<div class="featured-slider">
								<div id="featured-slider" >				
                                                                
									
									<?php 
                                    foreach($getProducts as $rows){
                                        ?>
                                    <!-- featured -->
									<div class="featured">
										<div class="featured-image">
											<a href="<?php echo site_url(); ?>home/details/<?php echo $rows['product_id']; ?>"><img src="<?php echo base_url(); ?>uploads/product/<?php echo $rows['featured_image']; ?>" alt="" class="img-respocive"></a>
											<a href="<?php echo site_url(); ?>home/details/<?php echo $rows['product_id']; ?>" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
										</div>
										
										<!-- ad-info -->
										<div class="ad-info">
											<h3 class="item-price">$<?php echo $rows['pro_sell_price']; ?></h3>
											<h4 class="item-title"><a href="<?php echo site_url(); ?>home/details/<?php echo $rows['product_id']; ?>"><?php echo $rows['pro_name']; ?></a></h4>
											<div class="item-cat">
												<span><a href="#"><?php echo $rows['cat_name']; ?></a></span> 
											</div>
										</div><!-- ad-info -->
										
										<!-- ad-meta -->
										<div class="ad-meta">
											<div class="meta-content">
												<span class="dated"><a href="#">7 Jan 10:10 pm </a></span>
											</div>									
											<!-- item-info-right -->
											<div class="user-option pull-right">
												<a href="#" data-toggle="tooltip" data-placement="top" title="Los Angeles, USA"><i class="fa fa-map-marker"></i> </a>
												<a href="#" data-toggle="tooltip" data-placement="top" title="Dealer"><i class="fa fa-suitcase"></i> </a>											
											</div><!-- item-info-right -->
										</div><!-- ad-meta -->
									</div>
								<!-- featured -->
								
								<?php
									}
								
								?>                                      
                                                                        
								</div><!-- featured-slider -->
							</div><!-- #featured-slider -->
						</div>
                                                
                                                <!-- featureds -->

						<!-- ad-section -->						
						<div class="ad-section text-center">
							<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/3.jpg" alt="Image" class="img-responsive"></a>
						</div><!-- ad-section -->

						<!-- trending-ads -->
						<div class="section trending-ads">
							<div class="section-title tab-manu">
								<h4>Trending Ads</h4>
								 <!-- Nav tabs -->      
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#recent-ads"  data-toggle="tab">Recent Ads</a></li>
									<li role="presentation"><a href="#popular" data-toggle="tab">Popular Ads</a></li>
									<li role="presentation"><a href="#hot-ads"  data-toggle="tab">Hot Ads</a></li>
								</ul>
							</div>

				  			<!-- Tab panes -->
							<div class="tab-content">
								<!-- tab-pane -->
								<div role="tabpanel" class="tab-pane fade in active" id="recent-ads">
									<!-- ad-item -->
									<div class="ad-item row">
										<!-- item-image -->
										<div class="item-image-box col-sm-4">
											<div class="item-image">
												<a href="<?php echo site_url(); ?>Welcome/details"><img src="<?php echo base_url(); ?>public/images/trending/1.jpg" alt="Image" class="img-responsive"></a>
												<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
											</div>
										<!-- item-image -->
										</div>
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$50.00</h3>
												<h4 class="item-title"><a href="<?php echo site_url(); ?>Welcome/details">Apple TV - Everything you need to know!</a></h4>
												<div class="item-cat">
													<span><a href="#">Electronics & Gedgets</a></span> /
													<span><a href="#">Tv & Video</a></span>
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
												<a href="<?php echo site_url(); ?>home/details"><img src="<?php echo base_url(); ?>public/images/trending/2.jpg" alt="Image" class="img-responsive"></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$250.00 <span>(Negotiable)</span></h3>
												<h4 class="item-title"><a href="<?php echo site_url(); ?>home/details">Bark Furniture, Handmade Bespoke Furniture</a></h4>
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
									</div>
									<!-- ad-item -->


									<!-- ad-item -->
									<div class="ad-item row">
										<div class="item-image-box col-sm-4">
											<!-- item-image -->
											<div class="item-image">
												<a href="<?php echo site_url(); ?>Welcome/details"><img src="<?php echo base_url(); ?>public/images/trending/4.jpg" alt="Image" class="img-responsive"></a>
												<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$800.00</h3>
												<h4 class="item-title"><a href="<?php echo site_url(); ?>Welcome/details">Rick Morton- Magicius Chase</a></h4>
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
												<a href="<?php echo site_url(); ?>Welcome/details"><img src="<?php echo base_url();?>public/images/trending/3.jpg" alt="Image" class="img-responsive"></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
												<h4 class="item-title"><a href="<?php echo site_url(); ?>Welcome/details">Samsung Galaxy S6 Edge</a></h4>
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
									
								</div><!-- tab-pane -->
								
								<!-- tab-pane -->
								<div role="tabpanel" class="tab-pane fade" id="popular">

									<div class="ad-item row">
										<!-- item-image -->
										<div class="item-image-box col-sm-4">
											<div class="item-image">
												<a href="details.html"><img src="<?php echo base_url();?>public/images/trending/1.jpg" alt="Image" class="img-responsive"></a>
												<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
											</div><!-- item-image -->
										</div>
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$50.00</h3>
												<h4 class="item-title"><a href="#">Apple TV - Everything you need to know!</a></h4>
												<div class="item-cat">
													<span><a href="#">Electronics & Gedgets</a></span> /
													<span><a href="#">Tv & Video</a></span>
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
									
									<div class="ad-item row">
										<div class="item-image-box col-sm-4">
											<!-- item-image -->
											<div class="item-image">
												<a href="details.html"><img src="<?php echo base_url();?>public/images/trending/3.jpg" alt="Image" class="img-responsive"></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
												<h4 class="item-title"><a href="#">Samsung Galaxy S6 Edge</a></h4>
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
												<a href="details.html"><img src="<?php echo base_url();?>public/images/trending/2.jpg" alt="Image" class="img-responsive"></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$250.00 <span>(Negotiable)</span></h3>
												<h4 class="item-title"><a href="#">Bark Furniture, Handmade Bespoke Furniture</a></h4>
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
												<a href="details.html"><img src="<?php echo base_url();?>public/images/trending/4.jpg" alt="Image" class="img-responsive"></a>
												<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$800.00</h3>
												<h4 class="item-title"><a href="#">Rick Morton- Magicius Chase</a></h4>
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
								</div><!-- tab-pane -->

								<!-- tab-pane -->
								<div role="tabpanel" class="tab-pane fade" id="hot-ads">
									<!-- ad-item -->
									<div class="ad-item row">
										<!-- item-image -->
										<div class="item-image-box col-sm-4">
											<div class="item-image">
												<a href="details.html"><img src="<?php echo base_url();?>public/images/trending/1.jpg" alt="Image" class="img-responsive"></a>
												<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
											</div><!-- item-image -->
										</div>
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$50.00</h3>
												<h4 class="item-title"><a href="#">Apple TV - Everything you need to know!</a></h4>
												<div class="item-cat">
													<span><a href="#">Electronics & Gedgets</a></span> /
													<span><a href="#">Tv & Video</a></span>
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
												<a href="details.html"><img src="<?php echo base_url();?>public/images/trending/4.jpg" alt="Image" class="img-responsive"></a>
												<a href="#" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$800.00</h3>
												<h4 class="item-title"><a href="#">Rick Morton- Magicius Chase</a></h4>
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

									<div class="ad-item row">
										<div class="item-image-box col-sm-4">
											<!-- item-image -->
											<div class="item-image">
												<a href="details.html"><img src="<?php echo base_url(); ?>public/images/trending/3.jpg" alt="Image" class="img-responsive"></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- ad-item -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$890.00 <span>(Negotiable)</span></h3>
												<h4 class="item-title"><a href="#">Samsung Galaxy S6 Edge</a></h4>
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
												<a href="details.html"><img src="<?php echo base_url(); ?>public/images/trending/2.jpg" alt="Image" class="img-responsive"></a>
											</div><!-- item-image -->
										</div><!-- item-image-box -->
										
										<!-- rending-text -->
										<div class="item-info col-sm-8">
											<!-- ad-info -->
											<div class="ad-info">
												<h3 class="item-price">$250.00 <span>(Negotiable)</span></h3>
												<h4 class="item-title"><a href="#">Bark Furniture, Handmade Bespoke Furniture</a></h4>
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
								</div><!-- tab-pane -->
							</div>
						</div><!-- trending-ads -->		

						<!-- cta -->
						<div class="section cta text-center">
							<div class="row">
								<!-- single-cta -->
								<div class="col-sm-4">
									<div class="single-cta">
										<!-- cta-icon -->
										<div class="cta-icon icon-secure">
											<img src="<?php echo base_url(); ?>public/images/icon/13.png" alt="Icon" class="img-responsive">
										</div><!-- cta-icon -->

										<h4>Secure Trading</h4>
										<p>Duis autem vel eum iriure dolor in hendrerit in</p>
									</div>
								</div><!-- single-cta -->

								<!-- single-cta -->
								<div class="col-sm-4">
									<div class="single-cta">
										<!-- cta-icon -->
										<div class="cta-icon icon-support">
											<img src="<?php echo base_url(); ?>public/images/icon/14.png" alt="Icon" class="img-responsive">
										</div><!-- cta-icon -->

										<h4>24/7 Support</h4>
										<p>Duis autem vel eum iriure dolor in hendrerit in</p>
									</div>
								</div><!-- single-cta -->

								<!-- single-cta -->
								<div class="col-sm-4">
									<div class="single-cta">
										<!-- cta-icon -->
										<div class="cta-icon icon-trading">
											<img src="<?php echo base_url(); ?>public/images/icon/15.png" alt="Icon" class="img-responsive">
										</div><!-- cta-icon -->

										<h4>Easy Trading</h4>
										<p>Duis autem vel eum iriure dolor in hendrerit in</p>
									</div>
								</div><!-- single-cta -->
							</div><!-- row -->
						</div><!-- cta -->
					</div><!-- product-list -->

					<!-- advertisement -->
					<div class="hidden-xs hidden-sm col-md-2">
						<div class="advertisement text-center">
							<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/1.jpg" alt="Images" class="img-responsive"></a>
						</div>
					</div><!-- advertisement -->
				</div>
				<!-- row -->
			</div>
			<!-- main-content -->
		</div><!-- container -->
	</section>