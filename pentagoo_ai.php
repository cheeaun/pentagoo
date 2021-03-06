<?
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
$matrix_arr1 = $matrix_arr;
for($c = 0; $c < 6; ++$c)
	for($r = 0; $r < 6 ; ++$r)
		$matrix_arr2[$c][$r] = array_shift($matrix_arr);

$dir_path = dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR;
/*
switch($level)
{
	case '0':
		include_once($dir_path.'ai/ai_0.php'); // AI - Minimax
		break;
	case '1':
		include_once($dir_path.'ai/ai_1.php'); // AI - Minimax
		break;
}
*/
include_once($dir_path.'ai/ai_1.php'); // AI by Mickael ROUVIER

echo $x.$y.$t.$d;
?>