<?php

namespace Library\Infrastructure\Validation;

use Library\Utils\ApplicationFlags;
use Library\Exception\ApplicationException;
use Library\Utils\AppDate;
use Carbon\Carbon;
use Laminas\InputFilter\Input;

class ValidatorUtility {

    private $_filter = null;

    /**
     * @return \Laminas\InputFilter\InputFilter
     */
    private function getFilter() {
        if ($this->_filter === null) {
            $filter = new \Laminas\InputFilter\InputFilter;
            $this->_filter = $filter;
        }
        return $this->_filter;
    }

    private static function getErrorMessage(\Laminas\InputFilter\InputFilter $filter) {
        $message = "";
        foreach ($filter->getInvalidInput() as $field => $error) {
            foreach ($error->getMessages() as $message) {
                $message = str_replace('Value', ucfirst($field), $message);
                break;
            }
        }
        return $message;
    }

    public function getValue($name) {
        return $this->getFilter()->getValue($name);
    }

    public function getInt($name) {
        return (int) $this->getFilter()->getValue($name);
    }

    public function getIntToBoolean($name) {
        return ((int) $this->getValue($name) === ApplicationFlags::YES);
    }
    
    public function getAsFloat(string $name): float {
        return (float) $this->getValue($name);
    }

    /**
     * @param $name
     * @return Carbon|null
     */
    public function getAsDate($name) {
        $filter = $this->getFilter();
        $dateString = $filter->getValue($name);
        if (!empty($dateString)) {
            return Carbon::createFromFormat(AppDate::ISO8601_DATE, $dateString);
        } else {
            return null;
        }
    }

    /**
     * @param $name
     * @return Carbon|null
     */
    public function getAsDateTime($name) {
        $filter = $this->getFilter();
        $dateString = $filter->getValue($name);
        if ($dateString !== null && !empty($dateString)) {
            return Carbon::createFromFormat(AppDate::ISO8601_DATETIME, $dateString);
        } else {
            return null;
        }
    }

    public function validateAndThrow($params) {
        $filter = $this->getFilter();
        $filter->setData($params);
        if (!$filter->isValid()) {
            $message = self::getErrorMessage($filter);
            throw new ApplicationException($message);
        }
    }

    public function validateAndReturnResult($params): ValidationResult {
        $filter = $this->getFilter();
        $filter->setData($params);
        $isValid = $filter->isValid();
        $message = $isValid ? null : self::getErrorMessage($filter);
        $result = new ValidationResult($isValid, $message);
        return $result;
    }

    public function addRequiredParameter($name, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired(true);

        $filter = $this->getFilter();
        $filter->add($input);
        return $this;
    }

    public function addStringValidator($name, $isRequired, $message = null, $stringLength = 100) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim");
        if ($stringLength !== -1) {
            $input->getValidatorChain()
                ->attachByName("StringLength", [
                    'encoding' => 'UTF-8',
                    'min' => 1,
                    'max' => $stringLength,
            ]);
        }


        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addAlphaNumericOnlyValidator($name, $isRequired, $message = null, $stringLength = 100, $allowWhiteSpace = true) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim");
        $input->getValidatorChain()
            ->attachByName("Laminas\I18n\Validator\Alnum", ['allowWhiteSpace' => $allowWhiteSpace])
            ->attachByName("StringLength", [
                'encoding' => 'UTF-8',
                'min' => 1,
                'max' => $stringLength,
        ]);

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addGUIDValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim");
        $input->getValidatorChain()
            ->attachByName("StringLength", [
                'encoding' => 'UTF-8',
                'min' => 1,
                'max' => 50,
        ]);

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addObjectValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addFloatValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim");
        $input->getValidatorChain()
            ->attachByName("IsFloat");

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addIntValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("Digits");
        $input->getValidatorChain()
            ->attachByName("IsInt");

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addEmailValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim")
            ->attachByName("StripNewlines");
        $input->getValidatorChain()
            ->attachByName("EmailAddress");

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addDateISOValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim")
            ->attachByName("StripNewlines");
        $input->getValidatorChain()
            ->attachByName("Date", [
                'format' => AppDate::ISO8601_DATE
        ]);

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addDateTimeISOValidator($name, $isRequired, $message = null) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired($isRequired);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim")
            ->attachByName("StripNewlines");
        $input->getValidatorChain()
            ->attachByName("Date", [
                'format' => AppDate::ISO8601_DATETIME
        ]);

        if ($isRequired) {
            $input->getValidatorChain()
                ->attachByName("NotEmpty");
        }

        $filter = $this->getFilter();
        $filter->add($input);
    }

    public function addPhilMobileValidator($name, $isRequired, $message) {
        $this->addStringValidator($name, $isRequired, $message, 15);
    }

    public function addUsernameValidator($name, $message = null, $stringLength = 100) {
        $input = new Input($name);
        $input->setBreakOnFailure(true);
        $input->setErrorMessage($message);
        $input->setRequired(true);
        $input->getFilterChain()
            ->attachByName("StripTags")
            ->attachByName("StringTrim");
        $input->getValidatorChain()
            ->attachByName("NotEmpty");
        if ($stringLength !== -1) {
            $input->getValidatorChain()
                ->attachByName("StringLength", [
                    'encoding' => 'UTF-8',
                    'min' => 1,
                    'max' => $stringLength,
            ]);
        }
        $input->getValidatorChain()
            ->attachByName("Regex", [
                'pattern' => '/^[A-Za-z0-9_.-]*$/'
        ]);


        $filter = $this->getFilter();
        $filter->add($input);
    }

}
