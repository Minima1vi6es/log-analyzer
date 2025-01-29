---
title: "🔍 Forensic Log Analyzer"
description: "A web-based tool that allows users to upload system log files, analyze SSH login attempts, and detect brute-force attacks."

features:
  - ✅ Upload & Analyze SSH Logs – Detect failed login attempts & brute-force attacks.
  - ✅ Real-Time Log Processing – Instantly extract security insights.
  - ✅ Delete Uploaded Files – Manually remove logs after analysis.
  - ✅ Auto-Cleanup – Logs are automatically deleted after 30 minutes.

project_structure:
  log-analyzer/:
    - index.php: "Frontend UI (upload & display results)"
    - upload_log.php: "Backend processing of uploaded logs"
    - delete_logs.php: "Deletes uploaded log files"
    - uploads/: "Temporary storage for log files"
    - README.md: "Documentation"

installation:
  steps:
    - Clone the repository:
      command: "git clone https://github.com/Minima1vi6es/log-analyzer.git && cd log-analyzer"
    - Set up permissions:
      commands:
        - "sudo chmod -R 775 uploads/"
        - "sudo chown -R www-data:www-data uploads/"
    - Run the tool:
      instructions:
        - "Open in a browser: 👉 https://your-domain.com/log-analysis/"
        - "Upload a log file (.log or .txt)"
        - "View detected failed logins & brute-force attempts"

sample_logs:
  - name: "Sample Log 1 - Basic Failed Logins"
    url: "uploads/sample_log_1.log"
  - name: "Sample Log 2 - Brute-Force Attack"
    url: "uploads/sample_log_2.log"

future_enhancements:
  - 📊 Graphical Analysis (Charts & Maps)
  - 🌎 GeoIP Lookup for Attackers
  - 📅 Filter Logs by Date Range
  - 📥 Download Reports (CSV/PDF)

contributing:
  steps:
    - Fork the repository on GitHub.
    - Create a feature branch:
      command: "git checkout -b new-feature"
    - Commit changes:
      command: "git commit -m 'Added feature XYZ'"
    - Push to GitHub:
      command: "git push origin new-feature"
    - Open a Pull Request and describe your changes.

license: "This project is licensed under the MIT License."

author:
  name: "Mark Gustafson"
  github: "https://github.com/Minima1vi6es"
---
