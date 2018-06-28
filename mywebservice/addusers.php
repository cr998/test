<?php
define("JSON", true);
function mylog($string){
    if(!JSON){
        echo $log;
    }
}
if(JSON){
    //header('Content-type: application/json');
}
require_once "../config.php";
require_once "PHPMailer/PHPMailerAutoload.php";
require_once "lib.php";
/*$json=file_get_contents($_FILES["json"]["tmp_name"]);
$json=json_decode($json);*/;
mylog($_POST["json"]);
$json=json_decode($_POST["json"]);
$response=array();
$time=time();
if(!JSON) var_dump($json);
foreach($json as $key=>$student){
    try{
        //Insert user
        $user             = new StdClass();
        $user->auth       = 'manual';
        $user->confirmed  = 1;
        $user->suspended  = 0;
        $user->mnethostid = 1;
        $user->email      = $student->email;
        $user->username   = "random".$time;
        $user->password   = "random".$time;
        $user->lastname   = $student->lastname;
        $user->firstname  = $student->firstname;
        $user->lang       = "es";
        $user->id         = $DB->insert_record('user', $user);
        

	$firstname= str_replace(' ', '', $user->firstname);
        $user->username   = remove_accents($firstname).$user->id;
        $password=$user->username.".".$student->dni[0].$student->dni[1].$student->dni[strlen($student->dni)-1];
        if (isset($CFG->passwordsaltmain)) {
             $user->password=md5($password.$CFG->passwordsaltmain);
        } else {
             $user->password=md5($password);
        }
        $DB->update_record("user", $user);

/*
        //Insert enrolment
        $enrol = $DB->get_record("enrol", array("courseid"=>$student->course, "roleid"=>5, "enrol"=>"manual"));
        $enrolment            = new StdClass();
        $enrolment->status=0;
        $enrolment->enrolid=$enrol->id;
        $enrolment->userid=$user->id;
        $enrolment->timestart=time();
        $enrolment->timeend=0;
        $enrolment->id=$DB->insert_record("user_enrolments", $enrolment);

        //Insert role context
        $context = $DB->get_record("context", array("contextlevel"=>50, "instanceid"=>$student->course));
        $role_assignment            = new StdClass();
        $role_assignment ->roleid=5;
        $role_assignment ->contextid=$context->id;
        $role_assignment ->userid=$user->id;
        $role_assignment ->timemodified=$time;
        $role_assignment ->modifierid=2;
        $role_assignment ->component="";
        $role_assignment ->itemid=0;
        $role_assignment ->sortorder=0;
        $role_assignment ->id=$DB->insert_record("role_assignments", $role_assignment);
*/
        $responseuser=array();
        $responseuser["username"]=$user->username;
        $responseuser["password"]=$password;

        $response[$key]=$responseuser;
    } catch(Exception $e){
        $responseuser=array();
        $responseuser["error"]=$e->getMessage();
        
        $response[$key]=$responseuser;
    }
    
}

echo json_encode($response);
?>