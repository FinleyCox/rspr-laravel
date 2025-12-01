document.addEventListener("DOMContentLoaded", () => {
//  TODO：数字の画像？が必要かも
  /* ===== カウンター ===== */
    const digitsContainer = document.getElementById("counter-digits");
    if (digitsContainer) {
        const renderDigits = (count) => {
            const digits = String(count).padStart(3, "0"); // 3桁（001〜）
            digitsContainer.innerHTML = "";
            for (const d of digits) {
                const img = document.createElement("img");
                img.src = `digits/${d}.svg`;
                img.alt = d;
                img.className = "counter-digit";
                digitsContainer.appendChild(img);
            }
        };

        const bumpLocal = () => {
            let count = parseInt(localStorage.getItem("visitCount") || "0", 10);
            count += 1;
            localStorage.setItem("visitCount", String(count));
            renderDigits(count);
        };

        const bumpGlobal = async () => {
            const namespace = "rspr-home";
            const key = "visits";
            const url = `https://api.countapi.xyz/hit/${namespace}/${key}`;

            try {
                const res = await fetch(url);
                if (!res.ok) throw new Error(`CountAPI status ${res.status}`);
                const data = await res.json();
                if (!data || typeof data.value !== "number") throw new Error("CountAPI invalid payload");
                renderDigits(data.value);
            } catch (error) {
                console.error("Global counter failed, fallback to localStorage", error);
                bumpLocal();
            }
        };

        bumpGlobal();
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
