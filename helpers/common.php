<?php 
/*
|----------------------------------------------------------------
| 全局辅助函数
|----------------------------------------------------------------
| 该文件内定义的php函数将可在整个项目下随意使用
|
*/
if ( ! function_exists('config_path'))
{
    /**
    * Get the configuration path.
    *
    * @param string $path
    * @return string
    */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if (! function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  array|string  $key
     * @param  mixed   $default
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }
        if (is_array($key)) {
            return app('request')->only($key);
        }
        return data_get(app('request')->all(), $key, $default);
    }
}

function array_push_or_set(array &$arr, $key, &$data)
{
    if (!array_key_exists($key, $arr)) {
        $arr[$key] = [];
    }
    $arr[$key][] = $data;
}

function list_compare($list)
{
    return function ($a, $b) use ($list) {
        return (array_search($a['id'], $list) < array_search($b['id'], $list)) ? -1 : 1;
    };
}

function success_response($messages, $status = 201)
{
    if (!is_array($messages)) {
        $messages = ['message' => $messages];
    }

    return response()->json($messages, $status);
}

function error_response($messages, $status = 400)
{
    if (!is_array($messages)) {
        $messages = ['message' => $messages];
    }

    throw new \App\Exceptions\CustomerExpection(
        response()->json($messages, $status)
    );
}

function array_encode($data)
{
    return '{'.implode(',', $data).'}';
}

function array_decode($data)
{
    return json_decode('['.substr($data, 1, -1).']', true);
}

function array_decode_string($data)
{
    return explode(',', substr($data, 1, -1));
}

function error($messages, $code = 400)
{
    if (!is_array($messages)) {
        $messages = ['message' => $messages];
    }
    throw new \App\Exceptions\CustomerExpection(
        response()->json($messages, $code)
    );
}

function json_set($item, $key, $value)
{
    $data = $item->doc;
    $data[$key] = $value;
    $item->doc = $data;
}

function validate(array $rules)
{
    $result = request(array_keys($rules));

    $validator = \Validator::make($result, $rules);

    if ($validator->fails()) {
        throw new \Illuminate\Validation\ValidationException($validator);
    } else {
        return $result;
    }
}
