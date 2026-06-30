<?php
/**
 * WW-16: Location-page FAQ section (Layout Builder layout `faq_section`).
 *
 * Placed below the About Us block on location pages. Holds one merged accordion
 * (bike + paddle FAQs combined). Sub-fields:
 *   faq_heading (text, default "FAQs")
 *   faqs        (wysiwyg — <ul class="accordion-list"> … </ul>)
 *
 * Accordion toggle JS mirrors the Service template's; scoped to .mod-faqs so it
 * doesn't collide with any other accordion on the page. Icon glyph comes from
 * the material-design-iconic-font (loaded here, same as the Service FAQ).
 */

$faq_heading = get_sub_field( 'faq_heading' );
$faqs        = get_sub_field( 'faqs' );

if ( empty( $faqs ) ) {
	return;
}
?>

<section class="module mod-faqs">
  <div class="container">
    <h2 class="faqs__heading text-center"><?php echo esc_html( $faq_heading ? $faq_heading : 'FAQs' ); ?></h2>
    <?php echo $faqs; ?>
  </div>
</section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function ($) {
  $(".mod-faqs .accordion-list > li > .answer").hide();
  $(".mod-faqs .accordion-list > li").click(function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active").find(".answer").slideUp();
    } else {
      $(".mod-faqs .accordion-list > li.active .answer").slideUp();
      $(".mod-faqs .accordion-list > li.active").removeClass("active");
      $(this).addClass("active").find(".answer").slideDown();
    }
    return false;
  });
});
</script>
