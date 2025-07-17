# Last.fm Integration Platform

A Laravel application that integrates with the Last.fm API to provide music data analysis and visualization.

## Project Overview

This application allows users to connect their Last.fm accounts and analyze their listening habits through various statistics, charts, and visualizations. It tracks weekly charts, processes listening history, and provides insights about favorite artists, tracks, and albums.

## Directory Structure

```
/app
|-- Actions/LastFm/         # Business logic for Last.fm integrations
|   |-- Albums/             # Album-related operations
|   |-- Artists/            # Artist-related operations
|   |-- Charts/             # Chart-related operations
|   |-- Statistics/         # Statistics generation
|   |-- Tracks/             # Track-related operations 
|   |-- Users/              # User-related operations
|-- Console/Commands/LastFm/ # Console commands for Last.fm operations
|-- Contracts/Actions/LastFm/ # Interfaces for Last.fm actions
|-- DTOs/LastFm/           # Data Transfer Objects for Last.fm data
|-- Http/
|   |-- Controllers/LastFm/ # Controllers handling Last.fm requests
|   |-- Requests/LastFm/    # Form requests for Last.fm operations
|-- Models/LastFm/          # Database models for Last.fm data
|-- Services/LastFm/        # Services for Last.fm operations
/resources
|-- views/
|   |-- last-fm/           # Blade views for Last.fm features
|   |-- components/last-fm/ # Reusable components for Last.fm features
```

## Last.fm API Endpoints Used

The application integrates with the following Last.fm API endpoints:

