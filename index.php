<html>
 <style>
   @import url(style.css);
  </style>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62594538-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
      $(document).ready(function (){
        var link = "http://api.tumblr.com/v2/blog/glitchgifs.tumblr.com/posts?";
		//var link = "http://api.tumblr.com/v2/blog/mapsdesign.tumblr.com/posts?";
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
<div class="container">
<div id="header" class="header"><a href="index.php" class="kaptn">kaptn</a></div>
<?php include 'getData.php'; ?>
<div id="buttons"><?php include 'prev.php'; include 'next.php';?></div>
</div>

</body>
</html>