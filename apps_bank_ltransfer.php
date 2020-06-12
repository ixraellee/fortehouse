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
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['amount']) and  
        isset($_POST['bank_name']) and 
        isset($_POST['bank_address']) and
        isset($_POST['country']) and
        isset($_POST['account_name']) and
        isset($_POST['account_number']) and
        isset($_POST['transfer_details']) and
        isset($_POST['transfer_type']) and
        isset($_POST['short_code'])
        ) 
        {
            $amount = $_POST['amount'];
            $bank_name = $_POST['bank_name'];
            $bank_address = $_POST['bank_address'];
            $country = $_POST['country'];
            $account_name = $_POST['account_name'];
            $account_number = $_POST['account_number'];
            $transfer_details = $_POST['transfer_details'];
            $transfer_type = $_POST['transfer_type'];
            $short_code = $_POST['short_code'];

            if (empty($amount) || 
            empty($bank_name) || 
            empty($bank_address) || 
            empty($country) || 
            empty($account_name) || 
            empty($account_number) || 
            empty($transfer_details) || 
            empty($transfer_type) || 
            empty($short_code)) 
            {
            //user didn't send all that is required
                http_response_code(401);
                header("bad request: ensure all fiels are filled");
            }else{
            // user has successfully passed validation'
                $user_id = $_SESSION['user_id'];
                $amount = trim_input($amount);
                $bank_name = trim_input($bank_name);
                $bank_address = trim_input($bank_address);
                $country = trim_input($country);
                $account_name = trim_input($account_name); 
                $account_number = trim_input($account_number);
                $transfer_details = trim_input($transfer_details);
                $transfer_type = trim_input($transfer_type); 
                $transaction_id = generate_transaction_id($dbconnect);
                
                $sql = "INSERT INTO transactionhistory (userid,transaction_id,bankname,bankaddress,country,accountname,accountnumber,shortcode,amount,details,transfertype) 
                        VALUES ('$user_id','$transaction_id','$bank_name','$bank_address','$country','$account_name','$account_number','$short_code','$amount','$transfer_details','$transfer_type')";                $result = mysqli_query($dbconnect,$sql);
                if ($result) {
                    echo json_encode(['msg'=>'successfully posted']);
                    
                }else{
                    echo json_encode(['msg'=>'server error']);
                }        
            }
            
    }else{
        echo 'not set';
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
              <a href="apps_bank_ltransfer.php">
                <div class="icon-w">
                  <div class="os-icon os-icon-grid"></div>
                </div>
                <span>Account Transactions</span></a>
              <div class="sub-menu-w">
                <div class="sub-menu-header">
                  History
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-grid"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="apps_bank_deposit.php">Approve Transactions</a>
                    </li>
                    <li>
                      <a href="apps_bank_ltransfer.php">Edit Balance</a>
                    </li>
                    <li>
                      <a href="apps_bank_itransfer.php">Closing Balance</a>
                    </li>
                  </ul>
                </div>
              </div>
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
        <div class="content-w">
          <div class="content-i">
            <div class="content-box">
              <div class="element-wrapper compact pt-4">
                <div class="element-actions">
                  <a class="btn btn-primary btn-sm" href="apps_bank_deposit.php"><i class="os-icon os-icon-ui-22"></i><span>Deposit</span></a><a class="btn btn-primary btn-sm" href="apps_bank_ltransfer.php"><i class="os-icon os-icon-grid-10"></i><span>Local Transfer</span></a><a class="btn btn-success btn-sm" href="apps_bank_itransfer.php"><i class="os-icon os-icon-grid-10"></i><span>International Transfer</span></a>
                </div>	
                <h6 class="element-header">
                  Financial Overview
                </h6>
                <div class="element-box-tp">
                  <div class="row">
                    <div class="col-lg-7 col-xxl-6">
                      <!--START - BALANCES-->
                      <div class="element-balances">
                        <div class="balance hidden-mobile">
                          <div class="balance-title">
                            Total Balance
                          </div>
                          <div class="balance-value">
                            <span>£2,108,800</span><span class="trending trending-down-basic"><span>%12</span><i class="os-icon os-icon-arrow-2-down"></i></span>
                          </div>
                          <div class="balance-link">
                            <a class="btn btn-link btn-underlined" href="#"><span>View Statement</span><i class="os-icon os-icon-arrow-right4"></i></a>
                          </div>
                        </div>
                        <div class="balance">
                          <div class="balance-title">
                            Credit Available
                          </div>
                          <div class="balance-value">
                            £1,922,350
                          </div>
                          <div class="balance-link">
                            <a class="btn btn-link btn-underlined" href="#"><span>Request Increase</span><i class="os-icon os-icon-arrow-right4"></i></a>
                          </div>
                        </div>
                        <div class="balance">
                          <div class="balance-title">
                            Due Today
                          </div>
                          <div class="balance-value danger">
                            £18,645
                          </div>
                          <div class="balance-link">
                            <a class="btn btn-link btn-underlined btn-gold" href="#"><span>Pay Now</span><i class="os-icon os-icon-arrow-right4"></i></a>
                          </div>
                        </div>
                      </div>
                      <!--END - BALANCES-->
                    </div>
                    <div class="col-lg-5 col-xxl-6">
                      <!--START - MESSAGE ALERT-->
                      <div class="alert alert-warning borderless">
                        <h5 class="alert-heading">
                          Essential Verification
                        </h5>
                        <p>
                          Verify the beneficiary account info before initiating funds transfer. Minimum Amount transferable is £50 and the maximum is your available balance. Funds availability may take 2-3 working days owing to Transfer request authetication.
                        </p>
                        <div class="alert-btn">
                          <a class="btn btn-white-gold"><i class="os-icon os-icon-ui-92"></i><span>NOTICE</span></a>
                        </div>
                      </div>
                      <!--END - MESSAGE ALERT-->
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7 col-xxl-6">
                  <!--START - CHART-->
                  <div class="element-wrapper">
                    <div class="element-box">
                      <div class="element-actions">
                        <div class="form-group">
                          <select class="form-control form-control-sm">
                            <option selected="true">
                              Last 90 days
                            </option>
                            <option>
                              This Week
                            </option>
                            <option>
                              This Month
                            </option>
                            <option>
                              Today
                            </option>
                          </select>
                        </div>
                      </div>
                      <h5 class="element-box-header">
                        Balance History
                      </h5>
                      <div class="el-chart-w">
                        <img height="190" width="300" src="./img/linechart.gif"/>
                      </div>
                    </div>
                  </div>
                  <!--END - CHART-->
                </div>
				
                <div class="col-lg-5 col-xxl-6">
                  <!--START - Money Withdraw Form-->
                  <div class="element-wrapper">
                    <div class="element-box">
                      <form id="transfer-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h5 class="element-box-header">
                          Local Transfer
                        </h5>
                        <div class="row">
							<div class="col-sm-12">						
                            <div class="form-group">
                              <label class="lighter" for="">Enter Amount</label>
                              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <input class="form-control" placeholder="Enter Amount..." type="text" value="0" id="amount" name="amount">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    GBP
                                  </div>
                                </div>
                              </div>
							  </div>
                            </div>
							<!--div class="form-group">
                              <label class="lighter" for="">Bank Name</label>                              
                                <input class="form-control" placeholder="Enter Amount..." type="text" value="0">
                                <div class="input-group-append">                              
                                </div>                    
                            </div-->
						  <!--div class="col-sm-12">
						  <div class="form-group"-->
						  <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Bank Name</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter Bank Name" required="required" type="text" id="bank_name" name="bank_name">                                
                            </div>
                          </div>
                          <div class="col-sm-12">
						  <div class="form-group">
							  <label class="lighter" for="">Bank Address</label><textarea class="form-control" rows="2" placeholder="Enter Bank Address" required="required" id="bank_address" name="bank_address"></textarea>
							</div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Country</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter Bank Country" required="required" type="text" id="country" name="country">                                
                            </div>
                          </div>
                          <input type="submit" id="hidden_submit" value="sub" hidden/>
						  <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Account Name</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Account Name" required="required" type="text" id="account_name" name="account_name">                                
                            </div>
                          </div>
						  <div class="col-sm-12">
                            <div class="form-group">								
                              <label class="lighter" for="">Account Number</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter Account Number" required="required" type="text" id="account_number" name="account_number">                                
                            </div>
                          </div>
                          <div class="col-sm-12">
						  <div class="form-group">
							  <label class="lighter" for="">Transfer Details</label><textarea class="form-control" rows="2" placeholder="Enter Transfer Details" required="required" id="transfer_details"  name="transfer_details" ></textarea>
							</div>
                          </div>
                         <div class="col-sm-12">
						  <div class="form-group">
							  <label class="lighter" for="">Type</label><select class="form-control" required id="transfer_type" name="transfer_type">
							      <option value="credit" disabled>select a type of transfer</option>
							      <option value="credit">Credit</option>
							      <option value="debit">Debit</option>
							  </select>
							</div>
                          </div>
						  <div class="col-sm-12">
                            <div class="form-group">	
                              <label class="lighter" for="">Sort Code/Routing Number</label><input class="form-control" data-error="Enter Correct Account Info" placeholder="Enter Sort Code/Routing Number" required="required" type="text" id="short_code" name="short_code">                                
                            </div>
                          </div>
                        </div>
                        <div class="form-buttons-w text-right compact">
                          <!--button class="mr-2 mb-2 btn btn-primary" data-target="#onboardingFormModal" data-toggle="modal" type="button"><a class="btn btn-primary" href="#"><span>Transfer</span><i class="os-icon os-icon-grid-18"></i></a-->
						  <!--a class="mr-2 mb-2 btn btn-primary" data-target="#onboardingFormModal" data-toggle="modal"><span>TF</span><i class="os-icon os-icon-grid-18"></i></a-->
						  <!--button class="mr-2 mb-2 btn btn-primary" data-target="#onboardingFormModal" data-toggle="modal" type="button"><a class="btn btn-primary" href="#"><span>Transfer</span><i class="os-icon os-icon-grid-18"></i></a-->
                        <!--Button trigger modal><button class="mr-2 mb-2 btn btn-primary" data-target="#onboardingWideSlideModal" data-toggle="modal" type="button">Multistep modal with slider</button-->
						<!--div class="mb-4"-->
						<button class="mr-2 mb-2 btn btn-primary" id="transfer-btn" data-target="#onboardingWideSlideModal" data-toggle="modal" type="button">Transfer<span></span><i class="os-icon os-icon-grid-18"></i></button>
       <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideSlideModal" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg modal-centered" role="document">
        <div class="modal-content text-center">
          <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="close-label">Cancel Transfer</span><span class="os-icon os-icon-close"></span></button>
          <div class="onboarding-slider-w">
            <div class="onboarding-slide">
              <div class="onboarding-side-by-side">
                <div class="onboarding-media">
                  <img alt="" src="img/bigicon2.png" width="200px">
                </div>
                <div class="onboarding-content with-gradient">
                  <h4 class="onboarding-title">
                    Two-Way Security Authentication
                  </h4>
                  <div class="onboarding-text">
                    This is a Two-Way Security Authentication for the transaction you are about to perform. 
                  </div>
                </div>
              </div>
            </div>
			<div class="onboarding-slide">
              <div class="onboarding-side-by-side">
                <div class="onboarding-media">
                  <img alt="" src="img/bigicon6.png" width="200px">
                </div>
                <div class="onboarding-content with-gradient">
                  <h4 class="onboarding-title">
                    Transaction Requirements
                  </h4>
                  <div class="onboarding-text">
                    The operation you are performing requires the provision of A Security Authentication Code for processing; consider the transaction requirements below and continue.
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <ul class="features-list">
                        <li>
                          Two-Way Security Authentication Code
                        </li>  
                      </ul>
                    </div>
                    <div class="col-sm-6">
                      <ul class="features-list">
                        <li>
                          Accept Terms &  Conditions
                        </li>                       
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<div class="onboarding-slide">
              <div class="onboarding-side-by-side">
                <div class="onboarding-media">
                  <img alt="" src="img/bigicon5.png" width="200px">
                </div>
                <div class="onboarding-content with-gradient">
                  <h4 class="onboarding-title">
                    Two-Way Security Authentication
                  </h4>
                  <div class="onboarding-text">
                    Please enter Two-Way Security Authentication Code to continue. Request your pin from your Account Office Support Center.<br>
NOTE: Do not share your Transaction Two-Way Authentication Security Code to avoid account compromise. Contact support@fortehousecapital.com 
                  </div>
                  <form id="otp-form">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="">Enter Code here</label><input class="form-control" placeholder="Enter code..." type="text" id="otp">
                        </div>
                      </div>
                      <div class="col-sm-12" id="result">
                          
                      </div>
                    </div>
                  </form>
					<div class="modal-footer">
					<button class="btn btn-secondary" data-dismiss="modal" type="button"> Cancel</button><button id="verify-otp-button" class="btn btn-primary" type="button"> Confirm Transfer</button>
					</div>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
						</div>
                      </form>
                    </div>
                  </div>
                  <!--END - Money Withdraw Form-->
				  
                </div>
              </div>
              <!--START - Transactions Table-->
              <div class="element-wrapper">
                <h6 class="element-header">
                  Recent Transactions
                </h6>
                <div class="element-box-tp">
                  <div class="table-responsive">
                  <table class="table table-padded">
                      <thead>
                        <tr>
						<th>
                            Transaction ID
                          </th>
                          <th>
                           Transaction Status
                          </th>
                          <th>
                            Date
                          </th>
                          <th>
                            Transaction Details
                          </th>
                          <th class="text-center">
                            Type
                          </th>
                          <th class="text-right">
                            Amount
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                            $user = $_SESSION['user_id'];
                            transac($dbconnect,$user);
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--END - Transactions Table--><!--------------------
              START - Color Scheme Toggler
              -------------------->
              <div class="floated-colors-btn second-floated-btn">
                <div class="os-toggler-w">
                  <div class="os-toggler-i">
                    <div class="os-toggler-pill"></div>
                  </div>
                </div>
                <span>Dark </span><span>Colors</span>
              </div>

              <div class="floated-chat-btn">
                <i class="os-icon os-icon-mail-07"></i><span>Chat Support</span>
              </div>
              <div class="floated-chat-w">
                <div class="floated-chat-i">
                  <div class="chat-close">
                    <i class="os-icon os-icon-close"></i>
                  </div>
                  <div class="chat-head">
                    <div class="user-w with-status status-green">
                      <div class="user-avatar-w">
                        <div class="user-avatar">
                          <img alt="" src="img/avatar1.png">
                        </div>
                      </div>
                      <div class="user-name">
                        <h6 class="user-title">
                          John Mayers
                        </h6>
                        <div class="user-role">
                          Account Manager
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="chat-messages">
                    <div class="message">
                      <div class="message-content">
                        Hi, how can I help you?
                      </div>
                    </div>
                    <div class="date-break">
                      Mon 10:20am
                    </div>
                    <div class="message">
                      <div class="message-content">
                        Hi, my name is Mike, I will be happy to assist you
                      </div>
                    </div>
                    <div class="message self">
                      <div class="message-content">
                        Hi, I am having challenges with a transfer I did some time ago, could you confirm the status for me plz?
                      </div>
                    </div>
                  </div>
                  <div class="chat-controls">
                    <input class="message-input" placeholder="Type your message here..." type="text">
                    <div class="chat-extra">
                      <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <!--------------------
              END - Chat Popup Box
              -------------------->
            </div>
          </div>
        </div>
      </div>
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
    <script src="js/transfer.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      
      ga('create', 'UA-XXXXXXX-9', 'auto');
      ga('send', 'pageview');
    </script>
	<footer>
  <div>Secure Login - Forte House Capital: Member of BENTLEY REID (c) 2020 All Rights Reserved 
  </div>
  </footer>
  </body>
  
</html>