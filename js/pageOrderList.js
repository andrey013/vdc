'use strict'
/**
 *  highlightRow and highlight are used to show a visual feedback. If the row has been successfully modified, it will be highlighted in green. Otherwise, in red
 */
function highlightRow(rowId, bgColor, after)
{
	var rowSelector = $("#" + rowId);
	rowSelector.css("background-color", bgColor);

	rowSelector.fadeTo("normal", 0.5, function() { 
		rowSelector.fadeTo("fast", 1, function() { 
			rowSelector.css("background-color", '');
		});
	});
}

function highlight(div_id, style) {
	highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#ffffff");
}
        
/**
   updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, updatelink, link)
{      
	$.ajax({
		url: updatelink,
		type: 'POST',
		dataType: "html",
		data: {
			tablename : editableGrid.name,
			id: editableGrid.getRowId(rowIndex), 
			newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1 : 0) : newValue, 
			colname: editableGrid.getColumnName(columnIndex),
			coltype: editableGrid.getColumnType(columnIndex)			
		},
		success: function (response) 
		{ 
			// reset old value if failed then highlight row
			var success = (response == "ok" || !isNaN(parseInt(response))); // by default, a sucessfull reponse can be "ok" or a database id 
			if (!success) editableGrid.setValueAt(rowIndex, columnIndex, oldValue);
		    //highlight(row.id, success ? "ok" : "error");
		    editableGrid.loadJSON(editableGrid.fetchUrl);
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}
   
function updateSum(editableGrid){
	var client_priceIndex = editableGrid.getColumnIndex("client_price");
	var designer_priceIndex = editableGrid.getColumnIndex("designer_price");
	var pennyIndex = editableGrid.getColumnIndex("penny");
	var payIndex = editableGrid.getColumnIndex("pay");
        var debtIndex = editableGrid.getColumnIndex("debt");
	var client_price = 0;
	var designer_price = 0;
	var penny = 0;
	var pay = 0;
        var debt = 0;
	for(var i = 0; i < editableGrid.getRowCount() ; i++){
		if(client_priceIndex >= 0) client_price += editableGrid.getValueAt(i, client_priceIndex);
		if(designer_priceIndex >= 0) designer_price += editableGrid.getValueAt(i, designer_priceIndex);
		if(pennyIndex >= 0) penny += editableGrid.getValueAt(i, pennyIndex);
		if(payIndex >= 0) pay += editableGrid.getValueAt(i, payIndex);
                if(debtIndex >= 0) debt += editableGrid.getValueAt(i, debtIndex);
	}
	var fmt = function(val){
		return number_format(val, 0, ',', ' ');
	}
	var sum = ''
	if(client_priceIndex >= 0) sum += fmt(client_price) + ' &nbsp; ';
	if(designer_priceIndex >= 0) sum += fmt(designer_price) + ' &nbsp; ';
	if(pennyIndex >= 0) sum += fmt(penny) + ' &nbsp; ';
	if(payIndex >= 0) sum += fmt(pay) + ' &nbsp; ';
        if(debtIndex >= 0) sum += fmt(debt) + ' &nbsp; ';
        else if(client_priceIndex >= 0) sum += fmt(client_price - pay);
	$("#sum").html('Итого: &nbsp; ' + sum);
}

function DatabaseGrid(config)
{
	var t = this;
	
	this.editableGrid = new EditableGrid("order", {
		enableSort: config.sort!==undefined?config.sort:true,
		pageSize: config.pageSize!==undefined?config.pageSize:20,
   	    tableLoaded: function() {
   	    	t.initializeGrid(this, config);
   	    	config.updateSum!==undefined?updateSum(this):0;
   	    },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	if(confirm("Вы уверены?"))updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row, config.updateUrl, config.fetchUrl);
   	    	else this.setValueAt(rowIndex, columnIndex, oldValue);
   	    	config.updateSum!==undefined?updateSum(this):0;
       	},
       	tableRendered: function() {
   	    	if(this.pageSize>0)updatePaginator(this);
			var grid = this;
			// set active (stored) filter if any
			$('#filter').val(
				this.localisset('listfilter') ? this.localget('listfilter') : '');

				//grid.currentFilter ? grid.currentFilter : '');
			var filters = $('[id^="filter_"]');
			filters.each(function(){
					var field = $(this).attr('id').substr(7);
					$(this).val(grid.localisset(field) ? grid.localget(field) : '');
				});	
       	},
 	});
	this.fetchGrid(config.fetchUrl);
	var grid = this.editableGrid;
	

	// filter when something is typed into filter
	$('#filter').on("keyup", function() { grid.filter($('#filter').val()); });
	$('[id^="filter_"]').on("change", function() { grid.filter($('#filter').val()); });
}

DatabaseGrid.prototype.fetchGrid = function(link)  {
	// call a PHP script to get the data
	this.editableGrid.fetchUrl = link;
	this.editableGrid.loadJSON(link);
};

DatabaseGrid.prototype.initializeGrid = function(grid, config) {
	// render for the action column
	config.init(grid);

	grid.renderGrid("tablecontent", "table " + config.tableClass);
	grid.filter($('#filter').val());
};    

// function to render the paginator control
function updatePaginator (editableGrid)
{
	var paginator = $("#paginator").empty();
	var nbPages = editableGrid.getPageCount();
	// get interval
	var interval = editableGrid.getSlidingPageInterval(20);
	if (interval == null) return;
	// get pages in interval (with links except for the current page)
	var pages = editableGrid.getPagesInInterval(interval, function(pageIndex, isCurrent) {
		if (isCurrent)
		return $("<li>").append($("<a>").html(pageIndex + 1)).addClass("active");
		return $("<li>").append($("<a>").html(pageIndex + 1).click(function(event) { editableGrid.setPageIndex(parseInt($(this).html()) - 1); }));
	});
	// "first" link
	var link = $("<li>").append($("<a>").html("<<"));
	if (!editableGrid.canGoBack()) link.addClass("disabled");
	else link.click(function(event) { editableGrid.firstPage(); });
	paginator.append(link);
	// "prev" link
	link = $("<li>").append($("<a>").html("<"));
	if (!editableGrid.canGoBack()) link.addClass("disabled");
	else link.click(function(event) { editableGrid.prevPage(); });
	paginator.append(link);
	// pages
	for (var p = 0; p < pages.length; p++) paginator.append(pages[p]);
	// "next" link
	link = $("<li>").append($("<a>").html(">"));
	if (!editableGrid.canGoForward()) link.addClass("disabled");
	else link.click(function(event) { editableGrid.nextPage(); });
	paginator.append(link);
	// "last" link
	link = $("<li>").append($("<a>").html(">>"));
	if (!editableGrid.canGoForward()) link.addClass("disabled");
	else link.click(function(event) { editableGrid.lastPage(); });
	paginator.append(link);
}; 
