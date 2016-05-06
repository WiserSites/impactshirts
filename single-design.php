<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Design
 *
 *
 * @file           single-design.php
 * @package        Impact Shirts
 * @author         Jason T. Wiser
 * @copyright      2014 Webination Station
 * @license        license.txt
 * @version        Release: 1.0
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div id="content-full" class="grid col-940"><!-- single-design.php -->

<script>
        jQuery(document).ready(function($) {
    if($(window).innerWidth() < 980){
            $( "#content-full .type-design>.col-460 .da_showcase" ).insertAfter( "#single_content_header_text" ); 
            $( "#content-full .type-design>.col-460 .da_page_title" ).insertAfter( "#single_content_header_text" ); 
        }
        $(window).resize(function (){
            if($(window).innerWidth() < 980){
                $( "#content-full .type-design>.col-460 .da_showcase" ).insertAfter( "#single_content_header_text" );  
                $( "#content-full .type-design>.col-460 .da_page_title" ).insertAfter( "#single_content_header_text" ); 
            }else{
                $( "#content-full .type-design>.col-460:first-child .da_showcase" ).prependTo("#content-full .type-design>.col-460.grid.fit"); 
                $( "#content-full .type-design>.col-460:first-child .da_page_title" ).prependTo("#content-full .type-design>.col-460.grid.fit");
                
            }
            
        });
        });
    </script>

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

		<?php
			$featuredImage 		= get_the_post_thumbnail();
			$image 				= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			$itemNumber 		= get_field('design_number');
			$tableShortcode 	= get_field('table_shortcode');
			$contactShortcode 	= get_field('contact_form');
			$tableID 			= get_post_meta($post->ID, 'ncTableID', true);
			$designNumber 		= get_post_meta($post->ID, 'ncDesignNumber', true);
			
		?>

			<?php impactshirts_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php impactshirts_entry_top(); ?>

                    <?php

						$fields = get_fields();
						
						
/**************************************************************

// The Designer APP is activated....
					
**************************************************************/
						if(isset($fields['activate_design_builder']) && $fields['activate_design_builder'] == true):
							
							//
							// THE LEFT COLUMN
							//
							echo '<div class="col-460 grid">';
							
							// Fetch the root folder for replacements later
							$blog_details = get_blog_details();
							$root = $blog_details->domain.$blog_details->path;
							$new_root = $blog_details->siteurl.'/';
							$new_root = str_replace('http://','',$new_root);
							$new_root = str_replace('https://','',$new_root);
							
							$ink_color_qty = count($fields['design_layers']) - 1;
							$args = array('post_type' => 'garment','posts_per_page' => -1);
							
							// Activate the data from the primary data source: Ministry Gear
							switch_to_blog(1);
							
							$q = new WP_Query($args);
							if($q->have_posts()):
								while($q->have_posts()): $q->the_post();
									$post_fields = get_fields();
									
									if(is_array($fields['default_garment'])) { $fields['default_garment'] = 320; }
									
									// If the garment has Available Colors assigned to it
									if($post_fields['available_colors'] && $post_fields['pricing_table']):
									
										// If this is the default garment for this design
										if($fields['default_garment'] == get_the_ID()):
											
											// The garments array
											$garments[] = array(
												'text'			=> get_the_title() ,
												'value'			=> get_the_title() ,
												'selected'		=> true ,
												'description'	=> false ,
												'imageSrc'		=> $post_fields['icon'] ,
												'post_id'		=> get_the_ID()
											); 
																						
											
											$pricing_table = $post_fields['pricing_table'][$ink_color_qty];
											$garment_name = get_the_title();
											
											// Get the description
											$garment_description = get_the_content();
											
											// Let's output the garment colors for this garment
											foreach($post_fields['available_colors'] as $color):
											
												// If this is the default garment color
												if($fields['default_garment_color_name'] == $color['color_name']):
												$garment_colors[] = array(
													'text' 			=> $color['color_name'] , 
													'value' 		=> $color['color_name'] , 
													'selected' 		=> true , 
													'description' 	=> false , 
													'color_code'	=> $color['color_code'],
													// 'imageSrc'		=> $color['color_image'] ,
													'shirt_front'	=> $color['shirt_front'] ,
													'shirt_back'	=> $color['shirt_back']
												);
												$garment_color_image = $color['shirt_front'];
												else:
													$garment_colors[] = array(
														'text' 			=> $color['color_name'] , 
														'value' 		=> $color['color_name'] , 
														'selected' 		=> false , 
														'description' 	=> false , 
														'color_code'	=> $color['color_code'],
														// 'imageSrc'		=> $color['color_image'] ,
														'shirt_front'	=> $color['shirt_front'] ,
														'shirt_back'	=> $color['shirt_back']
													);												
												endif;
											endforeach;
										else:
											// The garments array
											$garments[] = array(
												'text'			=> get_the_title() ,
												'value'			=> get_the_title() ,
												'selected'		=> false ,
												'description'	=> false ,
												'imageSrc'		=> $post_fields['icon'] ,
												'post_id'		=> get_the_ID()
											);
										endif;
									endif;
									
								endwhile;
							endif;

							// Reset our blog and our query
							restore_current_blog();
							wp_reset_query();
							
							// Request Proof CTA
