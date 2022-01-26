<?php

class tictactoe extends game
{
    var $player = "X";      
    var $board = array();
    var $totalMoves = 0;

    /** Default constructor **/
    function tictactoe()
    {
        game::start();
        $this->newBoard();
    }

    /** Start of the game  **/
    function newGame()
    {

        $this->start();


        $this->player = "X";
        $this->totalMoves = 0;
        $this->newBoard();
    }

    /** Creaton of board **/
    function newBoard()
    {
    $this->board = array();

         for ($x = 0; $x <= 2; $x++) {
            for ($y = 0; $y <= 2; $y++) {
                $this->board[$x][$y] = null;
            }
        }
    }

    function playGame($gamedata)
    {
        if (!$this->isOver() && isset($gamedata['move'])) {
            $this->move($gamedata);
        }


        if (isset($gamedata['newgame'])) {
            $this->newGame();
        }

        if (isset($gamedata['theComputer'])) {
            $this->theComputer();
        }

        $this->displayGame();
    }
	
    function displayGame()
    {

        if (!$this->isOver()) {
            echo "<div id=\"board\">";

            for ($x = 0; $x < 3; $x++) {
                for ($y = 0; $y < 3; $y++) {
                    echo "<div class=\"board_cell\">";

                    //Check position for value
                    if ($this->board[$x][$y])
                        echo "<img src=\"/{$this->board[$x][$y]}.jpg\" alt=\"{$this->board[$x][$y]}\" title=\"{$this->board[$x][$y]}\" />";
                    else {
                        echo "<select name=\"{$x}_{$y}\">
								<option value=\"\"></option>
								<option value=\"{$this->player}\">{$this->player}</option>
							</select>";
                    }
                    echo "</div>";
                }
                echo "<div class=\"break\"></div>";
            }
            echo "
				<p align=\"center\">
					<input type=\"submit\" name=\"move\" value=\"Take Turn\" />
				    <div align==\"right\">	<p align==\"right\"><input type=\"submit\" name=\"newgame\" value=\"New Game\"/></p> </div>
					<div style='alignment: right'><p align==\"right\"><input type=\"submit\" name=\"theComputer\" value=\"Computer\"/></p></div>
					<br/><br/>
					<h2 style='background-color: cadetblue'><b>It's player {$this->player}'s turn.</b></h2>
					</p>
			</div>";
        } else {
		
            if ($this->isOver() != "Tie")
                echo successMsg("Congratulations player " . $this->isOver() . ", you've won the game!");
            else if ($this->isOver() == "Tie")
                echo errorMsg("Whoops! Looks like you've had a tie game. Want to try again?");

            session_destroy();

            echo "<p align=\"center\"><input type=\"submit\" name=\"newgame\" value=\"New Game\" /></p>";
        }
    }

    function move($gamedata)
    {
        if ($this->isOver())
            return;

        $gamedata = array_unique($gamedata);

        foreach ($gamedata as $key => $value) {
            if ($value == $this->player) {
                //enimerosi ama pire tin timis X i O sto pinaka
                $coords = explode("_", $key);
                $this->board[$coords[0]][$coords[1]] = $this->player;

                //allagi seiras ton paikton
                if ($this->player == "X")
                    $this->player = "O";
                else
                    $this->player = "X";

                $this->totalMoves++;
            }
        }

        if ($this->isOver())
            return;
    }
   
     /** Math Random for single player **/
    function theComputer()
    {
        if ($this->player == "X")
            $this->player = "O";
        else
            $this->player = "X";

        $found = false;

        do {
            $x = rand(0, 2);
            $y = rand(0, 2);
            if (!isset($this->board[$x][$y])) {

                $this->board[$x][$y]= 'O';
                $found= true ;
            }
        } while(!$found);

    }

    function isOver()
    {
        // 1 row
        if ($this->board[0][0] && $this->board[0][0] == $this->board[0][1] && $this->board[0][1] == $this->board[0][2])
            return $this->board[0][0];

        //2 row
        if ($this->board[1][0] && $this->board[1][0] == $this->board[1][1] && $this->board[1][1] == $this->board[1][2])
            return $this->board[1][0];

        //3 row
        if ($this->board[2][0] && $this->board[2][0] == $this->board[2][1] && $this->board[2][1] == $this->board[2][2])
            return $this->board[2][0];

        //first column
        if ($this->board[0][0] && $this->board[0][0] == $this->board[1][0] && $this->board[1][0] == $this->board[2][0])
            return $this->board[0][0];

        //second column
        if ($this->board[0][1] && $this->board[0][1] == $this->board[1][1] && $this->board[1][1] == $this->board[2][1])
            return $this->board[0][1];

        //third column
        if ($this->board[0][2] && $this->board[0][2] == $this->board[1][2] && $this->board[1][2] == $this->board[2][2])
            return $this->board[0][2];
	
	//first diagonal line
        if ($this->board[0][0] && $this->board[0][0] == $this->board[1][1] && $this->board[1][1] == $this->board[2][2])
            return $this->board[0][0];

	//second diagonal line    
        if ($this->board[0][2] && $this->board[0][2] == $this->board[1][1] && $this->board[1][1] == $this->board[2][0])
            return $this->board[0][2];

        if ($this->totalMoves >= 9)
            return "Tie";
    }
}
