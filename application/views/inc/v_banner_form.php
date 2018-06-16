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
					
						<input type="text" class="form-control" placeholder="Type Your key word">
						<button type="submit" class="form-control" value="Search">Search</button>
					</form>
				</div>