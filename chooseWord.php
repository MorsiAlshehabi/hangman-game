<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hangman</title>
    <meta name="description" content="Play hangman">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Choose your Hangman word.</h1>
    <form action="galgje.php" method="POST">
        <label for="chosenWord">Hangman word:</label>
        <input type="text" id="chosenWord" name="writeword" placeholder="Enter your word" pattern="[a-zA-Z]{3,}" required><br>
        <input type="submit" name="chooseWord" value="Submit">
    </form>
</body>

</html>