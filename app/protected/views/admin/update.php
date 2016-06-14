<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this AdminController */
/* @var $model Admin */

/*$this->breadcrumbs=array(
	'Admins'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);*/

$this->menu=array(
	//array('label'=>'List Admin', 'url'=>array('index')),
	array('label'=>'Add User', 'url'=>array('create')),
	//array('label'=>'View User', 'url'=>array('view', 'id'=>$model->user_id)),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Update <?php echo $model->username; ?></h1>
<script>
function showPassword(event){
		
			var $this = $(this);
			$this.unbind('click');
		
			if(event.handled !== true)
			{
				if($("#password-div").css("display") == 'none'){
					$("#password-div").show();
					event.handled = true;
				}else{
					$("#password-div").hide();
					event.handled = true;
				}
				event.handled = false;
			}	
			return false;
			
		}	
</script>
<?php $this->renderPartial('_form_update', array('model'=>$model,'style' => $style,
'single_div_display' => $single_div_display,
'div_display' => $div_display,
	'line_list_data' => $line_list_data,
	'selected_line_data'=>$selected_line_data
)); ?>