<?php

require_once 'vendor/autoload.php';

use XRPL\Client\XRPLClient;

$client = new XRPLClient('https://s1.ripple.com:51234');
var_dump($client->paymentChannelClient->verifyChannel('channelId', 'amount', 'issou', 'azezae'));
