<?php
//nooooo this code is not stolen fron StackOverflow no never!
function config_set($config_file, $section, $key, $value) {
  $config_data = parse_ini_file($config_file, true);
  $config_data[$section][$key] = $value;
  $new_content = '';
  foreach ($config_data as $section => $section_content) {
      $section_content = array_map(function($value, $key) {
          return "$key=$value";
      }, array_values($section_content), array_keys($section_content));
      $section_content = implode("\n", $section_content);
      $new_content .= "[$section]\n$section_content\n";
  }
  file_put_contents($config_file, $new_content);
}
//nooooo this code is not stolen fron StackOverflow no never!
$cookie_name = "phid";
//check for all the variables from the html below
$domain = $_SERVER['SERVER_NAME'];
//$domain = "1b0e-8-6-112-61.ngrok.io";
//echo $domain;
if(isset($_GET['page'])) {
  if(isset($_POST['firstname'])) {
    if(isset($_POST['lastname'])) {
      if(isset($_POST['stid'])) {
        if(isset($_POST['stem'])) {
          //set all the variables
          $qrid = $_GET['page'];
          $firstname=$_POST['firstname'];
          $lastname=$_POST['lastname'];
          $stid=$_POST['stid'];
          $stem=$_POST['stem'];
          //get a unique id for the user
          $ranid = uniqid(rand());
          echo $ranid;
          $date = date(DATE_ATOM);
          if(!isset($_COOKIE[$cookie_name])) {
            //set the cookie with their random id so i can identify them later
            $ini = parse_ini_file('../config/config.ini');
            $sendemail = $ini['em_enable'];
              $money = "$";
              setcookie($cookie_name, $ranid, time() + (86400 * 360), "/", $domain, TRUE, TRUE);
              exec("sleep.5s");
              if(!isset($_COOKIE[$cookie_name])) {
                echo("Hmm something has gone wrong I cant set your cookie. Trying fallback method...");
              }
              $inifl = fopen("registered_phid/" . $ranid, "w");
              $tet = ("[usrinfo]\nfirst_name=" . $firstname . "\nlast_name=" . $lastname . "\nstudent_id=" . $stid . "\nstudent_email=" . $stem . "\nstudent_activity=Arrived\n[srvinfo]\ndayofmonth_gon=\nhour_gon=\nminute_gon=\ndayofmonth_arv=\nhour_arv=\nminute_arv=\n[email]\nemail_html=\n[huinfo]\n");
              fwrite($inifl, $tet);
              fclose($inifl);
              mkdir("human_info/" . $ranid);
              //exec("cd registered_phid/ && mkdir '{$ranid}' && cd '{$ranid}' && mkdir 'srvinfo' && mkdir 'huinfo' && mkdir 'email' && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> '{$ranid}'");
              if ($sendemail == "1"){
                //$myfile = fopen('registered_phid/' . $ranid . '/email/email.html', "w");
                $txt = ('<head><link href="https://rawcdn.githack.com/Duedot43/VirtualPass/82889bcf8bd24b0df4b99b1a59bef0699f370474/src/style.css" rel="stylesheet" type="text/css" /></head><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>VirtualPass sign-up confirmation</title><tr><td><table width="100%" border="0" cellpadding="3" cellspacing="1"><tr><td colspan="3"><strong>Congrats ' . $firstname . ', your info has been set!<br>Choose any option below and it will redirect you to the VirtualPass website.<br></strong></td></tr><tr><td width="0"></td><td width="0"></td><td width="294"><input class="reg" type="button" value="Change user info" onclick="location=\"https://' . $domain . '/cgusr.php?user=' . $ranid . '\"" /></td><td width="78"></td><td width="80"></td><td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location=\"https://' . $domain . '/delusreml.php?user=' . $ranid . '\"" style="border-color:red; color:white"/></td><td width="0"></td><td width="0"></td></tr><tr></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr></table>');
                config_set("registered_phid/" . $ranid, "email", "email_html", $txt);
                //$txt = ('<head>\n<link href="https://rawcdn.githack.com/Duedot43/VirtualPass/82889bcf8bd24b0df4b99b1a59bef0699f370474/src/style.css" rel="stylesheet" type="text/css" /></head><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>VirtualPass sign-up confirmation</title><tr><td><table width="100%" border="0" cellpadding="3" cellspacing="1"><tr><td colspan="3"><strong>Congrats ' . $firstname . ', your info has been set!<br>Choose any option below and it will redirect you to the VirtualPass website.<br></strong></td></tr><tr><td width="0"></td><td width="0"></td><td width="294"><input class="reg" type="button" value="Change user info" onclick="location=\'https://' . $domain . '/cgusr.php?user=' . $ranid . '\'" /></td><td width="78"></td><td width="80"></td><td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location=\'https://' . $domain . '/delusreml.php?user=' . $ranid . '\'" style="border-color:red; color:white"/></td><td width="0"></td><td width="0"></td></tr><tr></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr></table>');
                //fwrite($myfile, $txt);
                //fclose($myfile);

              }
              
              if (!is_file("administrator/student.php")) {
                copy("usr_pre_fls/index.php", "administrator/student.php");
                //exec("cp usr_pre_fls/index.php ./administrator/student.php");
              }
              $tat = '<link href="style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="' . $firstname . '" onclick="location=\'human_info/' . $ranid . '/index.php\'" /></td>';
              $student = file_put_contents('administrator/student.php', $tat.PHP_EOL , FILE_APPEND | LOCK_EX);
              if ($ini['enable_insecure_general_logs'] == "1"){
              //exec('cd administrator/ && echo "<"link href="/style.css" rel="stylesheet" type="text/css" "/>""<"input type="button" value="' . $firstname . '" onclick="location=\'/registered_phid/' . $ranid . '/huinfo/index.html\'" "/><br>" >> student.php');
              exec("echo ///////////////////////////////////////////////// >> log/inout.log");
              exec("echo '{$date}' >> log/inout.log");
              exec("echo '{$firstname}' registered with phid '{$ranid}' >> log/inout.log");
              exec("echo ///////////////////////////////////////////////// >> log/inout.log");
              }
              //send it back to stupid
              header("Location: /stupid.php?page=" . $qrid);
              exit();
          }
          else {
    
            //echo "Cookie '" . $cookie_name . "' is set!<br>";
            //echo "Value is: " . $_COOKIE[$cookie_name];
            //look for the user in the files and find out if they are departed or not
            //$catin = exec("ls departed/ | grep " . $_COOKIE[$cookie_name]);
            //$catout = exec("ls registered_phid/ | grep " . $_COOKIE[$cookie_name]);
            //echo ("Hall pass registerd<br>");
            //echo ("Please rescan the QR code if this is your first time.<br>");
            //echo " out ", $catout, " in ", $catin, " cookie ", $_COOKIE[$cookie_name];
            //1 = departed
            $cook = ("0");
            if (file_exists("registered_phid/" . $_COOKIE[$cookie_name])) {
              header("Location: /stupid.php?page=" . $qrid);
              $cook = ("1");
              //exec("mv -v registered_phid/" . $_COOKIE[$cookie_name] . " departed/");
            }
            //if the top if statment has triggered this one will not beacuse $catout is outdated at this point
            //if the user is found in departed the below if triggers
            //if ($catin == $_COOKIE[$cookie_name]) {
            //  $fh = fopen('departed/' . $_COOKIE[$cookie_name] . '/' . $_COOKIE[$cookie_name],'r');
            //  $cookid = fgets($fh); 
              //read the file and mark them as arrived
            //  $dpt = ("Arrived");
            //  $cook = ("1");
            //  exec("mv -v departed/" . $_COOKIE[$cookie_name] . " registered_phid/");
              //move them to the arrived folder
           // }
            //checking if the cookie is registered but they are not in the files
            if ($cook == "0") {
              //cookie error re register cookie and delete the cookie
              setcookie("phid", "", time() - 9999999999);
              header("Location: /registercookie.php?page=" . $qrid);
            }
          }
//setcookie($cookie_name, $ranid, time() + (86400 * 360));
//exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> {$ranid}");
//exec("echo '{$firstname} registered with phid {$ranid} >> log/inout.log");
//exec("echo ///////////////////////////////////////////////// >> log/inout.log");
//exec("echo '{$date}' >> log/inout.log");
//exec("echo '{$firstname} registered with phid {$ranid}' >> log/inout.log");
//exec("echo ///////////////////////////////////////////////// >> log/inout.log");
//header("Location: /stupid.php");

        }
      }
    }
  }
}
?>

<title>Register Your User</title>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<tr>
    <form method="post">
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <td colspan="3"><strong>Register! (you only have to do this once.) We do not collect data.
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td class="text" width="78">First Name
                        <td width="6">:</td>
                        <td width="294"><input class="box" autocomplete="off" name="firstname" type="text" pattern="[a-zA-Z]+" id="firstname"
                            required></td>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>:</td>
                    <td><input class="box" name="lastname" autocomplete="off" type="text" id="lastname" pattern="[a-zA-Z]+" required></td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td>:</td>
                    <td><input class="box" name="stid" autocomplete="off" type="number" id="stid" placeholder="10150100" required></td>
                </tr>
                <td>Student E-Mail</td>
                <td>:</td>
                <td><input class="box" name="stem" autocomplete="off" type="email" id="stem" placeholder="student@cherrycreekschools.org"
                        required></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input class="reg" type="submit" name="Submit" value="Register"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>