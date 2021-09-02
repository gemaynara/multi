jQuery(document).ready(function($) {
	// add Porto Studio menu
	elementor.on('panel:init', function() {
		$('<div id="porto-elementor-panel-porto-studio" class="elementor-panel-footer-tool tooltip-target" data-tooltip="Porto Studio"><i class="porto-icon-studio" aria-hidden="true"></i><span class="elementor-screen-only">Porto Studio</span></div>').insertAfter('#elementor-panel-footer-saver-preview').tipsy({
			gravity: 's',
			title: function title() {
				return this.getAttribute('data-tooltip');
			}
		});
	});

	elementor.on('frontend:init', function() {
		var custom_css = elementor.settings.page.model.get('porto_custom_css');
		if (typeof custom_css != 'undefined') {
			setTimeout(function() {
				elementorFrontend.hooks.doAction('refresh_dynamic_css', custom_css);
			}, 1000);
		}
	});

	var portoMasonryTimer = null;
	$(document.body).on('input', '.elementor-control-width1 input[data-setting="size"]', function(e) {
		if (portoMasonryTimer) {
			clearTimeout(portoMasonryTimer);
		}
		var $this = $(this);
		portoMasonryTimer = setTimeout(function() {
			elementorFrontend.hooks.doAction('masonry_refresh', false, $this.val());
		}, 300);
	});

	$(document.body).on('input', 'textarea[data-setting="porto_custom_css"]', function(e) {
		elementorFrontend.hooks.doAction('refresh_dynamic_css', $(this).val());
	}).on('click', '.porto-elementor-btn-reload', function(e) {
		e.preventDefault();
		if (!elementor.saver.isEditorChanged()) {
			return false;
		}
		var $this = $(this);
		$this.attr('disabled', true);
		setTimeout(function() {
			$this.removeAttr('disabled');
		}, 10000);
		$e.run('document/save/auto', {
			force: true,
			onSuccess: function onSuccess() {
				elementor.reloadPreview();
				elementor.once('preview:loaded', function () {
					$e.route('panel/page-settings/settings');
					$this.removeAttr('disabled');
				});
			}
		});
	});
});