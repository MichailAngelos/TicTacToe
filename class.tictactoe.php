<?php

class tictactoe extends game
{
    var $player = "X";            //seira paikti "X"
    var $board = array();        //o pinakas
    var $totalMoves = 0;        //poses kinisis exoun ginei

    /** Default constructor pou dixnei kai tin enarksi leitourgias tis gonikis klasis**/
    function tictactoe()
    {
        /** KLironomi tis methodous kai xaraktiristika tis klasis game kai kalei tin methodo start **/
        game::start();
        $this->newBoard();
    }

    /** Ekinisi neou paixnidiou  **/
    function newGame()
    {

        $this->start();


        $this->player = "X";
        $this->totalMoves = 0;
        $this->newBoard();
    }

    /** Dimiourgeia adeiou pinaka**/

    function newBoard()
    {


        $this->board = array();

        //dimiorgei to board
        for ($x = 0; $x <= 2; $x++) {
            for ($y = 0; $y <= 2; $y++) {
                $this->board[$x][$y] = null;
            }
        }
    }


    /** Trexei to block tou kwdika mexri na vgei isopalia i kapios na kerdisei **/


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

        //display the game
        $this->displayGame();
    }

    /** Emfanisei tou interface mas**/
    function displayGame()
    {

        //Oso to paixnidi den telinei isOver()
        if (!$this->isOver()) {
            echo "<div id=\"board\">";

            for ($x = 0; $x < 3; $x++) {
                for ($y = 0; $y < 3; $y++) {
                    echo "<div class=\"board_cell\">";

                    //elexi an einai gemati i thesi
                    if ($this->board[$x][$y])
                        echo "<img src=\"/{$this->board[$x][$y]}.jpg\" alt=\"{$this->board[$x][$y]}\" title=\"{$this->board[$x][$y]}\" />";
                    else {
                        //epilogis X i 0
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

            //kapios kerdise i isopalia
            if ($this->isOver() != "Tie")
                echo successMsg("Congratulations player " . $this->isOver() . ", you've won the game!");
            else if ($this->isOver() == "Tie")
                echo errorMsg("Whoops! Looks like you've had a tie game. Want to try again?");

            session_destroy();

            echo "<p align=\"center\"><input type=\"submit\" name=\"newgame\" value=\"New Game\" /></p>";
        }


    }

    /** Kinisis mexri tin liksi tou painxidiou **/

    function move($gamedata)
    {

        if ($this->isOver())
            return;

        //na min exoume dipla sto pinaka(unique)
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
    /** Random gemisma apo Computer **/

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

    /** Elexos nikiti an yparxei allios emfanisei isopalias**/
    function isOver()
    {


//        for($x = 0; $x < count($this->board);$x++){
//            if($count == 3)
//                return true;
//
//            $column = $this->board[$x];
//            $count = 1;
//            for($y = 0; $y < count($column);$y++){
//                if($count == 1){
//                    $value = $column[$y];
//                    continue 2;
//                }
//
//                if($value != $column[$y])
//                    break 2;
//
//                count++;
//            }
//        }
//

        // 1
        if ($this->board[0][0] && $this->board[0][0] == $this->board[0][1] && $this->board[0][1] == $this->board[0][2])
            return $this->board[0][0];

        //2
        if ($this->board[1][0] && $this->board[1][0] == $this->board[1][1] && $this->board[1][1] == $this->board[1][2])
            return $this->board[1][0];

        //3
        if ($this->board[2][0] && $this->board[2][0] == $this->board[2][1] && $this->board[2][1] == $this->board[2][2])
            return $this->board[2][0];

        //prwti stili
        if ($this->board[0][0] && $this->board[0][0] == $this->board[1][0] && $this->board[1][0] == $this->board[2][0])
            return $this->board[0][0];

        //deuteri stili
        if ($this->board[0][1] && $this->board[0][1] == $this->board[1][1] && $this->board[1][1] == $this->board[2][1])
            return $this->board[0][1];

        //triti stili
        if ($this->board[0][2] && $this->board[0][2] == $this->board[1][2] && $this->board[1][2] == $this->board[2][2])
            return $this->board[0][2];

        //prwti diagonios
        if ($this->board[0][0] && $this->board[0][0] == $this->board[1][1] && $this->board[1][1] == $this->board[2][2])
            return $this->board[0][0];

        //deuteri diagonios
        if ($this->board[0][2] && $this->board[0][2] == $this->board[1][1] && $this->board[1][1] == $this->board[2][0])
            return $this->board[0][2];

        if ($this->totalMoves >= 9)
            return "Tie";
    }

}
