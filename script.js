//Title: Custom DropDown plugin by PC
//Documentation: http://designwithpc.com/Plugins/ddslick
//Author: PC 
//Website: http://designwithpc.com
//Twitter: http://twitter.com/chaudharyp

console.log( 'v4.4.3' ); //GX version
var QueryString = function () {
  // This function is anonymous, is executed immediately and 
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  if(vars != '') {
	  for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
			// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
		  query_string[pair[0]] = decodeURIComponent(pair[1]);
			// If second entry with this name
		} else if (typeof query_string[pair[0]] === "string") {
		  var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
		  query_string[pair[0]] = arr;
			// If third or later entry with this name
		} else {
		  query_string[pair[0]].push(decodeURIComponent(pair[1]));
		}
	  }
	  
		return query_string;
    
	} else {
	
		return false;
	}
}();

(function ($) {

    $.fn.ddslick = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exists.');
        }
    };

    var methods = {},

    //Set defauls for the control
    defaults = {
        data: [],
        keepJSONItemsOnTop: false,
        width: 260,
        height: null,
        background: "#eee",
        selectText: "",
        defaultSelectedIndex: null,
        truncateDescription: true,
        imagePosition: "left",
        showSelectedHTML: true,
        clickOffToClose: true,
        onSelected: function () { }
    },

    ddSelectHtml = '<div class="dd-select"><input class="dd-selected-value" type="hidden" /><a class="dd-selected"></a><span class="dd-pointer dd-pointer-down"></span></div>',
    ddOptionsHtml = '<ul class="dd-options"></ul>',

    //CSS for ddSlick
    ddslickCSS = '<style id="css-ddslick" type="text/css">' +
                '.dd-select{ border-radius:2px; border:solid 1px #ccc; position:relative; cursor:pointer;}' +
                '.dd-desc { color:#aaa; display:block; overflow: hidden; font-weight:normal; line-height: 1.4em; }' +
                '.dd-selected{ overflow:hidden; display:block; padding:10px; font-weight:bold;}' +
                '.dd-pointer{ width:0; height:0; position:absolute; right:10px; top:50%; margin-top:-3px;}' +
                '.dd-pointer-down{ border:solid 5px transparent; border-top:solid 5px #000; }' +
                '.dd-pointer-up{border:solid 5px transparent !important; border-bottom:solid 5px #000 !important; margin-top:-8px;}' +
                '.dd-options{ border:solid 1px #ccc; border-top:none; list-style:none; box-shadow:0px 1px 5px #ddd; display:none; position:absolute; z-index:2000; margin:0; padding:0;background:#fff; overflow:auto;}' +
                '.dd-option{ padding:10px; display:block; border-bottom:solid 1px #ddd; overflow:hidden; text-decoration:none; color:#333; cursor:pointer;-webkit-transition: all 0.25s ease-in-out; -moz-transition: all 0.25s ease-in-out;-o-transition: all 0.25s ease-in-out;-ms-transition: all 0.25s ease-in-out; }' +
                '.dd-options > li:last-child > .dd-option{ border-bottom:none;}' +
                '.dd-option:hover{ background:#f3f3f3; color:#000;}' +
                '.dd-selected-description-truncated { text-overflow: ellipsis; white-space:nowrap; }' +
                '.dd-option-selected { background:#f6f6f6; }' +
                '.dd-option-image, .dd-selected-image { vertical-align:middle; float:left; margin-right:5px; max-width:64px;}' +
                '.dd-image-right { float:right; margin-right:15px; margin-left:5px;}' +
                '.dd-container{ position:relative;}​ .dd-selected-text { font-weight:bold}​</style>';

    //CSS styles are only added once.
    if ($('#css-ddslick').length <= 0) {
        $(ddslickCSS).appendTo('head');
    }

    //Public methods 
    methods.init = function (options) {
        //Preserve the original defaults by passing an empty object as the target
        var options = $.extend({}, defaults, options);

        //Apply on all selected elements
        return this.each(function () {
            var obj = $(this),
                data = obj.data('ddslick');
            //If the plugin has not been initialized yet
            if (!data) {

                var ddSelect = [], ddJson = options.data;

                //Get data from HTML select options
                obj.find('option').each(function () {
                    var $this = $(this), thisData = $this.data();
                    ddSelect.push({
                        text: $.trim($this.text()),
                        value: $this.val(),
                        selected: $this.is(':selected'),
                        description: thisData.description,
                        imageSrc: thisData.imagesrc //keep it lowercase for HTML5 data-attributes
                    });
                });

                //Update Plugin data merging both HTML select data and JSON data for the dropdown
                if (options.keepJSONItemsOnTop)
                    $.merge(options.data, ddSelect);
                else options.data = $.merge(ddSelect, options.data);

                //Replace HTML select with empty placeholder, keep the original
                var original = obj, placeholder = $('<div id="' + obj.attr('id') + '"></div>');
                obj.replaceWith(placeholder);
                obj = placeholder;

                //Add classes and append ddSelectHtml & ddOptionsHtml to the container
                obj.addClass('dd-container').append(ddSelectHtml).append(ddOptionsHtml);

                //Get newly created ddOptions and ddSelect to manipulate
                var ddSelect = obj.find('.dd-select'),
                    ddOptions = obj.find('.dd-options');

                //Set widths
                ddOptions.css({ width: options.width });
                ddSelect.css({ width: options.width, background: options.background });
                obj.css({ width: options.width });

                //Set height
                if (options.height != null)
                    ddOptions.css({ height: options.height, overflow: 'auto' });

                //Add ddOptions to the container. Replace with template engine later.
                $.each(options.data, function (index, item) {
                    if (item.selected) options.defaultSelectedIndex = index;
                    ddOptions.append('<li>' +
                        '<a class="dd-option">' +
                            (item.value ? ' <input class="dd-option-value" type="hidden" value="' + item.value + '" />' : '') +
                            (item.imageSrc ? ' <img class="dd-option-image' + (options.imagePosition == "right" ? ' dd-image-right' : '') + '" src="' + item.imageSrc + '" />' : '') +
							(item.color_code  ? ' <div class="dd-option-color" style="background-color:'+item.color_code+';"></div>' : '' ) +
                            (item.text ? ' <label class="dd-option-text">' + item.text + '</label>' : '') +
                            (item.description ? ' <small class="dd-option-description dd-desc">' + item.description + '</small>' : '') +
                        '</a>' +
                    '</li>');
                });

                //Save plugin data.
                var pluginData = {
                    settings: options,
                    original: original,
                    selectedIndex: -1,
                    selectedItem: null,
                    selectedData: null
                }
                obj.data('ddslick', pluginData);

                //Check if needs to show the select text, otherwise show selected or default selection
                if (options.selectText.length > 0 && options.defaultSelectedIndex == null) {
                    obj.find('.dd-selected').html(options.selectText);
                }
                else {
                    var index = (options.defaultSelectedIndex != null && options.defaultSelectedIndex >= 0 && options.defaultSelectedIndex < options.data.length)
                                ? options.defaultSelectedIndex
                                : 0;
                    selectIndex(obj, index);
                }

                //EVENTS
                //Displaying options
                obj.find('.dd-select').on('click.ddslick', function () {
                    open(obj);
                });

                //Selecting an option
                obj.find('.dd-option').on('click.ddslick', function () {
                    selectIndex(obj, $(this).closest('li').index());
                });

                //Click anywhere to close
                if (options.clickOffToClose) {

                    ddOptions.addClass('dd-click-off-close');
                    obj.on('click.ddslick', function (e) { e.stopPropagation(); });
                    $('body').on('click', function () {
                        $('.dd-click-off-close').slideUp(50).siblings('.dd-select').find('.dd-pointer').removeClass('dd-pointer-up');
                    });
                }
            }
        });
    };

    //Public method to select an option by its index
    methods.select = function (options) {
        return this.each(function () {
            if (options.index)
                selectIndex($(this), options.index);
        });
    }

    //Public method to open drop down
    methods.open = function () {
        return this.each(function () {
            var $this = $(this),
                pluginData = $this.data('ddslick');

            //Check if plugin is initialized
            if (pluginData)
                open($this);
        });
    };

    //Public method to close drop down
    methods.close = function () {
        return this.each(function () {
            var $this = $(this),
                pluginData = $this.data('ddslick');

            //Check if plugin is initialized
            if (pluginData)
                close($this);
        });
    };

    //Public method to destroy. Unbind all events and restore the original Html select/options
    methods.destroy = function () {
        return this.each(function () {
            var $this = $(this),
                pluginData = $this.data('ddslick');

            //Check if already destroyed
            if (pluginData) {
                var originalElement = pluginData.original;
                $this.removeData('ddslick').unbind('.ddslick').replaceWith(originalElement);
            }
        });
    }

    //Private: Select index
    function selectIndex(obj, index) {

        //Get plugin data
        var pluginData = obj.data('ddslick');

        //Get required elements
        var ddSelected = obj.find('.dd-selected'),
            ddSelectedValue = ddSelected.siblings('.dd-selected-value'),
            ddOptions = obj.find('.dd-options'),
            ddPointer = ddSelected.siblings('.dd-pointer'),
            selectedOption = obj.find('.dd-option').eq(index),
            selectedLiItem = selectedOption.closest('li'),
            settings = pluginData.settings,
            selectedData = pluginData.settings.data[index];

        //Highlight selected option
        obj.find('.dd-option').removeClass('dd-option-selected');
        selectedOption.addClass('dd-option-selected');

        //Update or Set plugin data with new selection
        pluginData.selectedIndex = index;
        pluginData.selectedItem = selectedLiItem;
        pluginData.selectedData = selectedData;        

        //If set to display to full html, add html
        if (settings.showSelectedHTML) {
            ddSelected.html(
                    (selectedData.imageSrc ? '<img class="dd-selected-image' + (settings.imagePosition == "right" ? ' dd-image-right' : '') + '" src="' + selectedData.imageSrc + '" />' : '') +
					(selectedData.color_code  ? ' <div class="dd-option-color" style="background-color:'+ selectedData.color_code+';"></div>' : '' ) +
                    (selectedData.text ? '<label class="dd-selected-text">' + selectedData.text + '</label>' : '') +
                    (selectedData.description ? '<small class="dd-selected-description dd-desc' + (settings.truncateDescription ? ' dd-selected-description-truncated' : '') + '" >' + selectedData.description + '</small>' : '')
                );

        }
        //Else only display text as selection
        else ddSelected.html(selectedData.text);

        //Updating selected option value
        ddSelectedValue.val(selectedData.value);

        //BONUS! Update the original element attribute with the new selection
        pluginData.original.val(selectedData.value);
        obj.data('ddslick', pluginData);

        //Close options on selection
        close(obj);

        //Adjust appearence for selected option
        adjustSelectedHeight(obj);

        //Callback function on selection
        if (typeof settings.onSelected == 'function') {
            settings.onSelected.call(this, pluginData);
        }
    }

    //Private: Close the drop down options
    function open(obj) {

        var $this = obj.find('.dd-select'),
            ddOptions = $this.siblings('.dd-options'),
            ddPointer = $this.find('.dd-pointer'),
            wasOpen = ddOptions.is(':visible');

        //Close all open options (multiple plugins) on the page
        $('.dd-click-off-close').not(ddOptions).slideUp(50);
        $('.dd-pointer').removeClass('dd-pointer-up');

        if (wasOpen) {
            ddOptions.slideUp('fast');
            ddPointer.removeClass('dd-pointer-up');
        }
        else {
            ddOptions.slideDown('fast');
            ddPointer.addClass('dd-pointer-up');
        }

        //Fix text height (i.e. display title in center), if there is no description
        adjustOptionsHeight(obj);
    }

    //Private: Close the drop down options
    function close(obj) {
        //Close drop down and adjust pointer direction
        obj.find('.dd-options').slideUp(50);
        obj.find('.dd-pointer').removeClass('dd-pointer-up').removeClass('dd-pointer-up');
    }

    //Private: Adjust appearence for selected option (move title to middle), when no desripction
    function adjustSelectedHeight(obj) {

        //Get height of dd-selected
        var lSHeight = obj.find('.dd-select').css('height');

        //Check if there is selected description
        var descriptionSelected = obj.find('.dd-selected-description');
        var imgSelected = obj.find('.dd-selected-image');
        if (descriptionSelected.length <= 0 && imgSelected.length > 0) {
            obj.find('.dd-selected-text').css('lineHeight', lSHeight);
        }
    }

    //Private: Adjust appearence for drop down options (move title to middle), when no desripction
    function adjustOptionsHeight(obj) {
        obj.find('.dd-option').each(function () {
            var $this = $(this);
            var lOHeight = $this.css('height');
            var descriptionOption = $this.find('.dd-option-description');
            var imgOption = obj.find('.dd-option-image');
            if (descriptionOption.length <= 0 && imgOption.length > 0) {
                $this.find('.dd-option-text').css('lineHeight', lOHeight);
            }
        });
    }

})(jQuery);

