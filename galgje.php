<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play_Hangman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        function generateWordFromCategory() {
            if(isset($_POST['category'])) {
                list($category, $words) = explode(':', $_POST['category']);
                $_SESSION['category'] = $category;
                $wordsArray = explode(",", $words);
                $_SESSION['word'] = strtoupper($wordsArray[array_rand($wordsArray)]);
            }
            return $_SESSION['word'] ?? "";
        }
        $playWord = generateWordFromCategory();
    
        function chooseWords() {
            if(isset($_POST['writeword'])) {
               $writeWord = $_POST['writeword'];
               $_SESSION['word'] = strtoupper($writeWord);
            }
            return $_SESSION['word'] ?? "";
        }
        $playWriteWord = chooseWords();

        function checkLetter(string $word) {
            if (!isset($_SESSION['wrongLetters'])) {
                $_SESSION['wrongLetters'] = array();
            }

            if (!isset($_SESSION['rightLetters'])) {
                $_SESSION['rightLetters'] = array();
            }

            if (isset($_POST['playerGuess'])) {
                $letter = $_POST['playerGuess'][0];
                if (stripos($word, $letter) === false) {
                    array_push($_SESSION['wrongLetters'], $letter);
                } else {
                    array_push($_SESSION['rightLetters'], $letter);
                }
            }

        }
        checkLetter($playWriteWord);

        function replaceRightLetter(string $word) {
            $wordHint = "";
            for ($i = 0; $i < strlen($word); $i++) {
                $letter = substr($word, $i, 1);
                $wordHint .= in_array($letter, $_SESSION['rightLetters']) ? $letter : " _ ";
            }
            return $wordHint;
        }
        $wordHin = replaceRightLetter($playWriteWord);

        echo "<h1> Hangman </h1>";
        $_SESSION['chances'] = max(0, 7 - count($_SESSION['wrongLetters']));
        echo '<p> The word is: ' .'<span>' . $wordHin . '</span>' .  '</p>';
        echo '<p id="chances"> You have ' . $_SESSION['chances'] .  ' chances left. </p>'; 
        $img = "images/hang" . count($_SESSION['wrongLetters']) . ".png";
        echo "<img id='hangman' src='$img'>";

        function checkWinLoss(string $word) {
            if ($_SESSION['chances'] <= 0) {
                $_SESSION['game_over'] = true;
                echo "YOU DIED!";
                echo '<span>The word was: ' . $word . '</span>';
                return;
                
            }
        
            if ($word === replaceRightLetter($word)) {
                $_SESSION['game_over'] = true;
                echo '<h1>You did it!</h1>';
                echo "<img id='vuurwerk' src='images/vuurwerk.gif'>";
                echo '<div class="balloons">';
                echo '<div class="balloon"></div>';
                echo '<div class="balloon"></div>';
                echo '<div class="balloon"></div>';
                echo '<div class="balloon"></div>';
                echo '<div class="balloon"></div>';
                echo '</div>';
                return;
            }
        }
        checkWinLoss($playWriteWord);
    
    ?>

    <form action="destroy.php" method="post">
        <input type="submit" value="Reset the game and return to main menu." />
    </form>

    <form method="POST" id="letter">

        <?php if (!isset($_SESSION['game_over'])): ?>

            <p>Letters left:</p>

            <?php 
                $alphabet = range("A", "Z"); 
            ?>

            <?php foreach ($alphabet as $letter): ?>

                <?php 
                if (
                    !in_array($letter, $_SESSION['rightLetters']) &&
                    !in_array($letter, $_SESSION['wrongLetters']) &&
                    $_SESSION['chances'] > 0
                    ): ?>

                    <input 
                        name="playerGuess"
                        id="<?= $letter ?>"
                        type="submit"
                        value="<?= $letter ?>"
                        class="letterbutton" 
                    />

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </form>

</body>
</html>

