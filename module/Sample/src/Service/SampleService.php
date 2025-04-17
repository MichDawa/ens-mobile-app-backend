<?php

namespace Sample\Service;

use Library\Infrastructure\Validation\ValidatorUtility;
use Library\Utils\BaseService;

class SampleService extends BaseService {
    public function __construct(
    ) {
    }
    
    public function testString($params) {
        $validator = new ValidatorUtility();
        $validator->addStringValidator('value', false, 'value is invalid');
        $validator->validateAndThrow($params);

        $value = $validator->getValue('value');

        return $value;
    }


}

