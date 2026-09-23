<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\ValidationException;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionObject;

abstract class PageController extends Controller
{
    protected Request $request;

    protected RedirectResponse|Redirector|null $pendingResponse = null;

    /** @var array<string, string> */
    protected array $pageErrors = [];

    public function __invoke(Request $request): View|RedirectResponse|Redirector
    {
        $this->request = $request;
        Paginator::currentPageResolver(fn (): int => max(1, (int) ($request->input('page', $this->page ?? 1))));
        $this->mountFromRoute($request);
        $this->hydrateFromRequest($request);

        if ($request->isMethod('post')) {
            $this->runAction($request);
        }

        if ($this->pendingResponse !== null) {
            return $this->pendingResponse;
        }

        ViewFacade::share('pageState', $this->publicState());

        return $this->render();
    }

    protected function mountFromRoute(Request $request): void
    {
        if (! method_exists($this, 'mount')) {
            return;
        }

        $method = new ReflectionMethod($this, 'mount');
        $routeParameters = $request->route()?->parameters() ?? [];
        $arguments = [];

        foreach ($method->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type instanceof ReflectionNamedType && $type->getName() === Request::class) {
                $arguments[] = $request;
                continue;
            }

            $arguments[] = $routeParameters[$parameter->getName()]
                ?? array_shift($routeParameters)
                ?? ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null);
        }

        $response = $method->invokeArgs($this, $arguments);

        if ($response instanceof RedirectResponse || $response instanceof Redirector) {
            $this->pendingResponse = $response;
        }
    }

    protected function hydrateFromRequest(Request $request): void
    {
        $reflection = new ReflectionObject($this);
        $values = array_replace_recursive($request->except(['_token', '_action', '_arguments']), $request->allFiles());

        foreach ($values as $name => $value) {
            if (! $reflection->hasProperty($name)) {
                continue;
            }

            $property = $reflection->getProperty($name);

            if (! $property->isPublic() || $property->isStatic()) {
                continue;
            }

            $type = $property->getType();
            if ($type instanceof ReflectionNamedType && $type->isBuiltin()) {
                $value = match ($type->getName()) {
                    'bool' => filter_var($value, FILTER_VALIDATE_BOOL),
                    'int' => (int) $value,
                    'float' => (float) $value,
                    'string' => (string) $value,
                    'array' => Arr::wrap($value),
                    default => $value,
                };
            }

            $property->setValue($this, $value);
        }
    }

    protected function runAction(Request $request): void
    {
        $action = (string) $request->input('_action', '');

        $arguments = json_decode((string) $request->input('_arguments', '[]'), true);
        $arguments = is_array($arguments) ? $arguments : [];

        if ($action === '$set') {
            $property = (string) ($arguments[0] ?? '');
            if ($property !== '' && property_exists($this, $property)) {
                data_set($this, $property, $arguments[1] ?? null);
            }

            return;
        }

        if ($action === '$refresh') {
            return;
        }

        abort_unless($action !== '' && method_exists($this, $action) && ! str_starts_with($action, '__'), 404);

        $response = $this->{$action}(...$arguments);

        if ($response instanceof RedirectResponse || $response instanceof Redirector) {
            $this->pendingResponse = $response;
        }
    }

    /** @param array<string, mixed> $rules */
    public function validate(array $rules, array $messages = [], array $attributes = []): array
    {
        $data = [];
        foreach (array_keys($rules) as $key) {
            $data[$key] = data_get(get_object_vars($this), $key);
        }

        return Validator::make($data, $rules, $messages, $attributes)->validate();
    }

    /** @param array<string, mixed> $rules */
    public function validateOnly(string $field, array $rules = []): void
    {
        $selectedRules = $rules !== [] ? $rules : Arr::only(method_exists($this, 'rules') ? $this->rules() : [], [$field]);
        Validator::make([$field => data_get(get_object_vars($this), $field)], $selectedRules)->validate();
    }

    public function addError(string $key, string $message): void
    {
        $this->pageErrors[$key] = $message;
        throw ValidationException::withMessages([$key => $message]);
    }

    public function reset(string|array ...$properties): void
    {
        foreach (Arr::flatten($properties) as $property) {
            if (property_exists($this, $property)) {
                $reflection = new \ReflectionProperty($this, $property);
                $this->{$property} = $reflection->hasDefaultValue() ? $reflection->getDefaultValue() : null;
            }
        }
    }

    public function resetValidation(?string $field = null): void
    {
        $this->pageErrors = $field === null ? [] : Arr::except($this->pageErrors, [$field]);
    }

    public function resetErrorBag(?string $field = null): void
    {
        $this->resetValidation($field);
    }

    public function dispatch(string $event, mixed ...$payload): static
    {
        session()->flash('page_event', ['name' => $event, 'detail' => $payload]);

        return $this;
    }

    protected function toast(string $message, string $variant = 'success', ?string $heading = null): void
    {
        session()->flash('toast', compact('message', 'variant', 'heading'));
    }

    protected function toastError(string $message, string $heading = 'Error'): void
    {
        $this->toast($message, 'danger', $heading);
    }

    /** @return array<string, mixed> */
    protected function publicState(): array
    {
        return collect((new ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC))
            ->reject(fn (\ReflectionProperty $property): bool => $property->isStatic())
            ->mapWithKeys(fn (\ReflectionProperty $property): array => [
                $property->getName() => $property->isInitialized($this) ? $property->getValue($this) : null,
            ])
            ->all();
    }

    public function redirectRoute(string $route, mixed $parameters = [], bool $navigate = false): void
    {
        $this->pendingResponse = redirect()->route($route, $parameters);
    }

    public function authorize(mixed $ability, mixed $arguments = []): mixed
    {
        return Gate::authorize($ability, $arguments);
    }

    abstract public function render();
}
