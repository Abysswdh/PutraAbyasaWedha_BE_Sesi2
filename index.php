<?php
$greeting = "Hello World!";
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Example</title>
</head>
<body>
    <h1><?php echo $greeting; ?></h1>
    <p>This is HTML mixed with PHP</p>
    <?php
    // This is PHP code
    for($i = 1; $i <= 3; $i++) {
        echo "<div>Loop item $i</div>";
    }
    ?>
</body>
</html>