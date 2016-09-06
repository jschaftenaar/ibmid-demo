<?php

namespace App;

class Oauth2
{
	/**
	 * @var string
	 */
	private $endpointBaseUrl;

	/**
	 * @var string
	 */
	private $clientId;

	/**
	 * @var string
	 */
	private $clientSecret;

	/**
	 * @var Session
	 */
	private $session;

	/**
	 * @var string
	 */
	private $redirectUrl = 'https://peaceful-wildwood-33778.herokuapp.com/callback';

	public function __construct($endpointBaseUrl, $clientId, $clientSecret, $session)
	{
		$this->endpointBaseUrl = $endpointBaseUrl;
		$this->clientId        = $clientId;
		$this->clientSecret    = $clientSecret;
		$this->session         = $session;
	}

	public static function create()
	{
		return new self(
			getenv('IBMID_ENDPOINT_BASE_URL'),
			getenv('IBMID_CLIENT_ID'),
			getenv('IBMID_CLIENT_SECRET'),
			new Session()
		);
	}

	public function authorize()
	{
		$this->session->set('state', md5(uniqid(mt_rand(), true)));

		$queryParams = [
			'client_id'     => $this->clientId,
			'redirect_url'  => $this->redirectUrl,
			'scope'         => 'openid',
			'response_type' => 'code',
			'state'         => $this->session->get('state'),
		];

		$url = $this->endpointBaseUrl.'/authorize'.'?'.http_build_query($queryParams);

		header('Location: '.$this->endpointBaseUrl.'/authorize');
		die();
	}
}
