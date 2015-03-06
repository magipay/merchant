<?php

include_once("db_connect.php");

class magipay {
	
	private $clientID		= "";
	private $boxID			= "";
	private $public_key 	= "";		
	private $private_key 	= "";			
	private $amountUSD 		= 0;		
	private $invoiceID 		= "";		
	private $userID 		= "";	
	private $uniqueID 		= "";	

	private $payment_received = false;
	
	private $invoice		= "";

	public function __construct($options = array()){
	
		foreach($options as $key => $value) 
			if (in_array($key, array("public_key", "clientID", "boxID", "invoiceID", "amountUSD"))) 
				$this->$key = (is_string($value)) ? trim($value) : $value;
		
		$this->clientID = preg_replace('/[^A-Za-z0-9\-]/', '', $this->clientID);
		$this->public_key = preg_replace('/[^A-Za-z0-9\-]/', '', $this->public_key);
		
		if ($this->amountUSD && strpos($this->amountUSD, ".")) 	
			$this->amountUSD = rtrim(rtrim($this->amountUSD, "0"), ".");
		if (!$this->amountUSD || $this->amountUSD <= 0) 	
			$this->amountUSD = 0;
		if ($this->amountUSD && (!is_numeric($this->amountUSD))) 
			die("Invalid amountUSD");
			
		$this->payment_received = $this->check_transaction_status();
		
		$this->uniqueID = $this->generate_uniqueID();
		
		return true;
	}
	
	public function check_transaction_status(){
		global $db_conx;
		$invoice = $this->invoiceID;
		$sql = "SELECT payment_received FROM magiEpayments WHERE invoiceID = '$invoice' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		if($query){
			$result = mysqli_num_rows($query);
			
			if($result > 0){
				$this->payment_received = true;
			}else{
				$this->payment_received = false;
			}
		}
		
		mysqli_close($db_conx);
		return $this->payment_received;
	}
	
	public function invoice_paid(){
		
		if ($this->payment_received)
			return true;
		else 
			return false;
	}
	
	public function display_magibox(){
		$magipay_html = "";
		$magipay_html .= "<br>";
		//$magipay_html .= "<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>"	
		$magipay_html .= "<div id='magiPayBox' align='center'><iframe id='magiPaymentBox' width='500px' height='400px' scrolling='no' marginheight='0' marginwidth='0' frameborder='0'></iframe></div>";
		//$magipay_html .= "</div>";
		$magipay_html .= "<div><script type='text/javascript'>";
		$magipay_html .= "display_paymentBox('$this->uniqueID', $this->boxID, '$this->public_key', '$this->clientID', '$this->invoiceID',  $this->amountUSD);";
		$magipay_html .= "</script></div>";
		
		if (isset($_POST["check"])){
			$this->check_transaction_status();
			if($this->payment_received){
				$magipay_html .= "<div align='center'>";
				$magipay_html .= "<span>This invoice has been paid.</span>";
				$magipay_html .= "</div>";
			}
		}
		
		if (!$this->payment_received){
			$magipay_html .= "<form action='".$_SERVER["REQUEST_URI"]."' method='post'>";
			$magipay_html .= "<input type='hidden' id='check' name='check' value=''>";
			$magipay_html .= "<div align='center'>";
			$magipay_html .= "<button style='color:#fff;border-color:#ccc;background:#00B2EE;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top;display:inline-block;text-decoration:none;font-size:13px;line-height:26px;height:28px;margin:20px 0 25px 0;padding:0 10px 1px;cursor:pointer;border-width:1px;-webkit-appearance:none;-webkit-border-radius:3px;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;font-family:\"Open Sans\",sans-serif;font-size: 13px;font-weight: normal;text-transform: none;'>&#160; Click If You Already Sent Payment &#160;</button>";
			$magipay_html .= "</div>";
			$magipay_html .= "</form>";
		}
		$magipay_html .= "<br>";
		 
		echo $magipay_html;
	}
	
	public function generate_uniqueID(){
		$uid = sha1($this->invoiceID."".$this->boxID);
		return $uid;
	}
	
	function randStrGen($len){
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789$$$$$$$1111111";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return $result;
	}
	
}	
// end class
?>