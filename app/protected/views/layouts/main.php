<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	 
    <!--script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

	<script src="http://code.jquery.com/ui/1.8.24/jquery-ui.min.js"></script-->

	<!-- (Start) Add jQuery UI Touch Punch -->
	<!--script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-touch-punch-master/jquery.ui.touch-punch.min.js"></script-->
  
  	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<style>
.errorMessage {
    color: #F00;
    font-size: 0.9em;
}
</style>
<body>

<div class="container" id="page" data-role="page" >

	<?php 	
	
		if(Yii::app()->user->isGlobalViewer){
			$index_view = "/edit";
		}
		else{
			$index_view = "";
		}
	 ?>

	<div id="mainmenu">
		<?php echo CHtml::openTag('div', array('class' => 'bs-navbar-top-example'));
$this->widget(
    'booster.widgets.TbNavbar',
    array(
        'brand' => CHtml::encode(Yii::app()->name),
        'brandOptions' => array('style' => 'width:auto;margin-left: 0px;'),
        'fixed' => 'top',
        'fluid' => true,
        'htmlOptions' => array('style' => 'position:absolute'),
        'items' => array(
            array(
                'class' => 'booster.widgets.TbMenu',
            	'type' => 'navbar',
                'items' => array(
                    array('label' => 'Home', 'url' => '#','icon'=>'home'),
                    array('label' => 'JO Manager', 'url' => array('/jo'.$index_view),'icon'=>'th-list', 'visible'=>!Yii::app()->user->isGuest),
                    array('label' => 'Users', 'url' => array('/admin/admin'),'icon'=>'user', 'visible'=> Yii::app()->user->isProductionHead || Yii::app()->user->isSuperAdmin),
                    array('label' => 'Lines', 'url' => array('/joLine/admin'),'icon'=>'list-alt', 'visible'=> Yii::app()->user->isProductionHead || Yii::app()->user->isSuperAdmin),
                    array('label' => 'Form Editor', 'url' => array('/formDropdown/index'),'icon'=>'pencil', 'visible'=> Yii::app()->user->isProductionHead || Yii::app()->user->isSuperAdmin),
                    array('label' => 'Calendar', 'url' => array('/calendar/index'),'icon'=>'calendar', 'visible'=> Yii::app()->user->isProductionHead || Yii::app()->user->isSuperAdmin),
                    array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/admin/logout'), 'visible'=>!Yii::app()->user->isGuest,'icon'=>'log-out')
                )
            )
        )
    )
);
echo CHtml::closeTag('div'); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>


</div><!-- page -->
<script type="text/javascript">
	
	$(document).ready(function() {
		//alert("hi");
		$("body").removeClass( "modal-open" );
	});

</script>
</body>
</html>
