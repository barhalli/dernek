"""Hesap makinesi uygulamasının temel işlemleri."""

from __future__ import annotations

from dataclasses import dataclass
from functools import reduce
from typing import Callable, Iterable, Mapping, Sequence

Number = float


@dataclass(frozen=True)
class Operation:
    """Bir hesap makinesi işlemini temsil eder."""

    func: Callable[[Sequence[Number]], Number]
    min_args: int
    max_args: int | None
    description: str
    aliases: tuple[str, ...] = ()

    def validate_argument_count(self, values: Sequence[Number]) -> None:
        """Argüman sayısını doğrular."""

        count = len(values)
        if count < self.min_args:
            raise ValueError(
                f"Bu işlem için en az {self.min_args} adet sayı gerekiyor."  # noqa: TRY003
            )
        if self.max_args is not None and count > self.max_args:
            raise ValueError(
                f"Bu işlem için en fazla {self.max_args} adet sayı kullanabilirsiniz."  # noqa: TRY003
            )


def _add(values: Sequence[Number]) -> Number:
    return float(sum(values))


def _subtract(values: Sequence[Number]) -> Number:
    iterator = iter(values)
    result = next(iterator)
    for value in iterator:
        result -= value
    return float(result)


def _multiply(values: Sequence[Number]) -> Number:
    return float(reduce(lambda acc, value: acc * value, values, 1.0))


def _divide(values: Sequence[Number]) -> Number:
    iterator = iter(values)
    result = next(iterator)
    for value in iterator:
        if value == 0:
            raise ValueError("Sıfıra bölme yapılamaz.")  # noqa: TRY003
        result /= value
    return float(result)


def _power(values: Sequence[Number]) -> Number:
    base, exponent = values
    return float(base**exponent)


def _modulo(values: Sequence[Number]) -> Number:
    dividend, divisor = values
    if divisor == 0:
        raise ValueError("Mod işlemi için bölen sıfır olamaz.")  # noqa: TRY003
    return float(dividend % divisor)


def _register_operations() -> tuple[Mapping[str, Operation], tuple[str, ...]]:
    operations: dict[str, Operation] = {}
    canonical_names: list[str] = []

    def register(name: str, operation: Operation) -> None:
        canonical_names.append(name)
        for alias in (name, *operation.aliases):
            operations[alias] = operation

    register(
        "topla",
        Operation(
            func=_add,
            min_args=1,
            max_args=None,
            description="Girilen tüm sayıları toplar.",
            aliases=("add",),
        ),
    )
    register(
        "çıkar",
        Operation(
            func=_subtract,
            min_args=2,
            max_args=None,
            description="İlk sayıdan diğerlerini çıkarır.",
            aliases=("cikar", "subtract"),
        ),
    )
    register(
        "çarp",
        Operation(
            func=_multiply,
            min_args=2,
            max_args=None,
            description="Girilen tüm sayıları çarpar.",
            aliases=("carp", "multiply"),
        ),
    )
    register(
        "böl",
        Operation(
            func=_divide,
            min_args=2,
            max_args=None,
            description="İlk sayıyı sırayla diğerlerine böler.",
            aliases=("bol", "divide"),
        ),
    )
    register(
        "üs",
        Operation(
            func=_power,
            min_args=2,
            max_args=2,
            description="İlk sayının verilen kuvvetini alır.",
            aliases=("us", "power"),
        ),
    )
    register(
        "mod",
        Operation(
            func=_modulo,
            min_args=2,
            max_args=2,
            description="İlk sayının ikinci sayıya bölümünden kalanını bulur.",
            aliases=("modulo",),
        ),
    )

    return operations, tuple(canonical_names)


OPERATIONS, CANONICAL_OPERATION_NAMES = _register_operations()


def list_operations() -> list[tuple[str, Operation]]:
    """Desteklenen işlemleri liste olarak döndürür."""

    return [(name, OPERATIONS[name]) for name in CANONICAL_OPERATION_NAMES]


def calculate(operation_name: str, values: Iterable[Number]) -> Number:
    """İşlemi çalıştırır."""

    operation = OPERATIONS.get(operation_name.lower())
    if operation is None:
        available = ", ".join(CANONICAL_OPERATION_NAMES)
        raise ValueError(f"Geçersiz işlem: {operation_name}. Mevcut işlemler: {available}.")

    number_list = [float(value) for value in values]
    operation.validate_argument_count(number_list)
    return operation.func(number_list)
