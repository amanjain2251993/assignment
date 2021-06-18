<?php
include 'db.php';

function renderMenuItem($id, $label, $code ,$description)
{
    return '<li class="dd-item dd3-item" data-id="' . $id . '" data-label="' . $label . '" data-code="' . $code . '" data-description="' . $description .'">' .
        '<div class="dd-handle dd3-handle" > Drag</div>' .
        '<div class="dd3-content"><span>' . $label . '</span>' .
        '<div class="item-edit">Edit</div>' .
        '</div>' .
        '<div class="item-settings d-none">' .
        '<p><label for="">Update Name<br><input type="text" name="update_name" value="' . $label . '"></label></p>' .
        '<p><label for="">Update Code<br><input type="text" name="update_code" value="' . $code . '"></label></p>' .
        '<p><label for="">Update Description<br><input type="text" name="update_description" value="' . $description . '"></label></p>' .
        '<p><a class="item-delete" href="javascript:;">Remove</a> |' .
        '<a class="item-close" href="javascript:;">Close</a></p>' .
        '</div>';

}

function menuTree($parent_id = 0)
{
    global $db;
    $items = '';
    $query = $db->query("SELECT * FROM menu WHERE parent_id = ? ORDER BY id_menu ASC", $parent_id);
    if ($query->numRows() > 0) {
        $items .= '<ol class="dd-list">';
        $result = $query->fetchAll();
        foreach ($result as $row) {
            $items .= renderMenuItem($row['id_menu'], $row['label'], $row['code'], $row['description']);
            $items .= menuTree($row['id_menu']);
            $items .= '</li>';
        }
        $items .= '</ol>';
    }
    return $items;
}

?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Assignment</title>
    <meta name="description" content="Assignment">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/jquery.nestable.css">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>



    <form id="add-item">
        <input type="text" id="name" name="name" placeholder="Name">
        <input type="text" id="code" name="code" placeholder="Enter Code">
        <input type="textarea" id="description" name="description" placeholder="Enter Description">
        <button type="submit">Add Item</button>
    </form>

    <hr />

    <div class="dd" id="nestable">
        <?php
            $html_menu = menuTree();
            echo (empty($html_menu)) ? '<ol class="dd-list"></ol>' : $html_menu;
        ?>
    </div>


    <hr />
    <form action="menu.php" method="post">
        <input type="hidden" id="nestable-output" name="menu">
        <button type="submit">Save Menu</button>
    </form>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery.nestable.js"></script>
    <script src="js/script.js"></script>
</body>

</html>