<?php
//function para sa login
function login($conn,$user,$pass){
    // select if username match anyone
    $sql = "SELECT * from account where acc_user=? and acc_pass=?";
    // initializing the statement 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("location: ../login.php?error=stmt-failed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"ss",$user,$pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        $userGranted = $row["acc_pass"];
        if($userGranted == $pass){
            header("location: ../dashboard.php");
            exit();
        }else{
        return false;
        }
    }else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

//check if password match retype
function retypePass($pass,$pass2){
    if($pass == $pass2){
        return true;
    }else{
        return false;
        exit();
    }
}

//function to check empty input in register
function emptyInputRegister($fname,$lname,$contact,$uname,$pass,$pass2,$email){
    $result = true;
    if(empty($fname) || empty($lname) || empty($contact) || empty($uname) || empty($pass) || empty($pass2) || empty($email)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

//function para sa register
function register($conn,$fname,$lname,$contact,$uname,$pass,$email){
    $sql = "INSERT into account (firstname,lastname,contact,acc_user,acc_pass,email) values (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header("location: ../register.php?error=stmt-failed");
        exit();
    }
    //to hash the password to make it more secure
    $hashpass = password_hash($pass,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssssss",$fname,$lname,$contact,$uname,$pass,$email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?account-create-successfully");
    exit();
}
