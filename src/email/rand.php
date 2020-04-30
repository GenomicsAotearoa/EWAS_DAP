<?php

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

echo substr(str_shuffle($permitted_chars), 0, 20);



?>
