<?php
/**
 * WW-54: Optional Gallery section (Layout Builder layout `gallery_section`).
 *
 * Images are styled as Explore cards and REUSE the Explore slider when there are
 * more than 3 (4+); 1–3 show in a simple row. Renders only when images are added.
 * Managed from the WP backend via the ACF Gallery field. Click an image to enlarge
 * (lightweight shared lightbox).
 *
 * The slider markup mirrors content-explore_section.php so the existing generic
 * slider JS (javascripts/custom.js → every .explore-slider-wrap) initializes it.
 */

$heading    = get_sub_field( 'gallery_heading' );
$subheading = get_sub_field( 'gallery_subheading' );
$images     = get_sub_field( 'gallery_images' );

if ( empty( $images ) ) {
	return;
}

$count    = count( $images );
$slider   = $count > 3;
$track_id = 'gallery-' . substr( md5( implode( ',', wp_list_pluck( $images, 'ID' ) ) ), 0, 8 );

/** Render one image as an Explore-style card. */
$card = function ( $img ) {
	$thumb = $img['sizes']['large'] ?? ( $img['sizes']['medium_large'] ?? $img['url'] );
	$alt   = $img['alt'] ? $img['alt'] : ( $img['title'] ?? '' );
	echo '<div class="explore-card gallery-card" data-full="' . esc_url( $img['url'] ) . '">'
		. '<div class="explore-card__img"><img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy"></div>'
		. '</div>';
};
?>

<section class="module mod-gallery">
  <div class="container">
    <?php if ( $heading ) : ?>
      <h2 class="explore-section__heading gallery__heading"><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>

    <?php if ( $subheading ) : ?>
      <p class="explore-section__sub gallery__sub"><?php echo esc_html( $subheading ); ?></p>
    <?php endif; ?>

    <?php if ( $slider ) : ?>
      <div class="explore-slider-wrap" data-track-id="<?php echo esc_attr( $track_id ); ?>" data-total="<?php echo (int) $count; ?>">
        <button class="explore-arrow explore-arrow--left explore-arrow--hidden" id="<?php echo esc_attr( $track_id ); ?>-prev" aria-label="Previous"><span class="explore-chevron explore-chevron--left"></span></button>
        <div class="explore-slider-viewport">
          <div class="explore-slider-track" id="<?php echo esc_attr( $track_id ); ?>-track">
            <?php foreach ( $images as $img ) { $card( $img ); } ?>
          </div>
        </div>
        <button class="explore-arrow explore-arrow--right" id="<?php echo esc_attr( $track_id ); ?>-next" aria-label="Next"><span class="explore-chevron explore-chevron--right"></span></button>
      </div>
    <?php else : ?>
      <div class="explore-grid-2 gallery-row">
        <?php foreach ( $images as $img ) { $card( $img ); } ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<script>
(function () {
  if (window.__btbGalleryLb) { return; }
  window.__btbGalleryLb = true;
  function init() {
    var lb = document.createElement('div');
    lb.className = 'gallery-lightbox';
    lb.hidden = true;
    lb.innerHTML = '<button class="gallery-lightbox__close" aria-label="Close">&times;</button><img class="gallery-lightbox__img" src="" alt="">';
    document.body.appendChild(lb);
    var img = lb.querySelector('.gallery-lightbox__img');
    function open(src, alt) { img.src = src; img.alt = alt || ''; lb.hidden = false; }
    function close() { lb.hidden = true; img.src = ''; }
    document.addEventListener('click', function (e) {
      var card = e.target.closest('.mod-gallery .gallery-card');
      if (card) { e.preventDefault(); var im = card.querySelector('img'); open(card.getAttribute('data-full'), im && im.alt); return; }
      if (e.target.closest('.gallery-lightbox')) { close(); }
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { close(); } });
  }
  if (document.readyState !== 'loading') { init(); } else { document.addEventListener('DOMContentLoaded', init); }
})();
</script>
