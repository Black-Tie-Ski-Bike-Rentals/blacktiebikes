(function ($) {
  'use strict';

  document.addEventListener('click', function (e) {
    var link = e.target.closest('#menu-main-menu .menu-item-has-children > a');
    if (!link) return;
    // Desktop: sub-menus open on hover; let the link navigate normally.
    if (window.innerWidth >= 992) return;
    e.preventDefault();
    e.stopPropagation();
    var $li = $(link).closest('.menu-item-has-children');
    var isOpen = $li.hasClass('is-open-child');
    $('#menu-main-menu .menu-item-has-children.is-open-child').removeClass('is-open-child');
    if (!isOpen) {
      $li.addClass('is-open-child');
    }
  }, true);

  $(document).on('click', function (e) {
    if (!$(e.target).closest('#menu-main-menu .menu-item-has-children').length) {
      $('#menu-main-menu .menu-item-has-children.is-open-child').removeClass('is-open-child');
    }
    if ($(window).width() < 992 && !$(e.target).closest('#main-menu, .hamburger-menu').length) {
      if ($('html').hasClass('is-open-menu')) {
        $('.hamburger-menu').trigger('click');
      }
    }
  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      $('#menu-main-menu .menu-item-has-children.is-open-child').removeClass('is-open-child');
    }
  });

  // Jobs popup — app.js binds .popup-is-open-v2 directly at page load, which misses
  // menu items rebuilt by WP-CLI (class lands on <li>, data-id on <a>). Replicate
  // the same open sequence here via delegation, targeting the <a> by data-id directly.
  $(document).on('click', '#menu-main-menu a[data-id]', function (e) {
    var targetId = $(this).data('id');
    if ( !targetId || !$(targetId).hasClass('popup-v2') ) return;
    e.preventDefault();
    // Use replaceState (not location.hash) so the browser doesn't scroll the
    // page down to the #careers element in the footer — that jump is what made
    // the page appear scrolled to the bottom when the popup closed.
    history.replaceState(null, '', targetId);
    $('html').addClass('popup-open popup-animation');
    $(targetId).addClass('show');
    $(targetId).find('.popup-form').show();
    $(targetId).find('.career-content').show();
    $(targetId).find('.career-thank-message').hide();
  });


  // Prevent app.js from reopening the popup on refresh by clearing the hash on page load.
  if (window.location.hash === '#booknow') {
    history.replaceState(null, '', window.location.pathname + window.location.search);
  }

  // Intercept direct booking links in hero/content areas and open the popup instead.
  // Skip if the popup is already open — links inside it should open normally in a new tab.
  $(document).on('click', 'a[href*="booknow.blacktiebikes.com"], a[href*="blackdiamondbanff.com/book-now"], a[href*="checkfront.com/reserve"], a.cta-link', function (e) {
    if ($(this).hasClass('popup-is-open')) return;
    if ($(this).hasClass('gear-card__cta')) return;  // WW-12: Getting Your Gear buttons use their own per-option link, not the popup
    if ($('html').hasClass('html-popup-content')) return;
    e.preventDefault();
    $('#boonowbutton').trigger('click');
  });

  // Desktop logo: CSS transition from 160px → 100px on scroll.
  // Uses .logo-shrunk at threshold=10px so the browser has rendered the
  // 160px state before the class change triggers the transition.
  var $header = $('#header');
  var logoShrunk = $(window).scrollTop() > 10;
  if (logoShrunk) $header.addClass('logo-shrunk');

  $(window).on('scroll.logoShrink', function () {
    var shouldShrink = $(window).scrollTop() > 10;
    if (shouldShrink === logoShrunk) return;
    logoShrunk = shouldShrink;
    $header.toggleClass('logo-shrunk', shouldShrink);
  });

}(jQuery));

// WW-10: Destroy Slick on location/subpage hero — single static image, duplicate clone not needed
(function ($) {
  var $hero = $('.page-template-page-location .mod-hero-image, .page-template-default.page-child .mod-hero-image');
  if ($hero.length && $hero.hasClass('slick-initialized')) {
    $hero.slick('unslick');
  }
}(jQuery));

// WW-7: Explore section slider
// custom.js loads async in the footer — DOM is already ready, no DOMContentLoaded needed
(function () {
  document.querySelectorAll('.explore-slider-wrap').forEach(function (wrap) {
    var trackId = wrap.dataset.trackId;
    var total   = parseInt(wrap.dataset.total, 10);
    var visible = 3;
    var index   = 0;
    var track   = document.getElementById(trackId + '-track');
    var prev    = document.getElementById(trackId + '-prev');
    var next    = document.getElementById(trackId + '-next');

    function update() {
      var cardW = track.children[0].offsetWidth + 36;
      track.style.transform = 'translateX(-' + (index * cardW) + 'px)';
      prev.classList.toggle('explore-arrow--hidden', index === 0);
      next.classList.toggle('explore-arrow--hidden', index >= total - visible);
    }

    prev.addEventListener('click', function () {
      index = Math.max(0, index - 1);
      update();
    });

    next.addEventListener('click', function () {
      index = Math.min(total - visible, index + 1);
      update();
    });

    update();
  });
}());

/* Lock the home hero height so the mobile address bar hiding on scroll can't
   resize it (that resize rescaled the cover photo and clipped the mountain).
   Re-lock only when the width changes (rotation/resize), never on the
   height-only change the address bar causes. */
(function () {
  var hero = document.querySelector('.btb-hero');
  if (!hero) { return; }
  var lockedWidth;
  function lockHeroHeight() {
    hero.style.height = window.innerHeight + 'px';
    lockedWidth = window.innerWidth;
  }
  lockHeroHeight();
  window.addEventListener('resize', function () {
    if (window.innerWidth !== lockedWidth) { lockHeroHeight(); }
  });
  window.addEventListener('orientationchange', lockHeroHeight);
}());
