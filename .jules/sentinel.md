## 2025-02-28 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint `KaryawanSlipGajiController@generatePDF`. Endpoints generating files sometimes miss authorization checks even when using route model binding. An attacker could access other employees' payrolls.
**Learning:** Endpoints that return files (like PDFs) are frequently overlooked for authorization checks, as developers focus on the view generation rather than access control.
**Prevention:** Always explicitly verify ownership (`$payroll->employee_id === $employee->id`) and state (`$payroll->status`) against the authenticated user when a controller method accepts an object directly, especially for file generation or downloads.
