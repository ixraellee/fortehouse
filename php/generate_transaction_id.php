<?php
function generate_transaction_id($db)
{
    $transaction_id = rand(1000000,9999999);
    $transaction_id_sql = "SELECT FROM * transcactionhistory WHERE `transcaction_id`='$transaction_id'";
    $check = mysqli_query($db,$sql);
    if($check){
        if(mysqli_num_rows($check) > 0){
            generate_transaction_id();
        }else{
            return $transaction_id;
        }
    }
}

?>