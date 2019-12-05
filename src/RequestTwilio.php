<?php

namespace Tafhyseni\TwilioSimple;

use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
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
	 * Text when making outbound calls from Twilio
	 */
	protected $CALL_TEXT;

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
     * CALL TEXT for outbound calls
     */
    public function setText($text)
    {
    	$this->CALL_TEXT = $this->_generate_text_to_say($text);
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
     * @param string $send_to_number Send the receiving number
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
			return true;
		} catch (Exception $e) {
			$this->error = $e->getMessage();
			return false;
		}
    }

    /**
     * Makes call and reads the Call Text
     * @param string $call_number Number that should be called
     * @return bool
     */
    public function makeCall($call_number)
    {
    	if($this->_connectToTwilio())
    	{
    		$this->error = 'Failed to connect to Twilio';
    		return false;
    	}

    	if(!$this->CALL_TEXT)
    	{
    		$this->error = 'Call text was not set properly!';
    		return false;
    	}

    	try {
	    	$call = $this->twilio->calls->create(
	    		$this->_getTwilioNumber($call_number),
	    		$this->_getTwilioNumber(),
	    		array(
	    			'twiml' => $this->CALL_TEXT
	    		)
	    	);
    		return true;
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

    private function _generate_text_to_say($text)
    {
    	$call_text = new VoiceResponse();
    	$call_text->say($text);
    	return $call_text;
    }
}