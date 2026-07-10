(function($) {
	'use strict';

	var refreshTimer = null;

	function afterImages($scope, callback) {
		var $images = $scope.find('img');
		var pending = 0;

		$images.each(function() {
			if (!this.complete) {
				pending++;
				$(this).one('load error', function() {
					pending--;
					if (pending <= 0) {
						callback();
					}
				});
			}
		});

		if (!pending) {
			callback();
		}
	}

	function stabilizeProductGrids($scope) {
		$scope.find('ul.products.products-apply-isotope:not(.swiper-wrapper)').addBack('ul.products.products-apply-isotope:not(.swiper-wrapper)').each(function() {
			var $grid = $(this);

			if ($.fn.isotope && $grid.data('isotope')) {
				$grid.isotope('destroy');
			}

			$grid
				.addClass('dcf-stable-product-grid')
				.css({
					height: '',
					position: '',
					overflow: ''
				});

			$grid.children('li.product').css({
				position: '',
				left: '',
				top: '',
				transform: ''
			});
		});
	}

	function setupProductCarousels($scope) {
		$scope.find('.elementor-widget-wdt-shop-products ul.products.products-apply-isotope:not(.swiper-wrapper)').each(function() {
			var $track = $(this);
			var $container = $track.closest('.wdt-products-container');

			if ($.fn.isotope && $track.data('isotope')) {
				$track.isotope('destroy');
			}

			$track
				.addClass('dcf-product-carousel-track')
				.css({
					height: '',
					position: '',
					overflow: ''
				});

			$track.children('li.product').css({
				position: '',
				left: '',
				top: '',
				transform: ''
			});

			if (!$container.length || $container.hasClass('dcf-product-carousel-ready')) {
				return;
			}

			$container.addClass('dcf-product-carousel-ready');
			$container.prepend('<button class="dcf-product-carousel-nav dcf-product-carousel-prev" type="button" aria-label="Previous products">&lsaquo;</button>');
			$container.append('<button class="dcf-product-carousel-nav dcf-product-carousel-next" type="button" aria-label="Next products">&rsaquo;</button>');
		});
	}

	function moveProductCarousel($button, direction) {
		var $container = $button.closest('.dcf-product-carousel-ready');
		var track = $container.find('.dcf-product-carousel-track').get(0);
		var firstItem = $container.find('li.product.product-grid-view').get(0);
		var distance = firstItem ? firstItem.getBoundingClientRect().width + 24 : 0;

		if (!track) {
			return;
		}

		track.scrollBy({
			left: distance * direction,
			behavior: 'smooth'
		});
	}

	function refreshMasonry($scope) {
		if (!$.fn.isotope) {
			return;
		}

		$scope.find('.apply-isotope:not(.products), .tpl-blog-holder.apply-isotope').addBack('.apply-isotope:not(.products), .tpl-blog-holder.apply-isotope').each(function() {
			var $grid = $(this);
			var options = {
				itemSelector: '.column',
				transformsEnabled: false,
				percentPosition: true,
				masonry: {
					columnWidth: $grid.find('.grid-sizer').length ? '.grid-sizer' : '.column'
				}
			};

			afterImages($grid, function() {
				if ($grid.data('isotope')) {
					$grid.isotope('reloadItems').isotope('layout');
				} else {
					$grid.isotope(options);
				}
			});
		});
	}

	function refreshSwipers($scope) {
		$scope.find('.swiper-container, .swiper').addBack('.swiper-container, .swiper').each(function() {
			if (this.swiper && typeof this.swiper.update === 'function') {
				this.swiper.update();
			}
		});
	}

	function refreshLayout(scope) {
		var $scope = scope ? $(scope) : $(document);

		window.clearTimeout(refreshTimer);
		refreshTimer = window.setTimeout(function() {
			stabilizeProductGrids($scope);
			setupProductCarousels($scope);
			refreshMasonry($scope);
			refreshSwipers($scope);
		}, 80);
	}

	$(function() {
		refreshLayout(document);
	});

	$(window).on('load resize orientationchange', function() {
		refreshLayout(document);
	});

	$(document.body).on('updated_wc_div wc_fragments_refreshed wc_fragments_loaded yith-wcan-ajax-filtered added_to_cart removed_from_cart', function() {
		refreshLayout(document);
	});

	$(document).on('click', '.dcf-product-carousel-nav', function() {
		moveProductCarousel($(this), $(this).hasClass('dcf-product-carousel-next') ? 1 : -1);
	});

	$(document).on('elementor/frontend/init', function() {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function($scope) {
				refreshLayout($scope);
			});
		}
	});

	$(window).on('load', function() {
		window.setTimeout(function() {
			refreshLayout(document);
		}, 1100);
	});

	window.dcfRefreshLayout = refreshLayout;
})(jQuery);
