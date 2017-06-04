// 表单验证类
(function ($) {
	$.fn.formvalidator = function (options) {

		var opts = $.extend({}, $.fn.formvalidator.defaults, options);
		var $this = this;
		var queryValidator = [];
		var queryIndexAttrName = 'queryValidatorIndex';


		function init() {
			$.each(opts.fields, function (i, fieldOptions) {
				var fieldOpt = $.extend({}, $.fn.formvalidator.filedDefaults, fieldOptions);
				var $filedInput = $(fieldOpt.inputSelector, $this);
				var newLength = queryValidator.push(fieldOpt);

				$filedInput
				.change(fieldOpt.change || changeHandler)
                .blur(fieldOpt.blur || blurHandler)
                .focus(fieldOpt.focus || focusHandler)
                .attr(queryIndexAttrName, newLength - 1);

			});
			return $this;
		}

		var validateHandler = function (validator) {
			var result = true;
			var $input = $(validator.inputSelector, $this);
			var $tip = $(validator.tipSelector, $this);
			var val = validator.trim == true ? $.trim($input.val()) : $input.val();
			
			if (val.length == 0) {
				if (!(result = validator.allowEmpty)) {
					$input.addClass(validator.errorClass);
					$tip.text(validator.emptyTxt).show();
				}
			}
			else {
				if (!(result = validator.validate(val))) {
					$input.addClass(validator.errorClass);
					$tip.text(validator.errorTxt).show();
				}
			}
			if (result == true)
				$tip.text('');
			return result;
		}

		var blurHandler = function () {
			var queryIndex = $(this).attr(queryIndexAttrName);
			var curValidator = queryValidator[queryIndex];
			validateHandler(curValidator);
		};

		var changeHandler = function () {
			var queryIndex = $(this).attr(queryIndexAttrName);
			var curValidator = queryValidator[queryIndex];
			validateHandler(curValidator);
		};

		var focusHandler = function () {
			var queryIndex = $(this).attr(queryIndexAttrName);
			var curValidator = queryValidator[queryIndex];
			var $input = $(curValidator.inputSelector, $this);
			var $tip = $(curValidator.tipSelector, $this);
			$input.removeClass(curValidator.errorClass);
			$tip.text('').hide();
			$(opts.tipsSelector).text('').hide();
		};

		var validateAll = function () {
			var result = true;
			for (var i = 0; i < queryValidator.length; i++) {
				var curValidator = queryValidator[i];
				var curResult = validateHandler(curValidator);
				result = result && curResult;
			}
			return result;
		}

		var resetState = function () {
			for (var i = 0; i < queryValidator.length; i++) {
				var curValidator = queryValidator[i];
				var $input = $(curValidator.inputSelector, $this);
				var $tip = $(curValidator.tipSelector, $this);
				$input.val('').removeClass(curValidator.errorClass);
				$tip.text('').hide();
			}
			$(opts.tipsSelector).text('').hide();
		}

		$this.validateAll = validateAll;

		$this.resetState = resetState;

		return init();
	};

	// 默认配置
	$.fn.formvalidator.defaults = {
		tipsSelector: '',
		auto: false,
		fields: []
	};

	$.fn.formvalidator.filedDefaults = {
		inputSelector: '.tips',
		tipSelector: '',
		trim: true,
		allowEmpty: false,
		emptyTxt: '不能为空',
		errorClass: 'ui-state-error',
		errorTxt: '格式错误',
		validate: function () { return true; },
		blur: null,
		focus: null
	};

})(jQuery);

// 表单组件
(function ($) {
	$.fn.ajaxForm = function (options) {
		var opts = $.extend(true, {}, $.fn.ajaxForm.defaults, options);
		var $form = this;
		var formId = $form.attr('id');

		function init() {
			validateInit();
			ajaxInit();
			return $form;
		}

		// 验证初始化
		var validateInit = function () {
			if (opts.validate && opts.validate.enable) {
				$form.formvalidator(opts.validate.setting);
			}
		}

		// Ajax提交初始化
		var ajaxInit = function () {
			if (opts.ajax && opts.ajax.enable) {
				if (opts.ajax.trigger && opts.ajax.trigger.selector) {
					var $btn = opts.ajax.trigger.inForm ? $(opts.ajax.trigger.selector, $form) : $(opts.ajax.trigger.selector);
					$btn.bind('click', function () {
						if (!$(this).is(':disabled')) {
							if (opts.ajax.setting.prepareData)
								opts.ajax.setting.data = opts.ajax.setting.prepareData();
							$.ajax(opts.ajax.setting);
							return false;
						}
					});
				}
			}
		}

		return init();
	};

	// 默认配置
	$.fn.ajaxForm.defaults = {
		validate: {
			enable: true,
			setting: {
				tipsSelector: '.tips',
				auto: true,
				fields: null
			}
		},
		ajax: {
			enable: true,
			trigger: {
				selector: '.btn_submit',
				inForm: true
			},
			setting: {
				type: 'POST',
				dataType: 'json',
				data: null,
				prepareData: false
			}
		}
	};

})(jQuery);


