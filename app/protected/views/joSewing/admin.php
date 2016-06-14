<?php $this->layout=false;?>
<!DOCTYPE html> 
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>Example</title> 
  
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0-alpha.2/jquery.mobile-1.4.0-alpha.2.min.css" />
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.0-alpha.2/jquery.mobile-1.4.0-alpha.2.min.js"></script>
  
  <!-- (Start) Add the features of jQuery UI sortable -->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.touch-punch.min.js"></script>
  <script>
  $(document).bind('pageinit', function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    <!-- Refresh list to the end of sort to have a correct display -->
    $( "#sortable" ).bind( "sortstop", function(event, ui) {
      $('#sortable').listview('refresh');
    });
  });
  </script>
</head>
<body> 
<div>
  <div data-role="header" data-theme="d">
    <h1>JO Manager</h1>
  </div>

  <div data-role="content" data-theme="c">
    
  
  <div data-role="main" class="ui-content">
    <table>
      <thead>
        <tr> 
          <th>Priority</th>
          <th>Date Added</th>
          <th>JO</th>
          <th>Brand</th>
          <th>Qty</th>
          <th>Category</th>
          <th>Color</th>
        </tr>
      </thead>
      <tbody id="sortable">
        <tr>
          <td>1</td>
          <td>18-Nov</td>
          <td>1234</td>
          <td>Penshoppe</td>
          <td>3500</td>
          <td>Wovens</td>
          <td>Blue</td>
        </tr>
        <tr>
          <td>2</td>
          <td>18-Nov</td>
          <td>1235</td>
          <td>Penshoppe</td>
          <td>1500</td>
          <td>Wovens</td>
          <td>Red</td>

        </tr>
        <tr>
          <td>3</td>
          <td>18-Nov</td>
          <td>1236</td>
          <td>Memo</td>
          <td>900</td>
          <td>Wovens</td>
          <td>Yellow</td>

        </tr>
        <tr>
          <td>4</td>
          <td>18-Nov</td>
          <td>1237</td>
          <td>SM</td>
          <td>300</td>
          <td>Knits</td>
          <td>Pink</td>

        </tr>
      </tbody>
    </table>
  </div>



  </div>
</div>
</body>
</html>