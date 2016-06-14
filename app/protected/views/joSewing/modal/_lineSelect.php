<?php //modal select for different Line scenario ?>


<!-- EDIT Line Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'viewModal',

)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Line:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<div class="topleft" style="position: absolute; font-size: 18px; top: 8px; left: 16px;">
  		
  	
  	</div>
	<div class="topright" style="position: absolute; font-size: 18px; top: 8px; right: 16px;">
		<?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => "Line <span id='line_B'>2</span>",
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

