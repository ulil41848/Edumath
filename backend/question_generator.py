
import random
import re

from llama_helper import ask_llama
from arithmetic_checker import calculate_expression


# =========================================================
# KONFIGURASI SESI
# =========================================================

TOTAL_QUESTIONS = 10

QUESTION_PLAN = [
    ("addition", "easy"),
    ("subtraction", "easy"),
    ("multiplication", "easy"),
    ("division", "easy"),
    ("addition", "medium"),
    ("subtraction", "medium"),
    ("multiplication", "medium"),
    ("division", "medium"),
    ("multiplication", "hard"),
    ("division", "hard"),
]


# =========================================================
# MEMBUAT EKSPRESI MATEMATIKA
# =========================================================

def create_expression(operation, difficulty):
    """Membuat ekspresi sesuai operasi dan tingkat kesulitan."""

    ranges = {
        "easy": (1, 20),
        "medium": (10, 100),
        "hard": (50, 500),
    }

    if difficulty not in ranges:
        raise ValueError(f"Tingkat kesulitan tidak dikenal: {difficulty}")

    low, high = ranges[difficulty]

    if operation == "addition":
        a = random.randint(low, high)
        b = random.randint(low, high)
        return f"{a} + {b}"

    if operation == "subtraction":
        a = random.randint(low, high)
        b = random.randint(low, high)

        # Memastikan hasil pengurangan tidak nol.
        while a == b:
            b = random.randint(low, high)

        a, b = max(a, b), min(a, b)
        return f"{a} - {b}"

    if operation == "multiplication":
        if difficulty == "easy":
            a = random.randint(2, 10)
            b = random.randint(2, 10)

        elif difficulty == "medium":
            a = random.randint(11, 30)
            b = random.randint(3, 15)

        else:
            a = random.randint(20, 99)
            b = random.randint(12, 50)

        return f"{a} * {b}"

    if operation == "division":
        if difficulty == "easy":
            divisor = random.randint(2, 10)
            quotient = random.randint(2, 10)

        elif difficulty == "medium":
            divisor = random.randint(3, 15)
            quotient = random.randint(11, 30)

        else:
            divisor = random.randint(12, 50)
            quotient = random.randint(20, 99)

        dividend = divisor * quotient
        return f"{dividend} / {divisor}"

    raise ValueError(f"Operasi tidak dikenal: {operation}")

    low, high = ranges[difficulty]

    if operation == "subtraction":
        a = random.randint(low, high)
        b = random.randint(low, high)

        # Memastikan kedua angka berbeda.
        while a == b:
            b = random.randint(low, high)

        a, b = max(a, b), min(a, b)
        return f"{a} - {b}"


def format_expression(expression):
    """Mengubah simbol Python menjadi simbol untuk siswa."""

    return expression.replace("*", "×").replace("/", "÷")


def make_question_text(expression):
    """Membuat teks soal untuk siswa."""

    return f"Berapakah hasil dari {format_expression(expression)}?"


# =========================================================
# MEMBUAT PILIHAN JAWABAN
# =========================================================

def make_choices(answer):
    """Membuat empat pilihan berbeda dengan satu jawaban benar."""
    answer = int(answer)
    choices = {answer}

    # Menyiapkan pilihan yang dekat dengan jawaban benar.
    candidates = set()

    for offset in [1, 2, 3, 5, 10]:
        if answer - offset >= 0:
            candidates.add(answer - offset)
        candidates.add(answer + offset)

    candidates.discard(answer)
    candidates = list(candidates)
    random.shuffle(candidates)

    # Mengambil tiga pilihan pengecoh.
    choices.update(candidates[:3])

    # Pengaman jika pilihan yang tersedia belum mencapai empat.
    while len(choices) < 4:
        offset = random.randint(1, 10)
        candidate = answer + random.choice([-offset, offset])

        if candidate >= 0 and candidate != answer:
            choices.add(candidate)

    # Mengacak posisi jawaban dan pilihan lainnya.
    result = [str(value) for value in choices]
    random.shuffle(result)

    return result


# =========================================================
# MEMBUAT PEMBAHASAN
# =========================================================

