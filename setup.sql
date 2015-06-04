CREATE DATABASE rb00166;
USE rb00166;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `firstname` varchar(65) NOT NULL DEFAULT '',
  `lastname` varchar(65) NOT NULL DEFAULT '',
  `email` varchar(65) NOT NULL DEFAULT '',
  `twitter` varchar(20) DEFAULT '',
  `facebook` varchar(20) DEFAULT '',
  `skype` varchar(20) DEFAULT '',
  `account` varchar(9) NOT NULL DEFAULT 'user',
  `hash` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL DEFAULT '',
  `description` varchar(5000) NOT NULL DEFAULT '',
  `developerID` int(10) NOT NULL,
  `releaseDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `download` varchar(500) NOT NULL DEFAULT '',
  `icon` varchar(500) NOT NULL DEFAULT '',
  `platform` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `developerID` (`developerID`),
  CONSTRAINT `developedBy` FOREIGN KEY (`developerID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `applications` (`id`, `name`, `description`, `developerID`, `releaseDate`, `download`, `icon`, `platform`)
VALUES
	(1,'Dotz','A dots and boxes game for android.',15,'2012-05-09 17:42:48','http://ryanburke.co.uk/work/dotz.zip','images/1/dotz.png','Windows'),
	(2,'Angry Chickens','Use the unique powers of the Angry Chickens to destroy the greedy cows\' castle! The lives of the Angry Chickens are at stake. Dish out revenge on the greedy cows who stole their eggs. Use the strange powers of each chicken to destroy the cows fortresses. Angry Chickens features challenging physics-based gameplay and minutes of replay value. Each of the over 9000 levels requires logic, skill, and force to solve.',3,'2012-05-04 13:57:51','http://ryanburke.co.uk/work/angrychickens.zip','images/2/chicken.jpg','Android'),
	(3,'Drawing Game','Draw something fun and let your friends guess it!',9,'2012-05-04 13:57:54','http://ryanburke.co.uk/work/drawing.zip','images/3/icon.png','iOS'),
	(4,'openIPSW','Download iOS firmware direct from Apple servers.',15,'2012-05-09 17:42:48','http://ryanburke.co.uk/work/openipsw.zip','images/4/openipsw.jpg','Windows'),
	(5,'FaceNovel','A place to socialise with your fellow book lovers!',4,'2012-05-04 13:58:05','http://ryanburke.co.uk/work/facenovel.zip','images/5/facenovel.png','Windows'),
	(6,'Kindol','Read books whereever you need them to be.',4,'2012-05-09 18:35:59','http://ryanburke.co.uk/work/kindol.zip','images/6/IMG_2574.JPG','Mac');

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `applicationID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `review` varchar(21000) NOT NULL DEFAULT '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE reviews SYSTEM "xml/rules.dtd"><reviews></reviews>',
  PRIMARY KEY (`applicationID`),
  CONSTRAINT `reviewOf` FOREIGN KEY (`applicationID`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reviews` (`applicationID`, `review`)
VALUES
	(1,'<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE reviews SYSTEM "xml/rules.dtd"><reviews></reviews>'),
	(2,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE reviews SYSTEM \"xml/rules.dtd\">\n<reviews><review><username>ryan</username><rating>1</rating><comment>AWESOME!</comment></review><review><username>lucie</username><rating>1</rating><comment>VERY GOOD!!!</comment></review><review><username>harrypotter</username><rating>5</rating><comment>Really good game, enjoyed it!</comment></review><review><username>JBean</username><rating>1</rating><comment>This had me entertained loads over the weekend when i was meant to be doing my coursework!!!</comment></review><review><username>irluxor</username><rating>1</rating><comment>dfdfasd</comment></review></reviews>\n'),
	(3,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE reviews SYSTEM \"xml/rules.dtd\">\n<reviews><review><username>ryan</username><rating>3</rating><comment>dfsdfsdfsd</comment></review></reviews>\n'),
	(4,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE reviews SYSTEM \"xml/rules.dtd\">\n<reviews><review><username>ryan</username><rating>5</rating><comment>good utility for my computer</comment></review><review><username>irluxor</username><rating>1</rating><comment>&lt;a href=\"http://google.com\"&gt;Click me!&lt;/a&gt;</comment></review></reviews>\n'),
	(5,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE reviews SYSTEM \"xml/rules.dtd\">\n<reviews><review><username>ryan</username><rating>5</rating><comment>great app, would recommend it to anyone!</comment></review></reviews>\n'),
	(6,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE reviews SYSTEM \"xml/rules.dtd\">\n<reviews><review><username>ryan</username><rating>1</rating><comment>AWESOME!</comment></review></reviews>\n');