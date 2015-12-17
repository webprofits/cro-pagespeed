<?php namespace App\Http\Controllers;

use Input, Exception, Cache, Response, Log;
use PageSpeed\Insights\Service as PageSpeed;

class PageSpeedAPIController extends Controller {

    private $hideItemsWithoutScores = true;

    function endpoint()
    {
        $url = Input::get('url');
        Log::info('Endpoint hit for: ' . $url);

        if (empty($url)) {
            throw new Exception("URL is empty!");
        }

        try {
            return $this->getResultsCache($url);
        } catch (\Exception $e) {
            \Log::info($e);
            return \Response::JSON(array(
                'error' => true,
                'message' => $e->getMessage()
            ));
        }
    }

}