<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forensic Log Analyzer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Forensic Log Analysis Tool</h1>

        <div class="mb-3">
            <label for="logFile" class="form-label">Upload a Log File:</label>
            <input type="file" id="logFile" class="form-control">
        </div>

        <button class="btn btn-primary" onclick="uploadLog()">Upload & Analyze</button>
        <button class="btn btn-danger" onclick="deleteFiles()">Delete All Logs</button>

        <h2 class="mt-4">🔍 SSH Failed Login Attempts</h2>
        <table class="table table-bordered">
            <thead>
                <tr><th>Timestamp</th><th>User</th><th>IP Address</th></tr>
            </thead>
            <tbody id="failed-logins"></tbody>
        </table>

        <h2>🚨 Potential Brute-Force Attacks</h2>
        <table class="table table-bordered">
            <thead>
                <tr><th>IP Address</th><th>Failed Attempts</th></tr>
            </thead>
            <tbody id="brute-force"></tbody>
        </table>
    </div>

    <script>
        function uploadLog() {
            let fileInput = $("#logFile")[0].files[0];
            if (!fileInput) {
                alert("Please select a log file to upload.");
                return;
            }

            let formData = new FormData();
            formData.append("logFile", fileInput);

            $.ajax({
                url: "upload_log.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    let data = response;

                    $("#failed-logins").html("");
                    $("#brute-force").html("");

                    data.failed_logins.forEach(entry => {
                        $("#failed-logins").append(`
                            <tr>
                                <td>${entry.timestamp}</td>
                                <td>${entry.user}</td>
                                <td>${entry.ip}</td>
                            </tr>
                        `);
                    });

                    for (const [ip, count] of Object.entries(data.brute_force_attempts)) {
                        if (count > 3) {
                            $("#brute-force").append(`
                                <tr>
                                    <td>${ip}</td>
                                    <td>${count}</td>
                                </tr>
                            `);
                        }
                    }

                    alert("Analysis complete. Results updated.");
                },
                error: function(xhr, status, error) {
                    console.error("Upload failed:", error);
                    alert("Error uploading log file.");
                }
            });
        }

        function deleteFiles() {
            if (confirm("Are you sure you want to delete all uploaded log files?")) {
                $.post("delete_logs.php", function(response) {
                    alert(response.message);
                });
            }
        }
    </script>
</body>
</html>
