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
		    editableGrid.loadJSON(link);
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}
   


function DatabaseGrid(config)
{
	var t = this;
	this.editableGrid = new EditableGrid("order", {
		enableSort: true,
		pageSize: 20,
   	    tableLoaded: function() { t.initializeGrid(this, config); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	if(confirm("Вы уверены?"))updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row, config.updateUrl, config.fetchUrl);
   	    	else this.setValueAt(rowIndex, columnIndex, oldValue);
       	},
       	tableRendered: function() {
   	    	updatePaginator(this);

			// set active (stored) filter if any
			$('#filter').val(grid.currentFilter ? grid.currentFilter : '');	
       	},
 	});
	this.fetchGrid(config.fetchUrl);
	var grid = this.editableGrid;
	

	// filter when something is typed into filter
	$('#filter').on("keyup", function() { grid.filter($('#filter').val()); });
}

DatabaseGrid.prototype.fetchGrid = function(link)  {
	// call a PHP script to get the data
	this.editableGrid.loadJSON(link);
};

DatabaseGrid.prototype.initializeGrid = function(grid, config) {
	// render for the action column
	config.init(grid);

	grid.renderGrid("tablecontent", "table " + config.tableClass);
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