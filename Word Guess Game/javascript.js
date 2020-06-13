var words3letters = new Array("FUN", "HOT", "APT", "MAD")
var words4letters = new Array("COOL", "EPIC", "RICH", "DOPE")
var words5letters = new Array("SMART", "RIGHT", "LUCKY", "FRESH")
var words6letters = new Array("GENIUS", "LEGEND", "BRIGHT", "WICKED")
var words7letters = new Array("AMAZING", "AWESOME", "PERFECT", "NUCLEAR")
var words8letters = new Array("FLAWLESS", "SKILLFUL", "TALENTED", "POWERFUL")
var words9letters = new Array("BEAUTIFUL", "FANTASTIC", "RIGHTEOUS", "EXPLOSIVE")
var words10letters = new Array("UNDENIABLE", "PERFECTION", "EFFORTLESS", "INFECTIOUS")
var words11letters = new Array("INTELLIGENT", "ADVENTUROUS", "UNBREAKABLE", "EXPERIENCED")
var words12letters = new Array("INTELLECTUAL", "COSMOPOLITAN", "EFFERVESCENT", "IMMEASURABLE")
var words13letters = new Array("REVOLUTIONARY", "EXTRAORDINARY", "KNOWLEDGEABLE", "PHILOSOPHICAL")
var words14letters = new Array("QUINTESSENTIAL", "INDESTRUCTIBLE", "INSURMOUNTABLE", "UNIDENTIFIABLE")
var words15letters = new Array("DISPORPORTIONAL", "CONFRONTATIONAL", "EXPRESSIONISTIC", "NONPROFESSIONAL")
var words16letters = new Array("INEXTINGUISHABLE", "UNCHARACTERISTIC", "INTERCONTINENTAL", "EXTRATERRESTRIAL")
var words17letters = new Array("INDISTINGUIAHABLE", "ELECTROMECHANICAL", "INTERDISCIPLINARY", "DECONSTRUCTIONIST")
var words18letters = new Array("OVERCAPITALISATION", "INTERCOMMUNICATION", "OVERSIMPLIFICAITON", "CHARACTERISTICALLY")
var words19letters = new Array("UNSPORTSMANLIKENESS", "INDIVIDUALISTICALLY", "TRANSCENDENTALISTIC", "COUNTERINTELLIGENCE")
var words20letters = new Array("COUNTERREVOLUTIONARY", "INTERCOMMUNICATIONAL", "COMPARTMENTALIZATION", "PALEOANTHROPOLOGICAL")

var roundNumber = 0;
var answer = "";
var guessesLeft = 0;
var score = 0;
var stars = 0;
var newGame = true;

