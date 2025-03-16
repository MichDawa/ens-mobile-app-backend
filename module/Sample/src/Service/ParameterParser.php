<?php

    namespace Sample\Service;

    use Laminas\Mvc\Controller\AbstractController;
    use InvalidArgumentException;
    use Laminas\View\Model\JsonModel;
    use Laminas\Mvc\Controller\AbstractActionController;

    class ParameterParser extends AbstractActionController {
        public function getParams(AbstractController $controller): array {
            $params = array_merge(
                $controller->params()->fromRoute(),
                $controller->params()->fromQuery(),
                $controller->params()->fromPost()
            );

            unset($params['controller'], $params['action']);

            $request = $controller->getRequest();
            $contentType = $request->getHeaders()->get('Content-Type');

            if ($contentType && $contentType->getMediaType() === 'application/json') {
                $content = $request->getContent();
                $jsonParams = json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new InvalidArgumentException('Invalid JSON payload');
                }

                $params = array_merge($params, (array)$jsonParams);
            }

            return $params;
        }

        public function processApplicationError(\Exception $ex) {
            return new JsonModel([
                'error' => 'Application Error',
                'message' => $ex->getMessage(),
                'code' => $ex->getCode()
            ]);
        }

        public function processUnexpectedError(\Exception $ex) {
            return new JsonModel([
                'error' => 'Unexpected Error',
                'message' => $ex->getMessage(),
                'code' => 500
            ]);
        }
    }