---
trigger: glob
description: 
globs: **/*.php
---

# MUST

- You are an expert in PHP, Laravel 12, TypeScript, <https://fluxui.dev/>, Pest, Tailwind and AlpineJs.
- Always answer in spanish.
- All variables, methods, and classes must be named in English.
- It's important that every `Controller` and `Component` works with their own Service.
- Within the Service, use the actions, models, and other services as needed.
- There must be NO logic in the `Controller` or `Component`, only within the `Service`.
- If any method return an array in the @return annotation, it must be something like `array{message: string, is_from_ai: bool}` and so on. A fully array type must be used.
- Every documentation, comments, text content, etc. must be in English.

# ARCHITECTURE PATTERNS

## Action Pattern

- Use for single, focused business operations.
- Place in `app/Actions` directory.
- Must be `readonly` classes.
- Use dependency injection in constructor.
- Must implement a single `handle()` method.
- Name with verb + noun + Action (e.g., `CreateUserAction`).

Example:

```php
readonly class CreateTodoAction
{
    public function __construct(
        private TodoRepository $repository,
    ) {}

    public function handle(CreateTodoRequest $request): Todo
    {
        return $this->repository->create($request->validated());
    }
}
```

## Data Transfer Objects (DTOs)

- Use for transferring structured data between layers.
- Place in `app/DTOs` directory.
- Must be `readonly` classes.
- Use constructor property promotion.
- Include static factory methods for common conversions.
- Name with noun + Dto (e.g., `UserDto`).
- **STRICT**: DTOs must NEVER contain null values, only numeric fields where null represents a specific business meaning.

Example:

```php
readonly class TodoDto
{
    public function __construct(
        public string $title,
        public string $description,
        public bool $completed,
        public int $priority,
        public array $tags,
        public ?int $parentId = null,  // Only numeric fields can be nullable
    ) {}

    public static function fromModel(Todo $todo): self
    {
        return new self(
            title: $todo->title ?? '',
            description: $todo->description ?? '',
            completed: $todo->completed ?? false,
            priority: $todo->priority ?? 0,
            tags: $todo->tags ?? [],
            parentId: $todo->parent_id ?? null
        );
    }

    public static function fromArray(array $data): self
    {
        // No default values used for non-numeric fields
        return new self(
            title: $data['title'] ?? '' ,
            description: $data['description'] ?? '',
            completed: $data['completed'] ?? false,
            priority: $data['priority'] ?? 0,
            tags: $data['tags'] ?? [],
            parentId: $data['parent_id'] ?? null  // Only nullable for numeric field
        );
    }
}
```

## Enums

- Use for fixed sets of related values.
- Place in `app/Enums` directory.
- Use backed enums for database storage.
- Name with descriptive noun (e.g., `UserStatus`).
- Include helper methods when needed.

Example:

```php
enum UserRole: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case USER = 'user';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

## Services

- Handle business logic and orchestration.
- Place in `app/Services` directory.
- Use dependency injection.
- Name with noun + Service (e.g., `UserService`).
- Should be focused and follow Single Responsibility Principle.

Example:

```php
class UserService
{
    public function __construct(
        private UserRepository $repository,
        private MailService $mailService,
    ) {}

    public function registerUser(array $data): User
    {
        $user = $this->repository->create($data);
        $this->mailService->sendWelcomeEmail($user);
        return $user;
    }
}
```

## Collection Value Objects

- **Purpose**: Encapsulate typed collections of specific DTOs or Value Objects to maintain domain integrity and provide context-specific operations.
- **Implementation Rules**:
  - Must be placed in the `app/Collections` directory
  - Must be `readonly` classes to ensure immutability
  - Must encapsulate an instance of `Illuminate\Support\Collection`
  - Name must follow the format: object name + Collection (e.g., `ClassCollection`)
  - Must not contain complex business logic, only collection-related operations
  - Must provide static factory methods for common conversions:
    - `fromArray()`: create from an array of data
    - `fromModels()`: create from a collection of models

- **Required Methods**:
  - Constructor that accepts a `Collection` instance
  - Methods _fromArray_ and _fromModels_ are required and must be static
  - Utility methods like `count()`, `isEmpty()`, `first()`, etc if needed.
  - Methods that preserve typing when operating on the collection

- **Restrictions**:
  - Must not contain persistence logic
  - Must not directly modify collection elements
  - Must ensure all elements are of the same type
  - Must not have null values (except in methods like `first()` where it's unavoidable)

Example:

```php
readonly class ClassCollection
{
    public function __construct(
        public Collection $items
    ) {}

    public static function fromArray(array $data): self
    {
        $items = collect($data)->map(function (array $itemData) {
            return ClassDto::fromArray($itemData);
        });

        return new self(items: $items);
    }

    public static function fromModels(Collection $models): self
    {
        $items = $models->map(function ($model) {
            return ClassDto::fromModel($model);
        });

        return new self(items: $items);
    }

    public function count(): int
    {
        return $this->items->count();
    }
}
```

## CODE STYLE

### Formatting

- Use consistent indentation (4 spaces).
- Keep line lengths reasonable (120 characters maximum).
- Use method chaining on new lines:

```php
// Correct
$query->where('id', $id)
    ->where('name', $name)
    ->where('email', $email);

// Incorrect
$query->where('id', $id)->where('name', $name)->where('email', $email);
```

### Type Declarations

- Always use strict typing (`declare(strict_types=1)`).
- Use return type declarations for all methods.
- Use property type declarations.
- Use union types where appropriate.
- Never use `mixed` type.

## CODE REVIEW

- Review for security vulnerabilities.
- Ensure code follows these standards.
- Look for code smells and anti-patterns.
- If one of the above is found, stop and suggest a fix.

## MAINTENANCE

- Keep dependencies updated.
- Remove unused code.