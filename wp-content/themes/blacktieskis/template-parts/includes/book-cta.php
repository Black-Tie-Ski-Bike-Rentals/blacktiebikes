<?php
/**
 * Site-wide footer CTA — the triangular mod-book-ski "Book Now" block.
 *
 * Mirrors the home page's cta_and_footer block exactly: headline + "Book now"
 * (opens the #booknow popup) + "Contact us" outline button. Rendered once on
 * every page from footer.php (is_page), so every page is identical. The old
 * builder `cta_and_footer` layout is neutralised (content-cta_and_footer.php)
 * so this is the single source. Not per-page editable by design.
 */
?>
<section class="module mod-book-ski">
  <div class="book-ski-headline container text-center ani-bottom">
    <h2>Book your Adventure with Black Tie Today</h2>
    <a href="javascript:void(0);" id="boonowbutton" data-id="#booknow" data-htmlclass="html-popup-content" class="popup-is-open btn">Book now</a>
    <a href="https://www.blacktiebikes.com/contact/" class="btn btn-outline-primary text-uppercase">Contact us</a>
  </div>
  <div class="bg-book-ski-fulldesk ani-bottom" data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer-image.webp" style="background-position: top center;"></div>
  <div class="bg-book-ski-desk ani-bottom" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/footer-image.webp'); background-position: center center;"></div>
</section>
