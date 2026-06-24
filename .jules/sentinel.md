
## 2026-06-24 - IDOR in PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF file generation (`generatePDF` method). A user could manipulate route model binding IDs to access PDFs belonging to other employees or PDFs in unauthorized states.
**Learning:** Endpoints that generate or return files (like PDFs) are frequently overlooked for authorization checks, as developers often assume the state check was done on the page that renders the download button. Route obfuscation (like `HashIdRoute`) does not prevent IDOR.
**Prevention:** Always implement explicit authorization and state checks in controller methods, especially those returning files, downloads, or PDFs, even if they use route model binding and/or route ID obfuscation.
