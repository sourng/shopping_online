	<section id="main" class="clearfix details-page">
		<div class="container">
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="<?php echo site_url(); ?>">Home</a></li>
					<li><a href="<?php echo site_url(); ?>categories/find.html/<?php echo $getItem[0]['cat_id']; ?>"><?php echo $this->m_crud->getFieldName('cat_name','categories','cat_id',$getItem[0]['cat_id']); ?></a></li>
					<li><?php echo $this->m_crud->getFieldName('pro_name','products','product_id',$getItem[0]['product_id']); ?></li>
				</ol><!-- breadcrumb -->						
				<h2 class="title"><?php echo $this->m_crud->getFieldName('cat_name','categories','cat_id',$getItem[0]['cat_id']); ?></h2>
			</div>
						
			<div class="section banner">				
				<!-- banner-form -->
				<div class="banner-form banner-form-full">
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

						<!-- language-dropdown -->
						<div class="dropdown category-dropdown language-dropdown ">						
							<a data-toggle="dropdown" href="#"><span class="change-text">United Kingdom</span> <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu  language-change">
								<?php
									foreach($province as $m_pro){
										?>
											<li><a href="#"><?php echo $m_pro['province_name_en'];?></a></li>
										<?php
									}  
								?>
							</ul>								
						</div><!-- language-dropdown -->
					<?php //echo "lang:".$lang; ?>
						<input type="text" class="form-control" placeholder="<?php echo $this->m_crud->get_langs('Type_Your_key_word',$lang); ?>">
						<button type="submit" class="form-control" value="Search"><?php echo $this->m_crud->get_langs('Search',$lang); ?></button>
					</form>
				</div><!-- banner-form -->
			</div><!-- banner -->
	

			<div class="section slider" style="padding: 33px 30px 10%;">					
				<div class="row">
					<!-- carousel -->
					<div class="col-md-7">
						<div id="product-carousel" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
								
								<?php 
								$i=0;
								foreach ($galleries as $row) {								
									
										if($i==0){
											?>
											
											<li data-target="#product-carousel" data-slide-to="<?php echo $i; ?>" class="active">
												<img src="<?php echo base_url(); ?>uploads/product/thumnail/<?php echo  $row['thumnail'] ?>" alt="Carousel Thumb" class="img-responsive">
											</li>
										<?php
										$i=$i+1;
										}else{
											?>
											<li data-target="#product-carousel" data-slide-to="<?php echo $i; ?>" >
												<img src="<?php echo base_url(); ?>uploads/product/thumnail/<?php echo  $row['thumnail'] ?>" alt="Carousel Thumb" class="img-responsive">
											</li>
										<?php
										$i=$i+1;
										}
										
								}												
									
								?>

								
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
								<?php 
								$j=0;
								foreach ($galleries as $row) {									
									if($j==0){
										?>
										<!-- item -->
											<div class="item active">
												<div class="carousel-image">
													<!-- image-wrapper -->
													<img src="<?php echo base_url(); ?>uploads/product/<?php echo $row['image']; ?>" alt="Featured Image" class="img-responsive">
												</div>
											</div><!-- item -->	
										<?php
										$j=$j+1;
									}else{
										?>
										<!-- item -->
										<div class="item">
											<div class="carousel-image">
												<!-- image-wrapper -->
												<img src="<?php echo base_url(); ?>uploads/product/<?php echo $row['image']; ?>" alt="Featured Image" class="img-responsive">
											</div>
										</div><!-- item -->
										<?php
										$j=$j+1;
									}

								}
								?>

															

								


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
								<h4><?php echo $this->m_crud->get_langs('short_info',$lang); ?></h4>
								<p><strong><?php echo $this->m_crud->get_langs('Condition',$lang); ?>: </strong><a href="#">New</a> </p>
								<p><strong><?php echo $this->m_crud->get_langs('Brand',$lang); ?>: </strong>

									<a href="<?php echo site_url(); ?>"><?php echo $getBranch[0]['name'];?></a> 

								</p>

								<p><strong><?php echo $this->m_crud->get_langs('Features',$lang); ?>: </strong>
									<!-- <a href="#">Camera,</a> 
									<a href="#">Dual SIM,</a> 
									<a href="#">GSM,</a> 
									<a href="#">Touch screen</a> --> 
									<?php 
										echo $getItem[0]['pro_features']; 
									?>
								</p>
								<p><strong><?php echo $this->m_crud->get_langs('Model',$lang); ?>: </strong>
								<a href="<?php echo site_url(); ?>categories.html/<?php echo $getItem[0]['model_id']; ?>"><?php 
										echo $getItem[0]['name']; 
									?></a></p>
							</div><!-- short-info -->
							
							<!-- contact-with -->
							<div class="contact-with">
								<h4><?php echo $this->m_crud->get_langs('Contact_with',$lang); ?> </h4>
								<span class="btn btn-red show-number">
									<i class="fa fa-phone-square"></i>
									<span class="hide-text"><?php echo $this->m_crud->get_langs('Click_to_show_phone_number',$lang); ?></span> 
									<span class="hide-number">012-1234567890</span>
								</span>
								<a href="#" class="btn"><i class="fa fa-envelope-square"></i><?php echo $this->m_crud->get_langs('Reply_by_email',$lang); ?></a>
							</div><!-- contact-with -->
							
							<!-- social-links -->
							<div class="social-links">
								<h4>Share this ad</h4>
								<ul class="list-inline">
									<li><a href="<?php echo site_url(); ?>"><i class="fa fa-facebook-square"></i></a></li>
									<li><a href="<?php echo site_url(); ?>"><i class="fa fa-twitter-square"></i></a></li>
									<li><a href="<?php echo site_url(); ?>"><i class="fa fa-google-plus-square"></i></a></li>
									<li><a href="<?php echo site_url(); ?>"><i class="fa fa-linkedin-square"></i></a></li>
									<li><a href="<?php echo site_url(); ?>"><i class="fa fa-pinterest-square"></i></a></li>
									<li><a href="<?php echo site_url(); ?>"><i class="fa fa-tumblr-square"></i></a></li>
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
							<h4><?php echo $this->m_crud->get_langs('description',$lang); ?></h4>
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
								<li><i class="fa fa-shopping-cart"></i><a href="<?php echo site_url(); ?>#">Delivery: Meet in person</a></li>
								<li><i class="fa fa-user-plus"></i><a href="<?php echo site_url(); ?>#">More ads by <span>Yury Corporation</span></a></li>
								<li><i class="fa fa-print"></i><a href="<?php echo site_url(); ?>#">Print this ad</a></li>
								<li><i class="fa fa-reply"></i><a href="<?php echo site_url(); ?>#">Send to a friend</a></li>
								<li><i class="fa fa-heart-o"></i><a href="<?php echo site_url(); ?>#">Save ad as Favorite</a></li>
								<li><i class="fa fa-exclamation-triangle"></i><a href="<?php echo site_url(); ?>#">Report this ad</a></li>
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
							<h4><?php echo $this->m_crud->get_langs('recommended_ads_for_you',$lang); ?></h4>
						</div>					
						
							<?php 
								foreach ($getRecommendedAds as $rows) {
									?>
					<!-- ad-item -->
							<div class="ad-item row">
								<div class="item-image-box col-sm-4">
									<!-- item-image -->
									<div class="item-image">
										<a href="<?php echo site_url(); ?>home/details/<?php echo $rows['product_id']; ?>"><img src="<?php echo base_url(); ?>uploads/product/<?php echo $rows['featured_image']; ?>" alt="Image" class="img-responsive"></a>
									</div><!-- item-image -->
								</div><!-- item-image-box -->
								
								
								<div class="item-info col-sm-8">
									<!-- ad-info -->
									<div class="ad-info">
										<h3 class="item-price">$<?php echo $rows['pro_base_price']; ?><span>(<?php echo $rows['pro_sell_price'] ?>)</span></h3>
										<h4 class="item-title"><a href="<?php echo site_url(); ?>home/details/<?php echo $rows['product_id']; ?>"><?php echo $rows['pro_name']; ?></a></h4>
										<div class="item-cat">
											<span><a href="<?php echo site_url(); ?>categories/find.html/<?php echo $rows['cat_id']; ?>">
											<?php echo $this->m_crud->getFieldName('cat_name','categories','cat_id',$rows['cat_id']); ?>
											</a></span> /
											<span><a href="<?php echo site_url(); ?>#"><?php echo $this->m_crud->getFieldName('name','model','model_id',$rows['pro_model']); ?></a></span>
										</div>										
									</div><!-- ad-info -->
									
									<!-- ad-meta -->
									<div class="ad-meta">
										<div class="meta-content">
											<span class="dated"><a href="<?php echo site_url(); ?>#"><?php echo $rows['post_date']; ?></a></span>
											<a href="<?php echo site_url(); ?>#" class="tag"><i class="fa fa-tags"></i> <?php echo $rows['pro_condition']; ?></a>
										</div>									
										<!-- item-info-right -->
										<div class="user-option pull-right">
											<a href="<?php echo site_url(); ?>#" data-toggle="tooltip" data-placement="top" title="Address: <?php echo $this->m_crud->getFieldName('com_address','company','company_id',$rows['company_id']); ?>"><i class="fa fa-map-marker"></i> </a>
											<a class="online" href="<?php echo site_url(); ?>#" data-toggle="tooltip" data-placement="top" title="Dealer: <?php echo $this->m_crud->getFieldName('com_lname','company','company_id',$rows['company_id']); ?>"><i class="fa fa-suitcase"></i> </a>											
										</div><!-- item-info-right -->
									</div><!-- ad-meta -->
								</div><!-- item-info -->
							</div><!-- ad-item -->
									<?php
								}

							?>
							
							
							
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
									<p>Modern and secure for selling your products!</p>
								</div><!-- single-cta -->
								
								<!-- single-cta -->
								<div class="single-cta">
									<!-- cta-icon -->
									<div class="cta-icon icon-support">
										<img src="<?php echo base_url(); ?>public/images/icon/14.png" alt="Icon" class="img-responsive">
									</div><!-- cta-icon -->

									<h4>24/7 Support</h4>
									<p>Contact us at anytime you want for more!</p>
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
									<p><span>Give a call on</span><a href="tellto:092771244"> 092771244</a></p>
								</div><!-- single-cta -->
							</div>
						</div><!-- cta -->
					</div><!-- recommended-cta-->
				</div><!-- row -->
			</div><!-- recommended-info -->
		</div><!-- container -->
	</section><!-- main