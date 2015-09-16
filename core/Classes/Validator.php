<?php namespace App\Classes;

use App\Classes\Error;

class Validator extends Error {

    /**
     * Store the fields
     *
     * @var array
     */
    private static $fields = []; 

    /**
     * Store the rules
     *
     * @var array
     */
    private static $rules = [];

    /**
     * Store the renamed attributes
     *
     * @var array
     */
    private static $renamed = [];

    /**
     * Store errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * Store error messages
     *
     * @var array
     */
    private static $messages = [
        'required'  => 'The :attribute is required',
        'min'       => 'The :attribute must be at least %s characters long',
        'max'       => 'The :attribute cannot be longer than %s characters',
        'same'      => 'The :attribute and :other must match',
        'unique'    => 'The :attribute already exists',
        'alnum'     => 'The :attribute can only contains letters and numbers',
        'email'     => 'The :attribute is not a valid E-Mail address',
        'alpha'     => 'The :attribute can only contain alphabetic characters.',
        'gender'    => 'The :attribute is not a valid gender.',
        'vocation'  => 'The :attribute is not a valid vocation.',
        'town'      => 'The :attribute is not a valid town.',
        'charname'  => 'The :attribute is not a valid character name',
        'maxwords'  => 'The :attribute can only contains a maximum of :max words',

        // Rules below should be validaten against a PLAYER_ID single field
        'charowner' => 'You do not own selected character',
        'charexist' => 'Selected character do not exists',
        'noguild'   => 'Selected character is already in a guild.',
        'minlevel'  => 'Selected character is to low level.',
    ];

    /**
     * Construct the class
     *
     * @param array $fields
     * @return void
     */
    public function __construct($fields = null)
    {
        if (! is_null($fields)) {
            $this->setFields($fields);
        }
    }

    /**
     * Bind the fields to class
     *
     * @return void
     */
    public function setFields(array $fields)
    {
        self::$fields = $fields;
    }

    /**
     * Bind custom / overwrite messages
     *
     * @return void
     */
    public static function setMessages(array $messages)
    {
        array_walk($messages, function ($value, $key) {
            static::$messages[$key] = $value;
        });
    }

    /**
     * Store fields to rename and new name
     *
     * @return void
     */
    public static function renamed($renamed)
    {
        static::$renamed = $renamed;
    }

    /**
     * Parse rule
     *
     * @return array
     */
    protected function parse($rule)
    {
        if (! preg_match('/:/i', $rule)) return $rule;
    }

    /**
     * Validate the fields
     *
     * @return boolean
     */
    protected function validate()
    {
        if (! $this->hasInput()) {
            return null;
        }

        array_walk(static::$fields, function ($rules, $field) {
            $this->validateField($field, $rules);
        });
        
        return ! (boolean) count($this->errors); 
    }

    protected function validateField($field, $rules)
    {
        $rules = $this->parseRules((array) $rules);
        $input = isset($_POST[$field]) ? $_POST[$field] : null;

        array_walk($rules, function ($rule) use ($field, $input) {
            if (! isset($this->errors[$field])) {
                list($rule, $parameters) = array_values($rule);
                
                $callback = static::$rules[$rule];

                if (! $callback($field, $input, $parameters)) {
                    return $this->addError($field, $rule, $parameters);
                }
            }
        });
    }

    protected function parseRules(array $rules)
    {
        array_walk($rules, function (&$rule) {
            list($name, $parameters) = array_pad(explode(':', $rule), 2, null);

            $parameters = (array) explode(',', $parameters);

            $rule = [
                'rule'       => $name,
                'parameters' => $parameters,
            ];
        });

        return $rules;
    }

    /**
     * Determinate if the fields fails the validation or not
     *
     * @return boolean
     */
    public function fails()
    {
        $validation = $this->validate();

        return is_null($validation) ? false : ! $validation;
    }

    /**
     * Add error
     *
     * @return void
     */
    public function addError($attribute, $rule, $parameters)
    {
        $this->errors[$attribute][$rule] = $parameters;
    }

    /**
     * Get value(s)
     *
     * @return string|integer
     */
    public function value($attribute = null)
    {
        return (is_null($attribute)) ? $_POST : $_POST[$attribute];
    }

    /**
     * Get all the errors
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = [];

        foreach ($this->errors as $attribute => $rules) {
            foreach ($rules as $rule => $parameters) {
                $attribute_re = (isset(static::$renamed[$attribute])) ? static::$renamed[$attribute] : $attribute;

                $errors[$attribute][$rule] = vsprintf($this->rename($attribute_re, $rule, $parameters), $parameters);
            }
        }

        return $errors;
    }

    /**
     * Get the messages
     *
     * @return array
     */
    public function getMessages()
    {
        return static::$messages;
    }

    /**
     * Extend the rules
     *
     * @return void
     */
    public static function extend($rule, $callback)
    {
        static::$rules[$rule] = $callback;
    }

    /**
     * Rename the attributes
     *
     * @return void
     */
    public function rename($attribute, $rule, $parameters)
    {
        $replace = [
            '/:attribute/i' => $attribute,
            '/:other|:max/i' => (!empty($parameters)) ? (isset(static::$renamed[$parameters[0]])) ? static::$renamed[$parameters[0]] : $parameters[0] : '',
        ];

        return preg_replace(array_keys($replace), array_values($replace), static::$messages[$rule]);
    }

    /**
     * Determinate if validation passes
     *
     * @return boolean
     */
    public function passes()
    {
        $validation = $this->validate();

        return is_null($validation) ? false : $validation;
    }

    /**
     * Check if fields has input
     *
     * @return boolean
     */
    public function hasInput()
    {
        return ! empty($_POST);
    }

    /**
     * Check if attribute has error
     *
     * @return boolean
     */
    public function hasError($attribute)
    {
        return isset($this->errors[$attribute]);
    }

    /**
     * Get attribute error
     *
     * @return string
     */
    public function getError($attribute)
    {
        return head($this->getErrors()[$attribute]);
    }

}