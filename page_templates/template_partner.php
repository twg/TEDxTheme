<?php
/*
Template Name: Partners
*/

global $PartnerPostType;
$partners = $PartnerPostType->get_partners_for('partners');
$platinum_partners = $PartnerPostType->get_partners_for('platinum');
$gold_partners = $PartnerPostType->get_partners_for('gold');
$silver_partners = $PartnerPostType->get_partners_for('silver');
$supporters = $PartnerPostType->get_partners_for('supporters');
$salon_partners = $PartnerPostType->get_partners_for('salon');


$partner_types = array(
  'Partners' => 'partners',
  'Platinum' => 'platinum',
  'Gold' => 'gold',
  'Silver' => 'silver',
  'Bronze' => 'bronze',
  'Supporters' => 'supporters',
  'Salon' => 'salon'
);

get_header();

?>

  <div class="container contents">

    <section>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php the_content(); ?>

      <?php endwhile; endif; ?>
    </section>

    <?php
    foreach ($partner_types as $name => $slug):
      $partners = $PartnerPostType->get_partners_for($slug);
      if (!empty($partners)):
        ?>

        <section>

          <header>
            <h1 class="minor"><?php echo $name; ?></h1>
          </header>


          <div class="row">
            <?php foreach ($partners as $key => $post): setup_postdata($post); ?>

              <?php
              if (has_post_thumbnail()):
                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'small-partner');
                if (is_array($thumb) && !empty($thumb[0])) {
                  $thumbnail_src = $thumb[0];
                } else {
                  $thumbnail_src = '';
                }
                ?>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 partner-tile">
                  <a href='<?php echo get_post_meta(get_the_ID(), '_partner_url', true); ?>' target="_blank">
                    <img alt='<?php the_title(); ?>' src='<?php echo $thumbnail_src; ?>'/>
                  </a>
                </div>


              <?php endif; endforeach; ?>
          </div>
          <!-- .partner-list -->

        </section>

      <?php endif; endforeach; ?>

  </div><!-- .container contents -->


<?php get_footer(); ?>