//							echo '<div class="da_request_proof">';
//							echo '<div class="da_proof_title">Get a Free Proof</div>';
//							echo '<div class="da_proof_subtitle">Your designer will make your changes and send you a preview.</div>';
//							echo '</div>';


							// The Garment Color Selector
                                                        echo "<div style='width:100%;' id='single_content_header_text' class='grid col-460'><h3 style='color: #007cb3;'>Try some color options</h3><span style='color: #999;'>Once you find some colors to start with, we'll connect you with a real person who will help you further personalize a design just for your group.<span></div>";
							echo '<div class="grid col-460"><label class="da_label" style="float: left; display: inline-block; width: auto;">Choose a Product</label></div>';
							echo '<div class="grid col-940"><div id="da_garment_selector"></div></div>';
							echo '<div class="grid col-460"><div id="da_garment_color"></div></div>';
							echo '<div class="grid col-460 fit"><div id="da_garment_side"></div></div>';

							// The Garment Selector
							// echo '<div class="grid col-940"><label class="da_label">Item</label></div>';
							
							echo '<div class="clearfix"></div>';
							
							
							// The Garment Color Selector
							$count = 0;
							switch_to_blog(1);
							$ink_colors = get_field('ink_colors', 'option');
							restore_current_blog();
							
							echo '<div class="grid col-940"><label class="da_label">Choose Design Colors</label></div>';
							while($count <= $ink_color_qty):
								$colorNumber = $count + 1;
								foreach($ink_colors as $color):
										
									if($color['color_name'] == $fields['design_layers'][$count]['color_name']):
									$ink_color_array[$count][] = array(
										'text' => $color['color_name'] , 
										'value' => $color['color_name'] ,
										'color_code' => $color['color_code'], 
										'selected' => true , 
										'description' => false , 
										// 'imageSrc' => $color['image']
									);
									$color_codes[$count] = $color['color_code'];
									else:
									$ink_color_array[$count][] = array(
										'text' => $color['color_name'] , 
										'value' => $color['color_name'] ,
										'color_code' => $color['color_code'], 
										'selected' => false , 
										'description' => false , 
										// 'imageSrc' => $color['image']
									);
									endif;
								endforeach;
								// if($count % 2 == 0):
									echo '<div class="grid col-460"><div id="da_ink_color_'.$colorNumber.'" data-index="'.$colorNumber.'"></div></div>';
								// else:
								//	echo '<div class="grid col-460 fit"><div id="da_ink_color_'.$colorNumber.'" data-index="'.$colorNumber.'"></div></div>';
								// endif;
								echo '<script>var da_ink_colors_'.$colorNumber.' = '.json_encode($ink_color_array[$count]).'</script>';
								
								++$count;
							endwhile;
							
							echo '<div class="clearfix"></div>';
							
							
							echo '<div class="da_customizer_form single_content_header_text">';
									echo '<h3>Personalize it</h3>';
									echo '<p>Your personal designer can customize it anyway you like.</p>';
							echo '<textarea class="da_custimizer_textarea"></textarea>';
							echo '</div>';
							
							// START THE CALENDARS
