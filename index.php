<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InstantBillsPay</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 col-lg-8 mt-3">
                <div class="container">
                    <!-- Change the country code before https:// -->
                    <form id="make-payment" action="https://xx.instantbillspay.com/instantpay/payload/bill/payment"
                        method="POST">
                        <label style="color:black">First Name*</label> <input type="text" id="firstname"
                            name="firstname" class="form-control" placeholder="Enter your first name" value="" required>
                        <label style="color:black">Last Name*</label> <input type="text" id="lastname" name="lastname"
                            class="form-control" placeholder="Enter your last name" value="" required>
                        <label style="color:black">Phone*</label> <input type="tel" id="phone" name="phone"
                            class="form-control" placeholder="Enter your phone" value="" required>
                        <label style="color:black">Email*</label> <input type="email" id="email" name="email"
                            class="form-control" placeholder="Enter your email" value="" required>
                        <label style="color:black">Amount*</label> <input type="number" id="amount" name="amount"
                            class="form-control" placeholder="Enter your amount" value="" required>
                        <label style="color:black">Description*</label> <input type="text" id="description"
                            name="description" class="form-control" placeholder="Enter your description" value=""
                            required>

                        <input type="hidden" class="form-control" id="uniqueID" name="uniqueID"
                            value="<?php echo 'UID' . time() . rand(1000000000, 9999999999) . 'pay' ?>" required>
                        <!-- Add your company code on InstantBillsPay -->
                        <input type="hidden" class="form-control" id="merchantID" name="merchantID" value="xxxxxxxxx"
                            required>
                        <!-- A unique string of characters will generated over make-hash.php file and inserted into this input  -->
                        <input type="hidden" class="form-control" id="hash" name="hash" value="" required>

                        <input type="hidden" class="form-control" name="returnUrl"
                            value="http://localhost/payment/payment-notification.php">

                        <div class="mbr-section-btn">
                            <br />
                            <button type="button" onclick="submitForm()" class="btn btn-primary">Make
                                Payment</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="title col-4 col-lg-4"></div>
        </div>
    </div>

    <script>
        function hashString() {
            var ary = [
                'email',
                'firstname',
                'lastname',
                'merchantID',
                'uniqueID',
                'amount'
            ];
            var empty = false;
            var values = '';

            ary.map(function(ele, inx) {
                var input = $('#' + ele).val();
                if (input.trim().length == 0)
                    empty = true;
                values += input;
            });

            if ($('#description').val().trim().length == 0)
                empty = true;

            return empty ? null : values
        }

        function submitForm() {
            var hash_string = hashString();
            if (hash_string == null) {
                alert('Some form fields still needs to be filled!');
                return true;
            } else {
                $.post('make-hash.php', {
                    'hash': hash_string
                }, function(data) {
                    $('#hash').val(data);
                    var proceed = confirm('Make payment?')
                    if (proceed) {
                        setTimeout(function() {
                            $('#make-payment').submit();
                        }, 500);
                    }
                });
            }
        }
    </script>
</body>

</html>