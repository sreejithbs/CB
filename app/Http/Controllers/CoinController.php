<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Btcaddress;
use App\User;
use Auth;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;

use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;

class CoinController extends Controller
{

	// INDEX PAGE
	public function index(){
		$currentUser = Auth::user();

		$btcaddresses = Btcaddress::where('user_id', $currentUser->id)->get();
		return view('home', compact('currentUser', 'btcaddresses'));
	}


	// CREATE ADDRESS BUTTON
	public function createAddress($walletID){

		$apiKey = 'LNQbgw6dJdn8s1di';
		$apiSecret = 'oBk7KtrvVB8gEw69CCAm2iiBElia1EA4';

		$configuration = Configuration::apiKey($apiKey, $apiSecret);
		$client = Client::create($configuration);

		$currentUserID = Auth::user()->id;
		$currentUserName = Auth::user()->name;

		// Create NEW Address
		$currentWalletID = Account::reference($walletID);
		$address = new Address([
		    'name' => 'Address generated by '. $currentUserName
		]);
		$add = $client->createAccountAddress($currentWalletID, $address);
		$addressId = $client->getAccountAddresses($currentWalletID);
		$addresses = $client->getAccountAddress($currentWalletID, $addressId->getFirstId());
		$currentAddressID = $addresses->getAddress();

		// $address = $client->getAccountAddress($currentWalletID, $currentAddressID);
		// $transactions = $client->getAddressTransactions($address);
		// $transactions = $client->decodeLastResponse();
		// dd($transactions['data']);

		$address = new Btcaddress;
		$address->user_id = $currentUserID;
		$address->address = $currentAddressID;
		$address->save();

		return redirect()->route('home');
	}


	// SEND BTC BUTTON
	public function sendBTC(){
		$apiKey = 'LNQbgw6dJdn8s1di';
		$apiSecret = 'oBk7KtrvVB8gEw69CCAm2iiBElia1EA4';

		$configuration = Configuration::apiKey($apiKey, $apiSecret);
		$client = Client::create($configuration);

		// GET PRIMARY A/C TO RECEIVE PAYMENT
		$PrimaryAccount = $client->getPrimaryAccount();
		$PrimaryAddress = new Address([
		    'name' => 'A/c generated for fund receiving'
		]);
		$client->createAccountAddress($PrimaryAccount, $PrimaryAddress);
		$PrimaryAddressID = $client->getAccountAddresses($PrimaryAccount);
		$PrimaryAddressses = $client->getAccountAddress($PrimaryAccount, $PrimaryAddressID->getFirstId());
		$currentReceiveAddress = $PrimaryAddressses->getAddress();

		return view('sendBTC', compact('currentReceiveAddress'));
	}


	// SEND BTC BUTTON FUNCTIONALITY
	public function BTCsendForm($currentReceiveAddress){

		$apiKey = 'LNQbgw6dJdn8s1di';
		$apiSecret = 'oBk7KtrvVB8gEw69CCAm2iiBElia1EA4';

		$configuration = Configuration::apiKey($apiKey, $apiSecret);
		$client = Client::create($configuration);

		$currentUserID = Auth::user()->id;
		$currentUserName = Auth::user()->name;
		$bitcoinWalletID = Auth::user()->bitcoinWalletID;

		$fromAccount = Account::reference($bitcoinWalletID);
		// Create NEW Address
		// $address = new Address([
		//     'name' => 'Address generated by '. $currentUserName . ' for BTC sending'
		// ]);
		// $add = $client->createAccountAddress($fromAccount, $address);
		// $addressId = $client->getAccountAddresses($fromAccount);
		// $addresses = $client->getAccountAddress($fromAccount, $addressId->getFirstId());
		// $currentAddressID = $addresses->getAddress();

		// $address = new Btcaddress;
		// $address->user_id = $currentUserID;
		// $address->address = $currentAddressID;
		// $address->save();

		$sendTransaction = Transaction::send([
		    'toBitcoinAddress' => $currentReceiveAddress,
		    'amount'           => new Money(5, CurrencyCode::USD),
		    'description'      => 'My First Bitcoin Transaction!',
		]);

		$client->createAccountTransaction($fromAccount, $sendTransaction);
		// print_r($sendTransaction);
		// After some time, the transaction should complete and your balance should update
		// $client->refreshAccount($primaryAccount);
		return redirect()->route('home');
	}


