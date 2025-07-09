document.addEventListener("DOMContentLoaded", function () {
    // Cari semua tombol yang berfungsi sebagai pemicu collapse
    const collapseTriggers = document.querySelectorAll(
        '[data-bs-toggle="collapse"]'
    );

    collapseTriggers.forEach((trigger) => {
        trigger.addEventListener("click", function (event) {
            event.preventDefault(); // Mencegah aksi default jika pemicunya adalah link

            // Dapatkan selector target dari atribut data-bs-target
            const targetSelector = this.getAttribute("data-bs-target");
            if (!targetSelector) return;

            const targetElement = document.querySelector(targetSelector);
            if (!targetElement) return;

            // Periksa apakah elemen sedang terbuka atau tertutup
            const isExpanded = this.getAttribute("aria-expanded") === "true";

            if (isExpanded) {
                // Jika sedang terbuka, maka TUTUP
                collapseElement(targetElement);
                this.setAttribute("aria-expanded", "false");
            } else {
                // Jika sedang tertutup, maka BUKA
                expandElement(targetElement);
                this.setAttribute("aria-expanded", "true");
            }
        });
    });

    // Fungsi untuk MEMBUKA elemen (expand)
    function expandElement(element) {
        element.style.display = "block"; // Tampilkan elemen untuk mengukur tingginya
        const elementHeight = element.scrollHeight + "px"; // Dapatkan tinggi konten sebenarnya
        element.style.height = elementHeight;

        // Tunggu transisi selesai, lalu hapus height agar bisa dinamis
        element.addEventListener("transitionend", function handler() {
            element.style.height = null;
            element.removeEventListener("transitionend", handler);
        });

        element.classList.add("is-open"); // Tambahkan kelas penanda
    }

    // Fungsi untuk MENUTUP elemen (collapse)
    function collapseElement(element) {
        // Set tinggi secara eksplisit agar transisi berfungsi
        const elementHeight = element.scrollHeight + "px";
        element.style.height = elementHeight;

        // Paksa browser "melihat" tinggi tersebut sebelum mengubahnya ke 0
        setTimeout(() => {
            element.style.height = "0px";
        }, 1);

        // Sembunyikan elemen setelah transisi selesai
        element.addEventListener("transitionend", function handler() {
            element.style.display = "none";
            element.removeEventListener("transitionend", handler);
        });

        element.classList.remove("is-open"); // Hapus kelas penanda
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Cari tombol "Load More"
    const loadMoreBtn = document.getElementById("load-more-comments");
    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener("click", function () {
        // Ambil nomor halaman dan ID artikel dari atribut data-*
        let page = parseInt(this.dataset.page);
        const articleId = this.dataset.articleId;

        // Tampilkan loading state (opsional)
        this.textContent = "Loading...";
        this.disabled = true;

        // Buat URL untuk meminta data ke server
        const url = `/news/${articleId}/load-comments?page=${page}`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                if (data.html.trim() !== "") {
                    // Jika ada data, tambahkan komentar baru ke dalam daftar
                    const commentsList =
                        document.querySelector(".comments-list");
                    commentsList.insertAdjacentHTML("beforeend", data.html);

                    // Perbarui nomor halaman untuk permintaan berikutnya
                    this.dataset.page = page + 1;
                }

                // Sembunyikan tombol jika tidak ada halaman lagi
                if (!data.hasMorePages) {
                    const loadMoreContainer = document.getElementById(
                        "load-more-container"
                    );
                    if (loadMoreContainer) {
                        loadMoreContainer.style.display = "none";
                    }
                }

                // Kembalikan tombol ke state normal
                this.textContent = "Load More Comments";
                this.disabled = false;
            })
            .catch((error) => {
                console.error("Error loading comments:", error);
                // Kembalikan tombol jika terjadi error
                this.textContent = "Failed to load. Try again.";
                this.disabled = false;
            });
    });
});
