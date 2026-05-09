## 2024-05-09 - Insecure Direct Object Reference (IDOR) in PDF Download
**Vulnerability:** IDOR vulnerability in `generatePDF` endpoint for Karyawan Slip Gaji.
**Learning:** Endpoints that return direct objects like PDFs must also implement the same authorization and status checks as standard route model binding endpoints. Obfuscated IDs or route model binding are not a substitute for explicit authorization checks.
**Prevention:** Always verify authorization and state explicitly for direct resource endpoints, even when using route model binding or hashed IDs.
