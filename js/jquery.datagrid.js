(function ($) {

	function History()
	{
		this._callback = function(hash) {};
	};

	$.extend(History.prototype, {

		init: function(callback) {
			this._callback = callback;
		},

		load: function(hash) {
			this._callback(hash);
		}
	});

	$(document).ready(function() {
		$.history = new History(); // singleton instance
	});

	// -----------------------------------------------------------------

	$.fn.datagrid = function(options) {
		var settings = $.extend({}, $.fn.datagrid.defaults, options);

		return this.each(function () {
			$.datagrid(this, settings);
		});
	};

	$.fn.datagrid.defaults = {
		load: function(grid) {
		}
	};

	$.datagrid = function (grid, settings) {
		if ($(grid).hasClass('carbogrid-noajax')) {
			return false;
		}

		var baseUrl = $('.base-url', grid).text();
		var gridUrl = $('.cg-url', grid).text();
		var loading = false;
		var ajaxSessionStart = false;

		// Init columns show/hide
		$('.cg-columns-list .cg-checkbox', grid).click(function() {
			if ($(this).attr('checked')) {
				$('.cg-table thead tr th:nth-child(' + $(this).val() + '), .cg-table tbody tr td:nth-child(' + $(this).val() + ')').removeClass('cg-hidden');
			}
			else {
				$('.cg-table thead tr th:nth-child(' + $(this).val() + '), .cg-table tbody tr td:nth-child(' + $(this).val() + ')').addClass('cg-hidden');
			}
		});

		// Init buttons
		$('.cg-toolbar .cg-add', grid).html($('.cg-toolbar .cg-add', grid).text()).button({ icons: { primary: 'ui-icon-circle-plus' } });
		$('.cg-toolbar .cg-delete', grid).html($('.cg-toolbar .cg-delete', grid).text()).button({ icons: { primary: 'ui-icon-trash' } });
		$('.cg-toolbar .cg-columns', grid).html($('.cg-toolbar .cg-columns', grid).text()).button({ icons: { primary: 'ui-icon-circle-triangle-s' } });
		$('.cg-toolbar .cg-export', grid).html($('.cg-toolbar .cg-export', grid).text()).button({ icons: { primary: 'ui-icon-print' } });

		// Init Columns button
		$('button.cg-columns', grid).live('click', function() {
			$('.cg-columns-list', grid).toggleClass('cg-hidden');
			return false;
		});
		$('.cg-columns-list', grid).click(function(e) {
			e.stopPropagation();
		});
		$(document).click(function(e) {
			$('.cg-columns-list', grid).addClass('cg-hidden');
		});
		// Init Add button
		$('button.cg-add', grid).click(function() {
			var url = $('.cg-add-url', grid).text();
			initDialog($('.cg-lang-add', grid).text(), url);
			return false;
		});
		// Init Delete button
		$('button.cg-delete', grid).click(function() {
			var ids = '';
			$('input[name=item_ids[]]:checked', grid).each(function() {
				ids += $(this).val() + ',';
			});
			ids = ids.replace(/,$/, '');
			var url = $('.cg-delete-url', grid).text() + '/' + ids;
			initDialog($('.cg-lang-confirm-delete-title', grid).text(), url, 300, 'auto', true);
			return false;
		});

		$.ajaxSetup({
			cache: false,
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				alert(errorThrown);
	        }
		});
		// Init history plugin
		$.history.init(callback);

		// Call custom init funciton
		initGrid();

		function callback(hash)
		{
			if ((hash == '' || hash == '#') && !ajaxSessionStart) {
				ajaxSessionStart = true;
				return false;
			}
			var url = gridUrl + hash;
			// Hide column dropdown
			$('.cg-columns-list', grid).addClass('cg-hidden');
			startLoad(grid);
			$.get(url, function(html) {
				$('.cg-table', grid).html(html);
				endLoad(grid);
				initGrid();
			});
		}

		function startLoad(element, anim) {
			if (anim === undefined) anim = true;
			$(element).data('position', $(element).css('position'));
			$(element).data('overflow', $(element).css('overflow'));
			$(element).css('position', 'relative');
			$(element).css('overflow', 'hidden');
			$('<div class="cg-block ui-widget-overlay"><div class="cg-block-message ui-loading">' + $('.cg-lang-loading-message').text() + '</div></div>').css({
				top: 0 + $(element).scrollTop(),
				left: 0 + $(element).scrollLeft(),
				width: $(element).outerWidth(),
				height: $(element).outerHeight()
			}).appendTo($(element));
		}

		function endLoad(element) {
			$(element).children('.cg-block, .cg-block-message').remove();
			$(element).css('position', $(element).data('position'));
			$(element).css('overflow', $(element).data('overflow'));
		}

		function filter() {
			data = {};
			$(':input.cg-filter', grid).each(function() {
				if ($(this).val() !== '') data[$(this).attr('name')] = $(this).val();
			});
			// TODO: be more general
			$.post(baseUrl + 'carbogrid/ajax/hash', data, function(resp) {
				$.history.load($('.cg-hash', grid).text() + '/' + resp);
			});
		}

		function checkButtons() {
			// Enable/disable buttons
			if ($('.cg-grid td :checkbox:checked', grid).length) {
				$('.cg-toolbar .cg-delete', grid).button('enable');
			}
			else {
				$('.cg-toolbar .cg-delete', grid).button('disable');
			}
		}

		function initGrid() {
			// Enable/disable buttons
			checkButtons();

			// Hide columns not selected
			$('.cg-columns-list .cg-checkbox:not(:checked)', grid).each(function() {
				$('.cg-table thead tr th:nth-child(' + $(this).val() + '), .cg-table tbody tr td:nth-child(' + $(this).val() + ')').addClass('cg-hidden');
			});
			// Show columns selected
			$('.cg-columns-list .cg-checkbox:checked', grid).each(function() {
				$('.cg-table thead tr th:nth-child(' + $(this).val() + '), .cg-table tbody tr td:nth-child(' + $(this).val() + ')').removeClass('cg-hidden');
			});

			// Init buttons
			$('.cg-filter.cg-button', grid).html($('.cg-filter.cg-button', grid).text()).button({ icons: { primary: 'ui-icon-circle-triangle-s' } });

			// Init Apply Filter button
			$('button.cg-apply-filter', grid).click(function() {
				filter();
				return false;
			});

			// Init Enter key on filter
			$(':input.cg-filter').keydown(function(e) {
				if (e.keyCode == 13) {
					filter();
					return false;
				}
			});

			// Init Edit link
			$('a.cg-edit', grid).click(function() {
				var url = $(this).attr('href');
				initDialog($('.cg-lang-edit', grid).text(), url);
				return false;
			});
			// Init Delete link
			$('a.cg-delete', grid).click(function() {
				var url = $(this).attr('href');
				initDialog($('.cg-lang-confirm-delete-title', grid).text(), url, 300, 'auto', true);
				return false;
			});

			// Init inner links
			$('a.cg-ajax', grid).click(function() {
				var url = $(this).attr('href');
				$.history.load(this.href.replace(/^.*#/, ''));
				return false;
			});
			// Init page size change
			$('select[name=limit]', grid).change(function() {
				var hash = $('.cg-params', grid).text() + $(this).val() + '/0/' + $('.cg-order-string', grid).text()  + '/' + $('.cg-filter-string', grid).text();
				$.history.load(hash);
			});
			// Init row selection
			$('.cg-grid tbody tr:has(:checkbox) td', grid).click(function(e) {
				$(this).parents('tr').find('td').toggleClass('ui-state-highlight').toggleClass('ui-widget-content');;
				if ($(e.target).attr('type') !== 'checkbox') {
					var checkbox = $(this).parents('tr').find('td.cg-select :checkbox');
					checkbox.attr('checked', !checkbox.attr('checked'));
				}
				if ($('td :checkbox', grid).length == $('td :checkbox:checked', grid).length) {
					$('th.cg-select :checkbox', grid).attr('checked', 'checked');
				}
				else {
					$('th.cg-select :checkbox', grid).attr('checked', '');
				}
				checkButtons();
			});
			// Init select all checkbox
			$('.cg-grid th.cg-select :checkbox', grid).click(function() {
				$(this).parents('table').find('td :checkbox').attr('checked', $(this).attr('checked'));
				if ($(this).attr('checked')) {
					$(this).parents('table').find('tbody td.cg-data').addClass('ui-state-highlight');
				}
				else {
					$(this).parents('table').find('tbody td.cg-data').removeClass('ui-state-highlight');
				}
				checkButtons();
			});
			// Init row hover
			$('.cg-grid tbody tr:has(:checkbox) td', grid).hover(function() {
				$(this).parents('tr').find('td').addClass('ui-state-hover');
			},
			function() {
				$(this).parents('tr').find('td').removeClass('ui-state-hover');
			});

			settings.load(grid);
		}

		function initDialog(title, url, width, height, modal) {
			if (width === undefined) width = 640;
			if (height === undefined) height = 480;
			if (modal === undefined) modal = true;
			var mybuttons = {}
			mybuttons[$('.cg-lang-ok', grid).text()] = function() {
				postDialog($(this), url);
			};
			mybuttons[$('.cg-lang-cancel', grid).text()] = function() {
				$(this).dialog('close');
			};
			var dialog = $('<div class="cg-dialog"></div>');
			dialog.appendTo('body');
			dialog.attr('title', title);
			dialog.dialog({
				bgiframe: true,
				resizable: false,
				width: width,
				height: height,
				minHeight: 200,
				modal: modal,
				buttons: mybuttons,
				open: function(e, ui) {
					loading = true;
					var dialog = $(this);
					dialog.empty();
					// Show loading sign
					dialog.parents('.ui-dialog').find('.ui-dialog-buttonpane').append('<div class="cg-loading ui-autocomplete-loading">&nbsp;</div>')
					$.get(url, function(html) {
						dialog.append(html);
						// Hide loading sign
						dialog.parents('.ui-dialog').find('.cg-loading').hide();
						loading = false;
						// Load script for form if any
						if ($('.cg-form-js', grid).text()) {
							$.getScript($('.cg-form-js', grid).text());
						}
						// On scroll hide any widgets like autocomplete, datepicker, or timepicker
						$(dialog).scroll(function() {
							$('.ui-autocomplete:visible, .ui-datepicker:visible:not(.static), .time-picker:visible').hide();
						});
						initDialogForm(dialog);
					});
					// Init submit on Enter key
					$(document).bind('keydown.dialog', function(e) {
						if (e.keyCode == 13) {
							postDialog(dialog, url);
							return false;
						}
					});
				},
				close: function(e, ui) {
					$(document).unbind('keydown.dialog');
					$(this).dialog('destroy').remove();
				}
			});
		}

		function initDialogForm(dialog) {
		}

		function postDialog(dialog, url) {
			// Don't allow post if already posted
			if (loading) return false;
			loading = true;
			$('form', dialog).append('<input type="hidden" name="yes" value="1" />');
			var data = $('form', dialog).serialize();
			dialog.parents('.ui-dialog').find('.cg-loading').show();
			$.post(url, data, function(html) {
				dialog.parents('.ui-dialog').find('.cg-loading').hide();
				loading = false;
				if (!isNaN(html)) {
					dialog.dialog('close');
					var url = gridUrl + location.hash.replace(/#/, '');
					startLoad(grid);
					$.get(url, function(html) {
						$('.cg-table', grid).html(html);
						endLoad(grid);
						initGrid();
					});
				}
				// Otherwise reload the form
				else {
					dialog.html(html);
					dialog.scrollTop(0);
					if ($('.cg-form-js', grid).text()) {
						$.getScript($('.cg-form-js', grid).text());
					}
					initDialogForm(dialog);
				}
			});
		}

	};

})(jQuery);
