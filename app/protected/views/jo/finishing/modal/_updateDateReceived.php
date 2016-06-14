<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- EDIT Date Received Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'JoFinishing_date_received_modal',
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
		'id' => 'JoFinishing_dateForm_received',
		'type' => 'horizontal',
		'action'=> array('joFinishing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoFinishing[jo_id]" id="JoFinishing_jo_id" value="" />
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
				'url' => $this->createURL('joFinishing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('joFinishing/edit'),
                	'data' => "js:{name: 'date_received',value: $('#JoFinishing_date_received').val(), pk: $('#JoFinishing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoFinishing_jo_id").val();
                				var row = $("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				console.log(row);
                				var data = JSON.parse(response);
                				
                				var jo_id = $("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_] > td.JoFinishing_date_received").html(data.field_value);
                				
                                $("#JoFinishing_date_received_modal").modal("toggle");
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

