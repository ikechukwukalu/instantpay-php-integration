<?php
echo hash_hmac(
    'sha512', 
    $_POST['hash'], 
    'xxxxxxxxxxxxxxxxxxxxxxxxxxx' //Add Secret Key
);
