import math

import pytest

from calculator import calculate, list_operations


@pytest.mark.parametrize(
    "operation, values, expected",
    [
        ("topla", [1, 2, 3], 6.0),
        ("add", [1.5, 2.5], 4.0),
        ("çıkar", [10, 3, 2], 5.0),
        ("carp", [2, 3, 4], 24.0),
        ("bol", [20, 2, 5], 2.0),
        ("üs", [2, 3], 8.0),
        ("mod", [10, 3], 1.0),
    ],
)
def test_calculate_success(operation, values, expected):
    assert math.isclose(calculate(operation, values), expected)


def test_calculate_invalid_operation():
    with pytest.raises(ValueError) as excinfo:
        calculate("bilinmeyen", [1, 2])
    assert "Geçersiz işlem" in str(excinfo.value)


def test_divide_by_zero():
    with pytest.raises(ValueError):
        calculate("bol", [10, 0])


def test_modulo_by_zero():
    with pytest.raises(ValueError):
        calculate("mod", [10, 0])


@pytest.mark.parametrize(
    "operation, values, message",
    [
        ("çıkar", [5], "en az"),
        ("üs", [2, 3, 4], "en fazla"),
    ],
)
def test_argument_count_validation(operation, values, message):
    with pytest.raises(ValueError) as excinfo:
        calculate(operation, values)
    assert message in str(excinfo.value)


def test_list_operations_returns_canonical_names():
    operations = list_operations()
    names = [name for name, _ in operations]
    assert names == ["topla", "çıkar", "çarp", "böl", "üs", "mod"]
