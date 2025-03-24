<?php

function sendEmail($recipient, $recipientName, $subject, $htmlBody, $plainTextBody) {
    require 'vendor/autoload.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lyngsoejakob@gmail.com';
        $mail->Password = 'vjop axmi mbel gjgn';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        
        // Recipients
        $mail->setFrom('udlaan@skolen.dk', 'Computer Udlånssystem');
        $mail->addAddress($recipient, $recipientName);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = $plainTextBody;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendBlacklistEmail($user, $isBlacklisting) {
    if ($isBlacklisting) {
        $subject = 'Du er blevet blacklistet i Computer Udlånssystem';
        
        $htmlBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .important { color: #cc0000; font-weight: bold; }
                .footer { font-size: 0.8em; color: #666; margin-top: 30px; }
            </style>
        </head>
        <body>
            <p>Kære {$user['name']},</p>
            <p class='important'>Du er blevet blacklistet i Computer Udlånssystemet.</p>
            <p>Dette betyder, at du ikke kan låne computere, før din status er ændret.</p>
            <p>Hvis du mener dette er en fejl, bedes du kontakte skolen.</p>
            <p>Med venlig hilsen,<br>Computer Udlånssystem</p>
            <div class='footer'>
                Dette er en automatisk genereret besked. Venligst svar ikke på denne mail.
            </div>
        </body>
        </html>";
        
        $plainTextBody = "Kære {$user['name']},\n\nDu er blevet blacklistet i Computer Udlånssystemet. Dette betyder, at du ikke kan låne computere, før din status er ændret.\n\nHvis du mener dette er en fejl, bedes du kontakte skolen.\n\nMed venlig hilsen,\nComputer Udlånssystem";
    } else {
        $subject = 'Du er ikke længere blacklistet i Computer Udlånssystem';
        
        $htmlBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .positive { color: #008800; font-weight: bold; }
                .footer { font-size: 0.8em; color: #666; margin-top: 30px; }
            </style>
        </head>
        <body>
            <p>Kære {$user['name']},</p>
            <p class='positive'>Du er ikke længere blacklistet i Computer Udlånssystemet.</p>
            <p>Dette betyder, at du igen kan låne computere fra skolen.</p>
            <p>Med venlig hilsen,<br>Computer Udlånssystem</p>
            <div class='footer'>
                Dette er en automatisk genereret besked. Venligst svar ikke på denne mail.
            </div>
        </body>
        </html>";
        
        $plainTextBody = "Kære {$user['name']},\n\nDu er ikke længere blacklistet i Computer Udlånssystemet. Dette betyder, at du igen kan låne computere fra skolen.\n\nMed venlig hilsen,\nComputer Udlånssystem";
    }
    
    return sendEmail($user['email'], $user['name'], $subject, $htmlBody, $plainTextBody);
}

function sendOverdueEmail($studentName, $studentEmail, $computerNumber, $endDate, $daysOverdue) {
    $subject = 'Påmindelse: Overskredet Computer Udlån';
    
    $htmlBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .important { color: #cc0000; font-weight: bold; }
            .footer { font-size: 0.8em; color: #666; margin-top: 30px; }
        </style>
    </head>
    <body>
        <p>Kære {$studentName},</p>
        <p>Vi kan se at du har lånt computer nummer <strong>{$computerNumber}</strong> og afleveringsfristen var den <strong>{$endDate}</strong>.</p>
        <p class='important'>Computeren er nu {$daysOverdue} dage forsinket.</p>
        <p>Venligst aflever computeren hurtigst muligt, eller kontakt os hvis der er opstået problemer.</p>
        <p>Med venlig hilsen,<br>Computer Udlånssystem</p>
        <div class='footer'>
            Dette er en automatisk genereret besked. Venligst svar ikke på denne mail.
        </div>
    </body>
    </html>";
    
    $plainTextBody = "Kære {$studentName},\n\nDu har lånt computer {$computerNumber} og afleveringsfristen var den {$endDate}. Computeren er nu {$daysOverdue} dage forsinket.\n\nVenligst aflever computeren hurtigst muligt.\n\nMed venlig hilsen,\nComputer Udlånssystem";
    
    return sendEmail($studentEmail, $studentName, $subject, $htmlBody, $plainTextBody);
}