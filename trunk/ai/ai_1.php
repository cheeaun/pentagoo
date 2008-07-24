<?php

// Rotate the function
function rotate($subGridId, $dir, $matrix)
{

	// I don't think that $final_matrix = $matrix so I copy
	for($c = 0; $c < 6; $c++)
	{
		for($r = 0; $r < 6; $r++)
		{
			$final_matrix[$c][$r] = $matrix[$c][$r];
		}
	}

	switch($subGridId)
	{
	case 1:
		if ($dir == 'l')
		{
			$final_matrix[0][0] = $matrix[0][2]; //
			$final_matrix[0][1] = $matrix[1][2]; //
			$final_matrix[0][2] = $matrix[2][2]; //
			$final_matrix[1][0] = $matrix[0][1]; //
			$final_matrix[1][2] = $matrix[2][1]; //
			$final_matrix[2][0] = $matrix[0][0]; //
			$final_matrix[2][1] = $matrix[1][0]; //
			$final_matrix[2][2] = $matrix[2][0]; //
		}
		else if ($dir == 'r')
		{
			$final_matrix[0][0] = $matrix[2][0]; //
			$final_matrix[0][1] = $matrix[1][0]; //
			$final_matrix[0][2] = $matrix[0][0]; //
			$final_matrix[1][0] = $matrix[2][1]; //
			$final_matrix[1][2] = $matrix[0][1]; //
			$final_matrix[2][0] = $matrix[2][2]; //
			$final_matrix[2][1] = $matrix[1][2]; //
			$final_matrix[2][2] = $matrix[0][2]; //Mistake 
		}
		break;
	case 2:
		if ($dir == 'l')
		{
			$final_matrix[0][3] = $matrix[0][5]; //
			$final_matrix[0][4] = $matrix[1][5]; // Mistake
			$final_matrix[0][5] = $matrix[2][5]; //
			$final_matrix[1][3] = $matrix[0][4]; //
			$final_matrix[1][5] = $matrix[2][4]; //
			$final_matrix[2][3] = $matrix[0][3]; //
			$final_matrix[2][4] = $matrix[1][3]; //
			$final_matrix[2][5] = $matrix[2][3]; //
		}
		else if ($dir == 'r')
		{
			$final_matrix[0][3] = $matrix[2][3]; //
			$final_matrix[0][4] = $matrix[1][3]; //
			$final_matrix[0][5] = $matrix[0][3]; //Mistake
			$final_matrix[1][3] = $matrix[2][4]; //Mistake
			$final_matrix[1][5] = $matrix[0][4]; //
			$final_matrix[2][3] = $matrix[2][5]; //
			$final_matrix[2][4] = $matrix[1][5]; //
			$final_matrix[2][5] = $matrix[0][5]; //
		}
		break;
	case 3:
		if ($dir == 'l')
		{
			$final_matrix[3][0] = $matrix[3][2]; //
			$final_matrix[3][1] = $matrix[4][2]; //
			$final_matrix[3][2] = $matrix[5][2]; //
			$final_matrix[4][0] = $matrix[3][1]; //
			$final_matrix[4][2] = $matrix[5][1]; //
			$final_matrix[5][0] = $matrix[3][0]; //
			$final_matrix[5][1] = $matrix[4][0]; //
			$final_matrix[5][2] = $matrix[5][0]; //
		}
		else if ($dir == 'r')
		{
			$final_matrix[3][0] = $matrix[5][0]; //
			$final_matrix[3][1] = $matrix[4][0]; //
			$final_matrix[3][2] = $matrix[3][0]; //
			$final_matrix[4][0] = $matrix[5][1]; //
			$final_matrix[4][2] = $matrix[3][1]; //Mistake
			$final_matrix[5][0] = $matrix[5][2]; //Mistake
			$final_matrix[5][1] = $matrix[4][2]; //Mistake
			$final_matrix[5][2] = $matrix[3][2]; //Mistake
		}
		break;
	case 4:
		if ($dir == 'l')
		{
			$final_matrix[3][3] = $matrix[3][5]; //
			$final_matrix[3][4] = $matrix[4][5]; //
			$final_matrix[3][5] = $matrix[5][5]; //
			$final_matrix[4][3] = $matrix[3][4]; //Mistake
			$final_matrix[4][5] = $matrix[5][4]; //
			$final_matrix[5][3] = $matrix[3][3]; //
			$final_matrix[5][4] = $matrix[4][3]; //
			$final_matrix[5][5] = $matrix[5][3]; //
		}
		else if ($dir == 'r')
		{
			$final_matrix[3][3] = $matrix[5][3]; //
			$final_matrix[3][4] = $matrix[4][3]; //
			$final_matrix[3][5] = $matrix[3][3]; //
			$final_matrix[4][3] = $matrix[5][4]; //
			$final_matrix[4][5] = $matrix[3][4]; //
			$final_matrix[5][3] = $matrix[5][5]; //
			$final_matrix[5][4] = $matrix[4][5]; //
			$final_matrix[5][5] = $matrix[3][5]; //
		}
		break;
	}
	return $final_matrix;
}



