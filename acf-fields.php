<?php

	// Switch and pull data from the primary blog
	switch_to_blog(1);
	
	// Fetch the available ink colors
	$ink_colors = get_field('ink_colors', 'option');
	
	// Add the ink colors to an array
	if( !empty( $ink_colors ) )
	foreach($ink_colors as $color):
		$ink_color_array[$color['color_name']] = $color['color_name'];
	endforeach;

	// Query the parent site for available garment types
	$garment_args = array('post_type' => 'garment','posts_per_page' => -1);
	$q = new WP_Query($garment_args);
	if($q->have_posts()):
		while($q->have_posts()): $q->the_post();
			$post_fields = get_fields();
			if($post_fields['available_colors'] && $post_fields['pricing_table']):
				$post_id = get_the_ID();
				$available_garments[$post_id] = get_the_title();
			endif;
		endwhile;
	endif;
	
// Restore the current blog
restore_current_blog();

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_564b7d23e6443',
	'title' => 'Design Builder App - Fields',
	'fields' => array (
		array (
			'key' => 'field_564b7d38e46f3',
			'label' => 'Activate Design Builder',
			'name' => 'activate_design_builder',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_564b7db27fe33',
			'label' => 'Design Layers',
			'name' => 'design_layers',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_564b7d38e46f3',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Row',
			'sub_fields' => array (
				array (
					'key' => 'field_564b7dc57fe34',
					'label' => 'Color Name',
					'name' => 'color_name',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 33,
						'class' => '',
						'id' => '',
					),
					'choices' => $ink_color_array, // Input our Custom Ink Color Array from the parent site's data
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
				array (
					'key' => 'field_564b7e447fe36',
					'label' => 'Design Layer',
					'name' => 'design_layer',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 33,
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'impactshirts-150',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
		),
		array (
			'key' => 'field_564b7e797fe37',
			'label' => 'Default Garment',
			'name' => 'default_garment',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_564b7d38e46f3',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => $available_garments, // Input our custom garment list from the parent site's data
			'default_value' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 1,
			'ajax' => 0,
			'placeholder' => '',
			'disabled' => 0,
			'readonly' => 0,
		),
		array (
			'key' => 'field_564b7eb97fe38',
			'label' => 'Default Garment Color Name',
			'name' => 'default_garment_color_name',
			'type' => 'text',
			'instructions' => 'This must match a color name that was input to the garment you selected above.',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_564b7d38e46f3',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'design',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;