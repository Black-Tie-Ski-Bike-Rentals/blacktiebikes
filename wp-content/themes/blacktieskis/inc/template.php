<?php
/*
 * generate main menu
 * @return output html
 */
function blacktieskis_main_menu()
{
	$theme_location = is_page_template( 'page-location.php' ) ? 'location-nav' : 'global-nav';

	$main_menus = array();
	$menu_items = blacktieskis_get_menu_item( $theme_location );
	$current_uri = explode('/', $_SERVER['REQUEST_URI']);
	$home_url = get_home_url();
	$active_pages = array();	
	
	$parent_page = '';
	for ($i = 0; $i < count($current_uri); $i++){
		if( !empty($current_uri[$i]) ){
			$active_pages[] = $home_url . '/' . $parent_page . $current_uri[$i];	
			$active_pages[] = $home_url . '/' . $parent_page . $current_uri[$i] . '/';	
			$parent_page = $parent_page . $current_uri[$i] . '/';
		}
	}
	
	if( $menu_items ) {
		for ($i = 0; $i < count($menu_items); $i++) {
			if ($menu_items[$i]->menu_item_parent == 0 ) { //lead level 1 group
				$main_menus[] = $menu_items[$i]; //level 1
			}			
		}	

		//output html
		?>
		
			<?php			
		
		
		  $args = array(
        'menu'                 => '',
        'container'            => '',
        'container_class'      => '',
        'container_id'         => '',
        'container_aria_label' => '',
        'menu_class'           => 'ml-auto main-menu-ul navbar-nav',
        'menu_id'              => 'menu-main-menu',
        'echo'                 => true,
        'fallback_cb'          => 'wp_page_menu',
        'before'               => '',
        'after'                => '',
        'link_before'          => '',
        'link_after'           => '',
        'items_wrap'           => '<ul id="%1$s" class="ml-auto main-menu-ul navbar-nav">%3$s</ul>',
        'item_spacing'         => 'preserve',
         'depth'                => 0,
        'walker'               => '',
        'theme_location'       => $theme_location,
    );

		//blacktieskis_main_menu();

// Find a per-location menu for this page or any location page above it in
// the hierarchy (handles service pages nested under location pages).
$location_menu_slug  = '';
$location_page_title = '';

if ( is_page() ) {
	// Prefer a location ANCESTOR's menu, so a page nested under a location (e.g. a
	// bike-shop /service page — itself on page-location.php) shows the PARENT
	// location's nav instead of treating its own title ("Service") as a location.
	foreach ( get_ancestors( get_the_ID(), 'page' ) as $ancestor_id ) {
		if ( get_page_template_slug( $ancestor_id ) === 'page-location.php' ) {
			$location_page_title = get_the_title( $ancestor_id );
			break;
		}
	}
	// No location ancestor: if this page itself is a location, use its own title.
	if ( ! $location_page_title && is_page_template( 'page-location.php' ) ) {
		$location_page_title = get_the_title();
	}
	if ( $location_page_title ) {
		$location_menu_slug = 'btb-' . sanitize_title( $location_page_title ) . '-nav';
	}
}

if ( $location_menu_slug && wp_get_nav_menu_object( $location_menu_slug ) ) {
	$args['menu']           = $location_menu_slug;
	$args['theme_location'] = '';
}

if ( $location_page_title ) {
	// Strip the "Home" item and prepend a location-picker dropdown instead.
	$_btb_rm_home = function( $items ) {
		return array_values( array_filter( $items, function( $item ) {
			return ! ( (int) $item->menu_item_parent === 0 && $item->title === 'Home' );
		} ) );
	};
	add_filter( 'wp_nav_menu_objects', $_btb_rm_home );
	$nav_html = wp_nav_menu( array_merge( $args, [ 'echo' => false ] ) );
	remove_filter( 'wp_nav_menu_objects', $_btb_rm_home );

	$picker = btb_location_picker_li( $location_page_title );
	echo preg_replace_callback( '/(<ul[^>]+>)/s', function( $m ) use ( $picker ) {
		return $m[1] . $picker;
	}, $nav_html, 1 );
} else {
	echo wp_nav_menu( $args );
}
		?> 
		<!--
		
		<ul class="ml-auto main-menu-ul navbar-nav"><?php
		for ($i = 0; $i < count($main_menus)-1; $i++) {
		
			//attr menu
			$classes = $main_menus[$i]->classes;
			$target = $main_menus[$i]->target;
			$class_menu = '';
			$target_menu = '';
			$is_popup = false;
			if( count($classes) ) {		
				$class_menu = ' ' . implode(" ", $classes);	
				if( in_array('popup', $classes) ){
					$is_popup = true;
				}else{
					$is_popup = false;
				}
			}
			if( !empty($target) )							
				$target_menu = ' target="' . $target . '"';
			
			if( $is_popup == true ){
				$popup_contact = ' data-id="#contact" class="popup-contact-us"';
			}
			?> <li class="<?php if(in_array($main_menus[$i]->url, $active_pages)) print ' active';?><?php echo $class_menu; ?>">
				<?php if($is_popup == true){ ?>
					<a class="popup-contact-us" href="<?php echo empty($popup_contact) ? $main_menus[$i]->url : 'javascript:void(0);'; ?>" <?php echo $target_menu; ?><?php echo $popup_contact; ?>><?php echo $main_menus[$i]->title; ?></a>				
			 	<?php }else{ ?>
					<a class="nav-link" href="<?php echo $main_menus[$i]->url ? $main_menus[$i]->url : 'javascript:void(0);'; ?>" <?php echo $target_menu; ?>><?php echo $main_menus[$i]->title; ?></a>				
				<?php } ?>
			</li><?php
		}			
		?></ul>-->
		<?php
		//attr menu: last item
		$index_last_item = count($main_menus)-1;
		$classes = $main_menus[$index_last_item]->classes;
		$target = $main_menus[$index_last_item]->target;
		$class_menu = '';
		$target_menu = '';
		if( count($classes) )							
			$class_menu = ' ' . implode(" ", $classes);
		if( !empty($target) )							
			$target_menu = ' target="' . $target . '"';
			
		?><div class="btn-cta">
			
			<a href="javascript:void(0);" id="boonowbutton" data-id="#booknow" data-htmlclass="html-popup-content" class="popup-is-open">Book Now</a>
			<!--<a href="<?php echo $main_menus[$index_last_item]->url; ?>" class="btn btn-outline-white" <?php echo $target_menu; ?>><?php echo $main_menus[$index_last_item]->title; ?></a>-->
		</div><?php
	}
}

