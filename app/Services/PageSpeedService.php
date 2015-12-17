<?php namespace App\Services;

use Input, Exception, Cache, Response, Log;
use PageSpeed\Insights\Service as PageSpeed;
use PageSpeed\Insights\Exception\RuntimeException as RuntimeException;

class PageSpeedService {

    private $hideItemsWithoutScores = true;

    private function validateDomain($domain)
    {
        $this->addValidator();

        $v = Validator::make(
            array('domain' => $domain),
            array(
                'domain' => 'required:validdomain'
            )
        );
    }

    private function addValidator()
    {
        Validator::extend('validdomain', function($attribute, $value, $parameters)
        {
            $ok = preg_match(
                '/^((?!-))(xn--)?[a-z0-9][a-z0-9-_]{0,61}[a-z0-9]{0,1}(\.(xn--)?([a-z0-9]{1,61}|[a-z0-9-]{1,30}\.[a-z]{2,}))*$/',
                $value
            );

            if (strpos($value, '.') === false)
                return false;

            return $ok;
        });
    }

    public function getResultsCache($url)
    {
        if (!preg_match('|^http[s]?://|', $url))
            $url = 'http://' . $url;

        $from_where = 'SCACHE';
        $results = Cache::remember('cache!_' . $url, 1, function() use ($url, &$from_where) {
            $from_where = 'PAGESPEED API';
            return $this->getResults($url);
        });

        Log::info('[' . $url . '] Serving results (from ' . $from_where . ')');

        return $results;
    }

    public function getResults($url) {
        $extra_parameters = array(
            'screenshot' => 'true'
        );

        $pageSpeed = new PageSpeed();
        try {
            $results = $pageSpeed->getResults($url, 'en_US', 'mobile', $extra_parameters);
        } catch (RuntimeException $e) {
            //throw new Exception("Something went wrong :<");
            throw $e;
        }

        if (!isset($results['formattedResults'])) {
            throw new Exception("Something went wrong :<");
        }

        $newResults = $this->cleanUpPageSpeedResults($results);

        // Decode that screenshot!
        if (isset($results['screenshot'])) {
            $screenshot_filename = 'screenshots/webprofits_' . md5($url . '__!__' . time()) . '.jpg';
            $screenshot = str_replace(array('_', '-'), array('/', '+'), $results['screenshot']['data']);
            $jpg = base64_decode($screenshot);

            file_put_contents($screenshot_filename, $jpg);
            unset ($results['screenshot']);
            unset ($newResults['screenshot']);
            unset ($screenshot);
            unset ($jpg);

            $newResults['screenshot'] = $screenshot_filename;
        }

        return $newResults;
    }

    private function cleanUpPageSpeedResults(&$results) {
        $newResults = $results;
        $formatted = $results['formattedResults']['ruleResults'];
        unset($newResults['formattedResults']);
        unset($newResults['version']);

        /**
         * Find out which results will have the greatest impact.
         */
        $scores = array();
        $items = array();
        $group_items = array();
        foreach ($formatted as $name => $result) {
            if ((isset($result['ruleImpact'])) &&
                (!$this->hideItemsWithoutScores || $result['ruleImpact'] > 0) &&
                ((isset($result['summary']) && isset($result['summary']['format']) &&
                    strlen($result['summary']['format']) > 10)
                )
            ) {
                $item = $result;
                // Get rid of some (unrequired) information...
                /*
                if (isset($item['urlBlocks'])) {
                    unset($item['urlBlocks']);
                }
                if (isset($item['urlBlocks'])) {
                    $item['blocks'] = $this->parseUrlBlocks($item['urlBlocks']);
                }
                */

                /**
                 * Replace any of the parameters...
                 */
                if (isset($item['summary']['args'])) {
                    $item['args'] = $item['summary']['args'];
                }

                if (isset($item['summary'])) {
                    $item['summary'] = $this->cleanSummary($item);
                }

                $item['rule_name'] = $item['localizedRuleName'];
                unset($item['localizedRuleName']);
                unset($item['groups']);

                /**
                 * Throw all of the rule impacts into the array...
                 */
                $scores[] = $result['ruleImpact'];
                $group = $result['groups'][0];

                if (!isset($group_items[$group]))
                    $group_items[$group] = array();

                $group_items[$group][] = $item;
            }
        }

        foreach($group_items as $key => &$rule_items) {
            $scores = array();
            foreach($rule_items as &$_item) {
                $scores[] = $_item['ruleImpact'];
            }
            array_multisort($scores, SORT_DESC, $rule_items);
        }

        $items = $group_items;

        $newResults['messages'] = $items;
        $newResults['error'] = false;

        //return \Response::json($newResults);
        return $newResults;
    }

    private function cleanSummary(&$item, $args = array()) {
        if (isset($item['summary']['args']))
        {
            $args = $item['summary']['args'];
        }

        return $this->parseSummary($item, $args);
    }

    private function parseUrlBlocks(&$blocks)
    {
        $newBlocks = array();
        foreach ($blocks as $block) {
            $newBlocks[] = $this->parseBlock($block);
        }

        return $newBlocks;
    }

    private function parseBlock(&$item) {
        /*
            [format] => {{BEGIN_LINK}}Remove render-blocking JavaScript{{END_LINK}}:
            [args] => Array
                (
                    [0] => Array
                        (
                            [type] => HYPERLINK
                            [key] => LINK
                            [value] => https://developers.google.com/speed/docs/insights/BlockingJS
                        )

                )
         */
        $newBlock = array();
        if (isset($item['header']['args'])) {
            $args = $item['header']['args'];
            $newBlock['header'] = preg_replace_callback('|\{\{([A-Z\_]*)\}\}|',
                function ($matches) use ($item, &$count, $args) {
                    $key_name = $matches[1];
                    if (count($args) == 0) {
                        return '';
                    }

                    if (!isset($args[$count])) {
                        return '';
                    }

                    if ($args[$count]['key'] == $key_name) {
                        return $args[$count]['value'];
                    }

                    return '';
                },
                $item['header']['format']
            );
        }
    }

    private function parseSummary(&$item, $args) {
        $count = 0;
        return preg_replace_callback('|\{\{([A-Z\_]*)\}\}|',
            function ($matches) use ($item, &$count, $args) {
                $key_name = $matches[1];
                if (count($args) == 0) {
                    return '';
                }

                if (!isset($args[$count])) {
                    return '';
                }

                if ($args[$count]['key'] == $key_name) {
                    return $args[$count]['value'];
                }

                return '';
            },
            $item['summary']['format']
        );
    }
}