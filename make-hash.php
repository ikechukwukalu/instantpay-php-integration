<?php
echo hash_hmac(
    'sha512', 
    $_POST['hash'], 
    '54f9177541582ab6a811e2f855e4dfc7cb959936' //Add Secret Key
);
