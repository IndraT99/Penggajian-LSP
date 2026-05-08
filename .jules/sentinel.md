## 2026-05-08 - Fix IDOR in PDF Download
**Vulnerability:** The KaryawanSlipGajiController@generatePDF method accepted a Payroll model and generated a PDF without validating if the authenticated user owned the payroll record. This allowed Insecure Direct Object Reference (IDOR), potentially exposing sensitive salary information.
**Learning:** In endpoints that directly stream or download files based on an object ID (like PDFs), authorization checks are often missed if they aren't part of a standard view-rendering flow. The presence of route model binding does not imply authorization.
**Prevention:** Always implement explicit authorization checks (e.g., matching user ID or using policies) and status checks (e.g., verifying the document is finalized) before serving direct object references.
