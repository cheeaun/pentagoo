<?php
<<<<<<< .mine
function Rotate($subGridId, $dir, $matrix)
=======
function rotate($subGridId, $dir, $matrix)
>>>>>>> .r30
{
	$final_matrix = $matrix;
	switch($subGridId)
	{
	case 1:
		if ($dir == 'l')
		{
			$final_matrix[0][0] = $matrix[0][2];
			$final_matrix[0][1] = $matrix[1][2];
			$final_matrix[0][2] = $matrix[2][2];
			$final_matrix[1][0] = $matrix[0][1];
			$final_matrix[1][2] = $matrix[2][1];
			$final_matrix[2][0] = $matrix[0][0];
			$final_matrix[2][1] = $matrix[1][0];
			$final_matrix[2][2] = $matrix[2][0];
		}
		else if ($dir == 'r')
		{
			$final_matrix[0][0] = $matrix[2][0];
			$final_matrix[0][1] = $matrix[1][0];
			$final_matrix[0][2] = $matrix[0][0];
			$final_matrix[1][0] = $matrix[2][1];
			$final_matrix[1][2] = $matrix[0][1];
			$final_matrix[2][0] = $matrix[2][2];
			$final_matrix[2][1] = $matrix[1][2];
			$final_matrix[2][2] = $matrix[0][1];
		}
		break;
	case 2:
		if ($dir == 'l')
		{
			$final_matrix[0][3] = $matrix[0][5];
			$final_matrix[0][4] = $matrix[1][2];
			$final_matrix[0][5] = $matrix[2][5];
			$final_matrix[1][3] = $matrix[0][4];
			$final_matrix[1][5] = $matrix[2][4];
			$final_matrix[2][3] = $matrix[0][3];
			$final_matrix[2][4] = $matrix[1][3];
			$final_matrix[2][5] = $matrix[2][3];
		}
		else if ($dir == 'r')
		{
<<<<<<< .mine
			$final_matrix[0][3] = $matrix[2][3];
			$final_matrix[0][4] = $matrix[1][3];
			$final_matrix[0][5] = $matrix[0][3];
			$final_matrix[1][3] = $matrix[2][4];
			$final_matrix[1][5] = $matrix[0][4];
			$final_matrix[2][3] = $matrix[2][5];
			$final_matrix[2][4] = $matrix[1][5];
			$final_matrix[2][5] = $matrix[0][5];
=======
			$final_matrix[0][3] = $matrix[2][3];
			$final_matrix[0][4] = $matrix[1][3];
			$final_matrix[0][5] = $matrix[2][2];
			$final_matrix[1][3] = $matrix[0][3];
			$final_matrix[1][5] = $matrix[0][4];
			$final_matrix[2][3] = $matrix[2][5];
			$final_matrix[2][4] = $matrix[1][5];
			$final_matrix[2][5] = $matrix[0][5];
>>>>>>> .r30
		}
		break;
	case 3:
		if ($dir == 'l')
		{
			$final_matrix[3][0] = $matrix[3][2];
			$final_matrix[3][1] = $matrix[4][2];
			$final_matrix[3][2] = $matrix[5][2];
			$final_matrix[4][0] = $matrix[3][1];
			$final_matrix[4][2] = $matrix[5][1];
			$final_matrix[5][0] = $matrix[3][0];
			$final_matrix[5][1] = $matrix[4][0];
			$final_matrix[5][2] = $matrix[5][0];
		}
		else if ($dir == 'r')
		{
<<<<<<< .mine
			$final_matrix[3][0] = $matrix[5][0];
			$final_matrix[3][1] = $matrix[4][0];
			$final_matrix[3][2] = $matrix[3][0];
			$final_matrix[4][0] = $matrix[5][1];
			$final_matrix[4][2] = $matrix[3][1];
			$final_matrix[5][0] = $matrix[5][2];
			$final_matrix[5][1] = $matrix[4][2];
			$final_matrix[5][2] = $matrix[3][2];
=======
			$final_matrix[3][0] = $matrix[5][0];
			$final_matrix[3][1] = $matrix[4][0];
			$final_matrix[3][2] = $matrix[3][0];
			$final_matrix[4][0] = $matrix[5][1];
			$final_matrix[4][2] = $matrix[4][2];
			$final_matrix[5][0] = $matrix[5][0];
			$final_matrix[5][1] = $matrix[5][1];
			$final_matrix[5][2] = $matrix[5][2];
>>>>>>> .r30
		}
		break;
	case 4:
		if ($dir == 'l')
		{
			$final_matrix[3][3] = $matrix[3][5];
			$final_matrix[3][4] = $matrix[4][5];
			$final_matrix[3][5] = $matrix[5][5];
			$final_matrix[4][3] = $matrix[4][3];
			$final_matrix[4][5] = $matrix[5][4];
			$final_matrix[5][3] = $matrix[3][3];
			$final_matrix[5][4] = $matrix[4][3];
			$final_matrix[5][5] = $matrix[5][3];
		}
		else if ($dir == 'r')
		{
			$final_matrix[3][3] = $matrix[5][3];
			$final_matrix[3][4] = $matrix[4][3];
			$final_matrix[3][5] = $matrix[3][3];
			$final_matrix[4][3] = $matrix[5][4];
			$final_matrix[4][5] = $matrix[3][4];
			$final_matrix[5][3] = $matrix[5][5];
			$final_matrix[5][4] = $matrix[4][5];
			$final_matrix[5][5] = $matrix[3][5];
		}
		break;
	}
	return $final_matrix;
}
<<<<<<< .mine
function NumOfPossibleWins($c, $m) // To calculate value for current player, $c = opponent player id
=======

