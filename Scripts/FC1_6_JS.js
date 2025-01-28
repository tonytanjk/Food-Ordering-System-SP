        // Toggle the balance visibility
        function toggleBalance() {
            const balance = document.getElementById("balance");
            const toggleBtn = document.getElementById("toggle-btn");
            if (balance.style.display === "none") {
                balance.style.display = "inline";
                toggleBtn.textContent = "Hide Balance";
            } else {
                balance.style.display = "none";
                toggleBtn.textContent = "Show Balance";
            }
        }
        