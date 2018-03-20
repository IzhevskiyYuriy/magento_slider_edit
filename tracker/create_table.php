<?php
define('DOCROOT', substr(str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__), 0, -1));

require_once (DOCROOT. '/db_connect/connect.php');
try {
    $pdo->query("use ronis_tracker");
    $createTableIfNotExists = "CREATE TABLE IF NOT EXISTS `ronis_track` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name_cookie` varchar(255) DEFAULT NULL ,
		`brawser_name` varchar(255) DEFAULT NULL ,
		`brawser_version` int(11) DEFAULT NULL,
		`platform` varchar(255) DEFAULT NULL ,
		`status_active` SMALLINT(6) NOT NULL DEFAULT '0'
		) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8;";

    $createTableIfNotExistsAction = "CREATE TABLE IF NOT EXISTS `action`(
        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `ronis_track_id` int(11) NOT NULL,
        `link` varchar(255) DEFAULT NULL 
    )ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8;";

    $foreignKey = "ALTER TABLE `action` ADD FOREIGN KEY (`ronis_track_id`) REFERENCES `ronis_track`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
    $sql1 = trim($createTableIfNotExists);
    $sql2 = trim($createTableIfNotExistsAction);
    $sql3 = trim($foreignKey);
    $pdo->exec($sql1);
    $pdo->exec($sql2);
    $pdo->exec($sql3);

} catch(PDOException $e) {
    echo $e->getMessage();
}
/**
 *
 * CREATE TABLE `ronis_tracker`.`action` ( `id` INT NOT NULL AUTO_INCREMENT , `ronis_track_id` INT NOT NULL , `link` VARCHAR NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
 */

/**
 *
 * ALTER TABLE `action` ADD FOREIGN KEY (`ronis_track_id`) REFERENCES `ronis_track`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 */