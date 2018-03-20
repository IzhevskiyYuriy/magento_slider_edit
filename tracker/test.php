<?php

 $param = json_decode($_POST["param"]);
foreach ($param as $data) {
    echo $data.'<br>';
}
