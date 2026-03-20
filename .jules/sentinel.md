## 2025-02-17 - [IDOR in PDF Generation Endpoint]
**Vulnerability:** The `KaryawanSlipGajiController::generatePDF` endpoint did not verify if the requested `Payroll` model belonged to the authenticated employee. This allowed any authenticated user to potentially download and view another employee's salary slip by accessing their payroll ID.
**Learning:** Even if an object is accessed directly via route model binding, you still must check authorization explicitly. Do not assume the user has access just because they are authenticated or can guess the ID.
**Prevention:** Always verify ownership (e.g., `$payroll->employee_id === $employee->id`) or use policies/gates for endpoints that return direct object references, such as PDF downloads or detailed views.