/*
 * Build the location-picker <li> for the per-location nav.
 * Renders the current location name as an active dropdown trigger whose
 * sub-menu lists every other visible location from the taxonomy.
 */
function btb_location_picker_li( string $current_location_name ): string {
	// Breckenridge: not operating this season — hidden from the location switcher.
	$hidden_slugs = [ 'north-tahoe', 'breckenridge' ];

	$all_terms = get_terms( [ 'taxonomy' => 'category_state_location', 'hide_empty' => false ] );
	$all_terms = is_wp_error( $all_terms ) ? [] : (array) $all_terms;

	// Resolve the current location's URL from taxonomy meta so it stays
	// correct even on child pages where get_permalink() would return the child.
	$current_url = get_permalink();
	foreach ( $all_terms as $term ) {
		if ( $term->parent !== 0 && strtolower( $term->name ) === strtolower( $current_location_name ) ) {
			$meta_url = get_term_meta( $term->term_id, 'bt_cate_parent_location_url', true );
			if ( $meta_url ) {
				$current_url = $meta_url;
			}
			break;
		}
	}

	$other_terms = array_filter( $all_terms, fn( $t ) =>
		$t->parent !== 0
		&& ! in_array( $t->slug, $hidden_slugs, true )
		&& strtolower( $t->name ) !== strtolower( $current_location_name )
	);
	usort( $other_terms, fn( $a, $b ) => strcmp( $a->name, $b->name ) );

	$li  = '<li class="menu-item menu-item-has-children nav-item active btb-current-location">';
	$li .= '<a class="nav-link" href="' . esc_url( $current_url ) . '">' . esc_html( $current_location_name ) . '</a>';

	if ( $other_terms ) {
		$li .= '<ul class="sub-menu">';
		foreach ( $other_terms as $term ) {
			$url = get_term_meta( $term->term_id, 'bt_cate_parent_location_url', true );
			if ( ! $url ) {
				$link = get_term_link( $term );
				$url  = is_wp_error( $link ) ? '#' : $link;
			}
			$li .= '<li class="menu-item nav-item">';
			$li .= '<a class="nav-link" href="' . esc_url( $url ) . '">' . esc_html( $term->name ) . '</a>';
			$li .= '</li>';
		}
		$li .= '</ul>';
	}

	$li .= '</li>';
	return $li;
}

