(function ($) {

	/* 黄道吉日全局对象
			{
				'2014-10-20':{
					day:'20',
					weekday:' 星期三',
					gongli:'2014年10月20日',
					nongli:'农历2015年六月(小)廿八',
					yi:'',
					ji:'',
					jiri:true
				},
				'2014-10-21':{
					day:'21',
					weekday:' 星期四',
					gongli:'2014年10月21日',
					nongli:'农历2015年六月(小)廿八',
					yi:'',
					ji:'',
					jiri:false
				}
			}
		*/
	var CalendarData = {};

	$.extend({
		rbride_calendar: {
			// 吉日初始化
			init_jiri_calendar: function () {
				
				var $calendar = $('#calendar');
				var $calendar_selector = $('#calendar_selector');

				// 根据日期获取 黄道吉日对象
				// callback(result,obj)
				var getCalendar = function (date, callback) {
					// 先尝试从 全局对象中获取 指定日期对象
					// 如果存在则执行callback，无则从远程获取当月数据，并赋值到全局对象中
					if (CalendarData[date]) {
						callback(true, CalendarData[date]);
						
					}
					else {
						
						// 远程获取当月 黄道吉日对象集合
						$.ajax({
						//	url: 'http://www.r-bride.com/service/CalendarHandler.ashx?action=query',
							url: '/ajax.php',
							type: 'get',
							cache: true,
							dataType: 'json',
							data: { m: date },
							success: function (data) {
								
								if (data && data.length > 0) {
									$.each(data, function (i, n) {
										var curDate = new Date(n.date);
										var nongliStr = n.nongli;
										var nongliSplitPos = nongliStr.indexOf(' ');
										
										CalendarData[n.date] = {
											day: $.datepicker.formatDate('d', curDate),
											weekday: nongliStr.substr(nongliSplitPos + 1, 3),
											gongli: $.datepicker.formatDate('yy年m月d日', curDate),
											nongli: nongliStr.substring(0, nongliSplitPos),
											yi: n.yi,
											ji: n.ji,
											jiri: n.yi.indexOf('嫁娶') >= 0
										};
									});

									callback(true, CalendarData[date]);
								}
								else
									callback(false, null);
							},
							error: function () {
								callback(false, null);
							},
							complete: function () {

							}
						});
					}
				}

				// 年月日变动时事件处理函数
				// type:0(指触发selDay)，1(只触发Month)，2(都触发)
				var changeHandler = function (year, month, day, type) {
					var triggerSelDay = type && (type == 0 || type == 2);
					var triggerMonth = type && (type == 1 || type == 2);

					var selDate = new Date(year, month, day);
					var selFormatDate = $.datepicker.formatDate('yy-mm-dd', selDate);
					getCalendar(selFormatDate, function (r, o) {
						if (r == true && o) {
							// 判定是否需要触发选中事件，需要则将当前日期对象赋值	
							if (triggerSelDay == true) {
								$('.calendar_date .day', $calendar).text(o.day);
								$('.calendar_date .date', $calendar).text(o.gongli);
								$('.calendar_date .nongli', $calendar).text(o.nongli);
								$('.calendar_date .weeks .weekday', $calendar).text(o.weekday);
								if (o.jiri == true)
								{
									$('.calendar_date .weeks .jiri', $calendar).show()
								}
								else
									{
									$('.calendar_date .weeks .jiri', $calendar).hide();
								}
								$('.calendar_yi .txt', $calendar).text(o.yi);
								$('.calendar_ji .txt', $calendar).text(o.ji);
							}
							if (triggerMonth == true) {
								setTimeout(function () {
									// 枚举当前日历

									$('.ui-datepicker-calendar td["data-handler"="selectDay"]["data-year"=' + year + ']["data-month"=' + month + '] a', $calendar).each(function () {
										var $curDay = $(this);
										var curDate = new Date(year, month, parseInt($curDay.text()));
										// 获取日期对象
										var curDateObj = CalendarData[$.datepicker.formatDate('yy-mm-dd', curDate)];
										if (curDateObj) {
											// 设置吉日属性
											if (curDateObj.jiri == true)
												$curDay.parent().addClass('ui-state-jiri').attr('title', '宜嫁娶');
										}
									});

								}, 10);
							}
						}
					});
				}

				var defaultDate = (DefaultDate && DefaultDate != '') ? new Date(DefaultDate) : null;

				var minDate = new Date();
				var maxDate = new Date(2016, 11, 31);

				$calendar_selector.datepicker({
					changeMonth: true,
					changeYear: true,
					minDate: minDate,
					defaultDate: defaultDate,
					maxDate: maxDate,
					onChangeMonthYear: function (year, month, inst) {
						changeHandler(year, month - 1, 1, 1);
					},
					//		beforeShowDay : function(curDate){

					//		},
					onSelect: function (dateStr, inst) {
						var curDate = new Date(dateStr);
						changeHandler(curDate.getFullYear(), curDate.getMonth(), curDate.getDate(), 2);
					}
				});


				if (!defaultDate)
					defaultDate = minDate;
				changeHandler(defaultDate.getFullYear(), defaultDate.getMonth(), defaultDate.getDate(), 2);
				
			},

			// 表单初始化
			init_form: function () {
				var $booking_form = $('.booking_form');

				var $base_info = $('.base_info', $booking_form);
				var $base_info_items = $('.items', $base_info);

				var $districtInput = $('#districtInput');
				var $budgetInput = $('#budgetInput');
				var $tableRangeInput = $('#tableRangeInput');

				$('.item_district .options>li.specify').click(function () {
					var $this = $(this);
					if ($this.hasClass('checked'))
						return false;
					$('.sub_options>li:eq(0)', $this).trigger('click');

					return false;
				});

				$('.item_district .sub_item a.btn_close').click(function () {
					$(this).parents('li.specify').addClass('closed');
					return false;
				});

				$('.item_district .sub_options>li').click(function () {
					var $this = $(this);
					if ($this.hasClass('checked'))
						return false;

					//if (!$this.is(':checked')) {
					$this.parents('li.specify').find('span.specify_text').text($this.text());
					//}

					return false;
				});

				$('.item_district li').click(function () {

					var $this = $(this);
					$this.removeClass('closed');
					if ($this.hasClass('checked')) {
						return false;
					}

					$this.addClass('checked')
						.siblings().removeClass('checked')
						.filter('.specify').each(function () {
							var $text = $(this).find('span.specify_text');
							$text.text($text.attr('defaulttext'));
							$(this).find('.sub_options>li').removeClass('checked');
						});

					// 赋值
					if ($this.hasClass('specify')) {
						$districtInput.val($('span.specify_text', $this).text());
					}
					else
						$districtInput.val($this.text());

					return false;
				}).first().trigger('click');

				$('.item_budget li').click(function () {
					var $this = $(this);
					$this.addClass('checked').siblings().removeClass('checked');
					$budgetInput.val($this.text());
				}).first().trigger('click');

				$('.item_tableRange li').click(function () {
					var $this = $(this);
					$this.addClass('checked').siblings().removeClass('checked');
					$tableRangeInput.val($this.text());
				}).first().trigger('click');

				$booking_form.ajaxForm({
					validate: {
						setting: {
							fields: [{
								inputSelector: '.fieldMobileInput input',
								tipSelector: '.fieldMobileInput .tip',
								allowEmpty: false,
								emptyTxt: '请输入手机号！',
								errorTxt: '请输入正确的手机号！',
								validate: function (val) {
									return /^[1][3-8]+\d{9}/.test(val);
								}
							}, {
								inputSelector: '.fieldNameInput input',
								tipSelector: '.fieldNameInput .tip',
								allowEmpty: false,
								emptyTxt: '不能为空！',
								errorTxt: '不能超过20个字符！',
								validate: function (val) {
									return /^[\w\W]{1,20}$/.test(val);
								}
							}]
						}
					},
					ajax: {
						enable: false
					}
				});

				$('#booking_btn').click(function () {
					return $booking_form.validateAll();;
				});
			},
			// 根据参数设置默认值
			set_form: function () {
				if (DefaultBanquet && DefaultBanquet.length > 0) {
					$('.booking_form .booking_info .item_district .specify_banquet li').each(function () {
						var $this = $(this);
						if ($this.attr('banquet') == DefaultBanquet) {
							$this.parents('.specify_banquet').trigger('click');
							$this.trigger('click');
							$this.parents('.specify_banquet').find('.btn_close').trigger('click');
						}
					});
				}

				if (DefaultBudget && DefaultBudget.length > 0) {
					$('.booking_form .booking_info .item_budget li').each(function () {
						var $this = $(this);
						if ($this.text() == DefaultBudget) {
							$this.trigger('click');
						}
					});
				}

				if (DefaultTableRange && DefaultTableRange.length > 0) {
					$('.booking_form .booking_info .item_tableRange li').each(function () {
						var $this = $(this);
						if ($this.text() == DefaultTableRange) {
							$this.trigger('click');
						}
					});
				}

			}
		}

	});

})(jQuery);

$(document).ready(function (e) {
	$.rbride_calendar.init_jiri_calendar();
	$.rbride_calendar.init_form();
	$.rbride_calendar.set_form();
});