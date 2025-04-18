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

    public function addtestAction() {
        try {
            $params = $this->getParams();
            
            $this->sampleService->testAdd($params);

            return new JsonModel(['success' => true]);
        } catch (ApplicationException $ex) {
            return $this->processApplicationError($ex);
        } catch (InvalidArgumentException $ex) {
            return $this->processApplicationError($ex);
        } catch (\Exception $ex) {
            return $this->processUnexpectedError($ex);
        }
    }
}