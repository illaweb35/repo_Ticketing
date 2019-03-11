<?php
namespace App\Service;

use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class Checkout
{

    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * Stripe payment system
     *
     * @param float $amount
     * @param string $description
     * @return bool
     */
    public function checkoutStripe(float $amount, string $description): bool
    {

        try {
            \Stripe\Stripe::setApiKey("sk_test_UGY6abLIuZBErdVYHHZpdhIL");
            $token = $_POST['stripeToken'];
            $charge = \Stripe\Charge::create([
                'amount'        => $amount,
                'currency'      => 'eur',
                'description'   => $description,
                'source'        => $token,
            ]);
            return true;
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];

            print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");
            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");
        } catch (\Stripe\Error\RateLimit $e) {
            $e->getMessage("Too many request made to the Api too quickly");
        } catch (\Stripe\Error\InvalidRequest $e) {
            $e->getMassage("Invalid parameters were supplied to Stripe's API");
        } catch (\Stripe\Error\Authentication $e) {
            $e->getMessage("Authentication with Stripe's API failed (maybe you changed API keys recently)");
        } catch (\Stripe\Error\ApiConnection $e) {
            $e->getMessage("Network communication with Stripe failed");
        } catch (\Stripe\Error\Base $e) {
            $e - getMessage("Display a very generic error to the user, and maybe send yourself an email");
        } catch (\Exception $e) {
            $e->getMessage("Something else happened, completely unrelated to Stripe");
        }

        return false;
    }
}
