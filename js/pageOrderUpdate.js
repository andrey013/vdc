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
   	    tableLoaded: function() { t.initializeGrid(this, link, addlink); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row, updatelink, link);
       	},
 	});
	this.fetchGrid(link);
	var grid = this.editableGrid;
}

DatabaseGrid.prototype.fetchGrid = function(link)  {
	// call a PHP script to get the data
	this.editableGrid.loadJSON(link);
};

DatabaseGrid.prototype.initializeGrid = function(grid, link, addlink) {
	grid.setCellRenderer("paidhistory", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		
		cell.innerHTML = '<div class="input-append pull-right">' +
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
		var words = value.split(' ');
		var text = '';
		$.each(words, function(index, value) {
			if(index==0)return;
			var column = grid.getColumn("paid");
			if(index % 3 == 1) text += value;
			else if(index % 3 == 2) text += ' ' + value;
			else text += ' - ' +
			  number_format(value, column.precision, column.decimal_point, column.thousands_separator) +
			  ' р.' + '<br>';
		})
		$("#paid_"+rowId).tooltip({title:text, placement: 'right'});
	}}));

	grid.setCellRenderer("client_price", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		var column = this.column;
		var displayValue = number_format(value, column.precision, column.decimal_point, column.thousands_separator);
		$("<span>").append(displayValue).addClass("dotted").appendTo(cell);
	}}));

	grid.setCellRenderer("designer_price", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		var column = this.column;
		var displayValue = number_format(value, column.precision, column.decimal_point, column.thousands_separator);
		$("<span>").append(displayValue).addClass("dotted").appendTo(cell);
	}}));

	grid.setCellRenderer("paid", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		var column = this.column;
		
		var displayValue = number_format(value, column.precision, column.decimal_point, column.thousands_separator);
		$("<span id='paid_"+rowId+"'>").append(displayValue).addClass("dotted").appendTo(cell);
	}}));
	grid.renderGrid("tablecontent", "table table-condensed");
};    


function getParameterByName(str, name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(str);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}


function addComment(editableGrid, parent_id, text, addlink, link)
{
	var id = getParameterByName(link, "id");
	$.ajax({
		url: addlink,
		type: 'POST',
		dataType: "html",
		data: {
			id: id,
			parent_id: parent_id, 
			text: text			
		},
		success: function (response) 
		{ 
			editableGrid.loadJSON(link);
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}

function CommentGrid(link, addlink, updatelink) 
{
	var t = this;
	this.editableGrid = new EditableGrid("demo", {
		enableSort: false,
   	    tableLoaded: function() { t.initializeGrid(this, link, addlink); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row, updatelink, link);
       	},
 	});
	this.fetchGrid(link);
	var grid = this.editableGrid;
}

CommentGrid.prototype.fetchGrid = function(link)  {
	// call a PHP script to get the data
	this.editableGrid.loadJSON(link);
};

CommentGrid.prototype.initializeGrid = function(grid, link, addlink) {
	grid.setHeaderRenderer("comment", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		
		cell.innerHTML ='<span class="lead pull-left">Комментарии: </span>' +
						'<div class="pull-right">' +
						'<button type="button" id="commentButton" class="btn"' +
						' data-content="<textarea id=\'addCommentText\' class=\'span5\'></textarea><button id=\'addCommentButton\' type=\'button\' class=\'btn btn-magenta\'>Отправить</button>"' +
						' data-placement="bottom"' +
						' rel="popover"' +
						' data-original-title="Комментарий">' +
						' 	Написать' +
						'</button>' +
						//'<button id="addCommentButton" class="btn span3" type="button"><i class="icon-plus"></i> Оставить комментарий</button>' +
						'</div>';

		$("body").off("click", "#addCommentButton");
		$("body").on("click", "#addCommentButton", function(){
			$("#commentButton").popover('destroy');
			addComment(grid, null, $('#addCommentText').val(), addlink, link);
		});
		$("#commentButton").popover();
	}}));
	grid.setCellRenderer("comment", new CellRenderer({render: function(cell, value) {
		var rowId = grid.getRowId(cell.rowIndex);
		//alert(value.replace(/\r\n/g, "<br/>").replace(/\r/g, "<br/>").replace(/\n/g, "<br/>"));
		var comment = $.parseJSON(value.replace(/\r\n/g, "<br/>").replace(/\r/g, "<br/>").replace(/\n/g, "<br/>"));
		cell.innerHTML = 
						'<div class="pull-left muted offset0'+comment.depth+'">' + 
							comment.role + '&nbsp;<strong>' + comment.user + '</strong>&nbsp;' + comment.date +
						'</div>' +
						'<br />' +
						'<div class="pull-left offset0'+(comment.depth)+'">' + 
							comment.text +
						'</div>' +
						'<div class="pull-right">' +
						((comment.depth<9)?
						'<button type="button" id="comment'+rowId+'Button" class="btn btn-mini"' +
						' data-content="<textarea id=\'addComment'+rowId+'Text\' class=\'span5\'></textarea><button id=\'addComment'+rowId+'Button\' type=\'button\' class=\'btn btn-magenta\'>Отправить</button>"' +
						' data-placement="bottom"' +
						' rel="popover"' +
						' data-original-title="Комментарий">' +
						' 	Ответить' +
						'</button>':'') +
						//'<button id="addPayment'+rowId+'Button" class="btn" type="button">&nbsp;<i class="icon-arrow-down"></i></button>' +
						'</div>';
		$("body").off("click", "#addComment"+rowId+"Button");
		$("body").on("click", "#addComment"+rowId+"Button", function(){
			$("#comment"+rowId+"Button").popover('destroy');
			addComment(grid, rowId, $("#addComment"+rowId+"Text").val(), addlink, link);
		});
		$("#comment"+rowId+"Button").popover();
	}}));
	grid.renderGrid("commentcontent", "table table-condensed lefted comment-table");
};    

