<?php

/** 
 * Import admins
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/admin/import.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";
require "../../include/customModules.php";

$config = parse_ini_file("../../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Import teachers</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    if (!canImport()) {
        echo "You do not have the tools to import your database";
        exit();
    }
    if (isset($_FILES["csv"])) {
        $file = $_FILES["csv"]["tmp_name"];
        move_uploaded_file($file, "./csv");
        $teachers = decompileTeacher(file_get_contents("./csv"));
        if (!$teachers[0]) {
            echo "Something has gone wrong with the import of your file please try again";
            exit();
        }
        unlink("./csv");
        foreach ($teachers[1] as $teacherRecord) {
            $output = sendSqlCommand("INSERT teachers VALUES('" . $teacherRecord['uname'] . "', '" . $teacherRecord['passwd'] . "', '" . $teacherRecord['uuid'] . "')", "root", $config['sqlRootPasswd'], "VirtualPass");
            if ($output[0] != 0) {
                echo "Something has gone wrong importing the database please try again";
                exit();
            }
        }
        echo "Success! Database imported!";
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Import admins</title>
<tr>
    <form method="post" name="form" enctype="multipart/form-data" action="/Users/sign-up.php">
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <td colspan="3"><strong>Upload CSV file
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td><input type="file" name="csv" id="csv">Upload the CSV file</td>
                </tr>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input class="reg" type="submit" name="Submit" value="Login"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>