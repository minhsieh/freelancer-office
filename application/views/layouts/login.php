<!DOCTYPE html>
<html lang="<?=lang('lang_code')?>" class="bg-dark">
	<head>
            <meta charset="utf-8" />
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
            <meta name="description" content="<?=$this->config->item('site_desc')?>" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <link rel="stylesheet" href="<?=base_url()?>resource/css/app.css" type="text/css" />
            <link rel="stylesheet" href="<?=base_url()?>resource/css/font.css" type="text/css" cache="false" />

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <!--[if lt IE 9]>
            <script src="js/ie/html5shiv.js" cache="false">
            </script>
            <script src="js/ie/respond.min.js" cache="false">
            </script>
            <script src="js/ie/excanvas.js" cache="false">
            </script> <![endif]-->
	</head>
	<body> 
	
	<!--main content start-->
      <?php  echo $template['body'];?>
      <!--main content end-->

	<script src="<?=base_url()?>resource/js/app.js"></script>
	<!-- Bootstrap -->
	<!-- App -->
</body>
</html>