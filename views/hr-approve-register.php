<?php $this->layout("layout-base-defalut"); ?>
<h3>HR APPROVE REGISTER</h3>
<?php 
    $db = db();

    $alpha = "abcdefghijklmnopqrstuvwxyz";
    $alpha_upper = strtoupper($alpha);
    $numeric = "0123456789";
    $special = ".-+=_,!@$#*%<>[]{}";
    $chars = "";
     
    if (isset($_POST['length'])){
       
        if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
            $chars .= $alpha;
         
        if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
            $chars .= $alpha_upper;
         
        if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
            $chars .= $numeric;
         
        if (isset($_POST['special']) && $_POST['special'] == 'on')
            $chars .= $special;
         
        $length = $_POST['length'];
    }else{
   
        $chars = $alpha . $alpha_upper . $numeric;
        $length = 6;
    }
     
    $len = strlen($chars);
    $pw = '';
     
    for ($i=0;$i<$length;$i++)
            $pw .= substr($chars, rand(0, $len-1), 1);
 
      $pw = str_shuffle($pw);  


      $email = $_GET["email"]; 

      $sql = " SELECT * FROM UserMaster WHERE Email = ?  AND Active=1";
      $params = array($email);
      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
      $query = sqlsrv_query($db,$sql,$params,$options);
      $has =  sqlsrv_has_rows($query);
      if ($has == false) {
          $UpdateActiveMaster = sqlsrv_query(
                      $db,
                      "UPDATE UserMaster SET Active=? ,Password=?  WHERE Email=?",
                      array(1,$pw,$email)
          );
          if ($UpdateActiveMaster) {
              sendmailregister_active($email,$pw);
              /*echo '<script>';
              echo 'alert("Active User Succesful!");'; 
              echo 'window.close();';
              echo '</script>';*/
          }else{
              echo '<script>';
              echo 'alert("Active User Error!");'; 
              echo 'location.href="./login"';
              echo '</script>';
          }
      }else{
          echo '<script>';
          echo 'alert("Active User Done!");'; 
          echo 'window.close();';
          echo '</script>';
      }

?>