def make_explanation(expression, answer):
    """Membuat pembahasan berdasarkan hasil Python."""

    match = re.fullmatch(
        r"\s*(\d+)\s*([+\-*/])\s*(\d+)\s*",
        expression,
    )

    if not match:
        return f"Hasil perhitungan adalah {answer}."

    a = int(match.group(1))
    symbol = match.group(2)
    b = int(match.group(3))

    if symbol == "+":
        return (
            f"Kita menjumlahkan {a} dengan {b}. "
            f"Hasilnya adalah {answer}."
        )

    if symbol == "-":
        return (
            f"Kita mengurangi {a} dengan {b}. "
            f"Hasilnya adalah {answer}."
        )

    if symbol == "*":
        return (
            f"Kita mengalikan {a} dengan {b}. "
            f"Hasilnya adalah {answer}."
        )

    return (
        f"Kita membagi {a} dengan {b}. "
        f"Karena {b} dikali {answer} menghasilkan {a}, "
        f"maka hasil pembagiannya adalah {answer}."
    )


# =========================================================
# MEMBUAT DAN MEMVALIDASI SATU SOAL
# =========================================================

def create_question(operation, difficulty, used_expressions):
    """Membuat soal unik dan memvalidasi kunci serta pilihan."""

    for _ in range(100):
        expression = create_expression(operation, difficulty)

        if expression in used_expressions:
            continue

        answer = calculate_expression(expression)

        if answer is None or int(answer) != answer:
            continue

        answer = int(answer)
        choices = make_choices(answer)

        # Pastikan pilihan unik.
        if len(choices) != 4 or len(set(choices)) != 4:
            continue

        # Pastikan tepat satu pilihan bernilai sama dengan kunci.
        correct_count = sum(
            1 for choice in choices if int(choice) == answer
        )

        if correct_count != 1:
            continue

        # Pastikan hasil pemeriksaan Python konsisten.
        checked_answer = calculate_expression(expression)

        if checked_answer != answer:
            continue

        used_expressions.add(expression)

        return {
            "operation": operation,
            "difficulty": difficulty,
            "question": make_question_text(expression),
            "expression": expression,
            "choices": choices,
            "answer": str(answer),
            "explanation": make_explanation(expression, answer),
        }

    return None


# =========================================================
# BANTUAN LLAMA
# =========================================================

def ask_llama_for_hint(question):
    """
    Meminta saran penjelasan kepada Llama.
    Jawaban Llama tidak digunakan sebagai kunci matematika.
    """

    prompt = f"""
Kamu adalah asisten matematika untuk siswa SD.
Berikan penjelasan singkat dan mudah dipahami untuk soal berikut:
{question}

Gunakan bahasa Indonesia.
Jangan mengubah soal atau menebak kunci jawaban.
"""

    response = ask_llama(prompt)

    if response.startswith("Gagal menghubungi Ollama:"):
        return None

    return response.strip() or None


# =========================================================
# MEMBUAT SESI 10 SOAL
# =========================================================

def generate_session():
    """Membuat 10 soal dengan urutan tingkat kesulitan acak."""

    # Salin dan acak rencana tanpa mengubah QUESTION_PLAN asli.
    plan = QUESTION_PLAN.copy()
    random.shuffle(plan)

    questions = []
    used_expressions = set()

    for index, (operation, difficulty) in enumerate(plan, start=1):
        print(
            f"Membuat soal {index}/{TOTAL_QUESTIONS} "
            f"({operation}, {difficulty})..."
        )

        question = create_question(
            operation,
            difficulty,
            used_expressions,
        )

        if question is None:
            print(f"Gagal membuat soal nomor {index}.")
            print("Sesi dibatalkan karena soal tidak valid.")
            return None

        checked_answer = calculate_expression(question["expression"])

        if checked_answer != int(question["answer"]):
            print(f"Verifikasi kunci soal nomor {index} gagal.")
            return None

        questions.append(question)

    if len(questions) != TOTAL_QUESTIONS:
        print("Jumlah soal tidak sesuai.")
        return None

    return questions


# =========================================================
# PENGUJIAN GENERATOR SECARA LANGSUNG
# =========================================================

def main():
    print("=== Generator Latihan Matematika ===")
    print("Python menghitung dan memvalidasi jawaban.")
    print("Urutan tingkat kesulitan diacak.")
    print("Menyiapkan soal...\n")

    questions = generate_session()

    if questions is None:
        print("\nSesi belum siap digunakan.")
        return

    print("\nSemua soal berhasil dibuat dan diperiksa!\n")

    # Mode ini khusus untuk pengujian pengembang.
    # Jangan gunakan tampilan ini sebagai tampilan siswa.
    for index, question in enumerate(questions, start=1):
        print(f"{index}. [{question['difficulty']}]")
        print(question["question"])
        print("Pilihan:", ", ".join(question["choices"]))
        print("Kunci jawaban:", question["answer"])
        print("Pembahasan:", question["explanation"])
        print()

    print("Pengujian generator selesai.")


if __name__ == "__main__":
    main()
