function strength(check) {
    let score = 0;
    if (/[A-Z]/.test(check)) {
        score++;
    }
    if (/[a-z]/.test(check)) {
        score++;
    }
    if (/[\d]/.test(check)) {
        score++;
    }
    if (/[\W]/.test(check)) {
        score++;
    }
    if (check.length >= 8) {
        score++;
    }
    if (check.length >= 14) {
        score++;
    }
    if (!check.toUpperCase().includes('PASS')) {
        score++;
    }
    if (!check.toUpperCase().includes('ADMIN')) {
        score++;
    }
    if (!check.toUpperCase().includes('ROOT')) {
        score++;
    }
    if (!check.toUpperCase().includes('1234')) {
        score++;
    }

    return score;
}