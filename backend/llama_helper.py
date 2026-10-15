
import requests


OLLAMA_URL = "http://localhost:11434/api/generate"
MODEL_NAME = "llama3.2"


def ask_llama(prompt):
    """Mengirim pertanyaan ke Llama dan mengembalikan jawabannya."""
    try:
        response = requests.post(
            OLLAMA_URL,
            json={
                "model": MODEL_NAME,
                "prompt": prompt,
                "stream": False,
            },
            timeout=120,
        )

        response.raise_for_status()
        return response.json()["response"].strip()

    except requests.RequestException as error:
        return f"Gagal menghubungi Ollama: {error}"


if __name__ == "__main__":
    question = input("Masukkan pertanyaan: ")
    answer = ask_llama(question)

    print("\nJawaban Llama:")
    print(answer)
