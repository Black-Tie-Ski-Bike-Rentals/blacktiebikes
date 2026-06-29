<?php
/**
 * WW-53: Local Picks page body.
 *
 * ACF fields:
 *   lp_hero_image      (image, optional)
 *   lp_hero_heading    (text)
 *   lp_hero_subheading (text, optional)
 *   lp_categories (repeater)
 *     category_heading (text)               -> H2
 *     recommendations (repeater)
 *       rec_title       (text)              -> H3
 *       rec_description (wysiwyg)
 *       rec_image       (image, optional)
 *
 * Hero mirrors the Service template hero (same markup/classes + Book Now button).
 * Recommendations alternate image left/right; a recommendation with no image
 * runs full width. On mobile everything stacks with the image below the text.
 */

$hero_image = get_field( 'lp_hero_image' );
$hero_head  = get_field( 'lp_hero_heading' );
$hero_sub   = get_field( 'lp_hero_subheading' );
$book_url   = 'https://booknow.blacktiebikes.com/reservations/step1';

// Page is "empty" until at least one category is added. While empty, show the
// same "Content Coming Soon" notice the Service template uses; it disappears
// automatically the moment any Local Picks content is filled in.
$lp_cats   = get_field( 'lp_categories' );
$has_picks = is_array( $lp_cats ) && count( $lp_cats );
?>

<?php if ( $hero_head || $hero_image ) : ?>
<section class="module mod-service-hero"<?php if ( $hero_image ) : ?> style="background-image:url('<?php echo esc_url( is_array( $hero_image ) ? $hero_image['url'] : $hero_image ); ?>')"<?php endif; ?>>
  <div class="service-hero__overlay"></div>
  <div class="container service-hero__inner text-center">
    <?php if ( $hero_head ) : ?><h1 class="service-hero__heading"><?php echo esc_html( $hero_head ); ?></h1><?php endif; ?>
    <?php if ( $hero_sub ) : ?><p class="service-hero__sub"><?php echo esc_html( $hero_sub ); ?></p><?php endif; ?>
    <a href="<?php echo esc_url( $book_url ); ?>" class="btn">Book Now</a>
  </div>
</section>
<?php endif; ?>

<?php /* ── Content coming soon (only while the page has no Local Picks yet) ── */ ?>
<?php if ( ! $has_picks ) : ?>
<section class="module mod-service-comingsoon">
  <div class="container text-center">
    <h2 class="service-comingsoon__heading">Content Coming Soon</h2>
    <p class="service-comingsoon__text">We're currently updating this page and will have more information available soon. Please check back later.</p>
  </div>
</section>
<?php endif; ?>

<?php if ( $has_picks ) : ?>
<section class="module mod-local-picks">
  <div class="container">

    <?php if ( have_rows( 'lp_categories' ) ) : ?>
      <?php while ( have_rows( 'lp_categories' ) ) : the_row();
        $cat_heading = get_sub_field( 'category_heading' );
        ?>
        <div class="lp-category">

          <?php if ( $cat_heading ) : ?>
          <h2 class="lp-category__heading"><?php echo esc_html( $cat_heading ); ?></h2>
          <?php endif; ?>

          <?php if ( have_rows( 'recommendations' ) ) : ?>
            <?php
            $i = 0;
            while ( have_rows( 'recommendations' ) ) : the_row();
              $title   = get_sub_field( 'rec_title' );
              $desc    = get_sub_field( 'rec_description' );
              $image   = get_sub_field( 'rec_image' );
              $has_img = ! empty( $image );
              $i++;

              $classes = 'lp-rec';
              if ( ! $has_img ) {
                $classes .= ' lp-rec--full';      // no image -> full-width text
              } elseif ( $i % 2 === 0 ) {
                $classes .= ' lp-rec--reverse';    // alternate image to the right
              }
              ?>
              <div class="<?php echo esc_attr( $classes ); ?>">
                <?php if ( $has_img ) : ?>
                <div class="lp-rec__img">
                  <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                </div>
                <?php endif; ?>
                <div class="lp-rec__body">
                  <?php if ( $title ) : ?><h3 class="lp-rec__title"><?php echo esc_html( $title ); ?></h3><?php endif; ?>
                  <?php if ( $desc ) : ?><div class="lp-rec__desc"><?php echo $desc; ?></div><?php endif; ?>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>

        </div>
      <?php endwhile; ?>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>

<?php /* ── Footer CTA (reservation link) — renders on every local-picks page ── */ ?>
<?php get_template_part( 'template-parts/includes/book-cta' ); ?>
