<?php
/**
 * メール送信クラス
 * パラメータをsendメソッドに渡してメールを送信する
 *
 * @package Mail
 * @author app2641
**/

namespace Api\Mail;


class Mailer 
{
    private function _extractMailAddr($addr)
    {
        if(! mb_strpos($addr, '<')) {
            return $addr;
        }

        return mb_substr(
            $addr,
            mb_strpos($addr, '<') + 1,
            mb_strpos($addr, '>') - mb_strpos($addr, '<') - 1
        );
    }

    private function _extractName($addr)
    {
        if(! mb_strpos($addr, '<')) {
            return '';
        }

        return mb_substr($addr, 0, mb_strpost($addr, '<'));
    }

    private function _makeAddrList($address)
    {
        $addresses = array();
        $temp = array();

        if (!is_array($address)) {
            $addresses[] = $address;
        } else {
            $addresses = $address;
        }

        foreach ($addresses as $item) {
            $item = trim($item);

            $tempAddr = $this->_extractMailAddr($item);
            $tempName = $this->_extractName($item);

            if ($tempName != '') {
                $tempName = mb_convert_encoding(
                    $tempName, "ISO-2022-JP-ms", "UTF-8"
                );
                $tempName =
                    "=?ISO-2022-JP-ms?B?" . base64_encode($tempName) . "?=";
            }

            if ($tempName) {
                $temp[] = $tempName . '<' . $tempAddr . '>';
            } else {
                $temp[] = $tempAddr;
            }

        }

        return implode(',', $temp);
    }

    private function _genHeader($conf)
    {
        $ret = "From: " . $conf->from . "\n";

        if (isset($conf->cc)) {
            $ret .= "Cc: " . $this->_makeAddrList($conf->cc) . "\n";
        }

        if (isset($conf->bcc)) {
            $ret .= "Bcc: " . $this->_makeAddrList($conf->bcc) . "\n";
        }

        $ret .= implode(
            "",
            array(
                "X-Mailer: " . $conf->mailer,
                "MIME-Version: 1.0",
                "Content-Type: text/plain; charset=\"ISO-2022-JP-ms\"",
                "Content-Transfer-Encoding: 7bit"
            )
        );

        return $ret;
    }

    public function send($conf, $html = false)
    {   
        // 配列で指定された場合、xFrameworkPX_Util_MixedCollectinに変換
        if (is_array($conf)) {
            $conf = (object) $conf;
        }

        $boundary = "Boundary_" . uniqid("b");

        // 送信先チェック\
        if (!isset($conf->to)) {
            throw new \Exception('送信先が設定されていません。');
        }

        // 差出人チェック
        if (!isset($conf->from)) {
            throw new \Exception('差出人が設定されていません。');
        }

        $conf->from = $this->_makeAddrList($conf->from);

        // 内部のエンコード取得/設定
        $mbLanguage = mb_language();
        $mbInternalEncoding = mb_internal_encoding();

        mb_language('japanese');
        mb_internal_encoding('UTF-8');

        // タイトル設定
        if (!isset($conf->subject)) {
            $conf->subject = '無題';
        }

        $conf->subject = mb_convert_encoding(
            $conf->subject,
            'ISO-2022-JP-ms',
            'UTF-8'
        );
        $conf->subject = sprintf(
            "=?ISO-2022-JP?B?%s?=",
            base64_encode($conf->subject)
        );

        // メーラー設定
        if (!isset($conf->mailer)) {
            $conf->mailer = 'PHP/Mail';
        }

        // 本文設定
        if ($html == true) {
            $temp = file_get_contents(ROOT_PATH . '/data/templates/manual-mail.html');

        } else {
            if (!isset($conf->body)) {
                $conf->body = '';
            }
        }

        $conf->body = mb_convert_encoding(
            $conf->body,
            "ISO-2022-JP-ms",
            "UTF-8"
        );

        $header = "From: " . $conf->from . "\n";

        if (isset($conf->cc)) {
            $header .= "Cc: " . $this->_makeAddrList($conf->cc) . "\n";
        }

        if (isset($conf->bcc)) {
            $header .= "Bcc: " . $this->_makeAddrList($conf->bcc) . "\n";
        }

        if ($html) {
            $con_type = 'text/html';
        } else {
            $con_type = 'text/plain';
        }

        $header .= implode(
            "\n",
            array(
                "X-Mailer: " . $conf->mailer,
                "MIME-Version: 1.0",
                "Content-Type: $con_type; charset=\"ISO-2022-JP\"",
                "Content-Transfer-Encoding: 7bit"
            )
        );
        

        // メール送信
        $ret = mail(
            $this->_makeAddrList($conf->to),
            $conf->subject,
            $conf->body,
            $header
        );

        // 内部エンコード復帰
        mb_language($mbLanguage);
        mb_internal_encoding($mbInternalEncoding);

        return $ret;
    }
}