function NumOfPossibleWins($c, $m) // To calculate value for current player, $c = opponent player id
>>>>>>> .r30
{
	$count = 32;
	
	// check 5, \
	if ($m[0][0] == $c || $m[1][1] == $c || $m[2][2] == $c || $m[3][3] == $c || $m[4][4] == $c)
		--$count;
	if ($m[1][1] == $c || $m[2][2] == $c || $m[3][3] == $c || $m[4][4] == $c || $m[5][5] == $c)
		--$count;
	if ($m[1][0] == $c || $m[2][1] == $c || $m[3][2] == $c || $m[4][3] == $c || $m[5][4] == $c)
		--$count;
	if ($m[0][1] == $c || $m[1][2] == $c || $m[2][3] == $c || $m[3][4] == $c || $m[4][5] == $c)
		--$count;
		
	// check 5, /
	if ($m[0][5] == $c || $m[1][4] == $c || $m[2][3] == $c || $m[3][2] == $c || $m[4][1] == $c)
		--$count;
	if ($m[1][4] == $c || $m[2][3] == $c || $m[3][2] == $c || $m[4][1] == $c || $m[5][0] == $c)
		--$count;
	if ($m[0][4] == $c || $m[1][3] == $c || $m[2][2] == $c || $m[3][1] == $c || $m[4][0] == $c)
		--$count;
	if ($m[1][5] == $c || $m[2][4] == $c || $m[3][3] == $c || $m[4][2] == $c || $m[5][1] == $c)
		--$count;
		
	// check 5, |
	if ($m[0][0] == $c || $m[1][0] == $c || $m[2][0] == $c || $m[3][0] == $c || $m[4][0] == $c)
		--$count;
	if ($m[1][0] == $c || $m[2][0] == $c || $m[3][0] == $c || $m[4][0] == $c || $m[5][0] == $c)
		--$count;
	if ($m[0][1] == $c || $m[1][1] == $c || $m[2][1] == $c || $m[3][1] == $c || $m[4][1] == $c)
		--$count;
	if ($m[1][1] == $c || $m[2][1] == $c || $m[3][1] == $c || $m[4][1] == $c || $m[5][1] == $c)
		--$count;
	if ($m[0][2] == $c || $m[1][2] == $c || $m[2][2] == $c || $m[3][2] == $c || $m[4][2] == $c)
		--$count;
	if ($m[1][2] == $c || $m[2][2] == $c || $m[3][2] == $c || $m[4][2] == $c || $m[5][2] == $c)
		--$count;
	if ($m[0][3] == $c || $m[1][3] == $c || $m[2][3] == $c || $m[3][3] == $c || $m[4][3] == $c)
		--$count;
	if ($m[1][3] == $c || $m[2][3] == $c || $m[3][3] == $c || $m[4][3] == $c || $m[5][3] == $c)
		--$count;
	if ($m[0][4] == $c || $m[1][4] == $c || $m[2][4] == $c || $m[3][4] == $c || $m[4][4] == $c)
		--$count;
	if ($m[1][4] == $c || $m[2][4] == $c || $m[3][4] == $c || $m[4][4] == $c || $m[5][4] == $c)
		--$count;
	if ($m[0][5] == $c || $m[1][5] == $c || $m[2][5] == $c || $m[3][5] == $c || $m[4][5] == $c)
		--$count;
	if ($m[1][5] == $c || $m[2][5] == $c || $m[3][5] == $c || $m[4][5] == $c || $m[5][5] == $c)
		--$count;
		
	// check 5, -
	if ($m[0][0] == $c || $m[0][1] == $c || $m[0][2] == $c || $m[0][3] == $c || $m[0][4] == $c)
		--$count;
	if ($m[0][1] == $c || $m[0][2] == $c || $m[0][3] == $c || $m[0][4] == $c || $m[0][5] == $c)
		--$count;
	if ($m[1][0] == $c || $m[1][1] == $c || $m[1][2] == $c || $m[1][3] == $c || $m[1][4] == $c)
		--$count;
	if ($m[1][1] == $c || $m[1][2] == $c || $m[1][3] == $c || $m[1][4] == $c || $m[1][5] == $c)
		--$count;
	if ($m[2][0] == $c || $m[2][1] == $c || $m[2][2] == $c || $m[2][3] == $c || $m[2][4] == $c)
		--$count;
	if ($m[2][1] == $c || $m[2][2] == $c || $m[2][3] == $c || $m[2][4] == $c || $m[2][5] == $c)
		--$count;
	if ($m[3][0] == $c || $m[3][1] == $c || $m[3][2] == $c || $m[3][3] == $c || $m[3][4] == $c)
		--$count;
	if ($m[3][1] == $c || $m[3][2] == $c || $m[3][3] == $c || $m[3][4] == $c || $m[3][5] == $c)
		--$count;
	if ($m[4][0] == $c || $m[4][1] == $c || $m[4][2] == $c || $m[4][3] == $c || $m[4][4] == $c)
		--$count;
	if ($m[4][1] == $c || $m[4][2] == $c || $m[4][3] == $c || $m[4][4] == $c || $m[4][5] == $c)
		--$count;
	if ($m[5][0] == $c || $m[5][1] == $c || $m[5][2] == $c || $m[5][3] == $c || $m[5][4] == $c)
		--$count;
	if ($m[5][1] == $c || $m[5][2] == $c || $m[5][3] == $c || $m[5][4] == $c || $m[5][5] == $c)
		--$count;
	
	return $count;
}
function CountNumOfEmpty($matrix)
{
	$numOfEmpty = 0;
	
	for ($c = 0; $c < 6; ++$c) // loop all the y positions
		for ($r = 0; $r < 6; ++$r) // loop all the x positions
			if ($matrix[$c][$r] == '0')
				++$numOfEmpty;
	
	return $numOfEmpty;
}
function MiniMaxFull($curPlayer, $oppPlayer, $ply, $matrix)
{
	
}
function MiniMaxInternal($curPlayer, $oppPlayer, $playerToPut, $matrix)
{
	$min_max_val = 0;
	
	for ($c = 0; $c < 6; ++$c) // loop all the y positions
	{
		for ($r = 0; $r < 6; ++$r) // loop all the x positions
		{
			if ($matrix[$c][$r] == '0') // loop all the empty positions
			{
				$matrix_tmp[$c][$r] = $playerToPut; // place it there

<<<<<<< .mine
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(1, 'l', $matrix_tmp)); // count num possible winning arrangement
				$curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(1, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(2, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(2, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(3, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(3, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(4, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(4, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore)
					 $curPlayerScore = $tmp;
					
				////////////////////////////////////////////////////////////////////////////////////////////////////////////

				$tmp = NumOfPossibleWins($curPlayer, Rotate(1, 'l', $matrix_tmp)); // count num possible winning arrangement
				$oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(1, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(2, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(2, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(3, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(3, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(4, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(4, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore)
					 $oppPlayerScore = $tmp;
					
				//$curPlayerScore = NumOfPossibleWins($oppPlayer, $matrix_tmp); // count num possible winning arrangement
				
				$min_max_val += $curPlayerScore - $oppPlayerScore;
			}

			$matrix_tmp = $matrix;
		}
	}
	return $min_max_val;
}
function MiniMax($curPlayer, $oppPlayer, $matrix)
{
	for ($c = 0; $c < 6; ++$c) // loop all the y positions
	{
		for ($r = 0; $r < 6; ++$r) // loop all the x positions
		{
			if ($matrix[$c][$r] == '0') // loop all the empty positions
			{
				$matrix_tmp[$c][$r] = $curPlayer; // place it there
				
				$tmp = NumOfPossibleWins($oppPlayer, $matrix_tmp); // count num possible winning arrangement
				$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(1, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(2, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(2, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(3, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(3, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(4, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($oppPlayer, Rotate(4, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp > $curPlayerScore[$c][$r])
					$curPlayerScore[$c][$r] = $tmp;
								
				////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(1, 'l', $matrix_tmp)); // count num possible winning arrangement
				$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(1, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(2, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(2, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(3, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(3, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(4, 'l', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, Rotate(4, 'r', $matrix_tmp)); // count num possible winning arrangement
				if ($tmp < $oppPlayerScore[$c][$r])
					 $oppPlayerScore[$c][$r] = $tmp;
					 
				//$curPlayerScore[$c][$r] = NumOfPossibleWins($oppPlayer, $matrix_tmp); // count num possible winning arrangement
				//$oppPlayerScore[$c][$r] = NumOfPossibleWins($curPlayer, $matrix_tmp); // count num possible winning arrangement
				
				$min_max_val[$c][$r] = $curPlayerScore[$c][$r] - $oppPlayerScore[$c][$r];
			}
			else
				$min_max_val[$c][$r] = -99999;
			
			$min_max_val[$c][$r] += MiniMaxInternal($curPlayer, $oppPlayer, $oppPlayer, $matrix_tmp);
			
			$matrix_tmp = $matrix;
		}
	}
	
	return $min_max_val;
}

$oppPlayer = ($player == '1') ? '2' : '1'; // the opponent player
$lala = MiniMax($player, $oppPlayer, $matrix_arr2);

$breakFlag = false;
for ($c = 0; $c < 6 && $breakFlag == false; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] != -99999)
		{
			$maxVal = $lala[$c][$r];
			$maxC = $c;
			$maxR = $r;
			$breakFlag = true;
			break;
		}
	}
}

for ($c = 0; $c < 6; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] > $maxVal && $lala[$c][$r] != -99999)
		{
			$maxVal = $lala[$c][$r];
			$maxC = $c;
			$maxR = $r;
		}
	}
}

$i = 0;
for ($c = 0; $c < 6; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] == $maxVal)
		{
			$poss_c[$i] = $c;
			$poss_r[$i] = $r;
			++$i;
		}
	}
}

mt_srand();
$rnd = mt_rand(0, count($poss_c) - 1);

$y = $poss_c[$rnd];
$x = $poss_r[$rnd];

function MiniMax2($curPlayer, $oppPlayer, $matrix)
{
	$posi_matrix = Rotate(1, 'l', $matrix);
	$min_max_val[0] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(1, 'r', $matrix);
	$min_max_val[1] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(2, 'l', $matrix);
	$min_max_val[2] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(2, 'r', $matrix);
	$min_max_val[3] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(3, 'l', $matrix);
	$min_max_val[4] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(3, 'r', $matrix);
	$min_max_val[5] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(4, 'l', $matrix);
	$min_max_val[6] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = Rotate(4, 'r', $matrix);
	$min_max_val[7] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);

	return $min_max_val;
}

$matrix_arr2[$y][$x] = $player; // place it

$lala2 = MiniMax2($player, $oppPlayer, $matrix_arr2);

$maxLala2 = $lala2[0];
for ($i = 1; $i < count($lala2); ++$i)
	if ($lala2[$i] > $maxLala2) // Find the max minimax value
		$maxLala2 = $lala2[$i];

$j = 0;
for ($i = 0; $i < count($lala2); ++$i) // loop all the y positions
{
	if ($lala2[$i] == $maxLala2)
	{
		switch($lala2[$i])
		{
		case 0:
			$poss_t[$j] = 1;
			$poss_d[$j] = 'l';
			break;
		case 1:
			$poss_t[$j] = 1;
			$poss_d[$j] = 'r';
			break;
		case 2:
			$poss_t[$j] = 2;
			$poss_d[$j] = 'l';
			break;
		case 3:
			$poss_t[$j] = 2;
			$poss_d[$j] = 'r';
			break;
		case 4:
			$poss_t[$j] = 3;
			$poss_d[$j] = 'l';
			break;
		case 5:
			$poss_t[$j] = 3;
			$poss_d[$j] = 'r';
			break;
		case 6:
			$poss_t[$j] = 4;
			$poss_d[$j] = 'l';
			break;
		case 7:
			$poss_t[$j] = 4;
			$poss_d[$j] = 'r';
			break;
		default:
			$poss_t[$j] = mt_rand(1,4);
			$poss_d[$j] = mt_rand(0,1) ? 'l' : 'r';
		}
		++$j;
	}
}

$rnd = mt_rand(0, count($poss_t) - 1);

$t = $poss_t[$rnd];
$d = $poss_d[$rnd];

/*
=======
function minimax($curPlayer, $oppPlayer, $matrix)
{
	for ($c = 0; $c < 6; ++$c) // loop all the y positions
	{
		for ($r = 0; $r < 6; ++$r) // loop all the x positions
		{
			if ($matrix[$c][$r] == '0') // loop all the empty positions
			{
				$matrix_tmp = $matrix;
				$matrix_tmp[$c][$r] = $curPlayer; // place it there
				
				$curPlayerScore[$c][$r] = NumOfPossibleWins($oppPlayer, $matrix_tmp); // count how many possible winning arrangement
				
				$oppPlayerScore[$c][$r] = 0;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(1, 'l', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(1, 'r', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(2, 'l', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(2, 'r', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(3, 'l', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(3, 'r', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(4, 'l', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$tmp = NumOfPossibleWins($curPlayer, rotate(4, 'r', $matrix_tmp)); // count how many possible winning arrangement
				if ($tmp > $oppPlayerScore[$c][$r])
					$oppPlayerScore[$c][$r] = $tmp;
				
				$min_max_val[$c][$r] = $curPlayerScore[$c][$r] - $oppPlayerScore[$c][$r];
			}
		}
	}
	return $min_max_val;
}

$oppPlayer = ($player == '1') ? '2' : '1'; // the opponent player
$lala = minimax($player, $oppPlayer, $matrix_arr2);

for ($c = 0; $c < 6; ++$c) // loop all the y positions
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
		if ($matrix_arr2[$c][$r] != '0')
			$lala[$c][$r] = -99999;

$breakFlag = false;
for ($c = 0; $c < 6 && $breakFlag == false; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] != -99999)
		{
			$maxVal = $lala[$c][$r];
			$maxC = $c;
			$maxR = $r;
			$breakFlag = true;
			break;
		}
	}
}

for ($c = 0; $c < 6; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] > $maxVal && $lala[$c][$r] != -99999)
		{
			$maxVal = $lala[$c][$r];
			$maxC = $c;
			$maxR = $r;
		}
	}
}

$i = 0;
for ($c = 0; $c < 6; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] == $maxVal)
		{
			$poss_c[$i] = $c;
			$poss_r[$i] = $r;
			++$i;
		}
	}
}

mt_srand();
$y = mt_rand(0, count($poss_c) - 1);
$x = mt_rand(0, count($poss_r) - 1);

$y = $poss_c[$y];
$x = $poss_r[$x];

$y = $maxC;
$x = $maxR;

function minimax2($curPlayer, $oppPlayer, $matrix)
{
	$posi_matrix = rotate(1, 'l', $matrix);
	$min_max_val[0] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(1, 'r', $matrix);
	$min_max_val[1] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(2, 'l', $matrix);
	$min_max_val[2] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(2, 'r', $matrix);
	$min_max_val[3] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(3, 'l', $matrix);
	$min_max_val[4] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(3, 'r', $matrix);
	$min_max_val[5] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(4, 'l', $matrix);
	$min_max_val[6] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);
	
	$posi_matrix = rotate(4, 'r', $matrix);
	$min_max_val[7] = NumOfPossibleWins($oppPlayer, $posi_matrix) - NumOfPossibleWins($curPlayer, $posi_matrix);

	return $min_max_val;
}

$matrix_arr2[$y][$x] = $player; // place it

$lala2 = minimax2($player, $oppPlayer, $matrix_arr2);

$maxLala2 = $lala2[0];

for ($i = 1; $i < 8; ++$i)
	if ($lala2[$i] > $maxLala2)
		$maxLala2 = $lala2[$i];

switch($maxLala2)
{
case 0:
	$t = 1;
	$d = 'l';
	break;
case 1:
	$t = 1;
	$d = 'r';
	break;
case 2:
	$t = 2;
	$d = 'l';
	break;
case 3:
	$t = 2;
	$d = 'r';
	break;
case 4:
	$t = 3;
	$d = 'l';
	break;
case 5:
	$t = 3;
	$d = 'r';
	break;
case 6:
	$t = 4;
	$d = 'l';
	break;
case 7:
	$t = 4;
	$d = 'r';
	break;
default:
	$t = 4;
	$d = 'r';
}

/*
>>>>>>> .r30
// Randomizer AI
mt_srand();
do
{
	$x = mt_rand(0,5);
	$y = mt_rand(0,5);
}
while($matrix_arr2[$y][$x] != 0);
*/

//$t = mt_rand(1,4);
//$d = mt_rand(0,1) ? 'l' : 'r';
?>