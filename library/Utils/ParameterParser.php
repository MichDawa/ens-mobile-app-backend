<?php

namespace Library\Utils;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\InputFilter\InputFilter;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Monolog\Logger;
use InvalidArgumentException;

class ParameterParser extends AbstractActionController {
    /**
     * @var Logger
     */
    protected $log;

    /**
     * BaseActionController constructor.
     *
     * @param Logger $log
     */
    public function __construct(
        Logger $log
    ){
        $this->log = $log;
    }

    /**
     * Extract parameters from the controller's request.
     *
     * This method merges parameters from the route, query, and post. It also checks
     * if the request Content-Type is "application/json" and, if so, parses the JSON payload,
     * merging it with any existing parameters.
     *
     * @return array
     * @throws InvalidArgumentException if the JSON payload is invalid.
     */
    public function getParams() {
        $params = array_merge(
            $this->params()->fromRoute(),
            $this->params()->fromQuery(),
            $this->params()->fromPost()
        );

        // Remove controller and action parameters to avoid conflicts.
        unset($params['controller'], $params['action']);

        $request = $this->getRequest();
        $contentTypeHeader = $request->getHeaders()->get('Content-Type');

        // Check if the request payload is JSON.
        if ($contentTypeHeader && $contentTypeHeader->getMediaType() === 'application/json') {
            $content = $request->getContent();
            $jsonParams = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidArgumentException('Invalid JSON payload');
            }

            $params = array_merge($params, (array)$jsonParams);
        }

        return $params;
    }

    /**
     * Retrieve the InputFilter used by the current request.
     *
     * @return InputFilter
     */
    public function getInputFilter(): InputFilter {
        $event = $this->getEvent();
        return $event->getParam("Laminas\ApiTools\ContentValidation\InputFilter");
    }

    /**
     * Process an application error and return an appropriate API Problem response.
     *
     * @param \Exception $ex
     * @return ApiProblemResponse
     */
    public function processApplicationError(\Exception $ex) {
        $this->log->error($ex->getMessage(), ['ex' => $ex->getTraceAsString()]);
        return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
    }

    /**
     * Process an unexpected error and return an appropriate API Problem response.
     *
     * @param \Exception $ex
     * @return ApiProblemResponse
     */
    public function processUnexpectedError(\Exception $ex) {
        $this->log->error($ex->getMessage(), ['ex' => $ex->getTraceAsString()]);
        return new ApiProblemResponse(new ApiProblem(500, "Unexpected error occurred."));
    }

    /**
     * Process a PHP error and return an appropriate API Problem response.
     *
     * @param \Error $ex
     * @return ApiProblemResponse
     */
    public function processError(\Error $ex) {
        $this->log->error($ex->getMessage(), ['ex' => $ex->getTraceAsString()]);
        return new ApiProblemResponse(new ApiProblem(500, "Unexpected error occurred."));
    }

    /**
     * Return an API Problem response indicating that the user is not authorized to access the resource.
     *
     * @return ApiProblemResponse
     */
    public function notAuthorized() {
        return new ApiProblemResponse(new ApiProblem(403, "You are not authorized to access this resource."));
    }
}