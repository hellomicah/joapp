<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/jo_module/main.css');


?>
<input type="hidden" value ="<?php echo Yii::app()->session['access_role'];?>" id="access" />
<style>.datepicker{z-index:1200 !important;}</style>

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
           				 
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Show Done Jo's",
            				'context' => 'link',
            				'buttonType' => 'link',
        					'url' => Yii::app()->baseUrl.'/jo/done',
            				'size'=>'small',
            				'visible'=>	Yii::app()->user->isGlobalViewer,
            				'htmlOptions'=> array(
            					'onclick' => 'js:(function(){
                    				 	var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    					$("body").append(div_val);
                    				
            					 })();'
            				),
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Save Changes",
            				'context' => 'primary',
            				'size'=>'small',
            				'visible'=>	!Yii::app()->user->isGlobalViewer,
            				'htmlOptions'=> array(
            					'onclick' => 'js:(function(){
                    				 	
									console.log("saving...");
									//document.getElementById("load_fired").value ="Yes"
									var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
									$("body").append(div_val);
									
										$.ajax({
											url: location.origin+"/jo_manager_live/jo/saveTempData",
											type: "POST",
											data: {control : "save"},
											dataType:"json",
											success: function(data){
												//window.location=location.origin+"/jo_manager_live/jo";
												
												bootbox.alert("Successfully saved changes!", function() {
													window.location=location.origin+"/jo_manager_live/jo";
												});
											}
										});
			
            					 })();'
            				),
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => " ",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Cancel",
            				//'context' => 'info',
            				'icon'=>'arrow-left',
            				'size'=>'small',
            				'id'=>'cancel_edit-button',
            				'visible'=>	!Yii::app()->user->isGlobalViewer,
            				'htmlOptions'=> array(
            					
            				),
        					
						),
						
						//<button id="refresh-button">Refresh!</button>
						
						
        			),
        			//'content'=>
        			//'Start Date: '.$startDate.'<br/>Average Output: '.$avgOutput
        			'htmlOptions' => array('class' => 'bootstrap-widget-table')
    			)
			);
		?>
		
		<table class="table" style="display:none;">
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
                    				'visible'=>!Yii::app()->user->isFinishingController,
                    				
                    				'content' =>  $this->renderPartial('application.views.jo.sewing._edit', array(
                    					'model'=>$model,
										'dataProvider'=>$dataProvider,
            							'options' => $options,
            							'lines' => $lines
                    				), true),
                    				'active' => !Yii::app()->user->isFinishingController,
                    				'htmlOptions'=>array(
										'id' => 'Sewing_tab',
									),
                				),
                				
                				array(
                    				'label' => 'Finishing',
                    				'visible'=>!Yii::app()->user->isSewingController,
                    				'content' =>  //'test'
                    					$this->renderPartial('../jo/finishing/_edit', array(
                    					 		'model'=>$model2,
										 		'dataProvider'=>$dataProvider2,
            									'options' => $options,
            									'lines' => $lines
                    						), true
                    					),
                    				'active' => Yii::app()->user->isFinishingController,
                    				'htmlOptions'=>array(
										'id' => 'Finishing_tab',
									),
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
<!-- EDIT Line Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._lineSelect'); ?>

<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>
<!-- EDIT Delivery Date Popup  -->
<?php //$this->renderPartial('application.views.jo.sewing.modal._addNewJo',array('model'=>$model,'options'=>$options,'lines'=>$lines)); ?>

<script>
//window.onbeforeunload = confirmExit;
$(document).ready(function() {
$('.pagination a').click(function(event){
	var page_url = $(this).attr("href");
	confirmExit(event,page_url);
});
$('#cancel_edit-button').click(function(event){
	var page_url=location.origin+"/jo_manager_live/jo";
	confirmExit(event,page_url);
});

  function confirmExit(event,page_url)
  {
    //return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.";
  	var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
		$("body").append(div_val);
		
  	var access_role = document.getElementById("access").value;
  	if(access_role!="Global Viewer"){
		event.preventDefault();
  
	
		bootbox.confirm("You have attempted to leave this page.  Unsaved changes will be lost. Are you sure you want to continue?", function(result) {
			 //console.log(result);
			 if(result){
				//document.getElementById("load_fired").value="Yes";
				$.ajax({
					url: location.origin+"/jo_manager_live/jo/deleteTempJos",
					type: "POST",
					data: {control : "cancel"},
					dataType:"json",
					success: function(data){
						//if(lead!=='undefined'){
							//window.location=location.origin+"/"+lead;
						//}
						//window.location=location.origin+"/jo_manager_live/jo";
					
						window.location=page_url;
					}
				});
			 }else{
		 
				var oP = document.getElementById("loading_div");
				document.body.removeChild(oP);
			 }
		}); 
	}else{
	
	}
	
  }
  });
  </script>
  
  