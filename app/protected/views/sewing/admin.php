<?php
    $str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
 
        $('#project-grid table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#project-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
                $.ajax({
                    'url': '" . $this->createUrl('/sewing/sort') . "',
                    'type': 'post',
                    'data': serial,
                    'success': function(data){
                    },
                    'error': function(request, status, error){
                        alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";
 
    Yii::app()->clientScript->registerScript('sortable-project', $str_js);
?>
  <div data-role="main" class="ui-content">
  
	<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sewing-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'rowCssClassExpression'=>'"items[]_{$data->jo_id}"',
    'columns'=>array(
        'jo_id',
        'priority',
        'jo',
        'sortOrder',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
	'htmlOptions'=>array(
	'data-role'=>'table',
	)
	)); ?>
  
  </div

<!-- data-role="page" id="pageone">
  <div data-role="header">
    <h1>JO Manager</h1>
  </div>

  <div data-role="content" data-theme="c" class="ui-content">
	<ul data-role="listview" data-inset="true" data-theme="d" id="sortable">
      <li data-role="list-divider">List</li>
      <li>Item 1</li>
      <li>Item 2</li>
      <li>Item 3</li>
      <li>Item 4</li>
      <li>Item 5</li>
    </ul>

</div>
</div-->
