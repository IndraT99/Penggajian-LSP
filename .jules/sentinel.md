## 2026-11-03 - IDOR in PDF Generation Endpoint
**Vulnerability:** IDOR vulnerability in `KaryawanSlipGajiController@generatePDF` allowed generating PDFs for any payroll record.
**Learning:** Endpoints returning files/PDFs are especially prone to IDOR oversight as developers might focus on view generation rather than access control.
**Prevention:** Always explicitly verify that the object's `employee_id` belongs to the authenticated user and its `status` is finalized (e.g., 'approved_finance', 'paid') when directly accepting objects like `Payroll` in endpoints.
