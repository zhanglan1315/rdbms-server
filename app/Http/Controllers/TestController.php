<?php

namespace App\Http\Controllers;

use DB;

class TestController extends Controller
{
  public function test()
  {
    return 'server is running';
  }
}
