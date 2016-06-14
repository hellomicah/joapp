<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- EDIT Date Received Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'JoSewing_date_received_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Date Received:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'JoSewing_dateForm_received',
		'type' => 'horizontal',
		'action'=> Yii::app()->createUrl('/joSewing/edit'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoSewing[jo_id]" id="JoSewing_jo_id" value="" />
		<?php echo $form->datePickerGroup(
			$model,
			'date_received',
			
			array(
				'format' => 'yyyy-mm-dd',
				'viewformat' => 'MMM/dd/yy',
				'widgetOptions' => array(
					//'format' => 'yyyy-mm-dd',
        			
					'options' => array(
						'language' => 'en',
						'autoclose'=> 'true'
					),
				),
				'wrapperHtmlOptions' => array(
					//'value'=>'2016-02-02',
					'class' => 'col-sm-5',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
		<div class="form-actions">
		<?php $this->widget(
			'booster.widgets.TbButton', 
			array(
				'buttonType' => 'ajaxSubmit',
				'context' => 'primary',
				'label' => 'Submit',
				//'type' => 'link',
				'url' => Yii::app()->createUrl('/joSewing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => Yii::app()->createUrl('/joSewing/edit'),
                	'data' => "js:{name: 'date_received',value: $('#JoSewing_date_received').val(), pk: $('#JoSewing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoSewing_jo_id").val();
                				var row = $("tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				var jo_id = $("#"+row+"").children("td#date_received").html(data.field_value);
                				//console.log(response);
                                $("#JoSewing_date_received_modal").modal("toggle");
                       
                	}',
                )

			)
		); ?>
		</div>

	<?php
	$this->endWidget();
	unset($form); ?>
	</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->

