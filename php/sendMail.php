<?php
	require 'php_mailer/Exception.php';
	require 'php_mailer/PHPMailer.php';
	require 'php_mailer/SMTP.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	try{

		$nombre = $_POST['contactname'] ?? '';
		$mail = $_POST['contact-email'] ?? '';
		$telefono = $_POST['contact-phone'] ?? '';
		$asunto = $_POST['contact-service'] ?? '';
		$mensaje = $_POST['contact-message'] ?? '';
		if ($nombre == '') throw new Exception("Favor de capturar su nombre"); 
		if ($mail == '' && $telefono == '') throw new Exception("Favor de capturar un medio de contacto"); 
		if ($mensaje == '') throw new Exception("Favor de capturar el contenido de su mensaje");
		
		$mensaje = "
			<p>Nombre: $nombre</p>
			<p>Correo: $mail</p>
			<p>Telefono: $telefono</p>
			<p>Asunto: $asunto</p>
			<p>Mensaje: $mensaje</p>
		";
		
		send_mail('jose.valles90@hotmail.com', $mensaje);
		echo json_encode('Se envio correctamente');
	}catch(Exception $error){
		echo json_encode($error->getMessage());
	}

	function send_mail($mails, $mensaje, $PDF = null, $nombrePDF = ""){
		try {
			$mail = new PHPMailer(true);               	         // Passing `true` enables exceptions
			//Server settings
			$mail->SMTPDebug = 0;                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';								// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'ome.test.mail@gmail.com';     		// SMTP username
			$mail->Password = 'Rosanegra1';                       // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465;                                    // TCP port to connect to

			//Recipients
			$mail->setFrom('ome.test.mail@gmail.com', 'Notificaciones Abaspa');
			$mail->addAddress($mails, 'Gerente de Abaspa');    					// Add a recipient
			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Nuevo mensaje de contacto';
			$mail->Body    = $mensaje;
			if($PDF != null){
				$mail->addAttachment($PDF, $nombrePDF);   
			}
			$mail->send();
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
		}
	}
?>
