<?php //modal form update for Comments field ?>

<!-- EDIT Comments Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'comments_modal',
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
		'id' => 'comments_form',
		'type' => 'horizontal',
		'action'=> array('joSewing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoSewing[jo_id]" id="JoSewing_jo_id" value="" />
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
				'url' => $this->createURL('joSewing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('joSewing/edit'),
                	'data' => "js:{name: 'comments',value: $('#JoSewing_comments').val(), pk: $('#JoSewing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoSewing_jo_id").val();
                				var row = $("tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				var jo_id = $("#"+row+"").children("td#comments").html(data.field_value);
                				//console.log(response);
                                $("#comments_modal").modal("toggle");
                       
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