//							echo '<div class="clearfix"></div>';
//							echo '<div class="grid col-940 da_calendars">';
//							
//							// First Calendar
//							$freeDate = date('D, M j',strtotime('Now + 14 Days'));
//							echo '<div class="grid col-300 da_calendar">';
//							echo '<div class="da_calendar_title">Free Shipping</div><div class="da_calendar_description">Guaranteed by: '.$freeDate.'</div>';
//							echo '</div>';
//							
//							// Second Calendar
//							$rushDate = date('D, M j',strtotime('Now + 7 Days'));
//							echo '<div class="grid col-300 da_calendar">';
//							echo '<div class="da_calendar_title">Rush Upgrade</div><div class="da_calendar_description">Guaranteed by: '.$rushDate.'</div>';
//							echo '</div>';
//							
//							// Third Calendar
//							echo '<div class="grid col-300 fit da_calendar">';
//							echo '<div class="da_calendar_title">Miracle Rush</div><div class="da_calendar_description">Get your shirts in 3-4 days</div>';
//							echo '</div>';
//							
//							echo '</div>';
//							echo '<p class="center_text">View our <a href="http://ministrygear.com/shipping-delivery/">Shipping and Delivery</a> Page for more information.</p>';
							echo '<div class="clearfix"></div>';
							// END THE CALENDARS
							
							echo '<div class="da_request_proof">';
							echo '<div class="da_proof_title">Get a Free Proof</div>';
							echo '<div class="da_proof_subtitle">Your designer will make your changes and send you a preview.</div>';
							echo '</div>';
							echo '<table class="da_pricing_table"><tr><th class="table_label">Quantity</th><th>25+</th><th>50+</th><th>75+</th><th>100+</th><th>150+</th><th>300+</th><th>500+</th></tr><tr class="da_prices"><th class="table_label">Price Each</th>';
							foreach($pricing_table as $qty => $price):
								if($qty != 'colors'):
									echo '<td data-qty="'.$qty.'">$'.$price.'</td>';
								endif;
							endforeach;
							echo '</tr></table>';
							
							echo '<div class="show-number">';
                        	echo '<hr /><p><span class="thisIsTheNumber">#'.$designNumber.'</span> '.get_the_content().'</p>';
							echo '</div>';
							//
							// THE RIGHT COLUMN
							//
							echo '</div>';
							echo '<div class="col-460 grid fit">';
							
							echo '<h1 class="da_page_title">#'.$designNumber.' '.ucwords(get_the_title()).'</h1>';
							
							echo '<div class="da_showcase">';
							echo '<img class="garment background_garment" src="'.$garment_color_image.'" />';
							
							$count = 1;
							$index = 0;
							
							// The design layer canvas
							echo '<canvas id="design_canvas" class="da_canvas" width="400" height="550"></canvas>';
							
							// One image for each design layer to use as start points
							foreach($fields['design_layers'] as $design_layer):
								$image_link = str_replace($root,$new_root,$design_layer['design_layer']['url']);
								// $image_link = $design_layer['design_layer']['url'];
								echo '<img id="da_design_'.$count.'" class="da_design_layer" data-layer="'.$count.'" data-code="'.$color_codes[$index].'" src="'.$image_link.'" crossOrigin="anonymous" />';
								++$count; ++$index;
							endforeach;
                                                        echo '<img src="'.get_stylesheet_directory_uri().'/images/loading.gif" class="i_product_loading" >';
							echo '</div>';
							echo '<div class="clearfix"></div>';
							
							// The  Description
							$real_color_qty = $ink_color_qty + 1;
							// echo '<div class="clearfix" style="margin-top:30px;"></div>';
							
							// The Pricing Table
							echo '<h3>What\'s Included:</h3>';
							echo '<ul class="da_includes">';
							echo '<li><span class="da_garment_name">'.html_entity_decode($garment_name).'</span></li>';
							echo '<li>Screen printing with <span class="da_color_qty">'.$real_color_qty.'</span> color front</li>';
							echo '<li>Free 2-Week Delivery</li>';
							echo '<li>Free Professional Design Service</li>';
							echo '<li>Free set-up</li>';
							echo '<li>Money-Back Guarantee</li>';
							echo '</ul>';
