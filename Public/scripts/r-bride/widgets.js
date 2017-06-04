(function ($) {
	/***************************************** Tabs 组件 *****************************************/
	$.fn.tabs = function (options) {
		var opts = $.extend({}, $.fn.tabs.defaults, options);
		var $widget = $(this);
		var $tabs = $(opts.tabsSelector, $widget);
		var $blocks = $(opts.blocksSelector, $widget);
		var tabsStaticTop = $tabs.position().top;
		var blocksStaticTopArr = [];

		function init() {
			$('.block', $blocks).each(function (index, element) {
				blocksStaticTopArr.push({ 'id': $(this).attr(opts.blockIdAttr), 'top': $(this).position().top });
			});

			$(window).scroll(function (e) {
				var windowScrollTop = $(window).scrollTop();
				if (windowScrollTop >= tabsStaticTop)
					$tabs.css({ 'position': 'fixed', 'top': '0', 'left': '50%', 'z-index': '99999', 'margin-left': '-' + parseInt($tabs.width() / 2).toString() + 'px' });
				else
					$tabs.css({ 'position': 'static', 'top': '0', 'left': '0', 'margin-left': '0' });

				var currentBlockId = getCurrentBlock(windowScrollTop);

				if (currentBlockId != '')
					$('a[href="#' + currentBlockId + '"]', $tabs).parent().addClass(opts.tabActiveCls).siblings().removeClass(opts.tabActiveCls);
				else
					$('ul li:eq(0)', $tabs).addClass(opts.tabActiveCls).siblings().removeClass(opts.tabActiveCls);
			});

			return $widget;
		}

		var getCurrentBlock = function (windowScrollTop) {
			var result = '';
			$.each(blocksStaticTopArr, function (i, n) {
				if (windowScrollTop >= n.top)
					result = n.id;
			});
			return result;
		}

		return init();
	};

	// 默认配置
	$.fn.tabs.defaults = {
		// property
		tabsSelector: '.tabs',
		tabIdAttr: 'href',
		tabActiveCls: 'active',
		blocksSelector: '.blocks',
		blockIdAttr: 'id'
	};
	/***************************************** Tabs 组件 *****************************************/

	/***************************************** 宴会厅搜索组件 *****************************************/
	$.fn.query_options = function (options) {
		var opts = $.extend({}, $.fn.query_options.defaults, options);
		var $widget = $(this);
		var $inner = $(opts.innerSelector, $widget);
		var $btn_toggle = $(opts.toggleSelector, $widget);

		function init() {
			// 初始化切换按钮
			$btn_toggle.click(function () {
				if ($inner.hasClass('expand_on'))
					$inner.removeClass('expand_on').addClass('expand_off');
				else
					$inner.removeClass('expand_off').addClass('expand_on');
			});

			if (opts.IsRequest == true) {

			}
			else
				OnlyResponse();


			return $widget;
		}

		function OnlyResponse() {
			$(opts.groupSelector).each(function () {
				var key = $(this).attr('key');
				$('li', $(this)).each(function () {
					$(this).click(function () {
						var value = $(this).attr('value');
						window.location.href = opts.baseUrl + key + '/' + value + '/';
					});
				});

			});
		}

		return init();
	};

	// 默认配置
	$.fn.query_options.defaults = {
		innerSelector: '.inner',
		toggleSelector: '.btn_toggle',
		groupSelector: '.option_group',
		IsRequest: false,
		baseUrl: '/hall/'
	};
	/***************************************** 宴会厅搜索组件 *****************************************/

	/***************************************** 日历搜索组件 *****************************************/
	$.fn.widget_calendar_query = function (options) {
		var opts = $.extend({}, $.fn.widget_calendar_query.defaults, options);
		var $widget = $(this);
		var $calendar_query_date = $('input.calendar_query_date', $widget);
		var $select_btn = $('.calendar_filter .select_btn', $widget);
		var $query_btn = $('.query_btn', $widget);

		function init() {
			var minDate = new Date();

			$select_btn.click(function () {
				$calendar_query_date.datepicker('show');
			});

			$calendar_query_date.datepicker({
				dateFormat: 'yy-mm-dd',
				minDate: minDate
			});

			$query_btn.click(function () {
				var url = opts.url;
				var val = $calendar_query_date.val();
				if (val && val != '') {
					url += 'p/' + opts.p + '/d/' + val + '/';
				}
				window.location.href = url;
			});
			return $widget;
		}

		return init();
	}

	// 默认配置
	$.fn.widget_calendar_query.defaults = {
		url: '/calendar/',
		p: ''
	};
	/***************************************** 日历搜索组件 *****************************************/

	/***************************************** 浮层窗口组件 *****************************************/

	$.fn.widget_window = function (options) {
		var opts = $.extend({}, $.fn.widget_window.defaults, options);
		var $widget = $(this);
		var $btnClose = $('a.btn_close', $widget);

		var open = function () {
			if (opts.beforeOpen) {
				if (opts.beforeOpen() === false) {
					return false;
				}
			}

			$widget.show();

			if (opts.onOpened)
				opts.onOpened();
		};

		var close = function () {
			if (opts.beforeClose) {
				if (opts.beforeClose() === false) {
					return false;
				}
			}

			$widget.hide();

			if (opts.onClosed)
				opts.onClosed();
		}

		function init() {
			var left = '-' + parseInt(opts.width / 2) + 'px';
			var top = '-' + parseInt(opts.height / 2) + 'px';
			$widget.width(opts.width).height(opts.height).css({ 'margin-top': top, 'margin-left': left });


			$btnClose.click(close);

			return $widget;
		}

		$widget.open = function () {
			return open();
		}

		$widget.close = function () {
			return close();
		}

		return init();
	}

	// 默认配置
	$.fn.widget_window.defaults = {
		width: 800,
		height: 600,
		beforeOpen: false,
		onOpened: false,
		beforeClose: false,
		onClosed: false
	};

	/***************************************** 浮层窗口组件 *****************************************/



})(jQuery);
