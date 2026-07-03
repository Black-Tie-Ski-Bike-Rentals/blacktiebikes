<?php
/**
 * The template for displaying the footer
 *
 * @package blacktieskis
 */
?>
<?php
wp_reset_query(); //important to destroy the previous query and setup a new query.
?>
<?php /* Site-wide footer CTA on every page (mirrors the home cta_and_footer). */ ?>
<?php if ( is_page() ) { get_template_part( 'template-parts/includes/book-cta' ); } ?>
</main>
<!-- BEGIN LOADDING -->
<div class="module over-loader">
	<div class="loader">
		<img class="loader-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/BTS-logo.png" alt="Black Tie Bikes">
	</div>
</div>
<!-- END LOADDING -->

<?php /* Newsletter callout hidden until Klaviyo integration is ready (WW-20)
<section class="newsletter-callout">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-lg-6 newsletter-heading">
        <h3>GET THE LATEST NEWS DELIVERED TO YOUR INBOX!</h3>
        <p>We won't send you any garbage. Just the good stuff!</p>
      </div>
      <div class="col-12 col-lg-6">
        <div class="newsletter-form">
          <input type="email" placeholder="Enter email address">
          <button type="submit">Subscribe</button>
        </div>
      </div>
    </div>
  </div>
</section>
*/ ?>

<footer id="footer" class="module">
    <?php blacktieskis_footer_info(); ?>
</footer>


<div id="booknow" class="d-none" >
  <div class="mod-popup popup-show">
    <div class="popup-container ps-as" id="displaynone" >
      <div class="popup-content-contact container" id="booknnnn">
        <div class="mask-pop-overlay"></div>
        <div class="container popup-inner cont-background-opacity" style="max-width:770px;min-height:280px;padding:30px;">

          <?php the_field('bt_booknow_description', 'option'); ?>

          <a href="javascript:void(0);" class="popup-is-close">
            <span class="icomoon icon-close1"></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>



<div id="contact" class="d-none">
  <div class="mod-popup popup-show">
    <div class="popup-container ps-as">
      <div class="popup-content-contact container">
        <div class="mask-pop-overlay"></div>
        <div class="container popup-inner cont-background-opacity">
          <div class="content-popup-contact contact-thank-description text-center">
            <?php the_field('bt_contact_description', 'option'); ?>
          </div>
          <div class="content-popup-contact contact-thank-message text-center" style="display:none">
            <?php the_field('bt_contact_thank_message', 'option'); ?>
          </div>
          <div class="popup-contact-form">
            <?php the_field('bt_contact_form', 'option'); ?>
                <div class="loading-ajax d-none"><img src="<?php echo get_stylesheet_directory_uri();?>/images/ajax-loader.svg" alt="LOADING"></div>  

                <div class="response-message text-center" style="display:none"></div>
                <div class="response-success-send" style="display:none"><?php
                    $contact_msg = wpcf7_get_current_contact_form();
                    echo @$contact_msg->messages['mail_sent_ok'];
                    ?>
                </div>
                <div class="response-fail-send" style="display:none">
                    <?php
                    echo @$contact_msg->messages['mail_sent_ng'];
                    ?>
                </div>
          </div>

          <a href="javascript:void(0);" class="popup-is-close">
            <span class="icomoon icon-close1"></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<noscript>
  <div id="mod-noscript">
    <div class="d-table w-100 h-100">
      <div class="d-table-cell align-middle text-center">
        <div class="container">
          <h3>To use web better, please enable Javascript.</h3>
        </div>
      </div>
    </div>
  </div>