//							echo '<div class="grid col-460"><div class="da_sizing_link">View Sizing</div></div>';
							// echo '<hr />';
							
							echo '<div class="clearfix" style="margin-top:10px;"></div>';
							echo '<p class="da_description da_description_full">'.$garment_description.'</p>';
							// echo '<div class="clearfix" style="margin-top:50px;"></div>';
							
							
							// THE PHONE NUMBER
							// echo '<div class="caps">talk to a real person<br/><span class="head-phone"><a href="tel:'.$data['phoneNumber'].'">'.$data['phoneNumber'].'</a></span><br/>here to help from 9am-5pm pst<br/>monday-friday</div>';
							
							
														// Title And Description							
							
							
							// showCalendar();
							
							/*
							echo '<div class="show-notes">';
							echo '<h3>Get a Custom Design</h3>';
							echo '<p><span>Specify your customizations below or call <b><a class="phoneNumber" href="tel:'.$data['phoneNumber'].'">'.$data['phoneNumber'].'</a></b></span><br/>Friendly designers email your customized design in 1 business day.</p>';
							echo '</div>';

							echo '<div class="show-contact">';
							echo '<div>'.do_shortcode('[gravityform id="6" name="Request a Free Design Mockup" title="false" description="false"]').'</div>';
							echo '</div>';
							*/
						
							?>
							<script>
						
							
							// Garment and Garment Color Data Arrays
							var home_url = '<?php echo home_url( '/' ); ?>';
							var da_garment_data = <?php echo json_encode($garments); ?>;
							var da_garment_color_data = <?php echo json_encode($garment_colors); ?>;
							var post_id = <?php echo get_the_ID(); ?>;

							// Retrieve the object from storage
							var saved_settings = localStorage.getItem('design_settings_'+post_id);
							var saved_settings = JSON.parse(saved_settings);

							<?php
							echo 'var color_codes = '.json_encode($color_codes).';';
							?>
						
							var da_garment_side = [
								{
									text: "Design on Front",
									value: 'front',
									selected: true,
									description: false,
									imageSrc: false
								},
								{
									text: "Design on Back",
									value: 'back',
									selected: false,
									description: false,
									imageSrc: false
								}
							];
							var s = 0;
							jQuery('#da_garment_side').ddslick({
								data:da_garment_side,
								width:'100%',
								selectText: "Select your preferred garment color",
								imagePosition:"left",
								onSelected: function(selectedData){	
									if(s==1) {
										var garment_color = jQuery('#da_garment_color').data('ddslick');
										if(selectedData['selectedData']['value'] == 'front') {
											jQuery('.background_garment').attr('src',garment_color['selectedData']['shirt_front']);
										} else {
											jQuery('.background_garment').attr('src',garment_color['selectedData']['shirt_back']);
										}
										// Store the information
										store_da_settings();
									}
									s=1;
								}
							});
						
							// A function for rebuilding the garment color toggle
							function create_slick_garment_colors(colors) {
								jQuery('#da_garment_color').ddslick({
									data:colors,
									width:'100%',
									height:300,
									selectText: "Select your preferred garment color",
									imagePosition:"left",
									onSelected: function(selectedData){	

										// Update the background image
										var garment_side = jQuery('#da_garment_side').data('ddslick');
										if(garment_side['selectedData']['value'] == 'front') {
											jQuery('.background_garment').attr('src',selectedData['selectedData']['shirt_front']);
										} else {
											jQuery('.background_garment').attr('src',selectedData['selectedData']['shirt_back']);
										}
										
										store_da_settings();

									}
								});
							}
							create_slick_garment_colors(da_garment_color_data);
							
							
							
							// Build the Garment Selector Toggle
							
							jQuery('#da_garment_selector').ddslick({
								data:da_garment_data,
								width:'100%',
								height:300,
								selectText: "Select your preferred apparel",
								imagePosition:"left",
								onSelected: function(selectedData){
									if(typeof page_loaded !== 'undefined' && page_loaded == true) {
										da_switch_garment();
									}
								}   
							});
						
							// Function for converting hex codes to an RGB array
							function hexToRgb(hex) {
								// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
								var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
								hex = hex.replace(shorthandRegex, function(m, r, g, b) {
									return r + r + g + g + b + b;
								});
							
								var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
								return result ? {
									r: parseInt(result[1], 16),
									g: parseInt(result[2], 16),
									b: parseInt(result[3], 16)
								} : null;
							}
						
						
							
                        </script>
                        </div>
                        <div class="da-popup-outer" id="da-popup-outer">
                        	<img class="da_popup_closer" src="http://ministrygear.com/wp-content/uploads/2016/01/X4.png" />
                        	<div class="da-popup-inner">
                                <div class="grid col-940">
                                    <div class="grid col-460">
                                    <?php
                                        echo '<div class="show-contact">';
                                        echo '<div>'.do_shortcode('[gravityform id="6" name="Request a Free Design Mockup" title="false" description="false"]').'</div>';
                                        echo '</div>';
                                    ?>
                                    </div>
                                    <div class="grid col-460 fit">
                            <?php        
                                    echo '<div class="da_showcase">';
									echo '<img class="garment background_garment" src="'.$garment_color_image.'" />';
							
									// The design layer canvas
									echo '<canvas id="design_canvas_clone" class="da_canvas" width="400" height="550"></canvas>';
									echo '</div>';
									echo '<div class="clearfix"></div>';
									echo '<div class="da_customizer_form single_content_header_text">';
									echo '<h3>Personalize it</h3>';
									echo '<p>Your personal designer can customize it anyway you like.</p>';
                            		echo '<textarea class="da_customizer_textarea_two"></textarea>';
									echo '</div>';
							?>
                                    </div>
                                </div>
                        	</div>
                        </div>
                            <?php

