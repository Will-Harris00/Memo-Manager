<?php
/* This is an old method utilising a database to store and retrieve user preferences. */
session_start();

if (isset($_POST['apply_prefs_btn'])) {
    require "handler.inc.php";
    $userid = htmlspecialchars($_SESSION['userid']);
    $fg = htmlentities(str_replace(' ', '', $_POST['foreground']));
    $bg = htmlentities(str_replace(' ', '', $_POST['background']));

    $sql = "REPLACE INTO Preferences
        (userid, foreground, background)
        VALUES (?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../account.php?error=sqlpreferencesupdateerror&foreground=" . $fg . "&background=" . $bg);
    } else {
        mysqli_stmt_bind_param($stmt, "iss", $userid, $fg, $bg);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        header("Location: ../account.php?preferences_updated=success");
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
} else {
    header("Location: ../account.php");
    exit();
}
?>
