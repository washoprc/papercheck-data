<?php

$to      = 'okazaki@prc.tsukuba.ac.jp';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: Jack Sparrow <jsparrow@blackpearl.com>' . PHP_EOL .
    'Reply-To: Jack Sparrow <jsparrow@blackpearl.com>' . PHP_EOL .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

?>
