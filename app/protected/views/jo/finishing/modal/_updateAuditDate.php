<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- EDIT Delivery Date Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'audit_date_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Audit Date:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'dateForm_audit',
		'type' => 'horizontal',
		'action'=> array('/joFinishing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoFinishing[jo_id]" id="JoFinishing_jo_id" value="" />
		<?php echo $form->datePickerGroup(
			$model,
			'audit_date',
			
			array(
				'format' => 'yyyy-mm-dd',
				'viewformat' => 'M/d/y',
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
				'url' => $this->createURL('/joFinishing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('/joFinishing/edit'),
                	'data' => "js:{name: 'audit_date',value: $('#JoFinishing_audit_date').val(), pk: $('#JoFinishing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoFinishing_jo_id").val();
                				var row = $("tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				$("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_] > td.JoFinishing_audit_date").text(data.field_value);
                				
                				//close Audit Date modal
                				$("#audit_date_modal").modal("toggle");
                				
                                
                       
                	}',
                )

			)
		); ?>
		</div>

<?php
$this->endWidget();
unset($form); ?>
	</div>
<!-- Popup Footer -->
<div class="modal-footer">

<!-- close button -->

<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->
