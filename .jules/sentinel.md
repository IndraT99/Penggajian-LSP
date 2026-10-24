## 2024-10-24 - IDOR in PDF Generation
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` accepted a `Payroll` object directly via route model binding but failed to verify if the payroll record belonged to the authenticated user, nor did it check if the payroll status was finalized.
**Learning:** Endpoints that generate files or PDFs are often overlooked for authorization checks, leading to Insecure Direct Object Reference (IDOR) vulnerabilities where users can access sensitive documents (like payslips) of other users.
**Prevention:** Always explicitly check ownership and state (e.g., status) against the authenticated user for all endpoints that return direct object references, even if the route uses obfuscated IDs or model binding.
