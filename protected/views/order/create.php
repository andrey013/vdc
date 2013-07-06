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

        <?php
            $role_id = User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id;
        ?>

<script>
	$(function(){
		'use strict';

		var status = $("#Order_orderStatusHist")
		$(".statusRadio").removeClass("active");
		$(".statusRadio[value="+status.val()+"]").addClass("active");
		var status = $("#Order_orderStatusHist")
		$(".statusRadio").bind('click', function(){
				status.val(this.value);
			});

        $(".submit-button").on("click", function(){
            $(this).attr('disabled', true);
            $("#action").val($(this).val());
            var form = $("#order-form");
            form.submit();
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

            $("body").off("click", "#cancelLink2Button");
	          $("body").on("click", "#cancelLink2Button", function(){
        			$("#addLink2").popover('hide');
            });
          	$("body").off("click", "#addLink2Button");
        		$("body").on("click", "#addLink2Button", function(){
              $("#addLink2").popover('hide');
        			addLink(2,$("#addLink2Name").val(),$("#addLink2Link").val());
        		});
            $("#addLink2").popover({html:true});

            $("body").off("click", "#cancelLink3Button");
	          $("body").on("click", "#cancelLink3Button", function(){
        			$("#addLink3").popover('hide');
            });
          	$("body").off("click", "#addLink3Button");
        		$("body").on("click", "#addLink3Button", function(){
              $("#addLink3").popover('hide');
        			addLink(3,$("#addLink3Name").val(),$("#addLink3Link").val());
        		});
            $("#addLink3").popover({html:true});
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
		'model' => $model,
		'buttons' => 'create'));
?>
