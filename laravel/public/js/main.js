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

        const parseCount = (value) => {
            const num = Number.parseInt(String(value ?? "0").replace(/[^0-9]/g, ""), 10);
            return Number.isFinite(num) ? num : 0;
        };

        const initialCount = digitsContainer.dataset.count ?? digitsContainer.textContent ?? 0;
        renderDigits(parseCount(initialCount));
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

  /* ===== 画像ポップアップ ===== */
    const modal = document.getElementById("image-modal");
    if (modal) {
        const backdrop = modal.querySelector(".image-modal__backdrop");
        const closeBtn = modal.querySelector(".image-modal__close");
        const img = modal.querySelector("img");
        const links = document.querySelectorAll("[data-popup-image][data-popup-slug]");

        const hide = () => {
            modal.classList.remove("is-open");
            const url = new URL(window.location.href);
            url.searchParams.delete("popup");
            window.history.replaceState({}, "", url);
        };

        const show = (src) => {
            if (!src || !img) return;
            img.src = src;
            modal.classList.add("is-open");
        };

        const openFromLink = (linkEl) => {
            const image = linkEl.dataset.popupImage;
            const slug = linkEl.dataset.popupSlug;
            if (!image) return;
            show(image);

            if (slug) {
                const url = new URL(window.location.href);
                url.searchParams.set("popup", slug);
                window.history.replaceState({}, "", url);
            }
        };

        links.forEach((link) => {
            link.addEventListener("click", (event) => {
                event.preventDefault();
                openFromLink(link);
            });
        });

        if (modal.dataset.show === "1" && modal.dataset.image) {
            show(modal.dataset.image);
        }

        backdrop?.addEventListener("click", hide);
        closeBtn?.addEventListener("click", hide);
    }

  /* ===== コピーとか画像保存防止 ===== */
    document.addEventListener("contextmenu", (event) => {
        event.preventDefault();
    });
    document.addEventListener("copy", (event) => {
        event.preventDefault();
    });
    document.addEventListener("dragstart", (event) => {
        event.preventDefault();
    });
});
