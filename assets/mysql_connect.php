<?PHP
$sql = new MySQLi('mysql.joelhackney.me', 'joelhackney', 'qevvet-pifjiz-0rAshe', 'webhooks');

// ERROR CHECKING
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

// SHORT CODE CREATE
$alphaNum = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

$rand1 = rand(0, 61);
$rand2 = rand(0, 61);
$rand3 = rand(0, 61);
$rand4 = rand(0, 61);
$rand5 = rand(0, 61);

$shortCode = $alphaNum[$rand1].$alphaNum[$rand2].$alphaNum[$rand3].$alphaNum[$rand4].$alphaNum[$rand5];

?>