function prepareRound()
{
    if (roundNumber > 0 || newGame == true)
    {
        document.getElementById("gameWindow").innerHTML = "<h2> Guess the word: </h2>";
        document.getElementById("gameWindow").innerHTML += "<h1 id = \"scrambledWord\"> TESTWORD </h1>";
        document.getElementById("gameWindow").innerHTML += "<h3 id = \"numGuesses\"> You have 3 guesses left. What is your guess? </h3>";
        document.getElementById("gameWindow").innerHTML += "<input type = \"text\" id = \"guessBox\" minlength = 3 maxlength = 20 size = 21 style = \"font-size: 30pt; text-align: center;\"> <br> <br>";
        document.getElementById("gameWindow").innerHTML += "<button id = \"inputButton\" onclick = \"checkAnswer()\"> Guess! </button>";
        newGame = false;
    }
    
    var scrambledWord = document.getElementById("scrambledWord");
    
    switch (roundNumber)
    {
        case 0:
            answer = words3letters[Math.floor(Math.random() * words3letters.length - 1) + 1];
            break;
        case 1:
            answer = words4letters[Math.floor(Math.random() * words4letters.length - 1) + 1];
            break;
        case 2:
            answer = words5letters[Math.floor(Math.random() * words5letters.length - 1) + 1];
            break;
        case 3:
            answer = words6letters[Math.floor(Math.random() * words6letters.length - 1) + 1];
            break;
        case 4:
            answer = words7letters[Math.floor(Math.random() * words7letters.length - 1) + 1];
            break;
        case 5:
            answer = words8letters[Math.floor(Math.random() * words8letters.length - 1) + 1];
            break;
        case 6:
            answer = words9letters[Math.floor(Math.random() * words9letters.length - 1) + 1];
            break;
        case 7:
            answer = words10letters[Math.floor(Math.random() * words10letters.length - 1) + 1];
            break;
        case 8:
            answer = words11letters[Math.floor(Math.random() * words11letters.length - 1) + 1];
            break;
        case 9:
            answer = words12letters[Math.floor(Math.random() * words12letters.length - 1) + 1];
            break;
        case 10:
            answer = words13letters[Math.floor(Math.random() * words13letters.length - 1) + 1];
            break;
        case 11:
            answer = words14letters[Math.floor(Math.random() * words14letters.length - 1) + 1];
            break;
        case 12:
            answer = words15letters[Math.floor(Math.random() * words15letters.length - 1) + 1];
            break;
        case 13:
            answer = words16letters[Math.floor(Math.random() * words16letters.length - 1) + 1];
            break;
        case 14:
            answer = words17letters[Math.floor(Math.random() * words17letters.length - 1) + 1];
            break;
        case 15:
            answer = words18letters[Math.floor(Math.random() * words18letters.length - 1) + 1];
            break;
        case 16:
            answer = words19letters[Math.floor(Math.random() * words19letters.length - 1) + 1];
            break;
        case 17:
            answer = words20letters[Math.floor(Math.random() * words20letters.length - 1) + 1];
            break;
    }

    scrambledWord.innerHTML = shuffle(answer);

    guessesLeft = 3;
    var numGuesses = document.getElementById("numGuesses");
    numGuesses.innerHTML = "You have " + guessesLeft + " guesses left. What is your guess?"

    roundNumber++;
}

function shuffle (word)
{
    var shuffledWord = word.split("");

    for (var i = 0; i < word.length; i++)
    {
        var letter1 = i;
        var letter2 = Math.floor(Math.random() * word.length);

        var temp = shuffledWord[letter1];
        shuffledWord[letter1] = shuffledWord[letter2];
        shuffledWord[letter2] = temp;
    }

    var wordToGuess = shuffledWord.join("");

    if (wordToGuess == word)
    {
        return shuffle(wordToGuess);
    }
    else
    {
        return wordToGuess;
    }
}

function checkAnswer()
{
    var guess = document.getElementById("guessBox").value;
    guess = guess.toUpperCase();

    if (guess == answer)
    {
        document.getElementById("round" + roundNumber + "Word").innerHTML = answer;

        document.getElementById("round" + roundNumber + "Score").innerHTML = Math.floor(answer.length / (4 - guessesLeft) * 10);
        score += Math.floor(answer.length / (4 - guessesLeft) * 10);

        document.getElementById("round" + roundNumber + "Stars").innerHTML = "";
        for (var j = 1; j <= guessesLeft; j++)
        {
            document.getElementById("round" + roundNumber + "Stars").innerHTML += "&#11088;";
        }
        stars += guessesLeft;

        document.getElementById("totalScore").innerHTML = score;
        document.getElementById("totalStars").innerHTML = stars;

        if (roundNumber >= 18)
        {
            var gameWindow = document.getElementById("gameWindow");
            gameWindow.innerHTML = "<h2> Congrats! <br> You guessed the final word! </h2> <h1>"
            document.getElementById("sparkle").play();
            for (var i = 1; i <= guessesLeft; i++)
            {
                gameWindow.innerHTML += "<span> &#11088; </span>"
            }
            gameWindow.innerHTML += "</h1> <h3> You beat the game! </h3>";
            gameWindow.innerHTML += "<button id = \"inputButton\" onclick = \"viewScore()\"> Play Again? </button>";
        }
        else
        {
            var gameWindow = document.getElementById("gameWindow");
            gameWindow.innerHTML = "<h2> Congrats! <br> You guessed the word! </h2> <h1>"
            document.getElementById("sparkle").play();
            for (var i = 1; i <= guessesLeft; i++)
            {
                gameWindow.innerHTML += "<span> &#11088; </span>"
            }
            gameWindow.innerHTML += "</h1> <h3> Proceed to the next round? </h3>";
            gameWindow.innerHTML += "<button id = \"inputButton\" onclick = \"prepareRound()\"> Next Round! </button>";
        }
        
    }
    else
    {
        document.getElementById("guess").play();
        guessesLeft--;

        if (guessesLeft > 0)
        {
            document.getElementById("numGuesses").innerHTML = "You have " + guessesLeft + " guesses left. What is your guess?";
        }
        else
        {
            var gameWindow = document.getElementById("gameWindow");
            gameWindow.innerHTML = "<h2> Oh no! <br> It looks like you lost. </h2>"
            gameWindow.innerHTML += "<img width = \"150px\" height = \"150px\" src = \"sad.png\"/>";
            gameWindow.innerHTML += "<h3> But don't give up! </h3>";
            gameWindow.innerHTML += "<button id = \"inputButton\" onclick = \"viewScore()\"> View Score </button>";
        }
    }
}

