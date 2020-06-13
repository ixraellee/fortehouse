<?php

function transac($db)
{
  $query1 = "SELECT * from `transactionhistory` ORDER BY `id` DESC";
  $fetch1 = mysqli_query($db, $query1);
  $row = mysqli_num_rows($fetch1);

  if ($row > 0) {
    while ($fetchdata1 = mysqli_fetch_array($fetch1)) {
      $historyid = $fetchdata1['transaction_id'];
      $date = $fetchdata1['date'];
      $amount = $fetchdata1['amount'];
      $type = $fetchdata1['transfertype'];
      $details = $fetchdata1['details'];
      $accnumber = $fetchdata1['status'];

      echo "
            <tr>
                          
            <td>
              <span>$historyid</span>
            </td>
            <td class='nowrap'>
              <span class='status-pill smaller green'></span><span>$accnumber</span>
            </td>
            <td>
              <span>$date</span><span class='smaller lighter'></span>
            </td>
            <td class='cell-with-media'>
              <img alt=''  style='height: 25px;'><span>$details</span>
            </td>
            <td class='text-center'>
              <a class='badge badge-primary' href=''>$type</a>
            </td>
            <td class='text-right bolder nowrap'>
              <span class='text-success'>$amount</span>
            </td>
          </tr>
            ";
    }
  }
}

function pending_transac($db)
{
  $query1 = "SELECT * from `transactionhistory` WHERE `status` = 'pending' ORDER BY `id` DESC";
  $fetch1 = mysqli_query($db, $query1);
  $row = mysqli_num_rows($fetch1);

  if ($row > 0) {
    while ($fetchdata1 = mysqli_fetch_array($fetch1)) {
      $historyid = $fetchdata1['transaction_id'];
      $date = $fetchdata1['date'];
      $email = $fetchdata1['email'];
      $amount = $fetchdata1['amount'];
      $type = $fetchdata1['transfertype'];
      $status = $fetchdata1['status'];

      echo "
          <tr>
                        
          <td>
            <span>$historyid</span>
          </td>
          <td>
            <span></span><span>$email</span>
          </td>
          <td class='cell-with-media'>
            <img alt=''  style='height: 25px;'><span>$amount</span>
          </td>
          <td class='text-center'>
            <a class='badge badge-primary' href=''>$type</a>
          </td>
          <td class='text-right bolder nowrap'>
            <a class='btn btn-success' target='_blank' href='./view_pending_transaction.php?id=$historyid'>View</span>
          </td>
        </tr>
          ";
    }
  }
}

function pending_otp($db)
{
  $query1 = "SELECT * from `users` WHERE `request_otp` = '1'";
  $fetch1 = mysqli_query($db, $query1);
  $row = mysqli_num_rows($fetch1);

  if ($row > 0) {
    while ($fetchdata1 = mysqli_fetch_array($fetch1)) {
      $historyid = $fetchdata1['nickname'];
      $date = $fetchdata1['email'];
      $firstname = $fetchdata1['firstname'];
      $lastname = $fetchdata1['lastname'];
      $account_number = $fetchdata1['account_number'];
      echo "
          <tr>
                        
          <td>
            <span>$firstname</span>
          </td>
          <td>
            <span></span><span>$lastname</span>
          </td>
          <td class='cell-with-media'>
            <img alt=''  style='height: 25px;'><span>$date</span>
          </td>
          <td class='text-center'>
            $historyid
          </td>
          <td class='text-right bolder nowrap'>
            <a class='btn btn-success' target='_blank' href='./generate_otp.php?id=$account_number'>View</span>
          </td>
        </tr>
          ";
    }
  }
}



function showimg($uid, $db)
{
  $result = $db->query("SELECT * FROM users where `nickname` = '$uid'");
  $user = $result->fetch_assoc();


  if ($user) {
    $mimage = $user['picture_name']; ?>
    <img style="width:50px; height:50px" src="uploads/<?php echo $mimage ?>" />
<?php }
}

function generate_transaction_id($db)
{
  $transaction_id = rand(1000000, 9999999);
  $transaction_id_sql = "SELECT * FROM transactionhistory WHERE `transaction_id`='$transaction_id'";
  $check = mysqli_query($db, $transaction_id_sql);
  if ($check) {
    if (mysqli_num_rows($check) > 0) {
      generate_transaction_id($db);
    } else {
      return $transaction_id;
    }
  } else {
    echo 'not working';
  }
}

function  generate_otp($db)
{
  $id = rand(10000, 99999);
  $id_sql = "SELECT * FROM users WHERE `otp`='$id'";
  $check = mysqli_query($db, $id_sql);
  if ($check) {
    if (mysqli_num_rows($check) > 0) {
      generate_otp($db);
    } else {
      return $id;
    }
  } else {
    echo 'not working';
  }
}

function populateTable($db, $id)
{
  $db_sql = "SELECT * FROM transactionhistory WHERE `transaction_id`= '$id'";
  $check = mysqli_query($db, $db_sql);

  if ($check) {
    if (mysqli_num_rows($check) > 0) {
      $row = mysqli_fetch_assoc($check);
      return $row;
    }
  } else {
    die('eror fetching history');
  }
}
?>