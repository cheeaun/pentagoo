<?php
// Randomizer AI
mt_srand();
do
{
	$x = mt_rand(0,5);
	$y = mt_rand(0,5);
}
while($matrix_array[$y][$x] != 0);

$t = 99;
$d = mt_rand(0,1) ? 'l' : 'r';
?>