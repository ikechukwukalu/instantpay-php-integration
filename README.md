## PAYMENT GATEWAY INTEGRATION IN PHP

<h3>INSTALL PHP</h3>
•	Download and install <a href="https://www.apachefriends.org/download.html" target="_blank">Xampp</a> \
•	Within your ``/xampp/htdocs`` directory run ``git clone https://github.com/ikechukwukalu/instantpay-php-integration.git``

<h3>INDEX.php</h3>
•	Add the relevant country code to the form action attribute. For Nigeria would be ``ng`` and so the form action value should be ``https://ng.instantbillspay.com/instantpay/payload/bill/payment`` \
•	Add your merchant code to this form input``<input type="hidden" class="form-control" id="merchantID" name="merchantID" value="NG0000000" required>``

<h3>MAKE-HASH.php</h3>
•	Add the your secret key to the array

```
echo hash_hmac(
    'sha512', 
    $_POST['hash'], 
    '' //Add Secret Key
);
```

<h3>PAYMENT-NOTIFICATION.php</h3>
•	Add the relevant country code. For Nigeria would be ``ng``

```
$url = "https://ng.instantbillspay.com/instantpay/api/bill/refstatus?ref=" . $_GET['Ref'];
```