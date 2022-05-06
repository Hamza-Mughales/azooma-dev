<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        ),
        'Twitter' => array(
            'client_id'         => 'xKIxQ9BKqsM0TzpyeB5FJA',
            'client_secret'     => 'PXZbZrUUu7a6EPy4UYQrfdEKSG0ni6M8lIEUWmGNqPA',
        ),

	)

);