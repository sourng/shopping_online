
<!-- services-ad -->
	<section id="services-ad" class="clearfix home-three">
		<!-- view-ad -->
		<?php $this->load->view('index_three/v_view_ad');?>
		<!-- view-ad -->

		<div class="container">
			<div class="row">
				<!-- banner -->
				<?php $this->load->view('index_three/v_banner');?>
				<!-- banner -->
			</div><!-- row -->	
			
			<!-- services -->	
			<div class="section services">
				<?php $this->load->view('index_three/v_select_service');?>
					
			</div>
			<!--End services -->			

			<!-- featureds -->
			<div class="section featureds">
					<?php $this->load->view('index_three/v_select_featured');?>
			</div>
			<!--End featureds -->			

			<!-- cta -->
			<div class="cta text-center">
					<?php $this->load->view('index_three/v_cta');?>
			</div>
			<!--End cta -->			
			
		</div><!-- container -->
	</section>
<!-- services-ad -->

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
  </body>
</html>