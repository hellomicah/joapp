<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>


<!-- EDIT Line Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'line_select',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Line:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<div class="topleft" style="position: absolute; font-size: 18px; top: 8px; left: 16px;">
  		<?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => "Line <span id='line_A' data-line='' ></span>",
                'encodeLabel'=>false,
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal','id'=>'option_1'),
            )
        ); ?>
  	
  	</div>
	<div class="topright" style="position: absolute; font-size: 18px; top: 8px; right: 16px;">
		<?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => "Line <span id='line_B' data-line='' ></span>",
                'encodeLabel'=>false,
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal','id'=>'option_2'),
            )
        ); ?>
	</div>


</div>
<!-- Popup Footer -->
<div class="modal-footer">

<!-- close button -->

<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>

