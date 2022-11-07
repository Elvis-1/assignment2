<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// '<div id="position'+countPos+'">\
//   <p>Year: <input type="text" name="year'+ countPos'" value=""/>\
//   <input type="button" value="-"\ onclick="$(\'#position'+countPos+'\').remove();return false;"></p>\
//   <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
// </div>'

// '<div id="position'+countPos+'>\
//   <p>Year: <input type="text" name="year'+ countPos + ' value=""/>\
//   <input type="button" value="-" onclick="$(\'#position'+countPos+'\').remove();return false;"></p>'+
//   '<textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
// </div>'