<?php
$lines = file("words.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>

<link rel="stylesheet" href="style.css" type="text/css">
<h1>Choose a category</h1>

<form action="galgje.php" method="POST">

<?php
foreach ($lines as $line) {
    list($category, $words) = explode(":", $line);

    echo '<button type="submit" name="category" value="'.$line.'" class="cat-btn">
        '.ucfirst($category).'
      </button>';
}
?>

</form>