## 2024-08-10 - Insecure Direct Object Reference (IDOR) on PDF Endpoint
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` returned a PDF slip without verifying if the authenticated user owned the `Payroll` record or if its status was finalized.
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control, resulting in IDOR vulnerabilities even when routes use model binding.
**Prevention:** Always explicitly check authorization and ownership against the authenticated user on direct object references (like generating a PDF for a specific record ID) and also ensure the state of the entity (like `status`) is finalized.
