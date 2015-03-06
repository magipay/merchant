
	function display_paymentBox(uniqueID, boxID, publicKey, clientID, invoiceID, amountUSD){
		//:method/:uniqueID/:boxID/:publicKey/:clientID/:invoiceID/:amountUSD
		
		if (uniqueID == '' || boxID == '' || publicKey == '' || clientID == '' || invoiceID == '' || amountUSD == '' ) alert('Insufficient Data');
		else if (amountUSD <= 0) alert('Invalid payment box amount');
		else if (invoiceID == '') alert('Invalid invoiceID');
		else 
		{
			var url = 'https://www.m-epays.com/v1/m-epaymentBox/create' + 
			'/'+encodeURIComponent(uniqueID)+
			'/'+encodeURIComponent(boxID)+
			'/'+encodeURIComponent(publicKey)+
			'/'+encodeURIComponent(clientID)+
			'/'+encodeURIComponent(invoiceID)+
			'/'+encodeURIComponent(amountUSD)
			;
			
			var magibox = document.getElementById('magiPaymentBox');
			
			magibox.src = url;
		}
		
		return true;
	}
	
 