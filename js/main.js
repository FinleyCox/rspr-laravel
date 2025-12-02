document.addEventListener("DOMContentLoaded", () => {
  /* ===== カウンター ===== */
    const digitsContainer = document.getElementById("counter-digits");
    if (digitsContainer) {
        const renderDigits = (count) => {
            const digits = String(count).padStart(5, "0"); 
            digitsContainer.innerHTML = "";
            for (const d of digits) {
                const img = document.createElement("img");
                img.src = `digits/${d}.svg`;
                img.alt = d;
                img.className = "counter-digit";
                digitsContainer.appendChild(img);
            }
        };

        const loadNumber = (key, fallback = 0) =>
            parseInt(localStorage.getItem(key) || String(fallback), 10);
        const saveNumber = (key, value) => localStorage.setItem(key, String(value));

        const namespace = "rspr-home";
        const counterKey = "visits";
        const endpoints = [
            `https://api.countapi.xyz/update/${namespace}/${counterKey}/?amount=`,
            `https://api.countapi.dev/update/${namespace}/${counterKey}/?amount=`,
        ];

        const addPending = (n) => {
            const pending = loadNumber("pendingHits", 0) + n;
            saveNumber("pendingHits", pending);
            return pending;
        };

        const bumpWithSync = async () => {
            // まず「今回の1回」をpendingに加えておく（失敗時も保持される）
            addPending(1);
            const pending = loadNumber("pendingHits", 0);
            const cachedGlobal = loadNumber("lastGlobalCount", 0);

            // エンドポイントを順に試す（adblock/ドメインブロック対策）
            for (const baseUrl of endpoints) {
                try {
                    const res = await fetch(`${baseUrl}${pending}`, { cache: "no-store" });
                    if (!res.ok) throw new Error(`CountAPI status ${res.status}`);
                    const data = await res.json();
                    if (!data || typeof data.value !== "number") throw new Error("CountAPI invalid payload");

                    saveNumber("pendingHits", 0);
                    saveNumber("lastGlobalCount", data.value);
                    renderDigits(data.value);
                    return;
                } catch (error) {
                    console.error(`Global counter failed at ${baseUrl}`, error);
                }
            }

            // 全て失敗: キャッシュ＋pendingで暫定表示
            const fallbackCount = cachedGlobal + pending;
            renderDigits(fallbackCount);
        };

        bumpWithSync();
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
