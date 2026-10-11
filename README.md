# To-Do List

A simple to-do list web application built with Laravel. Add items, edit them inline, search and filter, and delete with a 6-second undo — all from a single, clean page.

## Features

- Add new to-do items with inline validation
- Inline editing of item titles
- Search by title
- Filter by status: All, Active, Done
- Mark a single item as done (or back to active) with a circular toggle
- Mark all items done / active in one click
- Soft delete with **6-second undo toast**
- Live counter of active vs. done items
- Empty state when there is nothing to show
- Responsive, accessible UI (keyboard focus, ARIA labels, SR-only labels)
- Vite-built assets

## Tech Stack

- **PHP 8.1+**
- **Laravel 10**
- **MySQL**
- **Blade** templating
- **Vite** for CSS/JS bundling

## Requirements

- PHP >= 8.1 with the `mbstring`, `xml`, `curl`, and `bcmath` extensions
- Composer
- MySQL server
- Node.js & npm

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/AlvyRahman/laravel-todo-app.git
cd laravel-todo-app

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies and build assets
npm install
npm run build

# 4. Create your environment file and app key
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todoList
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then create the tables and start the server:

```bash
php artisan migrate
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

## Usage

- Type into the **Add a new item** field and click **Add** (or press Enter).
- Click the circle to toggle an item between done and active.
- Click **Edit** on a row to edit inline; hit **Save** or **Cancel** to exit.
- Use the search box to filter by name.
- Use **All / Active / Done** pills to filter by status.
- Click **Remove** to soft-delete an item — a toast appears with **Undo** for 6 seconds.
- Use **Mark all done** / **Mark all active** to update every item at once.

## Auto-Purging Deleted Items

Deleted items stay in the database (soft-deleted) for 6 seconds so Undo can work. After that, they are **permanently deleted** by Laravel's `model:prune` command. For the purge to run automatically, set up the Laravel scheduler:

**In development:**
```bash
php artisan schedule:work
```

**In production:** add this to your crontab:
```text
* * * * * php artisan schedule:run >> /dev/null 2>&1
```

## Project Structure

```text
app/
├── Console/Kernel.php                        # Scheduler (model:prune)
├── Http/Controllers/TodoListController.php   # Routes & logic
├── Http/Requests/ListItemRequest.php         # Form validation
└── Models/ListItem.php                        # To-do item model (SoftDeletes + Prunable)
database/
└── migrations/                                # users, list_items (with softDeletes), etc.
resources/
├── css/app.css                                # Styles (compiled by Vite)
├── js/app.js                                  # JS (edit-toggle, tiny helpers)
└── views/welcome.blade.php                    # Single-page UI
routes/
└── web.php                                    # Web routes
```

## Routes

| Method | URI               | Action   | Description               |
|--------|-------------------|----------|---------------------------|
| GET    | `/`               | `index`  | Show list with search/filter |
| POST   | `/saveItem`       | `saveItem` | Create a new item (validated) |
| POST   | `/complete/{id}`  | `complete` | Mark one as done         |
| POST   | `/incomplete/{id}`| `incomplete` | Mark one as active       |
| POST   | `/remove/{id}`    | `remove` | Soft-delete (shows undo) |
| POST   | `/restore/{id}`   | `restore` | Restore a soft-deleted item |
| POST   | `/markAllComplete`| `markAllComplete` | Mark all done        |
| POST   | `/markAllIncomplete`| `markAllIncomplete` | Mark all active   |
| PUT    | `/edit/{id}`      | `edit`   | Inline edit (validated)   |

## Database

The `list_items` table stores each to-do item:

| Column        | Type      | Notes                  |
|---------------|-----------|------------------------|
| `id`          | bigint    | Primary key            |
| `name`        | string    | Item text (max 255)    |
| `is_complete` | integer   | `0` = active, `1` = done |
| `deleted_at`  | timestamp | Soft delete timestamp (nullable) |
| `created_at`  | timestamp |                        |
| `updated_at`  | timestamp |                        |

## Development

To rebuild assets automatically while editing CSS/JS:

```bash
npm run dev
```

To lint PHP files (Laravel Pint):

```bash
vendor/bin/pint
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
