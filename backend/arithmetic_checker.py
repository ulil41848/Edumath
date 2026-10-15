
import ast
import operator
import re


OPERATORS = {
    ast.Add: operator.add,
    ast.Sub: operator.sub,
    ast.Mult: operator.mul,
    ast.Div: operator.truediv,
}


def calculate_expression(expression):
    """Hitung ekspresi aritmetika dasar dengan aman."""

    expression = expression.strip()
    expression = expression.replace("×", "*").replace("÷", "/")
    expression = expression.replace("x", "*").replace("X", "*")

    # Izinkan hanya angka, spasi, titik desimal, dan operator dasar.
    if not re.fullmatch(r"[0-9+\-*/().\s]+", expression):
        return None

    try:
        tree = ast.parse(expression, mode="eval")
    except SyntaxError:
        return None

    def evaluate(node):
        if isinstance(node, ast.Expression):
            return evaluate(node.body)

        if isinstance(node, ast.Constant) and type(node.value) in (int, float):
            return node.value

        if isinstance(node, ast.BinOp) and type(node.op) in OPERATORS:
            left = evaluate(node.left)
            right = evaluate(node.right)

            if isinstance(node.op, ast.Div) and right == 0:
                raise ZeroDivisionError

            return OPERATORS[type(node.op)](left, right)

        if isinstance(node, ast.UnaryOp) and isinstance(
            node.op, (ast.UAdd, ast.USub)
        ):
            value = evaluate(node.operand)
            return value if isinstance(node.op, ast.UAdd) else -value

        raise ValueError("Ekspresi tidak didukung.")

    try:
        return evaluate(tree)
    except (ValueError, TypeError, ZeroDivisionError, OverflowError):
        return None
