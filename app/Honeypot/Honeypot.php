<?php

namespace App\Honeypot;

use Illuminate\Http\Request;

class Honeypot
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var array
     */
    private $config;

    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function detectSpam()
    {
        $configHoneyPot = $this->config;
        $request = $this->request;
        if(! $configHoneyPot['enable']) {
            return false;
        }
        if (! $request->has($configHoneyPot['field_name'])) { // normal/valid user will always send this field name
            return true;
        }

        if ($request->get($configHoneyPot['field_name'])) { // normal/valid user will always send this field name with empty/null value
            return true;
        }

        $currentTime = microtime(true);
        if ($currentTime - $request->get($configHoneyPot['field_time_name']) <= $configHoneyPot['minimum_time']) { // fill data to quick
            return true;
        }

        return false;
    }
}
