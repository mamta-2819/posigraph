<style>
.user-detail {
    
    text-align:center;
    padding: 30px;
    position: relative;
    display: block;
    background: #fff;
    color: #000;
    /* box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; */
    margin: 15px 0;
}

.name-tilte {
    font-size: 16px;
    font-weight: 700;
    color: #0a69ed;
    /* margin-top: 30px; */
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
</style>

<?php
// session_start();
include("connection.php");
$database="posigraph_socialplexus";
mysqli_select_db($conn,$database);

$me=$_SESSION['id'];

function newUsers()
{     global $conn ,$me;
      $i=0;
      $friendId[]=0;
 //when someone sent rqst to me get Id from userTwo
 $id="select senderId from battle_request where receiverId=$me";
     $sender=mysqli_query($conn,$id);
    if($sender)
    {
     if(mysqli_num_rows($sender)>= 1)
     {  
           while($row=mysqli_fetch_array($sender))
           {               
                     $friendId[$i]=$row['senderId'];               
                     $i++;  
           }             
     }
    }
 else
      mysqli_error($conn);
 
 //when someone sent rqst to me get Id from userTwo
 $id="select receiverId from battle_request where senderId=$me";
     $receiver=mysqli_query($conn,$id);
    if($receiver)
    {
     if(mysqli_num_rows($receiver)>= 1)
     {  
           while($row=mysqli_fetch_array($receiver))
           {
               
                     $friendId[$i]=$row['receiverId'];
               
                     $i++;  
           }             
     }
    }
 else
      mysqli_error($conn);
    
        $str =implode(',', $friendId);
 
/////////////////////////////////////////////////////////////////////////////////////////
    $query=" select userId ,firstName ,dp from user where userId NOT IN($str,$me)";
    $newUser=mysqli_query($conn,$query);
    if($newUser)
    {
        if(mysqli_num_rows($newUser) >= 1)
        {
            while($row=mysqli_fetch_array($newUser))
            {
                echo"
                    
                    <div class='col-6 col-md-4 user-detail'>

                               <div class='col-sm-4 user-pic'> 
                               <img src='../proImg/pro.jpg'> 
                               </div>
                        <div class='col-sm-7 user-name-buttons'> 
                        
                             <div class=' row name'>
                                  <a href='peopleProfile.php'><p style='margin:10px 10px;'>{$row['firstName']}</p></a>
                             </div>
                             
                           <div class='row btn'>
                             <a id='request' href='#'><button data-id='{$row['userId']}'         data-name='{$row['firstName']}' class='request-btn' >Request</button>
                             </a>
                            </div>

                        </div>

                   </div>
                 
                  ";
            }
        }
        
    }
    else
        mysqli_error($conn);    
}

function SgstdUser(){
    $friendId=rqstdAndRqstng(1);    
    $str =implode(',', $friendId);
$strr=myF(1);
$strr=implode(',', $strr);
    
//var_dump($strr);
// return $str;
     $query=" select userId ,firstName ,dp from user where userId IN() AND userId NOT IN($str,$strr) ";
    $newUser=mysqli_query($conn , $query);
    if($newUser)
    {
        if(mysqli_num_rows($newUser) >= 1)
        {
            while($row=mysqli_fetch_array($newUser))
            {
                echo"    
                <div class= 'row'>                
                    <div class='col-sm-6 user-detail'>

                               <div class='col-sm-4 user-pic'>
                                <img src='../proImg/pro.jpg'>
                                 </div>
                        <div class='col-sm-7 user-name-buttons'> 
                        
                             <div class=' row name'>
                                  <a href='peopleProfile.php'><p style='margin:10px 10px;'>{$row['firstName']}</p></a>
                             </div>
                             
                           <div class='row btn'>
                             <a id='request' href='#'><button data-id='{$row['userId']}'         data-name='{$row['firstName']}' class='request-btn' >Request</button>
                             </a>
                            </div>

                        </div>

                   </div>
                 </div>
                  ";
            }
        }
        
    }
    else
        mysqli_error($conn);
    
//  echo"<script>window.alert('{$str},{$strr}')</script>";
  
}
function rqstdAndRqstng($me)
{     global $conn;
      $i=0;
      $friendId[]=0;
// 
 
 $id="select senderId from battle_request where receiverId=$me";//when someone sent rqst to me get Id from userTwo
     $sender=mysqli_query($conn,$id);
    if($sender)
    {
     if(mysqli_num_rows($sender)>= 1)
     {  
           while($row=mysqli_fetch_array($sender))
           {
               
                     $friendId[$i]=$row['senderId'];
               
                     $i++;  
           }             
     }
    }
 else
      mysqli_error($conn);
 
 
 $id="select receiverId from battle_request where senderId=$me";//when someone sent rqst to me get Id from userTwo
     $receiver=mysqli_query($conn,$id);
    if($receiver)
    {
     if(mysqli_num_rows($receiver)>= 1)
     {  
           while($row=mysqli_fetch_array($receiver))
           {               
                     $friendId[$i]=$row['receiverId'];
               
                     $i++;  
           }             
     }
    }
 else
      mysqli_error($conn);
 
return $friendId;
  }


function meToUsers()
{
    global $conn,$me;
    $query="select receiverId from battle_request where senderId='$me'";
    $requestedUser=mysqli_query($conn,$query);
    if($requestedUser)
    {
        if(mysqli_num_rows($requestedUser) >= 1)
        {
           
            while($row=mysqli_fetch_array($requestedUser))
            {     
                 $query="select userId, firstName ,dp from user where userId={$row['receiverId']}";
                  $nameDp=mysqli_query($conn,$query);
                  $receiverNameDp=mysqli_fetch_array($nameDp);
                //   print_r($receiverNameDp['dp']);exit();
                // echo $row['receiverId'].'<br>';
                echo"
                <div class= 'row'>  
                    <div class='col-sm-6 user-detail'>

                               <div class='user-pic'> 
                               <img src=../dp/{$receiverNameDp['dp']}> 
                               </div>
                        <div class='user-name-buttons'> 
                        
                             <div class='name'>
                                  <a href='https://posigraph.com/ajit/profile/profile.php?id={$row['receiverId']}'>
                                  <p class='name-tilte'>{$receiverNameDp['firstName']}</p>
                                  </a>
                             </div>
                             
                           <div class='btn'>
                             <a id='request' href='#'><button data-id='{$row['receiverId']}'      data-name='{$receiverNameDp['firstName']}' class='btn btn-success cancel-btn' >cancel</button></a>
                            </div>

                        </div>

                   </div>
                 </div>
                  ";
            }
        }
        else
        echo "
        <div class='col-6 col-md-4 user-detail'>
            <p class='name-tilte text-danger'>Currently, You not request battle to any friend!!</p>
        </div>";
        
    }
    else
        mysqli_error($conn);
}


function usersToMe()
{
    global $conn,$me;
    $query="select senderId  from battle_request where receiverId='$me'";
    $requestedUser=mysqli_query($conn,$query);
    if($requestedUser)
    {
        if(mysqli_num_rows($requestedUser) >= 1)
        {
            while($row=mysqli_fetch_array($requestedUser))
            {
                 $query="select firstName ,dp from user where userId={$row['senderId']}";
                  $nameDp=mysqli_query($conn,$query);
                  $senderNameDp=mysqli_fetch_array($nameDp);
                echo"
                    
                     <div class='col-6 col-md-4 user-detail'>

                           <div class='user-pic'> 
                                 <img src='../proImg/pro.jpg'>    
                            </div>

                            <div class='user-name-buttons'>
                       
                                    <div class=' name'>
                                      <a href='https://posigraph.com/ajit/profile/profile.php?id={$row['senderId']}'>
                                      <p class='name-tilte'>{$senderNameDp['firstName']}</p>
                                       </a>
                                    </div>

                                    <div class=' btn'>

                                     <a href='#'>
                                    <button data-id='{$row['senderId']}'  data-name='{$senderNameDp['firstName']}' class='btn btn-success accept-btn'>accept</button>
                                     </a>
                                     <a href='#'>
                                    <button data-id='{$row['senderId']}'  data-name='{$senderNameDp['firstName']}' class='btn btn-danger ignore-btn'>ignore</button>
                                     </a>
                       
                                    

                            </div> 
                 </div>
                 
                  ";                                                  
            }
        }  
        else
        echo "
        <div class='col-6 col-md-4 user-detail'>
            <p class='name-tilte text-danger'>Currently, No request for battle from any friend!!</p>
        </div>";

    }
    else
        mysqli_error($conn);    
}

function myFriends()
{
//    friendsOfFriend(1);
//    rqstdAndRqstng(1);
//    SgstdUser(1);

    global $conn,$me;
    // when i'am 1st col,get friend Id from userTwo
  $query="select userOne,userTwo from friends where userOne=$me or userTwo=$me";
     $friends=mysqli_query($conn,$query);
    if($friends)
    {
     if(mysqli_num_rows($friends)>= 1)
     {  
           while($row=mysqli_fetch_array($friends))
           {               
                  if($row['userOne']==$me)
                  {
                    $query="select userId,firstName ,dp from user where userId={$row['userTwo']}";
                    $nameDp=mysqli_query($conn,$query);
                    $friend=mysqli_fetch_array($nameDp);

                    $query2="select * from battle_request";
                    $nameDp2=mysqli_query($conn,$query2);
                    $battle=mysqli_fetch_array($nameDp2);
                      
                    if($friend['userId']==$battle['senderId'] || $friend['userId']==$battle['receiverId'])
                      {
                      echo"

                        <div class='col-6 col-md-4 user-detail'>

                               <div class=''>
                                     <div class='friend-pic round-pic'> 
                                           <img src='../proImg/pro.jpg'>    
                                      </div>
                               </div>

                              <div class=' user-name-buttons'> 
                                  <div class='row name'><a href='https://posigraph.com/posigraph.com/ajit/profile/profile.php?id={$friend['userId']}'>
                                  <p class='name-tilte'>{$friend['firstName']}</p></a></div>
                                 <div class='row btn'> <a href='#'>
                                 <button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class='battle-btn btn-sm btn-success'>Start Battle</button></a>
                                  </div>

                              </div>
                            </div>
                    
                                        
                        ";                      
                  }
                  else
                  echo "
                     <div class='col-6 col-md-4 user-detail'>
                         <p class='name-tilte text-danger'>Currently no friend for battle!!</p>
                     </div>";
                    }
                 else
                 {
                    $query="select userId,firstName ,dp from user where userId={$row['userOne']}";
                      $nameDp=mysqli_query($conn,$query);
                      $friend=mysqli_fetch_assoc($nameDp);                     
                    
                      $query2="select * from battle_request";
                      $nameDp2=mysqli_query($conn,$query2);
                      $count= 0;
                      while($battle=mysqli_fetch_array($nameDp2))
                      {
                        if($friend['userId']==$battle['senderId'] || $friend['userId']==$battle['receiverId'])
                        {
                            $count=1;
                        }
                      }
                     if($count==0) 
                    {
                      echo"
                          <div class='col-6 col-md-4 user-detail'>

                                 <div class=''>
                                       <div class='friend-pic round-pic'> 
                                             <img src='../proImg/pro.jpg'>    
                                        </div>
                                 </div>

                                <div class='user-name-buttons'> 
                                    <div class='name'><a href='https://posigraph.com/ajit/profile/profile.php?id={$friend['userId']}'>
                                    <p class='name-tilte'>{$friend['firstName']}</p>
                                    </a></div>
                                   <div class='btn'> <a href='#'>
                                   <button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class='battle-btn btn-sm btn-success'>Start Battle</button></a>
                                   </div>

                                </div>

                              </div> 
                 
                        "; 
                 }
                 else
                 echo "
                    <div class='col-6 col-md-4 user-detail'>
                        <p class='name-tilte text-danger'>Currently no friend for battle!!</p>
                    </div>";
                }
           }             
     }

    }
 else
      mysqli_error($conn);
}

function battle()
{
    global $conn,$me;
    $type='';
    $query="select * from battle where player1_id=$me or player2_id=$me";
     $friends=mysqli_query($conn,$query);
    if($friends)
    {
     if(mysqli_num_rows($friends)>= 1)
     {  
           while($row=mysqli_fetch_array($friends))
           {       
             
                  if($row['player1_id']==$me)
                  {
                     $query="select userId,firstName ,dp from user where userId={$row['player2_id']}";
                      $nameDp=mysqli_query($conn,$query);
                      $friend=mysqli_fetch_array($nameDp);
                        $type= 'p2';
                      if($row['player1_post']=='')
                        $but1 = "<a href='../add_battle.php?bid=".$row['battle_id']."&&pid=".$friend['userId']."&&type=".$type."'><button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class='battle-btn btn-sm btn-success' style='width:fit-content;'>Upload Picture</button></a>";
                      else
                        $but1 = "<a href='#'><button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class='battle-btn btn-sm btn-success' style='width:fit-content;'>Picture Uploaded</button></a>";
                          
                       echo"
                        <div class='col-6 col-md-4 user-detail'>

                               <div class=''>
                                     <div class='friend-pic round-pic'> 
                                           <img src='../proImg/pro.jpg'>    
                                      </div>
                               </div>

                            <div class=' user-name-buttons'> 
                                <div class='row name'><a href='https://posigraph.com/posigraph.com/ajit/profile/profile.php?id={$friend['userId']}'>
                                 <p class='name-tilte'>{$friend['firstName']}</p></a>
                                </div>
                                <div class='row btn'> 
                                $but1 
                                </div>

                              </div>
                            </div>
                    
                                        
                        ";                      
                  }
                  
                 else
                 {
                    $query="select userId,firstName ,dp from user where userId={$row['player1_id']}";
                    $nameDp=mysqli_query($conn,$query);
                    $friend=mysqli_fetch_assoc($nameDp);                     
                    $type= 'p1';
                    if($row['player2_post']=='')
                    $but2 = "<a href='../add_battle.php?bid=".$row['battle_id']."&&pid=".$friend['userId']."&&type=".$type."'><button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class='upload-btn btn-sm btn-success' style='width:fit-content;'>Upload Picture</button></a>";
                    else
                    $but2 = "<a href='#'><button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class=' btn-sm btn-success' style='width:fit-content;'>Picture Uploaded</button></a>";
                        
                     
                      echo"
                          <div class='col-6 col-md-4 user-detail'>

                                 <div class=''>
                                       <div class='friend-pic round-pic'> 
                                             <img src='../proImg/pro.jpg'>    
                                        </div>
                                 </div>

                                <div class='user-name-buttons'> 
                                    <div class='name'><a href='https://posigraph.com/ajit/profile/profile.php?id={$friend['userId']}'>
                                    <p class='name-tilte'>{$friend['firstName']}</p>
                                    </a></div>
                                   <div class='btn'> 
                                   $but2
                                   </div>

                                </div>

                              </div> 
                 
                        "; 
                 }
                 
                }
           }
           else
                 echo "
                    <div class='col-6 col-md-4 user-detail'>
                        <p class='name-tilte text-danger'>Currently no friend for battle!!</p>
                    </div>";             
     }

    
 else
      mysqli_error($conn);
}


// get my all friends in index
function get_all_myFriends()
{
    global $conn,$me;
    
  $query="select userOne,userTwo from battle_request_accepted where userOne=$me or userTwo=$me";// when i'am 1st col,get friend Id from userTwo
     $friends=mysqli_query($conn,$query);
    if($friends)
    {
     if(mysqli_num_rows($friends)>= 1)
     {  
           while($row=mysqli_fetch_array($friends))
           {               
                  if($row['userOne']==$me)
                  {
                     $query="select userId,firstName ,dp from user where userId={$row['userTwo']}";
                      $nameDp=mysqli_query($conn,$query);
                      $friend=mysqli_fetch_array($nameDp);
                      
                      echo"
                        
                        <div class='col-6 col-md-4 user-detail'>

                               <div class=''>
                                     <div class='friend-pic round-pic'> 
                                           <img src='../proImg/pro.jpg'>    
                                      </div>
                               </div>

                              <div class=' user-name-buttons'> 
                                  <div class='row name'><a href='https://posigraph.com/posigraph.com/ajit/profile/profile.php?id={$friend['userId']}'>
                                  <p class='name-tilte'>{$friend['firstName']}</p></a></div>
                                 <div class='row btn'> <a href='#'>
                                  <button data-id='{$friend['userId']}'  data-name='{$friend['firstName']}' class='btn btn-success unfriend-btn'>Unfriend</button></a>
                                  </div>

                              </div>
                            </div>
                    
                                        
                        ";                      
                  }
                 else
                 {
                    $query="select userId,firstName ,dp from user where userId={$row['userOne']}";
                      $nameDp=mysqli_query($conn,$query);
                      $friend=mysqli_fetch_array($nameDp);
                      
                      echo"hello2
                          <div class='col-6 col-md-4 user-detail'>

                                 <div class=''>
                                       <div class='friend-pic round-pic'> 
                                             <img src='../proImg/pro.jpg'>    
                                        </div>
                                 </div>

                                <div class='user-name-buttons'> 
                                    <div class='name'><a href='https://posigraph.com/ajit/profile/profile.php?id={$friend['userId']}'>
                                    <p class='name-tilte'>{$friend['firstName']}</p>
                                    </a></div>
                                   <div class='btn'> <a href='#'>
                                   <button data-id='{$friend['userId']}' data-name='{$friend['firstName']}' class='unfriend-btn btn-sm btn-success'>Unfollow</button></a>
                                   </div>

                                </div>

                              </div> 
                 
                        "; 
                 }
           }             
     }

    }
 else
      mysqli_error($conn);
}


function myF($id)
{ global $conn;
    $i=0;
      $friendId[]=0;
    $query="select userOne,userTwo from battle_request_accepted where userOne=$id or userTwo=$id";// when i'am 1st col,get friend Id from userTwo
     $friends=mysqli_query($conn,$query);
    if($friends)
    {
     if(mysqli_num_rows($friends)>= 1)
     {  
           while($row=mysqli_fetch_array($friends))
           {
               
                  if($row['userOne']==$id)
                  {
                     $friendId[$i]=$row['userTwo'];
               
                     $i++;                       
                  }
                 else
                 {
                     $friendId[$i]=$row['userOne'];
               
                     $i++;
                      
                 }
           }
             
   return $friendId;
     }
        else
            return $friendId;

    }
 else
      mysqli_error($conn);
 
}

$GFOF="";
$Grqstd_rqstng="";
$Frnd="";

function friendsOfFriend($id)
{ global $conn,$me;
 global $GFOF, $Grqstd_rqstng, $Frnd;
    $FOF="";
 $ONE_OR_MORE="";
 $my=myF($id);
 $m=count($my);
 for($i=0;$i<$m;$i++)
 {
  $FF=myF($my[$i]);
    $str=implode(',', $FF);
     $FOF.=$str.",";
     
     
 }
 $FOF.='0';
 $GFOF=$FOF;
 
 
 $rqstd_rqstng_id=rqstdAndRqstng($id);    
    $str =implode(',', $rqstd_rqstng_id);
 $Grqstd_rqstng=$str;
 
$strr=myF($id);
$strr=implode(',', $strr);
 $Frnd=$strr;
    
     $query=" select userId ,firstName ,dp from user where userId IN($FOF) AND userId NOT IN($str,$strr,$me) ";
    $newUser=mysqli_query($conn,$query);
    if($newUser)
    {
        if(mysqli_num_rows($newUser) >= 1)
        {
            while($row=mysqli_fetch_array($newUser))
            {
                echo"
                    
                    <div class='col-6 col-md-4 user-detail'>

                               <div class=' user-pic'> 
                               <img src='../proImg/pro.jpg'>
                                </div>
                        <div class=' user-name-buttons'> 
                        
                             <div class='  name'>
                                  <a href='https://posigraph.com/ajit/profile/profile.php?id={$row['userId']}'>
                                  <p class='name-tilte'>{$row['firstName']}</p></a>
                             </div>
                             
                           <div class=' btn'>
                             <a id='request' href='#'><button data-id='{$row['userId']}'         data-name='{$row['firstName']}' class='request-btn btn btn-success' >Follow</button>
                             </a>
                            </div>
                        </div>
                   </div>                 
                  ";
            }
        }
//         <a href='https://posigraph.com/ajit/profile/profile.php?id={$id}'> <p><button>View Profile</button></p></a>
        
    }
    else
        mysqli_error($conn);
    

}


function moreSugg()
{
    global $conn,$me;
    global $GFOF, $Grqstd_rqstng, $Frnd;
 
     $query=" select userId ,firstName ,dp from user where userId NOT IN($Frnd,$Grqstd_rqstng,$me,$GFOF) ";
    $newUser=mysqli_query($conn,$query);
    if($newUser)
    {
        if(mysqli_num_rows($newUser) >= 1)
        {
            while($row=mysqli_fetch_array($newUser))
            {
                echo"                    
                    <div class='col-6 col-md-4 user-detail'>
                               <div class='user-pic'> 
                               <img src=../dp/{$row['dp']}> 
                               </div>

                              <div class='user-name-buttons'>                         
                             <div class='name'>
                                  <a href='https://posigraph.com/ajit/profile/profile.php?id={$row['userId']}'>
                                  <p style='' class='name-tilte'>{$row['firstName']}</p>
                                  </a>
                             </div>  

                           <div class='btn'>
                             <a id='request' href='#'><button data-id='{$row['userId']}' data-name='{$row['firstName']}' class='request-btn btn btn-sm btn-success' >Follow</button>
                             </a>
                            </div>
                        </div>
                   </div>                 
                  ";
            }
        }        
    }
    else
        mysqli_error($conn);    
}

?>