function viewScore()
{
    var gameWindow = document.getElementById("gameWindow");
    gameWindow.innerHTML = "<h2> Your final score was: </h2>"
    gameWindow.innerHTML += "<h3> Rounds passed: " + (roundNumber - 1) + "<br>" + "Points Earned: " + score + "<br>" + "Stars Earned: " + stars + "</h3>";
    gameWindow.innerHTML += "<button id = \"inputButton\" onclick = \"restartGame()\"> Play Again? </button>";
}

function restartGame()
{
    roundNumber = 0;
    answer = "";
    guessesLeft = 0;
    score = 0;
    stars = 0;
    newGame = true;

    document.getElementById("roundTable").innerHTML = "<tr> <th width = \"20%\"> Round # </th> <th width = \"50%\"> Word </th> <th width = \"15%\"> Points </th> <th width = \"15%\"> Stars </th> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 1 </td> <td id = \"round1Word\"></td> <td id = \"round1Score\"></td> <td id = \"round1Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 2 </td> <td id = \"round2Word\"></td> <td id = \"round2Score\"></td> <td id = \"round2Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 3 </td> <td id = \"round3Word\"></td> <td id = \"round3Score\"></td> <td id = \"round3Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 4 </td> <td id = \"round4Word\"></td> <td id = \"round4Score\"></td> <td id = \"round4Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 5 </td> <td id = \"round5Word\"></td> <td id = \"round5Score\"></td> <td id = \"round5Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 6 </td> <td id = \"round6Word\"></td> <td id = \"round6Score\"></td> <td id = \"round6Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 7 </td> <td id = \"round7Word\"></td> <td id = \"round7Score\"></td> <td id = \"round7Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 8 </td> <td id = \"round8Word\"></td> <td id = \"round8Score\"></td> <td id = \"round8Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 9 </td> <td id = \"round9Word\"></td> <td id = \"round9Score\"></td> <td id = \"round9Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 10 </td> <td id = \"round10Word\"></td> <td id = \"round10Score\"></td> <td id = \"round10Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 11 </td> <td id = \"round11Word\"></td> <td id = \"round11Score\"></td> <td id = \"round11Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 12 </td> <td id = \"round12Word\"></td> <td id = \"round12Score\"></td> <td id = \"round12Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 13 </td> <td id = \"round13Word\"></td> <td id = \"round13Score\"></td> <td id = \"round13Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 14 </td> <td id = \"round14Word\"></td> <td id = \"round14Score\"></td> <td id = \"round14Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 15 </td> <td id = \"round15Word\"></td> <td id = \"round15Score\"></td> <td id = \"round15Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 16 </td> <td id = \"round16Word\"></td> <td id = \"round16Score\"></td> <td id = \"round16Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 17 </td> <td id = \"round17Word\"></td> <td id = \"round17Score\"></td> <td id = \"round17Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td class = \"identifier\"> Round 18 </td> <td id = \"round18Word\"></td> <td id = \"round18Score\"></td> <td id = \"round18Stars\"></td> </tr>";
    document.getElementById("roundTable").innerHTML += "<tr> <td colspan = 2 class = \"identifier\" style = \"text-align: right;\"> <strong>Total:</strong> </td> <td id = \"totalScore\"> 0 </td> <td id = \"totalStars\"> 0 </td> </tr>";

    prepareRound();
}