</noscript>      
<?php
$google_api_key = get_field('bt_google_api_key', 'option');
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo $google_api_key;?>"></script> 
<script>
	(function (e, t) { typeof module != "undefined" && module.exports ? module.exports = t() : typeof define == "function" && define.amd ? define(t) : this[e] = t() })("$script", function () { function p(e, t) { for (var n = 0, i = e.length; n < i; ++n)if (!t(e[n])) return r; return 1 } function d(e, t) { p(e, function (e) { return t(e), 1 }) } function v(e, t, n) { function g(e) { return e.call ? e() : u[e] } function y() { if (!--h) { u[o] = 1, s && s(); for (var e in f) p(e.split("|"), g) && !d(f[e], g) && (f[e] = []) } } e = e[i] ? e : [e]; var r = t && t.call, s = r ? t : n, o = r ? e.join("") : t, h = e.length; return setTimeout(function () { d(e, function t(e, n) { if (e === null) return y(); !n && !/^https?:\/\//.test(e) && c && (e = e.indexOf(".js") === -1 ? c + e + ".js" : c + e); if (l[e]) return o && (a[o] = 1), l[e] == 2 ? y() : setTimeout(function () { t(e, !0) }, 0); l[e] = 1, o && (a[o] = 1), m(e, y) }) }, 0), v } function m(n, r) { var i = e.createElement("script"), u; i.onload = i.onerror = i[o] = function () { if (i[s] && !/^c|loade/.test(i[s]) || u) return; i.onload = i[o] = null, u = 1, l[n] = 2, r() }, i.async = 1, i.src = h ? n + (n.indexOf("?") === -1 ? "?" : "&") + h : n, t.insertBefore(i, t.lastChild) } var e = document, t = e.getElementsByTagName("head")[0], n = "string", r = !1, i = "push", s = "readyState", o = "onreadystatechange", u = {}, a = {}, f = {}, l = {}, c, h; return v.get = m, v.order = function (e, t, n) { (function r(i) { i = e.shift(), e.length ? v(i, r) : v(i, t, n) })() }, v.path = function (e) { c = e }, v.urlArgs = function (e) { h = e }, v.ready = function (e, t, n) { e = e[i] ? e : [e]; var r = []; return !d(e, function (e) { u[e] || r[i](e) }) && p(e, function (e) { return u[e] }) ? t() : !function (e) { f[e] = f[e] || [], f[e][i](t), n && n(r) }(e.join("|")), v }, v.done = function (e) { v([null], e) }, v })
	;(function(){window.whenDefined=function(a,b,c){a[b]?c():Object.defineProperty(a,b,{configurable:!0,enumerable:!0,writeable:!0,get:function(){return this["_"+b]},set:function(a){this["_"+b]=a,c()}})}}).call(this);

	var settings = { baseurl: '<?php echo home_url(); ?>', jsPath: '<?php echo TEMPLATE_URL; ?>/javascripts/', icon_marker_location: '<?php echo TEMPLATE_URL; ?>/images/icon_marker_location.png?v=2', icon_marker_resport: '<?php echo TEMPLATE_URL; ?>/images/icon_marker_location.png?v=2' };
    var siteKeyRecap = '<?php the_field('bt_recaptcha_site_key','option');?>';
    var wpcf7 = {"apiSettings":{"root":"<?php echo home_url(); ?>\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"}};
    $script([
		'<?php echo TEMPLATE_URL; ?>/js/jquery-3.1.0.min.js'], 'vendor', function(){
			$script([settings.jsPath + 'app.js?v=2.72'], 'myScript', function(){
        $script([settings.jsPath + 'custom.js?v=1.5'], 'customScript');

        $script(['<?php echo TEMPLATE_URL; ?>/js/cf7.js?ver=1.3'], 'cf7Script', function(){
          $(window).trigger('load')
          $( document ).ajaxComplete(function( event, xhr, settings ) {
            if(xhr.statusText == "parsererror"){
                $('.contact-thank-description').hide();
                $('.contact-thank-message').show();
                $('.popup-contact-form').hide();
            }
          });
          $('.popup-contact-us').click(function () {
            $('.contact-thank-description').show();
            $('.popup-contact-form').show();
          })
          });

        });
		});
</script>
<!--<script src="https://www.google.com/recaptcha/api.js?render=<?php the_field('bt_recaptcha_site_key','option');?>"></script>-->
<script>
    // grecaptcha.ready(function () {
    //     grecaptcha.execute(siteKeyRecap, { action: 'contact' }).then(function (token) {
    //         var recaptchaResponse = document.getElementById('g-recaptcha-response');
    //         var recaptchaResponseCareer = document.getElementById('g-recaptcha-response-career');
    //         // treca=token;
    //         recaptchaResponse.value = token;
    //         recaptchaResponseCareer.value = token;
    //     });
    // });
    // 
</script>

<style>
#g-recaptcha.error iframe{border: 1px solid #dc3545;border-radius: 3px;}
</style>
<?php
wp_footer();
?>
</div>
</body>

</html>
