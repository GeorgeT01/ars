<?php
require_once"stripe-php-master/init.php";

$stripDetails = array(
"secretKey" => "sk_test_MvAoD7pjxqSFB1acQnpRioqj",
"publishableKey" => "pk_test_OJL0LzrQWVxFZ4iKUXrODcdM"
);

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey($stripDetails['secretKey']);

?>