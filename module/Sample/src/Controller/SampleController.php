<?php

namespace Sample\Controller;

use Library\Utils\ParameterParser;
use Laminas\View\Model\JsonModel;
use Assert\InvalidArgumentException;
use Library\Exception\ApplicationException;
use Monolog\Logger;

class SampleController extends ParameterParser {

    public function __construct(
        Logger $log
    ) {
        parent::__construct($log);
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

            return new JsonModel($params);
        } catch (ApplicationException $ex) {
            return $this->processApplicationError($ex);
        } catch (InvalidArgumentException $ex) {
            return $this->processApplicationError($ex);
        } catch (\Exception $ex) {
            return $this->processUnexpectedError($ex);
        }
    }
}