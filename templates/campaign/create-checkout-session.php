<?php
// This example sets up an endpoint using the Slim framework.
// Watch this video to get started: https://youtu.be/sGcNPFX1Ph4.

use Slim\Http\Request;
use Slim\Http\Response;
use Stripe\Stripe;

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->add(function ($request, $response, $next) {
  \Stripe\Stripe::setApiKey('sk_test_51KqvNSHfGDLeu6IQ6MVCMkj9slTRzzKOROK0c55sSLgGfdBvKmtZy6DDZa9rkIyrdJs3J3CvKfLLhKtPQwEYsmWs0035loZMr9');
  return $next($request, $response);
});

$app->post('/create-checkout-session', function (Request $request, Response $response) {
  $session = \Stripe\Checkout\Session::create([
    'line_items' => [[
      'price_data' => [
        'currency' => 'usd',
        'product_data' => [
          'name' => 'T-shirt',
        ],
        'unit_amount' => 2000,
      ],
      'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'https://example.com/success',
    'cancel_url' => 'https://example.com/cancel',
  ]);

  return $response->withHeader('Location', $session->url)->withStatus(303);
});

$app->run();