<?php
define('DOCROOT', substr(str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__), 0, -1));

require_once (DOCROOT. '/db_connect/connect.php');
require_once (DOCROOT. '/create_table.php');
//$paramsDecode = json_decode($_POST["param"], true);
$d = '{"hrefS":"http://dockerized-magento.local/tracker/js.html#","userAgent":{"name":"chrome","version":65,"platform":"linux"},"Cookie":"fc772ca5efdde1d788ce88147e394bcf"}';
$paramsDecode = json_decode($d, true);
//echo '<pre>';
//print_r($paramsDecode);exit;

try {
    if (!empty($paramsDecode)) {
        $select = 'SELECT id, name_cookie FROM `ronis_track` WHERE name_cookie  = :name_cookie';


        $nameCookie = $paramsDecode['Cookie'];

        $data = $pdo->prepare($select);
        $data->execute(['name_cookie' => $nameCookie]);

        $result = $data->fetchAll(PDO::FETCH_ASSOC);


        foreach ($result as $item) {
            if (!empty($item)) {
                $query = "INSERT INTO `action` (ronis_track_id, link) VALUES (:ronis_track_id, :link)";

                $ronisTrackId = $item['id'];
                $link = $paramsDecode['hrefS'];

                $data = $pdo->prepare($query);

                $data->execute([
                    'ronis_track_id' => $ronisTrackId,
                    'link' => $link,
                ]);
            }

        }

        $query = "INSERT INTO ronis_track
                    (name_cookie, brawser_name, brawser_version, platform)
                  VALUES (:name_cookie, :brawser_name, :brawser_version, :platform)";

        $action = "INSERT INTO `action` (ronis_track_id, link) VALUES (:ronis_track_id, :link)";

        // print_r($query);
        $nameCookie = $paramsDecode['Cookie'];
        $brawserName = $paramsDecode['userAgent']['name'];
        $brawserVersion = $paramsDecode['userAgent']['version'];
        $platform = $paramsDecode['userAgent']['platform'];

        $data = $pdo->prepare($query);
        $dataAction = $pdo->prepare($action);

        $data->execute([
            'name_cookie' => $nameCookie,
            'brawser_name' => $brawserName,
            'brawser_version' => $brawserVersion,
            'platform' => $platform,

        ]);
        $stmt = $pdo->query('SELECT MAX(id)+1 FROM `ronis_track`');
        while ($row = $stmt->fetch())
        {
           print_r($row[0]). "\n";  //62 рабоатет 
        }
//        $max = "SELECT MAX(id)+1 FROM `ronis_track`";
//        $dataAction = $pdo->prepare($max);
//        $resultAction = $dataAction->fetchAll();
//        echo '*************************************';
//        while($row =$dataAction->fetchAll() ) {
//            echo $row['id'];
//        }
//        var_dump($resultAction);
//       foreach ($resultAction as $item) {
//           print_r($item);
//       }
//        $dataAction->execute([
//            'ronis_track_id' =>,
//            'link' => $link,
//        ]);


    }
} catch (PDOException $e) {
    echo "Ошибка выполнения запроса: " . $e->getMessage();
}

