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

	$(document).on('elementor/frontend/init', function() {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function($scope) {
				refreshLayout($scope);
			});
		}
	});

	window.dcfRefreshLayout = refreshLayout;
})(jQuery);
