## Fligilo.Flfc

[![Build Status](https://travis-ci.org/fliglio/flfc.svg?branch=master)](https://travis-ci.org/fliglio/flfc)
[![Latest Stable Version](https://poser.pugx.org/fliglio/flfc/v/stable.svg)](https://packagist.org/packages/fliglio/flfc)

## Example

	<?php

	use Fliglio\Flfc as flfc;
	use Fliglio\Flfc\DefaultFcChainResolver;
	use Fliglio\Flfc\FcChainFactory;
	use Fliglio\Flfc\FcChainRunner;
	use Fliglio\Flfc\Context;
	use Fliglio\Flfc\Request;
	use Fliglio\Flfc\Response;

	error_reporting(E_ALL | E_STRICT);
	ini_set("display_errors" , 1);


	require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';



	// Configure Context
	$context = Context::get();
	$context->setRequest(new Request());
	$context->setResponse(new Response());

	$context->getRequest()->setCurrentUrl('/' . ltrim($_GET['fliglio_request'], '/'));
	$context->getRequest()->setPageNotFoundUrl("@404");
	$context->getRequest()->setErrorUrl("@error");

	$context->getRequest()->setRawInputStream(file_get_contents('php://input'));
	$context->getRequest()->setParams($_REQUEST);



	// Configure Front Controller Chain & Default Resolver

	$chain = new flfc\HttpApp(new flfc\ModuleApp());
	$resolver = new DefaultFcChainResolver($chain);
	FcChainFactory::addResolver($resolver);


	// Run App
	$chainRunner = new FcChainRunner();
	$chainRunner->dispatchRequest(Context::get());
