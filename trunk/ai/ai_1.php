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

function NumOfPossibleWins($curPlayer, $m)
{
	$count = 32;
	$o = ($curPlayer == '1') ? '2' : '1'; // the opponent player
	
	// check 5, \
	if ($m[0][0] == $o || $m[1][1] == $o || $m[2][2] == $o || $m[3][3] == $o || $m[4][4] == $o)
		--$count;
	if ($m[1][1] == $o || $m[2][2] == $o || $m[3][3] == $o || $m[4][4] == $o || $m[5][5] == $o)
		--$count;
	if ($m[1][0] == $o || $m[2][1] == $o || $m[3][2] == $o || $m[4][3] == $o || $m[5][4] == $o)
		--$count;
	if ($m[0][1] == $o || $m[1][2] == $o || $m[2][3] == $o || $m[3][4] == $o || $m[4][5] == $o)
		--$count;
		
	// check 5, /
	if ($m[0][5] == $o || $m[1][4] == $o || $m[2][3] == $o || $m[3][2] == $o || $m[4][1] == $o)
		--$count;
	if ($m[1][4] == $o || $m[2][3] == $o || $m[3][2] == $o || $m[4][1] == $o || $m[5][0] == $o)
		--$count;
	if ($m[0][4] == $o || $m[1][3] == $o || $m[2][2] == $o || $m[3][1] == $o || $m[4][0] == $o)
		--$count;
	if ($m[1][5] == $o || $m[2][4] == $o || $m[3][3] == $o || $m[4][2] == $o || $m[5][1] == $o)
		--$count;
		
	// check 5, |
	if ($m[0][0] == $o || $m[1][0] == $o || $m[2][0] == $o || $m[3][0] == $o || $m[4][0] == $o)
		--$count;
	if ($m[1][0] == $o || $m[2][0] == $o || $m[3][0] == $o || $m[4][0] == $o || $m[5][0] == $o)
		--$count;
	if ($m[0][1] == $o || $m[1][1] == $o || $m[2][1] == $o || $m[3][1] == $o || $m[4][1] == $o)
		--$count;
	if ($m[1][1] == $o || $m[2][1] == $o || $m[3][1] == $o || $m[4][1] == $o || $m[5][1] == $o)
		--$count;
	if ($m[0][2] == $o || $m[1][2] == $o || $m[2][2] == $o || $m[3][2] == $o || $m[4][2] == $o)
		--$count;
	if ($m[1][2] == $o || $m[2][2] == $o || $m[3][2] == $o || $m[4][2] == $o || $m[5][2] == $o)
		--$count;
	if ($m[0][3] == $o || $m[1][3] == $o || $m[2][3] == $o || $m[3][3] == $o || $m[4][3] == $o)
		--$count;
	if ($m[1][3] == $o || $m[2][3] == $o || $m[3][3] == $o || $m[4][3] == $o || $m[5][3] == $o)
		--$count;
	if ($m[0][4] == $o || $m[1][4] == $o || $m[2][4] == $o || $m[3][4] == $o || $m[4][4] == $o)
		--$count;
	if ($m[1][4] == $o || $m[2][4] == $o || $m[3][4] == $o || $m[4][4] == $o || $m[5][4] == $o)
		--$count;
	if ($m[0][5] == $o || $m[1][5] == $o || $m[2][5] == $o || $m[3][5] == $o || $m[4][5] == $o)
		--$count;
	if ($m[1][5] == $o || $m[2][5] == $o || $m[3][5] == $o || $m[4][5] == $o || $m[5][5] == $o)
		--$count;
		
	// check 5, -
	if ($m[0][0] == $o || $m[0][1] == $o || $m[0][2] == $o || $m[0][3] == $o || $m[0][4] == $o)
		--$count;
	if ($m[0][1] == $o || $m[0][2] == $o || $m[0][3] == $o || $m[0][4] == $o || $m[0][5] == $o)
		--$count;
	if ($m[1][0] == $o || $m[1][1] == $o || $m[1][2] == $o || $m[1][3] == $o || $m[1][4] == $o)
		--$count;
	if ($m[1][1] == $o || $m[1][2] == $o || $m[1][3] == $o || $m[1][4] == $o || $m[1][5] == $o)
		--$count;
	if ($m[2][0] == $o || $m[2][1] == $o || $m[2][2] == $o || $m[2][3] == $o || $m[2][4] == $o)
		--$count;
	if ($m[2][1] == $o || $m[2][2] == $o || $m[2][3] == $o || $m[2][4] == $o || $m[2][5] == $o)
		--$count;
	if ($m[3][0] == $o || $m[3][1] == $o || $m[3][2] == $o || $m[3][3] == $o || $m[3][4] == $o)
		--$count;
	if ($m[3][1] == $o || $m[3][2] == $o || $m[3][3] == $o || $m[3][4] == $o || $m[3][5] == $o)
		--$count;
	if ($m[4][0] == $o || $m[4][1] == $o || $m[4][2] == $o || $m[4][3] == $o || $m[4][4] == $o)
		--$count;
	if ($m[4][1] == $o || $m[4][2] == $o || $m[4][3] == $o || $m[4][4] == $o || $m[4][5] == $o)
		--$count;
	if ($m[5][0] == $o || $m[5][1] == $o || $m[5][2] == $o || $m[5][3] == $o || $m[5][4] == $o)
		--$count;
	if ($m[5][1] == $o || $m[5][2] == $o || $m[5][3] == $o || $m[5][4] == $o || $m[5][5] == $o)
		--$count;
	
	return $count;
}

