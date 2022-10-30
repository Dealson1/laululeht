<?php
require_once ('conf.php');
global $yhendus;

//laulude kommenteerimine
if (!empty($_REQUEST['komment'])){
    $kask=$yhendus->prepare("UPDATE laulud SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id=?");
    $lisakommentaar=($_REQUEST['komment']."\n");
    $kask->bind_param('si', $lisakommentaar, $_REQUEST['uus_komment']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//punktide lisamine
if(isset($_REQUEST['haal'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=punktid+1 Where id=?");
    $kask->bind_param('s', $_REQUEST['haal']);
    $kask->execute();
// aadressiriba sisu eemaldamine
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['haha'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=punktid-1 Where id=?");
    $kask->bind_param('s', $_REQUEST['haha']);
    $kask->execute();
// aadressiriba sisu eemaldamine
    header("Location: $_SERVER[PHP_SELF]");
}

?>
<!DOCTYPE html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" type="text/css" href="laulstyle.css">
</head>

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

<body>


<h1>Laulude leht</h1>

<br>

<table>
    <tr>
        <td>Laulunimi</td>
        <td>Punktid</td>
        <td>Lisamisaeg</td>
        <td>Lisa Punktid</td>
        <td></td>
        <td>Kommentaarid</td>
        <td>Lisa komment</td>
    </tr>
    <?php
    // tabeli sisu näitamine
    $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg, kommentaarid FROM laulud Where avalik=1');
    $kask->bind_result($id, $laulunimi, $punktid, $aeg, $kommentaarid);
    $kask->execute();
    while($kask->fetch()){
        echo "<tr>";
        echo "<td>".htmlspecialchars($laulunimi)."</td>";
        echo "<td>$punktid</td>";
        echo "<td>$aeg</td>";
        echo "<td><a href='?haal=$id'>+1 </a></td>";
        echo "<td><a href='?haha=$id'>-1 </a></td>";
        echo "<td>".nl2br($kommentaarid)."</td>"; //nl2br break function before new lines in string
        echo "<td>
                <form action ='?'>
                <input type='hidden' name='uus_komment' value='$id'>
                <input type='text' name='komment'>
                <input type='submit' value='OK'>
                </form>
              </td>";

        echo "</tr>";
    }


    ?>

</table>
</body>
<?php
$yhendus->close();
?>
</html>