<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/tmpl.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fileupload.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fileupload-ui.js"></script>


<script>
	$(function(){

		// Initialize the jQuery File Upload widget:
    	$('#fileupload').fileupload();
	 	$('#fileupload').fileupload(
	        'option',
	        'autoUpload',
	        true
	    );
	 	$('#fileupload').fileupload(
	        'option',
	        'maxChunkSize',
	        8000000
	    );
    	// Load existing files:
        $('#fileupload').each(function () {
            var that = this;
            $.getJSON(this.action, function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                        .call(that, null, {result: result});
                }
            });
        });

        datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/document/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/document/jsonupdate/'); ?>",
			init:
				function(grid){
					grid.setCellRenderer("name", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = value;
						$("<span>").append(displayValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellRenderer("delete_url", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = value;
						$("<button>").append('Удалить').addClass("btn btn-margin")
						.on('click', function(){
							$.ajax({
				                //context: button.closest('.template-download'),
				                url: value,
				                type: 'DELETE',
				                success: function(){
				                	grid.loadJSON("<?php echo $this->createUrl('/document/jsonlist'); ?>");
				                }
				            });
						})
						.appendTo(cell);
					}}));
				}
		});
		$('#fileupload').bind('fileuploaddone', function (e, data) {
			datagrid.fetchGrid("<?php echo $this->createUrl('/document/jsonlist'); ?>")
		})
	});
</script>

<h1>Ссылки</h1>
<div class="controls controls-row row">
	<form id="fileupload" action="<?php echo $this->createUrl('/document/json'); ?>" method="POST" enctype="multipart/form-data" class="span10">


		<span class="btn btn-magenta fileinput-button">
			Добавить документ
			<input type="file" name="files[]" multiple>
		</span>
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<div class="fileupload-buttonbar">
			<!-- The table listing the files available for upload/download -->
			<div class="span6" style="visibility:hidden; height: 1px">
				<table role="presentation" class="table table-condensed lefted">
					<thead>
						<tr>
							<th colspan="5">
								
							</th>
						</tr>
					</thead>
					<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
					</tbody>
				</table>
			</div>

			<!-- The global progress information -->
			<div class="span6 fileupload-progress fade">
				<!-- The global progress bar -->
				<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					<div class="bar" style="width:0%;"></div>
				</div>
				<!-- The extended global progress information -->
				<div class="progress-extended hidden">&nbsp;</div>
			</div>
		</div>
		
		<!-- The loading indicator is shown during file processing -->
		<div class="fileupload-loading"></div>
		<br>
	</form>
</div>

<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <!--<td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>-->
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-mini pull-right">
                    <i class="icon-upload"></i> Загрузить
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="1"></td>
        {% } %}
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td class="name"><span class="two-liner span3">{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="name">
                <div class="two-liner">
                    <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
                </div>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-mini" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-remove">&nbsp;</i>
            </button>
            <input class="hidden" type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
