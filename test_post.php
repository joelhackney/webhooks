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
                    
                    $data = '?q=' . $q . '&fname=Joel&lname=Hackney&phone=3174505279&zipcode=46250';
                    if( $sql->query("INSERT INTO hits SET code = '$q', data = '$data', datetime_created = NOW() ") ) {
                         http_response_code( 200 );
                    } else {
                         http_response_code( 400 );
                    }
                    
                    break;
                    
               case 'POST':
                    
                    $targetURL = 'https://joelhackney.me/webhooks/index.php?q=' . $q;

                    $fields = array(
                         'secKey'	=> urlencode($q),
                         'to'		=> urlencode('joelhackney@me.com'),
                         'subject'	=> urlencode('Webhook Post Data Test'),
                         'message'	=> urlencode('Testing Webhook Post'),
                         'from'	=> urlencode('no-reply@joelhackney.me')
                    );

                    $fields_string = '';
                    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                    rtrim($fields_string, '&');

                    //START cURL
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $targetURL);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

                    $result = curl_exec($ch);
                    curl_close($ch);   
                    
                    http_response_code( 200 );
                    
                    break;
                    
               case 'JSON':
                    
                    $targetURL = 'https://joelhackney.me/webhooks/index.php?q=' . $q;
                    
                    $data = array(
                        "first_name" => "First name",
                        "last_name" => "last name",
                        "email"=>"email@gmail.com",
                        "addresses" => array (
                            "address1" => "some address",
                            "city" => "city",
                            "country" => "CA",
                            "first_name" =>  "Mother",
                            "last_name" =>  "Lastnameson",
                            "phone" => "555-1212",
                            "province" => "ON",
                            "zip" => "123 ABC"
                        )
                    );
                    
                    $ch = curl_init( $targetURL );
                    # Setup request to send json via POST.
                    $payload = json_encode( array( "customer"=> $data ) );
                    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    # Return response instead of printing.
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    # Send request.
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    http_response_code( 200 );
                    
                    break;
          }
          
          
     } else {
          http_response_code( 400 );
     }
}

?>