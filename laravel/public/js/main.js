document.addEventListener("DOMContentLoaded", () => {
  /* ===== カウンター ===== */
    const digitsContainer = document.getElementById("counter-digits");
    if (digitsContainer) {
        const digitsBase = digitsContainer.dataset.digitsBase || "/digits";
        const digitPad = Number.parseInt(digitsContainer.dataset.pad ?? "5", 10);

        const renderDigits = (count) => {
            const safeCount = Number.isFinite(count) ? count : 0;
            const padLength = Number.isFinite(digitPad) ? digitPad : 5;
            const digits = String(safeCount).padStart(Math.max(padLength, String(safeCount).length), "0");
            digitsContainer.innerHTML = "";
            for (const d of digits) {
                const img = document.createElement("img");
                img.src = `${digitsBase}/${d}.svg`;
                img.alt = d;
                img.className = "counter-digit";
                digitsContainer.appendChild(img);
            }
        };

        const initialCount = Number(digitsContainer.dataset.count ?? digitsContainer.textContent ?? 0);
        renderDigits(Number.isFinite(initialCount) ? initialCount : 0);
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

  /* ===== もっと見る ===== */
    const setupShowMore = (listSelector, limit = 3) => {
        const list = document.querySelector(listSelector);
        if (!list) return;

        const button = document.querySelector(`button.show-more[data-target="${listSelector}"]`);
        const items = Array.from(list.children).filter((child) => child.tagName === "LI");

        if (!button || items.length <= limit) {
            if (button) button.style.display = "none";
            return;
        }

        const hideOverflow = () => {
            items.slice(limit).forEach((li) => li.classList.add("hidden-item"));
            button.textContent = "もっと見る";
            button.setAttribute("aria-expanded", "false");
        };

        const showAll = () => {
            items.forEach((li) => li.classList.remove("hidden-item"));
            button.textContent = "閉じる";
            button.setAttribute("aria-expanded", "true");
        };

        hideOverflow();

        button.addEventListener("click", () => {
            const hasHidden = items.some((li) => li.classList.contains("hidden-item"));
            if (hasHidden) {
                showAll();
            } else {
                hideOverflow();
            }
        });
    };

    setupShowMore("#illust-list");
    setupShowMore("#novel-list");
    setupShowMore("#member-list");
});
