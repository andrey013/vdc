<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderCreate.js"></script>

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
</script >

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

        $("#Order_order_type_id, #Order_difficulty_id").on("change", function(){
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('/price/getPrice'); ?>",
                data: { order_type_id: $("#Order_order_type_id").val(),
                        difficulty_id: $("#Order_difficulty_id").val()},
                dataType: "json"
            }).done(function( msg ) {
                $("#Order_clientPrice").val(msg.clientPrice);
                $("#Order_designerPrice").val(msg.designerPrice);
            });
        });
        $("#Order_order_type_id").change();

	});
</script>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>