Complete payment implementation manual can be found at: http://www.payexpim.com/

-----

1. Edit settings.php to add your Merchant Account Number + Encryption key.
2. To test CompleteExample.php, you will need to add a valid path to the completeExample.php file inside initialize8Example.php and/or createAgreementExample.php.
3. After this, initialize8Example.php, completeExample.php and createAgreementExample.php can be used.

-----

File description:
The files included in the payex folder are used for easier integration. Common procedures such as calling the API through SOAP and building hash is handled by these files. You are free to use these as you wish.
PxOrder.php - Class that handles calling PxOrder API. http://www.payexpim.com/category/pxorder/
PxAgreement.php - Class that handles calling PxAgreement API. http://www.payexpim.com/category/pxagreement/
payexMD5.php - Class that handles creating an array of parameters with valid hash.
InvoiceOrderlines.php - Class that handles creating valid FinancingInvoice Orderlines http://www.payexpim.com/extended-functionality/financinginvoice-orderlines-invoice-2-0/

The example files show how PxOrder.php and PxAgreement.php can be used for easy integration.
settings.php - insert your merchant account number and encryption key here.
initialize8Example.php - Example file for making an Initialize request. initialize is called for most payment methods, initiating the payment flow. This example shows a redirect credit card payment.
createAgreementExample.php - Example file for creating an agreement for one-click/recurring payments. After PxAgreement.createAgreement is called, Initialize is called to make a payment, connecting a credit card to the agreement.
NOTE: PxAgreement.AutoPay3 would later be called to charge the customer using the agreement, this is not shown in the example file.
completeExample.php - After the user has made a payment at PayEx redirect page, merchants need to call PxOrder.Complete in order to get payment status for the transaction. Complete will tell the merchant whether the payment was successful or not.
orderlineExample.php - Example of making a 1-phase FinancingInvoice transaction with invoice orderlines, using the invoiceOrderlines.php file.
transactionCallback.php - Example of a Transaction Callback implementation.

-----

PayEx Technical support
support.solutions@payex.com
+46 (0)498 20 29 94