<?php

namespace Application\Controllers;

use Zwaldeck\Controller\Controller;
use Zwaldeck\Form\Captcha\Captcha;
use Zwaldeck\Form\Captcha\ReCaptcha;
use Zwaldeck\Form\Element\Text\TextAreaElement;
use Zwaldeck\Form\Element\Helper\OptGroup;
use Zwaldeck\Form\Element\Helper\Option;
use Zwaldeck\Form\Element\SelectElement;
use Zwaldeck\Form\Element\FileElement;
use Zwaldeck\Form\Element\HiddenElement;
use Zwaldeck\Form\Element\SubmitElement;
use Zwaldeck\Form\Element\ResetElement;
use Zwaldeck\Form\Element\ButtonElement;
use Zwaldeck\Form\Element\RangeElement;
use Zwaldeck\Form\Element\NumberElement;
use Zwaldeck\Form\Element\ColorElement;
use Zwaldeck\Form\Element\DateElement;
use Zwaldeck\Form\Element\CheckBoxElement;
use Zwaldeck\Form\Element\RadioElement;
use Zwaldeck\Form\Element\Text\TextElement;
use Zwaldeck\Form\Label;
use Zwaldeck\Form\Form;
use Zwaldeck\Form\Validation\Validators;
use Zwaldeck\Registry\Registry;
use Zwaldeck\Util\Utils;

class IndexController extends Controller {
	
	public function indexAction() {
		$this->set('title', 'Zwaldeck loves you');


		
		$elem = new RadioElement('id', 'name', 'this is the text', false, false, false, false);
		$elem->addAttribute('attr', 'attr');
		//$elem->setRequired(true);
		$elem->addClass('class');
		//$elem->setDisabled(false);
		$elem->setValue('this is the value');
		//$elem->setReadonly(true);
		//$elem->setMaxlenght(800);
		//$elem->setPlaceholder('This is the placeholder');
		//$elem->setMultiple(true);
		
		$opt = new OptGroup(false, "label");
		$opt->addOption(new Option('first'));
		$opt->addOption(new Option('second', true));
		$opt->addOption(new Option('third', false, true));
		$opt->addOption(new Option('fourth', false, false, 'value'));
		
		$opt2 = new OptGroup(false, "label23222256");
		$opt2->addOption(new Option('first'));
		$opt2->addOption(new Option('second', true));
		$opt2->addOption(new Option('third', false, true));
		$opt2->addOption(new Option('fourth', false, false, 'value'));
		
		$sel = new SelectElement('select');
		$sel->addOptGroup($opt);
		$sel->addOptGroup($opt2);
		
		$textLabel = new Label('textLab', 'text', 'textElement');
		$text = new TextElement('text');
		$text->setSize(20);
		$text->setLabel($textLabel);
        $text->addValidator('reqText', array(
           'type' => Validators::Required,
           'field' => $text->getName(),
        ));
        $text->addValidator("regex", array(
           'type' => Validators::Regex,
           'field' => $text->getName(),
           'options' => array(
                'regex' => '^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z',
           ),
        ));


        $textLabel2 = new Label('textLab2', 'text2', 'textElement2');
        $text2 = new TextElement('text2');
        $text2->setSize(20);
        $text2->setLabel($textLabel2);
        $text2->addValidator('reqText', array(
            'type' => Validators::Required,
            'field' => $text2->getName(),
        ));
        $text2->addValidator("stringlen", array(
            'type' => Validators::StringLen,
            'field' => $text2->getName(),
            'options' => array(
                'min' => 3,
                'max' => 20,
            ),
        ));

        $submit = new SubmitElement("submit", "Verzend");
		$form = new Form('form');
		$form->setMethod('POST');
		$form->setFieldset(true);
		$form->setLegend('legend text');
		$form->addElement($elem);
		$form->addElement($sel);
		$form->addElement($text);
        $form->addElement($text2);
        $form->addElement($submit);

        $request = $this->getRequest();
        if($request->isPost()) {
            if($form->isValid()) {
                echo "VALID";
            }
        }

        $this->set('form', $form);
	}
}

?>