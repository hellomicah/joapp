<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- EDIT Comments Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'JoFinishing_comments_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Enter Comment:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'JoFinishing_comments_form',
		'type' => 'horizontal',
		'action'=> array('joFinishing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoFinishing[jo_id]" id="JoFinishing_jo_id" value="" />
		<?php echo $form->textAreaGroup(
			$model,
			'comments',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5),
				)
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
                	'data' => "js:{name: 'comments',value: $('#JoFinishing_comments').val(), pk: $('#JoFinishing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoFinishing_jo_id").val();
                				var row = $("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				console.log(row);
                				var data = JSON.parse(response);
                				
                				var jo_id = $("div#gridview-val-finishing > table > tbody > tr[id^="+jo_id+"_] > td.JoFinishing_comments").html(data.field_value);
                				//console.log(response);
                                $("#JoFinishing_comments_modal").modal("toggle");
                       
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