//GX
var wait_ajax_response = false;
var res_status_n = 1;
//
jQuery(document).ready(function( $ ) {
	if(jQuery('.thisIsTheNumber').length) {
		var number = jQuery('.thisIsTheNumber').text();
		jQuery('#input_6_5,#input_5_5').val(number);
	};
	if(jQuery('#trust-pilot-contain').length) {
		var width = jQuery('#trust-pilot-contain').width();
		jQuery('#tpiframe-box0').attr('width',width);
	};
	var smallState = false;
	var speed = 200;
	jQuery(window).scroll( function() {

		if(jQuery(window).width() > 980) {
			if(jQuery(window).scrollTop() > 75 && smallState != true ) {
				jQuery('#logo img')				.animate({ 			height:40 			},speed);
				jQuery('#header-wrapper')		.animate({			height:45 			},speed);
				jQuery('#top-widget')			.animate({			paddingTop:0 		},speed); 
				jQuery('.menu a')				.animate({			paddingTop:0		},speed);
				jQuery('.menu a')				.animate({			paddingBottom:0		},speed);
				jQuery('.skip-container')		.animate({			padding:4			},speed);
				jQuery('.churchShirts h2')		.animate({			marginTop:-5		},speed);
				jQuery('.phoneDescription')		.slideUp(speed);
				jQuery('.churchShirts p')		.slideUp(speed);
				jQuery('#nav-wrapper .search-foot form#searchform').animate({   	marginTop:6			},speed);
				smallState = true;
			} else if(jQuery(window).scrollTop() < 75 && smallState == true) {
				jQuery('#logo img')				.animate({			height:101			},speed);
				jQuery('#header-wrapper')		.animate({			height:117			},speed);
				jQuery('#top-widget')			.animate({			paddingTop:10 		},speed); 
				jQuery('.menu a')				.animate({			paddingTop:4.8		},speed);
				jQuery('.menu a')				.animate({			paddingBottom:4.8	},speed);
				jQuery('.skip-container')		.animate({			padding:8			},speed); 
				jQuery('.churchShirts h2')		.animate({			marginTop:10		},speed);
				jQuery('#nav-wrapper .search-foot form#searchform').animate({   	marginTop:10		},speed);
				jQuery('.phoneDescription')		.slideDown(speed);
				jQuery('.churchShirts p')		.slideDown(speed);
				smallState = false;
			}
		}
	});
	
	if(jQuery('.garment').length){
		displayOption = jQuery('.show-colors').attr('data-displayoption');
		if(displayOption == 'yes') {
			postID = jQuery('.show-colors').attr('data-postid');
			jQuery('.colorOption').click(function() {
				colorName = jQuery(this).attr('data-label');
				url = '/garmentImages/'+postID+'/'+colorName+'.jpg';
				jQuery('.garment-main .attachment-post-thumbnail').attr('src',url);
				
			});
		} else {
			jQuery('.colorOption').css('cursor','default');	
		}
	};
	
	if(jQuery('.faqTitle').length) {
		jQuery('.faqTitle').click(function() {
			var label = jQuery(this).attr('data-label');
			jQuery('.faqContent').hide();
			jQuery('.faqContent[data-label="'+label+'"]').show();
		});
	};
	
	jQuery('.testimonial').eq(0).fadeIn();
	setInterval(function() {
		if(jQuery('.testimonialSlider').length) {
			if(jQuery('.testimonialSlider').is(':hover')) {} else {
				jQuery('.testimonial').eq(0).fadeOut('slow',function() {
					jQuery('.testimonialStretchContainer').append(jQuery('.testimonial').eq(0));
				});
				jQuery('.testimonial').eq(1).fadeIn('slow');
			}
		}
	} , 5000);
	
	jQuery('.arrowContainerLeft').click(function() {
		jQuery('.testimonial').eq(0).fadeOut('slow',function() {
			jQuery('.testimonialStretchContainer').append(jQuery('.testimonial').eq(0));
		});
		jQuery('.testimonial').eq(1).fadeIn('slow');
	});
	jQuery('.arrowContainerRight').click(function() { 
		jQuery('.testimonial').eq(0).fadeOut('slow',function() {
			jQuery('.testimonialStretchContainer').prepend(jQuery('.testimonial').eq(-1));
		});
		jQuery('.testimonial').eq(-1).fadeIn('slow');
	});
	
	
	if(jQuery('.show-thumb-alt-outer').length) {
		var outer = jQuery('.show-thumb-alt-outer');
		var width = outer.width();
		var background = outer.attr('data-defaultshirt');
		var defaultDesign = outer.attr('data-defaultdesign');
		if(defaultDesign == 'darkDesign') {
			design = outer.attr('data-darkdesign');
		} else {
			design = outer.attr('data-lightdesign');
		}
		if(width >= 405) {
			jQuery('.show-thumb-alt-outer').css({
				'width':'405px',
				'height':'500px',
				'background-image':'url('+background+')'
			});
			jQuery('.show-thumb-alt-inner').css({
				'width':'405px',
				'height':'500px',
				'background-image':'url('+design+')'
			});
		} else {
			var ratio = 500 / 405;
			var height = width * ratio;	
			jQuery('.show-thumb-alt-outer').css({
				'width':width,
				'height':height,
				'background-image':'url('+background+')'
			});
			jQuery('.show-thumb-alt-inner').css({
				'width':width,
				'height':height,
				'background-image':'url('+design+')'
			});
		}
	}
	
	if(jQuery('.single-design').length && jQuery('.show-colors').length) {
		
		var colorImages = [];
		
		jQuery('.colorOption').each( function() {
			colorImages.push(jQuery(this).attr('data-image'));
		});
	
		preloadImages(colorImages);
		
		jQuery('.colorOption').click( function() {
			var style 		= jQuery(this).attr('data-style');
			var background 	= jQuery(this).attr('data-image');
			var colorName 	= jQuery(this).attr('data-label');
			if( style == 'Dark' ) {
				design = jQuery('.show-thumb-alt-outer').attr('data-darkdesign');
			} else {
				design = jQuery('.show-thumb-alt-outer').attr('data-lightdesign');
			}
			jQuery('.show-thumb-alt-outer').css({
				'background-image':'url('+background+')'
			});
			jQuery('.show-thumb-alt-inner').css({
				'background-image':'url('+design+')'
			});
			jQuery('.currentColorLabel').text(colorName);
		});
	}
	
	function preloadImages(array) {
		if (!preloadImages.list) {
			preloadImages.list = [];
		}
		var list = preloadImages.list;
		for (var i = 0; i < array.length; i++) {
			var img = new Image();
			img.crossOrigin = 'anonymous'; //GX
			img.onload = function() {
				var index = list.indexOf(this);
				if (index !== -1) {
					// remove image from the array once it's loaded
					// for memory consumption reasons
					list.splice(index, 1);
				}
			}
			list.push(img);
			img.src = array[i];
		}
	}
	
	i1 = 0;
	if(jQuery('#da_ink_color_1').length) {
		jQuery('#da_ink_color_1').ddslick({
			data:da_ink_colors_1,
			width:'100%',
			height:300,
			selectText: "Select your ink color",
			imagePosition:"left",
			onSelected: function(selectedData){
				if(i1 == 1) {
					da_paint_canvas();
				}
				i1 = 1;
			}   
		});
	};
	
	i2 = 0;
	if(jQuery('#da_ink_color_2').length) {
		jQuery('#da_ink_color_2').ddslick({
			data:da_ink_colors_2,
			width:'100%',
			height:300,
			selectText: "Select your ink color",
			imagePosition:"left",
			onSelected: function(selectedData){
				if(i2 == 1) {
					da_paint_canvas();
				}
				i2 = 1;
			}   
		});
	};
	
	i3 = 0;
	if(jQuery('#da_ink_color_3').length) {
		jQuery('#da_ink_color_3').ddslick({
			data:da_ink_colors_3,
			width:'100%',
			height:300,
			selectText: "Select your ink color",
			imagePosition:"left",
			onSelected: function(selectedData){
				if(i3 == 1) {
					da_paint_canvas();
				}
				i3 = 1;
			}   
		});
	};
	
	i4 = 0;
	if(jQuery('#da_ink_color_4').length) {
		jQuery('#da_ink_color_4').ddslick({
			data:da_ink_colors_4,
			width:'100%',
			height:300,
			selectText: "Select your ink color",
			imagePosition:"left",
			onSelected: function(selectedData){
				color = selectedData['selectedData']['color_code'];
				if(i4 == 1) {
					da_paint_canvas();
				}
				i4 = 1;
			}   
		});
	};
	
	i5 = 0;
	if(jQuery('#da_ink_color_5').length) {
		jQuery('#da_ink_color_5').ddslick({
			data:da_ink_colors_5,
			width:'100%',
			height:300,
			selectText: "Select your ink color",
			imagePosition:"left",
			onSelected: function(selectedData){
				color = selectedData['selectedData']['color_code'];
				if(i5 == 1) {
					da_paint_canvas();
				}
				i5 = 1;
			}   
		});
	};
	
	i6 = 0;
	if(jQuery('#da_ink_color_6').length) {
		jQuery('#da_ink_color_6').ddslick({
			data:da_ink_colors_6,
			width:'100%',
			height:300,
			selectText: "Select your ink color",
			imagePosition:"left",
			onSelected: function(selectedData){
				color = selectedData['selectedData']['color_code'];
				if(i6 == 1) {
					da_paint_canvas();
				}
				i6 = 1;
			}   
		});
	};
	
	// Function for loading the design on page load
	page_loaded = false;

	// Fetch the corresponding design layer image
	// console.log(color_codes);
	if(typeof color_codes !== 'undefined') {
		d = color_codes.length;
		for (var i = 1 ; i <= d ; i+= 1) {
			jQuery('#da_design_'+i).attr('crossorigin', 'anonymous'); //GX
			imageURL = jQuery('#da_design_'+i).attr('src');
			imageURL = imageURL.replace('http://djigfogczfdpe.cloudfront.net/',home_url);
			jQuery('#da_design_'+i).attr('src',imageURL);
			// console.log(imageURL);
		};
		
		i = 0;
		build_canvas = setInterval(function() {
	
			// Check if the toggles have all been initialized
			d = color_codes.length;
			
			color_toggle_status = jQuery('#da_ink_color_' + d ).data('ddslick');
			
			// If the check comes back undefined, do nothing
			if(typeof color_toggle_status == 'undefined') {
				
			// If it comes back true, build the canvas
			} else {
				
				// Paint the Canvas and setup the garment background
				da_switch_garment(true);
				
				if(isCanvasBlank() == true || i < 2) {
					da_paint_canvas(true);
					i++;
				} else {
					clearInterval(build_canvas);
					page_loaded = true;	
				};		
			}
		
		// Recheck every 100 milleseconds
		} , 100 );
	}

	// Function to check if the canvas has been drawn on yet.	
	function isCanvasBlank() {
		
		// Fetch the ttoal number of allowable design colors
		d = color_codes.length;
		
		// Create the layer_canvas array
		layer_canvas = new Array();

		// Create a blank canvas to test against
		var canvas = document.getElementById('design_canvas');
		var blank = document.createElement('canvas');
		blank.width = canvas.width;
		blank.height = canvas.height;
		
		// Loop through each of the design layer canvases
		var	blankstatus = false;
		for (var i = 1 ; i <= d ; i+= 1) {
			
			// Fetch the canvas for this layer
			layer_canvas[i] = document.getElementById('layer_canvas_'+i);
			if( canvas.toDataURL() == blank.toDataURL() ) {
				var blankstatus = true;	
			}
		}
		
		return blankstatus;
		
	}
	
	// Function for repainting the canvas for each design layer
	function da_paint_canvas(pageload) {

		// Count how many design layers there are
		d = color_codes.length;
		
		// Setup our variables
		var color_array = new Array();
		var color_info = new Array();
		var image = new Array();
		var imgd = new Array();
		var pix = new Array();
		var c = new Array();
		var uniqueColor = new Array();
		var layer_canvas = new Array();
		var layer_ctx = new Array();
		var imageURL = new Array();
		
		
		// If this is a page load and we have a query string....
		if (pageload !== undefined && QueryString !== false) {
			setDDslick('#da_garment_side' , QueryString.garment_side );
			
		// If this is a page load and we have saved session settings....
		} else if (pageload !== undefined && saved_settings !== null) {
			setDDslick('#da_garment_side' , saved_settings['garment_side']['selectedData']['value']);
		};

		// Loop through each design layer
		for (var i = 1 ; i <= d ; i+= 1) {
			
			// If this is the initial page load and we have Query Strings
			if (pageload !== undefined && QueryString != false) {
			
				// Locate the ink color element
				element 	= '#da_ink_color_' + i;
				
				// If there's only 1 color, it will be a string. Otherwise it will be an object.
				if(typeof(QueryString['color']) == 'object') {
					var o = i - 1;
					value = QueryString['color'][o];
				} else {
					value = QueryString['color'];	
				}
				//console.log(value);
				setDDslick('#da_ink_color_' + i , value );
				
				// Fetch the color code from the DDslick selector
				color_info[i] = jQuery('#da_ink_color_' + i ).data('ddslick');
				color_array[i] = color_info[i]['selectedData']['color_code'];
			
			// If this is the initial page load....
			} else if (pageload !== undefined && saved_settings !== null) {
							
				// Locate the ink color element
				element 	= '#da_ink_color_' + i;
				
				// If we have the setting saved....
				if( typeof(saved_settings['colors'][i]) != 'undefined' && saved_settings['colors'][i] != null && saved_settings != null ) {
					
					// Fetch the value and set it
					value 		= saved_settings['colors'][i]['selectedData']['value'];
					setDDslick('#da_ink_color_' + i , value);
					
				}

				// Fetch the color code from the DDslick selector
				color_info[i] = jQuery('#da_ink_color_' + i ).data('ddslick');
				color_array[i] = color_info[i]['selectedData']['color_code'];

			// If this is NOT the initial page load
			} else {
				
				// Fetch teh color code from the DDslick selector
				color_info[i] = jQuery('#da_ink_color_' + i ).data('ddslick');
				color_array[i] = color_info[i]['selectedData']['color_code'];
			
				// Store the information
				store_da_settings();

			}

			image[i] = document.getElementById('da_design_'+i);
			image[i].crossOrigin = 'anonymous'; //GX
		}


		// Setup our canvas variables
		var canvas = document.getElementById('design_canvas');
		var ctx = canvas.getContext('2d');
			for( var i = 1; i <= 1; i++){
				console.log(ctx);
			}
		// Clear the canvas so we have a clean slate each time
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		
		
		for (var i = 1; i <= d; i++) {
		
			// Create a temporary canvas
			jQuery('.da_showcase').append('<canvas id="layer_canvas_'+i+'" width="400" height="550" style="width:400px;height:550px;display:none;"></canvas>');
			layer_canvas[i] = document.getElementById('layer_canvas_'+i);
			layer_ctx[i] = layer_canvas[i].getContext('2d');
			layer_ctx[i].drawImage(image[i],0,0);
			
			// Fetch our data from the temporary canvas
			layer_ctx.crossOrigin = 'anonymous'; //GX
			imgd[i] = layer_ctx[i].getImageData(0, 0, 400, 550);
			//console.log( 'i'+i ); console.log(layer_ctx);
			pix[i] = imgd[i].data;
			
			c[i] = hexToRgb(color_array[i]);
			uniqueColor[i] = [c[i]['r'],c[i]['g'],c[i]['b']]; // Blue for an example, can change this value to be anything.
			
			// Loops through all of the pixels and modifies the components.
			for (var j = 0 , n = pix[i].length; j < n ; j += 4) {
				  pix[i][j] 	= uniqueColor[i][0];   // Red component
				  pix[i][j+1] 	= uniqueColor[i][1]; // Blue component
				  pix[i][j+2] 	= uniqueColor[i][2]; // Green component
				  //pix[i+3] is the transparency.
			}
			// console.log(pix[i].length);
			
		}
		
		for (var i = 1; i <= d; i++) {
			layer_ctx[i].putImageData(imgd[i], 0, 0);
			ctx.drawImage(layer_canvas[i],0,0);
			jQuery('#layer_canvas_'+i).remove();
		};
		
		// Setup our cloned canvas variables
		var canvas_clone = document.getElementById('design_canvas_clone');
		var ctx_clone = canvas_clone.getContext('2d');
		
		// Clear the canvas so we have a clean slate each time
		ctx_clone.clearRect(0, 0, canvas_clone.width, canvas_clone.height);
		ctx_clone.drawImage(canvas, 0, 0);
		
		// var savedImageData = document.getElementById("imageData");
		// savedImageData.src = canvas.toDataURL("image/png"); 
		
	}	
	
	
	jQuery('.da_request_proof').on( 'click' , function(event) {
		jQuery('.da-popup-outer').fadeIn();
	});
	if( $('.da-popup-outer .gform_validation_error').length ){ //GX
		$('.da-popup-outer').fadeIn();
	}
	
	jQuery(document).on('click', function(e){
		if(e.target.id == 'da-popup-outer') {
			jQuery('.da-popup-outer').fadeOut();
		}
	});
	
	jQuery('.da_popup_closer').on('click' , function(e) {
		jQuery('.da-popup-outer').fadeOut();
	});
	
	jQuery('.da_custimizer_textarea, .da_customizer_textarea_two').on('keyup paste', function() {
		ct_value = jQuery(this).val();
		jQuery('.da_customizer_textarea').val(ct_value);
		jQuery('.da_customizer_textarea_two').val(ct_value);
		jQuery('#input_6_8').val(ct_value);
	});
	jQuery('#field_6_5, #field_6_8').hide();
	
});

	function setDDslick(element,value) {
	
		var value = jQuery('<div/>').html(value).text();
	
		//#aSelectBox is the id of ddSlick selectbox
		jQuery(element+' li').each(function( index ) {
	
	  		//traverse all the options and get the value of current item
	  		var curValue = jQuery( this ).find('.dd-option-value').val();
	
	  		//check if the value is matching with the searching value
	  		if(curValue == value) {
		  
		  		//if found then use the current index number to make selected    
		  		jQuery(element).ddslick('select', {index: jQuery(this).index()});
	  		}
		});	
	}
	
	function find_garment(field_value) {
		
		var return_array = new Array();
		var selectedData 	= jQuery('#da_garment_selector').data('ddslick');
		
		jQuery.each( selectedData['settings']['data'] , function( index , value ){
			if(field_value == value['value']) {
				return_array['selectedData'] = value;	
			}
		});
		
		return return_array;
		
	}
	
	function decodeHtml(html) {
		var txt = document.createElement("textarea");
		txt.innerHTML = html;
		return txt.value;
	}
	
	function store_da_settings() {
		
		// Fetch the colors
		d = color_codes.length;
		var color_info = new Array();
		for (var i = 1 ; i <= d ; i+= 1) {
			color_info[i] = jQuery('#da_ink_color_' + i ).data('ddslick');
		};
		
		// Prep the information for storage
		storage_array = {
			'colors' 		: color_info ,
			'garment' 		: jQuery('#da_garment_selector' ).data('ddslick') ,
			'garment_color' : jQuery('#da_garment_color' ).data('ddslick') ,
			'garment_side'	: jQuery('#da_garment_side' ).data('ddslick')
		};
		
		// console.log(storage_array['garment']);
		// console.log(saved_settings['garment']);
		// Store the information in the local storage
		localStorage.setItem('design_settings_'+post_id, JSON.stringify(storage_array));
		// Build the information for the form submission data
		
		// Set the variables to begin building the message and the weblink
		var message = '';
		var weblink = window.location.href + '?custom=true';
				
		// Add the Garment Selection to the message and the weblink
		message += 'Selected Garment: \n';
		if(typeof(storage_array['garment']) != 'undefined') {
			message += decodeHtml(storage_array['garment']['selectedData']['value']) + '\n';	
			weblink += '&garment='+encodeURIComponent(storage_array['garment']['selectedData']['value']);
		}
		
		// Add the Garment Color Selection to the message and the weblink
		message += '\nSelected Garment Color: \n';
		if(typeof(storage_array['garment_color']) != 'undefined') {
			message += decodeHtml(storage_array['garment_color']['selectedData']['value']) + '\n';	
			weblink += '&garment_color='+encodeURIComponent(storage_array['garment_color']['selectedData']['value']);
		}
		
		// Add the Garment Front/Back Selection to the message and the weblink
		message += '\nSelected Garment Side: \n';
		if(typeof(storage_array['garment_side']) != 'undefined') {
			message += decodeHtml(storage_array['garment_side']['selectedData']['value']) + '\n';	
			weblink += '&garment_side='+encodeURIComponent(storage_array['garment_side']['selectedData']['value']);
		}
				
		// Add the Ink Colors to the message and the weblink
		message += '\nSelected Ink Colors: \n';
		for (var i = 1 ; i <= d ; i+=1 ) {
			if(typeof(color_info[i]) != 'undefined') {
				message += i + ': ' + color_info[i]['selectedData']['text'] + '\n';
				weblink += '&color='+encodeURIComponent(color_info[i]['selectedData']['value']);
			} 
		}
		
		// Add the weblink to the Message
		message += '\nQuick Link: \n';
		message += weblink;
		console.log(weblink);
		// Attach the message to the correct form field
		jQuery('.da_configuration_field textarea').val(message);
		
		// console.log(QueryString.garment);
		// console.log(message);
		// console.log(weblink);
		
	};

	
	function da_switch_garment(pageload) {
		
		// Retrieve the object from storage
		// var saved_settings = localStorage.getItem('design_settings_'+post_id);
		// var saved_settings = JSON.parse(saved_settings);
		
		// console.log(saved_settings);

		//GX wait for response script
		if( wait_ajax_response == true ){
			//res_status_n++;
			return false;
		}
		console.log('new response garment');
		wait_ajax_response = true;

		// If this is the initial page load and we have a Query String
		if (pageload !== undefined && QueryString != false && !QueryString['w3tc_note']) {
			
			// Fetch the garment and garment color
			var garment_color = QueryString['garment_color'];
			var selectedData 	= find_garment(QueryString['garment']);;
			setDDslick('#da_garment_selector',QueryString['garment']);
			
		// If this is the initial page load and we have saved settings
		} else if (pageload !== undefined && saved_settings !== null) {
			
			// Create the Garment Color Variables
			if(typeof(saved_settings['garment_color']) != 'undefined') {
				var garment_color 	= saved_settings['garment_color']['selectedData']['text'];
			} else {
				var garment_color 	= jQuery('#da_garment_color').data('ddslick');
				garment_color   	= garment_color['selectedData']['text'];
			}
			
			if(typeof(saved_settings['garment']) != 'undefined') {
				var selectedData 	= saved_settings['garment'];
			} else {
				var selectedData 	= jQuery('#da_garment_selector').data('ddslick');
			}
						
			setDDslick('#da_garment_selector',selectedData['selectedData']['value']);

		// If this is not the initial page load or we don't have saved settings				
		} else {
			var garment_color 	= jQuery('#da_garment_color').data('ddslick');
			garment_color   	= garment_color['selectedData']['text'];
			var selectedData 	= jQuery('#da_garment_selector').data('ddslick');
		}
		
		var color_qty		= jQuery('.da_color_qty').text();
		var data = {
			'action'		: 'da_builder',
			'post_id'		: selectedData['selectedData']['post_id'],
			'garment_color'	: garment_color,
			'color_qty'		: color_qty
		};
        jQuery('.i_product_loading').show();
		// Ping the server and fetch the new information then run a callback function
		jQuery.post(home_url+'/wp-admin/admin-ajax.php', data, function(response) {
			info = JSON.parse(response);
			
			// Update the garment color select options
			jQuery('#da_garment_color').ddslick('destroy');
			create_slick_garment_colors(info['colors']);
			
			// Update the garment description
			jQuery('.da_description_full').html(info['description']);
			jQuery('.da_garment_name').html(info['title']);
		
			// Update the pricing table
			jQuery('.da_prices td').each(function() {
				index = jQuery(this).attr('data-qty');
				jQuery(this).text('$'+ info['prices'][index]);
			});
			
			// If this is the pageload and we have a query string
			if (pageload !== undefined && QueryString !== false) {

				// Set the garment Side
				var garment_side	= QueryString.garment_side;
				// console.log(garment_side);

				// Set the garment color
				var garment_color	= jQuery('#da_garment_color').data('ddslick');

			// If this is the pageload and we have saved settings from a previous session....
			} else if (pageload !== undefined && saved_settings !== null) {

				// Set the garment Side
				var garment_side 	= saved_settings['garment_side'];
				garment_side		= garment_side['selectedData']['value'];

				// Set the garment color
				var garment_color	= saved_settings['garment_color'];

				// setDDslick('#da_garment_color',saved_settings['garment_color']['selectedData']['value']);

			// If this is not a pageload....
			} else {
			
				// Set the garment Side
				var garment_side 	= jQuery('#da_garment_side').data('ddslick');
				garment_side		= garment_side['selectedData']['value'];
				
				// Set the garment color
				var garment_color 	= jQuery('#da_garment_color').data('ddslick');
			}
			
			// If the garment side is set to front....
			if(garment_side == 'front') {
				jQuery('.background_garment').attr('src',garment_color['selectedData']['shirt_front']);
				
			// If the Garment Side is set to back....
			} else {
				jQuery('.background_garment').attr('src',garment_color['selectedData']['shirt_back']);
			}

            jQuery('.i_product_loading').hide();
		}).always(function() {
			wait_ajax_response = false;
		});
		
	}
	
