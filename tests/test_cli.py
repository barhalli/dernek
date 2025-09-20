import sys
from io import StringIO

import pytest

from calculator.cli import execute, main


def run_main(args):
    stdout = StringIO()
    stderr = StringIO()
    old_stdout, old_stderr = sys.stdout, sys.stderr
    try:
        sys.stdout, sys.stderr = stdout, stderr
        exit_code = main(args)
    finally:
        sys.stdout, sys.stderr = old_stdout, old_stderr
    return exit_code, stdout.getvalue(), stderr.getvalue()


def test_main_success():
    exit_code, stdout, stderr = run_main(["topla", "2", "3"])
    assert exit_code == 0
    assert stdout.strip() == "5"
    assert stderr == ""


@pytest.mark.parametrize("command", ["listele", "list"])
def test_list_command(command):
    exit_code, stdout, stderr = run_main([command])
    assert exit_code == 0
    assert "Desteklenen işlemler" in stdout
    assert "topla" in stdout
    assert stderr == ""


def test_main_error():
    exit_code, stdout, stderr = run_main(["bilinmeyen", "1", "2"])
    assert exit_code == 1
    assert stdout == ""
    assert "Geçersiz işlem" in stderr


def test_execute_disallows_list_operation():
    with pytest.raises(ValueError):
        execute("listele", [])
