<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/jo_module/main.css');

?>
<script src="<?php
echo Yii::app()->request->baseUrl;
?>/js/jquery.ui.touch-punch.min.js"></script>
<div style="margin-top:60px;">

	<!--Labels-->
	<div>
		<?php
			$box = $this->beginWidget(
    			'booster.widgets.TbPanel',
    			array(
        			'title' => 'Menu',
        			'headerIcon' => 'cog',
        			'padContent' => false,
        			'headerButtons' => array(
           				 
            		
						/*array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				//'context' => 'info',
            				'icon'=>'refresh',
            				'size'=>'default',
            				'id'=>'refresh-button'
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				'context' => 'link',
            				'size'=>'small',
        					
						), */
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Back",
        					'buttonType' =>'link',
        					'url' => Yii::app()->baseUrl.'/jo',
            				'icon'=>'arrow-left',
            				'size'=>'small',
            				'htmlOptions'=> array(
            					'onclick' => 'js:(function(){
                    				 	var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    					$("body").append(div_val);
                    				
            					 })();'
            				),
        					
						),
        			),
        			//'content'=>
        			//'Start Date: '.$startDate.'<br/>Average Output: '.$avgOutput
        			'htmlOptions' => array('class' => 'bootstrap-widget-table')
    			)
			);
		?>
		
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
                    				'visible'=>!Yii::app()->user->isFinishingController,
                    				
                    				'content' =>  $this->renderPartial('application.views.jo.sewing._done', array(
                    					'model'=>$model,
										'dataProvider'=>$dataProvider
                    				), true),
                    				'active' => !Yii::app()->user->isFinishingController
                				),
                				
                				array(
                    				'label' => 'Finishing',
                    				'visible'=>!Yii::app()->user->isSewingController,
                    				'content' =>  //'test'
                    					$this->renderPartial('../jo/finishing/_done', array(
                    					 		'model'=>$model2,
										 		'dataProvider'=>$dataProvider2
                    						), true
                    					),
                    				'active' => Yii::app()->user->isFinishingController
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
