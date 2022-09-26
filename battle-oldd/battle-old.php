<?php 
session_start();

    include("showUsers.php");
    include "battle_header.php";
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/w3.css">
    <link rel="stylesheet" href="../style/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <title>Posigraph </title>
    <link rel="icon" type="image/x-icon" href="https://posigraph.com/posi_favicon.png">
    <style>
    .new-user {
        /* height: 280px; */
        /* overflow-x: hidden;
        overflow-y: scroll; */
    }

    .requested-user {
        height: 300px;
        /* overflow-x: hidden;
        overflow-y: scroll; */
        margin-top: 5px;
        /* box-shadow: 3px 3px 10px 5px #ccc;
        border-radius: 15px; */
    }

    .known-user {
        height: 590px;
    }

    .known-user .request-list {
        /* height: 275px; */
        /* overflow-x: hidden;
        overflow-y: scroll;
        box-shadow: 3px 3px 10px 5px #ccc; */
    }

    .known-user .friend-list {
        height: 300px;
        background: gray;
        overflow-x: hidden;
        overflow-y: scroll;
        margin-top: 10px;
        box-shadow: -1px 10px 100px 5px green;
        border-radius: 10px;
    }

    .user-detail {
        /* width: 270px;
        height: auto;
        margin: 5px; */
        /* padding: 0; */
    }

    .user-pic img {
        height: 90px;
        width: 90px;
        border-radius:50%;
    }

    .user-detail .user-name-buttons {
        margin-top: 5px;
    }

    .user-detail .user-name-buttons p {
        font-size: 16px;
    font-family: sans-serif;
    }

    .user-detail .user-name-buttons button {
        width: 100px;
        padding: 4px 10px;
        font-size: 15px;
        outline: none;
        border: none;
        border-radius: 100px;
    }

    .friend-pic img {
        height: 90px;
        width: 90px;
        border-radius:50%;
    }

    .user-detail .user-name-buttons a{
    text-decoration: none;
    text-align: center;
    width: 100%;
    }

    </style>

</head>

<body>
    <div class="container-fluid" style="margin-bottom:100px;">
        
        <div class="row">
            <div class="col-md-12 all-user" style="margin-top: 60px;">                
            <div class="col-md-12 friend-list">
                <h3>Current Battle Competitors</h3>
                <div class='row'>
                    <?php  battle();?>
                </div>                
            </div>
</div>
        </div>

        <div class="row">
            <div class="col-md-12 all-user" style="margin-top: 60px;">                
            <div class="col-md-12 friend-list">
                <h3>Suggestion For Battle</h3>
                <div class='row'>
                    <?php  myFriends();?>
                </div>                
            </div>
</div>
        </div>

        <div class="row">
            <div class="col-md-12 known-user">
                <div class="col-md-12 request-list">
                
                <h3>Battle Request Sent</h3>
                <div class='row'>
                <?php meToUsers();?>
</div>
        </div>
        
        <div class="col-md-12 requested-user">
                <h3>Battle Request Recived</h3>
                <div class='row'>
                <?php usersToMe();?><br><br>
</div>
                </div>
                <br><br>
            </div>
        </div>

    </div>



</body>

<script>
function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
    } else {
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className =
            x.previousElementSibling.className.replace(" w3-theme-d1", "");
    }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}


$(".request-btn").click(function() {
    var $this = $(this);
    userId = $this.data("id");
    userName = $this.data("name");
    buttonName = "request";
    callFun = new FormData();
    callFun.append("buttonName", buttonName);
    callFun.append("userId", userId);
    // window.alert(userId);
    callFun.append("userName", userName);

    $.ajax({
        method: 'post',
        url: "functions.php",
        cache: false,
        data: callFun,
        contentType: false, // error if both are absent in ajax code 
        processData: false,

        success: function(result) {
            //                                                     window.open('home.php','_self');
            // window.alert(result);
            window.open('battle.php', '_self');
        },
        error: function(result) {
            window.alert(" sorrry error {request}");
        }
    });


});

$(".battle-btn").click(function() {
    var $this = $(this);
    userId = $this.data("id");
    userName = $this.data("name");
    buttonName = "requests";
    callFun = new FormData();
    callFun.append("buttonName", buttonName);
    callFun.append("userId", userId);
    // window.alert(userId);
    callFun.append("userName", userName);

    $.ajax({
        method: 'post',
        url: "functions.php",
        cache: false,
        data: callFun,
        contentType: false, // error if both are absent in ajax code 
        processData: false,

        success: function(result) {
            //                                                     window.open('home.php','_self');
            // window.alert(result);
            window.open('battle.php', '_self');
        },
        error: function(result) {
            window.alert(" sorrry error {request}");
        }
    });


});


$(".cancel-btn").click(function() {
    var $this = $(this);
    userId = $this.data("id");
    userName = $this.data("name");
    buttonName = "cancel";
    callFun = new FormData();
    callFun.append("buttonName", buttonName);
    callFun.append("userId", userId);
    callFun.append("userName", userName);
   
    $.ajax({
        method: 'post',
        url: "functions.php",
        cache: false,
        data: callFun,
        contentType: false, // error if both are absent in ajax code 
        processData: false,

        success: function(result) {
            //                                                     window.open('home.php','_self');
            window.alert(result);
            window.open('battle.php', '_self');
        },
        error: function(result) {
            window.alert(" sorrry error {cancel}");
        }
    });
});

$(".ignore-btn").click(function() {
    var $this = $(this);
    userId = $this.data("id");
    userName = $this.data("name");
    buttonName = "ignore";
    callFun = new FormData();
    callFun.append("buttonName", buttonName);
    callFun.append("userId", userId);
    callFun.append("userName", userName);
    
    $.ajax({
        method: 'post',
        url: "functions.php",
        cache: false,
        data: callFun,
        contentType: false, // error if both are absent in ajax code 
        processData: false,

        success: function(result) {
            //                                                     window.open('home.php','_self');
            window.alert(result);
            window.open('battle.php', '_self');

        },
        error: function(result) {
            window.alert(" sorrry error {ignored}");
        }
    });
});

$(".accept-btn").click(function() {
    var $this = $(this);
    userId = $this.data("id");
    userName = $this.data("name");
    buttonName = "accept";
    callFun = new FormData();
    callFun.append("buttonName", buttonName);
    callFun.append("userId", userId);
    callFun.append("userName", userName);
    window.alert(userId);

    $.ajax({
        method: 'post',
        url: "functions.php",
        cache: false,
        data: callFun,
        contentType: false, // error if both are absent in ajax code 
        processData: false,

        success: function(result) {
            //                                                     window.open('home.php','_self');
            window.alert(result);
            window.open('friends.php', '_self');
        },
        error: function(result) {
            window.alert(" sorrry error {accepted}");
        }
    });
});

$(".unfriend-btn").click(function() {
    var $this = $(this);
    userId = $this.data("id");
    userName = $this.data("name");
    buttonName = "unfriend";
    callFun = new FormData();
    callFun.append("buttonName", buttonName);
    callFun.append("userId", userId);
    callFun.append("userName", userName);
    window.alert(userId);

    $.ajax({
        method: 'post',
        url: "functions.php",
        cache: false,
        data: callFun,
        contentType: false, // error if both are absent in ajax code 
        processData: false,

        success: function(result) {
            //                                                     window.open('home.php','_self');
            window.alert(result);
            window.open('friends.php', '_self');
        },
        error: function(result) {
            window.alert(" sorrry error occured {unfriend}");
        }
    });
});
</script>
<style>

</style>

</html>