<?php
/**
 * WW-16: Location-page FAQ section (Layout Builder layout `faq_section`).
 *
 * Below the About Us block. One merged accordion (bike + paddle combined).
 * Sub-fields:
 *   faq_heading    (text, default "Frequently Asked Questions")
 *   faq_subheading (text, default "Find quick answers about rentals, …")
 *   faqs           (wysiwyg — <ul class="accordion-list"> … </ul>)
 *
 * Heading/subheading left-aligned and sized to match the other location-page
 * sections (see .mod-faqs in custom.css). Accordion toggle JS scoped to
 * .mod-faqs so answers start collapsed and the +/× icon shows.
 */

$faq_heading = get_sub_field( 'faq_heading' );
$faq_sub     = get_sub_field( 'faq_subheading' );
$faqs        = get_sub_field( 'faqs' );

if ( empty( $faqs ) ) {
	return;
}

$heading = $faq_heading ? $faq_heading : 'Frequently Asked Questions';
$sub     = $faq_sub ? $faq_sub : 'Find quick answers about rentals, equipment, pickup options, and more.';
?>

<section class="module mod-faqs">
  <div class="container">
    <h2 class="faqs__heading"><?php echo esc_html( $heading ); ?></h2>
    <?php if ( $sub ) : ?><p class="faqs__sub"><?php echo esc_html( $sub ); ?></p><?php endif; ?>
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
