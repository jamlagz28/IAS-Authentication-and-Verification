function showPuzzle() {
    shufflePuzzle();
    document.getElementById("puzzleModal").style.display = "block";
}

function submitLogin() {
    if (isPuzzleSolved()) {
        document.getElementById("puzzleModal").style.display = "none";
        document.getElementById("login-form").submit();
    } else {
        alert("Puzzle is not solved yet!");
    }
}

function shufflePuzzle() {
    const tiles = Array.from(document.querySelectorAll(".puzzle-tile"));
    const numbers = tiles.map(tile => tile.textContent).filter(n => n !== "");
    numbers.sort(() => Math.random() - 0.5);

    let i = 0;
    tiles.forEach(tile => {
        if (!tile.classList.contains("puzzle-empty")) {
            tile.textContent = numbers[i++];
        }
    });
}

function isPuzzleSolved() {
    const tiles = Array.from(document.querySelectorAll(".puzzle-tile"));
    const order = tiles.map(tile => tile.textContent.trim());
    const correct = ["1", "2", "3", "4", "5", "6", "7", "8", ""];

    return order.every((val, index) => val === correct[index]);
}

// Tile movement logic
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".puzzle-tile").forEach(tile => {
        tile.addEventListener("click", () => {
            const tiles = Array.from(document.querySelectorAll(".puzzle-tile"));
            const index = tiles.indexOf(tile);
            const emptyIndex = tiles.findIndex(t => t.classList.contains("puzzle-empty"));

            const validMoves = [emptyIndex - 1, emptyIndex + 1, emptyIndex - 3, emptyIndex + 3];

            if (validMoves.includes(index)) {
                const emptyTile = tiles[emptyIndex];
                emptyTile.textContent = tile.textContent;
                emptyTile.classList.remove("puzzle-empty");
                tile.textContent = "";
                tile.classList.add("puzzle-empty");
            }
        });
    });
});
