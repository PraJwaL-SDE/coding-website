const textBoxCode = document.getElementById("textbox-code");

// List of Java suggestions
const javaSuggestions = ["public", "class", "void", "int", "String", "if", "else", "for", "while", "System.out.println"];

// Event listener for keypress event
textBoxCode.addEventListener("keypress", function(event) {
    const cursorPosition = textBoxCode.selectionStart;
    const textBeforeCursor = textBoxCode.value.substring(0, cursorPosition);
    const textAfterCursor = textBoxCode.value.substring(cursorPosition);

    if (event.key === "Enter") {
        event.preventDefault();
        const prevChar = textBeforeCursor.trim().slice(-1);
        const isBracket = ['(', '[', '{', ';'].includes(prevChar);

        if (isBracket) {
            textBoxCode.value = textBeforeCursor + '\n\t\n\t' + textAfterCursor;
            textBoxCode.selectionStart = cursorPosition + 2;
            textBoxCode.selectionEnd = cursorPosition + 2;
        } else {
            textBoxCode.value = textBeforeCursor + '\n' + textAfterCursor;
            textBoxCode.selectionStart = cursorPosition + 1;
            textBoxCode.selectionEnd = cursorPosition + 1;
        }
    }

    if (event.key === "{" || event.key === "(" || event.key === "[" ||
        event.key === "\"" || event.key === "'" || event.key === "`") {
        event.preventDefault();
        const charMappings = {
            '{': '{}',
            '(': '()',
            '[': '[]',
            '"': '""',
            "'": "''",
            '`': '``'
        };
        const charPair = charMappings[event.key];
        textBoxCode.value = textBeforeCursor + charPair + textAfterCursor;
        textBoxCode.selectionStart = cursorPosition + 1;
        textBoxCode.selectionEnd = cursorPosition + 1;
    }
});

// Event listener for keydown event
textBoxCode.addEventListener("keydown", function(event) {
    if (event.key === "Tab") {
        event.preventDefault();
        const cursorPosition = textBoxCode.selectionStart;
        const textBeforeCursor = textBoxCode.value.substring(0, cursorPosition);
        const textAfterCursor = textBoxCode.value.substring(cursorPosition);
        textBoxCode.value = textBeforeCursor + '\t' + textAfterCursor;
        textBoxCode.selectionStart = textBoxCode.selectionEnd = cursorPosition + 1;
    }
});

// Function to display Java suggestions
function displayJavaSuggestions(suggestions) {
    removeJavaSuggestions(); // Remove any existing suggestions

    const suggestionBox = document.createElement("div");
    suggestionBox.classList.add("suggestion-box");

    suggestions.forEach(suggestion => {
        const suggestionItem = document.createElement("div");
        suggestionItem.textContent = suggestion;
        suggestionItem.classList.add("suggestion-item");
        suggestionItem.addEventListener("click", function() {
            textBoxCode.value = textBoxCode.value + suggestion;
            removeJavaSuggestions(); // Remove the suggestion box after selecting a suggestion
        });
        suggestionBox.appendChild(suggestionItem);
    });

    textBoxCode.parentNode.insertBefore(suggestionBox, textBoxCode.nextSibling); // Append suggestion box after the input field
}

// Function to remove Java suggestions
function removeJavaSuggestions() {
    const existingSuggestionBox = document.querySelector(".suggestion-box");
    if (existingSuggestionBox) {
        existingSuggestionBox.parentNode.removeChild(existingSuggestionBox);
    }
}

// Event listener for input event to display suggestions
textBoxCode.addEventListener("input", function(event) {
    const userInput = getLastWord(textBoxCode.value.trim());
    const matchingSuggestions = javaSuggestions.filter(suggestion =>
        suggestion.startsWith(userInput)
    );

    if (userInput.length > 0) {
        displayJavaSuggestions(matchingSuggestions);
    } else {
        removeJavaSuggestions();
    }
});

// Function to get the last word from a string
function getLastWord(str) {
    const words = str.split(/\s+/);
    return words[words.length - 1];
}

// Event listener to close the suggestion box when clicking outside of it
document.addEventListener("click", function(event) {
    if (!textBoxCode.contains(event.target)) {
        removeJavaSuggestions();
    }
});
