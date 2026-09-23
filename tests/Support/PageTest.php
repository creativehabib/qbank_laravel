<?php

namespace Tests\Support;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Assert;
use ReflectionMethod;
use Throwable;

class PageTest
{
    protected object $controller;

    protected ?Throwable $exception = null;

    protected mixed $response = null;

    public static function actingAs(object $user): static
    {
        Auth::login($user);

        return new static;
    }

    public static function test(string $controller, array $parameters = []): static
    {
        $instance = new static;
        /** @var object $page */
        $page = app($controller);
        $instance->controller = $page;

        if (method_exists($page, 'mount')) {
            (new ReflectionMethod($page, 'mount'))->invokeArgs($page, array_values($parameters));
        }

        return $instance;
    }

    public function set(string $property, mixed $value): static
    {
        data_set($this->controller, $property, $value);

        return $this;
    }

    public function call(string $method, mixed ...$arguments): static
    {
        $this->exception = null;
        try {
            $this->response = $this->controller->{$method}(...$arguments);
        } catch (Throwable $exception) {
            $this->exception = $exception;
        }

        return $this;
    }

    public function assertSet(string $property, mixed $expected): static
    {
        Assert::assertEquals($expected, data_get($this->controller, $property));

        return $this;
    }

    public function assertHasErrors(string|array $fields = []): static
    {
        Assert::assertInstanceOf(ValidationException::class, $this->exception);
        $errors = $this->exception->errors();
        foreach ((array) $fields as $field) {
            Assert::assertArrayHasKey(is_int($field) ? $field : $field, $errors);
        }

        return $this;
    }

    public function assertHasNoErrors(): static
    {
        Assert::assertNotInstanceOf(ValidationException::class, $this->exception);

        return $this;
    }

    public function assertForbidden(): static
    {
        Assert::assertInstanceOf(AuthorizationException::class, $this->exception);

        return $this;
    }

    public function assertRedirect(string $location): static
    {
        Assert::assertNotNull($this->response);
        Assert::assertStringContainsString($location, $this->response->getTargetUrl());

        return $this;
    }

    public function assertSee(string|array $values): static
    {
        $html = $this->renderedHtml();
        foreach ((array) $values as $value) {
            Assert::assertStringContainsString((string) $value, $html);
        }

        return $this;
    }

    public function assertDontSee(string|array $values): static
    {
        $html = $this->renderedHtml();
        foreach ((array) $values as $value) {
            Assert::assertStringNotContainsString((string) $value, $html);
        }

        return $this;
    }

    protected function renderedHtml(): string
    {
        $view = $this->controller->render();

        return $view instanceof View ? $view->render() : (string) $view;
    }
}
