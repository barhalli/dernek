"""Komut satırı arayüzü."""

from __future__ import annotations

import argparse
import sys
from typing import Sequence

from .core import Operation, calculate, list_operations


def _format_operation_help(name: str, operation: Operation) -> str:
    aliases = ", ".join(alias for alias in operation.aliases if alias != name)
    alias_text = f" (takma adlar: {aliases})" if aliases else ""
    return f"- {name}: {operation.description}{alias_text}"


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(
        description="Komut satırından basit matematiksel işlemler yapar.",
    )
    parser.add_argument(
        "operation",
        help="Yapılacak işlem. `listele` komutu ile seçenekleri görebilirsiniz.",
    )
    parser.add_argument(
        "numbers",
        nargs="*",
        type=float,
        help="İşlemde kullanılacak sayılar.",
    )
    return parser


def handle_list_command() -> int:
    print("Desteklenen işlemler:")
    for name, operation in list_operations():
        print(_format_operation_help(name, operation))
    return 0


def execute(operation: str, numbers: Sequence[float]) -> float:
    if operation.lower() in {"listele", "list"}:
        raise ValueError("listele komutu için main fonksiyonunu kullanın")
    return calculate(operation, numbers)


def main(argv: Sequence[str] | None = None) -> int:
    parser = build_parser()
    args = parser.parse_args(argv)

    operation = args.operation.lower()
    if operation in {"listele", "list"}:
        return handle_list_command()

    try:
        result = execute(operation, args.numbers)
    except ValueError as exc:  # pragma: no cover - arg hataları testlerle kapsanıyor
        print(f"Hata: {exc}", file=sys.stderr)
        return 1

    if result.is_integer():
        print(int(result))
    else:
        print(result)
    return 0


if __name__ == "__main__":  # pragma: no cover - komut satırı kullanımını kapsamak zorunda değiliz
    sys.exit(main())
