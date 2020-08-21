<?php 

$array = array("firstname" => "" , "name" => "" ,"email " => "" ,"phone" => "" ,"message" => "", "firstnameError" => "" , "nameError" => "" ,"emailError " => "" ,"phoneError" => "" ,"messageError" => "", "isSuccess" => false );

$emailTo = "safakhemiri.93@gmail.com";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["firstname"] = ($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true ;
    $emailText = "" ;


    if (empty($array["firstname"])) {
        $array["firstnameError"] = "Je veux connaitre ton prénom !";
        $array["isSuccess"]  = false ;
    }
    else $emailText .= "FirstName : {$array["firstname"]}\n";

    if (empty($array["name"])) {
        $array["nameError"] = "Je veux connaitre ton nom !";
        $array["isSuccess"]  = false ;
    }
    else $emailText .= "Name : {$array["name"]}\n" ;



    if(!isEmail($array["email"])) {
        $array["emailError"] = "Ce n'est pas un email !";
        $array["isSuccess"]  = false ;
    }
    else $emailText .= "Email : {$array["email"]} \n" ;

    if(!isPhone($array["phone"])) {
        $array["phoneError"] = "Que des chiffres et des espaces !";
        $array["isSuccess"]  = false ;
    }
    else $emailText .= "Téléphone : {$array["phone"]} \n" ;

    if (empty($array["message"])) {
        $array["messageError"] = "Qu'est ce que vous voulez dire !";
        $array["isSuccess"] = false ;
    }
    else $emailText .= "Message:  {$array["message"]}\n" ;

    // if success is true , donc envoi de email avec ttes les données 
    if($array["isSuccess"] ){
        $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]} ";
        mail($emailTo, "Objet: un message du Site", $emailText , $headers)  ; 
    }
echo json_encode($array);

}
//fonction verification email 
function isEmail($var){
    return filter_var($var , FILTER_VALIDATE_EMAIL);
}
//fonction verification telephone 
function isPhone($var) {
    return preg_match("/^[0-9 ]*$/" , $var);
}

function verifyInput($var) {
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}


?>