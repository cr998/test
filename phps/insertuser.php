<?php
header('Access-Control-Allow-Origin: *');  
$_SERVER["HTTP_REFERER"]="https://www.academiaeninternet.com/aulavirtual/";
$_SERVER['HTTP_ORIGIN']="https://www.academiaeninternet.com";
if(isset($_GET["new"])){
    $usejson=true;
    var_dump($_SERVER);
    header("Content-Type: application/json");
}else{
    $usejson=false;
}
    //caompos requeridos
    /*
        correo
        curso-----
        nombre
        apellido1
        apellido2
        dni
    */
    $resultado=array();
    $resultado["status"]="completado";
        require_once "../config.php";
        require_once "removeaccents.php";
        define('MDL_PERFTOFOOT', true);
        global $DB;
        //$DB->set_debug(true);
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
                return $randomString;
        }
    
        function sintildes($char){
            return remove_accents($char);
        }
        /*foreach($_GET as $key=>$value){
            $$key=$value;
        }*/
    
        $email=$_GET["correo"];
        $firstname=$_GET["nombre"];
        $lastname=$_GET["apellido1"]." ".$_GET["apellido2"];
        $dni=$_GET["dni"];
        $cursodata=intval($_GET["curso"]);
        if($cursodata!=0){
            $user             = new StdClass();
            $user->auth       = 'manual';
            $user->confirmed  = 1;
            $user->suspended  = 0;
            $user->mnethostid = 1;
            $user->email      = $email;
            $user->username   = generateRandomString(15);
            $user->password   = generateRandomString(15);
            $user->lastname   = $lastname;
            $user->firstname  = $firstname;
            $user->lang="es";
            $user->id         = $DB->insert_record('user', $user);
            $user->username   = "a".($user->id+2000000);
            $password=$user->username.sintildes($user->firstname)[0].sintildes($user->lastname)[0]."$";
    
    
            if (isset($CFG->passwordsaltmain)) {
                 $user->password=md5($password.$CFG->passwordsaltmain);
            } else {
                 $user->password=md5($password);
            }
    
            $DB->update_record("user", $user);
            $enrol = $DB->get_record("enrol", array("courseid"=>$cursodata, "roleid"=>5, "enrol"=>"manual"));
            $enrolment            = new StdClass();
            $enrolment->status=0;
            $enrolment->enrolid=$enrol->id;
            $enrolment->userid=$user->id;
            $enrolment->timestart=time();
            $enrolment->timeend=0;
            $enrolment->id=$DB->insert_record("user_enrolments", $enrolment);
        
            $context = $DB->get_record("context", array("contextlevel"=>50, "instanceid"=>$cursodata));
    
            $role_assignment            = new StdClass();
            $role_assignment ->roleid=5;
            $role_assignment ->contextid=$context->id;
            $role_assignment ->userid=$user->id;
            $role_assignment ->timemodified=time();
            $role_assignment ->modifierid=2;
            $role_assignment ->component="";
            $role_assignment ->itemid=0;
            $role_assignment ->sortorder=0;
            $role_assignment ->id=$DB->insert_record("role_assignments", $role_assignment);
            
            
            $user_data = new StdClass();
            $user_data->userid=$user->id;
            $user_data->fieldid=3;
            $user_data->data=$dni;
            $user_data->id=$DB->insert_record("user_info_data", $user_data);
            $headers= "Content-Type: text/html; charset=UTF-8";
            $content="<html><head><meta charset='UTF-8'></head><body>";
            $content.="<p>Hola, ".$user->firstname."</p>";
            $course_name=$DB->get_record("course", array("id"=>$cursodata))->fullname;
            $content.="<p>Se ha registrado correctamente en http://www.academiaeninternet.com,  en el curso $course_name</p>";
            $content.="<p>Su nombre de usuario y contraseña son:</p>";
            $content.="<p>Usuario: ".$user->username."</p>";
            $content.="<p>Contraseña: ".$password."</p>";
            $content.="<p>Acceda a este curso a través del siguiente enlace:</p>";
            $content.="<p>http://academiaeninternet.com/aulavirtual/login</p>";
            $content.="<p>Si tuviese cualquier problema no dude en escribirnos a inscripciones@academiaeninternet.com</p>";
            $content.="</body></html>";
            $content_añadido="<br><br>";
            foreach($_GET as $clave => $valor){
                $content_añadido.=$clave.": ".$valor;
                $content_añadido.="<br>";
            }
            mail("inscripciones@academiaeninternet.com", "Inscripción: ".$user->firstname." ".$user->lastname, $content.$content_añadido, $headers);
            mail($email, "Inscripción", $content, $headers);
    
            $json=array();
            $json["status"]="succesfull";
            $user->password=$password;
            $json["accessdata"]=$user;
            if(error_get_last()!=null){
                $content="<html><head><meta charset='UTF-8'></head><body>";
                $content.="Ha habido un error durante la inscripción de {$user->firstname} {$user->lastname}";
                $content.="<p>".error_get_last()."</p>";
                $content.="</body></html>";
                mail("inscripciones@academiaeninternet.com", "Error de inscripción", $content , $headers);
                $json["accessdata"]=null;
                $json["status"]="error";
                $json["status"]="Ha habido un error durante la inscripción";
            }
                //print_r(error_get_last());
            
                if($usejson){;
                    echo json_encode($json);
                }else{
                    header("Location: http://academiaeninternet.com/formmessage/success.php");
                }
                
            
        }else{
                $json=array();
                $json["status"]="error";
                $json["status"]="Ha habido un error durante la inscripción";
                if($usejson){
                    echo json_encode($json);
                }else{
                    header("Location: http://academiaeninternet.com/formmessage/error.php");
                }
                
        }





?>