//$c = CurrentPlayer
//$m = Matrice
function GameOver($c, $m)
{
	
	// check 5, \
	if ($m[0][0] == $c && $m[1][1] == $c && $m[2][2] == $c && $m[3][3] == $c && $m[4][4] == $c)
		return true;
	if ($m[1][1] == $c && $m[2][2] == $c && $m[3][3] == $c && $m[4][4] == $c && $m[5][5] == $c)
		return true;
	if ($m[1][0] == $c && $m[2][1] == $c && $m[3][2] == $c && $m[4][3] == $c && $m[5][4] == $c)
		return true;
	if ($m[0][1] == $c && $m[1][2] == $c && $m[2][3] == $c && $m[3][4] == $c && $m[4][5] == $c)
		return true;
		
	// check 5, /
	if ($m[0][5] == $c && $m[1][4] == $c && $m[2][3] == $c && $m[3][2] == $c && $m[4][1] == $c)
		return true;
	if ($m[1][4] == $c && $m[2][3] == $c && $m[3][2] == $c && $m[4][1] == $c && $m[5][0] == $c)
		return true;
	if ($m[0][4] == $c && $m[1][3] == $c && $m[2][2] == $c && $m[3][1] == $c && $m[4][0] == $c)
		return true;
	if ($m[1][5] == $c && $m[2][4] == $c && $m[3][3] == $c && $m[4][2] == $c && $m[5][1] == $c)
		return true;
		
	// check 5, |
	if ($m[0][0] == $c && $m[1][0] == $c && $m[2][0] == $c && $m[3][0] == $c && $m[4][0] == $c)
		return true;
	if ($m[1][0] == $c && $m[2][0] == $c && $m[3][0] == $c && $m[4][0] == $c && $m[5][0] == $c)
		return true;
	if ($m[0][1] == $c && $m[1][1] == $c && $m[2][1] == $c && $m[3][1] == $c && $m[4][1] == $c)
		return true;
	if ($m[1][1] == $c && $m[2][1] == $c && $m[3][1] == $c && $m[4][1] == $c && $m[5][1] == $c)
		return true;
	if ($m[0][2] == $c && $m[1][2] == $c && $m[2][2] == $c && $m[3][2] == $c && $m[4][2] == $c)
		return true;
	if ($m[1][2] == $c && $m[2][2] == $c && $m[3][2] == $c && $m[4][2] == $c && $m[5][2] == $c)
		return true;
	if ($m[0][3] == $c && $m[1][3] == $c && $m[2][3] == $c && $m[3][3] == $c && $m[4][3] == $c)
		return true;
	if ($m[1][3] == $c && $m[2][3] == $c && $m[3][3] == $c && $m[4][3] == $c && $m[5][3] == $c)
		return true;
	if ($m[0][4] == $c && $m[1][4] == $c && $m[2][4] == $c && $m[3][4] == $c && $m[4][4] == $c)
		return true;
	if ($m[1][4] == $c && $m[2][4] == $c && $m[3][4] == $c && $m[4][4] == $c && $m[5][4] == $c)
		return true;
	if ($m[0][5] == $c && $m[1][5] == $c && $m[2][5] == $c && $m[3][5] == $c && $m[4][5] == $c)
		return true;
	if ($m[1][5] == $c && $m[2][5] == $c && $m[3][5] == $c && $m[4][5] == $c && $m[5][5] == $c)
		return true;
		
	// check 5, -
	if ($m[0][0] == $c && $m[0][1] == $c && $m[0][2] == $c && $m[0][3] == $c && $m[0][4] == $c)
		return true;
	if ($m[0][1] == $c && $m[0][2] == $c && $m[0][3] == $c && $m[0][4] == $c && $m[0][5] == $c)
		return true;
	if ($m[1][0] == $c && $m[1][1] == $c && $m[1][2] == $c && $m[1][3] == $c && $m[1][4] == $c)
		return true;
	if ($m[1][1] == $c && $m[1][2] == $c && $m[1][3] == $c && $m[1][4] == $c && $m[1][5] == $c)
		return true;
	if ($m[2][0] == $c && $m[2][1] == $c && $m[2][2] == $c && $m[2][3] == $c && $m[2][4] == $c)
		return true;
	if ($m[2][1] == $c && $m[2][2] == $c && $m[2][3] == $c && $m[2][4] == $c && $m[2][5] == $c)
		return true;
	if ($m[3][0] == $c && $m[3][1] == $c && $m[3][2] == $c && $m[3][3] == $c && $m[3][4] == $c)
		return true;
	if ($m[3][1] == $c && $m[3][2] == $c && $m[3][3] == $c && $m[3][4] == $c && $m[3][5] == $c)
		return true;
	if ($m[4][0] == $c && $m[4][1] == $c && $m[4][2] == $c && $m[4][3] == $c && $m[4][4] == $c)
		return true;
	if ($m[4][1] == $c && $m[4][2] == $c && $m[4][3] == $c && $m[4][4] == $c && $m[4][5] == $c)
		return true;
	if ($m[5][0] == $c && $m[5][1] == $c && $m[5][2] == $c && $m[5][3] == $c && $m[5][4] == $c)
		return true;
	if ($m[5][1] == $c && $m[5][2] == $c && $m[5][3] == $c && $m[5][4] == $c && $m[5][5] == $c)
		return true;
	
	return false;
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

function position($matrix, $curPlayer, $oppPlayer) {
	$score = 0;

	if($matrix[1][1] == $curPlayer) $score += 100;
	if($matrix[1][4] == $curPlayer) $score += 100;
	if($matrix[4][1] == $curPlayer) $score += 100;
	if($matrix[4][4] == $curPlayer) $score += 100;

	if($matrix[1][1] == $oppPlayer) $score -= 100;
	if($matrix[1][4] == $oppPlayer) $score -= 100;
	if($matrix[4][1] == $oppPlayer) $score -= 100;
	if($matrix[4][4] == $oppPlayer) $score -= 100;

	return $score;
}

function alphabeta_failsoft($curPlayer, $oppPlayer, $matrix, $depth, $maxdepth, $alpha, $beta, &$cout)
{
	$g = -50000;
	if(gameover($curPlayer, $matrix) == true) return 5000;
	if(gameover($oppPlayer, $matrix) == true) return -5000;

	if($depth == $maxdepth) return position($matrix, $curPlayer, $oppPlayer);

	$liste_cout = liste($matrix);
	for($i = 0; ($i < sizeof($liste_cout)) && ($alpha < $beta); $i++) {
		$matrix[$liste_cout[$i]["c"]][$liste_cout[$i]["r"]] = $curPlayer;
		$matrix = rotate($liste_cout[$i]["turn"], $liste_cout[$i]["direction"], $matrix);

		$tempDepth = $depth + 1;
		$tempAlpha = -1 * $beta;
		$tempBeta = -1 * $alpha;
		$valeur = (-1) * alphabeta_failsoft($oppPlayer, $curPlayer, $matrix, $tempDepth, $maxdepth, $tempAlpha, $tempBeta, $cout);

		if($liste_cout[$i]["direction"] == "l") $matrix = rotate($liste_cout[$i]["turn"], "r", $matrix);
		else $matrix = rotate($liste_cout[$i]["turn"], "l", $matrix);
		$matrix[$liste_cout[$i]["c"]][$liste_cout[$i]["r"]] = 0;

		if($valeur > $g) $g = $valeur;
		if($valeur > $alpha) {
			$alpha = $valeur;
			if($depth == 0) {
				$cout = $liste_cout[$i];
			}
		}	

	}

	return $g;
}

// List all possibility to game (???? sorry for my bas english)
function liste($matrix) {

	$liste_cout = array();

	for ($c = 0; $c < 6; ++$c)
	{
		for ($r = 0; $r < 6; ++$r)
		{
			if($matrix[$c][$r] == 0)
			{
				for($i = 1; $i < 5; $i++)
				{

					$hash["c"] = $c;
					$hash["r"] = $r;
					$hash["turn"] = $i;
					$hash["direction"] = "l";
	
					$hash2["c"] = $c;
					$hash2["r"] = $r;
					$hash2["turn"] = $i;
					$hash2["direction"] = "r";

					$liste_cout[] = $hash;	
					$liste_cout[] = $hash2;
				}
			}
		}
	}

	return $liste_cout;
	
}

if($player == 2) { $curPlayer = 2; $oppPlayer = 1; }
else { $curPlayer = 1; $oppPlayer = 2; }

// Run AlphaBeta Failsoft
alphabeta_failsoft($curPlayer, $oppPlayer, $matrix_arr2, 0, 2, -50000, 50000, $cout);

$x = $cout["r"];
$y = $cout["c"];
$t = $cout["turn"];
$d = $cout["direction"];

?>
