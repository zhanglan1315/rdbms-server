<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function viaParams($params, $rules)
	{
		$validator = \Validator::make($params, $rules);

		if ($validator->fails()) {
			throw new \Illuminate\Validation\ValidationException($validator);
		}

		$result = [];

		foreach ($rules as $key => $value) {
			if (isset($params[$key])) {
				$result[$key] = $params[$key];
			} else {
				$result[$key] = null;
			}
		}

		return $result;
	}

	public function via(array $rules)
	{
		$params = request(array_keys($rules));

		return $this->viaParams($params, $rules);
	}

	public function get($name, $rule, $default = null)
	{
		$params = request([$name]);

		$this->viaParams($params, [$name => $rule]);

		$param = isset($params[$name]) ? $params[$name] : $default;

		return $param;
	}
}
