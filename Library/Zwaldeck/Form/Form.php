<?php

namespace Zwaldeck\Form;

use Zwaldeck\Form\Element\AbstractElement;

class Form
{
    /**
     * cant be changed
     * @var unknown
     */
    private $id;

    /**
     * all the css classes
     * @var array
     */
    protected $classes;

    /**
     * constains all the elements of the form
     * key = id of element(MUST BE UNIQUE)
     * value = \Zwaldeck\Form\Element\AbstractElement
     *
     * @var array
     */
    private $elements;

    /**
     * form attributes
     *
     * @var array
     */
    private $attr;

    /**
     * render a fieldset or not
     *
     * @var boolean
     */
    private $fieldset;

    /**
     * Fieldset attributes
     * key = attr name
     * value = attr value
     *
     * @var array
     */
    private $fieldsetAtrr;

    /**
     * render a legend or not
     *
     * @var string
     */
    private $legend;

    /**
     * Fieldset attributes
     * key = attr n1ame
     * value = attr value
     *
     * @var array
     */
    private $legendAtrr;

    /**
     * The method
     *
     * @var string
     */
    private $method;

    /**
     * action url
     *
     * @var string
     */
    private $action;

    /**
     * enctype attribute
     * @var string
     */
    private $enctype;

    /**
     * @var array
     */
    private $errorMsg;

    /**
     * allowed methods
     *
     * @var array
     */
    public static $allowedMethods = array(
        'GET',
        'POST'
    );

    /**
     * allowed enctype
     *
     * @var array
     */
    public static $allowedEnctypes = array(
        "application/x-www-form-urlencoded",
        "multipart/form-data",
        "text/plain"
    );

