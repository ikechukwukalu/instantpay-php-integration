<?php
$message = null;
function send_curl()
{
    if(isset($_GET['Ref']) && !empty(trim($_GET['Ref']))) {
        $url = "https://sl.instantbillspay.com/instantpay/api/bill/refstatus?ref=" . $_GET['Ref'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Prevents Output
        //Send the request
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response == false) {
            $message['status'] = false;
            $message['message'] = 'An error was encountered.';
            return null;
        } else {
            $response = json_decode($response, true);
            
            if (!is_array($response) || !isset($response['Status'])) {
                $message['status'] = false;
                $message['message'] = 'An error was encountered.';
                return null;
            }

            $data = $response['Response'];
            
            if ($response['Status'] == 0) {
                $message['status'] = true;
                $message['message'] = $data['status'];
                $message['data'] = $data;
                return $message;
            } else {
                $message['status'] = false;
                $message['message'] = $data['status'];
                return $message;
            }
        }
    }
    /*
    return [
        'status' => true, 
        'message' => 'Payment Successful', 
        'data' => 
            [
                'customer_name' => 'Kalu Ikechukwu', 
                'email' => 'ikaykaly@gmail.com', 
                'description' => 'Payment was made as at 10:30am', 
                'amount' => '1000.00'
            ]
    ];
    */
}
$message = send_curl();
?>
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="title col-md-6">
                <?php
                        if(is_null($message))
                            echo '
                                <div class="alert alert-warning">
                                    <h5 align="center"><strong>Error!</strong> An error was encountered.</h5>
                                </div>
                            ';
                        else
                            if($message['status']) {
                                $data = $message['data'];
                                if($message['message'] === 'CANCELED')
                                    echo '
                                        <div class="alert alert-warning">
                                            <h5 align="center"><strong>' . $message['message'] . '</h5> <p><span class="small font-weight-bolder">Customer Name: </span> ' . $data['customer_name'] . '</p> <p><span class="small font-weight-bolder">Customer Email: </span> ' . $data['email'] . '</p> <p><span class="small font-weight-bolder">Description: </span> ' . $data['description'] . '</p> <p><span class="small font-weight-bolder">Amount: </span> ' . $data['amount'] . '</p>
                                        </div>
                                    ';
                                else
                                    echo '
                                        <div class="alert alert-success">
                                            <h5 align="center"><strong>Success!</strong> ' . $message['message'] . '</h5> <p><span class="small text-white font-weight-bolder">Customer Name: </span> ' . $data['customer_name'] . '</p> <p><span class="small text-white font-weight-bolder">Customer Email: </span> ' . $data['email'] . '</p> <p><span class="small text-white font-weight-bolder">Description: </span> ' . $data['description'] . '</p> <p><span class="small text-white font-weight-bolder">Amount: </span> ' . $data['amount'] . '</p>
                                        </div>
                                    ';
                            } else {
                                echo '
                                    <div class="alert alert-danger">
                                        <h5 align="center"><strong>Fail!</strong> ' . $message['message'] . '</h5>
                                    </div>
                                ';
                            }
                    ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</body>

</html>