/*
 * Get locations data
 * @return array
 */
function blacktiekis_get_location_datas($state_categories)
{
	
	// WW-24: Breckenridge not operating this summer — hidden from the map.
	$hidden_slugs = array( 'breckenridge' );
	$locations = array();
	foreach( $state_categories as $key=>$location ) {
		if( $location->parent != 0 ) {	
			if ( in_array( $location->slug, $hidden_slugs, true ) ) { continue; }
			$latlngitude = blacktieskis_get_category_meta_str($location->term_id, 'bt_parent_location_map', 'category_state_location');
			if( !empty($latlngitude) && isset($latlngitude['lat']) && isset($latlngitude['lng']) ){
				$item = array();
				$item['Name'] = $location->name;
				$item['locationID'] = $location->term_id;
				$item['latitude'] = $latlngitude['lat'];
				$item['longitude'] = $latlngitude['lng'];				
				
				//get photo's resport
				$location_photo = blacktieskis_get_category_meta_str($location->term_id, 'bt_cate_photo', 'category_state_location');
				if ( !empty($location_photo) ) {
					$item['imageURL'] = $location_photo['url'];					
					$item['imageAlt'] = $location_photo['alt'];
				}
				else{
					$item['imageURL'] = '';
					$item['imageAlt'] = '';
				}
				
				$item['parentLocationURL'] = blacktieskis_get_category_meta_str($location->term_id, 'bt_cate_parent_location_url', 'category_state_location');
				$item['CTALink'] = blacktieskis_get_category_meta_str($location->term_id, 'bt_cate_cta_link', 'category_state_location');
				$item['offsetx'] = blacktieskis_get_category_meta_str($location->term_id, 'bt_pinpoint_offsetx', 'category_state_location');
				$item['offsety'] = blacktieskis_get_category_meta_str($location->term_id, 'bt_pinpoint_offsety', 'category_state_location');
				if(get_field('is_new',$location) === true){
					$item['new'] = "new-title";
				}else{
					$item['new'] = "";
				}
				$locations[] = $item;
			}	
		}	
	}
	
	return $locations;
}

/*
 * Get all individual resport location data
 * @return array
 */
function blacktiekis_get_resport_datas()
{
	$resports = array();
	$conditions = array(
					'post_type' => 'bt_resport',
					'orderby'   => 'title',
					'order' => 'ASC',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'cache_results' => false
				);
	$ps_resports = query_posts($conditions);
	if( count($ps_resports) ) {
		for ($i = 0; $i < count($ps_resports); $i++) {
	
			global $post;
			$post = $ps_resports[$i];
			setup_postdata($post);
			// WW-24: Breckenridge not operating this summer — hidden from the map.
			if ( stripos( get_the_title(), 'breckenridge' ) !== false ) { continue; }
			$latlngitude = get_field('bt_google_map');
			if( !empty($latlngitude) && isset($latlngitude['lat']) && isset($latlngitude['lng']) ){
				$item = array();
				$item['Name'] = get_the_title();
				//category contain this
				$location_ids = wp_get_post_terms($post->ID, 'category_state_location', array('fields' => 'ids'));
				if( isset($location_ids[0]) && !empty($location_ids[0]) ){
					$current_parent_location = get_term($location_ids[0], 'category_state_location');
					//get parent category
					if( $current_parent_location->parent != 0 )
						$item['locationID'] = $current_parent_location->parent;
					else
						$item['locationID'] = $location_ids[0];
				}
				else{
					$item['locationID'] = 0;	
				}					
				$item['resportID'] = $ps_resports[$i]->ID;
				$item['latitude'] = $latlngitude['lat'];
				$item['longitude'] = $latlngitude['lng'];
				
				//get feature's resport
				$resport_thumbnail_id = get_post_thumbnail_id($post->ID);
				if ( !empty($resport_thumbnail_id) ) {
					$resport_thumbnail = blacktieskis_get_attachment($resport_thumbnail_id);
					$item['imageURL'] = $resport_thumbnail['src'];		
					$resport_thumbnail_alt = $resport_thumbnail['alt'];	
					if( empty($resport_thumbnail_alt) )
						$resport_thumbnail_alt = get_the_title();
					$item['imageAlt'] = $resport_thumbnail_alt;
				}
				else{
					$item['imageURL'] = '';
					$item['imageAlt'] = '';
				}
				
				$bt_parent_location_url = get_field('bt_parent_location_url');
				if(isset($bt_parent_location_url) && !empty($bt_parent_location_url)){
					$item['parentLocationURL'] = get_field('bt_parent_location_url');
				}
				$CTALink = get_field('bt_cta_link');
				if(isset($CTALink) && !empty($CTALink)){
					$item['CTALink'] = get_field('bt_cta_link');
				}
				
				$item['hideLocation'] = get_field('bt_hide_location_on_map') == true ? true : false;
				$item['hideMarker'] = get_field('bt_hide_marker_on_map') == true ? true : false;
				
                $item['offsetx'] = get_field('bt_pinpoint_offsetx');
				$item['offsety'] = get_field('bt_pinpoint_offsety');
				if(get_field('is_new') === true){
					$item['new'] = "new-title";
				}else{
					$item['new'] = "";
				}
				$resports[] = $item;
			}
		}
		wp_reset_query();
		wp_reset_postdata();
	}

	return $resports;
}

