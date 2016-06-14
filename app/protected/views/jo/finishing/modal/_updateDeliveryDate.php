<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- EDIT Delivery Date Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'JoFinishing_date_delivery_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Delivery Date:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'JoFinishing_dateForm',
		'type' => 'horizontal',
		'action'=> array('joFinishing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoFinishing[jo_id]" id="JoFinishing_jo_id" value="" />
		<?php echo $form->datePickerGroup(
			$model,
			'delivery_date',
			
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
                	'data' => "js:{name: 'delivery_date',value: $('#JoFinishing_delivery_date').val(), pk: $('#JoFinishing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoFinishing_jo_id").val();
                				var row = $("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				var jo_id = $("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_] > td.JoFinishing_delivery_date").html(data.field_value);
                				//console.log(response);
                                $("#JoFinishing_date_delivery_modal").modal("toggle");
                       
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
