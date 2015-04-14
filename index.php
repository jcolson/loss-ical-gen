<?php
include 'ics.php';
// define variables and set to empty values
$startDateErr = $weightErr = $loseEachWeekErr = $targetWeightErr = "";
$startDate = $weight = $loseEachWeek = $targetWeight = "";
$icsOutput = test_input($_POST["icsOutput"].$_GET["icsOutput"]);

if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    $startDate = test_input($_POST["startDate"].$_GET["startDate"]);
    if (empty($startDate)) {
        $startDateErr = "Start date is required";
    }
    $weight = test_input($_POST["weight"].$_GET["weight"]);
   if (empty($weight)) {
     $weightErr = "Weight is required";
   } else {
       // check if name only contains letters and whitespace
       if (!preg_match("/^[0-9]*\.[0-9]*$/", $weight)) {
           $weightErr = "Only numbers allowed";
       }
   }
    $loseEachWeek = test_input($_POST["loseEachWeek"].$_GET["loseEachWeek"]);
    if (empty($loseEachWeek)) {
        $loseEachWeekErr = "Lose each week is required";
    } else {
        // check if name only contains letters and whitespace
        if (!preg_match("/^[0-9]*\.[0-9]*$/", $loseEachWeek)) {
            $loseEachWeekErr = "Only numbers allowed";
        }
    }
    $targetWeight = test_input($_POST["targetWeight"].$_GET["targetWeight"]);
    if (empty($targetWeight)) {
        $targetWeightErr = "Target Weight is required";
    } else {
        // check if name only contains letters and whitespace
        if (!preg_match("/^[0-9]*\.[0-9]*$/", $targetWeight)) {
            $targetWeightErr = "Only numbers allowed";
        }
    }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
if ($icsOutput == "true") {
    $ics = new ics();
    echo $ics->generate($startDate, $weight, $loseEachWeek, $targetWeight);
} else {
    ?>
<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>
<h2>Loss Calender Generator</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Date to start: <input type="date" name="startDate" value="<?php echo $startDate;?>">
    <span class="error">* <?php echo $startDateErr;?></span>
    <br><br>
    Current weight: <input type="text" name="weight" value="<?php echo $weight;?>">
    <span class="error">* <?php echo $weightErr;?></span>
    <br><br>
    Lose each week: <input type="text" name="loseEachWeek" value="<?php echo $loseEachWeek;?>">
    <span class="error">* <?php echo $loseEachWeekErr;?></span>
    <br><br>
    Target weight: <input type="text" name="targetWeight" value="<?php echo $targetWeight;?>">
    <span class="error">* <?php echo $targetWeightErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>
</body></html>
<?php
    echo "<h2>ICS URL TO USE:</h2>";
    echo "<a href=\"" . curPageURL() . "?icsOutput=true&startDate=" . $startDate . "&weight=" . $weight. "&loseEachWeek=" . $loseEachWeek. "&targetWeight=" . $targetWeight . "\">ICS URL</a>";
}
?>