/*
 * State/Location Nav
 * get category navigation of state/location
 * @return output html
 */
function blacktiekis_state_location_nav($state_categories, $resports)
{	
	$state_locations = array();
	
	// Sort location filter
	usort($state_categories,function($first,$second){
		return strtolower($first->name) > strtolower($second->name);
	});
	// End Sort location filter

	//group category: level 1 is main state, level is childs
	for ($i = 0; $i < count($state_categories); $i++) {
	
		if( $state_categories[$i]->parent == 0 ){
			$state_locations[] = $state_categories[$i]; //level 1
            $state_locations[count($state_locations) - 1]->childs = array();
		}
	}
	
	//add level2 to state, level 2 is individual resport
	for ($i = 0; $i < count($state_locations); $i++) {
		for ($j = 0; $j < count($resports); $j++) {
			if( $state_locations[$i]->term_id == $resports[$j]['locationID'] && !$resports[$j]['hideLocation']){
				$state_locations[$i]->childs[] = $resports[$j]; //level 2
			}
		}
	}

	//output html
	?><ul class="list-location-parent d-lg-block"><?php
	for ($i = 0; $i < count($state_locations); $i++) {
		$active_l = get_field('resort_active', $state_locations[$i]);
		$data_active = $class_active = "";
		if(isset($active_l)){
			$class_active = "active-l";
			$data_active = $active_l->ID;
		}
		?>
		<li class="location-parent">
			<a class="d-block state-nav <?php echo $class_active?>" data-state-active="<?php echo $data_active?>" href="javascript:void(0);" data-state-id="<?php echo $state_locations[$i]->term_id; ?>"><?php echo $state_locations[$i]->name; ?></a>
		<?php
		if (count($state_locations[$i]->childs) > 0) {
			?>
			<ul class="location-child"><?php
			for ($j = 0; $j < count($state_locations[$i]->childs); $j++) {
				?>
				<li class="resport-item" data-lng="<?php echo $state_locations[$i]->childs[$j]['longitude']; ?>" data-lat="<?php echo $state_locations[$i]->childs[$j]['latitude']; ?>" data-hide-marker="<?php echo $state_locations[$i]->childs[$j]['hideMarker']; ?>" data-resport-id="<?php echo $state_locations[$i]->childs[$j]['resportID']; ?>"><?php echo $state_locations[$i]->childs[$j]['Name']; ?></li><?php
			}
			?></ul><?php
		}	
		
		?>
		</li><?php
	}
	?></ul><?php
}

/*
 * get number parent locations
 *
 * @return output html
 */
function blacktiekis_count_parent_location($state_categories)
{
	$num_parent_location = 0;
	foreach( $state_categories as $key=>$location ) {	
		if( $location->parent != 0 )
			$num_parent_location += 1;		
	}
	
	echo $num_parent_location;
}

/*
 * show Platform (Trip Advisor, Facebook, etc)
 *
 * @return output html
 */
function blacktieskis_platform()
{
	
	$review_platform = get_field('bt_review_platform');
	if( !empty($review_platform) ) {
		?><div class="review-item-social float-left">
            <span class="icomoon align-self-center icon-<?php echo strtolower($review_platform);?>"></span>
        </div><?php
	}	
}

