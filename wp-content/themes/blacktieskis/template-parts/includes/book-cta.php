<?php
/**
 * Shared "Book Now" footer CTA — the triangular mod-book-ski block.
 *
 * Self-contained version of content-cta_and_footer.php for templates that don't
 * render the Layout Builder (Service Page, Local Picks). Reuses the existing
 * mod-book-ski / book-ski-headline / bg-book-ski-* styling and the footer-image
 * background, but the button is a DIRECT reservation link (not the #booknow
 * popup) — matching the booking-link pattern used by the service hero.
 */

$book_cta_url = 'https://booknow.blacktiebikes.com/reservations/step1';
?>
<section class="module mod-book-ski">
  <div class="book-ski-headline container text-center ani-bottom">
    <h2>Ready to ride? Reserve your gear today.</h2>
    <a href="<?php echo esc_url( $book_cta_url ); ?>" class="btn">Book Now</a>
  </div>
  <div class="bg-book-ski-fulldesk ani-bottom" data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer-image.webp" style="background-position: top center;"></div>
  <div class="bg-book-ski-desk ani-bottom" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/footer-image.webp'); background-position: center center;"></div>
</section>
