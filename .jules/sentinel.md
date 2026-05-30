## 2024-05-30 - Prevent IDOR on PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation. `KaryawanSlipGajiController@generatePDF` accepted a route model bound `Payroll` instance but did not verify if the authenticated employee owned that payroll or if the payroll was in an approved status.
**Learning:** Endpoints that generate files or streams, like PDFs, are particularly prone to missing authorization checks, as developers focus on the document generation instead of checking access to the object.
**Prevention:** Always verify explicit ownership and status checks even on endpoints providing obfuscated IDs, before responding with file content.
