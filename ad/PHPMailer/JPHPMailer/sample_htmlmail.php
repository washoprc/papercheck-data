<?php
//�饤�֥���ɤ߹���
require("./jphpmailer.php");

//�������ꡢ�������󥳡��ǥ��󥰤���ꤹ��
mb_language("japanese");
mb_internal_encoding("EUC-JP");

//���ܸ�HTML�᡼�������
$to = "kawamura@example.com"; //����
$subject = "��η�ˤĤ���"; //��̾
$htmlbody = "<b>����</b>������ޤ�"; //HTML��ʸ
$altbody = "����������ޤ�"; //���إƥ�������ʸ
$from = "masaki@example.com"; //���п�
$fromname = "���� ����"; //�����Ф���̾


$mail = new JPHPMailer();

$mail->addTo($to);
$mail->setFrom($from,$fromname);
$mail->setSubject($subject);
$mail->setHtmlBody($htmlbody);
$mail->setAltBody($altbody);

if (!$mail->send()){
	die("�᡼�뤬�����Ǥ��ޤ���Ǥ��������顼:".$mail->getErrorMessage());
}