function minimax($curPlayer, $oppPlayer, $matrix)
{
	for ($c = 0; $c < 6; ++$c) // loop all the y positions
	{
		for ($r = 0; $r < 6; ++$r) // loop all the x positions
		{
			if ($matrix[$c][$r] == '0') // loop all the possible positions
			{
				$matrix_tmp = $matrix;
				$matrix_tmp[$c][$r] = $curPlayer; // place it there
				
				$curPlayerScore[$c][$r] = NumOfPossibleWins($curPlayer, $matrix_tmp); // count how many possible winning arrangement
				
				$oppPlayerScore[$c][$r] = 0;
				for ($i = 1; $i <= 4; ++$i) // for all the possible ways that can turn by opponent
				{
					$posi_matrix[$i][0] = rotate($i, 'l', $matrix_tmp);
					$tmp = NumOfPossibleWins($oppPlayer, $posi_matrix[$i][0]); // count how many possible winning arrangement
					if ($tmp > $oppPlayerScore[$c][$r])
						$oppPlayerScore[$c][$r] = $tmp;
					
					$posi_matrix[$i][1] = rotate($i, 'r', $matrix_tmp);
					$tmp = NumOfPossibleWins($oppPlayer, $posi_matrix[$i][1]); // count how many possible winning arrangement
					if ($tmp > $oppPlayerScore[$c][$r])
						$oppPlayerScore[$c][$r] = $tmp;
				}
				
				$min_max_val[$c][$r] = $curPlayerScore[$c][$r] - $oppPlayerScore[$c][$r];
			}
			else
				$curPlayerScore[$c][$r] = $oppPlayerScore[$c][$r] = $min_max_val[$c][$r] = -999;
		}
	}
	return $min_max_val;
}

$oppPlayer = ($player == '1') ? '2' : '1'; // the opponent player

$lala = minimax($player, $oppPlayer, $matrix_arr2);

for ($c = 0; $c < 6; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] != -999)
		{
			$maxVal = $lala[$c][$r];
			$maxC = $c;
			$maxR = $r;
		}
	}
}

for ($c = 0; $c < 6; ++$c) // loop all the y positions
{
	for ($r = 0; $r < 6; ++$r) // loop all the x positions
	{
		if ($lala[$c][$r] > $maxVal)
		{
			$maxVal = $lala[$c][$r];
			$maxC = $c;
			$maxR = $r;
		}
	}
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

$y = $maxC;
$x = $maxR;

$t = mt_rand(1,4);
$d = mt_rand(0,1) ? 'l' : 'r';
?>