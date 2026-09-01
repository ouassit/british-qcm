import re
from collections import defaultdict

def parse_quiz(text):
    categories = defaultdict(list)
    current_category = None
    current_question = None
    current_choices = []

    for line in text.strip().splitlines():
        line = line.strip()
        if len(line)==0 :
            print('here')
            continue

        # Detect category
        if line.startswith("Category:"):
            current_category = line.replace("Category:", "").strip()
            continue

        # Detect question line (starts with "*")
        if line.startswith("*"):
            # If there's an unfinished question, save it
            if current_question and current_choices:
                # Extract correct answer
                correct = next((choice[1:].strip() for choice in current_choices if choice.startswith("+")), None)
                # Clean choices (remove +)
                choices = [choice.lstrip("+- ").strip() for choice in current_choices]
                categories[current_category].append({
                    "question": current_question,
                    "choices": choices,
                    "answer": correct,
                    "index": choices.index(correct)
                })
                current_choices = []

            # New question
            current_question = line.lstrip("*").strip()

        # Detect choices (lines with dashes or +)
        elif re.match(r"^[-+]", line):
            current_choices.append(line.strip())

    # Handle last question at end of file
    if current_question and current_choices:
        correct = next((choice[1:].strip() for choice in current_choices if choice.startswith("+")), None)

        choices = [choice.lstrip("+- ").strip() for choice in current_choices]
        categories[current_category].append({
            "question": current_question,
            "choices": choices,
            "answer": correct,
            "index": choices.index(correct)
        })

    return dict(categories)

with open("C:/Users/Lenovo/Desktop/test/adults", "r", encoding="utf-8") as f:
    content = f.read()

quiz_data = parse_quiz(content)

import json

with open('C:/Users/Lenovo/Desktop/test/adults.json', 'w', encoding='utf-8') as f:
    json.dump(quiz_data, f, ensure_ascii=False, indent=2)




