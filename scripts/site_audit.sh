#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR=$(cd "$(dirname "$0")/.." && pwd)
cd "$ROOT_DIR"

# PHP syntax linting
php_files=($(find "$ROOT_DIR" -name "*.php"))
if [ ${#php_files[@]} -eq 0 ]; then
  echo "No PHP files found to lint."
else
  echo "Running php -l on ${#php_files[@]} files..."
  for file in "${php_files[@]}"; do
    php -l "$file" > /tmp/php_lint_output.txt
    echo "$(sed 's/^/  /' /tmp/php_lint_output.txt)"
  done
fi

# Page presence check
required_pages=(
  "index.php" "about.php" "contact.php" "donate.php" "events.php" "news.php" "event.php" "news-detail.php"
  "admin/index.php" "admin/login.php" "admin/dashboard.php"
  "admin/stats.php" "admin/programs.php" "admin/events.php" "admin/news.php" "admin/settings.php"
  "admin/testimonials.php" "admin/partners.php" "admin/messages.php"
)

missing=()
for path in "${required_pages[@]}"; do
  if [ ! -f "$ROOT_DIR/$path" ]; then
    missing+=("$path")
  fi
done

if [ ${#missing[@]} -eq 0 ]; then
  echo "All required pages are present."
else
  echo "Missing required pages:" && printf '  - %s\n' "${missing[@]}"
  exit 1
fi
