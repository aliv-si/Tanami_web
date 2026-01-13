function checkPasswordStrength(password) {
    let strength = 0;

    // Check length
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;

    // Check for lowercase
    if (/[a-z]/.test(password)) strength++;

    // Check for uppercase
    if (/[A-Z]/.test(password)) strength++;

    // Check for numbers
    if (/[0-9]/.test(password)) strength++;

    // Check for special characters
    if (/[^a-zA-Z0-9]/.test(password)) strength++;

    // Normalize to 0-4 scale
    let level = Math.min(4, Math.floor(strength / 1.5));
    if (password.length === 0) level = 0;

    const bars = ["bar1", "bar2", "bar3", "bar4"];
    const colors = ["#ef4444", "#f97316", "#eab308", "#53be20"]; // red, orange, yellow, green
    const labels = ["Sangat Lemah", "Lemah", "Cukup", "Kuat", "Sangat Kuat"];
    const textColors = [
        "text-red-500",
        "text-orange-500",
        "text-yellow-600",
        "text-green-600",
    ];

    // Reset all bars
    bars.forEach((barId, i) => {
        const bar = document.getElementById(barId);
        if (i < level) {
            bar.style.backgroundColor = colors[level - 1];
        } else {
            bar.style.backgroundColor = "";
            bar.className =
                "h-1 flex-1 bg-gray-200 dark:bg-white/10 rounded-full transition-colors";
        }
    });

    // Update text
    const textEl = document.getElementById("strengthText");
    textEl.textContent =
        "Password strength: " + (password.length > 0 ? labels[level] : "-");
    textEl.className =
        "text-[10px] mt-1 font-sans " +
        (level > 0 ? textColors[level - 1] : "text-gray-500");
}
