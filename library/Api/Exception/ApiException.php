<?php


namespace Api\Exception;

use Api\Mail\Mailer;

class ApiException extends \Exception
{
    private static
        $to = array(
            'app2641@gmail.com'
        ),
        $from = 'exception@mixture2641.com',
        $subject = 'throw ApiException',
        $msg = 'Error! Please contact to app2641@gmail.com';


    public function __construct($msg = '', $code = 0, \Exception $previous = null)
    {
        $this->$msg = $msg;
        parent::__construct($msg, $code, $previous);
    }


    /**
     * Exception内容をメールで送信する
     *
     * @return array 
     * @author app2641
     **/
    public static function invoke (\Exception $e)
    {
        $trace = $e->getTrace();
        $body = $e->getMessage() . "\n" . $e->getFile() . " on line " . $e->getLine() . "\n\n";

        foreach ($trace as $t) {
            if (isset($t['class'])) {
                $body .= 'Class: ' . $t['class'] . "\n";
            }
            $body .= "Function: " . $t['function'] . "\n";

            if (isset($t['file'])) {
                $body .= $t['file'] . ' on line ' . $t['line'] . "\n";
            }

            $body .= "\n";
        }

        $body .= "Parameters:\n";

        foreach ($trace[0]['args'] as $v) {
            foreach ($v as $k => $v) {
                $body .= $k . ': ' . $v . "\n";
            }
        }

        $mailer = new Mailer();
        if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
            $mailer->send(
                array(
                    'to' => self::$to,
                    'from' => self::$from,
                    'subject' => self::$subject,
                    'body' => $body
                )
            );
        }

        return array('success' => false, 'msg' => self::$msg);
    }


    public static function msg ($msg = null)
    {
        if (is_null($msg)) {
            $msg = self::$msg;
        }

        return array('success' => false, 'msg' => self::$msg);
    }
}
