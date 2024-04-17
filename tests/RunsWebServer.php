<?php

namespace Tests;

use Symfony\Component\Process\Process;

trait RunsWebServer
{
	/**
	 * @var Process
	 */
	protected static $webServerProcess;
	
	/**
	 * Start the web server process
	 */
	public static function startWebServer()
	{
		static::$webServerProcess = static::buildServerProcess();
		static::$webServerProcess->start();
		static::afterClass(function() {
			static::stopWebServer();
		});
	}
	
	/**
	 * Stop the web server process
	 */
	public static function stopWebServer()
	{
		if (static::$webServerProcess) {
			static::$webServerProcess->stop();
		}
	}
	
	/**
	 * Build the process to run the web server
	 *
	 * @return \Symfony\Component\Process\Process
	 * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 */
	protected static function buildServerProcess()
	{
		//$host = env('TEST_SERVER_HOST', '127.0.0.1');
		//$port = env('TEST_SERVER_PORT', 8000);
		
		$command = [
			PHP_BINARY,
			'artisan',
			"serve",
		];

		$process = new Process($command);
		$process->setTimeout(null)->setWorkingDirectory(realpath(__DIR__.'/../'));
		return $process;

	}
}