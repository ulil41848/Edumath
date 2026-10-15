
from question_generator import generate_session

LETTERS = ["A", "B", "C", "D"]
TOTAL_QUESTIONS = 10


def run_session():
    print("=== LATIHAN MATEMATIKA ===")
    print("Menyiapkan 10 soal...\n")

    try:
        questions = generate_session()
    except Exception as error:
        print("Gagal membuat soal:", error)
        return

    if not questions or len(questions) != TOTAL_QUESTIONS:
        print("Latihan dibatalkan: jumlah soal tidak sesuai.")
        return

    answers = []

    for number, question in enumerate(questions, start=1):
        choices = question.get("choices", [])
        correct_answer = str(question.get("answer", ""))

        if len(choices) != 4:
            print(f"Pilihan soal nomor {number} tidak valid.")
            return

        if correct_answer not in [str(c) for c in choices]:
            print(f"Kunci soal nomor {number} tidak valid.")
            return

    for number, question in enumerate(questions, start=1):
        print("\n" + "=" * 35)
        print(f"SOAL {number} DARI {TOTAL_QUESTIONS}")
        print(question["question"])

        for letter, choice in zip(LETTERS, question["choices"]):
            print(f"{letter}. {choice}")

        while True:
            answer = input("Jawabanmu (A/B/C/D): ").strip().upper()
            if answer in LETTERS:
                answers.append(answer)
                break
            print("Masukkan A, B, C, atau D.")

        if number < TOTAL_QUESTIONS:
            print("Jawaban tersimpan. Lanjut ke soal berikutnya.")

    score = 0

    print("\n" + "=" * 35)
    print("HASIL LATIHAN")
    print("=" * 35)

    for number, (question, answer) in enumerate(
        zip(questions, answers), start=1
    ):
        selected = str(question["choices"][LETTERS.index(answer)])
        correct = str(question["answer"])
        is_correct = selected == correct

        if is_correct:
            score += 1

        print(f"\nSoal {number}: {question['question']}")
        print(f"Jawabanmu: {selected}")
        print(f"Kunci jawaban: {correct}")
        print("Status:", "Benar" if is_correct else "Belum tepat")
        print("Pembahasan:", question["explanation"])

    print(f"\nNilai akhir: {score}/{TOTAL_QUESTIONS}")
    print(f"Persentase: {score / TOTAL_QUESTIONS * 100:.0f}%")
    print("Latihan selesai. Terus semangat belajar!")


if __name__ == "__main__":
    run_session()
