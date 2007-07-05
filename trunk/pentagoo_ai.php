<?
// Get parameters
$matrix = $_GET['m'];
$player = $_GET['p'];
$level = $_GET['l'];

// Convert matrix string to array
$matrix_arr = str_split($matrix);
for($m = 0; $m < 6; ++$m)
	for($n = 0; $n < 6 ; ++$n)
		$matrix_array[$m][$n] = array_shift($matrix_arr);

switch($level)
{
	case '0':
		include_once('ai_0.php'); // Easiest AI - Random
		break;
	case '1':
		include_once('ai_1.php'); // Easy
		break;
	case '2':
		include_once('ai_2.php'); // Medium
		break;
	case '3':
		include_once('ai_3.php'); // Hard
		break;
	case '4':
		include_once('ai_4.php'); // God-like
		break;
}

echo $x.$y.$t.$d; // OUTPUT!
?>