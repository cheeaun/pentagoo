<?
// Get parameters
$matrix = $_GET['m'];
$player = $_GET['p'];

// Convert matrix string to array
$matrix_arr = str_split($matrix);
for( $m=0 ; $m<6 ; $m++)
	for( $n=0 ; $n<6 ; $n++)
		$matrix_array[$m][$n] = array_shift($matrix_arr);

// Randomizer AI
mt_srand();
do{
	$x = mt_rand(0,5);
	$y = mt_rand(0,5);
}
while($matrix_array[$y][$x] != 0);
$t = mt_rand(1,4);
$d = mt_rand(0,1) ? 'l' : 'r';

// OUTPUT!
echo $x.$y.$t.$d;
?>