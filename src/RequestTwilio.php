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
	protected $PHONE;

	/**
	 * @var int SMS LIMIT (before split). It's already a defined constant by Twilio!
	 */
	const LIMIT = 160;

	/**
	 * SMS Message
	 * @var string
	 */
	public $message;

	/**
	 * The home of Exceptions!
	 */
	public $error;

	/**
	 * Twilio object
	 */
	protected $twilio;

    public function __construct(
    	$sid = NULL, 
    	$token = NULL, 
    	$phone = NULL
    )
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
     * Exceptions saver
     * @return  string $error Saves Exception message
     */
    public function getError()
    {
    	return $this->error;
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
     * @return bool
     */
    public function sendSMS(
    	$send_to_number
    )
    {
    	if($this->_connectToTwilio())
    	{
    		$this->error = 'Failed to connect to Twilio';
    		return false;
    	}
		try {
			$this->_clear_error();

			$send = $this->twilio->messages->create(
			    $this->_getTwilioNumber($send_to_number),
			    array(
			        'from' => $this->_getTwilioNumber(),
			        'body' => $this->message
			    )
			);

		} catch (Exception $e) {
			$this->error = $e->getMessage();
			return false;
		}
    }

    /**
     * Connection will be done only on several functions
     * @return bool
     */
    private function _connectToTwilio()
    {
		$this->twilio = new Client($this->SID, $this->TOKEN);
    }

    private function _getTwilioNumber($phone = null)
    {
    	$phone = $phone ?: $this->PHONE;
    	return substr($phone, 0, 1) == '+' ? $phone : '+' . $phone;
    }

    private function _clear_error()
    {
    	$this->error = '';
    }
}