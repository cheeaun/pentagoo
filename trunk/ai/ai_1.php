<?php
function rotate($subGridId, $dir)
{
	$final_matrix = $matrix_arr2;
	switch($subGridId)
	{
	case 1:
		if ($dir == 'l')
		{
			$final_matrix[0][0] = $matrix_arr2[0][2];
			$final_matrix[0][1] = $matrix_arr2[1][2];
			$final_matrix[0][2] = $matrix_arr2[2][2];
			$final_matrix[1][0] = $matrix_arr2[0][1];
			$final_matrix[1][2] = $matrix_arr2[2][1];
			$final_matrix[2][0] = $matrix_arr2[0][0];
			$final_matrix[2][1] = $matrix_arr2[1][0];
			$final_matrix[2][2] = $matrix_arr2[2][0];
		}
		else if ($dir == 'r')
		{
			$final_matrix[0][0] = $matrix_arr2[2][0];
			$final_matrix[0][1] = $matrix_arr2[1][0];
			$final_matrix[0][2] = $matrix_arr2[0][0];
			$final_matrix[1][0] = $matrix_arr2[2][1];
			$final_matrix[1][2] = $matrix_arr2[0][1];
			$final_matrix[2][0] = $matrix_arr2[2][2];
			$final_matrix[2][1] = $matrix_arr2[1][2];
			$final_matrix[2][2] = $matrix_arr2[0][1];
		}
		break;
	case 2:
		if ($dir == 'l')
		{
			$final_matrix[0][3] = $matrix_arr2[0][5];
			$final_matrix[0][4] = $matrix_arr2[1][2];
			$final_matrix[0][5] = $matrix_arr2[2][5];
			$final_matrix[1][3] = $matrix_arr2[0][4];
			$final_matrix[1][5] = $matrix_arr2[2][4];
			$final_matrix[2][3] = $matrix_arr2[0][3];
			$final_matrix[2][4] = $matrix_arr2[1][3];
			$final_matrix[2][5] = $matrix_arr2[2][3];
		}
		else if ($dir == 'r')
		{
			$final_matrix[0][3] = $matrix_arr2[2][3];
			$final_matrix[0][4] = $matrix_arr2[1][3];
			$final_matrix[0][5] = $matrix_arr2[2][2];
			$final_matrix[1][3] = $matrix_arr2[0][3];
			$final_matrix[1][5] = $matrix_arr2[0][4];
			$final_matrix[2][3] = $matrix_arr2[2][5];
			$final_matrix[2][4] = $matrix_arr2[1][5];
			$final_matrix[2][5] = $matrix_arr2[0][5];
		}
		break;
	case 3:
		if ($dir == 'l')
		{
			$final_matrix[3][0] = $matrix_arr2[3][2];
			$final_matrix[3][1] = $matrix_arr2[4][2];
			$final_matrix[3][2] = $matrix_arr2[5][2];
			$final_matrix[4][0] = $matrix_arr2[3][1];
			$final_matrix[4][2] = $matrix_arr2[5][1];
			$final_matrix[5][0] = $matrix_arr2[3][0];
			$final_matrix[5][1] = $matrix_arr2[4][0];
			$final_matrix[5][2] = $matrix_arr2[5][0];
		}
		else if ($dir == 'r')
		{
			$final_matrix[3][0] = $matrix_arr2[5][0];
			$final_matrix[3][1] = $matrix_arr2[4][0];
			$final_matrix[3][2] = $matrix_arr2[3][0];
			$final_matrix[4][0] = $matrix_arr2[5][1];
			$final_matrix[4][2] = $matrix_arr2[4][2];
			$final_matrix[5][0] = $matrix_arr2[5][0];
			$final_matrix[5][1] = $matrix_arr2[5][1];
			$final_matrix[5][2] = $matrix_arr2[5][2];
		}
		break;
	case 4:
		if ($dir == 'l')
		{
			$final_matrix[3][3] = $matrix_arr2[3][5];
			$final_matrix[3][4] = $matrix_arr2[4][5];
			$final_matrix[3][5] = $matrix_arr2[5][5];
			$final_matrix[4][3] = $matrix_arr2[4][3];
			$final_matrix[4][5] = $matrix_arr2[5][4];
			$final_matrix[5][3] = $matrix_arr2[3][3];
			$final_matrix[5][4] = $matrix_arr2[4][3];
			$final_matrix[5][5] = $matrix_arr2[5][3];
		}
		else if ($dir == 'r')
		{
			$final_matrix[3][3] = $matrix_arr2[5][3];
			$final_matrix[3][4] = $matrix_arr2[4][3];
			$final_matrix[3][5] = $matrix_arr2[3][3];
			$final_matrix[4][3] = $matrix_arr2[5][4];
			$final_matrix[4][5] = $matrix_arr2[3][4];
			$final_matrix[5][3] = $matrix_arr2[5][5];
			$final_matrix[5][4] = $matrix_arr2[4][5];
			$final_matrix[5][5] = $matrix_arr2[3][5];
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

// Randomizer AI
mt_srand();
do
{
	$x = mt_rand(0,5);
	$y = mt_rand(0,5);
}
while($matrix_arr2[$y][$x] != 0);

$t = mt_rand(1,4);
$d = mt_rand(0,1) ? 'l' : 'r';
?>