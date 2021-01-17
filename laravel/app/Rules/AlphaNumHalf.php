<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordComplexity implements Rule
{
    protected $minDigits;
    protected $maxDigits;
    protected $includeLessThanOneUpperLetter;
    protected $includeLessThanOneLowerLetter;
    protected $includeLessThanOneNumber;
    protected $includeLessThanOneSymbol;
    protected $includeSymbol;

    /**
     * Create a new rule instance.
     *
     * @param int $minDigits
     * @param null $maxDigits
     * @param bool $includeSymbol
     * @param bool $includeLessThanOneUpperLetter
     * @param bool $includeLessThanOneLowerLetter
     * @param bool $includeLessThanOneNumber
     * @param bool $includeLessThanOneSymbol
     */
    public function __construct(
        $minDigits = 8,
        $maxDigits = null,
        $includeSymbol = true,
        $includeLessThanOneUpperLetter = true,
        $includeLessThanOneLowerLetter = true,
        $includeLessThanOneNumber = true,
        $includeLessThanOneSymbol = true
    )
    {
        $this->minDigits = $minDigits;
        $this->maxDigits = $maxDigits;
        $this->includeLessThanOneUpperLetter = $includeLessThanOneUpperLetter;
        $this->includeLessThanOneLowerLetter = $includeLessThanOneLowerLetter;
        $this->includeLessThanOneNumber = $includeLessThanOneNumber;
        $this->includeLessThanOneSymbol = $includeLessThanOneSymbol;
        $this->includeSymbol = $includeSymbol;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $regex = '';
        if ($this->includeSymbol) {
            $regex = '[!-~]';
        } else {
            $regex = '[a-zA-Z\d]';
        }
        if ($this->includeLessThanOneLowerLetter) {
            $regex = "(?=.*?[a-z])" . $regex;
        }
        if ($this->includeLessThanOneUpperLetter) {
            $regex = "(?=.*?[A-Z])" . $regex;
        }
        if ($this->includeLessThanOneNumber) {
            $regex = "(?=.*?\d)" . $regex;
        }
        if ($this->includeLessThanOneNumber) {
            $regex = "(?=.*?[!-\/\:-@\[-`\{-~])" . $regex;
        }

        if ($this->maxDigits || $this->minDigits) {
            $regex = $regex . "{{$this->minDigits},{$this->maxDigits}}";
        }
        $regex = "/\A{$regex}+\z/";

        return preg_match($regex, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = 'パスワードは';
        $includeLessThanOneLetters = [];
        if ($this->includeLessThanOneLowerLetter) {
            $includeLessThanOneLetters[] = "半角英字（小文字）";
        }
        if ($this->includeLessThanOneUpperLetter) {
            $includeLessThanOneLetters[] = "半角英字（大文字）";
        }
        if ($this->includeLessThanOneNumber) {
            $includeLessThanOneLetters[] = "半角数字";
        }
        if ($this->includeLessThanOneSymbol) {
            $includeLessThanOneLetters[] = "半角記号";
        }
        if ($includeLessThanOneLetters) {
            $message .= implode('、', $includeLessThanOneLetters) . "を1文字以上含む";
        }
        if ($this->includeSymbol) {
            $message .= "半角英数字記号";
        } else {
            $message .= "半角英数字";
        }
        if ($this->minDigits) {
            $message .= "{$this->minDigits}文字以上";
        }
        if ($this->maxDigits) {
            $message .= "{$this->maxDigits}文字以下";
        }
        $message .= "で入力してください。";

        return $message;
    }
}