| Endpoint | Description | Documentation URL |
|----------|-------------|------------------|
| `user.getInfo` | Retrieves user profile information | [user.getInfo Documentation](https://www.last.fm/api/show/user.getInfo) |
| `user.getWeeklyChartList` | Gets a list of available charts for a user | [user.getWeeklyChartList Documentation](https://www.last.fm/api/show/user.getWeeklyChartList) |
| `user.getWeeklyTrackChart` | Gets a track chart for a user in a specified time period | [user.getWeeklyTrackChart Documentation](https://www.last.fm/api/show/user.getWeeklyTrackChart) |
| `user.getWeeklyArtistChart` | Gets an artist chart for a user in a specified time period | [user.getWeeklyArtistChart Documentation](https://www.last.fm/api/show/user.getWeeklyArtistChart) |
| `user.getWeeklyAlbumChart` | Gets an album chart for a user in a specified time period | [user.getWeeklyAlbumChart Documentation](https://www.last.fm/api/show/user.getWeeklyAlbumChart) |

## Implementation Details

### Actions

The main operations for interacting with the Last.fm API are implemented as dedicated Action classes:

- `FetchWeeklyChartList`: Retrieves available charts for a user with their timestamps
- `FetchWeeklyTrackChart`: Gets a user's track chart for a specific time period
- `ProcessWeeklyTrackChart`: Processes a track chart and stores it in the database

### Data Transfer Objects (DTOs)

The application uses DTOs to safely transform Last.fm API responses:

- `ArtistDTO`: Represents artist data
- `TrackDTO`: Represents track data with related artist information
- `AlbumDTO`: Represents album data with related artist information
- `WeeklyChartDTO`: Represents a weekly chart with from/to timestamps

### Services

The `LastFmApi` service handles direct communication with the Last.fm API, with methods for each endpoint.

## Getting Started

### Requirements

- PHP 8.4+
- Laravel 12
- Composer
- MySQL/PostgreSQL database

### Installation

1. Clone the repository
2. Install dependencies:
   ```
   composer install
   ```
3. Copy `.env.example` to `.env` and configure your database and Last.fm API credentials:
   ```
   LASTFM_API_KEY=your_api_key
   LASTFM_API_SECRET=your_api_secret
   ```
4. Run database migrations:
   ```
   php artisan migrate
   ```
5. Start the development server:
   ```
   php artisan serve
   ```

## Configuration

### Last.fm API Keys

You need to register for a Last.fm API account to get your API key and secret:
1. Visit [Last.fm API](https://www.last.fm/api/account/create)
2. Create an API account
3. Add your API key and secret to your `.env` file

## Testing

Tests are written using Pest and can be run with:

```
./vendor/bin/pest
```

## Design Standards

The project follows Tailwind CSS design standards with support for dark mode. See the design standards documentation for more details on implementation patterns.

## Code Quality & Linting

The project uses several code quality tools configured in both `composer.json` and `package.json`:

### Available Commands

- **Full Linting**: Run all linting tools with one command
  ```bash
composer lint
```
  This runs PHP linting tools (Pint, Rector) and frontend formatting (Prettier) in sequence.

### PHP Tools (`composer.json`)

#### Laravel Pint

PHP code style fixer for Laravel configured in `pint.json` with the following key rules:

```bash
composer pint-dirty
```

- **Base Configuration**: Uses Laravel preset as foundation
- **Type Safety**: Enforces `declare(strict_types=1)` in all files
- **Structural Order**: Orders class elements alphabetically with public methods first, then protected, then private
- **Import Management**: Requires fully qualified strict types and removes unused imports
- **Code Quality**:
  - Prevents multiple statements per line
  - Enforces strict comparisons (`===` instead of `==`)
  - Converts legacy type casting to modern syntax
  - Eliminates superfluous conditionals and empty elseif/else blocks

#### Rector

PHP code refactoring and improvement tool configured in `rector.php`:

```bash
composer rector      # Apply fixes
composer rector-dry  # Dry run (show but don't apply)
```

- **Prepared Sets**:
  - `deadCode`: Removes unused code
  - `codeQuality`: Simplifies and optimizes code
  - `typeDeclarations`: Adds type hints where possible
  - `privatization`: Makes properties/methods private when possible
  - `earlyReturn`: Restructures code to reduce nesting
  - `strictBooleans`: Enforces strict boolean handling

- **Custom Rules**:
  - `NewlineAfterStatementRector`: Ensures clean separation between statements

- **Scope**: Applied to `/app`, `/tests`, `/routes`, and `/config` directories

#### PHPStan

PHP static analysis tool configured in `phpstan.neon`:

```bash
composer phpstan
```

- **Analysis Level**: Set to level 5 (advanced type checking)
- **Analyzed Paths**: `app`, `config`, `database`, `routes`
- **Excluded Paths**: `tests/*`
- **Git Integration**: Smart analysis of only changed files:

```bash
vendor/bin/phpstan analyse $(git diff --name-only --diff-filter=ACM)
```

### Frontend Tools (`package.json`)

#### Prettier

Code formatter for JavaScript, TypeScript, CSS, and Blade templates configured in `.prettierrc.json`:

```bash
npm run format         # Format all files in resources/
npm run check          # Check format without modifying files
```

- **General Settings**:
  - `printWidth: 120`: Maximum line length
  - `singleQuote: true`: Uses single quotes
  - `tabWidth: 4`: Default indentation (except JS/CSS files)
  - `semi: true`: Enforces semicolons
  - `endOfLine: lf`: Consistent line endings

- **File-specific Rules**:
  - **Blade Files**: Uses Blade parser via `prettier-plugin-blade`
  - **JS/TS/CSS/JSON Files**: Uses 2-space indentation

- **Plugin Integration**:
  - `prettier-plugin-blade`: Formatting for Blade templates
  - `prettier-plugin-tailwindcss`: Sorts Tailwind CSS classes

- **Advanced Formatting Options**:

```bash
npm run prettier-diff-fancy       # Show detailed formatting differences
npm run format-apply-with-diff    # Format files with visual diff output
```

These tools collectively help maintain code quality and ensure adherence to the project's coding standards. The linting workflow analyzes code changes in git to efficiently process only modified files.

## Laravel Pint Rules Detail

Our project leverages Laravel Pint (PHP-CS-Fixer) with specific rules to ensure code quality and consistency. Below is a comprehensive list of rules with their purpose and effects:

### Code Style & Syntax

| Rule | Description | Example |
|------|-------------|--------|
| `array_push` | Replaces array_push() with more efficient array operations | `$array[] = $value` instead of `array_push($array, $value)` |
| `no_unused_imports` | Removes unused imports | Deletes `use App\Models\User;` if not used |
| `single_line_after_imports` | Enforces blank line after imports | Ensures empty line after namespace imports |
| `backtick_to_shell_exec` | Replaces backticks with shell_exec() | `shell_exec($cmd)` instead of \`$cmd\` |
| `declare_strict_types` | Enforces strict type declarations | Adds `declare(strict_types=1);` to files |
| `lowercase_keywords` | Ensures all PHP keywords are lowercase | `foreach` not `FOREACH` |
| `ternary_operator_spaces` | Standardizes spacing around ternary operators | `$a ? $b : $c` not `$a?$b:$c` |

### Type Safety & Casting

| Rule | Description | Example |
|------|-------------|--------|
| `date_time_immutable` | Promotes use of DateTimeImmutable | `new \DateTimeImmutable()` instead of `new \DateTime()` |
| `modernize_types_casting` | Updates to modern type casting | `(int)$var` instead of `intval($var)` |
| `strict_comparison` | Enforces strict comparisons | `===` and `!==` instead of `==` and `!=` |

### Code Structure & Organization

| Rule | Description | Purpose |
|------|-------------|--------|
| `ordered_class_elements` | Orders class elements alphabetically by type | Consistency and predictable code structure |
| `ordered_interfaces` | Alphabetically orders interfaces in implements | Better readability and organization |
| `ordered_traits` | Alphabetically orders traits in use statements | Consistent trait ordering |
| `visibility_required` | Ensures visibility is declared on all elements | Forces explicit public/protected/private declarations |

### Code Optimization

| Rule | Description | Benefit |
|------|-------------|--------|
| `no_multiple_statements_per_line` | Prevents multiple statements on single line | Improves readability and debugging |
| `no_extra_blank_lines` | Removes excessive blank lines | Cleaner, more compact code |
| `no_superfluous_elseif` | Removes unnecessary elseif blocks | Simplifies control flow |
| `no_useless_else` | Eliminates redundant else blocks | Reduces nesting and improves clarity |
| `protected_to_private` | Converts protected to private when possible | Reduces unnecessary exposure |

### Method & Property Access

| Rule | Description | Example |
|------|-------------|--------|
| `self_accessor` | Forces self:: for static method calls | `self::method()` not `$this->method()` |
| `self_static_accessor` | Forces static:: over self:: when inheritance in play | `static::method()` not `self::method()` when extended |

### Namespace & Import Rules

| Rule | Description | Example |
|------|-------------|--------|
| `fully_qualified_strict_types` | Imports classes from global namespace | Adds use statements for \DateTime etc. |
| `global_namespace_import` | Controls import of classes/consts/functions | Configures how global elements are imported |
| `lowercase_static_reference` | Ensures lowercase static references | `self::`, `static::`, `parent::` not capitalized |

These rules are configured to align with PHP 8.4 features and modern development practices, ensuring a codebase that is maintainable, consistent, and follows industry best practices.

## Git Hooks with Husky

This project uses [Husky](https://typicode.github.io/husky/) to enforce code quality standards through Git hooks. Husky automatically runs linting and formatting tools before each commit to ensure that all code meets the project's standards.

### Pre-commit Hook

The pre-commit hook runs the following commands:

1. `composer php-lint` - Runs Laravel Pint and Rector on changed PHP files
2. `npm run format` - Runs Prettier on frontend files

This ensures that all committed code is properly formatted and follows the project's coding standards.

### Installation

Husky is automatically installed and configured when you run `npm install`. The pre-commit hook is set up to run automatically before each commit.

### Bypassing Hooks

In rare cases where you need to bypass the pre-commit hook (not recommended for normal workflow), you can use the `--no-verify` flag:

```bash
git commit -m "Your commit message" --no-verify
```

However, it's generally better to fix any issues flagged by the linting tools rather than bypassing the hooks.
