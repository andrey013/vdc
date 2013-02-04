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
function myCustomOnChangeHandler(inst) {
        var status = $("#Order_orderStatusHist");
        status.change();
}
tinyMCE.init({
        mode : "textareas",
        language : "ru",
        //body_class : "span5",
        theme : "advanced",
        theme_advanced_resizing : true,
        theme_advanced_resizing_max_width : 460,
        theme_advanced_resizing_min_width : 460,
        theme_advanced_resizing_max_height : 400,
        onchange_callback : "myCustomOnChangeHandler",
        <?php
            $role_id = User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id;
            if($role_id=='Designer') { ?>
        readonly : true,
        <?php } ?>
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,sub,sup,fontsizeselect,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_toolbar_location : "bottom",
        setup : function(ed)
        {
            ed.onInit.add(function(ed)
            {
                ed.getDoc().body.style.fontSize = 14;
            });
        }
});

    $(function(){
        $('#paidSum').tooltip({placement:'right', html:true});
    });
</script >

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderUpdate.js"></script>

<script>
	$(function(){
		'use strict';
        var status = $("#Order_orderStatusHist");
		$(".statusRadio").removeClass("active");
		$(".statusRadio[value="+status.val()+"]").addClass("active");
		$(".statusRadio").bind('click', function(){
				status.val(this.value);
                status.change();
			});
        <?php
            $role_id = User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id;
            if($role_id=='Admin') { ?>
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
        <?php } ?>
        var link2 = "<?php echo $this->createUrl('/comment/jsonlist').'?id='.$model->id; ?>";
        var addlink2 = "<?php echo $this->createUrl('/comment/add'); ?>";
        var updatelink2 = '';
        <?php if($role_id=='Admin') { ?>
                updatelink2 = "<?php echo $this->createUrl('/comment/remove'); ?>";
        <?php } ?>
        var commentgrid = new CommentGrid(link2, addlink2, updatelink2);
        $(".cancel-button").on("click", function(){
            if(confirm("Вы уверены? Несохраненные данные будут потеряны")){
                window.location = "<?php echo $this->createUrl('/order/list'); ?>";
            }
        });
        $(".copy-button").on("click", function(){
            var form = $("#order-form");
            form.attr("action","<?php echo $this->createUrl('/order/create'); ?>");
            form.submit();
        });
        $(".submit-button").on("click", function(){
            var form = $("#order-form");
            form.submit();
        });
	// Initialize the jQuery File Upload widget:
    	$('#fileupload1').fileupload({
            url: '<?php echo $this->createUrl("/file/json"); ?>?id=<?php echo $model->id; ?>&stage=1',
            <?php if($role_id=='Designer'){ ?>
            downloadTemplateId: 'template-download-readonly'
            <?php } ?>
        });
        $('#fileupload1').fileupload(
                'option',
                'maxChunkSize',
                4000000
        );
        // Load existing files:
        $.ajax({
            url: $('#fileupload1').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload1')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });

        // Initialize the jQuery File Upload widget:
        $('#fileupload2').fileupload({
            url: '<?php echo $this->createUrl("/file/json"); ?>?id=<?php echo $model->id; ?>&stage=2',
            <?php if($role_id=='Manager'){ ?>
            downloadTemplateId: 'template-download-readonly'
            <?php } ?>
        });
        $('#fileupload2').fileupload(
                'option',
                'maxChunkSize',
                4000000
        );
        // Load existing files:
        $.ajax({
            url: $('#fileupload2').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload2')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
        // Initialize the jQuery File Upload widget:
        $('#fileupload3').fileupload({
            url: '<?php echo $this->createUrl("/file/json"); ?>?id=<?php echo $model->id; ?>&stage=3',
            <?php if($role_id=='Manager'){ ?>
            downloadTemplateId: 'template-download-readonly'
            <?php } ?>
        });
        $('#fileupload3').fileupload(
                'option',
                'maxChunkSize',
                4000000
        );
        // Load existing files:
        $.ajax({
            url: $('#fileupload3').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload3')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
        $('#fileupload1').bind('fileuploaddone', function (e, data) {
            status.change();
        })
        $('#fileupload2').bind('fileuploaddone', function (e, data) {
            status.change();
        })
        $('#fileupload3').bind('fileuploaddone', function (e, data) {
            status.change();
        })

        $("#order-form :input")
            .on("change", function() {
                // do whatever you need to do when something's changed.
                // perhaps set up an onExit function on the window
                $('.new-button').fadeTo("fast", 0, function() { 
                    $('.new-button').addClass('hidden');
                    $('.edit-button').fadeTo(1, 0, function() {
                        $('.edit-button').removeClass('hidden');
                        $('.edit-button').fadeTo("fast", 1, function() { 
                            
                        });
                    });
                });
                //window.onbeforeunload = function() {
                //    return confirm("You are about to lose your form data.")
                //}

                // now remove the event handler from all the elements
                // since you don't need it any more.
                $("#order-form :input").unbind("change");
            });

            $("body").off("click", "#cancelLink1Button");
	          $("body").on("click", "#cancelLink1Button", function(){
        			$("#addLink1").popover('hide');
            });
          	$("body").off("click", "#addLink1Button");
        		$("body").on("click", "#addLink1Button", function(){
              $("#addLink1").popover('hide');
        			addLink(1,$("#addLink1Name").val(),$("#addLink1Link").val());
        		});
            $("#addLink1").popover({html:true});
	});
      function addLink(stage, name, link)
      {
	      $.ajax({
		      url: '<?php echo $this->createUrl("/file/addLink"); ?>',
		      type: 'POST',
		      dataType: "html",
		      data: {
			      id: <?php echo $model->id; ?>,
			      stage: stage, 
			      name: name,
            link: link
		      },
		      success: function (response) 
		      { 
            $(".files"+stage).empty()
			      $.ajax({
                url: $('#fileupload'+stage).fileupload('option', 'url'),
                dataType: 'json',
                context: $('#fileupload'+stage)[0]
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, null, {result: result});
            });
		      },
		      error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		      async: true
	      });
         
      }
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
                    <i class="icon-{% if (file.size == '') { %}share{% } else { %}file{% } %}">&nbsp;</i>
                    <a target="_blank" href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name?file.name:file.name%}</a>
                </div>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-mini pull-right" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-remove">&nbsp;</i>
            </button>
            <input class="hidden" type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>

<script id="template-download-readonly" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td class="name"><span class="two-liner span3">{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="name">
                <div class="two-liner">
                    <i class="icon-{% if (file.size == '') { %}share{% } else { %}file{% } %}">&nbsp;</i>
                    <a target="_blank" href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name?file.name:file.name%}</a>
                </div>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% } %}
        <td class="delete hidden">
            <button class="btn btn-mini pull-right" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-remove">&nbsp;</i>
            </button>
            <input class="hidden" type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
