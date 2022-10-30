<?php
require_once ('conf.php');
global $yhendus;

//peitmine
if(isset($_REQUEST['peitmine'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET avalik=0 Where id=?");
    $kask->bind_param('s', $_REQUEST['peitmine']);
    $kask->execute();
}
//naitamine
if(isset($_REQUEST['naitamine'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET avalik=1 Where id=?");
    $kask->bind_param('s', $_REQUEST['naitamine']);
    $kask->execute();
}

//kustutamine
if(isset($_REQUEST["ban"])) {
    $kask=$yhendus->prepare("DELETE FROM laulud WHERE id=?");
    $kask->bind_param("i", $_REQUEST["ban"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_REQUEST["clear"])) {
    $kask=$yhendus->prepare("UPDATE laulud SET kommentaarid=' ' Where id=?");
    $kask->bind_param("i", $_REQUEST["clear"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_REQUEST['zero'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=0 Where id=?");
    $kask->bind_param('s', $_REQUEST['zero']);
    $kask->execute();
// aadressiriba sisu eemaldamine
    header("Location: $_SERVER[PHP_SELF]");
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude admin leht</title>
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

<h1>Laulude admin leht</h1>

<br>

<table>
    <thead>
        <tr>
            <td>Laulunimi</td>
            <td>Punktid</td>
            <td>Lisamisaeg</td>
            <td>Kommentaarid</td>
            <td>Status</td>
            <td>Haaldus</td>
            <td>Kustuta laul</td>
            <td>Zero punktid</td>
            <td>Clear komment</td>
        </tr>
    </thead>

    <?php
    // tabeli sisu näitamine
    $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg, kommentaarid, avalik FROM laulud');
    $kask->bind_result($id, $laulunimi, $punktid, $aeg, $kommentaarid, $avalik);
    $kask->execute();
    while($kask->fetch()){
        $seisund='Peidetud';
        $param='naitamine';
        $tekst='Naita';
        if($avalik==1){
            $seisund='Avatud';
            $param='peitmine';
            $tekst='Peida';
        }

        echo "<tbody>";
        echo "<tr>";
        echo "<td>".htmlspecialchars($laulunimi)."</td>";
        echo "<td>$punktid</td>";
        echo "<td>$aeg</td>";
        echo "<td>$kommentaarid</td>";
        echo "<td>$seisund</td>";
        echo "<td><a href='?$param=$id'>$tekst</a>";
        echo "<td><a href='?ban=$id'>Kustuta</a>";
        echo "<td><a href='?zero=$id'>Zero</a>";
        echo "<td><a href='?clear=$id'>Clear</a>";
        echo "</tr>";
        echo "<tbody>";
    }


    ?>

</table>
</body>
<?php
$yhendus->close();
?>
</html>