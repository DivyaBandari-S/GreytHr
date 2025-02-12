from fastapi import FastAPI
from pydantic import BaseModel
import language_tool_python
from transformers import pipeline

app = FastAPI()
tool = language_tool_python.LanguageTool("en-US")
text_generator = pipeline("text-generation", model="gpt2")  # GPT-2 for suggestions

class TextRequest(BaseModel):
    text: str

@app.post("/grammar-correct")
def grammar_correct(request: TextRequest):
    # Correct grammar line by line
    lines = request.text.split("\n")
    corrected_lines = [language_tool_python.utils.correct(line, tool.check(line)) for line in lines]

    # Generate suggestions based on the last line of input
    last_line = corrected_lines[-1] if corrected_lines else ""
    suggestions = text_generator(last_line, max_length=50, num_return_sequences=3)

    return {
        "corrected_text": "\n".join(corrected_lines),
        "suggestions": [sugg["generated_text"] for sugg in suggestions]
    }
