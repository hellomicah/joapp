<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<style type="text/css">
        
		body{
			font: 14px Arial, Helvetica, sans-serif;color: #777777; background: #fff;
		}
		
        .login-form{
			margin: auto; width: 460px; padding: 10px; -webkit-box-shadow: 0px 0px 10px 5px #ddd; box-shadow: 0px 0px 10px 5px #ddd; -webkit-border-radius: 5px; border-radius: 5px; background: #fff;
		}
		.guide{
			border-bottom: solid 1px #ddd; padding: 0 10px 10px 10px; margin: 0 0 10px 0;
		}
        .buttons{
			border-top: solid 1px #ddd; padding: 20px 10px 10px 10px; margin: 30px 0 0 0;
		}
		.buttons a{
			font: 13px Arial, Helvetica, sans-serif;
			font-style:italic;
			color:rgb(153, 153, 153);
		}
		.login-btn{
			float: right;
		}
		.login-btn input[type="submit"]{
			background: -moz-linear-gradient(top, #0076ad 28%, #00394f 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(28%,#0076ad), color-stop(100%,#00394f)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top, #0076ad 28%,#00394f 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top, #0076ad 28%,#00394f 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top, #0076ad 28%,#00394f 100%); /* IE10+ */
			background: linear-gradient(to bottom, #0076ad 28%,#00394f 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0076ad', endColorstr='#00394f',GradientType=0 ); /* IE6-8 */
			border: none 0;
			-webkit-border-radius: 5px; border-radius: 5px;
			padding: 10px 20px;
			color: #fff;
			font-weight: bold;
			margin-top: -12px;
		}
		.login-btn input[type="submit"]:hover{
			background: rgb(0,84,128);
		}
		.label{
			display: inline-block; width: 80px; margin: 0 0 0 45px;
		}
		.row{
			margin-bottom: 10px;
		}
		.row input[type="text"], .row input[type="password"]{
			width: 200px; padding: 8px; -webkit-border-radius: 3px; border-radius: 3px; border: solid 1px #ddd; box-shadow: inset 0 2px 2px #eee;
		}
		.fields{
			margin: auto;width: 400px;display: block; padding: 10px 0;
		}
		.errorMessage{
			padding: 5px; color: red; font-size: .8em;
		}
		.error-field{
			background: #FFFFCC; margin: 10px auto; width: 90%;
		}
		.logo{
			width: 300px;margin: auto; margin-bottom: 20px;
		}
        </style>
			
	</head>

		<body>

	<?php
	/* @var $this SiteController */
	/* @var $model LoginForm */
	/* @var $form CActiveForm  */

	$this->pageTitle=Yii::app()->name . ' - Login';
	?>

	<div class="logo"></div>
	
	<div class="login-form">
    	
        <div class="guide">Please login with your account to continue</div>
    
        <div class="form">
        <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
            'id'=>'login-form',
            'type' => 'horizontal',
			'htmlOptions' => array('class' => 'well')
            //'enableClientValidation'=>true,
           // 'clientOptions'=>array(
               // 'validateOnSubmit'=>true,
           // ),
        )); ?>
    <?php echo $form->textFieldGroup($model,'username'); ?>
    <?php echo $form->passwordFieldGroup($model,'password'); ?>
    <?php $this->widget(
    		'booster.widgets.TbButton',
    		array('buttonType' => 'submit', 'label' => 'Login')
		);?>
<?php $this->endWidget(); ?>
        </div><!-- form -->
    
    </div>
	</body>
</html>