/**************************************************************

// The Designer APP is not activated....
					
**************************************************************/
					else:
                    
					echo '<div class="col-460 grid">';
					
                    if(get_field('lightColorDesign') && get_field('darkColorDesign')):
						$lightDesign 		= get_field('lightColorDesign');
						$darkDesign  		= get_field('darkColorDesign');
						$defaultShirt 		= get_field('defaultShirtImage');
						$defaultDesign 		= get_field('defaultDesignPreview');
						$defaultColorName 	= get_field('defaultColorName');
					?>
                    <div class="show-thumb-alt-outer" data-lightdesign="<?php echo $lightDesign['url']; ?>" data-darkdesign="<?php echo $darkDesign['url']; ?>" data-defaultshirt="<?php echo $defaultShirt['url']; ?>" data-defaultdesign="<?php echo $defaultDesign; ?>">
                    	<div class="show-thumb-alt-inner">
                        	
                        </div>
                    </div>
                    <?php else: ?>
					<div class="show-thumb">
						<?php echo '<img class="attachment-post-thumbnail wp-post-image" src="'.$image[0].'" title="'.get_the_title().'" alt="'.get_the_title().'" height="'.$image[2].'" width="'.$image[1].'"/>'; ?>
					</div>
                    <?php endif; ?>
                    
                    <?php if(get_field('lightColorDesign') && get_field('darkColorDesign')): ?>
					<div class="show-colors" data-postid="<?php echo $post->ID; ?>">
						<h3 class="colorsHeader">Color: <span class="currentColorLabel"><?php echo $defaultColorName; ?></span></h3>
                        
                        <?php
						
						switch_to_blog(1);
						$data = get_field('colors','options');
						foreach ($data as $thisOne):
							echo '<div class="colorOption" data-label="'.$thisOne['colorName'].'" data-image="'.$thisOne['shirtImage']['url'].'" data-style="'.$thisOne['lightDarkToggle'].'">';
							echo '<div class="colorCircle" style="background:'.$thisOne['colorCode'].'"></div>';
							echo '</div>';
						endforeach;
						restore_current_blog();	
						
						?>
                        
						<div class="clearfix"></div>
					</div>
                    <?php endif; ?>
					<?php $data = get_option('impact-options'); ?>
                    <?php // global $switched; switch_to_blog(1); ?>
					<div class="show-table">
						<?php if($tableID) echo do_shortcode('[table id='.$tableID.'/]');  ?>
					</div>
                    
                    
                    <?php // restore_current_blog(); ?>
					<div class="caps">
						talk to a real person<br/>
						<span class="head-phone"><?php echo '<a href="tel:'.$data['phoneNumber'].'">'.$data['phoneNumber'].'</a>'; ?></span><br/>
						here to help from 9am-5pm pst<br/>
						monday-friday
					</div>
                    
                    
                    
                    
				</div>
				
				<div class="col-460 grid fit">
					<?php socialWarfare(); ?>
				<div class="garment-details">
					<div class="show-number">
						<h3><?php echo ucwords(get_the_title()); ?></h3>
                        <p class="productDescription"><span class="thisIsTheNumber">#<?php echo $designNumber ?></span> <?php echo get_the_content(); ?></p>
					</div>
					<?php showCalendar(); ?>
					<div class="show-notes">
						<h3>Get a Custom Design</h3>
						<p><span>Specify your customizations below or call <b><?php echo '<a class="phoneNumber" href="tel:'.$data['phoneNumber'].'">'.$data['phoneNumber'].'</a>'; ?></b></span><br/>
						Friendly designers email your customized design in 1 business day.</p>
					</div>
				</div>
				
					<div class="show-contact">
						<div><?php echo do_shortcode('[gravityform id="6" name="Request a Free Design Mockup" title="false" description="false"]'); ?></div>
					</div>
				</div>
				<!-- end of .post-entry -->

                    <?php endif; // End the check for the design builder ?>

				<?php impactshirts_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php impactshirts_entry_after(); ?>


		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_footer(); ?>