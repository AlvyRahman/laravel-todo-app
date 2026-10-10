# To-Do List

A simple to-do list web application built with Laravel. Add items, mark them done, flip them back to active, and remove them — all from a single, clean page.

## Features

- Add new to-do items
- Mark a single item as done (or back to active) with a toggle
- Mark all items done / active in one click
- Remove individual items (with confirmation)
- Completed items shown with a strikethrough style
- Live counter of active vs. done items
- Empty state when there is nothing to show
- Responsive, self-contained UI

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
- Click the circle next to an item to toggle it between done and active.
- Use **Mark all done** / **Mark all active** to update every item at once.
- Click **Remove** to delete an item (you'll be asked to confirm).

## Project Structure

```
app/
├── Http/Controllers/TodoListController.php   # All application logic
└── Models/ListItem.php                        # To-do item model
database/
└── migrations/                                # users, list_items, etc.
resources/
├── css/app.css                                # Styles (compiled by Vite)
└── views/welcome.blade.php                    # The single-page UI
routes/
└── web.php                                    # Application routes
```

## Routes

| Method | URI                 | Action              | Description                      |
|--------|---------------------|---------------------|----------------------------------|
| GET    | `/`                 | `index`             | Show all items                   |
| POST   | `/saveItem`         | `saveItem`          | Create a new item                |
| POST   | `/complete/{id}`    | `complete`          | Mark one item as done            |
| POST   | `/incomplete/{id}`  | `incomplete`        | Mark one item as active          |
| POST   | `/remove/{id}`      | `remove`            | Delete an item                   |
| POST   | `/markAllComplete`  | `markAllComplete`   | Mark every item as done          |
| POST   | `/markAllIncomplete`| `markAllIncomplete` | Mark every item as active        |

## Database

The `list_items` table stores each to-do item:

| Column        | Type      | Notes               |
|---------------|-----------|---------------------|
| `id`          | bigint    | Primary key         |
| `name`        | string    | Item text           |
| `is_complete` | integer   | `0` = active, `1` = done |
| `created_at`  | timestamp |                     |
| `updated_at`  | timestamp |                     |

## Development

To rebuild assets automatically while editing CSS/JS:

```bash
npm run dev
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
