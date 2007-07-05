<?
// Get parameters
$matrix = $_GET['m'];
$player = $_GET['p'];

// str_split function for PHP < 5
if (!function_exists("str_split")) {
    function str_split($string, $length = 1) {
        if ($length <= 0) {
            trigger_error(__FUNCTION__."(): The the length of each segment must be greater then zero:", E_USER_WARNING);
            return false;
        }
        $splitted  = array();
        $str_length = strlen($string);
        $i = 0;
        if ($length == 1) {
            while ($str_length--) {
                $splitted[$i] = $string[$i++];
            }
        } else {
            $j = $i;
            while ($str_length > 0) {
                $splitted[$j++] = substr($string, $i, $length);
                $str_length -= $length;
                $i += $length;
            }
        }
        return $splitted;
    }
}

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