<?php
	/*
	Copyright: (c) 2009-2014 The Federal Tax Authority, LLC (FedTax). TaxCloud is a registered trademark of FedTax.
	This file contains Original Code and/or Modifications of Original Code as defined in, and that are subject to, the FedTax Public Source License (reference http://dev.taxcloud.net/ftpsl/ or http://taxcloud.net/ftpsl.pdf). 

	Support: Questions about this file should be directed to service@taxcloud.net.
	Author: John Milan (jmilan@fedtax.net)
	Revision: 1.0
	Released: 10/1/2013
	*/

    $RequestMethod = $_SERVER['REQUEST_METHOD'];
    $Authorization = $_SERVER['HTTP_X_AUTHORIZATION'];
    $SOAPAction = $_SERVER['SOAPAction'];
	  $QueryString = $_SERVER['QUERY_STRING'];
	
    // Put your TaxCloud API Login and API Key values here, along with the USPS User ID.
    $apiLoginID = "12574830";// Get API ID from TaxCloud
    $apiKey = "EE28E60F-11F8-48A8-9745-2C54E632EBCE";//Get API KEY from TaxCloud
    $uspsUserID = "XXXXXXXXXXXX"; //depricated - no longer required.
    
    $rawPostData = $HTTP_RAW_POST_DATA;
    $rawPostData = str_replace("\$apiLoginID", $apiLoginID, $rawPostData);
    $rawPostData = str_replace("\$apiKey", $apiKey, $rawPostData);
    $rawPostData = str_replace("\$uspsUserID", $uspsUserID, $rawPostData);
      
    $curl_log = fopen('curl_post_stderr.log', 'a+');    
    $curl = curl_init(urldecode($QueryString));
	  curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_STDERR, $curl_log);
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Content-Type: text/xml; charset=utf-8', 'Accept: text/xml', 'SOAPAction: ' . $SOAPAction ));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $rawPostData);
	  $response = curl_exec( $curl );
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    fclose($curl_log);
    
    //if ($http_status != 201) {
    //  $timestamp = strtotime("now");
    //  $f = fopen('puterror_' . $timestamp . '.txt', 'w');
    //  fwrite($f, $HTTP_RAW_POST_DATA);
    //  fwrite($f, "\n\n\n\n");
    //  fwrite($f, $http_status);
    //  fwrite($f, "\n\n\n\n");
    //  fwrite($f, $response);
    //  fclose($f);
    //}

    print $response;
?>