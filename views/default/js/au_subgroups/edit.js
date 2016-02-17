define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');


	// Initialize global variable for ajax requests
	var ajax_request = false;

	$(document).on('keyup', '.au-subgroups-search', function () {
		var query = $(this).val();
		var results = $('.au-subgroups-search-results');
		var subgroup_guid = elgg.page_owner.guid;

		if (query.length < 3) {
			return;
		}

		// cancel any existing ajax requests
		// there's a good chance one was initiated
		// for fast typers
		if (ajax_request) {
			ajax_request.abort();
		}

		results.addClass('au-subgroups-throbber');
		results.html('');

		// get the results
		ajax_request = elgg.get('ajax/view/au_subgroups/search_results', {
			timeout: 120000, //2 min
			data: {
				q: query,
				subgroup_guid: subgroup_guid
			},
			success: function (result, success, xhr) {
				console.log(result);
				results.removeClass('au-subgroups-throbber');
				results.html(result);
			},
			error: function (result, response, xhr) {
				results.removeClass('au-subgroups-throbber');
				if (response == 'timeout') {
					results.html(elgg.echo('au_subgroups:error:timeout'));
				} else {
					results.html(elgg.echo('au_subgroups:error:generic'));
				}
			}
		});
	});


	$(document).on('click', '.au-subgroups-parentable, .au-subgroups-non-parentable', function (e) {
		e.preventDefault();

		if ($(this).hasClass('au-subgroups-non-parentable')) {
			elgg.register_error(elgg.echo('au_subgroups:error:permissions'));
			return;
		}

		var subgroup_guid = elgg.page_owner.guid;
		var action = $(this).attr('data-action') + '&subgroup_guid=' + subgroup_guid;

		if (confirm(elgg.echo('au_subgroups:move:confirm'))) {
			window.location.href = action;
		}
	});


});