<?php

class game {


	var $over;
    var $won;

	/** Etoimazetai to perivalon gia na arxisei to paixnidi **/
	function start()
	{
        $this->player = "X";
        $this->totalMoves = 0;
        $this->newBoard();
		$this->over = false;
		$this->won = false;
	}
	
	/** Telos paixndiou**/
	function end()
	{
		$this->over = true;
	}
	

	/** Epistrefi ama to paixnidi exei teliosi**/
	function isOver()
	{
		if ($this->won)
			return true;
			
		if ($this->over)
			return true;

			
		return false;
	}

}
//end game class



/** Minima lathous **/
function errorMsg($msg)
{
	return "<div class=\"errorMsg\">$msg</div>";
}

/** Minima epitixias **/
function successMsg($msg)
{
	return "<div class=\"successMsg\">$msg</div>";
}