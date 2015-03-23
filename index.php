<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
<form action="http://kaptn.altervista.org/inData.php" method="post" class="form-horizontal">
<div class="control-group">

  <label class="control-label" for="link">Link</label>
  <div class="controls">
    <input id="link" name="link" type="text" value="placeholder" class="input-large">
   </div> 
  <label class="control-label" for="title">Title</label>
  <div class="controls">
    <input id="title" name="title" type="text" value="placeholder" class="input-large">
  </div>
    <label class="control-label" for="text">Text</label>
  <div class="controls">
    <textarea id="text" name="text" type="text" > placeholder  </textarea>
  </div>
      <label class="control-label" for="date">Date</label>
  <div class="controls">
    <input id="date" name="date" type="text" value="<?php echo  date('Ymd') ; ?>"  class="input-large">
  </div>
        <label class="control-label" for="time">Date</label>
  <div class="controls">
    <input id="time" name="time" type="text" value="<?php echo  date('His') ; ?>"  class="input-large">
  </div>
      <label class="control-label" for="btnSend"></label>
  <div class="controls">
    <button id="btnSend" name="btnSend" class="btn btn-default">Send!</button>
  </div>
</div>


 </form>
 
 
</body>
</html>