from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from pydantic import BaseModel

from arithmetic_checker import calculate_expression
from llama_helper import ask_llama
from mathllm_helper import MathLLMHelper
import random

from question_generator import QUESTION_PLAN, create_question, generate_session

app = FastAPI()

# Izinkan frontend (yang jalan di port lain) memanggil backend ini.
# Ubah/tambah alamat di bawah sesuai port frontend Edumath kamu.
app.add_middleware(
    CORSMiddleware,
    allow_origins=[
        "http://localhost:5173",  # Vite
        "http://localhost:3000",  # Next.js / Create React App
        "http://127.0.0.1:5500",  # Live Server (HTML biasa)
    ],
    allow_methods=["*"],
    allow_headers=["*"],
)

# Model dimuat sekali saja saat server menyala.
mathllm = MathLLMHelper()


class Ask(BaseModel):
    question: str


@app.get("/")
def cek():
    return {"status": "backend Edumath jalan"}


@app.post("/api/ask")
def ask(body: Ask):
    question = body.question.strip()

    if not question:
        return {"error": "Soal tidak boleh kosong."}

    return {
        "question": question,
        # Hasil hitung Python (paling bisa dipercaya), None jika belum didukung.
        "checker": calculate_expression(question),
        # Prediksi model kecil buatan sendiri (hanya pembanding).
        "mathllm": mathllm.predict(question),
        # Jawaban Llama lewat Ollama (butuh Ollama menyala).
        "llama": ask_llama(
            f"Selesaikan soal matematika berikut dengan teliti: "
            f"{question}. Berikan jawaban akhir dengan jelas."
        ),
    }


def make_questions(count):
    """Membuat beberapa soal (kurang dari 10) dengan tingkat kesulitan acak."""
    plan = random.sample(QUESTION_PLAN, k=min(count, len(QUESTION_PLAN)))
    used = set()
    questions = []

    for operation, difficulty in plan:
        question = create_question(operation, difficulty, used)
        if question is None:
            return None
        questions.append(question)

    return questions


@app.get("/api/quiz")
def quiz(type: str = "choice", count: int = 10):
    """
    Membuat soal. Kunci dihitung dan dicek oleh Python.
    type  = "choice" (pilihan ganda) atau "essay" (essai)
    count = jumlah soal, 1 sampai 10
    """
    if type not in ("choice", "essay"):
        return JSONResponse(status_code=400, content={"error": "Jenis soal tidak dikenal."})

    count = max(1, min(count, 10))
    questions = generate_session() if count == 10 else make_questions(count)

    if questions is None:
        return JSONResponse(
            status_code=500,
            content={"error": "Gagal membuat soal."},
        )

    # Soal essai tidak memakai pilihan jawaban.
    if type == "essay":
        for question in questions:
            question.pop("choices", None)

    return {"type": type, "questions": questions}
