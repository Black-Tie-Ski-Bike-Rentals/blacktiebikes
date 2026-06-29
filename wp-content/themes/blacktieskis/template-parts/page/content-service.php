<?php
/**
 * WW-52: Service page body — fixed ACF section set.
 *
 * Sections (all optional, render only when filled):
 *   Hero      — svc_hero_image, svc_hero_heading, svc_hero_subheading
 *   Intro     — svc_intro (wysiwyg, centered 70%)
 *   Products  — svc_products repeater: product_heading + product_body (wysiwyg)
 *   FAQs      — svc_faqs repeater: faq_question + faq_answer (wysiwyg)
 */

$hero_image = get_field( 'svc_hero_image' );
$hero_head  = get_field( 'svc_hero_heading' );
$hero_sub   = get_field( 'svc_hero_subheading' );
$intro      = get_field( 'svc_intro' );
$products   = get_field( 'svc_products' );
$faqs       = get_field( 'svc_faqs' );
$book_url   = 'https://booknow.blacktiebikes.com/reservations/step1';

// Page is "empty" until it has an intro, a product, or FAQs (the hero always
// renders). Empty -> show the "Content coming soon" notice; the moment any of
// those is filled, the notice disappears and the page shows whatever's there.
$has_body = ( '' !== trim( wp_strip_all_tags( (string) $intro ) ) )
	|| ( is_array( $products ) && count( $products ) )
	|| ( '' !== trim( wp_strip_all_tags( (string) $faqs ) ) );
?>

<?php /* ── Hero ─────────────────────────────────────────────── */ ?>
<section class="module mod-service-hero"<?php if ( $hero_image ) : ?> style="background-image:url('<?php echo esc_url( is_array( $hero_image ) ? $hero_image['url'] : $hero_image ); ?>')"<?php endif; ?>>
  <div class="service-hero__overlay"></div>
  <div class="container service-hero__inner text-center">
    <?php if ( $hero_head ) : ?><h1 class="service-hero__heading"><?php echo esc_html( $hero_head ); ?></h1><?php endif; ?>
    <?php if ( $hero_sub ) : ?><p class="service-hero__sub"><?php echo esc_html( $hero_sub ); ?></p><?php endif; ?>
    <a href="<?php echo esc_url( $book_url ); ?>" class="btn">Book Now</a>
  </div>
</section>

<?php /* ── Content coming soon (only when the body is empty) ── */ ?>
<?php if ( ! $has_body ) : ?>
<section class="module mod-service-comingsoon">
  <div class="container text-center">
    <h2 class="service-comingsoon__heading">Content Coming Soon</h2>
    <p class="service-comingsoon__text">We're currently updating this page and will have more information available soon. Please check back later.</p>
  </div>
</section>
<?php endif; ?>

<?php /* ── Intro (centered, 70%) ────────────────────────────── */ ?>
<?php if ( ! empty( $intro ) ) : ?>
<section class="module mod-service-intro">
  <div class="container">
    <div class="service-intro text-center"><?php echo $intro; ?></div>
  </div>
</section>
<?php endif; ?>

<?php /* ── Products ─────────────────────────────────────────── */ ?>
<?php if ( have_rows( 'svc_products' ) ) : ?>
<section class="module mod-service-products">
  <div class="container">
    <?php while ( have_rows( 'svc_products' ) ) : the_row();
      $p_head = get_sub_field( 'product_heading' );
      $p_body = get_sub_field( 'product_body' );

      // The product image lives inside the wysiwyg body. Inject the heading
      // directly after that first image so it sits between the image and the
      // description (not below the whole card). Handles the common wysiwyg
      // forms: <figure>…</figure>, <p>…<img>…</p>, or a bare <img>.
      $heading_html    = $p_head ? '<h2 class="service-product__heading">' . esc_html( $p_head ) . '</h2>' : '';
      $heading_in_body = false;
      if ( $heading_html && $p_body ) {
        $img_pattern = '/<figure\b[^>]*>.*?<\/figure>|<p\b[^>]*>(?:(?!<\/p>).)*?<img\b[^>]*>.*?<\/p>|<img\b[^>]*\/?>/is';
        if ( preg_match( $img_pattern, $p_body, $m, PREG_OFFSET_CAPTURE ) ) {
          $pos             = $m[0][1] + strlen( $m[0][0] );
          $p_body          = substr( $p_body, 0, $pos ) . $heading_html . substr( $p_body, $pos );
          $heading_in_body = true;
        }
      }
      ?>
      <div class="service-product">
        <?php if ( $p_body ) : ?><div class="service-product__body"><?php echo $p_body; ?></div><?php endif; ?>
        <?php /* Fallback: no image found in body, so render the heading on its own. */ ?>
        <?php if ( $heading_html && ! $heading_in_body ) : ?><?php echo $heading_html; ?><?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</section>
<?php endif; ?>

<?php /* ── FAQs — same accordion build as the existing FAQ blocks ── */ ?>
<?php $faqs = get_field( 'svc_faqs' ); ?>
<?php if ( ! empty( $faqs ) ) : ?>
<section class="module mod-service-faqs">
  <h2 class="service-faqs__heading text-center">FAQs</h2>
  <?php echo $faqs; ?>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
<script>
jQuery(document).ready(function ($) {
  $(".accordion-list > li > .answer").hide();

  $(".accordion-list > li").click(function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active").find(".answer").slideUp();
    } else {
      $(".accordion-list > li.active .answer").slideUp();
      $(".accordion-list > li.active").removeClass("active");
      $(this).addClass("active").find(".answer").slideDown();
    }
    return false;
  });
});
</script>
<?php endif; ?>
