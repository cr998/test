<?php
        if($_GET["token"]!=549100) exit;
	//require_once(dirname(__FILE__) . '/../config.php');
	//require_once($CFG->dirroot.'/user/profile/lib.php');
	//$user=$DB->get_record('user', array('id' => $_GET["id"]));
	//profile_load_custom_fields($user); 
	//$course=$DB->get_record('course', array('id' => $_GET["course"]));
	$user = new Stdclass();
	echo "<html>";
		echo "<head>";
		echo "<meta charset='UTF-8'/>";
		?>
		<style>
			*{
				margin:0;
				padding:0;
				font-family: "Century Gothic";
				font-stretch: ultra-expanded;
			}
			
			@page {
				margin:0mm;
				padding:0mm;
				size: landscape;
				
			}
			#container{
				margin:0 auto;
				margin-top:20px;
				position:relative;
				width:297mm;
				height:210mm;
				background-image:url('http://academiaeninternet.com/aulavirtual/diplomaTemplate/fondo.png');
				background-size: 297mm 210mm;
				z-index:-3;
				
		}
			#fondo{
				position:absolute;
				width:297mm;
				height:210mm;
				z-index:-4;
			}
			
			@media print{
				#container{
					//transform: rotate(90deg);
					width:297mm;
					height:210mm;
					transform:scale(0.9, 0.9);
					top:0;
					bottom:0;
					margin:0;
				}
			}
			#titulo{
				font-weight:600;
				display:block;
				text-transform: uppercase;
				position: absolute;
				top:10mm;
				text-align:center;
				width:100%;
				text-shadow: 1px 1px 2px yellow;
				//letter-spacing:7.5px;
				/*-webkit-transform:scale(1.5,1); /* Safari and Chrome */
    				/*-moz-transform:scale(1.5,1); /* Firefox */
   				/*-ms-transform:scale(1.5,1); /* IE 9 */
    				/*-o-transform:scale(1.5,1); /* Opera */
    				/*transform:scale(1.5,1); /* W3C */
			}
			#logo{
				width:100%;
				text-align:center;
				position: absolute;
				top:20mm;
			}
			
			#logo img{
				width:50mm;
				height:53.2mm;
				
			}
			
			#certificanque{
				width:100%;
				position:absolute;
				top:72.5mm;
				text-align:center;
				font-size:6mm;

			}
			
			#nombre{
				width:100%;
				position:absolute;
				top:85mm;
				text-align:center;
				font-size:8mm;
				font-weight:bold;
				text-transform:uppercase;

			}
			
			#dni{
				width:100%;
				position:absolute;
				top:97.5mm;
				text-align:center;
				font-size:7mm;
				font-weight:bold;

			}
			#texto1{
				width:100%;
				position:absolute;
				top:110mm;
				text-align:center;
				font-size:4mm;

			}
			#curso{
				text-transform:uppercase;
				font-weight:bold;
				width:100%;
				position:absolute;
				top:120mm;
				text-align:center;
				font-size:8mm;

			}
			#texto2{
				width:100%;
				position:absolute;
				top:132.5mm;
				text-align:center;
				font-size:4mm;

			}
			
			#texto2 span{
				display:inline-block;
				width:60%;
			}
			
			#texto3{
				width:100%;
				position:absolute;
				top:147.5mm;
				text-align:center;
				font-size:4mm;

			}
			
			#texto3 span{
				display:inline-block;
				width:60%;
			}
			
			#texto4{
				width:100%;
				position:absolute;
				top:185mm;
				text-align:center;
				font-size:4mm;

			}
			
			#texto4 span{
				display:inline-block;
				width:60%;
			}
			
			
			#nRegistro{
				width:100%;
				position:absolute;
				top:170mm;
				text-align:center;
				font-size:4mm;

			}
			
			#nRegistro{
				position:absolute;
				right:15mm;
				display:inline-block;
				width:30%;
			}
			#nRegistro b{
				font-size: 5mm;
			}
			
			.escala{
				display:inline-block;
				-webkit-transform:scale(1.5,1); /* Safari and Chrome */
    				-moz-transform:scale(1.5,1); /* Firefox */
   				-ms-transform:scale(1.5,1); /* IE 9 */
    				-o-transform:scale(1.5,1); /* Opera */
    				transform:scale(1.5,1); /* W3C */
			}
			
			#firma{
				width:100%;
				text-align:center;
				position: absolute;
				top:145mm;
				z-index:-1;
			}
			
			#firma img{
				
				width:61.4mm;
				height:56.6mm;
			}
			#logofondo{
				width:100%;
				text-align:center;
				position: absolute;
				top:60mm;
				z-index:-2;
			}
			
			#logofondo img{
				
				width:112.3mm;
				height:107.1mm;
			}
		</style>
		<?php
		echo "</head>";
		echo "<body>";
		echo "<div id='container'>";
			echo "<img src='http://academiaeninternet.com/aulavirtual/diplomaTemplate/fondo.png' id='fondo'/>";
			echo "<h1 id='titulo'><span class='escala'>Academia en internet .com</span></h1>";
			echo "<div id='logo'><img src='http://academiaeninternet.com/aulavirtual/diplomaTemplate/logo.png'/></div>";
			echo "<p id='certificanque'><span>Certifican que:</span></p>";
			echo "<p id='nombre'><span>$user->firstname $user->lastname</span></p>";
			echo "<p id='dni'><span>con D.N.I.   {$user->profile['dni']}</span></p>";
			echo "<p id='texto1'><span>Ha realizado satisfactoriamente la acción formativa:</span></p>";
			echo "<p id='curso'><span>$course->fullname</span></p>";
			
			$text=file_exists("texts/text{$course->id}.txt")?file_get_contents("texts/text{$course->id}.txt"):"";
			echo "<p id='texto2'><span>$text</span></p>";
			echo "<p id='texto3'><span>Celebrado en formación a distancia, según el programa que se indica al dorso.<br>";
			$meses=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			echo "En Oviedo, el ".date('d')." de {$meses[date('n')-1]} del ".date('Y');
			echo "</span></p>";
			echo "<div id='firma'><img src='http://academiaeninternet.com/aulavirtual/diplomaTemplate/firma.png'></div>";
			echo "<p id='texto4'><span>Fdo.. D. Armando Miguel González Gutiérrez<br>";
			echo "Director del Centro de Formación Cidegrupo";
			echo "</span></p>";
			echo "<p id='nRegistro'><span>Número de registro del certificado:<br>";
			echo "<b>{$user->username}{$user->firstname[0]}{$user->lastname[0]}$</b>";
			echo "</span></p>";
			echo "<div id='logofondo'><img src='http://academiaeninternet.com/aulavirtual/diplomaTemplate/logo2.png'></div>";
		echo "</div>";
		echo "</body>";
	echo "</html>";
?>