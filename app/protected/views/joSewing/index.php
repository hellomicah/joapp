<div style="margin-top:60px;">

	<!--Labels-->
	<div>
		<?php
			$box = $this->beginWidget(
    			'booster.widgets.TbPanel',
    			array(
        			'title' => 'Settings',
        			'headerIcon' => 'cog',
        			'padContent' => false,
        			'headerButtons' => array(
           				 
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Show Done Jo's",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Add New JO",
            				'context' => 'primary',
            				'icon'=>'plus',
            				'size'=>'small',
            				
            				'htmlOptions'=> array(
            					
                    			'data-toggle' => 'modal',
                    			'data-target' => '#add_new_jo_modal',  
                    			'onclick' => 'js:(function(){
                    			
                    				//START --- Custom Reset Codes for Add New Form Modal
                    				
                					//remove error 	red outline to input boxes
                          			$("#add_new_jo_form").children().removeClass("error");
                    				$(".error").removeClass("error");
                    				
                    				//remove error message
                    				$("[id$=_error]").children().remove();
                    				
                    				//reset form values
                    				document.getElementById("add_new_jo_form").reset();
                    				
                    				//custom reset fo SELECT2 element (bootstrap)
                    				$("select").select2("val", "");
                    				
                    				//END --- Custom Reset Codes for Add New Form Modal
                    				
            					 })();'
            				),
        					
						),
						/*
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				'context' => 'link',
            				'size'=>'small',
        					
						),*/
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Toggle Edit Mode",
            				//'context' => 'link',
            				'icon'=>'resize-vertical',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => " ",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Save Changes",
            				'context' => 'primary',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				//'context' => 'info',
            				'icon'=>'refresh',
            				'size'=>'default',
            				'id'=>'refresh-button'
        					
						),
						
						//<button id="refresh-button">Refresh!</button>
						
						
        			),
        			//'content'=>
        			//'Start Date: '.$startDate.'<br/>Average Output: '.$avgOutput
        			'htmlOptions' => array('class' => 'bootstrap-widget-table')
    			)
			);
		?>
		
		<table class="table">
        	<thead>
			
        	</thead>
        	<tbody>

        		<tr class="even">
            		
            		<td>Start Date: <?php echo $startDate; ?></td>
            		<td>Average Output: <?php echo $avgOutput; ?></td>
        		</tr>

        	</tbody>
    	</table>
    <?php $this->endWidget(); ?>
	</div>
	
	<!--Gridview Tabs-->
	<div>
		<?php

    		$this->widget(
        		'booster.widgets.TbTabs',
        		array(
            		'type' => 'tabs', // 'tabs' or 'pills'
            		'justified' => true,
            		'tabs' => array(
            		
                				array(
                    				'label' => 'Sewing',
                    				'content' =>  $this->renderPartial('_sewing', array(
                    					'model'=>$model,
										'dataProvider'=>$dataProvider,
                    				), true),
                    				'active' => true
                				),
                				
                				array(
                    				'label' => 'Finishing',
                    				'content' =>  //'test'
                    					$this->renderPartial('_finishing', array(
                    					 		'model'=>$model,
										 		'dataProvider'=>$dataProvider,
                    						), true
                    					),
                    				'active' => false
                				),
               
            		),
        			'htmlOptions'=>array(
						//'live'=>false,
    				//'id' => uniqid()
					),
        		)
    		);
    
    	?>
    
    </div>
    
</div>
<?php Yii::app()->clientScript->registerScript('initRefresh',<<<JS
    $('#refresh-button').on('click',function(e) {
        e.preventDefault();
        $('#gridview-val').yiiGridView('update');
    });
JS
,CClientScript::POS_READY); ?>