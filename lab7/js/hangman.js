function startGame(){
    pickWord();
    initBoard();
    updateBoard();
}
function initBoard(){
    for (var letter in selectedWord){
        board.push("_");
    }
}

function pickWord(){
    var randInt = Math.floor(Math.random()*words.length);
    selectedWord = words[randInt].word.toUpperCase();
    selectedHint = words[randInt].hint;
}

function updateBoard(){
    //document.getElementById("word").innerHTML = "";
    $("#word").empty();
    
    for (var letter of board){
        document.getElementById("word").innerHTML += letter + " ";
    }
}

function updateWord(positions, letter){
    for (var index of positions){
        board[index] = letter;
    }
    updateBoard();
}

function createLetters(){
    for (var letter of alphabet){
        $("#letters").append("<button class='letter btn btn-success' id='" + letter + "'>" + letter + "</buttons>");
    }
}

function updateMan(){
    $("#hangImg").attr("src","img/stick_"+(6-remainingGuesses)+".png");
}

function disableButton(btn){
    btn.prop("disabled", true);
    btn.attr("class", "btn btn-danger");
}

function checkLetters(letter){
    var positions = [];
    console.log("Checking if word "+selectedWord+" contains letter "+ letter);
    for (var i = 0; i < selectedWord.length; i++){
        if (letter == selectedWord[i]){
            positions.push(i);
        }
    }
    if (positions.length > 0){
        //Letter is in the word
        updateWord(positions, letter);
        if (!board.includes('_')){
            endGame(true);
        }
    }
    else{
        //Letter is not in the word
        remainingGuesses -= 1;
        updateMan();
        if (remainingGuesses <= 0){
            endGame(false);
        }
    }
}

function endGame(win){
    $("#letters").hide();
    $("#hintAreagit ").hide();
    if (win){
        $("#won").show();
    }
    else{
        $("#lost").show();
    }
}
var alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
var selectedWord = "";
var selectedHint = "";
var board = [];
var remainingGuesses = 6;
var words = [{word: "apple", hint: "It's a fruit"},
            {word: "snake" ,hint: "it's a reptile"}, 
            {word: "monkey", hint: "It's a mammal"}, 
            {word: "beetle", hint: "It's an insect"}];
window.onLoad = startGame();

createLetters();

$(".letter").click(
    function(){
        var Val= $(this).attr("id");
        console.log("Button pressed, value = " + Val);
        checkLetters(Val);
        disableButton($(this));
    }
)

$(".hintBtn").click(
    function(){
        remainingGuesses -= 1;
        $("#hintArea").append("<span class='hint'>"+selectedHint+"</span>");
        $(".hint").show();
        $(".hintBtn").hide();
        updateMan();
    }
)

$(".replayBtn").on("click",    
    function(){
        location.reload();
    })

