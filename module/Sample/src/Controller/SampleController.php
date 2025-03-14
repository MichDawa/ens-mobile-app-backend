<?php

namespace Sample\Controller;

use Monolog\Logger;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use App\Library\Exception\ApplicationException;
use Assert\InvalidArgumentException;

class SampleController extends AbstractActionController {

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        Logger $logger,
    ) {
        $this->logger = $logger;
    }

    // public function sampleAction() {
    //     try {
    //         $text = $this->params()->fromQuery('text', '');
    //         $result = $this->appService->echoText($text);
            
    //         return new JsonModel([
    //             'status' => 'success',
    //             'data' => $result
    //         ]);
    //     } catch (\Exception $ex) {
    //         return new JsonModel([
    //             'status' => 'error',
    //             'message' => $ex->getMessage()
    //         ]);
    //     }
    // }

    public function sampleAction() {
        try {
            // $params = $this->getParams();
            
            // $forReturn = $params;
            $this->logger->info('Sample action called');
            return new JsonModel(["Hello World"]);
        } catch (ApplicationException $ex) {
            return $this->processApplicationError($ex);
        } catch (InvalidArgumentException $ex) {
            return $this->processApplicationError($ex);
        } catch (\Exception $ex) {
            return $this->processUnexpectedError($ex);
        }
    }
}