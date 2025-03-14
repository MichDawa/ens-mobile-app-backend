<?php

namespace Application\Controller;

use Monolog\Logger;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use App\Library\Utils\ApplicationFlags;
use Assert\Assertion;

class BaseLogActionController extends AbstractActionController {

    protected $log;

    public function __construct(Logger $log) {
        $this->log = $log;
    }

    protected function getLogger() {
        return $this->log;
    }

    public function getParams() {

        if ($_POST) {
            return $this->getRequest()->getPost();
        }
        return json_decode($this->getRequest()->getContent(), true);
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter() {
        $event = $this->getEvent();
        $inputFilter = $event->getParam("Laminas\ApiTools\ContentValidation\InputFilter");
        return $inputFilter;
    }

    private function checkActiveUser(string $message) {
        $isActive = $this->getUser()->isActive();
        Assertion::eq($isActive, ApplicationFlags::YES, $message);
    }

    public function checkSinglePermission(string $permission, string $message) {
        $this->checkActiveUser($message);

        $role = $this->getUser()->getRole();
        $hasPermission = $role->hasPermission($permission);
        Assertion::true($hasPermission, $message);
    }

    public function processApplicationError($ex) {
        $this->getLogger()->error($ex->getMessage(), ["ex" => $ex->getTraceAsString()]);
        return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
    }

    public function processUnexpectedError(\Exception $ex) {
        $this->getLogger()->error($ex->getMessage(), ["ex" => $ex->getTraceAsString()]);
        return new ApiProblemResponse(new ApiProblem(500, "Unexpected error occured."));
    }

    public function processError(\Error $ex) {
        //for type error or missing params
        $this->getLogger()->error($ex->getMessage(), ["ex" => $ex->getTraceAsString()]);
        return new ApiProblemResponse(new ApiProblem(500, "Unexpected error occured."));
    }

    public function notAuthorized() {
        return new ApiProblemResponse(new ApiProblem(403, "You are not authorized to access this resource."));
    }
    
}
