# Defense

[![CI](https://github.com/MederickBernier/Defense/actions/workflows/ci.yml/badge.svg)](https://github.com/MederickBernier/Defense/actions)  
![PHP](https://img.shields.io/badge/PHP-8.2%20|%208.3%20|%208.4-blue)  
![License](https://img.shields.io/badge/license-MIT-green)

**Defense** is a small, framework-agnostic defensive toolkit for PHP 8.2+ backends.  
It provides lightweight building blocks for safer, more resilient code: guards, results, retries, idempotency, and helpers around HTTP, persistence, and observability.

---

## Features

- 🔒 **Guards** — fail-fast validation for inputs (`notNull`, `notEmptyString`, `positiveInt`, `inArray`, …).
- ✅ **Result type** — explicit success/error wrapping.
- 🔁 **Retry** — automatic retry with backoff.
- 🆔 **Idempotency & Request-Id** — helpers and PSR-15 middleware for safer HTTP APIs.
- 📄 **Problem+JSON** — RFC 7807 error responses (`build`, `fromException`, `validationError`).
- 📊 **Pagination** — simple helper for query parsing + meta output.
- 🗄️ **Tx & Db** — transaction runner and PDO factory with safe defaults.
- 🔑 **Password & ConstantTime** — security primitives with safe defaults.
- 🔐 **JWT Interface** — pluggable adapter for token handling.
- 🔍 **Observability** — health checks and request IDs.

---

## Usage

### Guards

```php
use Mede\Defense\Core\Guard;

Guard::notNull($id, 'ID required');
Guard::notEmptyString($name, 'Name required');
Guard::positiveInt($age, 'Age must be > 0');
Guard::maxLength($username, 20, 'Username too long');
Guard::inArray($role, ['user','admin'], 'Invalid role');
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

### Pagination

```php
use Mede\Defense\Http\Pagination;

$p = Pagination::fromQuery($_GET, max:50, default:10);
$meta = $p->meta(120);
// ['page'=>1,'per_page'=>10,'total'=>120,'pages'=>12]
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

### Observability — Health Checks

```php
use Mede\Defense\Observability\HealthCheck;

$hc = (new HealthCheck())
    ->add('db', fn() => $pdo->query('SELECT 1') !== false)
    ->add('cache', fn() => $redis->ping() === '+PONG');

$results = $hc->run();
// [['name'=>'db','ok'=>true], ['name'=>'cache','ok'=>true]]

$allOk = $hc->allOk(); // true/false
```

### Observability — Request ID

```php
use Mede\Defense\Observability\RequestId;

$id = RequestId::ensure($_SERVER['HTTP_X_REQUEST_ID'] ?? null);
// stable request ID, or new if none provided
```

### Observability — RequestIdMiddleware

```php
use Mede\Defense\Http\Middleware\RequestIdMiddleware;
use Psr\Http\Server\RequestHandlerInterface;

// Wrap in a PSR-15 pipeline (Slim, Laminas, Mezzio…)
$app->add(new RequestIdMiddleware());
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

- ✅ **v0.3.0** — Request-ID middleware, JWT adapter interface, improved Problem+JSON, health checks.  
- 🚧 **v0.4.0** — Logging facade, idempotency helpers (Redis/Postgres), retry strategies.  
- 🔜 **v0.5+** — Framework integrations (Slim/Laravel), advanced reliability patterns.  
- 🎯 **v1.0** — Stable API surface with 85–90% coverage, Packagist-ready.

---

## License

MIT © 2025 [Mederick Bernier](https://github.com/MederickBernier)
