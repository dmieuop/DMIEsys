<?php

namespace App\Actions\Fortify;

use Axiom\Rules\StrongPassword;
use Axiom\Rules\WithoutWhitespace;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules(): array
    {
        return ['bail', 'required', 'confirmed', 'different:email', new WithoutWhitespace, 'different:username', new StrongPassword, 'unique:users,username'];
    }
}
