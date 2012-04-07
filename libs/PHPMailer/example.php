<?php
				$mail = new PHPMailer();
				$mail->CharSet = "windows-1251";//кодировка
				$mail->From = "info@{$hostname}";
				$mail->FromName = "От кого";
				
				$mail->AddAddress("ellen@example.com","Никита");
				$mail->AddAddress("ellen@example.com");                  // name is optional
				$mail->AddReplyTo("info@example.com", "Information");
				
				$mail->WordWrap = 50;                                 
				$mail->SetLanguage("ru");
				//добавление файла
				$mail->AddAttachment(ROOT.$ff);
				$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
				$mail->IsHTML(true);                                  // с помощью html
				
				$mail->Subject = "Тема";
				$mail->Body    = $text;
				$mail->AltBody = "Если не поддерживает html";
				
				if(!$mail->Send())
				{
				   echo "Message could not be sent. <p>";
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}
				
				echo "Письмо отправлено";
?>