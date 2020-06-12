<?php 
//   $dbconnect = mysqli_connect("localhost", "root", "", "registration") or die("Couldnt establish database connection !!!");
require('./php/db_connect.php');  
session_start();
  require 'php/functions.php';
  if(isset($_SESSION['isloggedin']) !== true){

    session_unset();
    session_destroy();
    header("Location: index.html");

  }
  function trim_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $result= '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (!isset($_POST['update_btn'])) {
       $id = $_GET['id'];
       $date = $_POST['date'];
       $status = $_POST['status'];

       if (!isset($id) or !isset($status) or !isset($date)) {
           echo 'not set';
       }else{
           $sql = "UPDATE `transactionhistory` SET `date`='$date',`status`='processed' WHERE `transaction_id`= '$id'";
           if (mysqli_query($dbconnect,$sql)) {
               $result = true;
           }
       }
       
   }

}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Secure Dashboard| FHC-Online Banking </title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="css/main.css?version=4.4.0" rel="stylesheet">
  </head>
  <body class="menu-position-side menu-side-left full-screen">
    <div class="all-wrapper solid-bg-all">
      <!--------------------
      START - Top Bar
      -------------------->
      <div class="top-bar color-scheme-bright">
        <div class="logo-w menu-size">
          <a class="logo" href="index.html">
            <div class="logo-element"></div>
            <div class="logo-label">
              FHC-Online Banking
            </div>
          </a>
        </div>
        <!--------------------
        START - Top Menu Controls
        -------------------->
        <div class="top-menu-controls">
          <!--div class="element-search autosuggest-search-activator">
            <input placeholder="Start typing to search..." type="text">
          </div-->
          <!--------------------
          START - Messages Link in secondary top menu
          -------------------->
          <div class="messages-notifications os-dropdown-trigger os-dropdown-position-left">
            <a href="contact_support.php"><i class="os-icon os-icon-mail-14" style="color: #fff"></i> </a>
            <div class="new-messages-count">
              
            </div>
          </div>
          <!--------------------
          END - Messages Link in secondary top menu
          --------------------><!--------------------
          START - Settings Link in secondary top menu
          -------------------->
          <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-left">
            <i class="os-icon os-icon-ui-46"></i>
            <div class="os-dropdown">
              <div class="icon-w">
                <i class="os-icon os-icon-ui-46"></i>
              </div>
              <ul>
                <li>
                  <a href="#"><i class="os-icon os-icon-ui-49"></i><span>Account Settings</span></a>
                </li>                
                <li>
                  <a href="php/logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                </li>
              </ul>
            </div>
          </div>
          <!--------------------
          END - Settings Link in secondary top menu
          --------------------><!--------------------
          START - User avatar and menu in secondary top menu
          -------------------->
          <div class="logged-user-w">
            <div class="logged-user-i">
              <div class="avatar-w">
              <?php
                        $userid = $_SESSION['user_id'];
                        showimg($userid,$dbconnect);                        
                ?>
                <!-- <img alt="" src="img/avatar1.png"> -->
              </div>
              <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                  <div class="avatar-w">
                  <?php
                        $userid = $_SESSION['user_id'];
                        showimg($userid,$dbconnect);                        
                ?>
                  </div>
                  <div class="logged-user-info-w">
                    <div class="logged-user-name">
                    <?php echo $_SESSION['user_id'] ?>
                    </div>
                    <div class="logged-user-role">
                      <?php echo $_SESSION['account_number'] ?>
                    </div>
                  </div>
                </div>
                <div class="bg-icon">
                  <i class="os-icon os-icon-wallet-loaded"></i>
                </div>
                <ul>                  
                  <li>
                    <a href="#"><i class="os-icon os-icon-user-male-circle2"></i><span>Account Settings</span></a>
                  </li>                  
                  <li>
                    <a href="php/logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!--------------------
          END - User avatar and menu in secondary top menu
          -------------------->
        </div>
        <!--------------------
        END - Top Menu Controls
        -------------------->
      </div>
      <!--------------------
      END - Top Bar
      -------------------->
      <!--div class="search-with-suggestions-w">
        <div class="search-with-suggestions-modal">
          <div class="element-search">
            <input class="search-suggest-input" placeholder="Start typing to search..." type="text">
              <div class="close-search-suggestions">
                <i class="os-icon os-icon-x"></i>
              </div>
            </input>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              <div class="ssg-icon">
                <div class="os-icon os-icon-box"></div>
              </div>
              <div class="ssg-name">
                Projects
              </div>
              <div class="ssg-info">
                24 Total
              </div>
            </div>
            <div class="ssg-content">
              <div class="ssg-items ssg-items-boxed">
                <a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(img/company6.png)"></div>
                  <div class="item-name">
                    Integ<span>ration</span> with API
                  </div>
                </a><a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(img/company7.png)"></div>
                  <div class="item-name">
                    Deve<span>lopm</span>ent Project
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              <div class="ssg-icon">
                <div class="os-icon os-icon-users"></div>
              </div>
              <div class="ssg-name">
                Customers
              </div>
              <div class="ssg-info">
                12 Total
              </div>
            </div>
            <div class="ssg-content">
              <div class="ssg-items ssg-items-list">
                <a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(img/avatar1.png)"></div>
                  <div class="item-name">
                    John Ma<span>yer</span>s
                  </div>
                </a><a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(img/avatar2.jpg)"></div>
                  <div class="item-name">
                    Th<span>omas</span> Mullier
                  </div>
                </a><a class="ssg-item" href="users_profile_big.html">
                  <div class="item-media" style="background-image: url(img/avatar3.jpg)"></div>
                  <div class="item-name">
                    Kim C<span>olli</span>ns
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              <div class="ssg-icon">
                <div class="os-icon os-icon-folder"></div>
              </div>
              <div class="ssg-name">
                Files
              </div>
              <div class="ssg-info">
                17 Total
              </div>
            </div>
            <div class="ssg-content">
              <div class="ssg-items ssg-items-blocks">
                <a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-file-text"></i>
                  </div>
                  <div class="item-name">
                    Work<span>Not</span>e.txt
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-film"></i>
                  </div>
                  <div class="item-name">
                    V<span>ideo</span>.avi
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-database"></i>
                  </div>
                  <div class="item-name">
                    User<span>Tabl</span>e.sql
                  </div>
                </a><a class="ssg-item" href="#">
                  <div class="item-icon">
                    <i class="os-icon os-icon-image"></i>
                  </div>
                  <div class="item-name">
                    wed<span>din</span>g.jpg
                  </div>
                </a>
              </div>
              <div class="ssg-nothing-found">
                <div class="icon-w">
                  <i class="os-icon os-icon-eye-off"></i>
                </div>
                <span>No files were found. Try changing your query...</span>
              </div>
            </div>
          </div>
        </div>
      </div-->
      <div class="layout-w">
        <!--------------------
        START - Mobile Menu
        -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="index.html"><img src="img/logo.png"><span>FHC- Online Banking</span></a>
            <div class="mm-buttons">
              <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
              </div>
              <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
              </div>
            </div>
          </div>
          <div class="menu-and-user">
            <div class="logged-user-w">
              <div class="avatar-w">
              <?php
                        $userid = $_SESSION['user_id'];
                        showimg($userid,$dbconnect);                        
                ?>
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                <?php echo $_SESSION['user_id'] ?>
                </div>
                <div class="logged-user-role">
                <?php echo $_SESSION['account_number'] ?>
                </div>
              </div>
            </div>
            <!--------------------
            START - Mobile Menu List
            -------------------->
            <ul class="main-menu">             
              <li class="has-sub-menu">
                <a href="layouts_menu_top_image.html">
                  <div class="icon-w">
                    <div class="os-icon os-icon-layers"></div>
                  </div>
                  <span>Home</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="#">Account Today</a>
                  </li>                  
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="apps_bank.html">
                  <div class="icon-w">
                    <div class="os-icon os-icon-package"></div>
                  </div>
                  <span>Quick Actions</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="apps_bank_deposit.php">Make Deposits</a>
                  </li>
                  <li>
                    <a href="apps_bank_ltransfer.php">Local Transfers</a>
                  </li>
                  <li>
                    <a href="apps_bank_itransfer.php">International Transfers</a>
                  </li>                  
                </ul>
              </li>
              
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-life-buoy"></div>
                  </div>
                  <span>Me2Me Transfer</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="#">Me2Me <strong class="badge badge-danger">New</strong></a>
                  </li>                  
                </ul>
              </li> 
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-edit-32"></div>
                  </div>
                  <span>Account Settings</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="#">Change Password</a>
                  </li>                  
                </ul>
              </li>              
              <li class="has-sub-menu">
                <a href="php/logout.php">
                  <div class="icon-w">
                    <div class="os-icon os-icon-signs-11"></div>
                  </div>
                  <span>Logout</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="php/logout.php">Logout</a>
                  </li>                  
                </ul>
              </li>
            </ul>
            <!--------------------
            END - Mobile Menu List
            -------------------->
            <div class="mobile-menu-magic">
              <h4>
                100Days Instant Profit
              </h4>
              <p>
                30% ROI Options
              </p>
              <div class="btn-w">
                <a class="btn btn-white btn-rounded" href="https://oceancapitalinvestments.ca" target="_blank">Review NOW</a>
              </div>
            </div>
          </div>
        </div>
        <!--------------------
        END - Mobile Menu
        --------------------><!--------------------
        START - Main Menu
        -------------------->
        <div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
          <div class="logged-user-w avatar-inline">
            <div class="logged-user-i">
              <div class="avatar-w">
              <?php
                        $userid = $_SESSION['user_id'];
                        showimg($userid,$dbconnect);                        
                ?>
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                <?php echo $_SESSION['user_id'] ?>
                </div>
                <div class="logged-user-role">
                <?php echo $_SESSION['account_number'] ?>
                </div>
              </div>
              <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
              </div>
              <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                  <div class="avatar-w">
                  <?php
                        showimg($userid,$dbconnect);                        
                ?>
                  </div>
                  <div class="logged-user-info-w">
                    <div class="logged-user-name">
                    <?php echo $_SESSION['user_id'] ?>
                    </div>
                    <div class="logged-user-role">
                    <?php echo $_SESSION['account_number'] ?>
                    </div>
                  </div>
                </div>
                <div class="bg-icon">
                  <i class="os-icon os-icon-wallet-loaded"></i>
                </div>
                <ul>                  
                  <li>
                    <a href="#"><i class="os-icon os-icon-user-male-circle2"></i><span>Account Settings</span></a>
                  </li>                  
                  <li>
                    <a href="php/logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="menu-actions">
            <!--------------------
            START - Messages Link in secondary top menu
            -------------------->
            <div class="messages-notifications os-dropdown-trigger os-dropdown-position-right">
            <a href="contact_support.php"><i class="os-icon os-icon-mail-14" style="color: #047bf8"></i> </a>
              <div class="new-messages-count">
                
              </div>
              <div class="os-dropdown light message-list">
              </div>
            </div>
            <!--------------------
            END - Messages Link in secondary top menu
            --------------------><!--------------------
            START - Settings Link in secondary top menu
            -------------------->
            <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-right">
              <i class="os-icon os-icon-ui-46"></i>
              <div class="os-dropdown">
                <div class="icon-w">
                  <i class="os-icon os-icon-ui-46"></i>
                </div>
                <ul>
                  <li>
                    <a href="#"><i class="os-icon os-icon-ui-49"></i><span>Account Settings</span></a>
                  </li>
                  </li>
                  <li>
                    <a href="php/logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                </ul>
              </div>
            </div>
            <!--------------------
            END - Settings Link in secondary top menu
            --------------------><!--------------------
            START - Messages Link in secondary top menu
            -------------------->
            
            <!--------------------
            END - Messages Link in secondary top menu
            -------------------->
          </div>
          <div class="element-search autosuggest-search-activator">
            <input placeholder="Start typing to search..." type="text">
          </div>
          <h1 class="menu-page-header">
            Page Header
          </h1>
          <ul class="main-menu">
            <li class="sub-header">
              <span>Action</span>
            </li>
            <li class="selected has-sub-menu">
              <a href="index.html">
                <div class="icon-w">
                  <div class="os-icon os-icon-layout"></div>
                </div>
                <span>Quick Action</span></a>
              <div class="sub-menu-w">
                <div class="sub-menu-header">
                  Quick Action
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-layout"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
				  <li>
                      <a href="apps_bank_deposit.php">Deposits</a>
                    </li>
                    <li>
                      <a href="apps_bank_ltransfer.php">Local Transfer</a>
                    </li>
					<li>
                      <a href="apps_bank_itransfer.php">International Transfer</a>
                    </li>
                    <!--li>
                      <a href="apps_crypto.html">Crypto Dashboard <strong class="badge badge-danger">Hot</strong></a>
                    </li-->
                    
                    <!--li>
                      <a href="apps_projects.html">Dashboard 4</a>
                    </li>
                    <li>
                      <a href="apps_bank.html">Dashboard 5</a>
                    </li>
                    <li>
                      <a href="layouts_menu_top_image.html">Dashboard 6</a>
                    </li>
                  </ul-->
                </div>
              </div>
            </li>
            <li class=" has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <div class="os-icon os-icon-layers"></div>
                </div>
                <span>Transactions</span></a>
              <div class="sub-menu-w">
                <div class="sub-menu-header">
                  Transactions
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-layers"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">                    
                    <li>
                      <a href="transaction_history.php">Transaction History</a>
                    </li>
                    </ul><!--ul class="sub-menu">
                    <li>
                      <a href="layouts_menu_side_mini_dark.html">Mini Menu Dark</a>
                    </li>
                    <li>
                      <a href="layouts_menu_side_compact.html">Compact Side Menu</a>
                    </li>
                    <li>
                      <a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a>
                    </li>
                    <li>
                      <a href="layouts_menu_right.html">Right Menu</a>
                    </li>
                    <li>
                      <a href="layouts_menu_top.html">Top Menu Light</a>
                    </li>
                    <li>
                      <a href="layouts_menu_top_dark.html">Top Menu Dark</a>
                    </li>
                    </ul><ul class="sub-menu">
                    <li>
                      <a href="layouts_menu_top_image.html">Top Menu Image <strong class="badge badge-danger">New</strong></a>
                    </li>
                    <li>
                      <a href="layouts_menu_sub_style_flyout.html">Sub Menu Flyout</a>
                    </li>
                    <li>
                      <a href="layouts_menu_sub_style_flyout_dark.html">Sub Flyout Dark</a>
                    </li>
                    <li>
                      <a href="layouts_menu_sub_style_flyout_bright.html">Sub Flyout Bright</a>
                    </li>
                    <li>
                      <a href="layouts_menu_side_compact_click.html">Menu Inside Click</a>
                    </li>
                  </ul-->
                </div>
              </div>
            </li>
            <li class="sub-header">
              <span>Account Options</span>
            </li>
            <li class=" has-sub-menu">
              <a href="apps_profile_settings.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-package"></div>
                </div>
                <span>Profile Settings</span></a>
            </li>
            <li class=" has-sub-menu">
              <a href="apps_request_security_code.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-package"></div>
                </div>
                <span>Request Security Code</span></a>
            </li>
            <li class=" has-sub-menu">
              <a href="apps_change_password.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-package"></div>
                </div>
                <span>Change Password</span></a>
            </li>
            <li class=" has-sub-menu">
              <a href="apps_contact_support.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-package"></div>
                </div>
                <span>Contact Support</span></a>
            </li>
            <?php 
            if ($_SESSION['is_admin']) { ?>
                <li class="sub-header">
              <span>Account Analytics</span>
            </li>
            
            <li class=" has-sub-menu">
              <a href="apps_user_statistics.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-users"></div>
                </div>
                <span>User Statistics</span>
              </a>
            </li>
            <li class=" has-sub-menu">
              <a disabled>
                <div class="icon-w">
                  <div class="os-icon os-icon-edit-32"></div>
                </div>
                <span>Add Accounts</span>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-header">
                  Add Accounts
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-edit-32"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="apps_add_account.php">Create Admin</a>
                    </li>
                    <!--li>
                      <a href="forms_uploads.html">Add Billing Account</a>
                    </li>
                    <li>
                      <a href="forms_wisiwig.html">Wisiwig Editor</a>
                    </li-->
                  </ul>
                </div>
              </div>
            </li>
            <li class=" has-sub-menu">
              <a href="approve_transactions.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-grid"></div>
                </div>
                <span>Approve Transactions</span></a>
            </li>
            <li class=" has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <div class="os-icon os-icon-zap"></div>
                </div>
                <span>Notifications</span></a>
              <div class="sub-menu-w">
                <div class="sub-menu-header">
                  Notifications
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-zap"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Account Updates</a>
                    </li>
                    <li>
                      <a href="#">Security Updates</a>
                    </li>
                    
                  </ul>
                </div>
              </div>
            </li>
            
            <?php }
            
            
            ?>
          
          </ul>
          <div class="side-menu-magic">
            <h4>
              100Days Instant Profit
            </h4>
            <p>
              30% ROI Options
            </p>
            <div class="btn-w">
              <a class="btn btn-white btn-rounded" href="https://oceancapitalinvestments.ca" target="_blank">Review NOW</a>
            </div>
          </div>
        </div>
        <!--------------------
        END - Main Menu
        -------------------->
        <?php 
        //$row = '';
        if (isset($_GET['id'])) { 
          $transaction_id = $_GET['id'];
          $row = populateTable($dbconnect,$transaction_id) ;?>
          
        
                    <div class="element-box"><?php
                        if ($result) { ?>
                           <div class="alert alert-success text-white">User has been uccessfully updated</div> 
                        <?php }
                    ?>
                      <form id="transfer-form" method="POST" action="<?php
                      $url = $_SERVER['PHP_SELF'].'?id='.$_GET['id'];
                      echo htmlspecialchars($url)?>">
                        <h5 class="element-box-header">
                          Profile Settings
                        </h5>
                        <div class="row">
                        
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">TransactionID</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter last name" required type="text" name="lastname" value="<?php echo $row['transaction_id'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Email</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter last name" required type="text" name="lastname" value="<?php echo $row['email'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Bank Name</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="firstname" value="<?php echo $row['bankname'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Bank address</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="" value="<?php echo $row['bankaddress'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Country</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="account_balance" value="<?php echo $row['country'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Account Number</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="credit_balance" value="<?php echo $row['accountnumber'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Short Code</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="due_today" value="<?php echo $row['shortcode'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Amount</label><input id="status" class="form-control form-control-<?php echo $type ?>" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" id="bank_name" name="" value="<?php echo $row['amount']?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Date</label><input  class="form-control form-control-<?php echo $type ?>" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="date" value="<?php echo $row['date'] ?>">                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Transfer Details</label><input  class="form-control form-control-<?php echo $type ?>" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="" value="<?php echo $row['details']?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Transfer Type</label><input  class="form-control form-control-<?php echo $type ?>" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="" value="<?php echo $row['transfertype'] ?>" disabled>                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Status</label><input  class="form-control form-control-<?php echo $type ?>" data-error="Enter Correct Account Info" placeholder="Enter first name" required type="text" name="status" value="<?php echo $row['status'] ?>" >                                
                            </div>
                        </div>
                        <button type="submit" name="activate_btn" class="mr-2 mb-2 py-2 btn btn-primary"  type="submit">Update Transaction<span></span><i class="os-icon os-icon-grid-18"></i></button>
                        </form>
                       
        <?php }else{ ?>
             
                 Wrong sequence ..
                  <script> window.Location.href = 'index.php'</script>
        <?php }
        ?>
      <div class="display-type"></div>
    </div>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="bower_components/moment/moment.js"></script>
    <script src="bower_components/chart.js/dist/Chart.min.js"></script>
    <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="bower_components/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script src="bower_components/ckeditor/ckeditor.js"></script>
    <script src="bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <script src="bower_components/dropzone/dist/dropzone.js"></script>
    <script src="bower_components/editable-table/mindmup-editabletable.js"></script>
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="bower_components/tether/dist/js/tether.min.js"></script>
    <script src="bower_components/slick-carousel/slick/slick.min.js"></script>
    <script src="bower_components/bootstrap/js/dist/util.js"></script>
    <script src="bower_components/bootstrap/js/dist/alert.js"></script>
    <script src="bower_components/bootstrap/js/dist/button.js"></script>
    <script src="bower_components/bootstrap/js/dist/carousel.js"></script>
    <script src="bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="bower_components/bootstrap/js/dist/modal.js"></script>
    <script src="bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="bower_components/bootstrap/js/dist/popover.js"></script>
    <script src="js/demo_customizer.js?version=4.4.0"></script>
    <script src="js/main.js?version=4.4.0"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      
      ga('create', 'UA-XXXXXXX-9', 'auto');
      ga('send', 'pageview');
    </script>

    <script src="js/changestatus.js"> </script>
	<footer>
  <div>Secure Login - Forte House Capital: Member of BENTLEY REID (c) 2020 All Rights Reserved 
  </div>
  </footer>
  </body>
  
</html>