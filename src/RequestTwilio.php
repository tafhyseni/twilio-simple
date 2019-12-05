<?php

namespace Tafhyseni\TwilioSimple;

use Twilio\Rest\Client;
use Exception;

class RequestTwilio
{

	/**
	 * @var string The Twilio SID
	 */
	protected $SID;

	/**
	 * @var string The Twilio API Token
	 */
	protected $TOKEN;

	/**
	 * @var string A Valid Twilio phone number
	 */
	protected $phone_number;

	/**
	 * @var int SMS LIMIT (before split). It's already a defined constant by Twilio!
	 */
	const LIMIT = 160;

	/**
	 * SMS Message
	 * @var string
	 */
	public $message;

	public $twilio;

    public function __construct($sid = NULL, $token = NULL, $phone = NULL)
    {
    	if(!isset($sid) || !isset($token))
    	{
    		throw new Exception('Configuration failure. Make sure you set SID and Token from Twilio Console!');
    	}
        $this->SID = $sid;
        $this->TOKEN = $token;
        $this->PHONE = $phone;
    }

    /**
     * SMS Message setter
     * @param string $message SMS Message
     */
    public function setSMS($message)
    {
		$this->message = $message;    	
    }

    /**
     * SMS Message getter
     * @return string SMS Message
     */
    public function getSMS()
    {
    	return $this->message;
    }

    /**
     * Preview the SMS message body
     * @return string message preview
     */
    public function preview()
    {
    	//
    }

    /**
     * Returns the number of SMS's needed for the SMS message
     * @return int
     */
    public function countSMS()
    {
    	return count(str_split($this->message, self::LIMIT));
    }

    /**
     * Sends the SMS request to Twilio API
     * @return array Returns array will response code and message
     */
    public function sendSMS($phone_number)
    {
    	// Send SMS
    }

    /**
     * Connection will be done only on several functions
     * @return bool
     */
    public function connectToTwilio()
    {
		$this->twilio = new Client($this->sid, $this->token);
		return $this->twilio;
    }
}