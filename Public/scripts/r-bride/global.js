(function ($) {
	var Global_Resize_Events = [];

	$.extend({
		rbride_global: {
			// 全局侧边栏初始化
			init_slider: function () {
				var $body = $('body');
				var $global_slider = $('.global_slider');

				var slider_resize_handler = function () {
					$global_slider.height($body.height());
					if (!$.rbride_global.isMobile.any() && $body.width() >= (960 + $global_slider.width()))
						$global_slider.show();
					else
						$global_slider.hide();
					
				}
				Global_Resize_Events.push(slider_resize_handler);
				slider_resize_handler();

				// 初始化来管路线发送短信表单 显示事件
				$('.connect a', $global_slider).click(function () {
					$.rbride_global.show_global_widget_sms();
				});
			},
			// 初始化全局导航
			init_navigation: function () {
				$('.global_header_navigation li[href]').click(function () {
					window.location.href = $(this).attr('href');
				});
			},
			// 全局事件注册
			register_events: function () {
				$(window).resize(function () {
					for (var i = 0; i < Global_Resize_Events.length; i++) {
						if (Global_Resize_Events[i])
							Global_Resize_Events[i]();
					}
				});
			},
			// 显示/隐藏Global组件
			show_global_widget: function (selector, flag, defualtId) {
				if (flag == true) {
					$('.global_widgets').show().find(selector).show();
				}
				else {
					$('.global_widgets').hide().find(selector).hide();
				}
			},
			// 显示短信发送组件
			show_global_widget_sms: function (defaultId, pos) {
				var $global_widget_sms = $('#global_send_address');

				if (defaultId) {
					$('select.input', $global_widget_sms).val(defaultId);
				}
				else {
					$('select.input', $global_widget_sms).val('');
				}

				if (pos) {
					$global_widget_sms.css({ top: pos.top, left: pos.left });
				}

				$.rbride_global.show_global_widget('#global_send_address', true);

			},
			// 初始化发送地址组件
			init_widget_send_address: function () {
				var $widget_send_address = $('#global_send_address');
				var $btnClose = $('a.btn_close', $widget_send_address).click(function () {
					$.rbride_global.show_global_widget('.widget_send_address', false);
				});

				var $sendAddressForm = $('#send_address_form');
				var $sendBtn = $('a.btn_submit', $sendAddressForm);
				var $mobileInput = $('#send_address_mobile');

				var setDefaultVal = function ($obj) {
					if ($.trim($obj.val()) == $obj.attr('defaultVal'))
						$obj.val('');
				}
				$mobileInput.focus(function () {
					setDefaultVal($(this));
				});

				$sendAddressForm.ajaxForm({
					validate: {
						setting: {
							fields: [{
								inputSelector: '.fieldBanquet select',
								tipSelector: '.fieldBanquet .tip',
								allowEmpty: false,
								emptyTxt: '请选择！',
								errorTxt: '',
								validate: function (val) {
									return true;
								}
							}, {
								inputSelector: '.fieldMobile input',
								tipSelector: '.fieldMobile .tip',
								allowEmpty: false,
								emptyTxt: '不能为空！',
								errorTxt: '格式错误！',
								validate: function (val) {
									return /^[1][3-8]+\d{9}/.test(val);
								}
							}]
						}
					},
					ajax: {
						enable: true,
						trigger: {
							selector: '.btn_submit',
							inForm: true
						},
						setting: {
							url: '/service/smshandler.ashx?action=send',
							type: 'POST',
							dataType: 'json',
							prepareData: function () {
								var banquet = $('#send_address_banquet').val();
								var mobile = $('#send_address_mobile').val();
								var source = $('#send_address_source').val();
								var type = 'banquet';
								var key = ASP_NET_SessionId.length > 8 ? ASP_NET_SessionId.substr(0, 8) : ASP_NET_SessionId;
								var code = $.rbride_global.des(key, mobile + type + source);

								return { 'b': banquet, 'm': mobile, 't': type, 's': source, c: code };
							},
							beforeSend: function (xhr) {
								setDefaultVal($mobileInput);
								var result = $sendAddressForm.validateAll();
								if (result == true)
									$sendBtn.attr('disabled', 'disabled');
								return result;
							},
							success: function (data) {
								if (data && data.Result == true) {
									$('#send_address_banquet,#send_address_mobile').val('');
									$btnClose.trigger('click');
									alert('地址已发送到您的短信，请注意查收，谢谢~');
								}
								else {
									alert(data.Message);
								}
							},
							error: function () {
								alert('网络错误，请稍后再试!');
							},
							complete: function () {
								$sendBtn.removeAttr('disabled')
							}
						}
					}
				});
			},
			des: function (key, str) {
				var result = '';
				if (str && str.length > 0) {
					var message = encodeURIComponent(str);
					var keyHex = CryptoJS.enc.Utf8.parse(key);
					var encrypted = CryptoJS.DES.encrypt(message, keyHex, {
						mode: CryptoJS.mode.ECB,
						padding: CryptoJS.pad.Pkcs7
					});
					result = encodeURIComponent(encrypted.toString());
				}
				return result;
			},
			ajax: function (opts) {

			},
			isMobile: {
				Android: function () {
					return navigator.userAgent.match(/Android/i) ? true : false;
				},
				BlackBerry: function () {
					return navigator.userAgent.match(/BlackBerry/i) ? true : false;
				},
				iOS: function () {
					return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
				},
				Windows: function () {
					return navigator.userAgent.match(/IEMobile/i) ? true : false;
				},
				any: function () {
					return ($.rbride_global.isMobile.Android() || $.rbride_global.isMobile.BlackBerry() || $.rbride_global.isMobile.iOS() || $.rbride_global.isMobile.Windows());
				}
			}

		}
	});

})(jQuery);


$(document).ready(function () {
	$.rbride_global.init_slider();
	$.rbride_global.init_navigation();
	$.rbride_global.register_events();
	$.rbride_global.init_widget_send_address();
});