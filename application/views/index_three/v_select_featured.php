				<div class="row">
					<!-- featured-top -->
					<div class="col-sm-12">
						<div class="featured-top">
							<h4>Featured Ads</h4>
						</div>
					</div><!-- featured-top -->
				</div>
					
				<div class="row">
					
					<?php 
						for($i=1;$i<=8;$i++){
							?>
						<!-- featured -->
						<div class="col-sm-6 col-md-4 col-lg-3">
						<!-- featured -->
						<div class="featured">
							<div class="featured-image">
								<a href="details.html"><img src="images/featured/1.jpg" alt="" class="img-respocive"></a>
								<a href="#" class="verified" data-toggle="tooltip" data-placement="top" title="Verified"><i class="fa fa-check-square-o"></i></a>
							</div>
							
							<!-- ad-info -->
							<div class="ad-info">
								<h3 class="item-price">$800.00</h3>
								<h4 class="item-title"><a href="#">Apple MacBook Pro with Retina Display</a></h4>
								<div class="item-cat">
									<span><a href="#">Electronics & Gedgets</a></span> 
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
									<a href="#" data-toggle="tooltip" data-placement="top" title="Individual"><i class="fa fa-suitcase"></i> </a>											
								</div><!-- item-info-right -->
							</div><!-- ad-meta -->
						</div><!-- featured -->
					</div>
						<!-- featured -->
								<?php
						}
					?>
					
					
					
				</div><!-- row -->				

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