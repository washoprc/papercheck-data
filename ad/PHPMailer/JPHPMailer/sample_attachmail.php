<?php
//�饤�֥���ɤ߹���
require("./jphpmailer.php");

//�������ꡢ�������󥳡��ǥ��󥰤���ꤹ��
mb_language("japanese");
mb_internal_encoding("EUC-JP");

//���ܸ�ź�ե᡼�������
$to = "kawamura@example.com"; //����
$subject = "��η�ˤĤ���"; //��̾
$body = "<b>����</b>������ޤ�"; //��ʸ
$from = "masaki@example.com"; //���п�
$fromname = "���� ����"; //�����Ф���̾


$mail = new JPHPMailer();

$mail->addTo($to);
$mail->setFrom($from,$fromname);
$mail->setSubject($subject);
$mail->setBody($body);

//ź�եե������ɲ�
$mail->addAttachment($attachfile);

if (!$mail->send()){
	die("�᡼�뤬�����Ǥ��ޤ���Ǥ��������顼:".$mail->getErrorMessage());
}