	// public function receiveBTC(){
	// 	$apiKey = 'LNQbgw6dJdn8s1di';
	// 	$apiSecret = 'oBk7KtrvVB8gEw69CCAm2iiBElia1EA4';

	// 	$configuration = Configuration::apiKey($apiKey, $apiSecret);
	// 	$client = Client::create($configuration);

	// 	// GET PRIMARY A/C TO RECEIVE PAYMENT
	// 	$PrimaryAccount = $client->getPrimaryAccount();
	// 	$PrimaryAddress = new Address([
	// 	    'name' => 'A/c generated for fund receiving'
	// 	]);
	// 	$client->createAccountAddress($PrimaryAccount, $PrimaryAddress);
	// 	$PrimaryAddressID = $client->getAccountAddresses($PrimaryAccount);
	// 	$PrimaryAddressses = $client->getAccountAddress($PrimaryAccount, $PrimaryAddressID->getFirstId());
	// 	$currentReceiveAddress = $PrimaryAddressses->getAddress();

	// 	// return view('receive', compact('currentReceiveAddress'));
	// }



		// echo "Your address is: ".json_encode($PrimaryAddressses->getAddress())."<br>";



		// $account = Account::reference("da9aade1-f3e3-575d-8923-ed110aded998");

		// $transaction = Transaction::send();
		// $transaction->setToBitcoinAddress('1Noe2Po2HFMVySezNcwzSwDbcP5jfwdiAK');
		// $transaction->setAmount(new Money(0.00100, CurrencyCode::BTC));
		// $transaction->setDescription('this is optional');
		// $client->createAccountTransaction($account, $transaction);

		// $transaction = Transaction::request([
		//     'amount'      => new Money(8, CurrencyCode::USD),
		//     'description' => 'Burrito'
		// ]);

		// $client->createAccountTransaction($transaction);

		// $paymentMethods = $client->getPaymentMethods();
		// $account = $client->getPrimaryAccount();

		// echo $account;

		// $account = Account::reference('da9aade1-f3e3-575d-8923-ed110aded998');
		// $buy = new Buy([
		//     'bitcoinAmount' => 0.00000000001
		// ]);

		// $client->createAccountBuy($account, $buy);




		// $account = new Account();
		// $account->setName('WALET 101');
		// $client->createAccount($account);
		// echo $account->getID();


		// // $account = Account::reference('fc51cc84-bd1a-57f0-b155-896f1dfa025f'); // $account = $client->getAccount("fc51cc84-bd1a-57f0-b155-896f1dfa025f");
		// echo $account->getID();


		//GET ALL ACCOUNTS
		// $accounts = $client->getAccounts();
		// foreach ($accounts as &$account) {
		//   $balance = $account->getBalance();
		//   echo $account->getID();
		//   echo "***********";
		//   // print_r($client->getAccountTransactions($account));
		// }

		// $address = $client->getAccountAddress($account, $addressId);
		//  $transactions = $client->getAddressTransactions($address);
		//  $transactions = $client->decodeLastResponse();
		//  echo var_dump($transactions['data']);


		// echo "***********";
		// Create NEW Address BUTTON
		// $account = Account::reference('d85288db-9017-5586-8b34-f9828a3a46a7');
		// $address = new Address([
		//     'name' => 'Test Address 101'
		// ]);
		// $add = $client->createAccountAddress($account, $address);
		// $addressId = $client->getAccountAddresses($account);
		// $addresses = $client->getAccountAddress($account, $addressId->getFirstId());
		// echo "Your address is: ".json_encode($addresses->getAddress())."<br>";




}
