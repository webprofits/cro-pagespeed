<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Services\PageSpeedService;
use \Session, \Log, \Redirect, \Input;

class PageSpeedController extends Controller {

    private $version_override = null;
    private $defaultInputs = array (
        'email' => 'email.was.empty@webprofits.com.au',
        'url' => 'http://www.webprofits.com.au/'
    );

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;
    private $input = array();
    private $results = array();

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Override the default input from Http\Request\Input
     *
     * @param $key
     * @param $value
     */
    private function setInput($key, $value)
    {
        $this->input[$key] = $value;
    }

    /**
     * Get the input from our local overrides, if not set, then from  Http\Request\Input
     *
     * @param $key
     * @param null $default
     * @return string
     */
    private function getInput($key, $default = null)
    {
        if ($default === null && isset($this->defaultInputs[$key]))
            $default = $this->defaultInputs[$key];

        // Allow other functions to override what the input is going to be
        // without messing with any of the flash data.
        if (!empty($this->input[$key]))
            return $this->input[$key];

        return trim($this->request->input($key, $default));
    }

    public function resultsInfusion2(PageSpeedService $pagespeed)
    {
        $this->version_override = 2;
        return $this->resultsInfusion($pagespeed);
    }

    public function results2(PageSpeedService $pagespeed)
    {
        $this->version_override = 2;
        return $this->results($pagespeed);
    }


    /**
     * Flash the old inputs from the Infusionsoft response,
     * then pretend our request is a POST instead, with all the old information!
     *
     * @param PageSpeedService $pagespeed injected by router
     * @return Response
     */
    public function resultsInfusion(PageSpeedService $pagespeed)
    {
        $request = &$this->request;

        $this->setInput('url', $request->input('inf_field_Website', 'http://www.webprofits.com.au'));
        $this->setInput('email', $request->input('inf_field_Email', 'email.was.empty@webprofits.com.au'));
        $this->setInput('first_name', $request->input('inf_field_FirstName', 'Firstname'));

        return $this->results($pagespeed);
    }

	/**
	 * Display a listing of the resource.
	 *
     * @param PageSpeedService $pagespeed injected by router
	 * @return Response
	 */
	public function results(PageSpeedService $pagespeed)
    {
        $url = $this->getInput('url', 'http://www.webprofits.com.au');
        $email = $this->getInput('email');
        $first_name = $this->getInput('first_name');

        try {
            $results = $pagespeed->getResultsCache($url);
            $results['url'] = $url;
            $results['email'] = $email;
            $results['first_name'] = $first_name;
        } catch (\Exception $e) {
            Log::error("[ERROR] There was an error getting the pagespeed info for [$url]");
            Log::error($e);

            return $this->renderErrorResults();
        }

        $results['total'] = $results['ruleGroups']['SPEED']['score'] + $results['ruleGroups']['USABILITY']['score'];

        $this->results = $results;
        return $this->returnView();
    }

    public function whatType($ruleImpact) {
        if ($ruleImpact > 15)
            return 'should';
        return 'consider';
    }

    public function returnView()
    {
        $version = $this->getVersion();
        if ($this->getShouldShowFullView()) {
            return view(
                'pagespeed.results', array(
                    'results' => $this->results,
                    'version' => $version
                )
            );
        }

        return view(
            'pagespeed.domain_section', array(
                'results' => $this->results,
                'version' => $version
            )
        );
    }

    private function getShouldShowFullView()
    {
        $view = Input::get('view');
        if (!empty($view) && $view = 'ajax') {
            return false;
        }

        return true;
    }

    private function getVersion()
    {
        if ($this->version_override !== null)
            return $this->version_override;
        $version = Input::get('v');
        if ($version == '2')
            return 2;

        return 1;
    }

    public function renderErrorResults() {
        return Redirect::to('/')
            ->withErrors(array(
                'url' => 'Please check that the domain has been entered correctly. '.
                    'It might be a firewall, we could not connect to the site.'
            ))
            ->withInput()
            ->with($this->input);
    }
}
