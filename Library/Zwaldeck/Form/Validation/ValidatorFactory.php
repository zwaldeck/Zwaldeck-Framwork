<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class ValidatorFactory
 * @author Wout Schoovaerts
 * @package Zwaldeck\Form
 */
class ValidatorFactory {

    /**
     * @param array $arr
     * @return null|RequiredValidator|StringLengthValidator
     * @throws \Exception
     */
    public static function createValidator(array $arr) {
        $validator = null;
            self::errorCheck($arr);
            switch($arr['type']) {
                case Validators::Required:
                    $validator = new RequiredValidator($arr['field']);
                    break;
                case Validators::StringLen:
                    self::checkStringLenErrors($arr);
                    $options = $arr['options'];
                    $validator = new StringLengthValidator($arr['field'], $options['min'], $options['max']);
                    break;
                case Validators::Between:
                    self::checkBetweenErrors($arr);
                    $options = $arr['options'];
                    $validator = new BetweenValidator($arr['field'], $options['low'], $options['high']);
                    break;
                case Validators::Greather:
                    self::checkGreatherErrors($arr);
                    $options = $arr['options'];
                    $validator = new GreatherThanValidator($arr['field'], $options['number']);
                    break;
                case Validators::Lesser:
                    self::checkGreatherErrors($arr);
                    $options = $arr['options'];
                    $validator = new LessThanValidator($arr['field'], $options['number']);
                    break;
                case Validators::Regex:
                    self::checkRegexErrors($arr);
                    $options = $arr['options'];
                    $validator = new RegexValidator($arr['field'], $options['regex']);
                    break;
                case Validators::Number:
                    $validator = new NumberValidator($arr['field']);
                    break;
                case Validators::Email:
                    $validator = new EmailValidator($arr['field']);
                    break;
                default:
                    throw new \Exception("Zwaldeck framework does not know the type: {$arr['type']}");
            }
        return $validator;
    }

    /**
     * @param array $arr
     * @throws \InvalidArgumentException
     */
    private static function errorCheck(array $arr) {
        if(!array_key_exists('field',$arr)) {
            throw new \InvalidArgumentException("Array must contain field key");
        }

        if(!array_key_exists('type',$arr)) {
            throw new \InvalidArgumentException("Array must contain type key");
        }
    }

    /**
     * @param array $arr
     * @throws \InvalidArgumentException
     */
    private static function checkStringLenErrors(array $arr) {
        if(!array_key_exists('options',$arr)) {
            throw new \InvalidArgumentException("Array must contain options key");
        }

        $tempArr = $arr['options'];

        if(!is_array($tempArr)) {
            throw new \InvalidArgumentException("Options must contain an array");
        }

        if(!array_key_exists('min',$tempArr)) {
            throw new \InvalidArgumentException("Options must contain min key");
        }

        if(!array_key_exists('max',$tempArr)) {
            throw new \InvalidArgumentException("Options must contain max key");
        }

        if(!is_integer($tempArr['min'])) {
            throw new \InvalidArgumentException("Options[min] must contain an integer");
        }

        if(!is_integer($tempArr['max'])) {
            throw new \InvalidArgumentException("Options[max] must contain an integer");
        }
    }

    /**
     * @param array $arr
     * @throws \InvalidArgumentException
     */
    private static function checkBetweenErrors(array $arr) {
        if(!array_key_exists('options',$arr)) {
            throw new \InvalidArgumentException("Array must contain options key");
        }

        $tempArr = $arr['options'];

        if(!is_array($tempArr)) {
            throw new \InvalidArgumentException("Options must contain an array");
        }

        if(!array_key_exists('low',$tempArr)) {
            throw new \InvalidArgumentException("Options must contain low key");
        }

        if(!array_key_exists('high',$tempArr)) {
            throw new \InvalidArgumentException("Options must contain high key");
        }

        if(!is_integer($tempArr['low'])) {
            throw new \InvalidArgumentException("Options[low] must contain an integer");
        }

        if(!is_integer($tempArr['high'])) {
            throw new \InvalidArgumentException("Options[high] must contain an integer");
        }
    }

    /**
     * @param array $arr
     * @throws \InvalidArgumentException
     */
    private static function checkGreatherErrors(array $arr) {
        if(!array_key_exists('options',$arr)) {
            throw new \InvalidArgumentException("Array must contain options key");
        }

        $tempArr = $arr['options'];

        if(!is_array($tempArr)) {
            throw new \InvalidArgumentException("Options must contain an array");
        }

        if(!array_key_exists('number',$tempArr)) {
            throw new \InvalidArgumentException("number must contain low key");
        }

        if(!is_integer($tempArr['number'])) {
            throw new \InvalidArgumentException("Options[number] must contain an integer");
        }
    }

    /**
     * @param array $arr
     * @throws \InvalidArgumentException
     */
    private static function checkRegexErrors(array $arr) {
        if(!array_key_exists('options',$arr)) {
            throw new \InvalidArgumentException("Array must contain options key");
        }

        $tempArr = $arr['options'];

        if(!is_array($tempArr)) {
            throw new \InvalidArgumentException("Options must contain an array");
        }

        if(!array_key_exists('regex',$tempArr)) {
            throw new \InvalidArgumentException("regex must contain low key");
        }

        if(!is_string($tempArr['regex']) || trim($tempArr['regex']) == "") {
            throw new \InvalidArgumentException("Options[regex] must be a valid string and may not be empty");
        }
    }
} 