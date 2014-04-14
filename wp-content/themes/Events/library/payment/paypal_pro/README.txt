Implementation of PayFlow API with PHP and CURL using the HTTP protocol (no SDK needed)

The script implements the HTTPS protocol, via the PHP cURL extension. 

Check payflow_examples.php file for different transactions you can use.

The URLs to use are:
for testing: pilot-payflowpro.verisign.com 
production: payflowpro.verisign.com

The nice thing about this protocol is that if you *don't* get a
$response, you can simply re-submit the transaction *using the same
REQUEST_ID* until you *do* get a response -- every time PayPal gets
a transaction with the same REQUEST_ID, it will not process a new
transactions, but simply return the same results, with a DUPLICATE=1
parameter appended.

API rebuild by Radu Manole, 
radu@u-zine.com, March 2007

Many thanks to Sieber Todd, tsieber@paypal.com