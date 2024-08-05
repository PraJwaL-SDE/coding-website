const textBoxCode = document.getElementById("textbox-code");



textBoxCode.addEventListener("keypress", function(event) {

    

    if (event.key === "Enter") {
        const cursorPosition = textBoxCode.selectionStart;
    const textBeforeCursor = textBoxCode.value.substring(0, cursorPosition);
    const textAfterCursor = textBoxCode.value.substring(cursorPosition);

        if (event.key === "Enter") {
            event.preventDefault();

            // Check if the previous character is one of the specified brackets
            const prevChar = textBeforeCursor.trim().slice(-1);
            const isBracket = ['(', '[', '{',';'].includes(prevChar);

            if (isBracket) {
                // Insert newline followed by tab
                textBoxCode.value = textBeforeCursor + '\n\t\n\t' + textAfterCursor;
                textBoxCode.selectionStart = cursorPosition + 2;
                textBoxCode.selectionEnd = cursorPosition + 2;
            } else {
                // Insert only newline
                textBoxCode.value = textBeforeCursor + '\n' + textAfterCursor;
                textBoxCode.selectionStart = cursorPosition + 1;
                textBoxCode.selectionEnd = cursorPosition + 1;
            }
        }
    }
    if (event.key === "{" || event.key === "(" || event.key === "[" || 
        event.key === "\"" || event.key === "'" || event.key === "`") {
        // Prevent the default action of inserting the character
        event.preventDefault();

        // Get the current cursor position
        const cursorPosition = textBoxCode.selectionStart;

        // Define the character pair mappings
        const charMappings = {
            '{': '{}',
            '(': '()',
            '[': '[]',
            // '<': '<>',
            '"': '""',
            "'": "''",
            '`': '``'
        };

        // Get the corresponding character pair for the pressed key
        const charPair = charMappings[event.key];

        // Insert the character pair at the current cursor position
        const textBeforeCursor = textBoxCode.value.substring(0, cursorPosition);
        const textAfterCursor = textBoxCode.value.substring(cursorPosition);
        textBoxCode.value = textBeforeCursor + charPair + textAfterCursor;

        // Move the cursor position after inserting the character pair
        textBoxCode.selectionStart = cursorPosition + 1;
        textBoxCode.selectionEnd = cursorPosition + 1;
    }
});
textBoxCode.addEventListener("keydown", function(event) {
    if (event.key === "Tab") {
      event.preventDefault();
      const cursorPosition = textBoxCode.selectionStart;
      const textBeforeCursor = textBoxCode.value.substring(0, cursorPosition);
      const textAfterCursor = textBoxCode.value.substring(cursorPosition);
      textBoxCode.value = textBeforeCursor + '\t' + textAfterCursor;
  
      // Update cursor position
      textBoxCode.selectionStart = textBoxCode.selectionEnd = cursorPosition + 1;
    }
  });

// function highlightWord(word, color) {
//     const textBoxCode = document.getElementById("textbox-code");
//     const cursorPosition = textBoxCode.selectionStart;
//     const textBeforeCursor = textBoxCode.value.substring(0, cursorPosition);
//     const textAfterCursor = textBoxCode.value.substring(cursorPosition);
//     const highlightedWord = `<span style='color:${color}'>${word}</span>`;
//     textBoxCode.innerHTML = textBeforeCursor.replace(new RegExp(word + "$"), highlightedWord) + textAfterCursor;
//     textBoxCode.setSelectionRange(cursorPosition, cursorPosition);
// }


