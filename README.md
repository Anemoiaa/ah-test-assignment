# Local Setup

## 1. Environment Setup

Copy the example environment file and adjust it if needed:

```bash
cp .env.example .env
```

> The `.env` file is already configured for local development by default.

---

## 2. Start Docker Containers

```bash
docker compose up -d
```

---

### Development mode (with frontend watcher)

To enable automatic frontend rebuilds (`npm run watch`), start docker compose with the `dev` profile:

```bash
docker compose --profile dev up -d
```

This will start an additional **`frontend`** container which:

* installs frontend dependencies
* runs `npm run watch`
* rebuilds assets on file changes

---

## 3. Install Dependencies

### PHP / Composer

```bash
docker compose exec app composer install
```

### Node.js / npm

```bash
docker compose exec app npm install
```

---

## 4. Frontend Assets

```bash
docker compose exec app npm run build
```

## 5. Database Migrations

```bash
docker compose exec app php ./database/migration.php
```

---

## 6. Database Seeding

```bash
docker compose exec app php ./database/seed.php
```

---

## 7. Code Style (PHP CS Fixer)

The project uses **PHP CS Fixer** to ensure consistent coding standards.

### Available Commands

* **Fix code style issues**

  ```bash
  composer code-style-fix
  ```

* **Check code style (dry run)**

  ```bash
  composer code-style-check
  ```

* **Describe available fixers**

  ```bash
  composer code-style-describe
  ```

---

## 8. Access the Application

Open your browser: **[http://localhost:8000](http://localhost:8000)**

---