"""`python -m calculator` kullanımını destekler."""

from __future__ import annotations

import sys

from .cli import main


if __name__ == "__main__":  # pragma: no cover - komut satırı kullanımını kapsamak zorunda değiliz
    sys.exit(main())
