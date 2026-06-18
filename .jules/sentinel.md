
## 2024-10-24 - IDOR in PDF Generation Endpoint
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` lacked authorization checks, allowing any authenticated user to download any other user's payroll slip PDF by guessing the ID.
**Learning:** Endpoints that generate files (like PDFs) or return direct object references are often missed when implementing authorization, as developers focus on the view generation rather than access control.
**Prevention:** Always verify ownership and state (e.g., status is `approved_finance` or `paid`) on endpoints that return files or direct object references, matching the authorization logic used in standard `show` methods.
