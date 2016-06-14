<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>

<!-- Star - Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'add_new_jo_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Add New JO:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'add_new_jo_form',
		'type' => 'horizontal',
		'action'=> array('jo/addNew/'),
		'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
        	'onsubmit'=>"return false;",/* Disable normal form submit */
            //'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user press*/
		
		),
	
		
    'focus'=>array($model,'jo'),

	)
	); ?>


		<p class="help-block">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldGroup($model,'priority',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
		<?php echo $form->textFieldGroup($model,'jo',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>60)))); ?>

		<?php echo $form->select2Group($model,'brand',
							array(
								'widgetOptions'=>array(
									'data'=> $options['Brand'], 
									'options'=>array(
										'placeholder'=>'Select Brand'
										
									),
									'htmlOptions'=>array(
										'class'=>'input-large'
									)
								),	
								
							)
		); ?>
		<?php echo $form->textFieldGroup($model,'quantity',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

		<?php echo $form->select2Group($model,'category', 
							array(
								'widgetOptions'=>array(
									'data'=> $options['Category'], 
									'options'=>array(
										'placeholder'=>'Select Category'
										
									),
									'htmlOptions'=>array(
										'class'=>'input-large'
									)
								),	
								
							)
		); ?>

		<?php echo $form->textFieldGroup($model,'color',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>60)))); ?>

		<?php echo $form->datePickerGroup($model,'date_received_modal',array('widgetOptions'=>array('options'=>array('format' => 'yyyy-mm-dd',
				'viewformat' => 'MMM/dd/yy','encodeLabel'=>false,
						'autoclose'=> 'true'),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'')); ?>

		<?php echo $form->textFieldGroup($model,'days_needed',
						array(
							'widgetOptions'=>array(
								'options'=>array(
									'placeholder'=>'0'
									
								),
								'htmlOptions'=>array(
									'class'=>'span5',
									'maxlength'=>60,
									'readonly'=>'readonly'
								)
							),
							'readonly'=>'readonly'
						)); ?>

		<?php echo $form->textFieldGroup($model,'days_allotted',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>6)))); ?>

		<?php echo $form->textFieldGroup($model,'allowance',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>6,'readonly'=>'readonly')))); ?>

		<?php echo $form->datePickerGroup($model,'target_end_date',array('widgetOptions'=>array('options'=>array('format' => 'yyyy-mm-dd',
				'viewformat' => 'MMM/dd/yy',
						'autoclose'=> 'true'),'htmlOptions'=>array('class'=>'span5','readonly'=>'readonly')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'')); ?>

		<?php echo $form->datePickerGroup($model,'delivery_date_modal',array('widgetOptions'=>array('options'=>array('format' => 'yyyy-mm-dd',
				'viewformat' => 'MMM/dd/yy','encodeLabel'=>false,
						'autoclose'=> true,),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'')); ?>

		<?php echo $form->select2Group($model,'line',
							array(
								'widgetOptions'=>array(
									'data'=> $lines, 
									'options'=>array(
										'placeholder'=>'Select Line'
										
									),
									'htmlOptions'=>array(
										'class'=>'input-large'
									)
								)
							)
		); ?>

		<?php echo $form->select2Group($model,'status', 
							array(
								'widgetOptions'=>array(
									'data'=> $options['Status'], 
									'options'=>array(
										'placeholder'=>'For Loading'
										
									),
									'htmlOptions'=>array(
										'class'=>'input-large'
									)
								)
							)
		); ?>

		<?php echo $form->textFieldGroup($model,'output',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

		<?php echo $form->textFieldGroup($model,'balance',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','readonly'=>'readonly')))); ?>

		<?php echo $form->textAreaGroup($model,'comments', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

		<?php echo $form->select2Group($model,'washing_info', 
							array(
								'widgetOptions'=>array(
									'data'=> $options['Washing_Info'], 
									'options'=>array(
										'placeholder'=>'Select Washing Info'
										
									),
									'htmlOptions'=>array(
										'class'=>'input-large'
									)
								),	
								
							)
		); ?>

		<div class="form-actions">
		
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'context'=>'primary',
			'label'=>'Submit',
			'url' => Yii::app()->createUrl(
                    'jo/addNew'
            ),
            //'htmlOptions'=>array('data-dismiss'=>'modal'),
            'ajaxOptions' => array(
                'type' => 'POST',
                'success'=>'function(data) {
                	console.log(data);
                	//remove loading GIF
                	$("#loading_div").remove();
                    
                    if(data.result){
                         
                        //close modal 
                        $("#add_new_jo_modal").modal("hide");
                        $("#gridview-val").yiiGridView("update");
                        
                  		return true;
                    }
                    else{
                    	data=JSON.parse(data);
                    	
                    	var ctr = 0;
                    	var first_err = null;
                    	
                    	$(".error").removeClass("error");
                    	$("[id$=_error]").children().remove();
                    	
                    	
                        $.each(data, function(key, val) {
                        	//console.log(key+" "+val);
                        	var error_dif ="<div id=\""+key+"_error\"><span style=\"color:red;\">"+val+"</span></div>";
                        	$(error_dif).insertAfter("#"+key);
                        	$("#"+key).addClass( "error" );
                        	
                        	if(ctr==0){
                        		first_err="#"+key;
                        	}
                        });
                        
                       //scroll top top of modal when has errors
                        $("#add_new_jo_modal").animate({ scrollTop: $(first_err).offset().top }, "slow");
                        	
                    }       
                }', 
                    'beforeSend'=>'function(){                        
                           //$("#AjaxLoader").show();
                           var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    		$("body").append(div_val);
                    }'

            )
		)); ?>
		</div>

		<?php
		$this->endWidget();
		unset($form); ?>
	</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->
