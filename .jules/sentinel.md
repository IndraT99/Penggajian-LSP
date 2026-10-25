## 2024-05-24 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `KaryawanSlipGajiController@generatePDF` where any user could download other employees' salary slips by guessing the Payroll ID.
**Learning:** Endpoints that generate or return files/PDFs using direct model binding can easily be overlooked for authorization checks since the focus is often on view generation.
**Prevention:** Always explicitly check ownership (e.g., `employee_id`) and record state (`status`) against the authenticated user on all endpoints, even those that just stream files.
