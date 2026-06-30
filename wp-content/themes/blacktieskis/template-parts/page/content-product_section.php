<?php
/**
 * Displays content for Product Section
 */ 
?>
<?php 

$heading = get_sub_field('heading');

$description = get_sub_field('description');

// WW-28: on the Contact page, bold the lead question and put it on its own
// line. The text lives inside the ACF/Gravity Forms description blob, so we
// reformat it here rather than editing the field content. No-op everywhere
// else (the phrase only exists on the Contact page).
$description = str_replace(
	'Have questions about renting with us? Fill in the form below or contact us at',
	'<strong>Have questions about renting with us?</strong><br>Fill in the form below or contact us at',
	$description
);

$pageid = get_the_ID();

if($pageid==20){ ?>
<section id="products" class="module mod-about container-fluid animation">
	<?php }else{ ?>
	<section  class="module mod-about container-fluid ">
		<?php } ?>
		
  	

    
		  <div class="home-jumbotron jumbotron">
		  <?php $bt_htag = ( $pageid == 20 ) ? 'h2' : 'h1'; // WW-25: homepage Adventure Products heading is an H2 ?>
		  <<?php echo $bt_htag; ?> class="entry-title" style="text-align:center;"><?php echo $heading; ?></<?php echo $bt_htag; ?>>
		 
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $description; ?>
<!--<p style="text-align: center;"><em>Bringing your own boots? Just subtract $4/day from any ski or board package.</em></p>-->
                        </div>
                    </div>
                </div> 
		</div>
</section>
<?php if($heading=="FAQ's"){ ?>

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
<?php } ?>