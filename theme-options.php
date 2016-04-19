<?php

	require_once('admin-page-class/admin-page-class.php');
	require_once('tax-meta-class/Tax-meta-class.php');
	require_once('meta-box-class/my-meta-box-class.php');
	
	$manufacturers = array('gildan'=>'Gildan','hanes'=>'Hanes','bellaCanvas'=>'Bella Canvas','nextLevel'=>'Next Level','c2'=>'C2','anvil'=>'Anvil','independent'=>'Independent','jerzees'=>'Jerzees','fruitOfTheLoom'=>'Fruit of the Loom', 'lat'=>'LAT','a4'=>'A4','jAmerica'=>'J America', 'comfortColors'=>'Comfort Colors', 'alternative'=>'Alternative','augusta'=>'Augusta','badger'=>'Badger','codeV'=>'Code V','americanApparel'=>'American Apparel','tieDyed'=>'Tie-Dyed');
	
	// This is the configuration for the Theme options page
	$config = array(
    'menu'=> array('top' => 'impact-options'),  // sub page to settings page
    'page_title' => 'Impact Options',   			// The name of this page
    'capability' => 'update_plugins',       		// The capability needed to view the page
    'option_group' => 'impact-options',			// the name of the option to create in the database
    'id' => 'impact-options',                	// Page id, unique per page
    'fields' => array(),                 			// list of fields (can be added by field arrays)
    'local_images' => false,             			// Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => true            			// change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
); 

	$options_panel = new BF_Admin_Page_Class($config);

	$options_panel->OpenTabs_container('');
	$options_panel->TabsListing(array(
		'links' => array(
		'options_1' =>  __('Site-Wide Options'),
		'options_2' =>  __('Home Page Options'),
		'options_3' =>  __('Garment Colors'),
		'options_4' =>  __('Site Color Options'),
		'options_8' =>  __('Global & SEO Colors'),
		'options_5' =>  __('Social Media'),
		'options_6' =>  __('Pagination Settings'),
		'options_7' =>  __('Customer Reviews')
		)
	));
	
	// Open the first tab
	$options_panel->OpenTab('options_1');
	
	$options_panel->Title("Site Wide Options");
	//An optional description paragraph
	$options_panel->addParagraph("Welcome to the Impact Shirts options panel! This is the page where you'll select what logo to display, the appropriate phone number, and more.");
	
	
	$options_panel->addImage('site-logo',array('name'=> 'Site Logo'));
	$options_panel->addImage('favicon',array('name'=> 'Favicon'));
	$options_panel->addText('headerText',array('name'=> 'Header Center Text'));
	$options_panel->addText('headerSubText',array('name'=> 'Header Center Sub Text'));
	$options_panel->addText('phoneNumber',array('name'=> 'Phone Number'));
	$options_panel->addImage('defaultGarmentBanner',array('name'=> 'Default Banner for Garment Category Pages'));
	$options_panel->addImage('defaultDesignBanner',array('name'=> 'Default Banner for Design Category Pages'));
	$options_panel->addImage('404error',array('name'=> '404 Error Image'));
	
	// Close the first tab
	$options_panel->CloseTab();
	
	// Open the second tab
	$options_panel->OpenTab('options_2');
	
	//An optional description paragraph
	$options_panel->addParagraph("This is the page where you'll adjust all of the settings for your home page.");
	$options_panel->addText('homeSliderID',array('name'=> 'Home Slider ID #'));

	$options_panel->Title("View Shirt Styles #1");
	$options_panel->addImage('viewShirtStyles',array('name'=> 'View Shirt Styles Image'));
	$options_panel->addText('viewShirtStylesUrl',array('name'=> 'View Shirt Styles URL'));
	$options_panel->Title("View Shirt Styles #2");
	$options_panel->addImage('viewShirtStyles2',array('name'=> 'View Shirt Styles Image'));
	$options_panel->addText('viewShirtStylesUrl2',array('name'=> 'View Shirt Styles URL'));
	
	$options_panel->Title("Design Ideas #1");
	$options_panel->addImage('designIdeas1',array('name'=> 'Design Idea Image #1'));
	$options_panel->addText('designIdeaUrl1',array('name'=> 'Design Idea URL #1'));
	$options_panel->addText('designIdeaTopText1',array('name'=> 'Design Idea Top Text #1'));
	$options_panel->addText('designIdeaBottomText1',array('name'=> 'Design Idea Button Text #1'));
	$options_panel->addSelect('designIdeasAlignment1',array('alignLeft'=>'Align Left','alignRight'=>'Align Right','alignCenter'=>'Align center'),array('name'=> 'Text Alignment', 'std'=> array('alignCenter')));
	
	$options_panel->Title("Design Ideas #2");
	$options_panel->addImage('designIdeas2',array('name'=> 'Design Idea Image #2'));
	$options_panel->addText('designIdeaUrl2',array('name'=> 'Design Idea URL #2'));
	$options_panel->addText('designIdeaTopText2',array('name'=> 'Design Idea Top Text #2'));
	$options_panel->addText('designIdeaBottomText2',array('name'=> 'Design Idea Button Text #2'));
	$options_panel->addSelect('designIdeasAlignment2',array('alignLeft'=>'Align Left','alignRight'=>'Align Right','alignCenter'=>'Align center'),array('name'=> 'Text Alignment', 'std'=> array('alignCenter')));
	
	$options_panel->Title("Design Ideas #3");
	$options_panel->addImage('designIdeas3',array('name'=> 'Design Idea Image #3'));
	$options_panel->addText('designIdeaUrl3',array('name'=> 'Design Idea URL #3'));
	$options_panel->addText('designIdeaTopText3',array('name'=> 'Design Idea Top Text #3'));
	$options_panel->addText('designIdeaBottomText3',array('name'=> 'Design Idea Button Text #3'));
	$options_panel->addSelect('designIdeasAlignment3',array('alignLeft'=>'Align Left','alignRight'=>'Align Right','alignCenter'=>'Align center'),array('name'=> 'Text Alignment', 'std'=> array('alignCenter')));
	
	$options_panel->Title("Design Ideas #4");
	$options_panel->addImage('designIdeas4',array('name'=> 'Design Idea Image #4'));
	$options_panel->addText('designIdeaUrl4',array('name'=> 'Design Idea URL #4'));
	$options_panel->addText('designIdeaTopText4',array('name'=> 'Design Idea Top Text #4'));
	$options_panel->addText('designIdeaBottomText4',array('name'=> 'Design Idea Button Text #4'));
	$options_panel->addSelect('designIdeasAlignment4',array('alignLeft'=>'Align Left','alignRight'=>'Align Right','alignCenter'=>'Align center'),array('name'=> 'Text Alignment', 'std'=> array('alignCenter')));
	
	$options_panel->Title("Design Ideas #5");
	$options_panel->addImage('designIdeas5',array('name'=> 'Design Idea Image #5'));
	$options_panel->addText('designIdeaUrl5',array('name'=> 'Design Idea URL #5'));
	$options_panel->addText('designIdeaTopText5',array('name'=> 'Design Idea Top Text #5'));
	$options_panel->addText('designIdeaBottomText5',array('name'=> 'Design Idea Button Text #5'));
	$options_panel->addSelect('designIdeasAlignment5',array('alignLeft'=>'Align Left','alignRight'=>'Align Right','alignCenter'=>'Align center'),array('name'=> 'Text Alignment', 'std'=> array('alignCenter')));
	
	$options_panel->Title("Design Ideas #6");
	$options_panel->addImage('designIdeas6',array('name'=> 'Design Idea Image #6'));
	$options_panel->addText('designIdeaUrl6',array('name'=> 'Design Idea URL #6'));
	$options_panel->addText('designIdeaTopText6',array('name'=> 'Design Idea Top Text #6'));
	$options_panel->addText('designIdeaBottomText6',array('name'=> 'Design Idea Button Text #6'));
	$options_panel->addSelect('designIdeasAlignment6',array('alignLeft'=>'Align Left','alignRight'=>'Align Right','alignCenter'=>'Align center'),array('name'=> 'Text Alignment', 'std'=> array('alignCenter')));

	$options_panel->Title("Home Page Text Block");
	$options_panel->addText('homePageTextBlock',array('name'=> 'Home Page Text Block'));
	$options_panel->addImage('starsImage',array('name'=> 'Stars Image'));
	
	$options_panel->Title("Live Text Area #1");
	$options_panel->addImage('liveTextImage1',array('name'=> 'Live Text Image #1 (137x137)'));
	$options_panel->addText('liveTextTitle1',array('name'=> 'Live Text Title #1'));
	$options_panel->addText('liveTextText1',array('name'=> 'Live Text Text #1'));
	
	$options_panel->Title("Live Text Area #2");
	$options_panel->addImage('liveTextImage2',array('name'=> 'Live Text Image #2 (137x137)'));
	$options_panel->addText('liveTextTitle2',array('name'=> 'Live Text Title #2'));
	$options_panel->addText('liveTextText2',array('name'=> 'Live Text Text #2'));
	
	$options_panel->Title("Live Text Area #3");
	$options_panel->addImage('liveTextImage3',array('name'=> 'Live Text Image #3 (137x137)'));
	$options_panel->addText('liveTextTitle3',array('name'=> 'Live Text Title #3'));
	$options_panel->addText('liveTextText3',array('name'=> 'Live Text Text #3'));
	
	$options_panel->Title("Live Text Area #4");
	$options_panel->addImage('liveTextImage4',array('name'=> 'Live Text Image #4 (137x137)'));
	$options_panel->addText('liveTextTitle4',array('name'=> 'Live Text Title #4'));
	$options_panel->addText('liveTextText4',array('name'=> 'Live Text Text #4'));
	
	// Close the second tab
	$options_panel->CloseTab();
	
	// Open the third tab
	$options_panel->OpenTab('options_3');
	
	// Add the repeatable color options	
	$options_panel->Title("Garment Page Color Options");
	$options_panel->addParagraph("This is the page where you'll add garment producers and assign the available colors that will be used to populate the color options on their pages.");
	$repeater_fields[] = $options_panel->addSelect('manufacturer',array('gildan'=>'Gildan','hanes'=>'Hanes','bellaCanvas'=>'Bella Canvas','nextLevel'=>'Next Level','c2'=>'C2','anvil'=>'Anvil','independent'=>'Independent','jerzees'=>'Jerzees','fruitOfTheLoom'=>'Fruit of the Loom', 'lat'=>'LAT','a4'=>'A4','jAmerica'=>'J America', 'comfortColors'=>'Comfort Colors', 'alternative'=>'Alternative','augusta'=>'Augusta','badger'=>'Badger','codeV'=>'Code V','americanApparel'=>'American Apparel','tieDyed'=>'Tie-Dyed'),array('name'=> 'Manufacturer'), true);
	$repeater_fields[] = $options_panel->addText('colorName',array('name'=> 'Color Name'),true);
	$repeater_fields[] = $options_panel->addText('colorCode',array('name'=> 'Color Code'),true);
	$options_panel->addRepeaterBlock('re_',array('inline' => true, 'name' => '','fields' => $repeater_fields));
	// Close the third tab
	$options_panel->CloseTab();
	
	
	
	// Open the ninth tab
	$options_panel->OpenTab('options_9');
	
	// Add the repeatable color options	
	$options_panel->Title("Design Page Color Options");
	$options_panel->addParagraph("This is the page where you'll assign the available colors that will be used to populate the color options on design pages.");
	$repeaterDesignFields[] = $options_panel->addText('colorName',array('name'=> 'Color Name'),true);
	$repeaterDesignFields[] = $options_panel->addText('colorCode',array('name'=> 'Color Code'),true);
	$options_panel->addRepeaterBlock('designColors',array('inline' => true, 'name' => '','fields' => $repeaterDesignFields));
	// Close the ninth tab
	$options_panel->CloseTab();
	
	// Open the fourth tab: Site Color Options
	$options_panel->OpenTab('options_4');
	$options_panel->Title('The Website Header Options');
	$options_panel->addColor('headerBar',array('name'=> 'Header Bar Background Color'));
	$options_panel->addColor('menuBar',array('name'=> 'Menu Bar Background Color'));
	$options_panel->addColor('mainNavTextDefault',array('name'=> 'Main Navigation Text Color: Default'));
	$options_panel->addColor('mainNavTextHover',array('name'=> 'Main Navigation Text Color: Hover'));
	$options_panel->addColor('mainNavTextActive',array('name'=> 'Main Navigation Text Color: Active'));
	$options_panel->addColor('mainNavHover',array('name'=> 'Main Navigation Menu Item Color: Hover'));
	$options_panel->addColor('mainNavActive',array('name'=> 'Main Navigation Menu Item Color: Active'));
	$options_panel->addColor('mainTitle',array('name'=> 'Main Header Title Color'));
	$options_panel->addColor('mainDescription',array('name'=> 'Main Subtitle/Description Color'));
	$options_panel->addColor('mainPhone',array('name'=> 'Phone Number Color'));
	$options_panel->addColor('mainPhoneDesc',array('name'=> 'Phone Number Small Text Color'));
	$options_panel->Title('The Website Footer Options');
	$options_panel->addColor('footerBar',array('name'=> 'Footer Bar Color'));
	$options_panel->addColor('searchBar',array('name'=> 'Search Bar Color'));
	$options_panel->Title('Design and Garment Listing Options');
	$options_panel->addColor('designListingBar', array('name'=>'Design and Garment Bar Color'));
	$options_panel->addColor('designListingFont', array('name'=>'Design and Garment Bar Font Color'));
	$options_panel->addColor('designNumberColor', array('name'=>'Design and Garment Number Background Color'));
	$options_panel->addColor('designNumberFontColor', array('name'=>'Design and Garment Number Font Color'));
	$options_panel->addColor('backArrowColor', array('name'=> '"Back to desgns/garments" arrow color'));
	$options_panel->Title('Design and Garment Category Buttons');
	$options_panel->addColor('catParentBG', array('name'=> 'Category Parent Background Color'));
	$options_panel->addColor('catParentBorder', array('name'=> 'Category Parent Border Color'));
	$options_panel->addColor('catParentColor', array('name'=> 'Category Parent Text Color'));
	$options_panel->addColor('catDefaultBG', array('name'=> 'Category Default Background Color'));
	$options_panel->addColor('catDefaultBorder', array('name'=> 'Category Default Border Color'));
	$options_panel->addColor('catDefaultColor', array('name'=> 'Category Default Text Color'));
	$options_panel->addColor('catHoverBG', array('name'=> 'Category Hover Background Color'));
	$options_panel->addColor('catHoverBorder', array('name'=> 'Category Hover Border Color'));
	$options_panel->addColor('catHoverColor', array('name'=> 'Category Hover Text Color'));
	$options_panel->addColor('catActiveBG', array('name'=> 'Category Active Background Color'));
	$options_panel->addColor('catActiveBorder', array('name'=> 'Category Active Border Color'));
	$options_panel->addColor('catActiveColor', array('name'=> 'Category Active Text Color'));
	$options_panel->Title('Design and Garment Live Text Options');
	$options_panel->addColor('liveTextBG', array('name'=> 'Live Text Background Color'));
	$options_panel->addColor('liveTextColor', array('name'=> 'Live Text Font Color'));
	$options_panel->addColor('liveTextTitle', array('name'=> 'Live Text Title Color'));
	$options_panel->Title('Form Button Color Options');
	$options_panel->addColor('buttonDefaultBG', array('name'=> 'Button Default Background Color'));
	$options_panel->addColor('buttonDefaultBorder', array('name'=> 'Button Default Border Color'));
	$options_panel->addColor('buttonDefaultText', array('name'=> 'Button Default Text Color'));
	$options_panel->addColor('buttonHoverBG', array('name'=> 'Button Hover Background Color'));
	$options_panel->addColor('buttonHoverBorder', array('name'=> 'Button Hover Border Color'));
	$options_panel->addColor('buttonHoverText', array('name'=> 'Button Hover Text Color'));
	$options_panel->Title('Design Idea Boxes');
	$options_panel->addColor('designIdeasTextColor', array('name'=> 'Design Ideas & Line Text Color'));
	$options_panel->CloseTab();
	// Close the fourth tab: Site Color Options
	
	// Open the eighth tab: Global & SEO Color Options
	$options_panel->OpenTab('options_8');
	$options_panel->Title('Global Site Colors');
	$options_panel->addColor('h1', array('name'=> 'H1 Text Color'));
	$options_panel->addColor('h2', array('name'=> 'H2 Text Color'));
	$options_panel->addColor('h3', array('name'=> 'H3 Text Color'));
	$options_panel->addColor('h4', array('name'=> 'H4 Text Color'));
	$options_panel->addColor('h5', array('name'=> 'H5 Text Color'));
	$options_panel->addColor('h6', array('name'=> 'H6 Text Color'));
	$options_panel->addColor('p', array('name'=> 'Paragraph Text Color'));
	$options_panel->Title('SEO Landing Page Header Box Colors');
	$options_panel->addColor('landingHeaderTitle', array('name'=> 'Title Text Color'));
	$options_panel->addColor('landingHeaderP', array('name'=> 'Paragraph Text Color'));
	$options_panel->Title('SEO Landing #2 Split Column Colors');
	$options_panel->addColor('leftHeaderBG', array('name'=> 'Left Header Background'));
	$options_panel->addColor('rightHeaderBG', array('name'=> 'Right Header Background'));
	$options_panel->CloseTab();
	// Close the eighth tab: Global & SEO Color Options
	
	// Open the fifth tab: Social Media Options
	$options_panel->OpenTab('options_5');
	$options_panel->Title('Social Media Options');
	$options_panel->addParagraph('Use this page to setup the social media links found in the site footer.');
	$options_panel->addText('GooglePlus',array('name'=> 'Google Plus URL'));
	$options_panel->addText('Facebook',array('name'=> 'Facebook URL'));
	$options_panel->addText('Twitter',array('name'=> 'Twitter URL'));
	$options_panel->addText('Pinterest',array('name'=> 'Pinterest URL'));
	$options_panel->CloseTab();
	// Close the fifth tab: Social Media Options
	
	// Open the sixth tab: Pagination Options
	$options_panel->OpenTab('options_6');
	$options_panel->Title('Pagination Settings');
	$options_panel->addParagraph('Use this page to configure the number of items to display per page and to control the color settings for the pagination links. To display all posts on a single page, enter -1 (negative 1). Otherwise enter a multiple of 4 for ideal display performance.');
	$options_panel->addText('pagiGarments', array('name' => 'Garment Items Per Page'));
	$options_panel->addText('pagiDesigns', array('name' => 'Design Items Per Page'));
	$options_panel->addColor('pagiColor', array('name' => 'Pagination Highlight Color'));
	$options_panel->CloseTab();
	// Close the fifth tab: Pagination Options
	
	// Open the seventh tab: Customer Reviews
	$options_panel->OpenTab('options_7');
	$options_panel->Title('Customer Reviews');
	$options_panel->addParagraph('Use this page to configure the display of the Customer Reviews on this website.');
	$options_panel->Title('Home Page Widget');
	$options_panel->addColor('cr_bgcolor', array('name' => 'Home Widget Background Color'));
	$options_panel->addColor('cr_textcolor', array('name' => 'Home Widget Text Color'));
	$options_panel->addColor('cr_title', array('name' => 'Home Widget Title Color'));
	$options_panel->addColor('cr_subtitle', array('name' => 'Home Widget Subtitle Color'));
	$options_panel->addParagraph('The star image needs to have 5 stars evenly distributed on an image that is EXACTLY 110px wide by 20px tall. The current image is white stars on a transparent background so you may not actually be able to see it right here.');
	$options_panel->addImage('cr_stars',array('name'=> 'Star Image'));
	$options_panel->CloseTab();
	// Close the seventh tab: Customer Reviews
	
	// This is the configuration for the category options. 
	$config = array(
		'id' => 'showcaseMetaBox', 
		'title' => 'Category Theme Fields',
		'pages' => array('design-category','garment-category','contest-category','specific-design-categories'),  
		'context' => 'normal',
		'fields' => array(),
		'local_images' => false,
		'use_with_theme' => true
	);
	
	$my_meta = new Tax_Meta_Class($config);
	$my_meta->addText('categoryHeader',array('name'=> 'Category H1 Title'));
	$my_meta->addText('categorySmallTitle',array('name'=> 'Category Small (Side) Title'));
	$my_meta->addTextarea('categoryDescription',array('name'=> 'Category Description'));
	$my_meta->addText('categoryImage',array('name'=> 'Category Image'));
	$my_meta->addText('categoryImageLink',array('name'=> 'Category Image Link'));
	$my_meta->Finish();
	
	// This is the configuration for the garment custom fields
	$prefix = 'nc';
	$config = array(
    	'id'             => 'garmentFields',          // meta box id, unique per meta box
    	'title'          => 'Garment Page Advanced Options',          // meta box title
    	'pages'          => array('garment'),      // post types, accept custom post types as well, default is array('post'); optional
    	'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    	'priority'       => 'high',            // order of meta box: high (default), low; optional
    	'fields'         => array(),            // list of meta fields (can be added by field arrays)
    	'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
    	'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  	);

	$garmentMeta =  new AT_Meta_Box($config);
	$garmentMeta->addImage($prefix.'thumbNailOne',array('name'=> 'The First Thumbnail'));
	$garmentMeta->addImage($prefix.'thumbNailTwo',array('name'=> 'The Second Thumbnail'));
	$garmentMeta->addImage($prefix.'thumbNailThree',array('name'=> 'The Third Thumbnail'));
	$garmentMeta->addText($prefix.'description',array('name'=> 'Description'));
	$garmentMeta->addText($prefix.'sizes',array('name'=> 'Sizes'));
	$garmentMeta->addText($prefix.'fit',array('name'=> 'Fit'));
	$garmentMeta->addSelect('fit',array('junior'=>'Junior Sizing','womens'=>'Women\'s Cut','slim'=>'Slim Fit','generous'=>'Generous Cut','true'=>'True to Size'),array('name'=> 'Fit'));
	$garmentMeta->addText($prefix.'ContactForm',array('name'=> 'Contact Form ID (Optional: Leave blank for default Garment Form'));
	$garmentMeta->addText($prefix.'TableID',array('name'=> 'Price Table ID (ID Only, No Shortcode Needed)'));
	$garmentMeta->addText($prefix.'Table2ID',array('name'=> 'Price Table 2 ID (ID Only, No Shortcode Needed)'));
	$garmentMeta->addText($prefix.'BrandNumber',array('name'=> 'Brand Number'));
	$garmentMeta->addText($prefix.'GarmentNumber',array('name'=> 'Garment Number'));
	$repeaterMeta[] = $garmentMeta->addTextarea($prefix.'features',array('name'=> 'Features'),true);
	$garmentMeta->addRepeaterBlock($prefix.'re_',array('inline' => true, 'name' => 'Add Features','fields' => $repeaterMeta));
	$garmentMeta->addSelect('manufacturer',array('gildan'=>'Gildan','hanes'=>'Hanes','bellaCanvas'=>'Bella Canvas','nextLevel'=>'Next Level','c2'=>'C2','anvil'=>'Anvil','independent'=>'Independent','jerzees'=>'Jerzees','fruitOfTheLoom'=>'Fruit of the Loom', 'lat'=>'LAT','a4'=>'A4','jAmerica'=>'J America', 'comfortColors'=>'Comfort Colors', 'alternative'=>'Alternative','augusta'=>'Augusta','badger'=>'Badger','codeV'=>'Code V','americanApparel'=>'American Apparel','tieDyed'=>'Tie-Dyed'),array('name'=> 'Manufacturer'));
	$garmentMeta->addSelect('colorImages',array('no'=>'No','yes'=>'Yes'),array('name'=> 'Does this garment have color images in place?'));
	
	if(isset($_GET) && isset($_GET['post'])):
		$manufacturer = get_post_meta($_GET['post'], 'manufacturer', true);
	endif;
	
	global $switched;
	switch_to_blog(1);
		$data = get_option('impact-options');
		if($data['re_']):
			foreach ($data['re_'] as $thisOne) :
				if( ( isset($manufacturer) && $thisOne['manufacturer'] == $manufacturer ) || !isset($_GET['post'])):
					$array[$thisOne['colorName']] = $thisOne['colorName'];
					$std[] = $thisOne['colorName'];
				endif;
			endforeach;
		endif;
		if($array):
			$garmentMeta->addCheckboxList($prefix.'CheckboxList',
				$array,
				array('name'=> 'Available Colors'
				)
			);
		endif;
	restore_current_blog();
	$garmentMeta->Finish();
	
		$designConfig = array(
    	'id'             => 'designFields',          // meta box id, unique per meta box
    	'title'          => 'Design Page Advanced Options',          // meta box title
    	'pages'          => array('design'),      // post types, accept custom post types as well, default is array('post'); optional
    	'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    	'priority'       => 'high',            // order of meta box: high (default), low; optional
    	'fields'         => array(),            // list of meta fields (can be added by field arrays)
    	'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
    	'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  	);

	$designMeta =  new AT_Meta_Box($designConfig);
	$designMeta->addText($prefix.'TableID',array('name'=> 'Table ID (ID only, No shortcode needed)'));
	// $designMeta->addText($prefix.'ContactForm',array('name'=> 'Contact Form ID (ID only, No shortcode needed)'));
	$designMeta->addText($prefix.'DesignNumber',array('name'=> 'Design Number'));
	$designMeta->addText($prefix.'DesignKeywords',array('name'=> 'Search Form Keywords'));
	$designMeta->Finish();
	
	$pageConfig = array(
    	'id'             => 'pageFields',
    	'title'          => 'Page Advanced Options (For Use with Two Column Template)',
    	'pages'          => array('page'),
    	'context'        => 'normal',
    	'priority'       => 'high',
    	'fields'         => array(),
    	'local_images'   => false,
    	'use_with_theme' => true
  	);

	$pageMeta = new AT_Meta_Box($pageConfig);
	$pageMeta->addImage($prefix.'Image',array('name'=> 'The Banner Image'));
	$pageMeta->addText($prefix.'ContactForm',array('name'=> 'Contact Form ID (ID only, No shortcode needed)'));
	$pageMeta->addText($prefix.'TopText',array('name'=> 'Top Explanation Text (For Youth Group Names Template)'));
	$pageMeta->Finish();
	
	$pageConfig = array(
    	'id'             => 'groupNameFields',
    	'title'          => 'Group Names Fields (For Use with Youth Group Names Template)',
    	'pages'          => array('page'),
    	'context'        => 'normal',
    	'priority'       => 'high',
    	'fields'         => array(),
    	'local_images'   => false,
    	'use_with_theme' => true
  	);

	$groupMeta = new AT_Meta_Box($pageConfig);
	
	$repeaterFields[] = $groupMeta->addText($prefix.'GroupName',array('name'=> 'GroupName'),true);
	$repeaterFields[] = $groupMeta->addText($prefix.'Subtitle',array('name'=> 'Subtitle'),true);
	$groupMeta->addRepeaterBlock($prefix.'Groups',array('inline' => true, 'name' => 'Groups','fields' => $repeaterFields));
	$groupMeta->Finish();
	
	
	if( function_exists('acf_add_options_page') )
	{

		acf_add_options_page(array(
			'page_title' => 'Impact Shirts Theme Options',
			'menu_title' => 'Theme Options',
			'menu_slug'  => 'theme-options',
			'capability' => 'edit_posts',
			'position'   => false,
			'icon_url'   => 'dashicons-businessman'
		));

		acf_add_options_sub_page(array(
			'page_title' => 'Site Wide Options',
			'menu_title' => 'Site Wide Options',
			'menu_slug'  => 'theme-options-site-options',
			'parent_slug'=> 'theme-options',
			'capability' => 'edit_posts',
			'position'   => false,
			'icon_url'   => false
		));

		acf_add_options_sub_page(array(
			'page_title' => 'Available Design Colors',
			'menu_title' => 'Design Colors',
			'menu_slug'  => 'theme-options-design-colors',
			'parent_slug'=> 'theme-options',
			'capability' => 'edit_posts',
			'position'   => false,
			'icon_url'   => false
		));
		
		acf_add_options_sub_page(array(
			'page_title' => 'Available Design Colors',
			'menu_title' => 'Search Page',
			'menu_slug'  => 'theme-options-search-page',
			'parent_slug'=> 'theme-options',
			'capability' => 'edit_posts',
			'position'   => false,
			'icon_url'   => false
		));

	}

?>