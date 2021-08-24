<? require_once('assets/mysql_connect.php');

$q = $_GET['q'];

if($q == '') {
     http_response_code( 400 );
} else {
     
     // CHECK CODE EXISITS
     $result = $sql->query("SELECT * FROM webhooks WHERE code = '$q' ");
     if($result->num_rows == 1) {
          
          $row = $result->fetch_assoc();
          
          // FIND THE CODE TYPE
          switch($row['type']) {
                    
               case 'GET':
                    
                    $data = $_SERVER['REQUEST_URI'];
                    if( $sql->query("INSERT INTO hits SET code = '$q', data = '$data', datetime_created = NOW() ") ) {
                         http_response_code( 200 );
                    } else {
                         http_response_code( 400 );
                    }
                    
                    break;
                    
               case 'POST':
                    
                    $data = file_get_contents('php://input');
                    if( $sql->query("INSERT INTO hits SET code = '$q', data = '$data', datetime_created = NOW() ") ) {
                         http_response_code( 200 );
                    } else {
                         http_response_code( 400 );
                    }
                    
                    break;
                    
               case 'JSON':
                    
                    $data = file_get_contents('php://input');
                    if( $sql->query("INSERT INTO hits SET code = '$q', data = '$data', datetime_created = NOW() ") ) {
                         http_response_code( 200 );
                    } else {
                         http_response_code( 400 );
                    }
                    
                    break;
          }
          
          
     } else {
          http_response_code( 400 );
     }
}

?>