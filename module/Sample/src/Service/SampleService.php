<?php

namespace Sample\Service;

use Library\Infrastructure\Validation\ValidatorUtility;
use Sample\Infra\Repository\SampleRepository;
use Sample\Infra\Entity\SampleEntity;
use Library\Utils\BaseService;

class SampleService extends BaseService {

    /**
     * @var SampleRepository
     */
    private $sampleRepository;

    public function __construct(
        SampleRepository $sampleRepository,
    ) {
        $this->sampleRepository = $sampleRepository;
    }

    public function testAdd($params) {
        $this->sampleRepository->beginTransaction();
        try {
            $validator = new ValidatorUtility();
            $validator->addStringValidator('value', false, 'value is invalid');
            $validator->validateAndThrow($params);

            $value = $validator->getValue('value');

            $sampleString = new SampleEntity();
            $sampleString->setSampleString($value);

            $this->sampleRepository->persist($sampleString);
            $this->sampleRepository->flush();
            $this->sampleRepository->commit();
            $this->sampleRepository->clearCache();
        } catch (\Exception $err) {
            $this->sampleRepository->rollbackAndClose();
            $this->getLogger()->error("Unexpected error occurred.", ["message" => $err->getMessage(), "ex" => $err->getTraceAsString()]);
            throw $err;
        }
    }


}   

