document.addEventListener("DOMContentLoaded", () => {
//  TODO：数字の画像？が必要かも
  /* ===== カウンター ===== */
    const digitsContainer = document.getElementById("counter-digits");
    if (digitsContainer) {
        let count = parseInt(localStorage.getItem("visitCount") || "0", 10);
        count += 1;
        localStorage.setItem("visitCount", String(count));

        const digits = String(count).padStart(3, "0"); // 3桁（001〜）
        digitsContainer.innerHTML = "";

        for (const d of digits) {
        const img = document.createElement("img");
        img.src = `digits/${d}.png`;
        img.alt = d;
        img.className = "counter-digit";
        digitsContainer.appendChild(img);
        }
    }

  /* ===== MIDI ===== */
    const bgm = document.getElementById("bgm");
    const midiToggle = document.getElementById("midi-toggle");

    if (bgm && midiToggle) {
        let playing = false;

        midiToggle.addEventListener("click", async () => {
        try {
            if (!playing) {
            await bgm.play();
            playing = true;
            midiToggle.textContent = "♪ BGM OFF";
            } else {
            bgm.pause();
            playing = false;
            midiToggle.textContent = "♪ BGM ON";
            }
        } catch (error) {
            console.error(error);
        }
        });
    }
});
