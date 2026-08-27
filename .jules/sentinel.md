## 2024-06-03 - IDOR in PDF Generation Endpoint
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` returned PDF for any payroll without checking if the payroll belonged to the authenticated user's employee ID, resulting in an Insecure Direct Object Reference (IDOR).
**Learning:** Even if route model binding is used, explicit object ownership and state checks must be applied. Endpoints returning files/PDFs are especially prone to this oversight as developers might focus on view generation rather than access control.
**Prevention:** Always explicitly verify ownership (`$payroll->employee_id === Auth::user()->employee->id`) and finalized state (e.g., `status` in `['approved_finance', 'paid']`) for any endpoints returning direct object references or sensitive files.
