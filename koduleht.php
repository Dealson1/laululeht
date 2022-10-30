<?php
require_once ('conf.php');
global $yhendus;

//tabeli andmete lisamine
if(!empty($_REQUEST['uusnimi'])){
    $kask=$yhendus->prepare("INSERT INTO laulud(laulunimi, lisamisaeg) VALUES (?, NOW())");
    $kask->bind_param('s', $_REQUEST['uusnimi']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="laulstyle.css">
    <title>Koduleht</title>
</head>
</head>
<body>

<nav class = "navbar">
    <div class = "containerr">
        <div class = "navbar-wrap">
            <ul class = "navbar-menu">
                <li><a href="koduleht.php">Koduleht</a></li>
                <li><a href="laulud.php">Laulud</a></li>
                <li><a href="lauludadmin.php">Admin</a></li>
                <li><a href="https://github.com/Dealson1">GitHub</a></li>
            </ul>
        </div>
    </div>
</nav>

<h1>Laulu lisamine</h1>

<form action="?" method="post">
    <label for="nimi">Laulunimi</label>
    <input type="text" name="uusnimi" id="nimi" placeholder="laulunimi">
    <input type="submit" value="OK">
</form>

</body>
</html>


<?php
$yhendus->close();
?>
