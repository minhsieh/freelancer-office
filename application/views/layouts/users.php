<?php if (config_item('timezone')) { date_default_timezone_set(config_item('timezone')); } ?>
<!DOCTYPE html>
<html lang="<?=lang('lang_code')?>" class="app">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="">
	<meta name="author" content="<?=$this->config->item('site_author')?>">
	<meta name="keyword" content="<?=$this->config->item('site_desc')?>">
	<?php $favicon = config_item('site_favicon'); $ext = substr($favicon, -4); ?>
	<?php if ( $ext == '.ico') : ?>
		<link rel="shortcut icon" href="<?=base_url()?>resource/images/<?=config_item('site_favicon')?>">
	<?php endif; ?>
	<?php if ($ext == '.png') : ?>
		<link rel="icon" type="image/png" href="<?=base_url()?>resource/images/<?=config_item('site_favicon')?>">
	<?php endif; ?>
	<?php if ($ext == '.jpg' || $ext == 'jpeg') : ?>
		<link rel="icon" type="image/jpeg" href="<?=base_url()?>resource/images/<?=config_item('site_favicon')?>">
	<?php endif; ?>
	<?php if (config_item('site_appleicon') != '') : ?>
		<link rel="apple-touch-icon" href="<?=base_url()?>resource/images/<?=config_item('site_appleicon')?>" />
		<link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>resource/images/<?=config_item('site_appleicon')?>" />
		<link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>resource/images/<?=config_item('site_appleicon')?>" />
		<link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>resource/images/<?=config_item('site_appleicon')?>" />
	<?php endif; ?>
	<title><?php  echo $template['title'];?></title>
	<!-- Bootstrap core CSS -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />


	<link rel="stylesheet" href="<?=base_url()?>resource/css/app.css" type="text/css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.1/toastr.min.css" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=base_url()?>resource/css/typeahead.css" type="text/css" cache="false" />
	<?php if (isset($fuelux)) { ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fuelux/3.10.0/css/fuelux.min.css" type="text/css" />
	<?php } ?>
	<?php if (isset($nouislider)) { ?>
		<link href="<?=base_url()?>resource/js/nouislider/jquery.nouislider.min.css" rel="stylesheet"  type="text/css">
	<?php } ?>
	<?php if (isset($editor)) { ?>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.10/summernote.min.css" rel="stylesheet"  type="text/css">
	<?php } ?>
	<?php if (isset($datepicker)) { ?>
		<link rel="stylesheet" href="<?=base_url()?>resource/js/slider/slider.css" type="text/css" cache="false" />
		<link rel="stylesheet" href="<?=base_url()?>resource/js/datepicker/datepicker.css" type="text/css" cache="false" />
	<?php } ?>
	<?php if (isset($iconpicker)) { ?>
		<link rel="stylesheet" href="<?=base_url()?>resource/js/iconpicker/fontawesome-iconpicker.min.css" type="text/css" cache="false" />
	<?php } ?>
	<?php if (isset($calendar) || isset($fullcalendar)) { ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.2/fullcalendar.min.css" type="text/css"  />
	<?php } ?>
	<?php if (isset($form)) { ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" type="text/css" cache="false" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" type="text/css" cache="false" />
	<?php } ?>
	<?php if ($this->uri->segment(2) == 'help') { ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/1.0.0/introjs.min.css" type="text/css" cache="false" />
	<?php }  ?>
	<?php if (isset($datatables)) { ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/css/jquery.dataTables.min.css" type="text/css" cache="false" />
	<?php }  ?>
	<link rel="stylesheet" href="<?=base_url()?>resource/css/custom.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url()?>resource/css/style.css" type="text/css" />
	<?php 
	$family = 'Lato';
	$font = config_item('system_font');
	switch ($font) {
		case "open_sans": $family="Open Sans";  echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext,greek-ext,cyrillic-ext' rel='stylesheet' type='text/css'>"; break;
		case "open_sans_condensed": $family="Open Sans Condensed";  echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "roboto": $family="Roboto";  echo "<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "roboto_condensed": $family="Roboto Condensed";  echo "<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "ubuntu": $family="Ubuntu";  echo "<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "lato": $family="Lato";  echo "<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "oxygen": $family="Oxygen";  echo "<link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "pt_sans": $family="PT Sans";  echo "<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
		case "source_sans": $family="Source Sans Pro";  echo "<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
	}
	?>

	<style type="text/css">
		#pie-chart{
			min-height: 250px;
		}
		.morris-hover{position:absolute;z-index:1000;}
		.morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}
		.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
		.morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}
		body { font-family: '<?=$family?>'; }
	</style>

	<!--[if lt IE 9]>
	<script src="js/ie/html5shiv.js" cache="false">
	</script>
	<script src="js/ie/respond.min.js" cache="false">
	</script>
	<script src="js/ie/excanvas.js" cache="false">
	</script> <![endif]-->
</head>
<body>
	<div class="vbox">
		<!--header start-->
		<?php  echo modules::run('sidebar/top_header');?>
		<!--header end-->
		<section class="container-fluid">
			<section class="hbox stretch">
				<?php
				if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') {
					echo modules::run('sidebar/admin_menu');
				}elseif ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'staff') {
					echo modules::run('sidebar/collaborator_menu');
				}elseif ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'client') {
					echo modules::run('sidebar/client_menu');
				}else{
					redirect('');
				}
				?>
				<!--main content start-->
				<?php  echo $template['body'];?>
				<!--main content end-->
				<aside class="bg-light lter b-l aside-md hide" id="notes">
					<div class="wrapper">Notification
					</div> </aside>
				</section>
			</section>
		</div>
		<script>
			var locale = '<?=lang('lang_code')?>';
			var base_url = '<?=base_url()?>';
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment-with-locales.min.js"></script>
		<script src="<?=base_url()?>resource/js/app.js"></script>
		<script src="<?=base_url()?>resource/js/charts/easypiechart/jquery.easy-pie-chart.js" cache="false"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js" cache="false"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.1/toastr.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
		<script src="<?=base_url()?>resource/js/libs/jquery.textarea_autosize.min.js"></script>
		<script src="<?=base_url()?>resource/js/custom.js"></script>

		<?php if (isset($fuelux)) { ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fuelux/3.10.0/js/fuelux.min.js"></script>
		<?php } ?>

		<?php if (isset($editor)) { ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.10/summernote.min.js"></script>
		<script type="text/javascript">
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"positionClass": "toast-bottom-right",
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}          
			$('.foeditor-100').summernote({codemirror: { theme: 'monokai' }, height: 100 });
			$('.foeditor').summernote({codemirror: { theme: 'monokai' }, height: 200 });
			$('.foeditor-300').summernote({codemirror: { theme: 'monokai' }, height: 300 });
			$('.foeditor-400').summernote({codemirror: { theme: 'monokai' }, height: 400 });
			$('.foeditor-500').summernote({codemirror: { theme: 'monokai' }, height: 500 });
			$('.foeditor-550').summernote({codemirror: { theme: 'monokai' }, height: 550 });
			$('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();
		</script>
		<?php } ?>
		<!-- Bootstrap -->
		<!-- js placed at the end of the document so the pages load faster -->
		<?php  echo modules::run('sidebar/scripts');?>

	</body>
	</html>