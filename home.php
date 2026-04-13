<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hangman</title>
    <meta name="description" content="Play hangman">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
  
    <h1>Welcome to Hangman</h1>
    <img id="hangmanLogo" src="./images/hangman.png" />
    <form action="chooseCategory.php" method="POST">
        <input type="submit" name="randomWord" value="Play with a random word.">
    </form>   
    <p> OR </p>
    <form action="chooseWord.php" method="POST">
        <input type="submit" name="chooseWord" value="Choose your own word.">
    </form>
</body>

</html>