/*!
 * Masonry PACKAGED v4.0.0
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

!function(t,e){"use strict";"function"==typeof define&&define.amd?define("jquery-bridget/jquery-bridget",["jquery"],function(i){e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("jquery")):t.jQueryBridget=e(t,t.jQuery)}(window,function(t,e){"use strict";function i(i,r,a){function h(t,e,n){var o,r="$()."+i+'("'+e+'")';return t.each(function(t,h){var u=a.data(h,i);if(!u)return void s(i+" not initialized. Cannot call methods, i.e. "+r);var d=u[e];if(!d||"_"==e.charAt(0))return void s(r+" is not a valid method");var c=d.apply(u,n);o=void 0===o?c:o}),void 0!==o?o:t}function u(t,e){t.each(function(t,n){var o=a.data(n,i);o?(o.option(e),o._init()):(o=new r(n,e),a.data(n,i,o))})}a=a||e||t.jQuery,a&&(r.prototype.option||(r.prototype.option=function(t){a.isPlainObject(t)&&(this.options=a.extend(!0,this.options,t))}),a.fn[i]=function(t){if("string"==typeof t){var e=o.call(arguments,1);return h(this,t,e)}return u(this,t),this},n(a))}function n(t){!t||t&&t.bridget||(t.bridget=i)}var o=Array.prototype.slice,r=t.console,s="undefined"==typeof r?function(){}:function(t){r.error(t)};return n(e||t.jQuery),i}),function(t,e){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",e):"object"==typeof module&&module.exports?module.exports=e():t.EvEmitter=e()}(this,function(){function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},n=i[t]=i[t]||[];return-1==n.indexOf(e)&&n.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{},n=i[t]=i[t]||[];return n[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=i.indexOf(e);return-1!=n&&i.splice(n,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=0,o=i[n];e=e||[];for(var r=this._onceEvents&&this._onceEvents[t];o;){var s=r&&r[o];s&&(this.off(t,o),delete r[o]),o.apply(this,e),n+=s?0:1,o=i[n]}return this}},t}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("get-size/get-size",[],function(){return e()}):"object"==typeof module&&module.exports?module.exports=e():t.getSize=e()}(window,function(){"use strict";function t(t){var e=parseFloat(t),i=-1==t.indexOf("%")&&!isNaN(e);return i&&e}function e(){}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0;u>e;e++){var i=h[e];t[i]=0}return t}function n(t){var e=getComputedStyle(t);return e||a("Style returned "+e+". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"),e}function o(){if(!d){d=!0;var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style.boxSizing="border-box";var i=document.body||document.documentElement;i.appendChild(e);var o=n(e);r.isBoxSizeOuter=s=200==t(o.width),i.removeChild(e)}}function r(e){if(o(),"string"==typeof e&&(e=document.querySelector(e)),e&&"object"==typeof e&&e.nodeType){var r=n(e);if("none"==r.display)return i();var a={};a.width=e.offsetWidth,a.height=e.offsetHeight;for(var d=a.isBorderBox="border-box"==r.boxSizing,c=0;u>c;c++){var l=h[c],f=r[l],m=parseFloat(f);a[l]=isNaN(m)?0:m}var p=a.paddingLeft+a.paddingRight,g=a.paddingTop+a.paddingBottom,y=a.marginLeft+a.marginRight,v=a.marginTop+a.marginBottom,_=a.borderLeftWidth+a.borderRightWidth,E=a.borderTopWidth+a.borderBottomWidth,z=d&&s,b=t(r.width);b!==!1&&(a.width=b+(z?0:p+_));var x=t(r.height);return x!==!1&&(a.height=x+(z?0:g+E)),a.innerWidth=a.width-(p+_),a.innerHeight=a.height-(g+E),a.outerWidth=a.width+y,a.outerHeight=a.height+v,a}}var s,a="undefined"==typeof console?e:function(t){console.error(t)},h=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"],u=h.length,d=!1;return r}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("matches-selector/matches-selector",e):"object"==typeof module&&module.exports?module.exports=e():t.matchesSelector=e()}(window,function(){"use strict";var t=function(){var t=Element.prototype;if(t.matches)return"matches";if(t.matchesSelector)return"matchesSelector";for(var e=["webkit","moz","ms","o"],i=0;i<e.length;i++){var n=e[i],o=n+"MatchesSelector";if(t[o])return o}}();return function(e,i){return e[t](i)}}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["matches-selector/matches-selector"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("desandro-matches-selector")):t.fizzyUIUtils=e(t,t.matchesSelector)}(window,function(t,e){var i={};i.extend=function(t,e){for(var i in e)t[i]=e[i];return t},i.modulo=function(t,e){return(t%e+e)%e},i.makeArray=function(t){var e=[];if(Array.isArray(t))e=t;else if(t&&"number"==typeof t.length)for(var i=0;i<t.length;i++)e.push(t[i]);else e.push(t);return e},i.removeFrom=function(t,e){var i=t.indexOf(e);-1!=i&&t.splice(i,1)},i.getParent=function(t,i){for(;t!=document.body;)if(t=t.parentNode,e(t,i))return t},i.getQueryElement=function(t){return"string"==typeof t?document.querySelector(t):t},i.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},i.filterFindElements=function(t,n){t=i.makeArray(t);var o=[];return t.forEach(function(t){if(t instanceof HTMLElement){if(!n)return void o.push(t);e(t,n)&&o.push(t);for(var i=t.querySelectorAll(n),r=0;r<i.length;r++)o.push(i[r])}}),o},i.debounceMethod=function(t,e,i){var n=t.prototype[e],o=e+"Timeout";t.prototype[e]=function(){var t=this[o];t&&clearTimeout(t);var e=arguments,r=this;this[o]=setTimeout(function(){n.apply(r,e),delete r[o]},i||100)}},i.docReady=function(t){"complete"==document.readyState?t():document.addEventListener("DOMContentLoaded",t)},i.toDashed=function(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()};var n=t.console;return i.htmlInit=function(e,o){i.docReady(function(){var r=i.toDashed(o),s="data-"+r,a=document.querySelectorAll("["+s+"]"),h=document.querySelectorAll(".js-"+r),u=i.makeArray(a).concat(i.makeArray(h)),d=s+"-options",c=t.jQuery;u.forEach(function(t){var i,r=t.getAttribute(s)||t.getAttribute(d);try{i=r&&JSON.parse(r)}catch(a){return void(n&&n.error("Error parsing "+s+" on "+t.className+": "+a))}var h=new e(t,i);c&&c.data(t,o,h)})})},i}),function(t,e){"function"==typeof define&&define.amd?define("outlayer/item",["ev-emitter/ev-emitter","get-size/get-size"],function(i,n){return e(t,i,n)}):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter"),require("get-size")):(t.Outlayer={},t.Outlayer.Item=e(t,t.EvEmitter,t.getSize))}(window,function(t,e,i){"use strict";function n(t){for(var e in t)return!1;return e=null,!0}function o(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}function r(t){return t.replace(/([A-Z])/g,function(t){return"-"+t.toLowerCase()})}var s=document.documentElement.style,a="string"==typeof s.transition?"transition":"WebkitTransition",h="string"==typeof s.transform?"transform":"WebkitTransform",u={WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[a],d=[h,a,a+"Duration",a+"Property"],c=o.prototype=Object.create(e.prototype);c.constructor=o,c._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},c.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},c.getSize=function(){this.size=i(this.element)},c.css=function(t){var e=this.element.style;for(var i in t){var n=d[i]||i;e[n]=t[i]}},c.getPosition=function(){var t=getComputedStyle(this.element),e=this.layout._getOption("originLeft"),i=this.layout._getOption("originTop"),n=t[e?"left":"right"],o=t[i?"top":"bottom"],r=this.layout.size,s=-1!=n.indexOf("%")?parseFloat(n)/100*r.width:parseInt(n,10),a=-1!=o.indexOf("%")?parseFloat(o)/100*r.height:parseInt(o,10);s=isNaN(s)?0:s,a=isNaN(a)?0:a,s-=e?r.paddingLeft:r.paddingRight,a-=i?r.paddingTop:r.paddingBottom,this.position.x=s,this.position.y=a},c.layoutPosition=function(){var t=this.layout.size,e={},i=this.layout._getOption("originLeft"),n=this.layout._getOption("originTop"),o=i?"paddingLeft":"paddingRight",r=i?"left":"right",s=i?"right":"left",a=this.position.x+t[o];e[r]=this.getXValue(a),e[s]="";var h=n?"paddingTop":"paddingBottom",u=n?"top":"bottom",d=n?"bottom":"top",c=this.position.y+t[h];e[u]=this.getYValue(c),e[d]="",this.css(e),this.emitEvent("layout",[this])},c.getXValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&!e?t/this.layout.size.width*100+"%":t+"px"},c.getYValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&e?t/this.layout.size.height*100+"%":t+"px"},c._transitionTo=function(t,e){this.getPosition();var i=this.position.x,n=this.position.y,o=parseInt(t,10),r=parseInt(e,10),s=o===this.position.x&&r===this.position.y;if(this.setPosition(t,e),s&&!this.isTransitioning)return void this.layoutPosition();var a=t-i,h=e-n,u={};u.transform=this.getTranslate(a,h),this.transition({to:u,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},c.getTranslate=function(t,e){var i=this.layout._getOption("originLeft"),n=this.layout._getOption("originTop");return t=i?t:-t,e=n?e:-e,"translate3d("+t+"px, "+e+"px, 0)"},c.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},c.moveTo=c._transitionTo,c.setPosition=function(t,e){this.position.x=parseInt(t,10),this.position.y=parseInt(e,10)},c._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to);for(var e in t.onTransitionEnd)t.onTransitionEnd[e].call(this)},c._transition=function(t){if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(t);var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);var n=this.element.offsetHeight;n=null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0};var l="opacity,"+r(d.transform||"transform");c.enableTransition=function(){this.isTransitioning||(this.css({transitionProperty:l,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(u,this,!1))},c.transition=o.prototype[a?"_transition":"_nonTransition"],c.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},c.onotransitionend=function(t){this.ontransitionend(t)};var f={"-webkit-transform":"transform"};c.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,i=f[t.propertyName]||t.propertyName;if(delete e.ingProperties[i],n(e.ingProperties)&&this.disableTransition(),i in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[i]),i in e.onEnd){var o=e.onEnd[i];o.call(this),delete e.onEnd[i]}this.emitEvent("transitionEnd",[this])}},c.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(u,this,!1),this.isTransitioning=!1},c._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var m={transitionProperty:"",transitionDuration:""};return c.removeTransitionStyles=function(){this.css(m)},c.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},c.remove=function(){return a&&parseFloat(this.layout.options.transitionDuration)?(this.once("transitionEnd",function(){this.removeElem()}),void this.hide()):void this.removeElem()},c.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options,e={},i=this.getHideRevealTransitionEndProperty("visibleStyle");e[i]=this.onRevealTransitionEnd,this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0,onTransitionEnd:e})},c.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},c.getHideRevealTransitionEndProperty=function(t){var e=this.layout.options[t];if(e.opacity)return"opacity";for(var i in e)return i},c.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options,e={},i=this.getHideRevealTransitionEndProperty("hiddenStyle");e[i]=this.onHideTransitionEnd,this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:e})},c.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},c.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},o}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["ev-emitter/ev-emitter","get-size/get-size","fizzy-ui-utils/utils","./item"],function(i,n,o,r){return e(t,i,n,o,r)}):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):t.Outlayer=e(t,t.EvEmitter,t.getSize,t.fizzyUIUtils,t.Outlayer.Item)}(window,function(t,e,i,n,o){"use strict";function r(t,e){var i=n.getQueryElement(t);if(!i)return void(a&&a.error("Bad element for "+this.constructor.namespace+": "+(i||t)));this.element=i,h&&(this.$element=h(this.element)),this.options=n.extend({},this.constructor.defaults),this.option(e);var o=++d;this.element.outlayerGUID=o,c[o]=this,this._create();var r=this._getOption("initLayout");r&&this.layout()}function s(t){function e(){t.apply(this,arguments)}return e.prototype=Object.create(t.prototype),e.prototype.constructor=e,e}var a=t.console,h=t.jQuery,u=function(){},d=0,c={};r.namespace="outlayer",r.Item=o,r.defaults={containerStyle:{position:"relative"},initLayout:!0,originLeft:!0,originTop:!0,resize:!0,resizeContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}};var l=r.prototype;return n.extend(l,e.prototype),l.option=function(t){n.extend(this.options,t)},l._getOption=function(t){var e=this.constructor.compatOptions[t];return e&&void 0!==this.options[e]?this.options[e]:this.options[t]},r.compatOptions={initLayout:"isInitLayout",horizontal:"isHorizontal",layoutInstant:"isLayoutInstant",originLeft:"isOriginLeft",originTop:"isOriginTop",resize:"isResizeBound",resizeContainer:"isResizingContainer"},l._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),n.extend(this.element.style,this.options.containerStyle);var t=this._getOption("resize");t&&this.bindResize()},l.reloadItems=function(){this.items=this._itemize(this.element.children)},l._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,n=[],o=0;o<e.length;o++){var r=e[o],s=new i(r,this);n.push(s)}return n},l._filterFindItemElements=function(t){return n.filterFindElements(t,this.options.itemSelector)},l.getItemElements=function(){return this.items.map(function(t){return t.element})},l.layout=function(){this._resetLayout(),this._manageStamps();var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;this.layoutItems(this.items,e),this._isLayoutInited=!0},l._init=l.layout,l._resetLayout=function(){this.getSize()},l.getSize=function(){this.size=i(this.element)},l._getMeasurement=function(t,e){var n,o=this.options[t];o?("string"==typeof o?n=this.element.querySelector(o):o instanceof HTMLElement&&(n=o),this[t]=n?i(n)[e]:o):this[t]=0},l.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},l._getItemsForLayout=function(t){return t.filter(function(t){return!t.isIgnored})},l._layoutItems=function(t,e){if(this._emitCompleteOnItems("layout",t),t&&t.length){var i=[];t.forEach(function(t){var n=this._getItemLayoutPosition(t);n.item=t,n.isInstant=e||t.isLayoutInstant,i.push(n)},this),this._processLayoutQueue(i)}},l._getItemLayoutPosition=function(){return{x:0,y:0}},l._processLayoutQueue=function(t){t.forEach(function(t){this._positionItem(t.item,t.x,t.y,t.isInstant)},this)},l._positionItem=function(t,e,i,n){n?t.goTo(e,i):t.moveTo(e,i)},l._postLayout=function(){this.resizeContainer()},l.resizeContainer=function(){var t=this._getOption("resizeContainer");if(t){var e=this._getContainerSize();e&&(this._setContainerMeasure(e.width,!0),this._setContainerMeasure(e.height,!1))}},l._getContainerSize=u,l._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},l._emitCompleteOnItems=function(t,e){function i(){o.dispatchEvent(t+"Complete",null,[e])}function n(){s++,s==r&&i()}var o=this,r=e.length;if(!e||!r)return void i();var s=0;e.forEach(function(e){e.once(t,n)})},l.dispatchEvent=function(t,e,i){var n=e?[e].concat(i):i;if(this.emitEvent(t,n),h)if(this.$element=this.$element||h(this.element),e){var o=h.Event(e);o.type=t,this.$element.trigger(o,i)}else this.$element.trigger(t,i)},l.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},l.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},l.stamp=function(t){t=this._find(t),t&&(this.stamps=this.stamps.concat(t),t.forEach(this.ignore,this))},l.unstamp=function(t){t=this._find(t),t&&t.forEach(function(t){n.removeFrom(this.stamps,t),this.unignore(t)},this)},l._find=function(t){return t?("string"==typeof t&&(t=this.element.querySelectorAll(t)),t=n.makeArray(t)):void 0},l._manageStamps=function(){this.stamps&&this.stamps.length&&(this._getBoundingRect(),this.stamps.forEach(this._manageStamp,this))},l._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},l._manageStamp=u,l._getElementOffset=function(t){var e=t.getBoundingClientRect(),n=this._boundingRect,o=i(t),r={left:e.left-n.left-o.marginLeft,top:e.top-n.top-o.marginTop,right:n.right-e.right-o.marginRight,bottom:n.bottom-e.bottom-o.marginBottom};return r},l.handleEvent=n.handleEvent,l.bindResize=function(){t.addEventListener("resize",this),this.isResizeBound=!0},l.unbindResize=function(){t.removeEventListener("resize",this),this.isResizeBound=!1},l.onresize=function(){this.resize()},n.debounceMethod(r,"onresize",100),l.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},l.needsResizeLayout=function(){var t=i(this.element),e=this.size&&t;return e&&t.innerWidth!==this.size.innerWidth},l.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},l.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},l.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},l.reveal=function(t){this._emitCompleteOnItems("reveal",t),t&&t.length&&t.forEach(function(t){t.reveal()})},l.hide=function(t){this._emitCompleteOnItems("hide",t),t&&t.length&&t.forEach(function(t){t.hide()})},l.revealItemElements=function(t){var e=this.getItems(t);this.reveal(e)},l.hideItemElements=function(t){var e=this.getItems(t);this.hide(e)},l.getItem=function(t){for(var e=0;e<this.items.length;e++){var i=this.items[e];if(i.element==t)return i}},l.getItems=function(t){t=n.makeArray(t);var e=[];return t.forEach(function(t){var i=this.getItem(t);i&&e.push(i)},this),e},l.remove=function(t){var e=this.getItems(t);this._emitCompleteOnItems("remove",e),e&&e.length&&e.forEach(function(t){t.remove(),n.removeFrom(this.items,t)},this)},l.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="",this.items.forEach(function(t){t.destroy()}),this.unbindResize();var e=this.element.outlayerGUID;delete c[e],delete this.element.outlayerGUID,h&&h.removeData(this.element,this.constructor.namespace)},r.data=function(t){t=n.getQueryElement(t);var e=t&&t.outlayerGUID;return e&&c[e]},r.create=function(t,e){var i=s(r);return i.defaults=n.extend({},r.defaults),n.extend(i.defaults,e),i.compatOptions=n.extend({},r.compatOptions),i.namespace=t,i.data=r.data,i.Item=s(o),n.htmlInit(i,t),h&&h.bridget&&h.bridget(t,i),i},r.Item=o,r}),function(t,e){"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("outlayer"),require("get-size")):t.Masonry=e(t.Outlayer,t.getSize)}(window,function(t,e){var i=t.create("masonry");return i.compatOptions.fitWidth="isFitWidth",i.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var t=0;t<this.cols;t++)this.colYs.push(0);this.maxY=0},i.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}var n=this.columnWidth+=this.gutter,o=this.containerWidth+this.gutter,r=o/n,s=n-o%n,a=s&&1>s?"round":"floor";r=Math[a](r),this.cols=Math.max(r,1)},i.prototype.getContainerWidth=function(){var t=this._getOption("fitWidth"),i=t?this.element.parentNode:this.element,n=e(i);this.containerWidth=n&&n.innerWidth},i.prototype._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,i=e&&1>e?"round":"ceil",n=Math[i](t.size.outerWidth/this.columnWidth);n=Math.min(n,this.cols);for(var o=this._getColGroup(n),r=Math.min.apply(Math,o),s=o.indexOf(r),a={x:this.columnWidth*s,y:r},h=r+t.size.outerHeight,u=this.cols+1-o.length,d=0;u>d;d++)this.colYs[s+d]=h;return a},i.prototype._getColGroup=function(t){if(2>t)return this.colYs;for(var e=[],i=this.cols+1-t,n=0;i>n;n++){var o=this.colYs.slice(n,n+t);e[n]=Math.max.apply(Math,o)}return e},i.prototype._manageStamp=function(t){var i=e(t),n=this._getElementOffset(t),o=this._getOption("originLeft"),r=o?n.left:n.right,s=r+i.outerWidth,a=Math.floor(r/this.columnWidth);a=Math.max(0,a);var h=Math.floor(s/this.columnWidth);h-=s%this.columnWidth?0:1,h=Math.min(this.cols-1,h);for(var u=this._getOption("originTop"),d=(u?n.top:n.bottom)+i.outerHeight,c=a;h>=c;c++)this.colYs[c]=Math.max(d,this.colYs[c])},i.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this._getOption("fitWidth")&&(t.width=this._getContainerFitWidth()),t},i.prototype._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},i.prototype.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!=this.containerWidth},i});

jQuery(document).ready(function($) {
	setTimeout( function() {
		jQuery('.group-names').masonry({
		  // options...
		  itemSelector: '.grid'
		});
	} , 500 );
        
        $("#nav-wrapper .grid.col-700>img").click(function() {
            $( "#nav-wrapper .col-220.grid.fit.search-foot" ).toggle( "slow", function() {
            });
          });
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