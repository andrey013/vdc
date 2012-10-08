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
	highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#AEFFAE");
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
		    highlight(row.id, success ? "ok" : "error");
		    editableGrid.loadJSON(link);
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}

function pay(editableGrid, id, value, addlink, link)
{      
	$.ajax({
		url: addlink,
		type: 'POST',
		dataType: "html",
		data: {
			id: id, 
			value: value			
		},
		success: function (response) 
		{ 
			editableGrid.loadJSON(link);
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}
   


function DatabaseGrid(link, addlink, updatelink) 
{
	var t = this;
	this.editableGrid = new EditableGrid("demo", {
		enableSort: false,
		pageSize: 20,
   	    tableLoaded: function() { t.initializeGrid(this, link, addlink); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row, updatelink, link);
       	},
       	tableRendered: function() {
   	    	updatePaginator(this);
       	},
 	});
	this.fetchGrid(link);
	var grid = this.editableGrid;
	// set active (stored) filter if any
	$('#filter').val(grid.currentFilter ? grid.currentFilter : '');
		
	// filter when something is typed into filter
	$('#filter').on("keyup", function() { grid.filter($('#filter').val()); });
}

DatabaseGrid.prototype.fetchGrid = function(link)  {
	// call a PHP script to get the data
	this.editableGrid.loadJSON(link);
};

DatabaseGrid.prototype.initializeGrid = function(grid, link, addlink) {
	grid.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		
		cell.innerHTML = '<div class="input-append">' +
						'<input id="addPayment'+rowId+'" class="span2" type="text" value="0">' +
						'<button id="addPayment'+rowId+'Button" class="btn" type="button">&nbsp;<i class="icon-arrow-down"></i></button>' +
						'</div>';
		$("#addPayment"+rowId+"Button").on("click", function(){
			pay(grid, rowId, $('#addPayment'+rowId).val(), addlink, link);
		});
		$("#addPayment"+rowId).keypress(function (e) {
		    if (e.keyCode == 13) {
		        pay(grid, rowId, $('#addPayment'+rowId).val(), addlink, link);
		        return false;
		    }

		});


		//"<a href=\"" + addlink + "/id/" + rowId + "\">" +
		// "<i class='icon-edit'></i></a>";
	}}));
	grid.renderGrid("tablecontent", "table");
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
