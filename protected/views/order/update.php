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


<script src="<?php echo Yii::app()->request->baseUrl; ?>/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<script type="text/javascript" >
tinyMCE.init({
        mode : "textareas",
        body_class : "span5",
        theme : "simple"   //(n.b. no trailing comma, this will be critical as you experiment later)
});
</script >

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderUpdate.js"></script>

<script>
	$(function(){
		'use strict';

		var status = $("#Order_orderStatus")
		$(".statusRadio").removeClass("active");
		$(".statusRadio[value="+status.val()+"]").addClass("active");
		var status = $("#Order_orderStatus")
		$(".statusRadio").bind('click', function(){
				status.val(this.value);
			});
		var link = "<?php echo $this->createUrl('/payment/jsonlist').'?id='.$model->id; ?>";
		var addlink = "<?php echo $this->createUrl('/payment/add'); ?>";
		var updatelink = "<?php echo $this->createUrl('/payment/jsonupdate'); ?>";
		var datagrid = new DatabaseGrid(link, addlink, updatelink);
		$("#addpayment").on("click", function(){
				$.ajax({
					url: '<?php echo $this->createUrl('/payment/create'); ?>',
					type: 'POST',
					dataType: "html",
					data: {
						id: <?php echo $model->id; ?>			
					},
					success: function (response) 
					{ 
					    datagrid.editableGrid.loadJSON(link);
					},
					error: function(XMLHttpRequest, textStatus, exception) { alert("Ошибка! \n" + errortext); },
					async: true
				});
			});
		// Initialize the jQuery File Upload widget:
    	$('#fileupload1').fileupload();
    	// Load existing files:
        $('#fileupload1').each(function () {
            var that = this;
            $.getJSON(this.action+'?id=<?php echo $model->id; ?>&stage=1', function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                        .call(that, null, {result: result});
                }
            });
        });
        // Initialize the jQuery File Upload widget:
        $('#fileupload2').fileupload();
        // Load existing files:
        $('#fileupload2').each(function () {
            var that = this;
            $.getJSON(this.action+'?id=<?php echo $model->id; ?>&stage=2', function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                        .call(that, null, {result: result});
                }
            });
        });
        // Initialize the jQuery File Upload widget:
        $('#fileupload3').fileupload();
        // Load existing files:
        $('#fileupload3').each(function () {
            var that = this;
            $.getJSON(this.action+'?id=<?php echo $model->id; ?>&stage=3', function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                        .call(that, null, {result: result});
                }
            });
        });
	});
</script>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>

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
                <button class="btn btn-mini btn-primary">
                    <i class="icon-upload icon-white"></i>
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