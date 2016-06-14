<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<script>
function displayLineListView(dropdownlist){
	if(dropdownlist.value == "Sewing Output & Status Controller" || dropdownlist.value == "Finishing Output & Status Controller"){
		document.getElementById("line-div").style.display = "block";
		document.getElementById("single-line-div").style.display = "none";
		
	}else if(dropdownlist.value == "Line Head"){
		document.getElementById("line-div").style.display = "none";
		document.getElementById("single-line-div").style.display = "block";
		
	}else{
		document.getElementById("line-div").style.display = "none";
	}
}	
</script>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'admin-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
	'htmlOptions' => array('class' => 'well')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldGroup($model,'username',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->textFieldGroup($model,'first_name',array('size'=>60,'maxlength'=>140)); ?>
		<?php echo $form->textFieldGroup($model,'last_name',array('size'=>60,'maxlength'=>140)); ?>

	<div class="pull-right">
		<a id="cancel-account-change" style="cursor: pointer; background: #fff; border: solid 1px #ccc; border-radius: 3px; font-size: .9em; padding: 5px 10px;" onclick="showPassword(this);">Change Password</a>
	</div>	
	<div id="password-div" style="<?php echo $style;?>">
			<?php echo $form->passwordFieldGroup($model,'old_password',array('size'=>60,'maxlength'=>240)); ?>
			<?php echo $form->passwordFieldGroup($model,'new_password',array('size'=>60,'maxlength'=>240)); ?>
			<?php echo $form->passwordFieldGroup($model,'confirm_new_password',array('size'=>60,'maxlength'=>240)); ?>
	</div>

	<?php echo $form->dropDownListGroup(
			$model,
			'user_role',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' =>Admin::model()->userRoles(),
					'htmlOptions' => array(
						'onChange' => 'displayLineListView(this)'
						),
				)
			)
		); ?> 
		
	<?php echo $form->dropDownListGroup(
			$model,
			'user_status',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' =>Admin::model()->userStatus(),
					'htmlOptions' => array(),
				)
			)
		); ?> 
	<div id="single-line-div" style="<?php echo $single_div_display;?>">
		<?php echo $form->dropDownListGroup(
			$model,
			'single_line',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' =>JoLine::model()->LineList("admin_single"),
				)
			)
		); ?> 
		
		</div>
	<div id="line-div" style="<?php echo $div_display;?>">
		<?php echo $form->dropDownListGroup(
			$model,
			'line_list',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => $line_list_data,
					'htmlOptions' => array(
						"multiple" => true,
					),
				)
			)
		); ?> 

		<?php
		$this->widget(
    		'booster.widgets.TbButtonGroup',
    		array(
        		'buttons' => array(
            		array('label' => 'Add to Selected Line', 'htmlOptions' => array('id'=>'move_selected')),
            		array('label' => 'Delete Selected Line', 'htmlOptions' => array('id'=>'delete_selected')),
        		),
    		)
		);
		?>
		<?php echo $form->dropDownListGroup(
			$model,
			'selected_line',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					//'data' =>JoLine::model()->LineList("admin"),
					'data' => $selected_line_data,
					'htmlOptions' => array(
						"multiple" => true,
					),
				)
			)
		); ?> 
		
		</div>

	<?php $this->widget(
    		'booster.widgets.TbButton',
    		array('buttonType' => 'submit', 'label' => 'Update')
		);?>

<?php $this->endWidget(); ?>

</div><!-- form -->