/*
 * show rating review
 *
 * @return output html
 */
function blacktieskis_rating()
{	
	$review_ratings = get_field('bt_review_rating');	
	$review_rating  = intval($review_ratings);	
	?>
	<div class="review-item-rate float-left"><?php
		
		for ($i = 1; $i <= $review_rating; $i++) {
			?><span class="icomoon align-self-center icon-star" data-rating="<?php echo $i;?>"></span><?php
		}
		for ($i = $review_rating+1; $i < 6; $i++) {
			?><span class="icomoon align-self-center icon-star star-silver" data-rating="<?php echo $i;?>"></span><?php
		}
	?></div>	
	<?php	
}

/*
 * show phone number/email/privacy policy in footer
 *
 * @return output html
 */
function blacktieskis_footer_info()
{	
	$footer_phone = get_field('bt_footer_phone', 'option');
	$footer_email = get_field('bt_footer_email', 'option');
	$privacy_policy_title = get_field('bt_privacy_policy_title', 'option');
	$career_title = get_field('bt_career_title', 'option');
	$career_description = get_field('bt_career_description', 'option');
	$career_form = get_field('bt_career_form', 'option');
	$career_max_size = get_field('bt_career_max_size', 'option');
	$career_max_size = $career_max_size ? $career_max_size : '500'; 
	$bt_other_links = get_field('bt_other_links', 'option');
	?><div class="container footer-top">
		<div class="row">
			<div class="footer-info footer-info-desk col-12 col-lg-8 d-flex justify-content-center justify-content-lg-start align-self-center">
				<?php
				if( !empty($footer_phone) ) :
					?><a href="tel:<?php echo $footer_phone;?>"><?php echo $footer_phone;?></a><?php
				endif;
				if( !empty($footer_email) ) :
					?><a class="footer-mail" href="https://www.blacktiebikes.com/contact/"><?php echo 'Contact';?></a>
				<?php
				endif;
				if( !empty($privacy_policy_title) ) :
					?><a href="javascript:void(0);" data-id="#privacy-policy" data-htmlclass="html-popup-content" class="popup-is-open"><?php echo $privacy_policy_title;?></a><?php			
					?><div id="privacy-policy" class="d-none">
					  <div class="container popup-inner">
						<div class="privacy-policy">
							<?php the_field('bt_privacy_policy_description', 'option'); ?>
						</div>
					  </div>
					</div><?php		
				endif;
				?>
				<?php if(!empty($career_title)):  ?>
					<a href="javascript:void(0);" data-id="#careers"  class="popup-is-open-v2"><?php echo $career_title; ?></a>
					<?php if(!empty($career_form)): ?>
						<div id="careers" class="popup-v2">
							<div class="mod-popup-v2 popup-flex-center">
								<div class="popup-container ps-as">
									<div class="popup-content-v2 container ">
										<div class="mask-pop-overlay-v2"></div>
										<div class="container popup-inner popup-careers cont-background-opacity">
											<div class="popup-content-v2">
												<div class="career-content popup-heading text-center">
													<?php echo $career_description; ?>
												</div>
												<div class="career-thank-message text-center" style="display:none;">
													<?php the_field('bt_career_thanks', 'option'); ?>
												</div>
					
<?php // WW-5: legacy Contact Form 7 jobs form removed — real applications now
													// come through the Gravity Form embedded in the description above.
													// The CF7 form was a spam magnet (thousands of junk Flamingo "Career"
													// entries) and created dead space below the live form. ?>
												<?php /* <div class="popup-form">
													<?php echo str_replace('<br>','',$career_form ) ; ?>
												</div> */ ?>
											</div>
											<div class="loading-ajax" style="display:none;"><img src="<?php echo get_stylesheet_directory_uri();?>/images/ajax-loader.svg" alt="LOADING"></div> 
											<a href="javascript:;" class="popup-is-close-v2"><span class="icomoon icon-close1"></span></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<p class="max-size" max-size="<?php echo $career_max_size; ?>"></p> 
					<?php endif; ?>
				<?php endif; ?>
				<?php // WW-20: link out to the Black Tie Skis (winter) site ?>
				<a href="https://www.blacktieskis.com/">Winter</a>
				<?php if(!empty($bt_other_links)) echo strip_tags($bt_other_links,'<a>') ; ?>
			</div>	  

			
			<?php blacktieskis_get_social_media(); ?>
		</div>
	</div><?php
}