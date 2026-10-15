<!-- resources/views/kiosk/entry.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Entry Kiosk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white flex items-center justify-center h-screen">

    <div class="text-center max-w-lg w-full p-8 bg-gray-800 rounded-2xl shadow-2xl border border-gray-700">
        <h1 class="text-3xl font-extrabold mb-2">Library Entrance Kiosk</h1>
        <p class="text-gray-400 mb-6">Tap your ID card on the reader to enter</p>

        <!-- Hidden Input to capture RFID Reader keystrokes -->
        <form id="rfid-form" onsubmit="handleScan(event)" action="javascript:void(0);">
            @csrf
            <input 
                type="text" 
                id="rfid_input" 
                name="rfid_uid" 
                class="opacity-0 absolute top-0 left-0 h-0 w-0" 
                autofocus 
                autocomplete="off"
            >
        </form>

        <!-- Dynamic Feedback Display -->
        <div id="status-card" class="p-6 rounded-xl bg-gray-700 border border-gray-600 transition-all">
            <span class="text-6xl block mb-4">🪪</span>
            <p id="status-message" class="text-xl font-semibold text-gray-200">Waiting for scan...</p>
        </div>
    </div>

    <script>
        const input = document.getElementById('rfid_input');
        const statusMessage = document.getElementById('status-message');
        const statusCard = document.getElementById('status-card');

        // Keep focus on input for RFID reader keystrokes
        document.addEventListener('click', () => input?.focus());
        window.addEventListener('load', () => input?.focus());

        async function handleScan(e) {
            // 1. CRITICAL: Stop the browser from refreshing or changing the URL
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            const input = document.getElementById('rfid_input');
            const uid = input.value.trim();
            input.value = ''; // Reset input immediately

            if (!uid) return false;

            const statusMessage = document.getElementById('status-message');
            const statusCard = document.getElementById('status-card');

            statusMessage.innerText = "Processing scan...";

            try {
                const response = await fetch('{{ route("kiosk.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ rfid_uid: uid })
                });

                const result = await response.json();

                if (response.ok) {
                    if (result.type === 'exit') {
                        // Exit Styling (Blue/Orange)
                        statusCard.className = "p-6 rounded-xl bg-blue-900/50 border border-blue-500 text-blue-200";
                        statusMessage.innerText = result.message;
                    } else {
                        // Entry Styling (Green)
                        statusCard.className = "p-6 rounded-xl bg-green-900/50 border border-green-500 text-green-200";
                        statusMessage.innerText = result.message;

                        if (result?.redirect_url) {
                            setTimeout(() => {
                                window.location.href = result.redirect_url;
                            }, 1200);
                            return;
                        }
                    }
                } else {
                    statusCard.className = "p-6 rounded-xl bg-red-900/50 border border-red-500 text-red-200";
                    statusMessage.innerText = result?.message || `Server Error (${response.status})`;
                }
            } catch (err) {
                console.error("Scan error:", err);
                statusCard.className = "p-6 rounded-xl bg-yellow-900/50 border border-yellow-500 text-yellow-200";
                statusMessage.innerText = "Connection error. Check F12 console.";
            }

            // Reset UI state after 3 seconds if no redirect happened
            setTimeout(() => {
                statusCard.className = "p-6 rounded-xl bg-gray-700 border border-gray-600 text-gray-200";
                statusMessage.innerText = "Waiting for scan...";
                input.focus();
            }, 3000);

            return false;
        }
    </script>
</body>
</html>