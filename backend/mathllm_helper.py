
import torch

from model import MathLLM


class MathLLMHelper:
    def __init__(self, checkpoint_path="checkpoints/mathllm_v3.pt"):
        self.device = torch.device("cpu")

        checkpoint = torch.load(
            checkpoint_path,
            map_location=self.device,
            weights_only=False,
        )

        self.stoi = checkpoint["stoi"]
        self.itos = checkpoint["itos"]

        self.model = MathLLM(
            **checkpoint["config"]
        ).to(self.device)

        self.model.load_state_dict(checkpoint["model_state"])
        self.model.eval()

    def predict(self, question):
        prompt = (
            "### Soal:\n"
            f"{question}\n"
            "### Jawaban:\n"
        )

        missing = [char for char in prompt if char not in self.stoi]
        if missing:
            return f"Karakter tidak dikenal oleh MathLLM: {sorted(set(missing))}"

        idx = torch.tensor(
            [[self.stoi[char] for char in prompt]],
            dtype=torch.long,
            device=self.device,
        )

        with torch.no_grad():
            output = self.model.generate(
                idx,
                max_new_tokens=6,
                temperature=0.1,
            )[0].tolist()

        generated = "".join(self.itos[token] for token in output)
        if generated.startswith(prompt):
            generated = generated[len(prompt):]

        import re
        match = re.search(r"\d+", generated)

        if match is None:
            return f"MathLLM belum menghasilkan angka. Output: {generated!r}"

        return match.group()
