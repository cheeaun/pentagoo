<?
// Get parameters
$matrix = $_GET['m'];
$player = $_GET['p'];
$level = $_GET['l'];

// str_split function for PHP < 5
if (!function_exists("str_split"))
{
    function str_split($string, $length = 1)
    {
        if ($length <= 0)
        {
            trigger_error(__FUNCTION__."(): The the length of each segment must be greater then zero:", E_USER_WARNING);
            return false;
        }
        $splitted  = array();
        $str_length = strlen($string);
        $i = 0;
        if ($length == 1)
        {
            while ($str_length--)
                $splitted[$i] = $string[$i++];
        }
        else
        {
            $j = $i;
            while ($str_length > 0)
            {
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