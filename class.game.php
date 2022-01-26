<?php

class game {


	var $over;
    var $won;

	/** Preparing game **/
	function start()
	{
        $this->player = "X";
        $this->totalMoves = 0;
        $this->newBoard();
		$this->over = false;
		$this->won = false;
	}
	
	/** When game is over **/
	function end()
	{
		$this->over = true;
	}
	

	/** True when the game is over**/
	function isOver()
	{
		if ($this->won)
			return true;
			
		if ($this->over)
			return true;

			
		return false;
	}

}


/** Error Message **/
function errorMsg($msg)
{
	return "<div class=\"errorMsg\">$msg</div>";
}

/** Success Message **/
function successMsg($msg)
{
	return "<div class=\"successMsg\">$msg</div>";
}
