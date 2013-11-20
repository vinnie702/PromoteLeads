<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once $_SERVER['DOCUMENT_ROOT'] . 'braintree_php-2.23.1' . DS . 'lib' . DS . 'Braintree.php';
/**
 * TODO: short description.
 *
 * TODO: long description.
 *
 */
class Payment
{

    public $errorReason;

    private $ci, $email;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->library('session');

        $this->email = $this->ci->session->userdata('email');


        if ($this->ci->config->live == true)
        {

        }
        else
        {
            // sent environment
            Braintree_Configuration::environment('sandbox');
            error_log('Braintree in sandbox mode!');
        }

        // error_log('merchantId: ' . $this->ci->config->item('merchantId'));
        // error_log('publicKey: ' . $this->ci->config->item('publicKey'));
        // error_log('privateKey: ' . $this->ci->config->item('privateKey'));

        Braintree_Configuration::merchantId($this->ci->config->item('merchantId'));
        Braintree_Configuration::publicKey($this->ci->config->item('publicKey'));
        Braintree_Configuration::privateKey($this->ci->config->item('privateKey'));

        // if connected to DB
        if (class_exists('CI_DB'))
        {

        }
    }

    /**
     * Process a transaction
     *
     * @return TODO
     */
    public function processTransaction ($p)
    {
        $saleArray = array(
                'amount' => '100.00',
                'creditCard' => array
                    (
                        'number' => $p['number'],
                        'cvv' => $p['cvv'],
                        'expirationMonth' => $p['expMonth'],
                        'expirationYear' => $p['expYear']
                    ),
                'options' => array
                    (
                        'submitForSettlement' => true
                    )
            );


        $result = Braintree_Transaction::sale($saleArray);

        if ($result->success)
        {
            error_log("Success Transaction ID:" . $result->transaction->id);
        }
        else if ($result->transaction)
        {
            error_log("ERROR:" . $result->message);
            error_log("code: " . $result->transaction->processorResponseCode);
        }
        else
        {
            error_log("Validation Errors");

            foreach ($results->errors->deepAll() as $error)
            {
                error_log($error->message);
            }
        }
    }

    /**
     * TODO: short description.
     *
     * @param mixed $d 
     *
     * @return TODO
     */
    public function createCustomer($d)
    {
        if (empty($d['company'])) throw new Exception("Company ID is empty!");
        if (empty($d['firstName'])) throw new Exception("Billing First Name is empty!");
        if (empty($d['lastName'])) throw new Exception("Billing Last Name is empty!");


        $customerArray = array
            (
                'id' => $d['company'],
                'firstName' => $d['firstName'],
                'lastName' => $d['lastName']
            );

        if (!empty($d['companyName'])) $customerArray['company'] = $d['companyName'];
        if (!empty($d['email'])) $customerArray['email'] = $d['email'];
        if (!empty($d['phone'])) $customerArray['phone'] = $d['phone'];
        if (!empty($d['fax'])) $customerArray['fax'] = $d['fax'];
        if (!empty($d['websiteUrl'])) $customerArray['website'] = $d['websiteUrl'];
    

        $result = Braintree_Customer::create($customerArray);

        if ($result->success)
        {
            // will now update companies table with its BrainTreeCustomerID
            // Copmany ID and BrainTreeCustomerID should uusually match
            $this->updateCompanyCustomerID ($d['company'], $result->customer->id);

            return $result->customer->id;
        }

    return false;
    }


    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function createSubscription ($company, $token, $planId, $price)
    {
        if (empty($token)) throw new Exception("Payment token is empty!");
        if (empty($planId)) throw new Exception("Subscription Plan ID is empty!<br><br><strong>IT has beeen notified!</strong>");
        if (empty($price)) throw new Exception("Unable to a subscription of $0.00!");

        $subscriptionArray = array
            (
                'paymentMethodToken' => $token,
                'planId' => $planId,
                'price' => $price
            );

        $result = Braintree_Subscription::create($subscriptionArray);

        $subscription = $result->subscription;
        
        $subID = $subscription->id;

        $status = strtoupper($subscription->status);

        error_log($subID);
        // saves subscription
        $this->updateCompanySubscriptionID($company, $subID);

        // BrainTree_Transaction::PROCESSOR_DECLINE
        // BrainTree_Transaction::ACTIVE
        // BrainTree_Transaction::PENDING
        return $status;
    }


    /**
     * TODO: short description.
     *
     * @param array $d
     *
     * @return TODO
     */
    public function createCreditCard ($d)
    {
        if (empty($d['company'])) throw new Exception("Company ID is empty!");
        if (empty($d['BTcustomerID'])) throw new Exception("BT Customer ID is empty!");

        // error_log('BTcustomerID: ' . $d['BTcustomerID']);

        $array = array
            (
                'customerId' => $d['BTcustomerID'],
                'cardholderName' => $d['ccName'],
                'cvv' => $d['ccCvv'],
                'number' => $d['ccNumber'],
                'expirationDate' => $d['ccExpM'] . '/' . $d['ccExpY'], // 05/12
                'options' => array
                (
                    'verifyCard' => true
                )
            );

        $result = Braintree_CreditCard::create($array);

        if ($result->success)
        {
            // will save CC token
            $this->saveCreditCardToken($d['company'], $d['ccNumber'], $result->creditCard->token);

            return $result->creditCard->token;
        }
        else
        {
            $verification = $result->creditCardVerification;

            error_log($verification->status);
            // "gateway_rejected`"
            error_log($verification->gatewayRejectionReason);
            return false;
        }

        return false;
    }


    /**
     * TODO: short description.
     *
     * @param mixed $company             
     * @param mixed $BrainTreeCustomerID 
     *
     * @return TODO
     */
    private function updateCompanyCustomerID ($company, $BrainTreeCustomerID)
    {
        if (empty($company)) throw new Exception("Company ID is empty!");
        if (empty($BrainTreeCustomerID)) throw new Exception("Brain Tree customer ID is empty!");

        $data = array('BrainTreeCustomerID' => $BrainTreeCustomerID);

        $this->ci->db->where('id', $company);
        $this->ci->db->update('companies', $data);

        return true;
    }

    private function updateCompanySubscriptionID ($company, $subscriptionID)
    {
        if (empty($company)) throw new Exception("Company ID is empty!");
        if (empty($subscriptionID)) throw new Exception("Brain Tree subscription ID is empty!");

        $data = array('BrainTreeSubscriptionID' => $subscriptionID);

        $this->ci->db->where('id', $company);
        $this->ci->db->update('companies', $data);

        return true;
    }


    /**
     * TODO: short description.
     *
     * @param mixed $company 
     * @param mixed $number  
     * @param mixed $token   
     *
     * @return TODO
     */
    private function saveCreditCardToken ($company, $number, $token)
    {
        if (empty($company)) throw new Exception("Company ID is empty!");
        if (empty($number)) throw new Exception("Card number is empty!");
        if (empty($token)) throw new Exception("BrainTree Credit Card Token is empty!");


        $cardType = (int) substr($number, 0, 1);
        $lastFour = (int) substr($number, -4);

        if (empty($cardType)) throw new Exception("Card Type is empty!");
        if (empty($lastFour)) throw new Exception("last four digits of card is empty!");

        $data = array
            (
                'company' => $company,
                'cardType' => $cardType,
                'lastFour' => $lastFour,
                'token' => $token,
            );

        $this->ci->db->insert('companyBilling', $data);

        return $this->ci->db->insert_id();
    }
}
