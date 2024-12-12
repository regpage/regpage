<?php
// сохранить звонок
if (isset($_GET['type']) && $_GET['type'] === 'save_call'){
    echo CallsDB::saveCall($_POST['data']);
    exit();
}

// получить звонок
if (isset($_GET['type']) && $_GET['type'] === 'get_call'){
    echo json_encode(["result"=>CallsDB::getCall($_GET['id'])]);
    exit();
}

// получить звонок
if (isset($_GET['type']) && $_GET['type'] === 'dlt_call'){
    echo CallsDB::dltcall($_GET['id']);
    exit();
}
