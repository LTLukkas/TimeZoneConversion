<?php
session_start();

$tzindents = DateTimeZone::listIdentifiers(); //OOP
$tzones = timezone_identifiers_list();
$dt = new DateTime('now');

function format_hours_minutes($float){
    $hours = floor($float);
    $minutes = ($float - $hours) * 60;
    return sprintf("%+02d:%02d", $hours, $minutes);
}

$user_tz_indent = NULL;

if(isset($_POST['submit'])){
    //save tz choice
    $tz_choice = $_POST['tz_choice'];
    //only accept value if its in the list
    if(in_array($tz_choice,$tzindents)){
        $_SESSION['user_tz_indent'] = $tz_choice;
        $user_tz_indent = $tz_choice;
    }
}else{
    // check for previous TZ settings
    if (isset($_SESSION['user_tz_indent'])){
        $user_tz_indent = $_SESSION['user_tz_indent'];
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Time Zone Selection by Lukkas</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="main-content">

            <h1>Time Zone Selection</h1>

            <form action="" method="post">

                Preffered Time Zone:
                <select name="tz_choice">
                    <?php
                    foreach ($tzones as $tzone) {
                        $this_tz = new DateTimeZone($tzone);
                        $dt->setTimezone($this_tz);
                        //divide by 360 for offset in hours
//                        $offset = format_hours_minutes($dt->getOffset() / 3600);
                        $offset = $dt->format('P');
                        echo "<option value='$tzone'" ?>
                        <?php
                            if($user_tz_indent == $tzone){
                                echo " selected ";
                            }
                    echo "> $tzone (UTC/GMT $offset) </option>";
                    }
                    ?>
                </select>

                <br />
                <div class="controls">
                    <input type="submit" name="submit" value="submit"/>
                </div>

            </form>

        </div>
    </body>
</html>