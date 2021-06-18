<?php

include 'db.php';

$menu = $_POST['menu'];
$array_menu = json_decode($menu, true);

$db->query('TRUNCATE TABLE menu');

function updateMenu($menu,$parent = 0)
{
    global $db;

    

    if (!empty($menu)) {
        

        foreach ($menu as $value) {
            
            $label = $value['label'];
            $code = (empty($value['code'])) ? '#' : $value['code'];
            $description = (empty($value['description'])) ? '#' : $value['description'];

            $sql = "INSERT INTO menu (label, code, description, parent_id) VALUES ('$label', '$code','$description', $parent)";

            $db->query($sql);
            $id = $db->insertedId();

            if (array_key_exists('children', $value))
                updateMenu($value['children'],$id);
        }

    }
}


updateMenu($array_menu);

header("Location: index.php")
?>