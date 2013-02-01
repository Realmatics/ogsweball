jQuery(document).ready(function() {
	
	// add the tabs
	jQuery("#tabs").tabs({
		cookie: {expires: 30},
		tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'></span></li>",
		add: function(event, ui) {
			jQuery(ui.panel).append('<table width="100%" class="chart-table"><tr><td></td></tr>');
		},
		show: function(event, ui) {
			if(jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide) .ganalytics_chart').children().length > 0){
				return;
			}
			showCharts();
		}
	});
	
	
	// group manipulation
	jQuery("#add-tab-button").click(function() {
		jQuery.fancybox({
			width:500,
			height:100,
			content : jQuery("#dialog-group"),
			autoDimensions : false,
			transitionIn : 'elastic',
			transitionOut : 'elastic',
			speedIn : 600,
			speedOut : 200,
			onStart: function() {
				jQuery("#dialog-group").show();
				jQuery("#tab_title").focus();
			},
			onClosed: function() {
				jQuery("#dialog-group").hide();
				jQuery('#tab_title').val('');
			}
		});
		jQuery("#dialog-group-save").click(function(){
			jQuery.ajax({
				type: 'POST',
				url: 'index.php?option=com_ganalytics&task=dashboard.addgroup',
				data: {name:  jQuery("#tab_name").val() || "Group"},
				success: function (data) {
					var json = showAjaxMessage(data);
					if(json.status == 'success'){
						window.location.hash="";
						window.location.href = window.location.href.replace('#', '')+'#tabs-' + json.id;
						window.location.reload(true);
					}
				}
			});
		});
	});

	jQuery("#tabs > ul > li span.ui-icon-close").live("click", function() {
		var index = jQuery('#tabs > ul > li').index(jQuery(this).parent());
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_ganalytics&task=dashboard.deletegroup',
			data: {id:  jQuery(this).parent().children('a').attr('href').replace('#tabs-')},
			success: function (data) {
				var json = showAjaxMessage(data);
				if(json.status == 'success'){
					jQuery('#tabs').tabs("remove", '#tabs-'+json.id);
				}
			}
		});
	});

	// widget stuff
	makeSortable();
	
	jQuery(".portlet")
		.addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".portlet-header")
		.addClass("ui-widget-header ui-corner-all")
		.prepend("<span class='ui-icon ui-icon-gear'></span>")
		.prepend("<span class='ui-icon ui-icon-closethick'></span>")
		.prepend("<span class='ui-icon ui-icon-minusthick'></span>")
		.end().find(".portlet-content");

	jQuery(".chart-table > tbody > tr > td").disableSelection();
	
	jQuery('.inputbox').live('change', function() {
		var form = jQuery(this).parents('form');
		if(form.attr('name') != 'adminForm'){
			return;
		};
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_ganalytics&task=dashboard.savewidget',
			data: form.serialize(),
			success: function (data) {
				var json = showAjaxMessage(data);
				if(json.status == 'success'){
					form.gaChart('refresh');
					form.parent().parent().find('.portlet-title').text(form.find('input[name=name]').val());
				}
			}
		});
	});
	
	jQuery(".portlet-header .ui-icon-gear").live('click', function() {
		var form = jQuery(this).parent().parent().find(".adminform");
		if(!form.is(':visible') && form.find('.dimensionscombo option').length < 2){
			var combo = form.find('.dimensionscombo');
			var value = combo.find('option').val().split(',');
			
			combo.multiselect2side('destroy');
			combo.replaceWith(jQuery('#dialog-widget .dimensionscombo').clone());
			
			jQuery.each(value, function(index, item) {
				form.find('.dimensionscombo').find("[value='" + item + "']").attr('selected', true);
			});

			createMultiSelectCombo(form.find('.dimensionscombo'));
		}
		if(!form.is(':visible') && form.find('.metricscombo option').length < 2){
			var combo = form.find('.metricscombo');
			var value = combo.find('option').val().split(',');
			
			combo.multiselect2side('destroy');
			combo.replaceWith(jQuery('#dialog-widget .metricscombo').clone().val(value));
			
			jQuery.each(value, function(index, item) {
				form.find('.dimensionscombo').find("[value='" + item + "']").attr('selected', true);
			});
			
			createMultiSelectCombo(form.find('.metricscombo'));
		}
		updateSortCombo(form);
		form.slideToggle("slow");
	});
	
	jQuery(".portlet-header .ui-icon-minusthick").live('click', function() {
		jQuery(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
		jQuery(this).parents(".portlet:first").find(".portlet-content").toggle();
	});
	jQuery(".portlet-header .ui-icon-closethick").live('click', function() {
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_ganalytics&task=dashboard.deletewidget',
			data: {id: jQuery(this).parent().parent().find('input[name=id]').val()},
			success: function (data) {
				var json = showAjaxMessage(data);
				if(json.status == 'success'){
					jQuery('#widgetForm-'+json.id).parent().parent().remove();
				}
			}
		});
	});
	
	
	jQuery(".column-action .ui-icon-calculator").live('click', function() {
		var cell = jQuery(this).parent().parent();
		jQuery("#dialog-widget").data('gacolumn', cell.parent().children().index(cell));
		
		jQuery("#dialog-widget").find('.dimensionscombo').multiselect2side('destroy');
		jQuery("#dialog-widget").find('.metricscombo').multiselect2side('destroy');
		createMultiSelectCombo(jQuery("#dialog-widget").find('.dimensionscombo'));
		createMultiSelectCombo(jQuery("#dialog-widget").find('.metricscombo'));
		
		jQuery.fancybox({
			width:700,
			height:430,
			content : jQuery("#dialog-widget"),
			autoDimensions : false,
			transitionIn : 'elastic',
			transitionOut : 'elastic',
			speedIn : 600,
			speedOut : 200,
			onStart: function() {
				jQuery("#dialog-widget").show();
//				jQuery("#tab_title").focus();
			},
			onClosed: function() {
				jQuery("#dialog-widget").hide();
//				jQuery('#tab_title').val('');
			}
		});
		jQuery("#dialog-widget-save").click(function(){
			jQuery.ajax({
				type: 'POST',
				url: 'index.php?option=com_ganalytics&task=dashboard.savewidget',
				data: jQuery("#dialog-widget form").serialize()+'&column='+jQuery("#dialog-widget").data('gacolumn')+'&group_id='+jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide)').attr('id').replace('tabs-', ''),
				success: function (data) {
					var json = showAjaxMessage(data);
					if(json.status == 'success'){
						window.location.reload(true);
					}
					jQuery.fancybox.close();
				}
			});
		});
	});

	// column stuff
	jQuery(".column-action .ui-icon-minusthick").live('click', function() {
		var cell = jQuery(this).parent().parent();
		var column = cell.parent().children().index(cell);
		var groupID = cell.parent().parent().parent().attr('id').replace('tabs-', '');
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_ganalytics&task=dashboard.deletecolumn',
			data: {id: groupID, column: column},
			success: function (data) {
				var json = showAjaxMessage(data);
				if(json.status == 'success'){
					jQuery('#tabs-'+json.id).children('tbody').children().children('td:eq(' + json.column + ')').remove();
					jQuery('#tabs-'+json.id).children('thead').children().children('td:eq(' + json.column + ')').remove();
					
					makeSortable();
					
					showCharts();
				}
			}
		});
	});
	
	jQuery(".column-action .ui-icon-plusthick").live('click', function() {
		var cell = jQuery(this).parent().parent();
		var column = cell.parent().children().index(cell);
		var groupID = cell.parent().parent().parent().attr('id').replace('tabs-', '');
		
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_ganalytics&task=dashboard.addcolumn',
			data: {id: groupID, column: column},
			success: function (data) {
				var json = showAjaxMessage(data);
				if(json.status == 'success'){
					var cellToAppend = jQuery('#tabs-'+json.id).children('thead').children().children('td:eq(' + json.column + ')');
					var newColumn = cellToAppend.clone();
					cellToAppend.after(newColumn);

					var cellToAppend = jQuery('#tabs-'+json.id).children('tbody').children().children('td:eq(' + json.column + ')');
					var newColumn = cellToAppend.clone(false).html('');
					cellToAppend.after(newColumn);
					
					makeSortable();
					
					showCharts();
				}
			}
		});
	});

	// global setting stuff
	jQuery('#profiles').change(function() {
		jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide)').find('form[name=adminForm]').gaChart('refresh', {
			gaid: jQuery(this).val()
		});
	});
	jQuery('#date_from').change(function() {
		jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide)').find('form[name=adminForm]').gaChart('refresh', {
			start: jQuery(this).val()
		});
	});
	jQuery('#date_to').change(function() {
		jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide)').find('form[name=adminForm]').gaChart('refresh', {
			end: jQuery(this).val()
		});
	});
	jQuery('.adminform').hide();
});
				
