<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RSS implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        try {
            $stream = simplexml_load_file($value);
            if ((string) $stream->attributes() == "2.0"){
                return true;
            }
            return false;
        }
        catch (\Exception $exception){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The url specified is not a valid RSS 2.0 xml feed.';
    }
}
