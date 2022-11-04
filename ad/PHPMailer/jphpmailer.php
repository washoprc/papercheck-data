<?php
####################################################################
#
# ���������������������� JPHPMailer - PHPMailer Japanese Edition
# ���������������������� (PHPMailer:http://phpmailer.sourceforge.net/)
# ���������������������� 
# ���������������������� 
# ���������������������� ������� EC studio  Masaki Yamamoto
# ���������������������� http://www.ecstudio.jp
# ���������������������� copyright (c): 2007,all rights reserved
#
####################################################################

//PHPMailer���ɤ߹���
require("./PHPMailer/class.phpmailer.php");                // *** �ѹ�������

/**
 * JPHPMailer - PHPMailer Japanese Edition
 *
 * @author    Masaki Yamamoto
 * @version   0.11
 * @copyright 2007 EC studio
 * @license   LGPL
 * @link http://techblog.ecstudio.jp/tech-tips/mail-japanese-advance.html
 */
class JPHPMailer extends PHPMailer {
	var $CharSet = "iso-2022-jp";
	var $Encoding = "7bit";
//	var $in_enc = "EUC-JP"; //�������󥳡���               // *** �����ȥ����ȡ�����
	var $in_enc = "UTF-8"; //�������󥳡���
	
	/**
	 * ������ɲ�
	 * 
	 * $name <$address> �Ȥ����񼰤ˤʤ롣
	 * 
	 * @param string $address �᡼�륢�ɥ쥹
	 * @param string $name ̾��
	 */
	function addAddress($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addAddress($address,$name);
	}

	/**
	 * ������ɲ� (addAddress�Υ����ꥢ��)
	 * 
	 * $name <$address> �Ȥ����񼰤ˤʤ롣
	 * 
	 * @param string $address �᡼�륢�ɥ쥹
	 * @param string $name ̾��
	 */
	function addTo($address,$name="") {
		$this->addAddress($address,$name);
	}

	/**
	 * CC���ɲ�
	 * 
	 * $name <$address> �Ȥ����񼰤ˤʤ롣
	 * 
	 * @param string $address �᡼�륢�ɥ쥹
	 * @param string $name ̾��
	 */
	function addCc($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addCc($address,$name);
	}

	/**
	 * BCC���ɲ�
	 * 
	 * $name <$address> �Ȥ����񼰤ˤʤ롣
	 * 
	 * @param string $address �᡼�륢�ɥ쥹
	 * @param string $name ̾��
	 */
	function addBcc($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addBcc($address,$name);
	}

	/**
	 * Reply-To���ɲ�
	 * 
	 * $name <$address> �Ȥ����񼰤ˤʤ롣
	 * 
	 * @param string $address �᡼�륢�ɥ쥹
	 * @param string $name ̾��
	 */
	function addReplyTo($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addReplyTo($address,$name);
	}
	
	/**
	 * ��̾�򥻥åȤ���
	 * 
	 * @param string $subject ��̾
	 */
	function setSubject($subject){
		$this->Subject = $this->encodeMimeHeader(mb_convert_encoding($subject,"JIS",$this->in_enc));
	}
	
	/**
	 * ���пͥ��ɥ쥹�򥻥åȤ���
	 * 
	 * @param string $from ���пͤΥ᡼�륢�ɥ쥹
	 * @param string $fromname �����Ф���̾
	*/
	function setFrom($from,$fromname=""){
		$this->From = $from;
		if ($fromname){
			$this->setFromName($fromname);
		}
	}
	
	/**
	 * �����Ф���̾�򥻥åȤ���
	 * @param string $fromname �����Ф���̾
	 */
	function setFromName($fromname){
		$this->FromName = $this->encodeMimeHeader(mb_convert_encoding($fromname,"JIS",$this->in_enc));
	}

	/**
	 * ��ʸ�򥻥åȤ��롣(text/plain)
	 * 
	 * @param string $body ��ʸ
	 */
	function setBody($body){
		$this->Body = mb_convert_encoding($body,"JIS",$this->in_enc);
		$this->AltBody = "";
		$this->IsHtml(false);
	}

	/**
	 * ��ʸ�򥻥åȤ��롣(text/html)
	 * 
	 * @param string $htmlbody ��ʸ (HTML)
	 */
	function setHtmlBody($htmlbody){
		$this->Body = mb_convert_encoding($htmlbody,"JIS",$this->in_enc);
		$this->IsHtml(true);
	}
	
	/**
	 * ���ؤ���ʸ�򥻥åȤ��롣(text/plain)
	 * setHtmlBody()��Ȥä�����HTML���ɤ�ʤ��᡼�륯�饤������Ѥ�ʿʸ�򥻥åȤǤ��롣
	 * 
	 * @param string $altbody ��ʸ
	 */
	function setAltBody($altbody){
		$this->AltBody = mb_convert_encoding($altbody,"JIS",$this->in_enc);
	}
	
	/**
	 * ��������إå������ɲ�
	 * 
	 * @param string $key �إå�������
	 * @param string $value �إå�����
	 */
	function addHeader($key,$value){
		if (!$value){
			return;
		}
		$this->addCustomHeader($key.":".$this->encodeMimeHeader(mb_convert_encoding($value,"JIS",$this->in_enc)));
	}
	
	/**
	 * ���顼��å��������������
	 * 
	 * @return string ���顼��å�����
	 */
	function getErrorMessage(){
		return $this->ErrorInfo;
	}
	
	/**
	 * PHPMailer��encodeHeader�򥪡��С��饤�ɤ���̵����
	 */
	function encodeHeader($str, $position='text'){
		return $str;
	}
	
	/**
	 * Mime���󥳡��ɽ���
	 * 
	 * php��mb_encode_mimeheader�Ǥϡ�Ĺ��ʸ����ǲ��Ԥ��줺�᡼��إå��ε�§�ˤ���ʤ���
	 */
	function encodeMimeHeader($string,$charset=null,$linefeed="\r\n"){
		if (!strlen($string)){
			return "";
		}
		
		if (!$charset)
			$charset = $this->CharSet;
	
		$start = "=?$charset?B?";
		$end = "?=";
		$encoded = '';
	
		/* Each line must have length <= 75, including $start and $end */
		$length = 75 - strlen($start) - strlen($end);
		/* Average multi-byte ratio */
		$ratio = mb_strlen($string, $charset) / strlen($string);
		/* Base64 has a 4:3 ratio */
		$magic = $avglength = floor(3 * $length * $ratio / 4);
	
		for ($i=0; $i <= mb_strlen($string, $charset); $i+=$magic) {
			$magic = $avglength;
			$offset = 0;
			/* Recalculate magic for each line to be 100% sure */
			do {
				$magic -= $offset;
				$chunk = mb_substr($string, $i, $magic, $charset);
				$chunk = base64_encode($chunk);
				$offset++;
			} while (strlen($chunk) > $length);
			
			if ($chunk)
				$encoded .= ' '.$start.$chunk.$end.$linefeed;
		}
		/* Chomp the first space and the last linefeed */
		$encoded = substr($encoded, 1, -strlen($linefeed));
	
		return $encoded;
	}
}