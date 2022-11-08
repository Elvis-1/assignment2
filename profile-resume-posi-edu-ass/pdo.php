<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



// CREATE TABLE Institution (
//     institution_id INTEGER NOT NULL KEY AUTO_INCREMENT,
//     name VARCHAR(255),
//     UNIQUE(name)
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
//   CREATE TABLE Education (
//     profile_id INTEGER,
//     institution_id INTEGER,
//     rank INTEGER,
//     year INTEGER,
//     CONSTRAINT education_ibfk_1
//       FOREIGN KEY (profile_id)
//       REFERENCES Profile (profile_id)
//       ON DELETE CASCADE ON UPDATE CASCADE,
//     CONSTRAINT education_ibfk_2
//       FOREIGN KEY (institution_id)
//       REFERENCES Institution (institution_id)
//       ON DELETE CASCADE ON UPDATE CASCADE,
//     PRIMARY KEY(profile_id, institution_id)
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