    /**
     *
     * @param string $method
     * @param string $enctype
     * @param string $action
     * @param array $attr
     * @throws \InvalidArgumentException
     */
    public function __construct($id, $method = 'GET', $enctype = 'text/plain', $action = '', array $attr = array())
    {
        if (!is_string($id) || trim($id) == "") {
            throw new \InvalidArgumentException('$id must be a valid string and not be empty');
        }

        if (!in_array(strtoupper($method), self::$allowedMethods)) {
            throw new \InvalidArgumentException ('Method must be GET or POST');
        }

        if (!in_array(strtolower($enctype), self::$allowedEnctypes)) {
            throw new \InvalidArgumentException ('enctype must be a valid type check Form::$allowedEnctypes array');
        }

        $this->id = trim($id);
        $this->method = $method;
        $this->action = $action;
        $this->attr = $attr;

        $this->elements = array();
        $this->fieldset = false;
        $this->fieldsetAtrr = array();
        $this->legend = "";
        $this->legendAtrr = array();
        $this->classes = array();
        $this->errorMsg = array();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $classes
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @param string $classes
     * @throws \InvalidArgumentException
     */
    public function setClasses($classes)
    {
        if (!is_string($classes) || trim($classes) == "") {
            throw new \InvalidArgumentException('$classes must be a string and not empty');
        }
        $this->classes = $classes;
    }

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     */
    public function addClass($name)
    {
        if (!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a string and not empty');
        }

        $this->classes[] = $name;
    }

    /*
     * begin elements functions
     */

    /**
     * Add element to the stack
     *
     * @param AbstractElement $element
     */
    public function addElement(AbstractElement $element)
    {
        if (key_exists($element->getId(), $this->elements)) {
            throw new \Exception('Id must be unique.');
        }

        $this->elements[$element->getId()] = $element;
    }

    /**
     * will skip the elementes that are not an istnace of AbstractElement
     * @param array $elements
     */
    public function addElements(array $elements)
    {
        foreach ($elements as $element) {
            if ($element instanceof AbstractElement)
                $this->elements[$element->getId()] = $element;
        }
    }

    /**
     * Checks if key exists and if it exist it removes that element
     * @param string $id
     * @return boolean -->check if removed
     */
    public function removeElement($id)
    {
        if (key_exists($id, $this->elements)) {
            unset($this->elements[$id]);
            return true;
        }

        return false;
    }

    /**
     * returns all the elements
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function getElement($id)
    {
        if (key_exists($id, $this->elements)) {
            throw new \Exception('Id must be in the elements array.');
        }

        return $this->elements[$id];
    }

    /*
     * end elemetns functions
     */

    /**
     * @return the $attr
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * @param string $attr
     * @throws \InvalidArgumentException
     */
    public function setAttr($attr)
    {
        if (!is_string($attr) || trim($attr) == "") {
            throw new \InvalidArgumentException('$attr must be a string and not empty');
        }
        $this->attr = $attr;
    }

    /**
     * if key exists it overrides
     *
     * @param string $name
     * @param string $value
     * @throws \InvalidArgumentException
     */
    public function addAttribute($name, $value)
    {

        if (!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a string and not empty');
        }

        if (!is_string($value) || trim($value) == "") {
            throw new \InvalidArgumentException('$value must be a string and not empty');
        }

        $this->attr[$name] = $value;
    }

    /**
     * @return boolean
     */
    public function isFieldset()
    {
        return $this->fieldset;
    }

    /**
     * @param boolean $fieldset
     * @throws \InvalidArgumentException
     */
    public function setFieldset($fieldset)
    {
        if (!is_bool($fieldset)) {
            throw new \InvalidArgumentException('$fieldset must be true or false');
        }

        $this->fieldset = $fieldset;
    }

    /**
     * @return the $attr
     */
    public function getFieldsetAttr()
    {
        return $this->attr;
    }

    /**
     * @param array $attrs
     * @throws \InvalidArgumentException
     */
    public function setFieldsetAttr(array $attrs)
    {
        if (!is_array($attrs)) {
            throw new \InvalidArgumentException('$attrs must be an array');
        }
        $this->fieldsetAtrr = $attrs;
    }

    /**
     * if key exists it overrides
     *
     * @param string $name
     * @param string $value
     * @throws \InvalidArgumentException
     */
    public function addFieldsetAttribute($name, $value)
    {

        if (!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a string and not empty');
        }

        if (!is_string($value) || trim($value) == "") {
            throw new \InvalidArgumentException('$value must be a string and not empty');
        }

        $this->fieldsetAtrr[$name] = $value;
    }

    /**
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * @param string $fieldset
     * @throws \InvalidArgumentException
     */
    public function setLegend($legend)
    {
        if (!is_string($legend)) {
            throw new \InvalidArgumentException('$legend must be true or false');
        }

        $this->legend = trim($legend);
    }

    /**
     * @return the $attr
     */
    public function getLegendAttr()
    {
        return $this->attr;
    }

    /**
     * @param string $attr
     * @throws \InvalidArgumentException
     */
    public function setLegendAttr($attr)
    {
        if (!is_string($attr) || trim($attr) == "") {
            throw new \InvalidArgumentException('$attr must be a string and not empty');
        }
        $this->legendAtrr = $attr;
    }

    /**
     * if key exists it overrides
     *
     * @param string $name
     * @param string $value
     * @throws \InvalidArgumentException
     */
    public function addLegendAttribute($name, $value)
    {

        if (!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a string and not empty');
        }

        if (!is_string($value) || trim($value) == "") {
            throw new \InvalidArgumentException('$value must be a string and not empty');
        }

        $this->legendAtrr[$name] = $value;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @throws \InvalidArgumentException
     */
    public function setMethod($method)
    {
        if (!in_array(strtoupper($method), self::$allowedMethods)) {
            throw new \InvalidArgumentException ('Method must be GET or POST');
        }

        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @throws \InvalidArgumentException
     */
    public function setAction($action)
    {
        if (!is_string($action)) {
            throw new \InvalidArgumentException('$action must be a valid string');
        }

        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getEnctype()
    {
        return $this->enctype;
    }

    /**
     * @param string $enctype
     * @throws \InvalidArgumentException
     */
    public function setEnctype($enctype)
    {
        if (!in_array(strtolower($enctype), self::$allowedEnctypes)) {
            throw new \InvalidArgumentException ('$enctype must be a valid type check Form::$allowedEnctypes array');
        }

        $this->enctype = $enctype;
    }

    /**
     * @return array
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * ASSOC array $key = field-id
     *             $value = error msg
     *
     * @param array $array
     * @throws \InvalidArgumentException
     */
    public function setErrorMsg(array $array)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException("$array must be an array");
        }

        $this->errorMsg = $array;
    }

    /**
     * @param string $fieldid
     * @param string $errormsg
     * @throws \InvalidArgumentException
     */
    public function addErrorMsg($fieldid, $errormsg)
    {
        if (!is_string($fieldid) || trim($fieldid) == "") {
            throw new \InvalidArgumentException('$fieldid must be a string and not empty');
        }

        if (!is_string($errormsg) || trim($errormsg) == "") {
            throw new \InvalidArgumentException('$errormsg must be a string and not empty');
        }

        $this->errorMsg[$fieldid] = $errormsg;
    }

    /**
     * renders the form
     */
    public function renderForm()
    {
        $form = "<form id=\"{$this->id}\" {$this->renderAttr($this->attr)} {$this->renderClasses()} action=\"{$this->action}\" method=\"{$this->method}\" enctype=\"{$this->enctype}\">";

        if ($this->fieldset) {
            $form .= "<fieldset {$this->renderAttr($this->fieldsetAtrr)}>";
            if ($this->legend != "") {
                $form .= "<legend {$this->renderAttr($this->legendAtrr)}>{$this->legend}</legend>";
            }
        }

        $form .= $this->renderErrors();
        foreach ($this->elements as $element) {
            if ($element->getLabel() !== null) {
                $form .= $element->getLabel()->render() . ' ';
            }
            $form .= $element->render() . "<br />";
        }

        if ($this->fieldset) {
            $form .= "</fieldset>";
        }

        $form .= "</form>";
        return $form;
    }


    /**
     * element defined by placeholder,
     * if plcacehodlder is empty,
     *                    label,
     * if label is empty,
     *                   name
     *
     * @return string
     */
    public function renderErrors()
    {
        $finder = new FormElementFinder($this);
        $errors = $this->getErrorMsg();

        $buffer = "";
        if (count($errors) > 0) {
            $buffer .= "<fieldset><legend>Errors</legend><ul>";
            foreach ($errors as $id => $error) {
                $elem = $finder->findElementByID($id);
                $name = "";
                if(method_exists($elem, 'getPlaceholder')) {
                    $name = trim($elem->getPlaceholder());
                }
                if($name == "") {
                    $name = trim($elem->getLabel()->getText());
                    if($name == "") {
                        $name = trim($elem->getId());
                    }
                }

                $buffer .= "<li>{$name} {$error}</li>";
            }
            $buffer .= "</ul></fieldset>";
        }
        return $buffer;
    }


    public function isValid()
    {
        if ($this->elements == null) {
            return true;
        }

        $valid = true;
        foreach ($this->elements as $elem) {
            /** @var AbstractElement $elem */
            if (count($elem->getValidators()) > 0) {
                $validateMsg = trim($elem->validate());
                if ( $validateMsg != "") {
                    $this->addErrorMsg($elem->getId(), $validateMsg);
                    $valid = false;
                }
            }
        }

        return $valid;

    }

    /**
     * @param array $attrArray
     * @return string
     */
    protected function renderAttr(array $attrArray)
    {
        $attr = "";
        foreach ($attrArray as $name => $value) {
            $attr .= $name . "=\"{$value}\" ";
        }
        $attr = rtrim($attr);

        return $attr;
    }

    /**
     * Renders the class atrribute
     * @return string
     */
    protected function renderClasses()
    {
        $class = "class=\"";
        foreach ($this->classes as $className) {
            $class .= $className . " ";
        }
        $class = rtrim($class) . "\"";

        return $class;
    }
}

?>