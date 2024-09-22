<?php 
/**
 * This function is used to send email
 */
if(!function_exists('sendEmail'))
{
    function sendEmail($subject,$message,$to='karthik.hbk24@gmail.com')
    {
    	$email = \Config\Services::email();		
        $email->setTo($to);
        $email->setFrom(EMAIL_FROM, FROM_NAME);
        
        $email->setSubject($subject);
        $email->setMessage($message);

        if(SEND_EMAIL_CONFIG == 1)
        {
            if ($email->send()) 
    		{
                return true;
            } 
    		else 
    		{
                return false;
            }
        }
    }
}


?>