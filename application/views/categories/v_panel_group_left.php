<div class="panel-group" id="accordion">
							 	
								<!-- panel -->
								<div class="panel-default panel-faq">
									<!-- panel-heading -->
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-one">
											<h4 class="panel-title">Categories<span class="pull-right"><i class="fa fa-minus"></i></span></h4>
										</a>
									</div><!-- panel-heading -->

									<div id="accordion-one" class="panel-collapse collapse in">
										<!-- panel-body -->
										<div class="panel-body">
											<h5><a href="categories-main.html"><i class="fa fa-caret-down"></i> All Categories</a></h5>
											
										<ul>
										<!--
												<li><a href="#"><i class="icofont icofont-laptop-alt"></i>Electronics & Gedget<span>(1029)</span></a></li>
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
											-->
											
											<?php 
												foreach($categories as $cat){												
												?>
												<li><a href="#"><i class="<?php echo $cat['cat_ico_class']; ?>"></i><?php echo $cat['cat_name']; ?><span>(1029)</span></a></li>
												<?php	
												}											
											?>
											
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
															<li><a href="#">USD</a></li>
															<li><a href="#">AUD</a></li>
															<li><a href="#">EUR</a></li>
															<li><a href="#">GBP</a></li>
															<li><a href="#">JPY</a></li>
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
							 </div>