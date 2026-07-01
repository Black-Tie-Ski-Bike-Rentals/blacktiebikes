<?php
/**
 * Displays content for locations map section
 */ 
?>
<?php
$state_categories = get_categories( array(
							'taxonomy' => 'category_state_location',
							'hide_empty' => 0
						) );
$resports = blacktiekis_get_resport_datas();		
//google map
$location_datas = blacktiekis_get_location_datas($state_categories);		
$location_headline = get_sub_field('headline');	
?>
<section id="locations" class="module mod-location-map animation">
  <div class="location-map-headline text-center">
    <h2 class="text-white ani-bottom"><?php echo !empty($location_headline) ? $location_headline : 'Ready to get started?'; ?></h2>
    <h3 class="text-white">Book your gear in minutes and get set for your trip:</h3>
    <a href="javascript:void(0);" data-id="#booknow" data-htmlclass="html-popup-content" class="popup-is-open btn text-uppercase">Book Now</a>
  </div>
  <div class="map position-relative">	  
      <div class="location-left-filter position-absolute bg-white ani-bottom" data-module="filter-location">
	    <div class="location-header"><h2>Explore Our Locations</h2></div>
        <div class="location-filter-mobile  d-lg-none">
          <a class="filter-text-default m-0 d-flex justify-content-between align-items-center">
            <span class="text-default">Locations</span>
            <span class="icomoon icon-close d-none"> </span>
            <span class="caret-c8 icomoon icon-chevron-down"> </span>
          </a>
        </div>
		<?php blacktiekis_state_location_nav($state_categories, $resports);	?>		
      </div>
	  <div class="location-map-reset position-absolute"><a href="javascript:void(0);" class="map-reset">Map Reset</a></div>
	<div class="w-100 map" id="map" style="height:500px; object-fit: cover;"></div>
  </div>
</section>
<?
// Cordeiro. TGO - 04232021 Direct Location Hack. Location_data & resports array are identical. unsure reason for both
if($_SERVER['REMOTE_ADDR']=="24.67.25.73"){ 
	/* Ex. Locations Array ( [0] => Array ( [Name] => Jackson Hole [locationID] => 28 [latitude] => 43.5875453 [longitude] => -110.82791829999996 [imageURL] => https://www.blacktieskis.com/wp-content/uploads/2019/07/aspen-1.jpg [imageAlt] => [parentLocationURL] => https://jacksonhole.blacktieskis.com/ [CTALink] => https://booknow.blacktieskis.com/?resort=JH [offsetx] => 10 [offsety] => 42 [new] => new-title
	 * */
	# Locations: print_r($location_datas); exit; 
	# Resorts: print_r($resports); exit;
	// Boone -> 36.138259825128884, -81.4429072956726
	// Whitefish -> 48.45834019109229, -113.93223198256722
	# add to array to hack direct
	#$location_data[]=array();
	#$resports[]=array();
}
?>
<script>
  var locationJsons = <?=json_encode($location_datas)?>;
  var resportJsons = <?=json_encode($resports)?>;
</script>
