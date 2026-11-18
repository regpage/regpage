<?php
// References
function db_addReference($data){
    global $db;

    $_name = db_real_escape_string($data['name']);
    $_page = db_real_escape_string($data['page']);
    $_link_article = db_real_escape_string($data['link_article']);
    $_block = db_real_escape_string($data['block']);
    $_published = db_real_escape_string($data['published']);
    $_priority = db_real_escape_string($data['priority']);

    db_query("INSERT INTO reference_system (name, link_article, page, block_num, published, priority) VALUES ('$_name', '$_link_article', '$_page', '$_block', '$_published', $_priority)");
}

function db_setReference($data){
    global $db;
    $_name = db_real_escape_string($data['name']);
    $_page = db_real_escape_string($data['page']);
    $_link_article = db_real_escape_string($data['link_article']);
    $_block = (int)$data['block'];
    $_id = (int)$data['id'];
    $_published = db_real_escape_string($data['published']);
    $_priority = db_real_escape_string($data['priority']);

    db_query("UPDATE reference_system SET name='$_name', link_article = '$_link_article', page = '$_page', block_num = '$_block', published = '$_published', priority='$_priority' WHERE id=$_id");
}

function db_setReferenceFieldValue($field, $value, $id){
    global $db;
    $_field = db_real_escape_string($field);
    $_value = (int)$value;
    $_id = (int)$id;

    db_query("UPDATE reference_system SET ".$_field." = '$_value' WHERE id=$_id ");
}

function db_deleteReference($id){
    $_id = (int)$id;

    db_query("DELETE FROM reference_system WHERE id=$_id ");
}

function db_getReferencesBlock(){
    $res = db_query("SELECT * FROM reference_block");

    $blocks = array();
    while($row = $res->fetch_assoc()){
        $blocks [$row['id']] = $row['name'];
    }

    return $blocks;
}

?>
