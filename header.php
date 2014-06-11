<?php
  global $TEDxMenus;
  $template_url = get_template_directory_uri();
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

  <link href="//www.google-analytics.com" rel="dns-prefetch">

  <!-- JQuery -->
  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

  <!-- Favicons -->
  <link href="<?php echo $template_url; ?>/assets/img/favicons/favicon.ico" rel="shortcut icon">
  <link href="<?php echo $template_url; ?>/assets/img/favicons/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="<?php echo $template_url; ?>/assets/img/favicons/apple-touch-icon.png" rel="apple-touch-icon-precomposed">
  <link href="<?php echo $template_url; ?>/assets/img/favicons/apple-touch-icon-57x57-precomposed.png" rel="apple-touch-icon" sizes="57x57">
  <link href="<?php echo $template_url; ?>/assets/img/favicons/apple-touch-icon-72x72-precomposed.png" rel="apple-touch-icon" sizes="72x72">
  <link href="<?php echo $template_url; ?>/assets/img/favicons/apple-touch-icon-114x114-precomposed.png" rel="apple-touch-icon" sizes="114x114">

  <!-- Compiled CSS -->
  <link href='<?php echo $template_url; ?>/dist/css/vendor.min.css' type='text/css' media='all' rel='stylesheet'>
  <link href='<?php echo $template_url; ?>/dist/css/application.min.css' type='text/css' media='all' rel='stylesheet'>

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
          if(is_array($logo) && array_key_exists('background-image', $logo)):
            $logo_url = $logo['background-image'];
          else:
            $logo_url = $logo;
          endif;
          ?>
          <a href="<?php echo ot_get_option('logo_link'); ?>">
            <img src="<?php echo $logo_url; ?>" height="50" width="229" alt="Logo" class="pull-left">
          </a>
          <div class="header-date-location pull-left">
            <time class="date" datetime="2014-10-02"><?php echo ot_get_option('event_date') ?></time>
            <span class="location"><?php echo ot_get_option('event_location') ?></span>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
          <div class="call-to-action">
            <a href="<?php echo ot_get_option('callout_link'); ?>" class="btn btn-danger pull-right"><?php echo ot_get_option('button_callout_text') ?></a>
            <span class="copy pull-right clear"><?php echo ot_get_option('header_callout') ?></span>
          </div>
        </div>
      </div><!-- .row -->

      <nav class="primary-nav">
        <?= $TEDxMenus->primary_nav(); ?>
      </nav>

    </header>

  </div>
</div><!-- .black-bg -->


<?php if($TEDxMenus->show_secondary_nav()): ?>
  <div class="primary-nav-secondary-container">
    <div class="container ">
      <nav class="primary-nav-secondary">
        <?= $TEDxMenus->secondary_nav(); ?>
      </nav>
    </div>
  </div>
<?php endif; ?>