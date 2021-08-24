<?
require_once( 'assets/mysql_connect.php' );
session_start();

// CREATE NEW CREATE
if($_POST['create'] == 'save') {
     
     $error = '';
     
	// SANATIZE POST ARRAY
	$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
     
     $code = mysqli_real_escape_string($sql, $POST['code']);
     $title = mysqli_real_escape_string($sql, $POST['title']);
     $type = mysqli_real_escape_string($sql, $POST['type']);
     
     $sql->query("INSERT INTO webhooks SET code = '$code', title = '$title', type = '$type', datetime_created = NOW() ");
     
}

// ACTIVATE, PAUSE, DELETE LINKS
if($_GET['active'] != '') {
     $curCode = $_GET['active'];
     $sql->query("UPDATE webhooks SET flag = 0 WHERE code = '$curCode' ");
     header('Location: dashboard');
     exit();
}
if($_GET['pause'] != '') {
     $curCode = $_GET['pause'];
     $sql->query("UPDATE webhooks SET flag = 1 WHERE code = '$curCode' ");
     header('Location: dashboard');
     exit();
}
if($_GET['delete'] != '') {
     $curCode = $_GET['delete'];
     $sql->query("UPDATE webhooks SET flag = 2 WHERE code = '$curCode' ");
     header('Location: dashboard');
     exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Webhooks Dashboard</title>
<meta name="description" content="Responsive, Bootstrap, BS4" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- for ios 7 style, multi-resolution icon of 152x152 -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
<link rel="apple-touch-icon" href="assets/images/logo.svg">
<meta name="apple-mobile-web-app-title" content="Flatkit">
<!-- for Chrome on Android, multi-resolution icon of 196x196 -->
<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" sizes="196x196" href="assets/images/logo.svg">
<!-- style -->
<link rel="stylesheet" href="libs/font-awesome/css/font-awesome.min.css" type="text/css" />
<!-- build:css assets/css/app.min.css -->
<link rel="stylesheet" href="libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
<!-- endbuild -->
</head>
<body>
<div class="d-flex flex-column flex">
     <div class="navbar light bg pos-rlt box-shadow">
          <div class=""> 
               <!-- brand --> 
               <a href="index.html" class="navbar-brand"> <span class="hidden-folded d-inline">WEB<span class="text-b-blue">HOOKS</span> API | Dashboard</span> </a> 
               <!-- / brand --> 
          </div>
          <div class="">Hello, Joel! <a href="assets/signout.php" class="btn btn-light btn-sm"><i class="fa fa-power-off text-b-blue"></i> Sign Out</a> </div>
     </div>
     <div id="content-body" class="my-4">
          <div class="container-fluid">
               <div class="row">
                    <div class="col-xl-8">
                         <div class="box">
                              <div class="box-header primary">
                                   <h2 class="text-uppercase">Create API Webhooks</h2>
                              </div>
                              <div class="box-body">
                                   <form method="post">
                                        <div class="row">
                                             <div class="form-group col-sm-4">
                                                  <label for="Form_ShortCode">Short Code</label>
                                                  <input type="text" class="form-control" id="Form_ShortCode" name="code" value="<?=$shortCode;?>" readonly required>
                                                  <small class="form-text text-muted">Unique Code for this Webhook.</small>
                                             </div>
                                             <div class="form-group col-sm-4">
                                                  <label for="Form_Title">Title</label>
                                                  <input type="text" class="form-control" id="Form_Title" name="title" value="<?=$title;?>" placeholder="Webhook Title" required>
                                                  <small class="form-text text-muted">A Title &amp; Description of this Webhook.</small>
                                             </div>
                                             <div class="form-group col-sm-4">
                                                  <label for="Form_Type">Type</label>
                                                  <select class="form-control" id="Form_Type" name="type" required>
                                                       <option value="null" disabled selected>Select Type</option>
                                                       <option value="GET">GET</option>
                                                       <option value="POST">POST</option>
                                                       <option value="JSON">JSON</option>
                                                  </select>
                                                  <small class="form-text text-muted">This Defines the Type of Data this Webhook listens for.</small>
                                             </div>
                                        </div>
                                        <div class="row justify-content-end">
                                             <div class="col-sm-4">
                                                  <button name="create" value="save" type="submit" class="btn primary btn-block"><i class="fa fa-plus"></i> Create Webhook</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>
                         
                         
                         <div class="box">
                              <div class="box-header info">
                                   <h2 class="text-uppercase">Registered API Webhooks</h2>
                              </div>
                              <div class="box-body">
                              <!--     <a href="qr_create"><span class="btn primary mb-4"><i class="fa fa-plus"></i> CREATE NEW LINK / QR CODE</span></a>
                                   <span class="btn light mb-4"><i class="fa fa-bar-chart"></i> GOOGLE ANALYTICS</span>
                                   <span class="btn light mb-4"><i class="fa fa-refresh"></i> FORCE REFRESH</span> -->
                                   <table class="table">
                                        <tr>
                                             <th width="40">STATUS</th>
                                             <th>TITLE<br>
                                                  CREATED</th>
                                             <th>ENDPOINT</th>
                                             <th>TYPE</th>
                                             <th>HITS</th>
                                             <th class="text-right" width="40">ACTIONS</th>
                                        </tr>
                                        <?
                                        $result = $sql->query( "SELECT id, code, title, type, datetime_created, flag, (SELECT COUNT(b.id) FROM hits b WHERE b.code = a.code) AS views FROM webhooks a ORDER BY datetime_created DESC " );
                                        while ( $row = $result->fetch_assoc() ) {

                                             ?>
                                        <tr>
                                             <td>
                                                  <? if($row['flag'] == 0) {?><span class="badge primary">ACTIVE</span>
                                                  <? } else if($row['flag'] == 1) {?><span class="badge warning">PAUSED</span>
                                                  <? } else if($row['flag'] == 2) {?><span class="badge danger">DELETED</span>
                                                  <? } ?>
                                             </td>
                                             
                                             <td><b><?=$row['title'];?></b><br><small><?=$row['datetime_created'];?></small></td>
                                             
                                             <td onClick="copyTextToClipboard('https://joelhackney.me/webhooks/?q=<?=$row['code'];?>');"><span data-toggle="tooltip" data-placement="top" title="" data-original-title="Click to Copy"><i class="fa fa-copy"></i> https://joelhackney.me/webhooks/?q=<?=$row['code'];?></span></td>
                                             
                                             <td><?=$row['type'];?></td>
                                             
                                             <td><?=$row['views'];?></td>
                                             
                                             <td class="text-center text">
                                                  <div class="item-action dropdown">
                                                       <a href="#" data-toggle="dropdown" class="text-muted" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                       <div class="dropdown-menu dropdown-menu-right text-color" role="menu" x-placement="bottom-end">
                                                            <a href="?connectionID=<?=$row['code'];?>" class="dropdown-item"><i class="fa fa-share-alt"></i> View Connections</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="test_post.php?q=<?=$row['code'];?>" target="_blank" class="dropdown-item"><i class="fa fa-pencil"></i> Send Test Data</a>
                                                            <a href="?active=<?=$row['code'];?>" class="dropdown-item"><i class="fa fa-flag text-primary"></i> Mark as Active</a>
                                                            <a href="?pause=<?=$row['code'];?>" class="dropdown-item"><i class="fa fa-flag text-warning"></i> Mark as Paused</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="?delete=<?=$row['code'];?>" class="dropdown-item"><i class="fa fa-trash"></i> Delete Link</a>
                                                       </div>
                                                  </div>
                                             </td>
                                        </tr>
                                        <?
                                        }
                                        ?>
                                   </table>
                                   <script>
                                        function copyTextToClipboard(text) {
                                             if (!navigator.clipboard) {
                                                  fallbackCopyTextToClipboard(text);
                                                  return;
                                             }
                                             navigator.clipboard.writeText(text).then(function() {
                                                  console.log('Async: Copying to clipboard was successful!');
                                             }, function(err) {
                                                  console.error('Async: Could not copy text: ', err);
                                             });
                                        }
                                   </script> 
                              </div>
                         </div>
                    </div>
                    
                    <div class="col-sm-4">
                         <div class="box">
                              <div class="box-header warning">
                                   <h2 class="text-uppercase">Connection Details</h2>
                              </div>
                              <div class="box-body">
                                   <table class="table">
                                        <tr>
                                             <th>CODE<br>
                                             CREATED</th>
                                             <th>DATA</th>
                                             </tr>
                                        <? // PULL HITS
                                        if($_GET['connectionID'] != ''){
                                             $conID = $_GET['connectionID'];
                                             $result = $sql->query("SELECT * FROM hits WHERE code = '$conID' ");
                                             while($row = $result->fetch_assoc()) {
                                                  $code = $row['code'];
                                                  $created = $row['datetime_created'];
                                                  $data = $row['data'];
                                                  ?>
                                        <tr>
                                             <td><?=$code;?><br>
                                                  <?=$created;?></td>
                                             <td><?=$data;?></td>
                                             </tr>
                                        <?   }
                                        }
                                        ?>
                                   </table>
                              </div>
                         </div>
                    </div>
                    
               </div>
          </div>
     </div>
</div>
<!-- build:js assets/js/app.min.js --> 
<!-- jQuery --> 
<script src="libs/jquery/dist/jquery.min.js"></script> 
<!-- Bootstrap --> 
<script src="libs/popper.js/dist/umd/popper.min.js"></script> 
<script src="libs/bootstrap/dist/js/bootstrap.min.js"></script> 
<!-- core --> 
<script src="libs/pace-progress/pace.min.js"></script> 
<script src="libs/pjax/pjax.min.js"></script> 
<script src="assets/js/lazyload.config.js"></script> 
<script src="assets/js/lazyload.js"></script> 
<script src="assets/js/plugin.js"></script> 
<script src="assets/js/nav.js"></script> 
<script src="assets/js/scrollto.js"></script> 
<script src="assets/js/toggleclass.js"></script> 
<script src="assets/js/theme.js"></script> 
<script src="assets/js/ajax.js"></script> 
<script src="assets/js/app.js"></script> 
<!-- endbuild -->
</body>
</html>