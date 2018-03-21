<?php
define('DOCROOT', substr(str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__), 0, -1));
require_once (DOCROOT. '/db_connect/connect.php');
require_once (DOCROOT. '/create_table.php');
$paramsDecode = json_decode($_POST["param"], true);

try {
    if (!empty($paramsDecode)) {
        $select = 'SELECT id, name_cookie FROM `ronis_track` WHERE name_cookie  = :name_cookie';
        $nameCookie = $paramsDecode['Cookie'];
        $data = $pdo->prepare($select);
        $data->execute(['name_cookie' => $nameCookie]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        $rowCount = $data->rowCount();//0 или 1

        if ($rowCount !== 0 && !empty($result)) {
            foreach ($result as $item) {

                $query = "INSERT INTO `action` (ronis_track_id, link, create_at) VALUES (:ronis_track_id, :link, :create_at)";

                $ronisTrackId = $item['id'];
                $link = $paramsDecode['open']['href'];
                $createAt = date("Y-m-d H:i:s");
                $data = $pdo->prepare($query);
                $data->execute([
                    'ronis_track_id' => $ronisTrackId,
                    'link' => $link,
                    'create_at' => $createAt,
                ]);
            }
        }
        else {
            $query = "INSERT INTO ronis_track
                        (name_cookie, brawser_name, brawser_version, platform)
                      VALUES (:name_cookie, :brawser_name, :brawser_version, :platform)";

            $nameCookie = $paramsDecode['Cookie'];
            $brawserName = $paramsDecode['userAgent']['name'];
            $brawserVersion = $paramsDecode['userAgent']['version'];
            $platform = $paramsDecode['userAgent']['platform'];

            $data = $pdo->prepare($query);
            $data->execute([
                'name_cookie' => $nameCookie,
                'brawser_name' => $brawserName,
                'brawser_version' => $brawserVersion,
                'platform' => $platform,

            ]);

            $id = $pdo->lastInsertId();

            $action = "INSERT INTO `action` (ronis_track_id, link, create_at) VALUES (:ronis_track_id, :link, :create_at)";
            $dataAction = $pdo->prepare($action);
            $createAt = date("Y-m-d H:i:s");
            $dataAction->execute([
                'ronis_track_id' => $id,
                'link' => $paramsDecode['open']['href'],
                'create_at' => $createAt,
            ]);

        }

    }
} catch (PDOException $e) {
    echo "Ошибка выполнения запроса: " . $e->getMessage();
}

function countOnline($conn) {
    $count = [];
    $sql = 'SELECT COUNT(DISTINCT ronis_track_id) FROM action WHERE create_at > date_sub(now(), interval 5 minute)';
    foreach ($conn->query($sql) as $row) {
        $count[] = $row[0];
    }
    return $count;
}
$countOnline = !empty (countOnline($pdo)[0]) ? countOnline($pdo)[0] : '0';

//2019-03-21T23:37:43.000Z