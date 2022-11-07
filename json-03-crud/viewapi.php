<html>
<head>
</head>
<body>
<p>Howdy - Lets get a JSON list</p>
<p id="list"></p>
<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
$(document).ready( function () {
  $.getJSON('getjson.php', function(data) {
      for (var i = 0; i < data.length; i++) { 
         $('#list').append(
         '<div>' +data[i].title+'</div>'
         );
         window.console && console.log(data[i].title);
      }
    })
  }
);
</script>
</body>
