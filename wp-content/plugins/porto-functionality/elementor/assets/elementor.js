jQuery(document).ready(function($) {
	'use strict';

	if (typeof elementorFrontend != 'undefined' && typeof elementor != 'undefined') {

		function porto_gcd( a, b ) {
			if (typeof a == 'undefined') {
				return false;
			}
			if ( Array.isArray( a ) ) {
				var len = a.length;
				if ( 1 === len ) {
					return a[0];
				}
				if ( 2 === len ) {
					return porto_gcd( a[0], a[1] );
				} else if ( len > 2 ) {
					return porto_gcd( a.pop(), porto_gcd( a ) );
				}
			} else {
				var max = Math.max( a, b ),
					min = Math.min( a, b ),
					rem = max % min;
				max = min;
				min = rem;
				if ( 0 === rem ) {
					return max;
				} else {
					return porto_gcd( max, min );
				}
			}
		}

		function porto_lcm( a, b ) {
			if ( Array.isArray( a ) ) {
				var len = a.length;
				if ( 1 === len ) {
					return a[0];
				}
				if ( 2 === len ) {
					return porto_lcm( a[0], a[1] );
				} else {
					return porto_lcm( a.pop(), porto_lcm( a ) );
				}
			} else {
				return ( a * b ) / porto_gcd( a, b );
			}
		}

		// init variables
		var refresh_timer = null,
			refresh_timer1 = null;

		elementor.channels.data.on('element:after:add', function(item) {
			if ('column' != item.elType) {
				return;
			}
			var $this = $('.elementor-element-' + item.id),
				$row  = $this.closest('.elementor-row');
			if ($row.hasClass('owl-carousel')) { // carousel
				$row.trigger('add.owl.carousel', $this);
				$row.trigger('refresh.owl.carousel', $this);
			} else if (typeof $row.attr('data-plugin-masonry') != 'undefined') { // isotope
				porto_init_creative_layout($row);
				if (!($this.get(0) instanceof HTMLElement)) {
					Object.setPrototypeOf($this.get(0), HTMLElement.prototype);
				}
				$this.addClass('porto-grid-item');
				$row.removeData('__masonry');
				if ($row.data('isotope')) {
					$row.isotope('destroy');
				}
				$row.themeMasonry($row.data('plugin-options'));
			}
		});

		function porto_init_creative_layout($obj) {
			var index = $obj.data('layout');
			$obj.children('.elementor-column').addClass('porto-grid-item');
			if (index) { // preset layout
				if (typeof porto_elementor_vars.creative_layouts[parseInt(index, 10)] == 'undefined') {
					return;
				}
				var item_classes = porto_elementor_vars.creative_layouts[Number(index)];
				$obj.children('.elementor-column').each(function(i) {
					if (typeof item_classes[i % item_classes.length] != 'undefined') {
						var current_classes = $(this).attr('class').split(' '),
							new_classes = item_classes[i % item_classes.length];
						for (var j = 0; j < current_classes.length; j++) {
							var c = $.trim(current_classes[j]);
							if (c && c.indexOf('grid-') === -1) {
								new_classes += ' ' + c;
							}
						}
						new_classes = new_classes.replace(' porto-grid-item', '');
						$(this).attr('class', new_classes + ' porto-grid-item');
					}
				});
				if ($obj.prev('style[data-id="' + escape(index) + '"]').length < 1) {
					$.ajax({
						url: theme.ajax_url,
						data: {
							action: 'porto_load_creative_layout_style',
							nonce: js_porto_vars.porto_nonce,
							layout: index,
							grid_height: $obj.data('grid-height'),
							spacing: $obj.data('spacing'),
							selector: '.elementor-element.elementor-element-' + $obj.parent().parent().data('id')
						},
						type: 'post',
						success: function(res) {
							$obj.prev('style').remove();
							$(res).insertBefore($obj);
							$obj.isotope('layout');
						}
					});
				}
			} else if (!$obj.hasClass('porto-preset-layout')) { // normal
				var fractions = [],
					denominators = [],
					numerators = [];
				$obj.children().each(function() {
					if ($(this).hasClass('grid-col-sizer')) {
						return;
					}
					var percent_w = $(this).children('.elementor-column-wrap').data('width');
					if (percent_w && percent_w.size) {
						var arr;
						percent_w = percent_w.size;
						if ( parseFloat( parseInt( percent_w, 10 ) ) === parseFloat( percent_w ) ) { // integer
							arr = [percent_w, 1];
						} else {
							for ( var index = 2; index <= 100; index++ ) {
								var r_w = ( percent_w * index ).toFixed(1);
								if ( parseFloat( parseInt( r_w, 10 ) ) === r_w ) { //integer
									var gcd = porto_gcd( r_w, index );
									arr = [r_w / gcd, index / gcd];
								}
							}

							if ( typeof arr == 'undefined' ) {
								percent_w = Math.floor( percent_w * 10 );
								var gcd = porto_gcd( percent_w, 10 );
								arr = [percent_w / gcd, 10 / gcd];
							}
						}
						if ( typeof arr != 'undefined' && -1 === fractions.indexOf( arr ) ) {
							fractions.push(arr);
							numerators.push(arr[0]);
							denominators.push(arr[1]);
						}
					}
				});

				if ( fractions.length ) {
					var deno_lcm = porto_lcm( denominators ),
						num_gcd  = porto_gcd( numerators ),
						unit_num = ( num_gcd / deno_lcm ).toFixed(4);
					if ( unit_num >= 0.1 ) {
						$obj.children('.grid-col-sizer').css({width: unit_num + '%', flex: '0 0 ' + unit_num + '%'});
					}
				}

				if ($obj.data('isotope')) {
					$obj.isotope('layout');
				}
			}
		}

		$('.elementor-row[data-plugin-masonry]').children('.elementor-column').each(function() {
			if (!(this instanceof HTMLElement)) {
				Object.setPrototypeOf(this, HTMLElement.prototype);
			}
		});
		/*$('.elementor-row[data-plugin-masonry]').each(function() {
			porto_init_creative_layout($(this));
			$(this).addClass('porto-init');
		});*/

		if (typeof porto_init == 'function') {
			elementor.channels.data.on('element:before:remove', function(item) {
				if ('column' != item.attributes.elType) {
					return;
				}
				var $this = $('.elementor-element-' + item.id),
					$row  = $this.closest('.elementor-row');
				if ($row.hasClass('owl-carousel')) { // carousel
					var index = $this.parent('.owl-item:not(.cloned)').index() - ($row.find('.owl-item.cloned').length / 2);
					$row.trigger('remove.owl.carousel', index);
					$row.trigger('refresh.owl.carousel', $this);
				} else if (typeof $row.attr('data-plugin-masonry') != 'undefined' && $row.data('isotope')) { // isotope
					porto_init_creative_layout($row);
					$row.isotope('remove', $this).isotope('layout');
				}
			});

			var porto_widgets = ['porto_blog.default', 'wp-widget-recent_posts-widget.default', 'wp-widget-recent_portfolios-widget.default', 'porto_products.default', 'porto_product_categories.default', 'porto_recent_posts.default', 'shortcode.default', 'porto_portfolios.default', 'porto_button.default'];
			$.each(porto_widgets, function(key, element_name) {
				elementorFrontend.hooks.addAction('frontend/element_ready/' + element_name, function($obj) {
					var $iso_obj = $obj.find('[data-plugin-masonry]').length ? $obj.find('[data-plugin-masonry]') : $obj.find('.posts-masonry .posts-container:not(.manual)');
					if (!$iso_obj.length) {
						$iso_obj = $obj.find('.page-members .member-row:not(.manual)');
					}
					if (!$iso_obj.length) {
						$iso_obj = $obj.find('.page-portfolios .portfolio-row:not(.manual)');
					}
					if ($iso_obj.length) {
						$iso_obj.children().each(function() {
							if (!(this instanceof HTMLElement)) {
								if ('shortcode.default' == element_name && $iso_obj.data('isotope')) {
									$iso_obj.isotope('destroy');
								}
								Object.setPrototypeOf(this, HTMLElement.prototype);
							}
						});
					}
					porto_init( $obj );
				});
			});

			elementorFrontend.hooks.addAction('frontend/element_ready/section', function($obj) {
				if ($obj.find('> .elementor-container > .porto-carousel').length) {
					var $carousel = $obj.find('> .elementor-container > .porto-carousel');
					if ($carousel.data('owl.carousel')) {
						$carousel.trigger('refresh.owl.carousel');
					} else {
						$carousel.themeCarousel($carousel.data('plugin-options'));
					}
				} else if ($obj.find('> .elementor-container > [data-plugin-masonry]').length) {
					var $iso_obj = $obj.find('> .elementor-container > [data-plugin-masonry]');
					$iso_obj.children().each(function() {
						if (!(this instanceof HTMLElement)) {
							Object.setPrototypeOf(this, HTMLElement.prototype);
						}
					});
					if (0 === $iso_obj.children('.grid-col-sizer').index()) {
						$iso_obj.children('.grid-col-sizer').appendTo($iso_obj);
					}
					if (!$iso_obj.hasClass('porto-init')) {
						porto_init_creative_layout($iso_obj);
						$iso_obj.themeMasonry($iso_obj.data('plugin-options'));
						$iso_obj.addClass('porto-init');
					} else if ($iso_obj.data('isotope')) {
						$iso_obj.isotope('layout');
					}
				}

				if ($obj.find('> .elementor-container > .porto-parallax').length) {
					var speed = $obj.find('> .elementor-container > .porto-parallax').data('parallax-speed');
					if ($obj.data('__parallax') && $obj.data('__parallax').options) {
						var old_speed = $obj.data('__parallax').options.speed;
						if (parseFloat(old_speed) !== parseFloat(speed)) {
							$obj.removeData('__parallax');
						}
					}
					$obj.themeParallax({speed: speed});
				}
			});

			elementorFrontend.hooks.addAction('frontend/element_ready/column', function($obj) {
				var $row = $obj.closest('.elementor-row');
				if ($obj.find('> .elementor-column-wrap > .porto-carousel').length) {
					var $carousel = $obj.find('> .elementor-column-wrap > .porto-carousel');
					if ($carousel.data('owl.carousel')) {
						$carousel.trigger('refresh.owl.carousel');
					} else {
						$carousel.themeCarousel($carousel.data('plugin-options'));
					}
				} 
				if ($row.hasClass('owl-carousel')) {
					if (refresh_timer) {
						clearTimeout(refresh_timer);
					}
					refresh_timer = setTimeout(function() {
						$row.removeData('__carousel');
						$row.trigger('destroy.owl.carousel');
						$row.themeCarousel($row.data('plugin-options'));
					}, 100);
				} else if (typeof $row.attr('data-plugin-masonry') != 'undefined') {
					if (refresh_timer) {
						clearTimeout(refresh_timer);
					}
					refresh_timer = setTimeout(function() {
						porto_init_creative_layout($row);
						$row.children().each(function() {
							if (!(this instanceof HTMLElement)) {
								Object.setPrototypeOf(this, HTMLElement.prototype);
							}
						});
						$row.removeData('__masonry');
						if ($row.data('isotope')) {
							$row.isotope('destroy');
						}
						$row.themeMasonry($row.data('plugin-options'));
					}, 100);
				}

				if ($obj.find('> .elementor-column-wrap.porto-parallax').length) {
					var speed = $obj.find('> .elementor-column-wrap').data('parallax-speed');
					if ($obj.data('__parallax') && $obj.data('__parallax').options) {
						var old_speed = $obj.data('__parallax').options.speed;
						if (parseFloat(old_speed) !== parseFloat(speed)) {
							$obj.removeData('__parallax');
						}
					}
					$obj.themeParallax({speed: speed});
				}
			});
		}

		if (typeof porto_woocommerce_init == 'function') {
			var porto_woocommerce_widgets = ['porto_products.default', 'porto_product_categories.default', 'porto_cp_related.default' ];
			$.each(porto_woocommerce_widgets, function(key, element_name) {
				elementorFrontend.hooks.addAction('frontend/element_ready/' + element_name, function($obj) {
					porto_woocommerce_init();
				});
			});

			elementorFrontend.hooks.addAction('frontend/element_ready/porto_cp_image.default', function($obj) {
				theme.WooProductImageSlider.initialize();
			});

			porto_woocommerce_widgets = ['porto_cp_actions.default', 'porto_cp_add_to_cart.default' ];
			$.each(porto_woocommerce_widgets, function(key, element_name) {
				elementorFrontend.hooks.addAction('frontend/element_ready/' + element_name, function($obj) {
					theme.WooQtyField.initialize()
				});
			});
		}

		elementorFrontend.hooks.addAction('masonry_refresh', function(cls, w) {
			if (refresh_timer) {
				clearTimeout(refresh_timer);
			}
			refresh_timer = setTimeout(function() {
				var $obj;
				if (cls) {
					$obj = $('.elementor-column[class="' + cls + '"]').parent();
				} else {
					$obj = $('.elementor-element-editable.porto-grid-item').parent();
				}
				if ($obj.length && $obj.data('isotope')) {
					if (w) {
						$('.elementor-element-editable.porto-grid-item').children('.elementor-column-wrap').data('width').size = Number(w);
					}
					porto_init_creative_layout($obj);
				}
			}, 100);
		});

		elementorFrontend.hooks.addAction('refresh_dynamic_css', function(css, block_id) {
			var $obj = $('style#porto_elementor_custom_css');
			if (!$obj.length) {
				$obj = $('<style></style>').attr('id', 'porto_elementor_custom_css').appendTo('head');
			}
			css = css.replace('/<script.*?\/script>/s', '');
			if (typeof block_id == 'undefined') {
				$obj.html(css);
			} else if (-1 === $obj.html().indexOf(css)) {
				$obj.html($obj.html() + css);
			}
		});
	}
});