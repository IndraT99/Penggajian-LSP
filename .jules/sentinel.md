## 2026-10-23 - IDOR in PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation. `KaryawanSlipGajiController@generatePDF` accepted a `Payroll` object directly without checking authorization.
**Learning:** Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control.
**Prevention:** Always explicitly check authorization and ownership against the authenticated user, and ensure the status is finalized, even if an object is accessed directly via route model binding.
