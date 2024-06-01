<?php

function post($var) {
    if (isset($_POST[$var])) {
        return $_POST[$var];
    } else {
        return null;
    }
}

function get($var) {
    return $_GET[$var];
}

function setError($error) {
    $_SESSION['error'] = $error;
}

function getError() {
    if (isset($_SESSION['error'])) {
        return $_SESSION['error'];
    } else {
        return [];
    }
}

function countError() {
    if (isset($_SESSION['error'])) {
        return 1;
    } else {
        return 0;
    }
}

function setPostError($error) {
    $_POST['error'] = $error;
}

function getPostError() {
    if (isset($_POST['error'])) {
        return $_POST['error'];
    } else {
        return null;
    }
}

function countPostError() {
    if (isset($_POST['error'])) {
        return 1;
    } else {
        return 0;
    }
}

function exist($column, $value, $table) {
    $db = new DB();
    $query = "SELECT $column
              FROM $table
              WHERE $column = '$value'
              AND delete_flg = '0'
              LIMIT 1;";
    if ($db->execute($query)) {
        return 1;
    } else {
        setError($db->getExecutionError());
        return 0;
    }
}

function find($id, $table) {
    $db = new DB();
    $query = "SELECT *
             FROM $table
             WHERE id = '$id'
             AND delete_flg = '0'
             LIMIT 1;";
    if ($result = $db->execute($query)) {
        return $result[0];
    } else {
        setError($db->getExecutionError());
        return 0;
    }
}

function descFind($id, $table) {
    $db = new DB();
    $query = "SELECT *
             FROM $table
             WHERE id = '$id'
             AND delete_flg = '0'
             ORDER BY id DESC
             LIMIT 1;";
    if ($result = $db->execute($query)) {
        return $result[0];
    } else {
        setError($db->getExecutionError());
        return 0;
    }
}

function findAll($table) {
    $db = new DB();
    $query = "SELECT *
              FROM $table
              WHERE delete_flg = '0'
              ORDER BY id;";
    if ($result = $db->execute($query)) {
        return $result;
    } else {
        setError($db->getExecutionError());
        return [];
    }
}

function findAllDesc($table) {
    $db = new DB();
    $query = "SELECT *
              FROM $table
              WHERE delete_flg = '0'
              ORDER BY id DESC;";
    if ($result = $db->execute($query)) {
        return $result;
    } else {
        setError($db->getExecutionError());
        return [];
    }
}

function findAllInvalidate($table) {
    $db = new DB();
    $query = "SELECT *
              FROM $table
              WHERE delete_flg = '0'
              ORDER BY id;";
    if ($result = $db->execute($query)) {
        return $result;
    } else {
        setError($db->getExecutionError());
        return [];
    }
}

function findBy($table, $cond) {
    $db = new DB();
    $where = '';
    foreach ($cond as $column => $row) {
        $where .= "AND $column = '$row'";
    }
    $query = "SELECT *
              FROM $table
              WHERE delete_flg = '0'
              $where
              ORDER BY id;";
    if ($result = $db->execute($query)) {
        return $result;
    } else {
        setError($db->getExecutionError());
        return [];
    }
}

function findByDesc($table, $cond) {
    $db = new DB();
    $where = '';

    foreach ($cond as $column => $row) {
        $where .= "AND $column = '$row'";
    }

    $query = "SELECT *
              FROM $table
              WHERE delete_flg = '0'
              $where
              ORDER BY id DESC;";

    if ($result = $db->execute($query)) {
        return $result;
    } else {
        return [];
    }
}

function findDesc($table) {
    $db = new DB();
    $query = "SELECT *
              FROM $table
              WHERE delete_flg = '0'
              ORDER BY id DESC
              LIMIT 1;";
    if ($result = $db->execute($query)) {
        return $result[0];
    } else {
        return 0;
    }
}

function resCount($table) {
    $db = new DB();
    $query = "SELECT id
              FROM $table
              WHERE delete_flg = '0';";
    $result = $db->execute($query);

    if ($result) {
        return count($result[0]);
    } else {
        setError($db->getExecutionError());
        return 0;
    }
}

function insert($vars, $table) {
    $db = new DB();
    $variables = [];
    $values = [];
    foreach ($vars as $key => $value) {
        array_push($variables, $key);
        array_push($values, $value);
    }
    $variables = implode(', ', $variables);
    foreach ($values as $key => $value) {
        $values[$key] = "'".$value."'";
    }
    $values = implode(', ', $values);
    $query = "INSERT INTO $table ($variables)
              VALUES ($values);";
    if ($db->execute($query)) {
        setError($db->getExecutionError());
        return 0;
    } else {
        return 1;
    }
}

function update($vars, $table, $where) {
    $db = new DB();
    $variables = [];
    foreach ($vars as $key => $value) {
        $val = "$key = '$value'";
        array_push($variables, $val);
    }
    $isFirst = true;
    $where_clause = "";
    foreach ($where as $key => $value) {
        if ($isFirst) {
            $where_clause = "$key = '$value'";
        } else {
            $where_clause = " AND $key = '$value'";
        }
        $isFirst = false;
    }
    $variables = implode(', ', $variables);
    $query = "UPDATE $table 
              SET $variables
              WHERE $where_clause;";
    if ($db->execute($query)) {
        setError($db->getExecutionError());
        return 0;
    } else {
        return 1;
    }
}

function isSelected($val1, $val2) {
    if ($val1 == $val2) {
        return "selected";
    } else {
        return null;
    }
}

function isChecked($val1, $val2) {
    if ($val1 == $val2) {
        return "checked";
    } else {
        return null;
    }
}

function isCheckedFromArray($val, $arr) {
    if (in_array($val, $arr)) {
        return "checked";
    } else {
        return null;
    }
}

function delete($table, $id) {
    $db = new DB();
    $query = "UPDATE $table
              SET delete_flg = '1'
              WHERE id = '$id';";
    if ($db->execute($query)) {
        setError($db->getExecutionError());
        return 0;
    } else {
        return 1;
    }
}

function addZeroes($number) {
    return number_format($number).'.00';
}

function numhash($inNum) {
    return (((0x0000FFFF & $inNum) << 16) + ((0xFFFF0000 & $inNum) >> 16));
}

function getAve($num, $div) {
    if ($div == 0) {
        return number_format((float)0, 1, '.', '');
    } else {
        return number_format((float)$num/$div, 1, '.', '');
    }
}

function userGetImage($user_id) {
    $user_details = find($user_id, 'm_user');

    if ($user_details['image_id'] != null) {
        $image_data = find($user_details['image_id'], 't_uploads');

        return '/html/imgs/'.$image_data['file'];
    } else {
        return '/html/imgs/user.png';
    }
}