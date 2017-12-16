<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title>Trade | World's Largest Classifieds Portal</title>

   <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/icofont.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/owl.carousel.css">  
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/slidr.css">     
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/main.css">  
	<link id="preset" rel="stylesheet" href="css/presets/preset1.css">	
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/icofont/css/icofont.css">
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
	<section id="main" class="clearfix category-page">
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
				<?php 
				$this->load->view('inc/v_banner_form');
				?>
				<!-- banner-form -->
			</div>
	
			<div class="category-info">	
				<div class="row">
					<!-- accordion-->
					<div class="col-md-3 col-sm-4">
						<div class="accordion">
							<!-- panel-group -->
							<?php $this->load->view('categories/v_panel_group_left'); ?>
															
							 <!-- panel-group -->
						</div>
					</div><!-- accordion-->

					<!-- recommended-ads -->
					<?php $this->load->view('categories/v_recommended_ads'); ?>					
					<!-- recommended-ads -->

					<div class="col-md-2 hidden-xs hidden-sm">
						<div class="advertisement text-center">
							<a href="#"><img src="<?php echo base_url(); ?>public/images/ads/2.jpg" alt="" class="img-responsive"></a>
						</div>
					</div>
				</div>	
			</div>
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