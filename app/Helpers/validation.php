<?php
namespace App\Helpers;

class Validator
{
    protected array $data;
    protected array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data): self
    {
        return new self($data);
    }

    public function required(string $field, string $message): self
    {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function email(string $field, string $message): self
    {
        if (!filter_var($this->data[$field] ?? '', FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function max(string $field, int $max, string $message): self
    {
        if (strlen($this->data[$field] ?? '') > $max) {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function numeric(string $field, string $message): self
    {
        if (!is_numeric($this->data[$field] ?? null)) {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function minValue(string $field, $min, string $message): self
    {
        if (($this->data[$field] ?? null) < $min) {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function maxValue(string $field, $max, string $message): self
    {
        if (($this->data[$field] ?? null) > $max) {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function date(string $field, string $message): self
    {
        if (!strtotime($this->data[$field] ?? '')) {
            $this->errors[$field][] = $message;
        }
        return $this;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
