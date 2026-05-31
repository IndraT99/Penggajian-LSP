## 2024-05-31 - Missing Authorization on PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint (`generatePDF` in `KaryawanSlipGajiController`). While the `show` method properly checked authorization, the PDF download endpoint did not, allowing any authenticated employee to download payslips of other employees by guessing the payroll ID.
**Learning:** Developers often forget to implement authorization checks on endpoints that return files or PDFs, focusing on view generation rather than access control.
**Prevention:** Always implement explicit ownership and state checks on all endpoints returning direct object references or files, even if the ID is obfuscated.
