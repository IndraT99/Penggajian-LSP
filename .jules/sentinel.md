## 2024-05-24 - IDOR in Payroll PDF Generation
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` accepts a `Payroll` model directly via route model binding but lacks authorization checks. An attacker could guess or iterate through obfuscated payroll IDs to view PDF slips for other employees' payrolls.
**Learning:** Endpoints returning files (like PDFs) or external resources often get overlooked for authorization checks, as developers focus on the view generation rather than access control.
**Prevention:** Always implement explicit ownership checks for endpoints returning files or direct object references, especially when they access sensitive records like payrolls. Check the authorization and record status matching the entity requesting access.
