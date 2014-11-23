<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 27.03.14
 * Time: 23:54
 * To change this template use File | Settings | File Templates.
 */

class Email {

  const CHARSET = 'utf-8';
  const CONTENT_TYPE = 'multipart/alternative';

  const FROM_MAIL = 'robot@wikichecker.com';
  const FROM_NAME = 'Wikichecker';

  /**
   * @param $to string
   * @param $subject string
   * @param $content string
   * @return bool
   */
  public static function send($to, $subject, $content) {
      return self::phpMailSend($to, $subject, $content);
  }

  /**
   * @param $to string
   * @param $subject string
   * @param $content string
   * @return bool
   */
  private function phpMailSend($to, $subject, $content) {
    $boundary = uniqid('np');

    $headers = implode("\r\n", array(
      'MIME-Version: 1.0',
      'From: '.self::FROM_NAME.' <'.self::FROM_MAIL.'>',
      'Content-Type: '.self::CONTENT_TYPE.';boundary='.$boundary,
    ));

    $message = "This is a MIME encoded message.";
    $message .= "\r\n\r\n--".$boundary."\r\n";
    $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

    $message .= strip_tags($content);
    $message .= "\r\n\r\n--".$boundary."\r\n";
    $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";

    $message .= $content;
    $message .= "\r\n\r\n--".$boundary."--";

    mail($to, $subject, $message, $headers);
  }

}