jQuery(document).ready(function() {
	
	jQuery('input[name=date_from]').change(function() {
		jQuery(this).closest('.ganalytics-table').parent().find('.ga-chart').gaChart('refresh', {
			start: jQuery(this).val()
		});
	});
	jQuery('input[name=date_to]').change(function() {
		jQuery(this).closest('.ganalytics-table').parent().find('.ga-chart').gaChart('refresh', {
			end: jQuery(this).val()
		});
	});
	
	jQuery('.date-range-button').click(function(){
		var range = 'day';
		var cl = jQuery(this).attr('class');
		var parent = jQuery(this).parent().parent();
		if(cl.indexOf('date-range-day') >= 0){
			range = 'day';
			parent.find('.date-range-day').attr('src', parent.find('.date-range-day').attr('src').replace('day-disabled-32.png', 'day-32.png'));
			parent.find('.date-range-week').attr('src', parent.find('.date-range-week').attr('src').replace('week-32.png', 'week-disabled-32.png'));
			parent.find('.date-range-month').attr('src', parent.find('.date-range-month').attr('src').replace('month-32.png', 'month-disabled-32.png'));
		}
		if(cl.indexOf('date-range-week') >= 0){
			range = 'week';
			parent.find('.date-range-day').attr('src', parent.find('.date-range-day').attr('src').replace('day-32.png', 'day-disabled-32.png'));
			parent.find('.date-range-week').attr('src', parent.find('.date-range-week').attr('src').replace('week-disabled-32.png', 'week-32.png'));
			parent.find('.date-range-month').attr('src', parent.find('.date-range-month').attr('src').replace('month-32.png', 'month-disabled-32.png'));
		}
		if(cl.indexOf('date-range-month') >= 0){
			range = 'month';
			parent.find('.date-range-day').attr('src', parent.find('.date-range-day').attr('src').replace('day-32.png', 'day-disabled-32.png'));
			parent.find('.date-range-week').attr('src', parent.find('.date-range-week').attr('src').replace('week-32.png', 'week-disabled-32.png'));
			parent.find('.date-range-month').attr('src', parent.find('.date-range-month').attr('src').replace('month-disabled-32.png', 'month-32.png'));
		}
		jQuery(this).parent().parent().find('.ga-chart').gaChart('refresh', {
			dateRange: range
		});
	});
});

function showCharts(){
	jQuery('.ga-chart').gaChart('refresh', {
		start: jQuery('input[name=date_from]').val(),
		end: jQuery('input[name=date_to]').val()
	});
}