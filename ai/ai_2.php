<?php
function rotate($subGridId, $dir, $matrix)
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
			$final_matrix[0][3] = $matrix[2][3];
			$final_matrix[0][4] = $matrix[1][3];
			$final_matrix[0][5] = $matrix[2][2];
			$final_matrix[1][3] = $matrix[0][3];
			$final_matrix[1][5] = $matrix[0][4];
			$final_matrix[2][3] = $matrix[2][5];
			$final_matrix[2][4] = $matrix[1][5];
			$final_matrix[2][5] = $matrix[0][5];
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
			$final_matrix[3][0] = $matrix[5][0];
			$final_matrix[3][1] = $matrix[4][0];
			$final_matrix[3][2] = $matrix[3][0];
			$final_matrix[4][0] = $matrix[5][1];
			$final_matrix[4][2] = $matrix[4][2];
			$final_matrix[5][0] = $matrix[5][0];
			$final_matrix[5][1] = $matrix[5][1];
			$final_matrix[5][2] = $matrix[5][2];
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

function NumOfPossibleWins($c, $m) // To calculate value for current player, $c = opponent player id
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