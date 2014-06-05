<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
    <link href='<?php echo get_template_directory_uri(); ?>/vendor/stylesheets/bootstrap.css' type='text/css' media='all' rel='stylesheet'  />
    <link href='<?php echo get_template_directory_uri(); ?>/vendor/stylesheets/tedx.css' type='text/css' media='all' rel='stylesheet'  />




    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="black-bg">
    <div class="container">
        <header>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

                    <?php
                    $logo = ot_get_option('logo', 'http://placehold.it/229x50.png');
                    if(array_key_exists('background-image', $logo)):
                        $logo_url = $logo['background-image'];
                    else:
                        $logo_url = $logo;
                    endif;
                    ?>
                    <img src="<?php echo $logo_url; ?>" height="50" width="229" alt="Logo" class="pull-left">

                    <div class="header-date-location pull-left">
                        <time class="date" datetime="2014-10-02">October 2nd, 2014</time>
                        <span class="location">Koerner Hall</span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="call-to-action">
                        <button class="btn btn-danger pull-right">Apply Now</button>
            <span class="copy pull-right clear">
              Submit a speaker, performer or demo nomination
            </span>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>
