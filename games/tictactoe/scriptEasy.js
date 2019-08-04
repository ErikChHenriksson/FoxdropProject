/* GLOBAL VARIABLES: 
origBoard, the playfield
huPlayer, user always plays as X
aiPlayer, AI-opponent always plays as O
winCombos, keeps track of the winner.
*/
var origBoard;
const huPlayer = 'X';
const aiPlayer = 'O';
const winCombos = [
	[0,1,2],
	[3,4,5],
	[6,7,8],
	[0,3,6],
	[1,4,7],
	[2,5,8],
	[0,4,8],
	[6,4,2]
]

var gameWon = false;

const cells = document.querySelectorAll('.cell');
startGame();

/* Starts game by pressing left-click, takes away background color from endgame screen */
function startGame() {
	document.querySelector('.endgame').style.display = "none";
	origBoard = Array.from(Array(9).keys());
	gameWon = false;
	for (var i = 0; i < cells.length; i++) {
		cells[i].innerText = '';
		cells[i].style.removeProperty('background-color');
		cells[i].addEventListener('click', turnClick, false);
	}
}


/* Turn is done by left clicking on the mouse. */
function turnClick(square) {
	if (typeof origBoard[square.target.id] == 'number') {
		var clickSound = new Audio("../../soundeffects/tictactoe.mp3");
	    clickSound.play();
		turn(square.target.id, huPlayer)

		if (!gameWon) {	
			if (!checkTie()) {
				turn(bestSpot(), aiPlayer);
			}
		} 
	}
}

function turn(squareId, player) {
	origBoard[squareId] = player;
	document.getElementById(squareId).innerText = player;
	let gameWon = checkWin(origBoard, player)
	if(gameWon) gameOver(gameWon)
}

function checkWin(board, player) {
	// Way to find every index that the player has played in.
	let plays = board.reduce((accumulator, element, index) =>
		(element === player) ? accumulator.concat(index) : accumulator, []);

	let gameWon = null;
	
	// Array iterator, "winCombos.entries()"
	for(let [index, win] of winCombos.entries()) {
		if(win.every(elem => plays.indexOf(elem) > -1)) {
			// Player has won
			gameWon = {index, player, player: player};
			break;
		}
	}
	return gameWon;
}

function gameOver(gameWon) {
	for (let index of winCombos[gameWon.index]) {
		document.getElementById(index).style.backgroundColor = 
			gameWon.player == huPlayer ? "green" : "red";
	}
	for(var i = 0; i < cells.length; i++){
		cells[i].removeEventListener('click', turnClick, false);
	}
	declareWinner(gameWon.player == huPlayer ? "You win!" : "You lose!");
}

function declareWinner(who) {
	gameWon = true;
	console.log(who);
	document.querySelector(".endgame").style.display = "block";
	document.querySelector(".endgame .text").innerText = who;
}

function emptySquares() {
	return origBoard.filter(s => typeof s == 'number');
}





function bestSpot() {
	return minimax(origBoard, aiPlayer).index;
}

function checkTie() {
	if (emptySquares().length == 0) {
		for (var i = 0; i < cells.length; i++) {
			cells[i].style.backgroundColor = "orange";
			cells[i].removeEventListener('click', turnClick, false);
		}
		declareWinner("Tie Game!")
		return true;
	}
	return false;
}

/* Algorithm to create a smart AI opponent that tries to do the optimal move */
function minimax(newBoard, player) {
	var availSpots = emptySquares(newBoard);

	if (checkWin(newBoard, player)) {	
		return {score: -10};
	} 
	else if (checkWin(newBoard, aiPlayer)) {
		return {score: 20};
	} 
	else if (availSpots.length === 0){
		return {score: 0};
	}

	var moves = [];
	for (var i = 0; i < availSpots.length; i++) {
		var move = {};
		move.index = newBoard[availSpots[i]];
		newBoard[availSpots[i]] = player;

		if (player == aiPlayer) {
			var result = minimax(newBoard, huPlayer);
			move.score = result.score;
		} 
		else {
			var result = minimax(newBoard, aiPlayer);
			move.score = result.score;
		}

		newBoard[availSpots[i]] = move.index;

		moves.push(move);
	}

	var bestMove;
	if (player === aiPlayer) {
		var bestScore = -10000;
		for (var i = 0; i < moves.length; i++) {
			if (moves[i].score > bestScore) {
				bestScore = moves[i].score;
				bestMove = i;
			}
		}
	} 
	else {
		var bestScore = 10000;
		for (var i = 0; i < moves.length; i++) {
			if (moves[i].score < bestScore) {
				bestScore = moves[i].score;
				bestMove = i;
			}
		}
	}
	return moves[bestMove];
}
