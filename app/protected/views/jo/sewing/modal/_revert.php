<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- EDIT Delivery Date Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'revert_modal',
	'htmlOptions'=>array('style'=>'display:none;',)
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Update JO Output:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'revertForm',
		'type' => 'horizontal',
        //'htmlOptions' => array('class' => 'well'),
		'action'=> array('joSewing/revert/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoSewing[jo_id]" id="JoSewing_jo_id" value="" />
		<input type="hidden" name="JoSewing[quantity]" id="JoSewing_quantity" value="" />
		
		<?php echo $form->textFieldGroup($model, 'output'
		
		); ?>
		<div class="form-actions">
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'ajaxSubmit',
				'context' => 'primary',
				'label' => 'Revert',
				//'type' => 'link',
				'url' => $this->createURL('joSewing/revert'),
				'disabled' => false,
				'htmlOptions'=>array("style"=>"float:right;"),
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('joSewing/revert'),
                	'data' => "js:{
                		quantity: $('form#revertForm > input#JoSewing_quantity').val(), 
                		output: $('form#revertForm #JoSewing_output').val(), 
                		jo_id: $('form#revertForm > #JoSewing_jo_id').val()
                	}",
                	'success'=>'js:function(response){
                		$("span#JoSewing_output_error").html("");
                				console.log(response);
                		
                       $("#JoSewing_output").removeAttr("readonly");
                       $("#loading_ajax").attr("style","display:none;");
                       
                		if(response.success == "false"){
                				$("span#JoSewing_output_error").html(response.msg);
                		}else{
                			 $("#revert_modal").modal("hide");
                       
                       		bootbox.alert("JO successfully updated!", function() {
                       			var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    			$("body").append(div_val);
		            			window.location.reload();
		        			});
                		}
                       
                      
                       
                	}',
                	
                	'beforeSend'=>'js:function(data){
                				
                       $("#JoSewing_output").attr("readonly","readonly");
                       $("#loading_ajax").removeAttr("style");
                	}',
                )

			)
		); ?><span><img id="loading_ajax" src="<?php echo Yii::app()->baseUrl;?>/images/loading_spinner.gif " height="40" width="42" style="display:none;"/></span>
		<span id="JoSewing_output_error" style="color: red; font-size: 10px ! important; margin-left: 152px;"></span>
		</div>
		<br/><br/>

<?php
$this->endWidget();
unset($form); ?>
	</div>

<?php $this->endWidget(); ?>
<!-- View Popup ends -->


