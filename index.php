<html>
 <style>
   @import url(style.css);
  </style>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
      $(document).ready(function (){
        var link = "http://api.tumblr.com/v2/blog/glitchgifs.tumblr.com/posts?";
        $.ajax({
          type: "GET",
          url : link,
          dataType: "jsonp", 
          data: {
              api_key: "fuiKNFp9vQFvjLNvx4sUwti4Yb5yGutBN4Xh10LXZhhRKjWlV4"
          }
        }).done(function( data ) {
          $.each(data.response.posts, function(){
            var _photos = this.photos;
            $.each(_photos, function(){
              $('#header').css("background-image", "url(" + this.original_size.url + ")");
              return false;
            });
            return false;
          });
        });
      });
</script>
</head>
<body>
<div id="container">
<div id="header" class="header">kaptn</div>
<?php include 'getData.php'; ?>
</div>
<div class="buttons"><?php include 'prev.php'; include 'next.php';?></div>
</body>
</html>