## 2026-09-02 - [IDOR in PDF Generation]
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` directly used the `Payroll` model from route binding to generate and return a salary slip PDF without verifying if the authenticated user owned the payroll record, or if the payroll record status was finalized.
**Learning:** Endpoints that generate or return files/PDFs are often overlooked for access control checks compared to standard view endpoints. Route obfuscation (like HashIds) does not replace the need for strict authorization checks.
**Prevention:** Always implement explicit ownership and state checks on endpoints returning direct object references or files, matching the authorization logic used in the corresponding view endpoints.
