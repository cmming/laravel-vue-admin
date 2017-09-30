<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Auth\Access\AuthorizationException;
use Exception;

trait HandlesPolicy
{
	/**
	 * Create a new access response.
	 *
	 * @param  string|null  $message
	 * @return \Illuminate\Auth\Access\Response
	 */
	protected function allow($message = null)
	{

//		return new Response($message);
		return true;
	}

	/**
	 * Throws an unauthorized exception.
	 *
	 * @param  string  $message
	 * @return void
	 *
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	protected function deny()
	{
		throw new Exception(['code'=>2001,'msg'=>'没有权限',],2001);
//		throw new AuthorizationException($message);
	}
}