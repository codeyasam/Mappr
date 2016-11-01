DROP DATABASE IF EXISTS maps_db;
CREATE DATABASE IF NOT EXISTS maps_db;

USE maps_db;

CREATE TABLE `markers` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `name` VARCHAR( 60 ) NOT NULL ,
  `address` VARCHAR( 80 ) NOT NULL ,
  `lat` FLOAT( 10, 6 ) NOT NULL ,
  `lng` FLOAT( 10, 6 ) NOT NULL
);

INSERT INTO `markers` (`name`, `address`, `lat`, `lng`) VALUES ('Frankie Johnnie & Luigo Too','939 W El Camino Real, Mountain View, CA','37.386339','-122.085823');
INSERT INTO `markers` (`name`, `address`, `lat`, `lng`) VALUES ('Amici\'s East Coast Pizzeria','790 Castro St, Mountain View, CA','37.38714','-122.083235');
INSERT INTO `markers` (`name`, `address`, `lat`, `lng`) VALUES ('Kapp\'s Pizza Bar & Grill','191 Castro St, Mountain View, CA','37.393885','-122.078916');
INSERT INTO `markers` (`name`, `address`, `lat`, `lng`) VALUES ('Round Table Pizza: Mountain View','570 N Shoreline Blvd, Mountain View, CA','37.402653','-122.079354');
INSERT INTO `markers` (`name`, `address`, `lat`, `lng`) VALUES ('Tony & Alba\'s Pizza & Pasta','619 Escuela Ave, Mountain View, CA','37.394011','-122.095528');
INSERT INTO `markers` (`name`, `address`, `lat`, `lng`) VALUES ('Oregano\'s Wood-Fired Pizza','4546 El Camino Real, Los Altos, CA','37.401724','-122.114646');






#Haversine Formula - Closest Locations within 20 locations that are within a radius of 25 miles to the 37, -122 coordinate. It calculates the distance based on the latitude/longitude of that row and the target latitude/longitude, and then asks for only rows where the distance value is less than 25, orders the whole query by distance, and limits it to 20 results. To search by kilometers instead of miles, replace 3959 with 6371. 
#SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;