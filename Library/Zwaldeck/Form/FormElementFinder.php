<?php

namespace Zwaldeck\Form;
use Zwaldeck\Form\Element\AbstractElement;

/**
 * Class FormElementFinder
 *
 * @author Wout Schoovaerts
 * @package Zwaldeck\Form
 */
class FormElementFinder {

    /**
     * @var Form $form
     */
    private $form;

    /**
     * @param Form $form
     */
    public function __construct(Form $form) {
        if(!$form instanceof Form) {
            throw new \InvalidArgumentException("$form must be an instance of Zwaldeck\\Form\\Form");
        }

        $this->form = $form;
    }

    /**
     * @param $id
     * @return AbstractElement
     * @throws \ElementNotFoundException
     */
    public function findElementByID($id) {
        foreach($this->form->getElements() as $element) {
            /** @var AbstractElement $element */
            if(strtolower($id) == strtolower($element->getId())) {
                return $element;
            }
        }

        throw new \ElementNotFoundException("No element with id:\"{$id}\" is not found");
    }

    /**
     * @param $class
     * @return array
     * @throws \ElementNotFoundException
     */
    public function findElementsByClass($class) {
        $array = array();
        foreach($this->form->getElements() as $element) {
            /** @var AbstractElement $element */
            $classes = $element->getClasses();
            foreach($classes as $clss) {
                if(strtolower($clss) == strtolower($classes)) {
                    $array[] = $element;
                }
            }
        }

        if(empty($array)) {
            throw new \ElementNotFoundException("No element with class:\"{$class}\" is not found");
        }

        return $array;
    }
} 