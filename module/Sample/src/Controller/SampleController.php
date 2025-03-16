<?php

namespace Sample\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Sample\Service\ParameterParser;
use Assert\InvalidArgumentException;

class SampleController extends AbstractActionController {
    protected ParameterParser $parameterParser;

    public function __construct(ParameterParser $parameterParser) {
        $this->parameterParser = $parameterParser;
    }

    public function testAction() {
        try {
            $params = $this->parameterParser->getParams($this);

            return new JsonModel(['helloworldthings' => $params['value']]);
        } catch (InvalidArgumentException $ex) {
            return $this->parameterParser->processApplicationError($ex);
        } catch (\Exception $ex) {
            return $this->parameterParser->processUnexpectedError($ex);
        }
    }
}