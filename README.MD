# Defense

[![CI](https://github.com/MederickBernier/Defense/actions/workflows/ci.yml/badge.svg)](https://github.com/MederickBernier/Defense/actions)  
![PHP](https://img.shields.io/badge/PHP-8.2%20|%208.3%20|%208.4-blue)  
![License](https://img.shields.io/badge/license-MIT-green)

**Defense** is a small, framework-agnostic defensive toolkit for PHP 8.2+ backends.  
It provides lightweight building blocks for safer, more resilient code: guards, results, retries, idempotency, and helpers around HTTP and persistence.



## Features

- 🔒 **Guards** — fail-fast validation for inputs.
- ✅ **Result type** — explicit success/error wrapping.
- 🔁 **Retry** — automatic retry with backoff.
- 🆔 **Idempotency & Request-Id** — helpers for safer HTTP APIs.
- 📄 **Problem+JSON** — RFC 7807 error responses.
- 🗄️ **Tx & Db** — transaction runner and PDO factory with safe defaults.
- 🔑 **Password & ConstantTime** — security primitives with safe defaults.
- 🔍 **Observability stubs** — request IDs, logs.

---

## Usage

### Guards

```php
use Mede\Defense\Core\Guard;

Guard::notEmptyString($name, 'Name required');
Guard::positiveInt($age, 'Age must be > 0');
Guard::inArray($role, ['user', 'admin'], 'Invalid role');
```

### Result

```php
use Mede\Defense\Core\Result;

function divide(int $a, int $b): Result {
    if ($b === 0) return Result::err('Division by zero');
    return Result::ok($a / $b);
}

$r = divide(10, 2);
if ($r->ok) {
    echo $r->val; // 5
} else {
    echo $r->err;
}
```

### Problem+JSON

```php
use Mede\Defense\Http\ProblemJson;

$response = ProblemJson::build(400, 'Invalid Request', 'Missing field: email');
// => ['type'=>'about:blank','title'=>'Invalid Request','status'=>400,'detail'=>'Missing field: email']
```

### Transactions

```php
use Mede\Defense\Persistence\Tx;

Tx::run($pdo, function () use ($pdo) {
    $stmt = $pdo->prepare('INSERT INTO users(name) VALUES (?)');
    $stmt->execute(['alice']);
});
```

### Retry

```php
use Mede\Defense\Core\Retry;

$value = Retry::run(fn() => flakyApiCall(), 3);
```

### Security

```php
use Mede\Defense\Security\Password;
use Mede\Defense\Security\ConstantTime;

$hash = Password::hash('secret');
Password::verify('secret', $hash); // true

ConstantTime::equals('abc', 'abc'); // true
```

---

## Development

Run QA locally:

```bash
composer install
composer qa
```

Includes:
- **php-cs-fixer** (style)
- **phpstan** (static analysis, level 8)
- **phpunit** (tests)

CI runs against PHP 8.2, 8.3, and 8.4.

---

## Roadmap

- **v0.2** — Expand Guards, add Pagination helper, enrich Problem+JSON builder.  
- **v0.3** — Request-ID middleware, JWT adapter interface, HealthCheck builder.  
- **v0.4+** — Logging facade, observability hooks, adapters for caching/storage.  
- **v1.0** — Stable API surface with 85–90% coverage, Packagist-ready.

---

## License

MIT © 2025 [Mederick Bernier](https://github.com/MederickBernier)
