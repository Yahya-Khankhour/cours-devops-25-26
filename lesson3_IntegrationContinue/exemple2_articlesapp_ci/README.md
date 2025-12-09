# ArticlesApp PHP with Docker CI/CD

A PHP Articles application with continuous integration using Docker and GitHub Actions.

## Features
- PHP 8.1 application
- Docker containerization
- GitHub Actions CI/CD pipeline
- PHPUnit testing
- Code quality checks (PHPCS, PHPMD, PHPStan)
- Docker security scanning

## Local Development

### Using Docker Compose
```bash
# Build and start the application
docker-compose -f docker/docker-compose.yml up php

# Run tests
docker-compose -f docker/docker-compose.yml run --rm php-test
```

### Enable pre-commit hook (runs checks + Docker tests)
Run this once in your repo to use the hook stored in `.githooks/`:

```bash
git config core.hooksPath .githooks
```

Now every commit will:
- Run `scripts/quality_check.sh` (lint, analyse, unit tests)
- Build `docker/Dockerfile.test` and run tests inside the container

### Enable pre-push hook (runs CI + Docker tests)
The pre-push hook runs a lighter CI and Docker test before any `git push`:

```bash
git config core.hooksPath .githooks
# Already set; this enables both pre-commit and pre-push hooks
```

If you need to bypass for an emergency push:
- `git push --no-verify`

## CI/CD on GitHub
- Workflows live in `.github/workflows/`
- `php-ci.yml`: quality checks + PHPUnit + image build + security scan
- `docker-ci.yml`: docker-compose test flow and production image scan