function saveCharts(){
	var activeTab = jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide)');
	var countCol = activeTab.children('tbody').children('tr:first-child').children('td').length;

	var chartData = activeTab.children('tbody').children().children().map(function(i) {
		var column = {};
		jQuery(this).children('div').each(function(i) {
			column[i] = jQuery(this).find('input[name=id]').val();
		});
		return column;
	}).get();

	jQuery.ajax({
		type: 'POST',
		url: 'index.php?option=com_ganalytics&task=dashboard.save',
		data: {structure:  JSON.stringify(chartData)},
		success: function (data) {
			showAjaxMessage(data);
		}
	});
}

function showCharts(){
	var activeTab = jQuery('#tabs table.ui-tabs-panel:not(.ui-tabs-hide)');
	var countCol = activeTab.children('tbody').children('tr:first-child').children('td').length;
	activeTab.children('tbody').children('tr:first-child').children('td').each(function(i) {
		var cell = jQuery(this);
		var width = (activeTab.width()-30)/countCol;
		cell.width(width);
		cell.find('.ganalytics_chart').width(width-30);
	});
	activeTab.find('form[name=adminForm]').gaChart('refresh', {start: jQuery('#date_from').val(), end: jQuery('#date_to').val()});
}

function showAjaxMessage(data) {
	var tmp = jQuery.parseJSON(data); 
	jQuery.pnotify({
	    pnotify_title: '',
	    pnotify_text: tmp.message,
	    pnotify_opacity: .95
	});
	return tmp;
}

function makeSortable(){
	jQuery(".chart-table > tbody > tr > td").sortable({
		connectWith : ".chart-table > tbody > tr > td",
		handle: 'div.portlet-header .portlet-title',
		items: 'div.portlet',
		stop: function(event, ui) {
			ui.item.find('.adminForm').gaChart('show');
			saveCharts();
		},
		start: function(event, ui) {
			ui.item.find('.adminForm').gaChart('hide');
		}
	});
}