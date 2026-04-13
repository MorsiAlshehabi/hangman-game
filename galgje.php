<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hangman - Playing!</title>
    <meta name="description" content="Play hangman">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    
    <?php

    function generateWordFromCategory() {
        if (isset($_POST['category'])) {

            list($category, $words) = explode(":", $_POST['category']);

            $_SESSION['category'] = $category;

            $wordsArray = explode(",", $words);

            $_SESSION['word'] = strtoupper($wordsArray[array_rand($wordsArray)]);
        }

        return $_SESSION['word'] ?? null;
}
    $word = generateWordFromCategory();

    function chooseWords() {
        if (isset($_POST['chosenWord'])) {
            $woord = $_POST['chosenWord'];
            $_SESSION['word'] = strtoupper($woord);
        }
        return $_SESSION['word']?? true;      
    }
    

   function checkLetter() {
        if (!isset($_SESSION['wrongLetters'])) { 
            $_SESSION['wrongLetters'] = array();
            // nu wrong letter = empty array daarna ik push fout letter in deze array
        } 
        if (!isset($_SESSION['rightLetters'])) {
            $_SESSION['rightLetters'] = array();
            // nu right letter = empty array daarna ik push right letter in deze array
        }
        if (isset($_POST['playerGuess'])) { // playerguess = letter kies van letters
          /*
          strpos(sensantief voor letter:je moet let op voor letter if groet of klien => daarom ik gebruik stripos
          want met i niet sesantief) stripos= string possion 3 parameter (1,2,3) 
          1:welke variable wil ik zoken(requierd moet ik uitvoeren),
          2:welke letter of nummer wil ik zoken(requierd),
          3: ofset van welke index wil ik beginnen(optional hoef niet uitvoeren)
          */ 
            if (stripos(chooseWords(), $_POST['playerGuess'][0]) === false) {
                array_push($_SESSION['wrongLetters'], $_POST['playerGuess'][0]); 
            } else {
                array_push($_SESSION['rightLetters'], $_POST['playerGuess'][0]); 
            }
        }
    } 
    checkLetter();
   
   function replaceRightLetter() {
        $wordHint = "";
        for ($i = 0; $i < strlen(chooseWords()); $i++) {
            $wordHint .= in_array(substr(chooseWords(), $i, 1), $_SESSION['rightLetters']) ? substr(chooseWords(), $i, 1) : " _ ";
        }
        return $wordHint;
    }
    $wordHin = replaceRightLetter();
    
    echo "<h1>Hangman</h1>";
    $_SESSION['chances'] = 7 - count($_SESSION['wrongLetters']);
    echo '<p> The word is: ' .'<span>' . $wordHin . '</span>' .  '</p>';
    echo '<p id="chances"> You have ' . strval($_SESSION['chances']) .  ' chances left. </p>'; 
    $img = "images/hang" . count($_SESSION['wrongLetters']) . ".png";
    echo "<img id='hangman' src='$img'>";
    
    function checkWinLoss(){
        if ($_SESSION['chances'] <= 0) {
            $_SESSION['game_over'] = true;
            echo "YOU DIED!";
            echo '<span>The word was: ' . chooseWords() . '</span>';
            
        }
    
        if (chooseWords() == replaceRightLetter()) {
            $_SESSION['game_over'] = true;
            echo '<h1>You did it!</h1>';
            echo "<img id='vuurwerk' src='images/vuurwerk.gif'>";
            
        }
    }
    checkWinLoss();
    
    ?>

    <form action="destroy.php" method="post">
        <input type="submit" value="Reset the game and return to main menu." />
    </form>
    <form method="POST" id="letter">
        <?php
if (!isset($_SESSION['game_over'])  == "playing") {

    echo '<p> Letters left: </p>';

    $alphabet = range("A", "Z");

    foreach ($alphabet as $letter) {
        if (!in_array($letter, $_SESSION['rightLetters']) && !in_array($letter, $_SESSION['wrongLetters'])) {
            if ($_SESSION['chances'] > 0) {
                if (chooseWords() != replaceRightLetter()) {
?>
                <input name="playerGuess"
                       id="<?php echo $letter?>"
                       type="submit"
                       value="<?php echo $letter?>"
                       class="letterbutton" />
<?php
                }
            }
        }
    }
}
?>
    </form>



</body>

</html>