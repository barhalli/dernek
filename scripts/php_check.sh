#!/usr/bin/env bash
set -euo pipefail

# Run PHP syntax checks across all PHP files in the repository.
# Usage: ./scripts/php_check.sh

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT_DIR"

if ! command -v php >/dev/null 2>&1; then
  echo "php is not installed or not in PATH" >&2
  exit 1
fi

status=0
while IFS= read -r -d '' file; do
  echo "Linting $file"
  if ! php -l "$file"; then
    status=1
  fi
done < <(find "$ROOT_DIR" -type f -name '*.php' -print0 | sort -z)

exit $status
