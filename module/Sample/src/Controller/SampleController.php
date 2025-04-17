<?php

namespace Sample\Controller;

use Library\Utils\ParameterParser;
use Laminas\View\Model\JsonModel;
use Assert\InvalidArgumentException;
use Library\Exception\ApplicationException;
use Monolog\Logger;
use Sample\Service\SampleService;

class SampleController extends ParameterParser {

    /**
     * @var SampleService
     */
    private $sampleService;

    public function __construct(
        Logger $log,
        SampleService $sampleService,
    ) {
        parent::__construct($log);
        $this->sampleService = $sampleService;
    }

    public function sampleAction() {
        try {
            $params = ['sample' => 'sample data'];

            return new JsonModel($params);
        } catch (ApplicationException $ex) {
            return $this->processApplicationError($ex);
        } catch (InvalidArgumentException $ex) {
            return $this->processApplicationError($ex);
        } catch (\Exception $ex) {
            return $this->processUnexpectedError($ex);
        }
    }

    public function testAction() {
        try {
            $params = $this->getParams();
            
            $forReturn = $this->sampleService->testString($params);

            return new JsonModel(['result' => $forReturn]);
        } catch (ApplicationException $ex) {
            return $this->processApplicationError($ex);
        } catch (InvalidArgumentException $ex) {
            return $this->processApplicationError($ex);
        } catch (\Exception $ex) {
            return $this->processUnexpectedError($ex);
        }
    }
}