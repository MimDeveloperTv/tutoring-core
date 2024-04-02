<?php

namespace App\Traits;
use App\Models\Error;
use App\Models\ErrorMessage;

trait ErrorBag
{
    private array $errors;
    public function errors() : array
    {
        return $this->errors;
    }
    public function errors_push($error) : void
    {
        $this->errors[] = $error;
    }
    public function __destruct()
    {
        $route = request()->path();
        $error = Error::create([
            'route' => $route
        ]);
        foreach ($this->errors as $message)
        {
            $error->messages()->create([
                'message' => $message
            ]);
        }
    }
}
