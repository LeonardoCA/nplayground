(function ($, undefined) {
	/**
	 * Applies sortable on replicator containers
	 */
	$.nette.ext('sortable-replicator', {
		init: function (payload) {
			this.init();
		},
		success: function (payload) {
			this.init();
		}
	}, {
		init: function () {
			$(".replicator-sortable").sortable({
				forcePlaceholderSize: true,
				placeholder: "ui-state-highlight",
				cursor: 'move',
				axis: 'y',
				helper: "clone",
				create: function (e, ui) {
					var sortableObj = $(e.target);
					if (sortableObj.attr('data-replicator-sortable-connectWith') !== undefined) {
						sortableObj.sortable('option', {
							connectWith: "[data-replicator-sortable-connectWith=" + sortableObj.attr('data-replicator-sortable-connectWith') + "]"
						});
						sortableObj.sortable({
							receive: function (e, ui) {
								var ids = ui.item.parent().find('.replicator-sortable-item').map(function () {
									return $(this).attr('data-replicator-item-id');
								}).get();
								var nextId = Math.max.apply(Math, ids) + 1;
								ui.item.find('input').each(function () {
									var replicators = $(this).parents('[data-replicator-item-id]').map(function () {
										return {
											name: $(this).parent().attr('data-replicator-name'),
											id: $(this).attr('data-replicator-item-id')
										};
									});
									for (var index = 0; index < replicators.length; ++index) {
										$(this).attr('name', $(this).attr('name').replace(
											new RegExp("(\\[?" + replicators[index].name + "]?)\\[\\d+](?!.*\\[remove]$)", "g"),
											"$1[" + (index == 0 ? nextId : replicators[index].id) + "]"
										));
									}
								});
								ui.item.find('[type="submit"][data-replicator-item-remove]').click();
							}
						});
					}
				}
			});
		}
	});
})(jQuery);
